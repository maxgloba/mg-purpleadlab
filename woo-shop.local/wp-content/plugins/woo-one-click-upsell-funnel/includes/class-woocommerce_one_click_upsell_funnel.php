<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       http://makewebbetter.com/
 * @since      1.0.0
 *
 * @package    Woocommerce_one_click_upsell_funnel
 * @subpackage Woocommerce_one_click_upsell_funnel/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Woocommerce_one_click_upsell_funnel
 * @subpackage Woocommerce_one_click_upsell_funnel/includes
 * @author     makewebbetter <webmaster@makewebbetter.com>
 */
class Woocommerce_one_click_upsell_funnel {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Woocommerce_one_click_upsell_funnel_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {
		
		if ( defined( 'MWB_WOCUF_VERSION' ) ) {
			$this->version = MWB_WOCUF_VERSION;
		} else {
			$this->version = '2.0.0';
		}

		$this->plugin_name = 'woocommerce-one-click-upsell-funnel';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();

	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Woocommerce_one_click_upsell_funnel_Loader. Orchestrates the hooks of the plugin.
	 * - Woocommerce_one_click_upsell_funnel_i18n. Defines internationalization functionality.
	 * - Woocommerce_one_click_upsell_funnel_Admin. Defines all hooks for the admin area.
	 * - Woocommerce_one_click_upsell_funnel_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-woocommerce_one_click_upsell_funnel-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-woocommerce_one_click_upsell_funnel-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-woocommerce_one_click_upsell_funnel-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-woocommerce_one_click_upsell_funnel-public.php';

