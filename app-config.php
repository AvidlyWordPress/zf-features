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
			'name'       => 'Location',
			'post_types' => [ 'thing' ],
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
