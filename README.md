ZF Project Features
=================

Features starter plugin for use in client projects. Use as a regular plugin or drop in mu-plugins with a separate loader file.

## Configuration

- Change the plugin directory name `zf-features` to match your project.
- Change the textdomain `'zf-features'` to match the plugin directory name. You can do a find-replace in the whole plugin for `'zf-features'`.
- If you want to, you can change the namespace (as in `namespace ZF_Features;`) to match your project too. Do a search-replace from `ZF_Features` to `Your_Project_Prefix`.

To use the plugin, you need to run `composer install` in the plugin directory. For information on installing Composer on your platform, see here https://getcomposer.org/doc/00-intro.md

TODO: automate the above with an installation script

## Adding Custom Post Types and Taxonomies

To create a new post type, first create a new file in `Post_Types/`, e.g. `Post_Types/Movie.php`, then add a corresponding line in `app-config.php` under `post_types`, so with the previous example it should look like this

	'post_types' => [
		'movie'  => 'Movie',
	],

There is an example post type Thing which you can copy and use as a starting point.

Custom taxonomies work in a similar fashion: first create a file under `Taxonomies`, then add it to `app-config.php`. The purpose of this is to ensure a proper and easily readable structure for our project.

## Custom meta boxes

The plugin relies on CMB2, which is installed inside the plugin via composer.

Each meta box should have its own class file inside `Custom_Meta/`. See example file `Custom_Meta/Location.php`. Meta fields are otherwise defined as described in the CMB2 documentation: https://github.com/CMB2/CMB2/wiki

After creating the file, add the meta box to `app-config.php`

## Adding Ajax requests

To create a new Ajax request, first create a new file in `Ajax/`, e.g. `Ajax/Dishwashing.php`, then add a corresponding line in `app-config.php` under `ajax`, so with the previous example it should look like this

	'ajax' => [
		'dishwashing'  => 'Dishwashing',
	],

There is an example Ajax request Random which you can copy and use as a starting point.

## Admin 

TODO: add documentation

## Mail templates

* Adding Custom Email templates
There is an example Test_Template.php to be used as a starting point.
To create a new email template copy a `Test_Template.php` and name it accordingly.
Remember to update class name also. Make necessary changes to `subject` and `message` parameters.

* wp_mail function is used for sending emails

## Views

To create a view, first create a new file in `Views/`, e.g. `Views/Front.php`, then add a corresponding line in `app-config.php` under views, so with the previous example it should look like this:

	'views' => [
		'front'  => 'Front',
	],

The `Views/Front.php` file requires two methods, `get_data` and `load_condition`.

* `get_data` is the method that will fetch the data needed into that view.
* `load_condition` is the method that checks if the data should be loaded or not.

If the condition within `load_condition` is matched then the data from `get_data` is loaded into the `WP_Query` object.

## ACF field groups

To create a field group, create a new file in `ACF/`, e.g `ACF/Person.php`. Then add a corresponding line in `app-config.php` under "acf" and define where and when the field should be shown (location). For example:
````
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
```

You can build the fields using ACF Field Editor and copy-paste the location and fields settings from Tools -> Export, just make sure you copy only the right arrays, not the whole field group settings. Also you should remove the key fiedls to make field naming more consistent. No need to prefix anything, this will handle it automatically. Fields are named with pattern `prefix_groupname-fieldname`, for example `zf_person-date`. 

### Example field array
```
	array(
		'label' => 'Event date',
		'name' => 'date',
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
```

This functionality has not yet been tested with repeater fields or sub group -fields.