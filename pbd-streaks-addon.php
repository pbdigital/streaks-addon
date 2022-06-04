<?php
/**
 * Plugin Name: PBD Streaks Add-on
 * Plugin URI: https://pbdigital.com.au/
 * Description: 
 * Author:     PB Digital
 * Author URI: https://pbdigital.com.au/
 * Version: 1.0.0
 * Text Domain:   pbd-sa
 * GitHub Plugin URI: pbdigital/streaks-addon
 * GitHub Plugin URI: https://github.com/pbdigital/streaks-addon
 *
 * @link              https://pbdigital.com.au/
 * @since             1.0.0
 * @package           pbd-sa
 */

// define constants
if ( ! defined( 'PBD_SA_PATH_CLASS' ) ) {
	define( 'PBD_SA_PATH_CLASS', dirname( __FILE__ ) . '/class' );
}
if ( ! defined( 'PBD_SA_PATH' ) ) {
	define( 'PBD_SA_PATH', dirname( __FILE__ ) );
}
if ( ! defined( 'PBD_SA_FOLDER' ) ) {
	define( 'PBD_SA_FOLDER', basename( PBD_SA_PATH ) );
}
if ( ! defined( 'PBD_SA_URL' ) ) {
	define( 'PBD_SA_URL', plugins_url() . '/' . PBD_SA_FOLDER );
}


if( ! class_exists( 'PBD_Streaks_Addon' ) ):

	// only activate if GamiPress is installed and active
	if ( !function_exists( 'pbd_sa_activation' ) ) {
		register_activation_hook( __FILE__, 'pbd_sa_activation' );
		function pbd_sa_activation(){
			if ( ! class_exists('GamiPress') ) {
				deactivate_plugins( plugin_basename( __FILE__ ) );
				wp_die('Sorry, but this plugin requires the GamiPress to be installed and active.');
			}
		}
	}

	add_action( 'admin_init', 'pbd_saplugin_activate' );
	function pbd_saplugin_activate(){
		if ( ! class_exists( 'GamiPress' ) ) {
			deactivate_plugins( plugin_basename( __FILE__ ) );
		}
	}

	include_once( PBD_SA_PATH_CLASS.'/pbd-streaks-addon.class.php' );
	add_action( 'plugins_loaded', array( 'PBD_Streaks_Addon', 'get_instance' ) );

	// Include our updater file
	include_once( PBD_SA_PATH_CLASS.'/pbd-streaks-addon-updater.class.php' );
	$updater = new PBD_Streaks_Addon_Updater( __FILE__ ); // instantiate our class
	$updater->set_username( '' ); // set username
	$updater->set_repository( '' ); // set repo
	// $updater->authorize( 'abcdefghijk1234567890' ); // Your auth code goes here for private repos
	$updater->initialize(); // initialize the updater


endif;
