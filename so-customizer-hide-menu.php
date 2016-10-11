<?php
/*
Plugin Name: SO Customizer Hide Menu
Plugin URI: https://so-wp.com/?p=192
Description: The SO Customizer Hide Menu hides the Navigation Menu from the Customizer so as not to confuse anyone.
Version: 1.0.3
Author: Piet Bos
Author URI: http://senlinonline.com
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
Text Domain: so-customizer-hide-menu
Domain Path: /languages
*/

/*  Copyright 2015 Piet Bos (email: piet@so-wp.com)

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

/**
 * Version check; any WP version under 4.3 is not supported (menus were added to Customizer then)
 * 
 * adapted from example by Thomas Scholz (@toscho) http://wordpress.stackexchange.com/a/95183/2015, Version: 2013.03.31, Licence: MIT (http://opensource.org/licenses/MIT)
 *
 * @since 1.0.2
 */

//Only do this when on the Plugins page.
if ( ! empty ( $GLOBALS['pagenow'] ) && 'plugins.php' === $GLOBALS['pagenow'] )
	add_action( 'admin_notices', 'sochm_check_admin_notices', 0 );

function sochm_min_wp_version() {
	global $wp_version;
	$require_wp = '4.3';
	$update_url = get_admin_url( null, 'update-core.php' );

	$errors = array();

	if ( version_compare( $wp_version, $require_wp, '<' ) ) 

		$errors[] = "You have WordPress version $wp_version installed, but <b>this plugin requires at least WordPress $require_wp</b>. Please <a href='$update_url'>update your WordPress version</a>.";

	return $errors;
}

function sochm_check_admin_notices()
{
	$errors = sochm_min_wp_version();

	if ( empty ( $errors ) )
		return;

	// Suppress "Plugin activated" notice.
	unset( $_GET['activate'] );

	// this plugin's name
	$name = get_file_data( __FILE__, array ( 'Plugin Name' ), 'plugin' );

	printf( __( '<div class="error"><p>%1$s</p><p><i>%2$s</i> has been deactivated.</p></div>', 'so-customizer-hide-menu' ),
		join( '</p><p>', $errors ),
		$name[0]
	);
	deactivate_plugins( plugin_basename( __FILE__ ) );
}
	
class SOCHM_Load {
	
	function __construct() {

		global $sochm;

		/* Set up an empty class for the global $sochm object. */
		$sochm = new stdClass;

		/* Set the constants needed by the plugin. */
		add_action( 'plugins_loaded', array( &$this, 'constants' ), 1 );

	}
	
	/**
	 * Defines constants used by the plugin.
	 *
	 * @since 1.0
	 */
	function constants() {

		/* Set the version number of the plugin. */
		define( 'SOCHM_VERSION', '1.0.1' );

		/* Set constant path to the plugin URL. */
		define( 'SOCHM_URI', trailingslashit( plugin_dir_url( __FILE__ ) ) );

	}

}

$sochm_load = new SOCHM_Load();
	

add_action( 'admin_enqueue_scripts', 'sochm_load_custom_admin_style' );	
	
/**
 * Register and enqueue the admin stylesheet
 * @since 2.0.0
 */
function sochm_load_custom_admin_style() {

    if ( ! is_admin() )
    	
    	return;
	
	wp_register_style( 'sochm-admin', SOCHM_URI . 'css/settings.css', false, SOCHM_VERSION );
	
	wp_enqueue_style( 'sochm-admin' );

}
