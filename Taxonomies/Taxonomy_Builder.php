<?php
namespace ZF_Features\Taxonomies;

class Taxonomy_Builder {

	/**
	 * Builds a new taxonomy object.
	 *
	 * @param  string $slug Taxonomy slug. Should only contain lowercase
	 *                      letters and the underscore character, and not be more than 32 characters long (database structure restriction).
	 * @param  string $name Taxonomy name.
	 * @return object       The Taxonomy object that was built.
	 */
	public function build( $slug, $name ) {

		$classname = __NAMESPACE__ . "\\" . $name;

		if ( ! class_exists( $classname ) ) {
			return new \WP_Error( 'invalid-taxonomy', __( 'The taxonomy you attempting to create does not have a class to instance. Possible problems: your configuration does not match the class file name; the class file name does not exist.', 'zf-features' ), $classname );
		}

		return new $classname( $slug );

	}

}
