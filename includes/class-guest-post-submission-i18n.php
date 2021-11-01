<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://profiles.wordpress.org/cnaveenkumar/
 * @since      1.0.0
 *
 * @package    Guest_Post_Submission
 * @subpackage Guest_Post_Submission/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Guest_Post_Submission
 * @subpackage Guest_Post_Submission/includes
 * @author     Naveen Kumar C <cnaveen777@gmail.com>
 */
class Guest_Post_Submission_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'guest-post-submission',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
