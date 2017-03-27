<?php

function hd_basement_add_admin_banner() {

	// if this is not a hd user
	if( ! is_hd_user() ) {

		// get access to the pagenow global
		global $pagenow;

		// if this page is the index.php in the admin
		if( 'index.php' === $pagenow ) {

			?>
			<div class="hd-adminhead">

				<div class="hd-adminhead__logo" style="float: left; width: 191px; padding-top: 20px;">
					<a href="https://highrise.digital/">
						<img src="<?php echo esc_url( plugins_url( 'assets/images/hd-logo.png', dirname( __FILE__, 2 ) ) ); ?>" alt="Highrise Digitial Logo" />
					</a>
				</div><!-- // hd-adminhead-logo -->

				<div class="hd-adminhead__content" style="float: left;">
					
				</div><!-- // hd-adminhead-logo -->

				<span style="clear: both; display: block;"></span>

			</div>
			<?php

		} // end if this is the dashboard admin page

	} // emd if this is not a hd user

}

add_action( 'all_admin_notices', 'hd_basement_add_admin_banner' );

/**
 * replace the word dashboard with welcome in the admin
 * @param  string $translated_text the text to be translated
 * @param  string $text            the untranslated text
 * @param  string $domain          the text domain
 * @return string                  newly translated text
 */
function hd_edit_admin_dashboard_title( $translated_text, $text, $domain ) {

	// if this is not the admin return the unaltered text
	if( ! is_admin() ) {
		return $translated_text;
	}

	// if the translated text is dashboard
	if( 'Dashboard' === $translated_text ) {
		
		// change the text
		$translated_text = 'Welcome';

	}

	// return the modified translated text
	return $translated_text;

}

add_filter( 'gettext', 'hd_edit_admin_dashboard_title', 20, 3 );

/**
 * adds a highrise digital colour scheme to the schemes available
 * on the user profile page
 */
function hd_basement_add_colour_scheme() {

	wp_admin_css_color(
		'hd_color_scheme', __( 'Highrise Digital', 'hd-basement' ),
		plugins_url( 'assets/css/hd-color-scheme.css', dirname( __FILE__, 2 ) ),
		array( '#262E4D', '#00d6a5', '#FFFFFF', '#eeeeee' ),
		array( 'base' => '#262E4D', 'focus' => '#00d6a5', 'current' => '#F8F6F1' )
	);

}

add_action( 'admin_init', 'hd_basement_add_colour_scheme' );

/**
 * adds post type descrption to the standard post and pages post types
 * @param  array $args      array of registered post type args
 * @param  string $post_type the current post type
 * @return array            the modified registered post type args
 */
function hd_basement_add_built_in_post_type_descriptions( $args, $post_type ) {

	// create an array of post types to add descriptions to
	$posts_to_describe = apply_filters(
		'hd_basement_add_descriptions_post_types',
		array(
			'post'	=> 'posts',
			'page'	=> 'pages'
		)
	);

	// if we have have posts to describe
	if( ! empty( $posts_to_describe ) ) {

		// if this post type is in our list to describe
		if( isset( $posts_to_describe[ $post_type ] ) ) {

			// if the post type is posts
			if( 'post' === $post_type ) {

				// set the description string
				$post_desc = __( 'Posts are your sites news or blog.', 'hd-basement' );

			}

			// if the post type is pages
			if( 'page' === $post_type ) {

				// set the description string
				$post_desc = __( 'Pages are good for your sites static content.', 'hd-basement' );

			}

			// add the post type description
			$args[ 'description' ] = esc_html( $post_desc );

		}

	}

	// return the modified args
	return $args;

}

add_filter( 'register_post_type_args', 'hd_basement_add_built_in_post_type_descriptions', 10, 2 );

/**
 * gets the taxonomies for particular post type and outputs a link
 * to the taxonomy term listing page in a button
 * @param  string  $post_type  post type to get the taxonomies for
 * @param  boolean $show_title whether or not to include a title in the output. Defaults to true
 * @return string              html markup of the buttons
 */
function hd_basement_get_post_type_taxonomy_buttons( $post_type = '', $show_title = true ) {

	// get the taxonomies associated with this post type
	$taxonomies = get_object_taxonomies( $post_type, 'object' );

	// if we have taxonomies
	if( ! empty( $taxonomies ) ) {

		?>

		<div class="hd-basement-post-type-taxonomies">

			<?php

				// if we are showing the title
				if( true === $show_title ) {

					// outputt the title
					?>
					<h4><?php _e( 'Content Taxonomies', 'hd-basement' ); ?></h4>
					<?php

				}

				// loop through each taxonomy
				foreach( $taxonomies as $taxonomy ) {

					// if this taxonomy should not show in this content block
					if( false === $taxonomy->show_in_hd_basement_content_block ) {
						continue;
					}

					?>
					<a class="page-title-action" href=""><?php echo esc_html( $taxonomy->label ); ?></a>
					<?php

				} // end if have taxonomies

			?>

		</div><!-- // hd-basement-post-type-taxonomies -->

		<?php

	} // end if have taxonomies

}