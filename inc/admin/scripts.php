<?php
/**
 * Function hd_basement_enqueue_scripts()
 * Adds plugins scripts and styles
 */
function hd_basement_enqueue_scripts() {

	/* site js scripts */
	wp_enqueue_script( 'hd_basement_admin_js', HD_BASEMENT_URL . '/assets/js/hd-basement-script.js', array( 'jquery' ) );

	/* register the stylesheet */
	wp_enqueue_style( 'hd_basement_admin_css', HD_BASEMENT_URL . '/assets/css/hd-basement-style.css' );

}

add_action( 'admin_enqueue_scripts', 'hd_basement_enqueue_scripts' );