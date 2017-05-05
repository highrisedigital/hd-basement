<?php

if( ! class_exists( 'HD_Remove_Customizer' ) ) {
	
	/**
	 * class to remove the customizer
	 */
	class HD_Remove_Customizer {

		/**
		 * @var HD_Remove_Customizer
		 */
		private static $instance;

		/**
		 * Main Instance
		 *
		 * Allows only one instance of HD_Remove_Customizer in memory.
		 *
		 * @static
		 * @staticvar array $instance
		 * @return Big mama, HD_Remove_Customizer
		 */
		public static function instance() {
			if ( ! isset( self::$instance ) && ! ( self::$instance instanceof HD_Remove_Customizer ) ) {

				// Start your engines!
				self::$instance = new HD_Remove_Customizer;

				// Load the structures to trigger initially
				add_action( 'init', array( self::$instance, 'init' ), 10 ); // was priority 5
				add_action( 'admin_init', array( self::$instance, 'admin_init' ), 10 ); // was priority 5

			}
			return self::$instance;
		}

		/**
		 * Run all plugin stuff on init.
		 *
		 * @return void
		 */
		public function init() {

			// Remove customize capability
			add_filter( 'map_meta_cap', array( self::$instance, 'filter_to_remove_customize_capability'), 10, 4 );
		}

		/**
		 * Run all of our plugin stuff on admin init.
		 *
		 * @return void
		 */
		public function admin_init() {

			// Drop some customizer actions
			remove_action( 'plugins_loaded', '_wp_customize_include', 10);
			remove_action( 'admin_enqueue_scripts', '_wp_customize_loader_settings', 11);

			// Manually overrid Customizer behaviors
			add_action( 'load-customize.php', array( self::$instance, 'override_load_customizer_action') );
		}

		/**
		 * Remove customize capability
		 *
		 * This needs to be in public so the admin bar link for 'customize' is hidden.
		 */
		public function filter_to_remove_customize_capability( $caps = array(), $cap = '', $user_id = 0, $args = array() ) {
			if ($cap == 'customize') {
				return array('nope'); // thanks @ScreenfeedFr, http://bit.ly/1KbIdPg
			}

			return $caps;
		}

		/**
		 * Manually overriding specific Customizer behaviors
		 */
		public function override_load_customizer_action() {
			// If accessed directly
			wp_die( __( 'The Customizer is currently disabled.', 'wp-crap' ) );
		}

	} // End Class

} // end if function exists

/**
* The main function. Use like a global variable, except no need to declare the global.
*
* @return object The one true HD_Remove_Customizer Instance
*/
function hd_basement_remove_customizer() {
	
	// remove the customizer
	return HD_Remove_Customizer::instance();

}

hd_basement_remove_customizer();