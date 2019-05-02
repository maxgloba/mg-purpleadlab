<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    Mg_Shop
 * @subpackage Mg_Shop/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Mg_Shop
 * @subpackage Mg_Shop/admin
 * @author     Your Name <email@example.com>
 */
class Mg_Shop_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $mg_shop    The ID of this plugin.
	 */
	private $mg_shop;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $mg_shop       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $mg_shop, $version ) {

		$this->mg_shop = $mg_shop;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Mg_Shop_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Mg_Shop_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->mg_shop, plugin_dir_url( __FILE__ ) . 'css/mg-shop-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Mg_Shop_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Mg_Shop_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->mg_shop, plugin_dir_url( __FILE__ ) . 'js/mg-shop-admin.js', array( 'jquery' ), $this->version, false );

	}

}

// Add custom MG Shop page in Admin
function add_mgshop() {
	add_menu_page('MG Shop Page', 'MG Shop', 0, 'mg_shop', 'render_mg_shop_page', 'dashicons-products', 5);
	add_submenu_page("mg_shop", "Reports", "Reports", 0, "mg_shop_reports", "render_mg_shop_reports_page");
}
add_action('admin_menu', 'add_mgshop');

// MG Shop page function
function render_mg_shop_page() {
	echo '<center><h1>Welcome to MG Shop Plugin!</h1></center>';
}

// Reports page function
function render_mg_shop_reports_page() {
	echo '
<ul id="report-nav">
	<li data-tab="year" class="active">Year</li>
	<li data-tab="lmonth">Last month</li>
	<li data-tab="tmonth">This month</li>
	<li data-tab="ldays">Last 7 days</li>
	<li data-tab="cdate">Custom date</li>
</ul>
<div class="report-tab report-tab-year active">
	<ul>
		<li>- Total: <span>0</span></li>
		<li>- Sent: <span>0</span></li>
		<li>- Canceled: <span>0</span></li>
		<li>- Worth: <span>0</span></li>
	</ul>
</div>
<div class="report-tab report-tab-lmonth">
	<ul>
		<li>- Total: <span>0</span></li>
		<li>- Sent: <span>0</span></li>
		<li>- Canceled: <span>0</span></li>
		<li>- Worth: <span>0</span></li>
	</ul>
</div>
<div class="report-tab report-tab-tmonth">
	<ul>
		<li>- Total: <span>0</span></li>
		<li>- Sent: <span>0</span></li>
		<li>- Canceled: <span>0</span></li>
		<li>- Worth: <span>0</span></li>
	</ul>
</div>
<div class="report-tab report-tab-ldays">
	<ul>
		<li>- Total: <span>0</span></li>
		<li>- Sent: <span>0</span></li>
		<li>- Canceled: <span>0</span></li>
		<li>- Worth: <span>0</span></li>
	</ul>
</div>
<div class="report-tab report-tab-cdate">
	<ul>
		<li>- Total: <span>0</span></li>
		<li>- Sent: <span>0</span></li>
		<li>- Canceled: <span>0</span></li>
		<li>- Worth: <span>0</span></li>
	</ul>
</div>


<div class="row" id="mg_shop_order_info">
	<div class="col-md-6">
		<div id="mg_shop_customer">Customer: <span>Max Globa</span></div>
		<div id="mg_shop_email">Email: <span>onyx18121990@gmail.com</span></div>
		<div id="mg_shop_hone">Phone: <span>+380731817768</span></div>
		<div id="mg_shop_payment">
			Payment via:
			<span id="mg_paypal">PayPal</span>
			<span id="mg_credit" style="display: none;">Visa/Mastercard</span>
		</div>
	</div>
	<div class="col-md-6">
		<div id="mg_shop_status">
			Status:
			<span>
				<select name="status" id="status">
					<option value="pending payment">pending payment</option>
					<option value="processing">processing</option>
					<option value="on hold">on hold</option>
					<option value="completed">completed</option>
					<option value="cancelled">cancelled</option>
					<option value="refunded">refunded</option>
					<option value="failed">failed</option>
				</select>
			</span>
		</div>
		<div id="mg_shop_billing">
			Billing:
			<span>Lorem ipsum <br> Lorem ipsum <br> Lorem ipsum <br> Lorem, NY 94000</span>
		</div>
		<div id="mg_shop_shipping">
			Shipping: <span>Lorem ipsum <br> Lorem ipsum <br> Lorem ipsum <br> Lorem, NY 94000</span>
		</div>
	</div>
</div>

';
}

// Init Products CPT
add_action( 'init', 'codex_mg_shop_products_init' );
function codex_mg_shop_products_init() {
	$args = array(
		'labels'             => array(
									'all_items' => __( 'Products', 'mg_shop' ),
									'name' => __( 'Products', 'mg_shop' ),
								),
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => 'mg_shop',
		'query_var'          => true,
		'rewrite'            => array( 'slug' => 'mg_shop_products' ),
		'capability_type'    => 'post',
		'has_archive'        => false,
		'hierarchical'       => false,
		'menu_position'      => 1,
		'supports'           => array( 'title', 'editor', 'thumbnail' )
	);
	register_post_type( 'mg_shop_products', $args );
}

// Init Orders CPT
add_action( 'init', 'codex_mg_shop_orders_init' );
function codex_mg_shop_orders_init() {
	$args = array(
		'labels'             => array(
									'all_items' => __( 'Orders', 'mg_shop' ),
									'name' => __( 'Orders', 'mg_shop' ),
								),
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => 'mg_shop',
		'query_var'          => true,
		'rewrite'            => array( 'slug' => 'mg_shop_orders' ),
		'capability_type'    => 'post',
		'has_archive'        => false,
		'hierarchical'       => false,
		'menu_position'      => 2,
		'supports'           => array( 'title', 'editor', 'excerpt' )
	);
	register_post_type( 'mg_shop_orders', $args );
}

