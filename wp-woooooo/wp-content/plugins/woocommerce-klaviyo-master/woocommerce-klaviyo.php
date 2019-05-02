<?php
/**
 * Plugin Name: Klaviyo for WooCommerce V2
 * Plugin URI: http://wordpress.org/extend/plugins/woocommerce-klaviyo/
 * Description: A plugin to automatically sync your WooCommerce sales, products and customers with Klaviyo. With Klaviyo you can set up abandoned cart emails, collect emails for your newsletter to grow your business.
 * Version: 2.0.1
 * Author: Klaviyo, Inc.
 * Author URI: https://www.klaviyo.com
 * Requires at least: 3.8
 * Tested up to: 4.9.8
 * WC requires at least: 2.0
 * WC tested up to: 3.5.0
 * Text Domain: woocommerce-klaviyo
 * Domain Path: /i18n/languages/
 *
 * @package WooCommerceKlaviyo
 * @category Core
 * @author Klaviyo
 */
if ( ! defined( 'ABSPATH' ) ) {
  exit; // Exit if accessed directly
}

if ( ! function_exists('is_plugin_inactive')) {
    require_once( ABSPATH . '/wp-admin/includes/plugin.php' );
}

if(is_plugin_inactive( 'woocommerce/woocommerce.php')) {return;}

if (is_plugin_active('klaviyo/klaviyo.php')) {
    //plugin is activated
    die('Klaviyo now bundles the wordpress plugin and the Woocommerce plugin. Please deactivate or remove the Klaviyo Wordpress plugin and re activate the Klaviyo for WooCommerce plugin.');
}

if ( ! class_exists( 'WooCommerceKlaviyo' ) ) :

/**
 * Main WooCommerceKlaviyo Class
 *
 * @class WooCommerceKlaviyo
 * @version 2.0.1
 */
final class WooCommerceKlaviyo {

  /**
   * @var string
   */
  public static $version = '2.0.1';

  /**
   * @var WooCommerceKlaviyo The single instance of the class
   * @since 2.0.0
   */
  protected static $_instance = null;

  /**
   * Get plugin version number.
   *
   * @since 2.0.0
   * @static
   * @return int
   */
  public static function getVersion() {
    return self::$version;
  }

  /**
   * Main WooCommerceKlaviyo Instance
   *
   * Ensures only one instance of WooCommerceKlaviyo is loaded or can be loaded.
   *
   * @since 2.0.0
   * @static
   * @see WCK()
   * @return WooCommerceKlaviyo - Main instance
   */
  public static function instance() {
    if ( is_null( self::$_instance ) ) {
      self::$_instance = new self();
    }
    return self::$_instance;
  }

  /**
   * Cloning is forbidden.
   *
   * @since 2.1
   */
  public function __clone() {
    _doing_it_wrong( __FUNCTION__, __( 'Cheatin&#8217; huh?', 'woocommerce-klaviyo' ), '0.9' );
  }

  /**
   * Unserializing instances of this class is forbidden.
   *
   * @since 2.1
   */
  public function __wakeup() {
    _doing_it_wrong( __FUNCTION__, __( 'Cheatin&#8217; huh?', 'woocommerce-klaviyo' ), '0.9' );
  }

  /**
   * WooCommerceKlaviyo Constructor.
   * @access public
   * @return WooCommerceKlaviyo
   */
  public function __construct() {
    // Auto-load classes on demand
    if ( function_exists( "__autoload" ) ) {
      spl_autoload_register( "__autoload" );
    }

    spl_autoload_register( array( $this, 'autoload' ) );

    $this->define_constants();

    // Include required files
    $this->includes();

    // Init API
    $this->api = new WCK_API();

    // Hooks
    add_action( 'init', array( $this, 'init' ), 0 );
    // add_action( 'init', array( $this, 'include_template_functions' ) );

    // Loaded action
    do_action( 'woocommerce_klaviyo_loaded' );
  }

  /**
   * Auto-load in-accessible properties on demand.
   *
   * @param mixed $key
   * @return mixed
   */
  public function __get( $key ) {
    if ( method_exists( $this, $key ) ) {
      return $this->$key();
    }
    return false;
  }

  /**
   * Auto-load WC classes on demand to reduce memory consumption.
   *
   * @param mixed $class
   * @return void
   */
  public function autoload( $class ) {
    $path  = null;
    $class = strtolower( $class );
    $file = 'class-' . str_replace( '_', '-', $class ) . '.php';

    if ( $path && is_readable( $path . $file ) ) {
      include_once( $path . $file );
      return;
    }

    // Fallback
    if ( strpos( $class, 'wck_' ) === 0 ) {
      $path = $this->plugin_path() . '/includes/';
    }

    if ( $path && is_readable( $path . $file ) ) {
      include_once( $path . $file );
      return;
    }
  }

   // Define WC Constants

  private function define_constants() {
    define( 'WCK_PLUGIN_FILE', __FILE__ );
    define( 'WCK_VERSION', $this->version );

    // if ( ! defined( 'WCK_TEMPLATE_PATH' ) ) {
    //   define( 'WCK_TEMPLATE_PATH', $this->template_path() );
    // }
  }

