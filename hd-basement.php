<?php
/**
Plugin Name: Highrise Digital Basement
Description: Core utilities plugin used by Highrise Digital for building out WordPress sites. Used alongside The Ground Floor base theme.
Version: 1.0
Author: Highrise Digital Ltd
Author URI: https://highrise.digital
*/

// define variable for path to this plugin file.
define( 'HD_BASEMENT_LOCATION', dirname( __FILE__ ) );
define( 'HD_BASEMENT_URL', plugins_url( '', __FILE__ ) );

// hide the acf menu item if staging or production.
if ( defined( 'WP_PRODUCTION' ) && WP_PRODUCTION || defined( 'WP_STAGING' ) && WP_STAGING ) {
	add_filter( 'acf/settings/show_admin', '__return_false' );
}

// if we are in the admin.
if ( is_admin() ) {

	// load in our included admin files for this plugin.
	require_once dirname( __FILE__ ) . '/inc/admin/scripts.php';
	require_once dirname( __FILE__ ) . '/inc/admin/admin-menus.php';
	require_once dirname( __FILE__ ) . '/inc/admin/admin-widgets.php';
	require_once dirname( __FILE__ ) . '/inc/admin/user-meta.php';
	require_once dirname( __FILE__ ) . '/inc/admin/admin.php';

}

// require non admin files.
require_once dirname( __FILE__ ) . '/inc/capabilities.php';
require_once dirname( __FILE__ ) . '/inc/widgets.php';
require_once dirname( __FILE__ ) . '/inc/admin/admin-bar.php';
require_once dirname( __FILE__ ) . '/inc/remove-customizer.php';

/**
 * Checks whether the current user is a highrise digital team member
 * this is based on the email address. If the email domain matches
 * highrise.digital the user is a hd user
 * The email domain can be filtered to allow other email domains to
 * be hd users too.
 *
 * @param  int $user_id The user ID to check.
 * @return boolean true is the user is a hd user and false otherwise
 */
function is_hd_user( $user_id = 0 ) {

	// if no user id is passed.
	if ( 0 === $user_id ) {

		// use current user.
		$user_id = get_current_user_id();

	} // End if().

	// get the highrise dashboard setting from user meta.
	$hd_dashboard = get_user_meta( $user_id, 'hd_normal_wp_user', true );

	// if no value is stored.
	if ( '' === $hd_dashboard ) {

		// assume the value is false.
		$hd_dashboard = false;

	}

	return apply_filters( 'is_hd_user', filter_var( $hd_dashboard, FILTER_VALIDATE_BOOLEAN ), $user_id );

}
