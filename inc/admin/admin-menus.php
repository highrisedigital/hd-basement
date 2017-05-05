<?php
/**
 * adds the new top level menu pages for none hd users
 */
function hd_basement_add_top_level_menu_pages() {

	/* if the current user is not a wpbasis super user */
	if( ! is_hd_user() ) {

		// if the current theme supports menus
		if( current_theme_supports( 'menus' ) ) {

			// add a new menu item linking to the wordpress menus page
			add_menu_page(
				__( 'Menus', 'hd-basement' ),
				__( 'Menus', 'hd-basement' ),
				'edit_theme_options',
				'nav-menus.php',
				'',
				'dashicons-menu',
				61
			);

		}

		// if the current theme supports widgets
		if( current_theme_supports( 'widgets' ) ) {

			// add a new menu item linking to the wordpress widgets page
			add_menu_page(
				__( 'Widgets', 'hd-basement' ),
				__( 'Widgets', 'hd-basement' ),
				'edit_theme_options',
				'widgets.php',
				'',
				'dashicons-welcome-widgets-menus',
				62
			);

		}

		// add a new media/uploads item linking to the wordpress menus page
		add_menu_page(
			__( 'Uploads', 'hd-basement' ),
			__( 'Uploads', 'hd-basement' ),
			'upload_files',
			'upload.php',
			'',
			'dashicons-admin-media',
			30
		);

		// add the menu for content
		add_menu_page(
			__( 'Content', 'hd-basement' ),
			__( 'Content', 'hd-basement' ),
			'edit_posts',
			'hd_basement_content',
			'hd_basement_content_page',
			'dashicons-admin-page',
			4
		);

	}

}

add_action( 'admin_menu', 'hd_basement_add_top_level_menu_pages', 10 );

function hd_basement_add_post_type_sub_menus() {

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
	$post_types = apply_filters( 'hd_basement_content_submenu_post_types', $post_types );

	// check we have post types to action
	if( ! empty( $post_types ) ) {

		// loop through each post type
		foreach( $post_types as $post_type ) {

			// get this post types object
			$post_type_obj = get_post_type_object( $post_type );

			// add the sub page menu item
			add_submenu_page(
				'hd_basement_content',
				$post_type_obj->labels->name,
				$post_type_obj->labels->menu_name,
				'edit_posts',
				'edit.php?post_type=' . $post_type
			);

		} // end loop through each post type

	} // end if have post types

}

add_action( 'admin_menu', 'hd_basement_add_post_type_sub_menus' );

/**
 * 
 */
function hd_basement_edit_admin_menus() {

	/* if the current user is not a wpbasis super user */
	if( ! is_hd_user() ) {

		$menu_items = array(
			//'seperator_one' => 'seperator1',
			'appearance'	=> 'themes.php',
			'tools'			=> 'tools.php',
			'settings'		=> 'options-general.php',
			'media'			=> 'upload.php',
		);

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
		
		// check we have post types to action
		if( ! empty( $post_types ) ) {

			// loop through each post type
			foreach( $post_types as $post_type ) {

				// get this post types object
				$post_type_obj = get_post_type_object( $post_type );

				// if this post type is post
				if( 'post' === $post_type ) {

					// add this post type to the menu items array
					$menu_items[ $post_type_obj->name ] = 'edit.php';

				// any post type except post
				} else {

					// add this post type to the menu items array
					$menu_items[ $post_type_obj->name ] = 'edit.php?post_type=' . $post_type;

				} // end if post type is post

			} // end loop through each post type

		} // end if have post types

		// allow the array to be filtered
		apply_filters( 'hd_basement_removed_admin_menus', $menu_items );

		// loop through each of the items from our array
		foreach( $menu_items as $menu_item ) {

			// reomve the menu item
			remove_menu_page( $menu_item );

		}

	}

}

add_action( 'admin_menu', 'hd_basement_edit_admin_menus', 999 );