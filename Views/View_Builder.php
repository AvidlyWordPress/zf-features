<?php
namespace ZF_Features\Views;

class View_Builder {

	/**
	 * Builds a new view.
	 *
	 * @param  string $slug View slug.
	 * @param  string $name View name.
	 * @return object View object.
	 */
	public function build( $slug, $name ) {
		$classname = __NAMESPACE__ . "\\" . $name;

		if ( ! class_exists( $classname ) ) {
			return new \WP_Error( 'invalid-custom-meta', __( 'The view you attempting to create does not have a class to instance. Possible problems: your configuration does not match the class file name; the class file name does not exist.', 'zf-features' ), $classname );
		}
		return new $classname( $slug );
	}

}
