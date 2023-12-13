<?php

/**

 *	Plugin Name: PIN Code Login

 *	Description: An easy to use pin code plugin to access the full site.

 *	Version: 3.1
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'PINCODE_PLUGIN_VERSION', '3.1' );
define( 'PINCODE_DIR_URI', plugin_dir_url( __FILE__ ));
define( 'PINCODE_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );

/**
 * Localization
 */
load_plugin_textdomain( 'pincode-login', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );

/**
 * Plugin page links
 */
function pin_code_plugin_settings_link( $links ) {

	$plugin_links = array(
		'<a href="' . admin_url( 'admin.php?page=pincode-login-setting-page' ) . '">' . __( 'Settings', '' ) . '</a>',
	);

	return array_merge( $plugin_links, $links );
}
add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ), 'pin_code_plugin_settings_link' );

/**
 * Load the main plugin file that will handle all actions
 */
require_once plugin_dir_path( __FILE__ ) . 'includes/pincode-login-class.php';
$pincode_obj = new Pincode_Login();
