<?php
namespace ZF_Features\ACF;

/* Example ACF field group */

class Person extends ACF {
	public function fields() {
		$this->fields = [
			array(
				// Do not set the key here (will be overwritten)
				//'key' => 'field_5be42b732f55a',
				'label' => 'Event date',
				'name' => 'date', // Don't prefix the names, it will be done automatically like 'prefix_group-slug'
				'type' => 'date_time_picker',
				'instructions' => '',
				'required' => 1,
				'conditional_logic' => 0,
				'wrapper' => array(
					'width' => '',
					'class' => '',
					'id' => '',
				),
				'display_format' => 'd.m.Y H:i:s',
				'return_format' => 'd/m/Y g:i a',
				'first_day' => 1,
			),
		];
		return $this->fields;
	}
}