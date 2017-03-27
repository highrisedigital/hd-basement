<?php
/**
Plugin Name:	Highrise Digital Basement
Description:	Core utilities plugin used by Highrise Digital for building out WordPress sites. Used alongside The Ground Floor base theme.
Version:		1.0
Author:			Highrise Digital Ltd
Author URI:		https://highrise.digital
*/

// define variable for path to this plugin file
define( 'HD_BASEMENT_LOCATION', dirname( __FILE__ ) );
define( 'HD_BASEMENT_URL', plugins_url( '', __FILE__ ) );

// if we are in the admin
if( is_admin() ) {

	// load in our included admin files for this plugin
	require_once dirname( __FILE__ ) . '/inc/admin/scripts.php';
	require_once dirname( __FILE__ ) . '/inc/admin/capabilities.php';
	require_once dirname( __FILE__ ) . '/inc/admin/admin-menus.php';
	require_once dirname( __FILE__ ) . '/inc/admin/admin-widgets.php';

}

// require non admin files
require_once dirname( __FILE__ ) . '/inc/widgets.php';
require_once dirname( __FILE__ ) . '/inc/admin/admin-bar.php';
require_once dirname( __FILE__ ) . '/inc/remove-customizer.php';

/**
 * 
 */
function is_hd_user() {

	// // set default return to false
	$output = array();

	// get the current logged in user
	$user = wp_get_current_user();

	// create a filterable array of email domains
	$email_domains = apply_filters(
		'hd_basement_email_domain',
		array(
			'highrise_digital'	=> 'highrise.digital',
		)
	);

	// if we have email domains
	if( ! empty( $email_domains ) ) {

		// loop through each domain
		foreach( $email_domains as $email_domain ) {

			// if this email address in our filterable array of email domains
			$email = strpos( $user->user_email, $email_domain );
			
			if( $email !== false ) {
				$output[] = true;
			} else {
				$output[] = false;
			}

		} // end loop through email domains

	} // end if have email domains

	// if true exists in the output
	if( in_array( true, $output ) ) {
		$value = true;
	} else {
		$value = false;
	}

	return apply_filters( 'is_hd_user', $value, wp_get_current_user() );

}

/**
 * adds a highrise digital colour scheme to the schemes available
 * on the user profile page
 */
function hd_basement_add_colour_scheme() {

	wp_admin_css_color(
		'hd_color_scheme', __( 'Highrise Digital', 'hd-basement' ),
		plugins_url( 'assets/css/hd-color-scheme.css', __FILE__ ),
		array( '#262E4D', '#00d6a5', '#FFFFFF', '#eeeeee' ),
		array( 'base' => '#262E4D', 'focus' => '#00d6a5', 'current' => '#F8F6F1' )
	);

}

add_action( 'admin_init', 'hd_basement_add_colour_scheme' );