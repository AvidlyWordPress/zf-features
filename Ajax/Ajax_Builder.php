<?php

namespace ZF_Features\Ajax;

class Ajax_Builder {

	/**
	 * Builds a new Ajax handler.
	 *
	 * @param  string               $name            Ajax handler name.
	 * @param  ZF_Project_Features  $features_object Constructor parameters.
	 * @return object Ajax handler object.
	 */
	public function build( $name, \ZF_Features\ZF_Project_Features $features_object ) {
		$classname = __NAMESPACE__ . "\\" . $name;

		if ( ! class_exists( $classname ) ) {
			return new \WP_Error( 'invalid-ajax-handler', __( 'The ajax handler you are creating does not have a class to instance. Possible problems: your configuration does not match the class file name; the class file name does not exist.', 'zf-features' ), $classname );
		}

		return new $classname( $features_object );
	}
}
