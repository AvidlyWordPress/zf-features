<?php
namespace ZF_Features\Mail_Templates;

abstract class Mail_Template {

	/**
	 * Loads the template emails.
	 *
	 * @return string Mail template.
	 */
	abstract protected function load_template();

	/**
	 * Send email.
	 *
	 * @param  string|array $to                 List of addresses the email
	 *                                          should be sent to.
	 * @param  array        $template_variables Template variables.
	 * @param  array        $extra_params       Extra parameters.
	 */
	public function send( $to, $template_variables = [], $extra_params = [] ) {
		if ( ! is_email( $to ) ) {
			return false;
		}

		$template = $this->set_template_variables( $this->load_template(), $template_variables );

		$params            = $extra_params;
		$params['to']      = $to;
		$params['subject'] = $template['subject'];
		$params['message'] = $template['message'];

		$this->send_mail( $params );
	}

	/**
	 * Replaces the template variables in the template content.
	 *
	 * @param array  $template {
	 *     Template content
	 *
	 *     @type string $subject Subject.
	 *     @type string $message Message.
	 * }
	 * @param array $variables Template variable.
	 * @return array Mail content (template with replaced variables).
	 */
	protected function set_template_variables( $template, $variables ) {
		foreach ( $variables as $key => $value ) {
			$template['subject'] = str_replace( '{{' . $key . '}}', $value, $template['subject'] );
			$template['message'] = str_replace( '{{' . $key . '}}', $value, $template['message'] );
		}

		return $template;
	}

	/**
	 * Sends the email.
	 *
	 * @param array $args {
	 *     Mail arguments.
	 *
	 *     @type array|string $to          Array or comma-separated list of
	 *                                     email addresses to send message.
	 *     @type string       $subject     Email subject.
	 *     @type string       $message     Message contents.
	 *     @type array|string $headers     Additional headers.
	 *     @type array|string $attachments Files to attach.
	 * }
	 * @return bool True if the email contents were sent successfully,
	 *              false otherwise.
	 */
	protected function send_mail( $args ) {
		$required_args = [ 'to', 'subject', 'message' ];

		if ( ! array_key_exists( 'headers', $args ) ) {
			$args['headers'] = [];
		}

		if ( ! array_key_exists( 'attachments', $args ) ) {
			$args['attachments'] = [];
		}

		// Check if all the required arguments are defined.
		if ( count( array_intersect( $required_args, array_keys( $args ) ) ) !== count( $required_args ) ) {
			return \WP_Error(
				'missing-email-args',
				__( 'There are missing email arguments.', 'zf-project-features' ),
				[
					'required' => $required_args,
					'provided' => array_keys( $args ),
				]
			);
		}

		wp_mail( $args['to'], $args['subject'], $args['message'], $args['headers'], $args['attachments'] );
	}

}
