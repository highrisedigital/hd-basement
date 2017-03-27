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
				'Menus',
				'Menus',
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
				'Widgets',
				'Widgets',
				'edit_theme_options',
				'widgets.php',
				'',
				'dashicons-welcome-widgets-menus',
				62
			);

		}

		// add a new media/uploads item linking to the wordpress menus page
		add_menu_page(
			'Uploads',
			'Uploads',
			'upload_files',
			'upload.php',
			'',
			'dashicons-admin-media',
			30
		);

	}

}

add_action( 'admin_menu', 'hd_basement_add_top_level_menu_pages', 10 );

/**
 * 
 */
function hd_basement_edit_admin_menus() {

	/* if the current user is not a wpbasis super user */
	if( ! is_hd_user() ) {

		$menu_items = apply_filters(
			'hd_basement_removed_admin_menus',
			array(
				//'seperator_one' => 'seperator1',
				'appearance'	=> 'themes.php',
				'tools'			=> 'tools.php',
				'settings'		=> 'options-general.php',
				'media'			=> 'upload.php'
			)
		);

		// loop through each of the items from our array
		foreach( $menu_items as $menu_item ) {

			// reomve the menu item
			remove_menu_page( $menu_item );

		}

	}

}

add_action( 'admin_menu', 'hd_basement_edit_admin_menus', 999 );