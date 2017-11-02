<?php
namespace ZF_Features\Custom_Meta;

abstract class Custom_Meta_Box {

	/**
	 *  Metabox identifier.
	 *
	 * @var string
	 */
	protected $id;

	/**
	 *  Metabox field prefix.
	 *
	 * @var string
	 */
	protected $field_prefix = '';

	/**
	 * Metabox object.
	 *
	 * @var CMB2
	 */
	protected $metabox = null;


	function __construct( string $id, string $field_prefix = '' ) {
		$this->id = $id;
		$this->field_prefix = ( $field_prefix ) ? $field_prefix . '-' : '';
	}

	/**
	 * Creates a custom metabox.
	 *
	 * @param array $post_types Post types in which the custom metabox should
	 *                          be displayed.
	 * @return Object Custom metabox object.
	 */
	abstract protected function create( array $post_types );

	/**
	 * Adds the custom metabox to set of post types.
	 *
	 * @param  Object $metabox      Metabox object.
	 * @param  array  $object_types Name of the object type for the custom meta
	 *                              box. Object-types can be built-in Post Type
	 *                              or any Custom Post Type that may be registered.
	 */
	protected function set_object_types( $metabox, array $object_types ) {

		// Convert the object types to strings because it can be a list of
		// strings or a list of post type objects.
		$object_types_slugs = array_map( function( $object_type ) {
			if ( is_string( $object_type ) ) {
				return $object_type;
			}
			if ( is_object( $object_type ) ) {
				return $object_type->slug;
			}
		}, $object_types );

		$metabox->set_prop( 'object_types', $object_types_slugs );
	}

}
