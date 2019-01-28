<?php

/**
 * The plugin bootstrap file
 *
 * @link              https://delay-delo.com/
 * @since             1.0.0
 * @package           Wp_Clear
 *
 * @wordpress-plugin
 * Plugin Name:       Wp clear
 * Plugin URI:        https://delay-delo.com/
 * Description:       A simple plugin removes unnecessary code from wp_head. Allows you to disable emoji and wp-embed
 * Version:           1.0.0
 * Author:            Alexey Rtishchev
 * Author URI:        https://delay-delo.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       wp-clear
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
define( 'PLUGIN_NAME_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-wp-clear-activator.php
 */
function activate_wp_clear() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-wp-clear-activator.php';
	Wp_Clear_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-wp-clear-deactivator.php
 */
function deactivate_wp_clear() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-wp-clear-deactivator.php';
	Wp_Clear_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_wp_clear' );
register_deactivation_hook( __FILE__, 'deactivate_wp_clear' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-wp-clear.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_wp_clear() {

	$plugin = new Wp_Clear();
	$plugin->run();

}
run_wp_clear();