		/**
		 * The file responsible for defining global plugin functions.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-woocommerce_one_click_upsell_funnel-global_functions.php';


		$this->loader = new Woocommerce_one_click_upsell_funnel_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Woocommerce_one_click_upsell_funnel_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Woocommerce_one_click_upsell_funnel_i18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new Woocommerce_one_click_upsell_funnel_Admin( $this->get_plugin_name(), $this->get_version() );

		$mwb_wocuf_enable_plugin = get_option( "mwb_wocuf_enable_plugin", "on" );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );
				
		$this->loader->add_action( 'admin_menu', $plugin_admin, 'mwb_wocuf_pro_admin_menu' );

		$this->loader->add_action( 'wp_ajax_seach_products_for_offers', $plugin_admin, 'seach_products_for_offers' );

		$this->loader->add_action( 'wp_ajax_seach_products_for_funnel', $plugin_admin, 'seach_products_for_funnel' );

		// Dismiss Elementor inactive notice.
		$this->loader->add_action( 'wp_ajax_mwb_upsell_dismiss_elementor_inactive_notice', $plugin_admin, 'dismiss_elementor_inactive_notice' );

		// Hide Upsell offer pages in admin panel 'Pages'.
		$this->loader->add_action( 'pre_get_posts', $plugin_admin, 'hide_upsell_offer_pages_in_admin' );

		

		$this->loader->add_filter( 'page_template', $plugin_admin, 'mwb_wocuf_pro_page_template' );

		// Create new offer - ajax handle function.
		$this->loader->add_action( 'wp_ajax_mwb_wocuf_pro_return_offer_content', $plugin_admin, 'return_funnel_offer_section_content' );

		// Insert and Activate respective template ajax handle function.
		$this->loader->add_action( 'wp_ajax_mwb_upsell_activate_offer_template_ajax', $plugin_admin, 'activate_respective_offer_template' );

		if( $mwb_wocuf_enable_plugin === "on" ) {

			// Adding Upsell Orders column in Orders table in backend.
			$this->loader->add_filter( 'manage_edit-shop_order_columns', $plugin_admin, 'mwb_wocuf_pro_add_columns_to_admin_orders', 11 );

			// Populating Upsell Orders column with Single Order or Upsell order.
			$this->loader->add_action( 'manage_shop_order_posts_custom_column', $plugin_admin, 'mwb_wocuf_pro_populate_upsell_order_column', 10, 2 );

			// Add Upsell Filtering dropdown for All Orders, No Upsell Orders, Only Upsell Orders.
			$this->loader->add_filter( 'restrict_manage_posts', $plugin_admin, 'mwb_wocuf_pro_restrict_manage_posts' );

			// Modifying query vars for filtering Upsell Orders.
			$this->loader->add_filter( 'request', $plugin_admin, 'mwb_wocuf_pro_request_query' );

			// Add 'Upsell Support' column on payment gateways page.
			$this->loader->add_filter( 'woocommerce_payment_gateways_setting_columns', $plugin_admin, 'upsell_support_in_payment_gateway' );
			
			// 'Upsell Support' content on payment gateways page.
			$this->loader->add_action( 'woocommerce_payment_gateways_setting_column_mwb_upsell', $plugin_admin, 'upsell_support_content_in_payment_gateway' );

		}

	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new Woocommerce_one_click_upsell_funnel_Public( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );

		// Set cron recurrence time for 'mwb_wocuf_twenty_minutes' schedule.
		$this->loader->add_filter( 'cron_schedules', $plugin_public, 'set_cron_schedule_time' );

		// Redirect upsell offer pages if not admin or upsell nonce expired.
		$this->loader->add_action( 'template_redirect', $plugin_public, 'upsell_offer_page_redirect' );

		// Hide upsell offer pages from nav menu front-end.
		$this->loader->add_filter( 'wp_page_menu_args', $plugin_public, 'exclude_pages_from_front_end', 99 );

		// Hide upsell offer pages from added menu list in customizer and admin panel.
		$this->loader->add_filter( 'wp_get_nav_menu_items', $plugin_public, 'exclude_pages_from_menu_list', 10, 3 );

		$mwb_upsell_global_settings = get_option( 'mwb_upsell_lite_global_options', array() );
										
		$remove_all_styles = !empty( $mwb_upsell_global_settings['remove_all_styles'] ) ? $mwb_upsell_global_settings['remove_all_styles'] : 'yes';

		if( 'yes' == $remove_all_styles && mwb_upsell_lite_elementor_plugin_active() ) {

			// Remove styles from offer pages.
			$this->loader->add_action( 'wp_print_styles', $plugin_public, 'remove_styles_offer_pages' );
		}

		$this->loader->add_action( 'init', $plugin_public, 'upsell_shortcodes' );
		

		$mwb_wocuf_enable_plugin = get_option( "mwb_wocuf_enable_plugin", "on" );

		if( $mwb_wocuf_enable_plugin === "on" ) {

			// Initiate Upsell Orders before processing payment.
			$this->loader->add_action( 'woocommerce_checkout_order_processed', $plugin_public, 'mwb_wocuf_initate_upsell_orders' );

			// When user clicks on No thanks for Upsell offer.
			! is_admin() && $this->loader->add_action( 'wp_loaded', $plugin_public, 'mwb_wocuf_pro_process_the_funnel' );
			
			// When user clicks on Add upsell product to my Order.
			! is_admin() && $this->loader->add_action( 'wp_loaded', $plugin_public, 'mwb_wocuf_pro_charge_the_offer' );

			// Define Cron schedule fire Event for Order payment process.
			$this->loader->add_action( 'mwb_wocuf_lite_order_cron_schedule', $plugin_public, 'order_payment_cron_fire_event' );

			// Global Custom CSS.
			$this->loader->add_action( 'wp_head', $plugin_public, 'global_custom_css' );

			// Global custom JS.
			$this->loader->add_action( 'wp_footer', $plugin_public, 'global_custom_js' );

		}
	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Woocommerce_one_click_upsell_funnel_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

	public function mwb_wocuf_woocommerce_version_check() {

		require_once( ABSPATH . 'wp-content/plugins/woocommerce/woocommerce.php' );
		
		global $woocommerce;
	
		return $woocommerce->version;
		
	}
}
