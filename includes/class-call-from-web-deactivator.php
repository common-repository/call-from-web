<?php

/**
 * Fired during plugin deactivation
 *
 * @link       https://www.call-from-web.com/
 * @since      4.0.0
 *
 * @package    Call_From_Web
 * @subpackage Call_From_Web/includes
 */

/**
 * Fired during plugin deactivation.
 *
 * This class defines all code necessary to run during the plugin's deactivation.
 *
 * @since      4.0.0
 * @package    Call_From_Web
 * @subpackage Call_From_Web/includes
 * @author     Call-From-Web.com <hello@call-from-web.com>
 */
class Call_From_Web_Deactivator {

  /**
   * Short Description. (use period)
   *
   * Long Description.
   *
   * @since    4.0.0
   */
  public static function deactivate() {
    update_option( 'cfw_pairing_token', null );
    update_option( 'cfw_secret_key', null );
    update_option( 'cfw_pairing_callback_token', null );
  }
}
