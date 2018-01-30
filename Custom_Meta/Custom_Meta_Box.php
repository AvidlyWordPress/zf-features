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

	/**
	 * Object types.
	 * 
	 * @var array
	 */
	protected $object_types = [];

	/**
	 * Taxonomies.
	 * 
	 * @var array
	 */
	protected $taxonomies = [];

	function __construct( string $id, string $field_prefix = '', array $object_types = [], array $taxonomies = [] ) {
		$this->id = $id;
		$this->field_prefix = ( $field_prefix ) ? $field_prefix . '-' : '';
		$this->object_types = $this->get_prefixed_object_types( $object_types );
		$this->taxonomies = $taxonomies;
	}

	/**
	 * Creates a custom metabox.
	 *
	 * @param array $object_types Post types or object types (term, user, comment, options-page) in which the custom metabox should
	 *                          be displayed.
	 * @param array $taxonomies Taxonomies in which the metabox should be displayed, if object type is 'term'
	 * @return Object Custom metabox object.
	 */
	abstract protected function create();

	/**
	 * Adds the custom metabox to set of post types, terms, user or options-page.
	 *
	 * @param  array  $object_types Name of the object type for the custom meta
	 *                              box. Object-types can be built-in Post Type
	 *                              or any Custom Post Type that may be registered.
	 */
	protected function get_prefixed_object_types( array $object_types ) {

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

		return $object_types_slugs;
	}

}
