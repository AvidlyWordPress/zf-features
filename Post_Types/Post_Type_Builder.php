<?php
namespace ZF_Features\Post_Types;

class Post_Type_Builder {

	/**
	 * Builds a new custom post type object.
	 *
	 * @param  string $slug Post type slug (max. 20 characters, cannot
	 *                      contain capital letters or spaces).
	 * @param  string $name Post type name.
	 * @return object       The Post type object that was built.
	 */
	public function build( $slug, $name ) {

		$classname = __NAMESPACE__ . "\\" . $name;

		if ( ! class_exists( $classname ) ) {
			return new \WP_Error( 'invalid-post-type', __( 'The post type you attempting to create does not have a class to instance. Possible problems: your configuration does not match the class file name; the class file name does not exist.', 'zf-features' ), $classname );
		}

		return new $classname( $slug );
	}

}
