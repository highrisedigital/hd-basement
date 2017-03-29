<?php

function hd_basement_profile_fields( $user ) {
	
	/* bail out early if user is not an admin */
	if( ! current_user_can( 'manage_options' ) ) {
		return false;
	}

	?>

	<table class="form-table">

		<tr>
			<th scope="row"><?php _e( 'Dashboard Style', 'hd-basement' ); ?></th>

			<td>
				
				<fieldset>
				
					<legend class="screen-reader-text">
						<span><?php _e( 'Use Regular WordPress Dashboard?', 'hd-basement' ); ?></span>
					</legend>
					
					<label for="hd_normal_wp_user">
						<input name="hd_normal_wp_user" type="checkbox" id="hd_normal_wp_user" value="1"<?php checked( get_user_meta( $user->ID, 'hd_normal_wp_user', true ), 'true' ); ?> />
						<?php _e( 'Use Regular WordPress Dashboard?', 'hd-basement' ); ?>
					</label>
				
				</fieldset>
				
			</td>
		</tr>
	
	</table>
	
	<?php
}

add_action( 'personal_options', 'hd_basement_profile_fields' );

function hd_basement_save_profile_fields( $user_id ) {
	
	/* check the current user is a super admin */
	if ( ! current_user_can( 'manage_options', $user_id ) ) {
		return false;
	}
	
	/* if we have a wpbasis user posted */
	if( isset( $_POST[ 'hd_normal_wp_user' ] ) ) {

		// update the user meta
		update_usermeta( $user_id, 'hd_normal_wp_user', 'true' );
		
	/* the email domain does not match the users email domain */
	} else {
		
		/* remove the wpbasis super user meta */
		update_usermeta( $user_id, 'hd_normal_wp_user', 'false' );
		
	}
}

add_action( 'personal_options_update', 'hd_basement_save_profile_fields' );
add_action( 'edit_user_profile_update', 'hd_basement_save_profile_fields' );

function hd_basement_dismiss_dashboard_style_notice() {
	
	update_usermeta( absint( $_POST[ 'user' ] ), 'hd_basement_dashboard_notice_dismiss', '1' );
	die();

}

add_action( 'wp_ajax_hd_basement_dismiss_dashboard_style_notice', 'hd_basement_dismiss_dashboard_style_notice' );