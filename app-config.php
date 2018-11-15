<?php
return [
	// Application prefixes.
	'prefixes' => [
		'slug' => 'zf',
		'name' => 'ZF',
	],
	// Custom post types.
	'post_types' => [
		'thing'  => 'Thing',
	],
	// Custom taxonomies.
	'taxonomies' => [
		'colour' => [
			'name'       => 'Colour',
			'post_types' => [ 'thing', 'page' ],
		],
	],
	// Custom meta boxes.
	'cmb' => [
		'location' => [
			'name'         => 'Location',
			'object_types' => [ 'thing' ], // an array of post types, or 'term', 'comment', 'user', 'options-page'
			// 'taxonomies' => [ 'taxonomy_name' ] // if object_type is 'term', specify taxonomies
		]
	],
	// ACF field groups.
	'acf' => [
		'person' => [
			'name' 	 	=> 'Person',
			'location'	=> [
				[
					[
						'param' => 'post_type',
						'operator' => '==',
						'value' => 'post',
					],
				],
			],
		],
	],
	// Views.
	'views' => [
		'front' => 'Front',
	],
	'ajax' => [
		'random'  => 'Random',
	],
];
