<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://www.call-from-web.com/
 * @since      4.0.0
 *
 * @package    Call_From_Web
 * @subpackage Call_From_Web/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Call_From_Web
 * @subpackage Call_From_Web/admin
 * @author     Call-From-Web.com <hello@call-from-web.com>
 */
class Call_From_Web_Admin {

  /**
   * The ID of this plugin.
   *
   * @since    4.0.0
   * @access   private
   * @var      string    $plugin_name    The ID of this plugin.
   */
  private $plugin_name;

  /**
   * The version of this plugin.
   *
   * @since    4.0.0
   * @access   private
   * @var      string    $version    The current version of this plugin.
   */
  private $version;

  /**
   * The domain of the plugin.
   *
   * @since    4.0.0
   * @access   private
   * @var      string    $version    The current domain of this plugin.
   */
  private $domain;

  /**
   * The domain used for API calls.
   *
   * @since    4.0.0
   * @access   private
   * @var      string    $version    The domain used for API calls.
   */
  private $api_domain;

  /**
   * Initialize the class and set its properties.
   *
   * @since    4.0.0
   * @param      string    $plugin_name       The name of this plugin.
   * @param      string    $version    The version of this plugin.
   * @param      string    $domain    The current domain of this plugin.
   */
  public function __construct( $plugin_name, $version, $domain, $api_domain ) {

    $this->plugin_name = $plugin_name;
    $this->version = $version;
    $this->domain = $domain;
    $this->api_domain = $api_domain;
    $this->development = get_site_url() == "http://localhost:8888";
  }

  /**
   * Register the stylesheets for the admin area.
   *
   * @since    4.0.0
   */
  public function enqueue_styles() {

    /**
     * This function is provided for demonstration purposes only.
     *
     * An instance of this class should be passed to the run() function
     * defined in Call_From_Web_Loader as all of the hooks are defined
     * in that particular class.
     *
     * The Call_From_Web_Loader will then create the relationship
     * between the defined hooks and the functions defined in this
     * class.
     */

    wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/call-from-web-admin.css', array(), $this->version, 'all' );

  }

  /**
   * Register the JavaScript for the admin area.
   *
   * @since    4.0.0
   */
  public function enqueue_scripts() {

    /**
     * This function is provided for demonstration purposes only.
     *
     * An instance of this class should be passed to the run() function
     * defined in Call_From_Web_Loader as all of the hooks are defined
     * in that particular class.
     *
     * The Call_From_Web_Loader will then create the relationship
     * between the defined hooks and the functions defined in this
     * class.
     */

    wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/call-from-web-admin.js', array( 'jquery' ), $this->version, false );

  }


  /**
   * Display error dialog when plugin not paired with Call From Web.
   *
   * @since    1.0.0
   */
  public function display_setup_prompt() {
    $pairing_token = get_option( 'cfw_pairing_token' );
    if ($pairing_token) { return; }

    $setup_url = admin_url( 'admin.php?page=cfw-redirect-to-finish-setup' );

    echo <<<HTML
      <div class="notice notice-error is-dismissible">
        <h2>Call From Web Setup</h2>
        <p>Thank you for installing Call From Web. Your setup is incomplete. Visit the <a href="$setup_url">setup page</a> and login/register with Call From Web to finish your setup.</p>
        <p><a href="$setup_url" class="button button-primary">Complete Setup</a></p>
      </div>
    HTML;
  }

  /**
   * Generate callback token for security and redirect to Call From Web pairing page.
   *
   * @since    1.0.0
   */
  public function redirect_to_finish_setup() {
    if ( ! isset( $_GET['page'] ) || $_GET['page'] !== 'cfw-redirect-to-finish-setup' ) {
    if ( !is_admin() ) { return; }
      return;
    }

    $callback_token = wp_generate_password(16, false, false);
    update_option( 'cfw_pairing_callback_token', $callback_token );

    $user = wp_get_current_user();

    $data = array(
      'callback_token' => $callback_token,
      'callback_url' => admin_url( 'admin.php?page=cfw-store-pairing-token' ),
      'complete_setup_url' => admin_url( 'admin.php?page=cfw-complete-setup' ),
      'email' => $user->user_email,
      'first_name' =>$user->user_firstname,
      'last_name' => $user->user_lastname,
      'site' => get_site_url(),
    );

    wp_redirect("https://" . $this->domain . "/extensions/wordpress/setup?" . http_build_query($data));
    exit;
  }

  /**
   * Store pairing token and redirect to account creation page on Call From Web.
   *
   * @since    1.0.0
   */
  public function store_pairing_token_and_redirect() {
    if ( ! isset( $_GET['page'] ) || $_GET['page'] !== 'cfw-store-pairing-token' ) { return; }
    if ( !is_admin() ) { return; }

    $returned_callback_token = $_GET['callback_token'];
    $stored_callback_token = get_option( 'cfw_pairing_callback_token' );

    if (!$stored_callback_token || $returned_callback_token !== $stored_callback_token) {
      wp_die( 'Invalid callback token' );
    }

    $pairing_token = $_GET['pairing_token'];
    $secret_key = $_GET['secret_key'];
    if (!$pairing_token || !$secret_key) { wp_die( 'Invalid pairing token or secret key' ); }
    update_option( 'cfw_pairing_token', $pairing_token );
    update_option( 'cfw_secret_key', $secret_key );

    wp_redirect($_GET['continue_to']);
    exit;
  }

  /**
   * Fetch profile id from Call From Web and store it.
   *
   * @since    1.0.0
   */
  public function complete_setup() {
    if ( ! isset( $_GET['page'] ) || $_GET['page'] !== 'cfw-complete-setup' ) { return; }
    if ( !is_admin() ) { return; }

    $pairing_token = get_option( 'cfw_pairing_token' );

    if (!$pairing_token) {
      wp_die( 'Invalid pairing token' );
    }

    // fetch profile key
    $endpoint = "{$this->api_domain}/api/wordpress_integrations";
    $headers = [
        "Authorization: Bearer $pairing_token",
        "Content-Type: application/json"
    ];

    // Make the API request
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $endpoint);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    if ($this->development) {
      curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
      curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    }

    $response = curl_exec($ch);
    $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    if ($response === false) {
      wp_die( 'Invalid response: ' . curl_error($ch));
    } else {
      $jsonData = json_decode($response);

      if ($jsonData !== null && isset($jsonData->profile)) {
        update_option( 'cfw_plugin_options', array('cfw_profile' => $jsonData->profile) );
      } else {
        wp_die("Invalid response");
      }
    }

    curl_close($ch);

    wp_redirect(admin_url());
    exit;
  }

}
