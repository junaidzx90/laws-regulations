<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://example.com/laws-regulations
 * @since      1.0.0
 *
 * @package    Laws_Regulations
 * @subpackage Laws_Regulations/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Laws_Regulations
 * @subpackage Laws_Regulations/includes
 * @author     Unknown <admin@easeare.com>
 */
class Laws_Regulations_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'laws-regulations',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
