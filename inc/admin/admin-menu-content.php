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

					<div class="postbox">

						<h2 class="hndle ui-sortable-handle"><?php echo $post_type_obj->labels->name; ?></h2>

						<div class="inside">

							<div class="hd-basement-content-actions" style="float: left; width: 49.5%; margin-right; 1%;">

								<h4><?php _e( 'Actions', 'hd-basement' ); ?></h4>

								<div class="hd-basement-content-actions__links">
									<a class="page-title-action" href="<?php echo esc_url( admin_url( 'edit.php?post_type=' . $post_type ) ); ?>"><?php _e( 'View All', 'hd-basement' ); ?></a>
									<a class="page-title-action" href=""><?php _e( 'Add New', 'hd-basement' ); ?></a>
								</div>

								<?php

									// output the post type description
									echo wpautop( $post_type_obj->description );

									// output the taxonomy links for this post type
									hd_basement_get_post_type_taxonomy_buttons( $post_type, true );

								?>

							</div><!-- // hd-basement-content-actions -->

							<div class="hd-basement-content-latest" style="float: left; width: 49.5%;">

								<?php

									// query for the latest content in this post type
									$content_query = new WP_Query(
										apply_filters(
											'hd_basement_content_block_' . $post_type . '_latest_query',
											array(
												'post_type'			=> $post_type,
												'posts_per_page'	=> 4,
												'no_found_rows'		=> true
											)
										)
									);

									// if we have any content
									if( $content_query->have_posts() ) {

										?>

										<h4 class="hd-basement-content-latest__title">Latest <?php esc_html_e( $post_type_obj->label ); ?></h4>

										<ul class="hd-basement-content-latest__posts">

										<?php

											// loop through each content post
											while( $content_query->have_posts() ) : $content_query->the_post();

												?>

												<li <?php post_class(); ?> id="post-<?php the_ID(); ?>">
													<a href="<?php echo get_edit_post_link( $post->ID ); ?>"><?php the_title(); ?></a>
												</li>

												<?php

											// end loop through content posts
											endwhile;

										?>
										</ul><!-- // hd-basement-content-latest__posts -->
										<?php

									} // end if have any content

									// reset query
									wp_reset_query();

								?>

							</div><!-- // hd-basement-content-latest -->

							<div class="clear"></div>

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