<?php
/**
 * WordPress admin functions and related functionality.
 *
 * @package HD_Basement
 */

/**
 * Replace the word dashboard with welcome in the admin.
 *
 * @param  string $translated_text the text to be translated.
 * @param  string $text            the untranslated text.
 * @param  string $domain          the text domain.
 * @return string                  newly translated text.
 */
function hd_edit_admin_dashboard_title( $translated_text, $text, $domain ) {

	// if the user is a hd user.
	if ( is_hd_user() ) {
		return $translated_text; // do nothing.
	}

	// if this is not the admin return the unaltered text.
	if ( ! is_admin() ) {
		return $translated_text;
	}

	// if the translated text is dashboard.
	if ( 'Dashboard' === $translated_text ) {

		// change the text.
		$translated_text = 'Welcome';

	}

	// return the modified translated text.
	return $translated_text;

}

add_filter( 'gettext', 'hd_edit_admin_dashboard_title', 20, 3 );

/**
 * Adds a highrise digital colour scheme to the schemes available
 * on the user profile page
 */
function hd_basement_add_colour_scheme() {

	wp_admin_css_color(
		'hd_color_scheme', __( 'Highrise Digital', 'hd-basement' ),
		plugins_url( 'assets/css/hd-color-scheme.css', dirname( __FILE__, 2 ) ),
		array( '#262E4D', '#00d6a5', '#FFFFFF', '#eeeeee' ),
		array(
			'base' => '#262E4D',
			'focus' => '#00d6a5',
			'current' => '#F8F6F1',
		)
	);

}

add_action( 'admin_init', 'hd_basement_add_colour_scheme' );

/**
 * Provides a user nag if the user is using the optimised version of the dashboard.
 */
function hd_basement_dashboard_style_nag() {

	// get the status of the dashboard style for this user.
	$hd_dashboard_style = get_user_meta( get_current_user_id(), 'hd_normal_wp_user', true );

	// get the update nag status.
	$hd_dashboard_status = get_user_meta( get_current_user_id(), 'hd_basement_dashboard_notice_dismiss', true );

	// if the status is false (empty string).
	if ( '1' !== $hd_dashboard_style && '1' !== $hd_dashboard_status ) {

		?>
		<div class="notice notice-info hd-basement-dashboard-js is-dismissible" data-userid="<?php echo absint( get_current_user_id() ); ?>">
			<p><?php printf( _e( 'You are currently using the Highrise Digital optimised WordPress dashboard. To use the regular dashboard, vist your <a href="%s">profile</a> page to disable', 'hd_basement' ), esc_url( admin_url( 'profile.php' ) ) ); ?>.</p>
		</div>
		<?php

	}

}

add_action( 'admin_notices', 'hd_basement_dashboard_style_nag' );

/**
 * Adds content to the WordPress admin footer area.
 */
function hd_basement_footer_notice() {

	?>

	<img src="<?php echo esc_url( plugins_url( 'assets/images/hd-logo.png', dirname( __FILE__, 2 ) ) ); ?>" />
	<span style="margin-left: 12px; display: inline-block; vertical-align: top;">Website by <a href="https://highrise.digital/">Highrise Digital</a>, built with <a href="https://wordpress.org">WordPress</a></span>

	<?php

}

add_filter( 'admin_footer_text', 'hd_basement_footer_notice' );
