<?php
namespace ZF_Features\Ajax;

class Random extends Ajax {

	/**
	 * Ajax action.
	 *
	 * @var string
	 */
	protected $action = 'zf-random-number';

	/**
	 * Action argument used by the nonce validating the AJAX request.
	 *
	 * @var string
	 */
	protected $nonce = 'zf-random-number-ajax';

	/**
	 * Access condition for the ajax request, can be either 'public' (all
	 * users) or 'private' (only authenticated users).
	 *
	 * @var string
	 */
	protected $access = 'public';

	/**
	 * Sets the required objects.
	 */
	function __construct() {
	}

	/**
	 * Handles the Ajax request.
	 */
	public function handle() {
		// Verifies the AJAX request.
		check_ajax_referer( $this->action, $_POST );
		$unsafe_params = $_POST;

		$params = [];
		$params['min'] = array_key_exists( 'min', $unsafe_params ) ? (int) $unsafe_params['min'] : '';
		$params['max'] = array_key_exists( 'max', $unsafe_params ) ? (int) $unsafe_params['max'] : '';

		$validation_result = $this->validate_data( $params );

		if ( is_wp_error( $validation_result ) ) {
			$this->send_error( $validation_result );
		}

		$random_value = rand( $params['min'] , $params['max'] );

		wp_send_json( $random_value );
	}

	/**
	 * Validates the search data.
	 * @param  array $data Search data.
	 * @return bool|WP_Error WP_Error is the data is not valid, true otherwise.
	 */
	protected function validate_data( $data ) {
		// Validate key (empty).
		if ( ! $data['min'] || ! $data['max'] ) {
			return new \WP_Error( 'empty-params', _x( 'Min and max parameters are required.', 'contact-search', 'zf-features' ) );
		}

		return true;
	}
}




