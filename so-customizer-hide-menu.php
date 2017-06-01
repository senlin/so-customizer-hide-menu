<?php
/*
Plugin Name: SO Customizer Hide Menu
Plugin URI: https://so-wp.com/?p=192
Description: The SO Customizer Hide Menu hides the Navigation Menu from the Customizer so as not to confuse anyone.
Version: 1.1.1
Author: SO WP
Author URI: https://so-wp.com/plugins/
License: GPLv3 or later
License URI: https://www.gnu.org/licenses/gpl-3.0.html
Text Domain: so-customizer-hide-menu
Domain Path: /languages
*/

/*  Copyright 2015-2017 Piet Bos (email: piet@so-wp.com)

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License, version 2, as
published by the Free Software Foundation.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

*/

/**
 * Prevent direct access to files
 * @since v1.0.2
 */
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class SOCHM_Load {
	
	function __construct() {

		global $sochm;

		/* Set up an empty class for the global $sochm object. */
		$sochm = new stdClass;

		/* Set the constants needed by the plugin. */
		add_action( 'plugins_loaded', array( $this, 'constants' ), 1 );
		
		add_action( 'admin_enqueue_scripts', array( $this, 'load_custom_admin_style' ) );

	}
	
	/**
	 * Defines constants used by the plugin.
	 *
	 * @since 1.0
	 */
	function constants() {

		/* Set the version number of the plugin. */
		define( 'SOCHM_VERSION', '1.1.1' );

		/* Set constant path to the plugin URL. */
		define( 'SOCHM_URI', trailingslashit( plugin_dir_url( __FILE__ ) ) );

	}

	/**
	 * Register and enqueue the admin stylesheet
	 * @since 2.0.0
	 */
	function load_custom_admin_style() {

		if ( ! is_admin() )

	    	return;

		wp_register_style( 'sochm-admin', SOCHM_URI . 'css/settings.css', false, SOCHM_VERSION );

		wp_enqueue_style( 'sochm-admin' );

	}

}

$sochm_load = new SOCHM_Load();
	

	
	
