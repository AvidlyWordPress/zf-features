<?php
/*
Plugin Name: ZF Features
Plugin URI: http://zeelandfamily.fi
Description: Define Custom post types, taxonomies and fields for project
Version: 1.0
Author: Marco Martins / Zeeland Family
Author URI: http://zeelandfamily.fi
License: GPL3
*/
/*  Copyright 2017  Zeeland Family (email : system@zeelandfamily.fi)

	This program is free software; you can redistribute it and/or modify
	it under the terms of the GNU General Public License, version 2, as
	published by the Free Software Foundation.

	This program is distributed in the hope that it will be useful,
	but WITHOUT ANY WARRANTY; without even the implied warranty of
	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	GNU General Public License for more details.

	You should have received a copy of the GNU General Public License
	along with this program; if not, write to the Free Software
	Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/
namespace ZF_Features;

use ZF_Features\Admin;

defined( 'ABSPATH' ) || die();

// Composer autoloader.
require_once __DIR__ . '/vendor/autoload.php';

// Load theme functions.
require_once __DIR__ . '/theme-functions.php';

/**
 * Loads the plugin config.
 *
 * @param  boolean $cli Loaded through the CLI.
 * @return Config  Config object.
 */
function zf_load_config( $cli = false ) {
	// By default the application config file is inside the plugin and the
	// environment config file should be outside the docroot for security.
	$app_config_filepath = __DIR__ . '/app-config.php';
	$env_config_filepath = dirname( $_SERVER['DOCUMENT_ROOT'] ) . '/env-config.php';

	if ( $cli ) {
		$env_config_filepath = dirname( dirname( $_SERVER['DOCUMENT_ROOT'] ) ) . '/env-config.php';
	}

	return new Config( $app_config_filepath, $env_config_filepath );
}

/**
 * Couples the WordPress execution with the plugin functionality.
 */
function zf_load_features() {
	$config = zf_load_config();
	$zf_features  = new ZF_Project_Features( $config );
	$admin_editor = new Admin\Editor();
	$admin_menus  = new Admin\Menus();

	load_plugin_textdomain( 'zf-features', '', basename( dirname( __FILE__ ) ) . '/languages' );

	register_activation_hook( __FILE__, [ $zf_features, 'activation' ] );

	// Register custom post types.
	add_action( 'init', [ $zf_features, 'register_post_types' ], 11 );

	// Register custom taxonomies.
	add_action( 'init', [ $zf_features, 'register_taxonomies' ], 12 );

	// Register views on init.
	add_action( 'init', [ $zf_features, 'register_views' ], 12 );
	add_action( 'pre_get_posts', [ $zf_features, 'set_view_data' ], 10 );

	// Register ajax handlers.
	add_action( 'init', array( $zf_features, 'register_ajax_handlers' ), 12 );

	// Add feature plugin data to the query variable object.
	add_action( 'the_posts', [ $zf_features, 'localize_script_data_handler' ], 10, 2 );

	// Register the meta boxes (uses CMB2).
	add_action( 'cmb2_admin_init', [ $zf_features, 'register_meta_boxes' ] );

	add_action( 'acf/init', [ $zf_features, 'register_acf_fields' ] );

	/*
	// Customize admin menus.
	add_action( 'admin_menu', array( $admin_menus, 'add' ) );

	// Change tinymce buttons on the visual tab.
	add_filter( 'mce_buttons',   array( $admin_editor, 'mce_buttons' ) );   // primary toolbar (always visible).
	add_filter( 'mce_buttons_2', array( $admin_editor, 'mce_buttons_2' ) ); // second-row toolbar.
	add_filter( 'mce_buttons_3', array( $admin_editor, 'mce_buttons_3' ) ); // third-row toolbar.
	add_filter( 'mce_buttons_4', array( $admin_editor, 'mce_buttons_4' ) ); // fourth-row toolbar.
	*/
}

add_action( 'plugins_loaded', __NAMESPACE__ . '\\zf_load_features' );
