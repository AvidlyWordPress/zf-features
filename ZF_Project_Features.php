<?php
namespace ZF_Features;

use ZF_Features\Post_Types;
use ZF_Features\Taxonomies;
use ZF_Features\Custom_Meta;
use ZF_Features\Ajax;

class ZF_Project_Features {

	/**
	 * Slug prefix used for the plugin objects.
	 *
	 * @var string
	 */
	protected $slug_prefix = 'zf';

	/**
	 * Name prefix used for the plugin objects.
	 *
	 * @var string
	 */
	protected $name_prefix = 'ZF';

	/**
	 * Post types.
	 *
	 * [slug] => [post type object]
	 *
	 * @var array
	 */
	public $post_types = [];

	/**
	 * Taxonomies.
	 *
	 * [slug] => [name], [post_types]
	 *
	 * @var array
	 */
	public $taxonomies = [];

	/**
	 * Views.
	 *
	 * [slug] => [view object]
	 *
	 * @var array
	 */
	public $views = [];

	/**
	 * Ajax handlers.
	 *
	 * [slug] => [ajax handler object]
	 *
	 * @var array
	 */
	public $ajax_handlers = [];


	/**
	 * User config.
	 *
	 * @var array
	 */
	public $config = null;

	/**
	 * List of plugin errors.
	 *
	 * @var array
	 */
	public $errors = [];

	/**
	 *
	 */
	function __construct( $config ) {
		$this->config = $config;

		$prefixes = (array) $config->property( 'prefixes' );

		// Set name and slug prefixes.
		if ( array_key_exists( 'slug', $prefixes ) ) {
			$this->slug_prefix = $prefixes['slug'];
		}

		if ( array_key_exists( 'name', $prefixes ) ) {
			$this->name_prefix = $prefixes['name'];
		}
	}

	/**
	 * Executes the plugin activation tasks.
	 */
	public function activation() {
		// Custom post types and custom taxonomies need to be registered
		// before flushing rewrites.
		$this->register_post_types();
		$this->register_taxonomies();

		// Ensures the rewrite rules are updated to reflect our custom post types
		// and custom taxonomies.
		flush_rewrite_rules();
	}

	/**
	 * Registers the custom post types.
	 */
	public function register_post_types() {
		$zf_post_type_builder = new Post_Types\Post_Type_Builder();

		foreach ( (array) $this->config->property( 'post_types' ) as $slug => $name ) {
			$prefixed_slug = $this->slug_prefix . '_' . $slug;
			$post_type = $zf_post_type_builder->build( $prefixed_slug, $name );

			if ( is_wp_error( $post_type ) ) {
				$this->errors[] = $post_type;
				continue;
			}

			 $this->post_types[ $slug ] = $post_type->register();
		}
	}

	/**
	 * Registers the custom taxonomies.
	 */
	function register_taxonomies() {
		$zf_taxonomy_builder = new Taxonomies\Taxonomy_Builder();

		foreach ( (array) $this->config->property('taxonomies') as $slug => $params ) {
			$prefixed_slug = $this->slug_prefix . '_' . $slug;

			// Get the post type definitions based on the config data.
			$post_types = array_map( function( $item ) {
				if ( ! post_type_exists( $this->slug_prefix . '_' . $item ) && ! post_type_exists( $item ) ) {
					return false;
				}
				return ( array_key_exists( $item, $this->post_types ) ) ? $this->post_types[ $item ] : $item;
			}, $params['post_types'] );

			$this->taxonomies[ $slug ]['post_types'] = $zf_taxonomy_builder->build( $prefixed_slug, $params['name'] )->register( $post_types );
		}
	}

	/**
	 * Register views.
	 */
	function register_views() {
		$zf_view_builder = new Views\View_Builder();

		foreach ( (array) $this->config->property( 'views' ) as $slug => $name ) {
			$prefixed_slug = $this->slug_prefix . '_' . $slug;
			$this->views[ $slug ] = $zf_view_builder->build( $prefixed_slug, $name );
		}
	}

	/**
	 * Register Ajax handlers.
	 */
	function register_ajax_handlers() {
		$zf_ajax_builder = new Ajax\Ajax_Builder();

		foreach ( (array) $this->config->property( 'ajax' ) as $slug => $name ) {
			$this->ajax_handlers[ $slug ] = $zf_ajax_builder->build( $name, $this );
			$this->ajax_handlers[ $slug ]->register();
		}
	}

	/**
	 * Defines the custom meta boxes.
	 *
	 * Assumes CMB2 plugin.
	 *
	 * @see https://wordpress.org/plugins/cmb2/ CMB2 WordPress Plugin page.
	 * @see  https://github.com/CMB2/CMB2 CMB2 Github repository.
	 */
	public function register_meta_boxes() {
		$zf_cmb_builder = new Custom_Meta\Custom_Meta_Box_Builder();

		foreach ( (array) $this->config->property( 'cmb' ) as $id => $params ) {
			// Metabox prefix id.
			$prefixed_id = $this->slug_prefix . '-' . $id;

			// Get the post type definitions based on the config data.
			$post_types = array_filter(
				array_map( function( $item ) {
					if ( ! post_type_exists( $this->slug_prefix . '_' . $item ) && ! post_type_exists( $item ) ) {
						return false;
					}
					return ( array_key_exists( $item, $this->post_types ) ) ? $this->post_types[ $item ] : $item;
				}, $params['post_types'] )
			);

			// By default the custom meta fields are not displayed in the
			// default custom meta field admin UI. To be displayed the option
			// 'show_in_admin' needs to be set to true in the config.
			$field_prefix = '_' . $this->slug_prefix;

			if ( array_key_exists( 'show_in_admin', $params ) && $params['show_in_admin'] ) {
				$field_prefix = $this->slug_prefix;
			}

			$metabox = $zf_cmb_builder->build( $prefixed_id, $params['name'], $field_prefix );

			if ( is_wp_error( $metabox ) ) {
				$this->errors[] = $metabox;
				continue;
			}

			$this->cmb[ $id ]['post_types'] = $metabox->create( $post_types );
		}
	}

	/**
	 * Extends the WP_Query object with features plugin data.
	 *
	 * Adds the following properties to the WP_Query object:
	 * - view: view data.
	 *
	 * @param WP_Query $query WordPress query object, passed by reference.
	 */
	public function set_view_data( $query ) {
		// Only set the view data in the main query.
		if ( ! $query->is_main_query() ) {
			return;
		}

		$property_name = $this->slug_prefix . '_' . 'features';

		$view_data = null;

		// Only the first view that returns data is set in the query.
		foreach ( (array) $this->views as $slug => $view ) {
			$view_data = $view->attach( $query );
		}
		$query->set( $property_name, $view_data );
	}

	/**
	 * Changes the main query to include the pre_get_posts hooks to change the main query.
	 *
	 * @param array    $posts List of posts from the WP_Query.
	 * @param WP_Query $query WP_Query.
	 * @return array Modified posts.
	 */
	function localize_script_data_handler( $posts, $query ) {

		if ( ! $query->is_main_query() ) {
			return $posts;
		}

		foreach ( $this->post_types as $post_type ) {
			if ( ! method_exists( $post_type, 'set_localized_data' ) ) {
				continue;
			}
			$post_type->set_localized_data( $posts, $query );
		}

		return $posts;
	}

}
