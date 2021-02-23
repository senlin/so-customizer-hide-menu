<?php
/*
Plugin Name: Customizer Hide Menu
Plugin URI: https://so-wp.com/plugin/customizer-hide-menu
Description: The Customizer Hide Menu hides the Navigation Menu from the Customizer so as not to confuse anyone.
Version: 1.2.0
Author: SO WP
Author URI: https://so-wp.com
License: GPLv3 or later
License URI: https://www.gnu.org/licenses/gpl-3.0.html
Text Domain: so-customizer-hide-menu
Domain Path: /languages
*/

/*  Copyright 2015-2021 Pieter Bos (email: pieter@so-wp.com)

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

		add_filter( 'customize_loaded_components', array( $this, 'sochm_remove_nav_menus_panel' ) );

	}

	/**
	 * Defines constants used by the plugin.
	 *
	 * @since 1.0
	 */
	function constants() {

		/* Set the version number of the plugin. */
		define( 'SOCHM_VERSION', '1.2.0' );

		/* Set constant path to the plugin URL. */
		define( 'SOCHM_URI', trailingslashit( plugin_dir_url( __FILE__ ) ) );

	}

	/**
	 * Removes the core 'Menus' panel from the Customizer.
	 *
	 * @param array $components Core Customizer components list.
	 * @return array (Maybe) modified components list.
	 *
	 * @since 1.2.0
	 */
	function sochm_remove_nav_menus_panel( $components ) {
		$i = array_search( 'nav_menus', $components );
		if ( false !== $i ) {
			unset( $components[ $i ] );
		}
		return $components;
	}
	
}

$sochm_load = new SOCHM_Load();




