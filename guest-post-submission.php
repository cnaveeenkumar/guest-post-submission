<?php
/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://profiles.wordpress.org/cnaveenkumar/
 * @since             1.0.0
 * @package           Guest_Post_Submission
 *
 * @wordpress-plugin
 * Plugin Name:       Guest Post Submission
 * Plugin URI:        https://github.com/cnaveeenkumar
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
 * Version:           1.0.0
 * Author:            Naveen Kumar C
 * Author URI:        https://profiles.wordpress.org/cnaveenkumar/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       guest-post-submission
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'GUEST_POST_SUBMISSION_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-guest-post-submission-activator.php
 */
function activate_guest_post_submission() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-guest-post-submission-activator.php';
	Guest_Post_Submission_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-guest-post-submission-deactivator.php
 */
function deactivate_guest_post_submission() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-guest-post-submission-deactivator.php';
	Guest_Post_Submission_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_guest_post_submission' );
register_deactivation_hook( __FILE__, 'deactivate_guest_post_submission' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-guest-post-submission.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_guest_post_submission() {

	$plugin = new Guest_Post_Submission();
	$plugin->run();

}
run_guest_post_submission();
