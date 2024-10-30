<?php

/**
 * Fired during plugin activation
 *
 * @link       https://www.call-from-web.com/
 * @since      4.0.0
 *
 * @package    Call_From_Web
 * @subpackage Call_From_Web/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      4.0.0
 * @package    Call_From_Web
 * @subpackage Call_From_Web/includes
 * @author     Call-From-Web.com <hello@call-from-web.com>
 */
class Call_From_Web_Activator {

  private $activation_flag = 'cfw_activation_redirect';

  /**
   * Short Description. (use period)
   *
   * Long Description.
   *
   * @since    4.0.0
   */
  public static function activate() {
    $activator = new Call_From_Web_Activator();
    $activator->mark_for_activation_redirect();
  }

  /**
   * Mark for setup redirection.
   *
   * @since    4.0.2
  */
  private function mark_for_activation_redirect() {
    set_transient($this->activation_flag, true);
  }

  /**
   * Redirect user to activation page on www.call-from-web.com.
   *
   * Redirects if activation_flag is set
   *
   * @since    4.0.2
  */
  public function redirect_to_activation_page() {
    if ( !is_admin() ) { return; }

    $should_redirect = get_transient($this->activation_flag);
    if (!$should_redirect) {
        return;
    }
    delete_transient($this->activation_flag);

    $url = admin_url( 'admin.php?page=cfw-redirect-to-finish-setup' );
    $redirect_link =
        add_query_arg(
            array(),
            $url );

    $redirect_url = esc_url_raw( $redirect_link );
    wp_safe_redirect( $redirect_url );
    exit;
  }
}
