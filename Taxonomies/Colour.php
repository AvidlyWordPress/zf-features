<?php
namespace ZF_Features\Taxonomies;

class Colour extends Taxonomy {

	/**
	 * Registers the colour taxonomy.
	 *
	 * @param array $post_types Optional. Post types in which the taxonomy
	 *                          should be registered.
	 * @return WP_Post_Type|WP_Error Registered post type or error in case
	 *                               of failure.
	 */
	public function register( array $post_types = [] ) {
		// Taxonomy labels.
		$labels = [
			'name'                  => _x( 'Colours', 'Taxonomy plural name', 'zf-features' ),
			'singular_name'         => _x( 'Colour', 'Taxonomy singular name', 'zf-features' ),
			'search_items'          => __( 'Search Colours', 'zf-features' ),
			'popular_items'         => __( 'Popular Colours', 'zf-features' ),
			'all_items'             => __( 'All Colours', 'zf-features' ),
			'parent_item'           => __( 'Parent Colour', 'zf-features' ),
			'parent_item_colon'     => __( 'Parent Colour', 'zf-features' ),
			'edit_item'             => __( 'Edit Colour', 'zf-features' ),
			'update_item'           => __( 'Update Colour', 'zf-features' ),
			'add_new_item'          => __( 'Add New Colour', 'zf-features' ),
			'new_item_name'         => __( 'New Colour', 'zf-features' ),
			'add_or_remove_items'   => __( 'Add or remove Colours', 'zf-features' ),
			'choose_from_most_used' => __( 'Choose from most used text-domain', 'zf-features' ),
			'menu_name'             => __( 'Colour', 'zf-features' ),
		];

		$args = [
			'labels'            => $labels,
			'public'            => true,
			'show_in_nav_menus' => true,
			'show_admin_column' => true,
			'hierarchical'      => false,
			'show_tagcloud'     => true,
			'show_ui'           => true,
			'query_var'         => true,
			'rewrite'           => [
				'slug' => 'colour',
			],
			'query_var'         => true,
		];

		return $this->register_wp_taxonomy( $this->slug, $post_types, $args );
	}

}
