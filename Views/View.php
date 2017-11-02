<?php
namespace ZF_Features\Views;

abstract class View {

	/**
	 * View identifier or name.
	 *
	 * @var string
	 */
	public $slug;

	/**
	 * View data.
	 *
	 * @var array
	 */
	public $data = [];


	function __construct( string $slug ) {
		$this->slug = $slug;
	}

	/**
	 * Gets the view data.
	 */
	abstract protected function get_data( $query );

	/**
	 * Verifies if the view should be loaded.
	 */
	abstract protected function load_condition( $query );


	/**
	 * Returns the view data if the view it's loaded.
	 *
	 * @param WP_Query $query Query object.
	 * @return array|bool View data if the view is loaded, false otherwise.
	 */
	public function attach( $query ) {

		if ( $this->load_condition( $query ) ) {
			return $this->get_data( $query );
		}

		return false;
	}

}
