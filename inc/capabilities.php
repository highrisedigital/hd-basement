<?php
/**
 * add capabilities to edit to the plugin edit caps filter
 */
function hd_edit_default_caps( $caps ) {

	// prevent user from updating wordpress
	$caps[ 'update_core' ] = array(
		'name'		=> 'update_core',
		'action' 	=> false,
	);
	
	// prevent user from updating, activating and installing plugins
	$caps[ 'install_plugins' ] = array(
		'name'		=> 'install_plugins',
		'action'	=> false,
	);
	
	// prevent users from activating plugins
	$caps[ 'activate_plugins' ] = array(
		'name'		=> 'activate_plugins',
		'action'	=> false,
	);
	
	// prevent users from updating plugins
	$caps[ 'update_plugins' ] = array(
		'name'		=> 'update_plugins',
		'action'	=> false,
	);
	
	// prevent user from installing, activating or switching themes
	$caps[ 'update_themes' ] = array(
		'name'		=> 'update_themes',
		'action'	=> false,
	);
	
	// prevent user from installing themes
	$caps[ 'install_themes' ] = array(
		'name'		=> 'install_themes',
		'action'	=> false,
	);
	
	// prevent users from switching themes
	$caps[ 'switch_themes' ] = array(
		'name'		=> 'switch_themes',
		'action'	=> false,
	);
	
	// prevent users from editing themes
	$caps[ 'edit_themes' ] = array(
		'name'		=> 'edit_themes',
		'action'	=> false,
	);
	
	// return the modified caps
	return $caps;

}

add_filter( 'hd_basement_user_caps', 'hd_edit_default_caps' );

/**
 * 
 */
function hd_basement_edit_user_caps( $caps ) {

	// if the current user is not a hd user - do nothing
	if( is_hd_user() ) {
		return $caps;
	}

	// stop gravity forms adding the capabilities to this user
	//remove_filter( 'user_has_cap', array( 'RGForms', 'user_has_cap' ), 10, 3 );
	
	// setup an array of capabilities to change - filterable
	$hd_caps = apply_filters(
		'hd_basement_user_caps',
		array(), // filtered functions populate this with cap names and actions
		get_current_user_id()
	);

	// if we have no capabilities to filter
	if( empty( $hd_caps ) ) {
		return $caps;
	}
	
	// loop through each capability
	foreach( $hd_caps as $hd_cap ) {
		
		// check if the user has the capability
		if( ! empty( $caps[ $hd_cap[ 'name' ] ] ) ) {
		
			// action the capability - adding or remove accordingly
			$caps[ $hd_cap[ 'name' ] ] = $hd_cap[ 'action' ];
		
		}
		
	}

	// return the modified caps
	return $caps;

}

add_filter( 'user_has_cap', 'hd_basement_edit_user_caps', 1 );