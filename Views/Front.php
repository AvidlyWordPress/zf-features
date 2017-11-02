<?php
namespace ZF_Features\Views;

class Front extends View {

	/**
	 * Gets the view data.
	 *
	 * @return array The view data.
	 */
	protected function get_data( $query ) {
		// Get all the posts.
		$data_query = new \WP_Query( [
			'post_type'   => 'post',
			'post_status' => 'any',
			'paging'      => 'nopaging',
		] );

		return $data_query->posts;
	}

	/**
	 * Checks if the view should be loaded or not.
	 *
	 * @param WP_Query $query Query object.
	 * @return bool True if the view should be loaded, false otherwise.
	 */
	protected function load_condition( $query ) {
		return $query->is_front_page();
	}
}
