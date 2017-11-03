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

## Ajax

TODO: add documentation

## Admin 

TODO: add documentation

## Mail templates

TODO: add documentation

## Views

TODO: add documentation
