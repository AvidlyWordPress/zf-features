<?php
namespace ZF_Features\Custom_Meta;

class Location extends Custom_Meta_Box {

	/**
	 * Creates the Location metabox.
	 *
	 * @param array $post_types Post types in which the Location metabox should
	 *                          be displayed.
	 * @return Location Metabox object.
	 */
	public function create( array $post_types = array() ) {

		// Initiate the metabox.
		$this->metabox = new \CMB2( array(
			'id'           => $this->id,
			'title'        => __( 'Location', 'zf-features' ),
			'object_types' => [],
			'context'      => 'normal',
			'priority'     => 'high',
			'show_names'   => true, // Show field names on the left
		) );

		// Latitude.
		$this->metabox->add_field( array(
			'name'       => __( 'Latitude', 'zf-features' ),
			'id'         => $this->field_prefix . 'lat',
			'type'       => 'text',
		) );

		// Longitude.
		$this->metabox->add_field( array(
			'name'       => __( 'Longitude', 'zf-project-features' ),
			'id'         => $this->field_prefix . 'lng',
			'type'       => 'text',
		) );

		$this->set_object_types( $this->metabox, $post_types );

		return $this;
	}
}
