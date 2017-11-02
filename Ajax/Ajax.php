<?php
namespace ZF_Features\Ajax;

class Ajax {

	/**
	 * Registers the AJAX handler functions.
	 *
	 * @param string $action Ajax action name.
	 * @param string $access Access condition for the ajax request, can be
	 *                       either 'public' (all users) or 'private' (only
	 *                       authenticated users).
	 */
	public function register() {
		// Set the ajax hook for authenticated users.
		add_action( 'wp_ajax_' . $this->action, array( $this, 'handle' ) );

		// Set ajax hook for non-authenticated users.
		if ( 'public' === $this->access ) {
			add_action( 'wp_ajax_nopriv_' . $this->action, array( $this, 'handle' ) );
		}
	}

	/**
	 * Sends a JSON response with the error details.
	 *
	 * @param WP_Error $error Error information.
	 */
	protected function send_error( \WP_Error $error ) {
		wp_send_json_error( array(
			'code'    => $error->get_error_code(),
			'message' => $error->get_error_message(),
		) );
	}
}
