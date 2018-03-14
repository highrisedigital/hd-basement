<?php
/**
 * Functions related to the WordPress admin bar, shown for logged in users.
 *
 * @package HD_Basement
 */

/**
 * Amends the admin bar
 */
function hd_basement_admin_bar_remove_elements() {

	// if the current user is a hd super user.
	if ( is_hd_user() ) {
		return;
	}

	global $wp_admin_bar;

	// create a filterable array of admin bar elements to remove.
	$admin_bar_remove = apply_filters(
		'hd_admin_bar_elements',
		array(
			'wp-logo',
			'site-name',
			'new-content',
			'customize',
			'wpseo-menu', // wordpress seo plugins menu item.
			'updates',
		),
		get_current_user_id()
	);

	// check we have elements to remove.
	if ( ! empty( $admin_bar_remove ) ) {

		// loop through each element to remove.
		foreach ( $admin_bar_remove as $element ) {

			// remove unwanted menu item.
			$wp_admin_bar->remove_menu( $element );

		}
	}

}

add_action( 'wp_before_admin_bar_render', 'hd_basement_admin_bar_remove_elements', 10 );

/**
 * Adds an admin bar toggle link for front and back end.
 *
 * @param  object $wp_admin_bar The WP admin bar object passed by reference.
 */
function hd_basement_admin_bar_site_toggle( &$wp_admin_bar ) {

	// if the current user is a hd user.
	if ( is_hd_user() ) {
		return;
	}

	// only do this if in the admin.
	if ( is_admin() ) {

		// set link to home url.
		$site_link = home_url();
		$link_name = __( 'View Site', 'hd-basement' );

	} else {

		// set link to admin url.
		$site_link = admin_url();
		$link_name = __( 'Site Admin', 'hd-basement' );

	}

	/* add a view site or admin link menu to the admin bar */
	$wp_admin_bar->add_menu(
		array(
			'id'    => 'site-toggle',
			'title' => $link_name,
			'href'  => $site_link,
		)
	);

}

add_action( 'admin_bar_menu', 'hd_basement_admin_bar_site_toggle', 9 );

/**
 * Change Howdy? in the admin bar
 */
function hd_basement_howdy() {

	global $wp_admin_bar;

	/* get the current logged in users gravatar */
	$avatar = get_avatar( get_current_user_id(), 16 );

	// there is a howdy node, lets alter it.
	$wp_admin_bar->add_node(
		array(
			'id'    => 'my-account',
			'title' => sprintf( 'Logged in as, %s', wp_get_current_user()->display_name ) . $avatar,
		)
	);

}

add_filter( 'admin_bar_menu', 'hd_basement_howdy', 10, 2 );
