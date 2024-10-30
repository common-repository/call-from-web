<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://www.call-from-web.com/
 * @since      4.0.0
 *
 * @package    Call_From_Web
 * @subpackage Call_From_Web/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Call_From_Web
 * @subpackage Call_From_Web/public
 * @author     Call-From-Web.com <hello@call-from-web.com>
 */
class Call_From_Web_Public {

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
   * @var      string    $version    The current version of this plugin.
   */
  private $domain;

  /**
   * Initialize the class and set its properties.
   *
   * @since    4.0.0
   * @param      string    $plugin_name       The name of the plugin.
   * @param      string    $version    The version of this plugin.
	 * @param      string    $domain    The domain of this plugin.
   */
  public function __construct( $plugin_name, $version, $domain ) {

    $this->plugin_name = $plugin_name;
    $this->version = $version;
    $this->domain = $domain;

  }

  /**
   * Register the stylesheets for the public-facing side of the site.
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

    wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/call-from-web-public.css', array(), $this->version, 'all' );

  }

  /**
   * Register the JavaScript for the public-facing side of the site.
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

    wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/call-from-web-public.js', array( 'jquery' ), $this->version, false );

  }

  public function add_button_anchor() {
    $version = $this->version;
    $domain = $this->domain;

    $options = get_option('cfw_plugin_options');
    $profile = $options['cfw_profile'] ?? 'no_profile';
    $title = $options['cfw_button_title'] ?? 'Contact Us with Call From Web';

    echo <<<HTML
      <a href="https://{$domain}/request/{$profile}" id="call-from-web-button-{$profile}" data-plugin-version="{$version}">Contact Us with Call From Web</a>
      <script type="text/javascript">!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="https://{$domain}/button/v2/{$profile}.js";fjs.parentNode.insertBefore(js,fjs);}}(document,'script','call-from-web-v2-js');</script>
    HTML;
  }

}
