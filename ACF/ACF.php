<?php
namespace ZF_Features\ACF;

abstract class ACF {

	/* Group settings */

	public $settings = [];

	/* Group fields */

	protected $location = [];

	/* Slug prefix */

	protected $prefix = '';

	/* Fields */

	protected $fields = [];

	/* Group name */

	protected $name = '';

	/**
	 * Build the field group.
	 *
	 * @return Array ACF fields
	 */

	abstract protected function fields();

	function __construct( string $id, string $title, array $location, string $prefix ) {			
		$this->settings['key'] 		= 'group_' . $prefix . '_' . $id;
		$this->settings['title']	= $title;
		$this->settings['name'] 	= $prefix . '_' . $id;
		$this->settings['location'] = $location;
		$this->settings['fields']	= $this->parse_fields( $this->fields(), $prefix, $id );
	}

	/**
	 * Parse fields to set the keys and prefix slugs
	 *
	 * @return Array Parsed ACF fields
	 */

	private function parse_fields( array $fields, string $prefix, string $id ) {
		$parsed_fields = [];
		foreach ( $fields as $field ) {
			if ( ! isset( $field['key'] ) ) {
				$field['key'] = 'field_' . $prefix . '_' . $id . '-' . $field['name'];
			}
			$field['name'] = $prefix . '_' . $id . '-' . $field['name'];
			$parsed_fields[] = $field;
		}
		return $parsed_fields;
	}

	/**
	 * Get a field from this ACF group
	 * This might be a totally stupid idea?
	 *
	 * @return Mixed Field contents
	 */
	public function get( string $fieldname ) {
		if ( ! function_exists( 'get_field' ) ) {
			return false; // Throw error?
		}
		$slug = $this->$prefix . '_' . $this->$name . '-' . $fieldname;
		return \get_field( $slug );
	}
}
