<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://www.call-from-web.com/
 * @since             4.0.0
 * @package           Call_From_Web
 *
 * @wordpress-plugin
 * Plugin Name:       Call From Web
 * Plugin URI:        https://www.call-from-web.com
 * Description:       Let your visitors call you by phone for free.
 * Version:           4.0.2
 * Author:            Call-From-Web.com
 * Author URI:        https://www.call-from-web.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       call-from-web
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
  die;
}

/**
 * Currently plugin version.
 * Start at version 4.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'CALL_FROM_WEB_VERSION', '4.0.2' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-call-from-web-activator.php
 */
function activate_call_from_web() {
  require_once plugin_dir_path( __FILE__ ) . 'includes/class-call-from-web-activator.php';
  Call_From_Web_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-call-from-web-deactivator.php
 */
function deactivate_call_from_web() {
  require_once plugin_dir_path( __FILE__ ) . 'includes/class-call-from-web-deactivator.php';
  Call_From_Web_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_call_from_web' );
register_deactivation_hook( __FILE__, 'deactivate_call_from_web' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-call-from-web.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    4.0.0
 */
function run_call_from_web() {

  $plugin = new Call_From_Web();
  $plugin->run();

}
run_call_from_web();
