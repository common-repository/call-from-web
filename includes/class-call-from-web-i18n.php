<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://www.call-from-web.com/
 * @since      4.0.0
 *
 * @package    Call_From_Web
 * @subpackage Call_From_Web/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      4.0.0
 * @package    Call_From_Web
 * @subpackage Call_From_Web/includes
 * @author     Call-From-Web.com <hello@call-from-web.com>
 */
class Call_From_Web_i18n {


  /**
   * Load the plugin text domain for translation.
   *
   * @since    4.0.0
   */
  public function load_plugin_textdomain() {

    load_plugin_textdomain(
      'call-from-web',
      false,
      dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
    );

  }



}
