<?php
namespace ZF_Features\Post_Types;

class Thing extends Post_Type {

	/**
	 * Registers the thing post type.
	 *
	 * @return Thing|WP_Error Registered post type or error in case
	 *                            of failure.
	 */
	public function register() {

		// Modify all the i18ized strings here.
		$generated_labels = [
			'menu_name'          => __( 'Thing', 'zf-features' ),
			'name'               => _x( 'Things', 'post type general name', 'zf-features' ),
			'singular_name'      => _x( 'Thing', 'post type singular name', 'zf-features' ),
			'name_admin_bar'     => _x( 'Thing', 'add new on admin bar', 'zf-features' ),
			'add_new'            => _x( 'Add New', 'thing', 'zf-features' ),
			'add_new_item'       => __( 'Add New Thing', 'zf-features' ),
			'new_item'           => __( 'New Thing', 'zf-features' ),
			'edit_item'          => __( 'Edit Thing', 'zf-features' ),
			'view_item'          => __( 'View Thing', 'zf-features' ),
			'all_items'          => __( 'All Things', 'zf-features' ),
			'search_items'       => __( 'Search Things', 'zf-features' ),
			'parent_item_colon'  => __( 'Parent Things:', 'zf-features' ),
			'not_found'          => __( 'No things found.', 'zf-features' ),
			'not_found_in_trash' => __( 'No things found in Trash.', 'zf-features' ),
		];

		// Definition of the post type arguments. For full list see:
		// http://codex.wordpress.org/Function_Reference/register_post_type
		$args = [
			'labels'       => $generated_labels,
			'description'  => '',
			'rewrite'      => [
				'slug' => 'thing',
			],
			'supports'     => [ 'title', 'editor', 'thumbnail' ],
			'taxonomies'   => [],
			'show_in_menu' => true,
			'public'       => true,
			'exclude_from_search' => false,
		];

		$post_type = $this->register_wp_post_type( $this->slug, $args );

		$this->post_type = $post_type;

		return $this;
	}

	/**
	 * Sets data to be added to js scripts.
	 *
	 * @todo Move most of this code to the parent class.
	 *
	 * @param  array    $posts List of posts from the WP_Query.
	 * @param  WP_Query $query Query.
	 * @return array Modified posts.
	 */
	public function set_localized_data( $posts, $query ) {
		// Add the building coordinates data that is required to display the map.
		if ( $query->is_main_query() && $query->is_single() && ( $query->get( 'post_type' ) === $this->slug ) ) {
			$localized_data = (array) $query->get( 'zf_localized_data' );
			$localized_data['test_elements'] = [
				'H'  => 'Hydrogen',
				'HE' => 'Helium',
				'O'  => 'Oxygen',
				'C'  => 'Carbon',
				'Ne' => 'Neon',
				'Fe' => 'Iron',
			];
			$query->set( 'zf_localized_data', $localized_data );
		}

		return $posts;
	}

}
