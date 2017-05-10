<?php

function hd_basement_edit_at_a_glance_widget_post_types( $items ) {

	// get the post types which want to be shown in at a glance
	$post_types = get_post_types(
		array(
			'at_a_glance'	=> true
		),
		'objects'
	);

	// if we have some post types
	if( ! empty( $post_types ) ) {

		// loop through each post type
		foreach( $post_types as $post_type ) {

			// get the post count for this post type
			$num_posts = wp_count_posts( $post_type->name );

			// get the published post count for this post type
			$published_posts = $num_posts->publish;

			// build the output text for this post type
			$text = _n( '%s ' . $post_type->labels->singular_name, '%s ' . $post_type->labels->name, $published_posts, 'hd-basement' );
			$text = sprintf( $text, number_format_i18n( $published ) );

			// if the current logged in user can edit this post type
			if ( current_user_can( $post_type->cap->edit_posts ) ) {

				// set the output
				$output = '<a href="edit.php?post_type=' . $post_type->name . '">' . $text . '</a>';

			// current user cannot edit this post types posts
			} else {

				// set the output
				$output = '<span>' . $text . '</span>';

			}

			// add this output to the items
			$items[] = $output;

		} // end loop through post types

	} // end if have post types

	// return the modified array of items
	return $items;

}

add_filter( 'dashboard_glance_items', 'hd_basement_edit_at_a_glance_widget_post_types' );

/**
 * remove and adds in widgets which are filterable by other plugins
 */
function hd_basement_edit_dashboard_widgets() {

	// if the current user is a hd user
	if( is_hd_user() ) {
		return; // do nothing
	}

	// create a filterable array of dashboard widgets to remove
	$widgets = apply_filters(
		'hd_basement_edit_dashboard_widgets',
		array(
			'quick_press'	=> array(
				'id'		=> 'dashboard_quick_press',
				'context'	=> 'side',
				'action'	=> 'remove',
			),
			'primary'		=> array(
				'id'		=> 'dashboard_primary',
				'context'	=> 'side',
				'action'	=> 'remove',
			),
			'browser_nag'	=> array(
				'id'		=> 'dashboard_browser_nag',
				'context'	=> 'normal',
				'action'	=> 'remove',
			),
			// 'right_now'	=> array(
			// 	'id'		=> 'dashboard_right_now',
			// 	'context'	=> 'normal',
			// 	'action'	=> 'remove',
			// ),
			'activity'	=> array(
				'id'		=> 'dashboard_activity',
				'context'	=> 'normal',
				'action'	=> 'remove',
			),
			'hd_welcome'	=> array(
				'id'		=> 'dashboard_hd_basement_hd_welcome',
				'context'	=> 'side',
				'action'	=> 'add',
				'title'		=> __( 'Thank you! From Highrise Digital', 'hd-basement' ),
				'callback'	=> 'hd_basement_admin_dashboard_hd_welcome'
			),
			// 'hd_blog'	=> array(
			// 	'id'		=> 'dashboard_hd_basement_hd_blog',
			// 	'context'	=> 'side',
			// 	'action'	=> 'add',
			// 	'title'		=> __( 'From the Highrise Digital Blog', 'hd-basement' ),
			// 	'callback'	=> 'hd_basement_admin_dashboard_highrise_blog'
			// ),
		)
	);

	// check we have dashboard widgets to action
	if( ! empty( $widgets ) ) {

		// loop through each widget
		foreach( $widgets as $widget ) {

			// switch between the actions
			switch( $widget[ 'action' ] ) {

				// if the action is to remove
				case 'remove':

					// remove the widget
					remove_meta_box(
						$widget[ 'id' ],
						'dashboard',
						$widget[ 'context' ]
					);

					// break out of the switch statement
					break;

				// if the action is to add
				case 'add':

					// check the callback function is registered
					if( function_exists( $widget[ 'callback' ] ) ) {

						// set widget callback
						$callback = $widget[ 'callback' ];

					// widget callback is not defined
					} else {

						// set callback to return false
						$callback = '__return_null';

					}

					// add this meta box
					wp_add_dashboard_widget(
						$widget[ 'id' ],
						$widget[ 'title' ],
						$callback 
					);

					// break out of the switch statement
					break;

				// default behaviour if case not found
				default:
					break;

			}
			

		} // end loop through each widget

	} // if widgets not empty

	// removes the welcome panel dashboard content
	remove_action( 'welcome_panel', 'wp_welcome_panel' );

}

add_action( 'wp_dashboard_setup', 'hd_basement_edit_dashboard_widgets' );

/**
 * checks whether the dashboard help widget should be added
 * if it should be added it is then added to the array of
 * dashboard widgets to register
 * @param array $widgets the curent widgets array
 * @return array the modified array of widgets
 */
function hd_basement_maybe_add_dashboard_widget_help( $widgets ) {

	// if file mods are disallowed
	if( defined( 'DISALLOW_FILE_MODS' ) && true === DISALLOW_FILE_MODS ) {

		// add the help widget
		$widgets[ 'hd_help' ] = array(
			'id'		=> 'dashboard_hd_basement_hd_help',
			'context'	=> 'side',
			'action'	=> 'add',
			'title'		=> __( 'Help & Support', 'hd-basement' ),
			'callback'	=> 'hd_basement_admin_dashboard_help'
		);

	}

	// return the modified widgets array
	return $widgets;

}

add_filter( 'hd_basement_edit_dashboard_widgets', 'hd_basement_maybe_add_dashboard_widget_help' );

/**
 * allow function to be overwritten by checking whether a function with
 * the same name already exists
 */
if( ! function_exists( 'hd_basement_admin_dashboard_hd_welcome' ) ) {

	/**
	 * 
	 */
	function hd_basement_admin_dashboard_hd_welcome() {

		?>
		
		<p>Thank you for choosing Highrise Digital to build your WordPress website. This is the admin area of WordPress which is used for editing and adding content, changing settings and managing the appearance of your website.</p>

		<?php

	}

}

if( ! function_exists( 'hd_basement_admin_dashboard_highrise_blog' ) ) {

	/**
	 * 
	 */
	function hd_basement_admin_dashboard_highrise_blog() {

		?>
		From the blog
		<?php

	}

}

if( ! function_exists( 'hd_basement_admin_dashboard_help' ) ) {

	/**
	 * 
	 */
	function hd_basement_admin_dashboard_help() {

		?>
		Help!
		<?php

	}

}