<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://example.com/laws-regulations
 * @since             1.0.0
 * @package           Laws_Regulations
 *
 * @wordpress-plugin
 * Plugin Name:       CFA Laws & Regulations
 * Plugin URI:        https://example.com/
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
 * Version:           1.1.0
 * Author:            Unknown
 * Author URI:        https://example.com/laws-regulations
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       laws-regulations
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
define( 'LAWS_REGULATIONS_VERSION', '1.1.0' );
define( 'LAWS_REGULATIONS_URL', plugin_dir_url( __FILE__ ) );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-laws-regulations-activator.php
 */
function activate_laws_regulations() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-laws-regulations-activator.php';
	Laws_Regulations_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-laws-regulations-deactivator.php
 */
function deactivate_laws_regulations() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-laws-regulations-deactivator.php';
	Laws_Regulations_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_laws_regulations' );
register_deactivation_hook( __FILE__, 'deactivate_laws_regulations' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-laws-regulations.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_laws_regulations() {
	function lr_thousandsShortFormat($num) {

		if($num>1000) {
	  
			  $x = round($num);
			  $x_number_format = number_format($x);
			  $x_array = explode(',', $x_number_format);
			  $x_parts = array('k', 'm', 'b', 't');
			  $x_count_parts = count($x_array) - 1;
			  $x_display = $x;
			  $x_display = $x_array[0] . ((int) $x_array[1][0] !== 0 ? '.' . $x_array[1][0] : '');
			  $x_display .= $x_parts[$x_count_parts - 1];
	  
			  return $x_display;
	  
		}
	  
		return $num;
	}
	
	$plugin = new Laws_Regulations();
	$plugin->run();

}
run_laws_regulations();
