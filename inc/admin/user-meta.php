<?php
/**
 * Functionality associated with storing and handline user meta data.
 *
 * @package HD_Basement
 */

/**
 * Adds a field to the user profile page to revert back to a standard WordPress dashboard.
 *
 * @param  WP_user $user The current user object.
 */
function hd_basement_profile_fields( $user ) {

	// bail out early if user is not an admin.
	if ( ! current_user_can( 'manage_options' ) ) {
		return false;
	}

	// output a nonce field.
	wp_nonce_field( 'hd_basement_profile_fields_action', 'hd_basement_profile_fields_name' );

	?>

	<table class="form-table">

		<tr>

			<th scope="row"><?php esc_html_e( 'Dashboard Style', 'hd-basement' ); ?></th>

			<td>
				
				<fieldset>
				
					<legend class="screen-reader-text">
						<span><?php esc_html_e( 'Use Regular WordPress Dashboard?', 'hd-basement' ); ?></span>
					</legend>
					
					<label for="hd_normal_wp_user">
						<input name="hd_normal_wp_user" type="checkbox" id="hd_normal_wp_user" value="1"<?php checked( get_user_meta( $user->ID, 'hd_normal_wp_user', true ), 'true' ); ?> />
						<?php esc_html_e( 'Use Regular WordPress Dashboard?', 'hd-basement' ); ?>
					</label>
				
				</fieldset>
				
			</td>
		</tr>
	
	</table>
	
	<?php

}

add_action( 'personal_options', 'hd_basement_profile_fields' );

/**
 * Saves the new fields added to the profile page.
 *
 * @param  Int $user_id The current users ID.
 */
function hd_basement_save_profile_fields( $user_id ) {

	// check the current user is a super admin.
	if ( ! current_user_can( 'manage_options', $user_id ) ) {
		return false;
	}

	// if we have a user posted data and the nonce passes.
	if ( isset( $_POST['hd_normal_wp_user'] ) || ! wp_verify_nonce( $_POST['hd_basement_profile_fields_name'], 'hd_basement_profile_fields_action' ) ) {

		// update the user meta.
		update_user_meta( $user_id, 'hd_normal_wp_user', 'true' );

	} else {

		// remove the wpbasis super user meta.
		update_user_meta( $user_id, 'hd_normal_wp_user', 'false' );

	}
}

add_action( 'personal_options_update', 'hd_basement_save_profile_fields' );
add_action( 'edit_user_profile_update', 'hd_basement_save_profile_fields' );

/**
 * Save the fact that admin nag has been dismissed.
 */
function hd_basement_dismiss_dashboard_style_notice() {

	update_user_meta( absint( $_POST['user'] ), 'hd_basement_dashboard_notice_dismiss', '1' );
	die();

}

add_action( 'wp_ajax_hd_basement_dismiss_dashboard_style_notice', 'hd_basement_dismiss_dashboard_style_notice' );