   // Include required core files used in admin and on the frontend.


  private function includes() {
    include_once( 'includes/wck-core-functions.php' );
    include_once( 'includes/class-wck-install.php' );
  }

  /**
   * Function used to Init WooCommerce Template Functions - This makes them pluggable by plugins and themes.
   */
  // public function include_template_functions() {
  //   include_once( 'includes/wc-template-functions.php' );
  // }

  /**
   * Init WooCommerceKlaviyo when WordPress Initialises.
   */
  public function init() {
    // Init action
    do_action( 'woocommerce_klaviyo_init' );
  }

  /**
   * Get the plugin url.
   *
   * @return string
   */
  public function plugin_url() {
    return untrailingslashit( plugins_url( '/', __FILE__ ) );
  }

  /**
   * Get the plugin path.
   *
   * @return string
   */
  public function plugin_path() {
    return untrailingslashit( plugin_dir_path( __FILE__ ) );
  }

}

endif;

/**
 * Returns the main instance of WCK to prevent the need to use globals.
 *
 * @since  0.9
 * @return WooCommerceKlaviyo
 */
function WCK() {
  return WooCommerceKlaviyo::instance();
}

// Global for backwards compatibility.
$GLOBALS['woocommerce-klaviyo'] = WCK();

// load the wordpress tracking and widgets

// Makes sure the plugin is defined before trying to use it

$url = plugins_url();

if ( ! function_exists('is_plugin_inactive')) {
    require_once( ABSPATH . '/wp-admin/includes/plugin.php' );
}

if (is_plugin_inactive('wordpress-klaviyo-master/klaviyo.php')) {
    //plugin is not activated

$my_plugin_file = __FILE__;

if (isset($plugin)) {
    $my_plugin_file = $plugin;
}
else if (isset($mu_plugin)) {
    $my_plugin_file = $mu_plugin;
}
else if (isset($network_plugin)) {
    $my_plugin_file = $network_plugin;
}


//
// CONSTANTS
// ------------------------------------------
if (!defined('KLAVIYO_URL')) {
    define('KLAVIYO_URL', plugin_dir_url($my_plugin_file));
}
if (!defined('KLAVIYO_PATH')) {
    define('KLAVIYO_PATH', WP_PLUGIN_DIR . '/' . basename(dirname($my_plugin_file)) . '/');
}
if (!defined('KLAVIYO_BASENAME')) {
    define('KLAVIYO_BASENAME', plugin_basename($my_plugin_file));
}
if (!defined('KLAVIYO_ADMIN')) {
    define('KLAVIYO_ADMIN', admin_url());
}
if (!defined('KLAVIYO_PLUGIN_VERSION' ) ) {
    define('KLAVIYO_PLUGIN_VERSION', '1.3');
}

//
// INCLUDES
// ------------------------------------------
require_once(KLAVIYO_PATH . 'inc/kla-analytics.php');
require_once(KLAVIYO_PATH . 'inc/kla-admin.php');
require_once(KLAVIYO_PATH . 'inc/kla-widgets.php');
require_once(KLAVIYO_PATH . 'inc/kla-notice.php');
require_once(KLAVIYO_PATH . 'inc/kla-popup.php');




//
// HELPER CLASS - WPKlaviyo
// ------------------------------------------

class WPKlaviyo {

    public static function is_connected($public_api_key='') {
        if (trim($public_api_key) != '') {
            return true;
        } else {
            $klaviyo_settings = get_option('klaviyo_settings');
            if (trim($klaviyo_settings['public_api_key']) != '') {
                return true;
            } else {
                return false;
            }
        }
    }

    function __construct() {
        global $klaviyowp_admin, $klaviyowp_notice, $klaviyowp_analytics, $klaviyowp_tracking;
        global $post;

        $klaviyowp_admin = new WPKlaviyoAdmin();

        $klaviyowp_analytics = new WPKlaviyoAnalytics();

        $klaviyowp_analytics = new WPKlaviyoPopup();

        // Display config message.
        $klaviyowp_message = new WPKlaviyoNotification();
        add_action('admin_notices', array(&$klaviyowp_message, 'config_warning'));

        $klwidget = function($name) {
			return register_widget("Klaviyo_EmailSignUp_Widget");
		};

		add_action('widgets_init', $klwidget);
    }

    function add_defaults() {
        $klaviyo_settings = get_option('klaviyo_settings');

        if (($klaviyo_settings['installed'] != 'true') || !is_array($klaviyo_settings)) {
            $klaviyo_settings = array(
                'installed' => 'true',
                'public_api_key' => '',
                'klaviyo_newsletter_list_id' => '',
                'admin_settings_message' => '',
                'klaviyo_newsletter_text' => '',
                'klaviyo_popup' => ''
            );
            update_option('klaviyo_settings', $klaviyo_settings);
        }
    }

    function format_text($content, $br=true) {
        return $content;
    }
}



//
// INIT
// ------------------------------------------

global $klaviyowp;
$klaviyowp = new WPKlaviyo();
// RegisterDefault settings
register_activation_hook(__FILE__, array( $klaviyowp, 'add_defaults'));

}