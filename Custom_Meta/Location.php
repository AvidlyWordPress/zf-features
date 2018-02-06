<?php
/**
 * An example metabox.
 */
namespace ZF_Features\Custom_Meta;

class Location extends Custom_Meta_Box {

	/**
	 * Creates the Location metabox.
	 *
	 * @return Location Metabox object.
	 */
	public function create() {

		// Initiate the metabox.
		$this->metabox = new \CMB2( array(
			'id'           => $this->id, // set via app-config.php
			'title'        => __( 'Location', 'zf-features' ),
			'object_types' => $this->object_types, // set via app-config.php
			'taxonomies'   => $this->taxonomies, // set via app-config.php
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

		return $this;
	}
}
