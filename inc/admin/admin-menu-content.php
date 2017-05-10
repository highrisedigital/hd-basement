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

						<?php

							// set a default menu icon
							$menu_icon = 'dashicons-admin-post';

							// if no menu icon is declared
							if( null === $post_type_obj->menu_icon ) {

								// if this post type is a page
								if( 'page' === $post_type_obj->name ) {

									// set the menu icon to be the page icon
									$menu_icon = 'dashicons-admin-page';

								} // end if post type is page

							// we have a menu icon declared
							} else {

								// set the menu icon to that declared in register post type
								$menu_icon = $post_type_obj->menu_icon;

							}

						?>

						<h2 class="hndle ui-sortable-handle"><span class="dashicons <?php esc_attr_e( $menu_icon ); ?>"></span> <?php echo $post_type_obj->labels->name; ?></h2>

						<div class="inside">

							<?php

								// output the post type description
								echo wpautop( $post_type_obj->description );

							?>

							<div class="hd-basement-content-actions">

								<h4><?php _e( 'Actions', 'hd-basement' ); ?></h4>

								<div class="hd-basement-content-actions__links">
									<a class="page-title-action post-type-button view-all" href="<?php echo esc_url( admin_url( 'edit.php?post_type=' . $post_type ) ); ?>"><?php _e( 'View All', 'hd-basement' ); ?></a>
									<a class="page-title-action post-type-button add-new" href="<?php echo esc_url( admin_url( '/post-new.php?post_type=' . $post_type ) ); ?>"><?php _e( 'Add New', 'hd-basement' ); ?></a>
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