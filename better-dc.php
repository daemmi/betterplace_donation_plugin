<?php

/*
Plugin Name: Betterplace Donation Plugin
Plugin URI: 
Description: Show Betterplace Donations from Project
Version: 1.0.0 
Author: Jonas Damhuis
Author URI: 
License: GPL3
*/

/*  Copyright 2019 Jonas Damhuis  (email : jonas-d@posteo.de)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 3, as
    published by the Free Software Foundation.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

/**
 * Holds the absolute location of Better DC
 *
 * @since 1.0.0
 */
if ( ! defined( 'BETTER_DC_ABSPATH' ) )
	define( 'BETTER_DC_ABSPATH', dirname( __FILE__ ) );

/**
 * Holds the URL of Betterplace Donation Plugin
 *
 * @since 1.0.0
 */
if ( ! defined( 'BETTER_DC_RELPATH' ) )
	define( 'BETTER_DC_RELPATH', plugin_dir_url( __FILE__ ) );

/**
 * Holds the name of the Betterplace Donation Plugin
 *
 * @since 1.0.0
 */
if ( !defined( 'BETTER_DC_DIRNAME' ) )
	define( 'BETTER_DC_DIRNAME', basename( BETTER_DC_ABSPATH ) );

/**
 * Admin UI
 *
 * @since 1.0
 */
if ( is_admin() ) {
        
	/* templates for tables */
        
	/* functional classes (usually insantiated only once) */

	/* template classes (non-OOP templates are included on the spot) */
            
	/**
	 * BETTER_DC_Admin object
	 *
	 * @since 1.0.0
	 */

	/**
	 * BETTER_DC_Admin ajax
	 *
	 * @since 1.0.0
	 */

	/**
	 * BETTER_DC_Admin Wp_List_Table Bulk action 
	 *
	 * @since 1.0.0
	 */ 
}

/**
 * Enqueue the plugin's javascript
 *
 * @since 1.0
 */
function BETTER_DC_enqueue() {
    
	/* register scripts */ 
	wp_register_script( 'better-dc-counter', BETTER_DC_RELPATH . 'js/better-dc-counter.js', array( 'jquery' ), '1.1.2.3633', true );
	    
	/* register styles */
	wp_register_style( 'better-dc-counter', BETTER_DC_RELPATH . 'css/better-dc-counter.css', false, '1.0.0' );
	
	/* enqueue scripts */
    
	/* enqueue stylesheets */
	wp_enqueue_style( 'better-dc-counter' );
    
}
add_action( 'wp_enqueue_scripts', 'BETTER_DC_enqueue' );

function BETTER_DC_admin_enqueue() {
        
	/* register scripts */

	/* register styles */
        
	/* enqueue scripts */
        
	/* enqueue stylesheets */    

	/* localize */
        
}
add_action( 'admin_enqueue_scripts', 'BETTER_DC_admin_enqueue' );

/**
 * Require needed files
 *
 * @since 1.0
 */
require_once ( BETTER_DC_ABSPATH . '/includes/class-better-dc-main.php' );

/**
 * BETTER_DC Objects
 *
 * @global object $BETTER_DC
 * @since 1.0
 */
$GLOBALS['BETTER_DC'] = new BETTER_DC();

/**
 * BETTER_DC_Admin ajax
 *
 * @since 1.0.0
 */

/**
 * Define globals
 *
 * @since 1.0
 */
$BETTER_DC_db_version = "1.0";

/**
 * Installation & Update Routines
 *
 * Creates and/or updates plugin's tables.
 * The install method is only triggered on plugin installation
 * and when the database version number
 * ( "BETTER_DC_db_version", see above )
 * has changed.
 *
 * @since 1.0
 */
function BETTER_DC_install() {
   global $wpdb, $BETTER_DC_db_version;
        
        $installed_ver = get_option( "BETTER_DC_db_version" );
		
		// if the plugin is not installed the db version is false
        if ( $installed_ver === false ) {				
                //add_option( 'MHS_TM_db_version', $MHS_TM_db_version ); 
        }   
		 
        register_uninstall_hook( __FILE__, 'BETTER_DC_uninstall' );
}
register_activation_hook( __FILE__, 'BETTER_DC_install' );

/**
 * Update Routine
 *
 * Checks if the databse is newer and will run the install routine again.
 *
 * @since 1.0
 */
function BETTER_DC_update_db_check() {
    global $BETTER_DC_db_version;
		
//    if ( get_site_option( 'BETTER_DC_db_version' ) != $BETTER_DC_db_version ) {
//        BETTER_DC_install();
//    }
}
add_action( 'plugins_loaded', 'BETTER_DC_update_db_check' );

/**
 * Uninstall Routine
 *
 * Delete the added Database tables
 *
 * @since 1.0
 */
function BETTER_DC_uninstall(){
}

?>