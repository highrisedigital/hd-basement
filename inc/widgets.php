<?php
/**
 * edit the list of default WordPress widgets
 */
function hd_basement_remove_default_widgets() {
	
	// create a filterable array of widgets to remove
	$widgets = apply_filters(
		'hd_removed_widgets',
		array(
			'pages'				=> 'WP_Widget_Pages',
			'calendar'			=> 'WP_Widget_Calendar',
			'links'				=> 'WP_Widget_Links',
			'meta'				=> 'WP_Widget_Meta',
			'recent_comments'	=> 'WP_Widget_Recent_Comments',
			'recent_posts'		=> 'WP_Widget_Recent_Posts',
			'rss'				=> 'WP_Widget_RSS',
			'tag_cloud'			=> 'WP_Widget_Tag_Cloud'
		)
	);

	// check we have widgets to remove
	if( ! empty( $widgets ) ) {

		// loop through each widget to remove
		foreach( $widgets as $widget ) {

			// under register to widget in WordPress
			unregister_widget( $widget );

		}

	} // end if have widgets to remove

}

add_action( 'widgets_init', 'hd_basement_remove_default_widgets', 11 );