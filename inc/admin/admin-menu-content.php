<?php

function hd_basement_content_page() {
	
	// get all the post types where we should show ui for
	$post_types = get_post_types(
		array(
			'show_ui'	=> true
		)
	);

	// if attachments is in the post types array
	if( isset( $post_types[ 'attachment' ] ) ) {

		// remove attachments
		unset( $post_types[ 'attachment' ] );

	}

	// allow post types to be filterable
	$post_types = apply_filters( 'hd_basement_content_page_post_types', $post_types );

	// check we have post types to action
	if( ! empty( $post_types ) ) {

		?>

		<div class="wrap">

			<h1 class="hd-basement-content-title"><?php _e( 'Content', 'hd-basement' ); ?></h1>

			<div class="hd-basement-content-wrapper metabox-holder">

				<?php

				// loop through each post type
				foreach( $post_types as $post_type ) {

					// get this post types object
					$post_type_obj = get_post_type_object( $post_type );

					?>

					<div class="postbox hd-content-block">

						<h2 class="hndle ui-sortable-handle"><?php echo $post_type_obj->labels->name; ?></h2>

						<div class="inside">

							<?php

								// output the post type description
								echo wpautop( $post_type_obj->description );

							?>

							<div class="hd-basement-content-actions">

								<h4><?php _e( 'Actions', 'hd-basement' ); ?></h4>

								<div class="hd-basement-content-actions__links">
									<a class="page-title-action" href="<?php echo esc_url( admin_url( 'edit.php?post_type=' . $post_type ) ); ?>"><?php _e( 'View All', 'hd-basement' ); ?></a>
									<a class="page-title-action" href=""><?php _e( 'Add New', 'hd-basement' ); ?></a>
								</div>

								<?php

									// output the taxonomy links for this post type
									hd_basement_get_post_type_taxonomy_buttons( $post_type, true );

								?>

							</div><!-- // hd-basement-content-actions -->

						</div><!-- // inside -->
					
					</div><!-- // postbox -->

					<?php

				} // end loop through post types

				?>

			</div><!-- // hd-basement-content-wrapper -->

		</div><!-- // wrap -->

		<?php

	} // end if have post types

}