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

		wp_enqueue_style( 'ui-styles', plugin_dir_url( __FILE__ ) . 'css/ui/jquery-ui.min.css' );
		wp_enqueue_style( $this->mg_shop, plugin_dir_url( __FILE__ ) . 'css/mg-shop-admin.css', array('ui-styles'), $this->version, 'all' );

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

		wp_enqueue_script( 'ui-core', plugin_dir_url( __FILE__ ) . 'js/ui/jquery.ui.core.min.js', array( 'jquery' ) );
		wp_enqueue_script( 'ui-date', plugin_dir_url( __FILE__ ) . 'js/ui/jquery.ui.datepicker.min.js', array( 'jquery' ) );
		wp_enqueue_script( $this->mg_shop, plugin_dir_url( __FILE__ ) . 'js/mg-shop-admin.js', array( 'jquery', 'ui-core', 'ui-date' ), $this->version, false );
		wp_localize_script($this->mg_shop, 'myScript', array(
			'pluginsUrl' => plugins_url(),
		));

	}

}

// Add Shortcode [shop-products posts=”5″]
function shop_products( $atts , $content = null ) {

	// Attributes
	$args = array(
		'post_type'      => 'mg_shop_products',
		'posts_per_page' => 3,
		'orderby'        => 'date',
		'order'          => 'ASC'
	);
	$myQuery = new WP_Query($args);

	$output = '<div id="shop_products">';
	while ($myQuery->have_posts()): $myQuery->the_post();
		$output .= '<div id="product_'. get_the_ID() .'" class="product product-'. get_the_ID() .'">';
		$output .= '<h2>' . get_the_title() . '</h2>';
		$output .= '<img src="'. get_the_post_thumbnail_url() .'" alt="'. get_the_title() .'">';
		$output .= '<p>' . get_the_content() . '</p>';
		$output .= '</div>';
	endwhile;
	$output .= '</div>';

	wp_reset_postdata();

	return $output;

}
add_shortcode( 'shop-products', 'shop_products' );

// Add custom MG Shop page in Admin
function add_mgshop() {
	add_menu_page('MG Shop Page', 'Shop', 0, 'mg_shop', 'render_mg_shop_page', 'dashicons-products', 5);
	add_submenu_page("mg_shop", "Orders", "Orders", 0, "mg_shop_orders", "render_mg_shop_orders_page");
	add_submenu_page("mg_shop", "Reports", "Reports", 0, "mg_shop_reports", "render_mg_shop_reports_page");
}
add_action('admin_menu', 'add_mgshop');

// MG Shop page function
function render_mg_shop_page() {
	echo '<center><h1>Welcome to MG Shop Plugin!</h1></center>';
}

// Reports page function
function render_mg_shop_reports_page() {

	global $wpdb;
	$table_name = $wpdb->prefix . "mgshop_orders";

	$pdf = new DateTime('first day of previous month');
	$pdl = new DateTime('last day of previous month');
	$pmonth_fd = $pdf->format('Y-m-d');
	$pmonth_ld = $pdl->format('Y-m-d');

	$df = new DateTime('first day of this month');
	$dl = new DateTime('last day of this month');
	$tmonth_fd = $df->format('Y-m-d');
	$tmonth_ld = $dl->format('Y-m-d');

	$sdf = date('Y-m-d', strtotime('-6 days'));
	$sdl = date('Y-m-d');

	echo '
		<div id="mg_order_sorting">
			<div id="mg_shop_order_info">
				<ul class="report-nav">
					<li data-tab="tab1" class="active">Full report</li>
					<li data-tab="tab2">Year</li>
					<li data-tab="tab3">Last month</li>
					<li data-tab="tab4">This month</li>
					<li data-tab="tab5">Last 7 days</li>
					<li data-tab="tab6">Custom date</li>
				</ul>
				<div class="report-tab report-tab1 active">
					<ul>
						<li>
							Sales in this period:
							<span>
	';
								$sales_period = $wpdb->get_results("SELECT price FROM $table_name");
								foreach($sales_period as $sales_periods){
									$sales += substr($sales_periods->price, 1);
								}
								echo $sales;
	echo '					$</span>
						</li>
						<li>
							Orders placed:
							<span>
	';
								$orders_placed = $wpdb->get_results("SELECT * FROM $table_name");
								echo( sizeof($orders_placed) );
	echo '					</span>
						</li>
						<li>
							Platinum Package:
							<span>
	';
								$products_purchased = $wpdb->get_results("SELECT post_content FROM $table_name WHERE post_content = 'Platinum Package' ");
								echo( sizeof($products_purchased) );
	echo '
							</span>
						</li>
						<li>
							Premium Package:
							<span>
	';
								$products_purchased = $wpdb->get_results("SELECT post_content FROM $table_name WHERE post_content = 'Premium Package' ");
								echo( sizeof($products_purchased) );
	echo '
							</span>
						</li>
						<li>
							Starter Package:
							<span>
	';
								$products_purchased = $wpdb->get_results("SELECT post_content FROM $table_name WHERE post_content = 'Starter Package' ");
								echo( sizeof($products_purchased) );
	echo '
							</span>
						</li>
					</ul>
				</div>
				<div class="report-tab report-tab2">
					<ul>
						<li>
							Sales in this period:
							<span>
	';
								$sales_period = $wpdb->get_results("SELECT * FROM $table_name WHERE DATE_SUB(NOW(), INTERVAL 1 YEAR) ");
								foreach($sales_period as $sales_periods){
									$sales_year += substr($sales_periods->price, 1);
								}
								echo $sales_year;
	echo '					$</span>
						</li>
						<li>
							Orders placed:
							<span>
	';
								$orders_placed = $wpdb->get_results("SELECT * FROM $table_name WHERE DATE_SUB(NOW(), INTERVAL 1 YEAR)");
								echo( sizeof($orders_placed) );

	echo '					</span>
						</li>
						<li>
							Platinum Package:
							<span>
	';
								$products_purchased = $wpdb->get_results("SELECT * FROM $table_name WHERE post_content = 'Platinum Package' AND DATE_SUB(NOW(),INTERVAL 1 YEAR) ");
								echo( sizeof($products_purchased) );
	echo '
							</span>
						</li>
						<li>
							Premium Package:
							<span>
	';
								$products_purchased = $wpdb->get_results("SELECT * FROM $table_name WHERE post_content = 'Premium Package' AND DATE_SUB(NOW(),INTERVAL 1 YEAR) ");
								echo( sizeof($products_purchased) );
	echo '
							</span>
						</li>
						<li>
							Starter Package:
							<span>
	';
								$products_purchased = $wpdb->get_results("SELECT * FROM $table_name WHERE post_content = 'Starter Package' AND DATE_SUB(NOW(),INTERVAL 1 YEAR) ");
								echo( sizeof($products_purchased) );
	echo '
							</span>
						</li>
					</ul>
				</div>
				<div class="report-tab report-tab3">
					<ul>
						<li>
							Sales in this period:
							<span>
	';
								$sales_period = $wpdb->get_results("SELECT * FROM $table_name WHERE date BETWEEN STR_TO_DATE('$pmonth_fd 00:00:00', '%Y-%m-%d %H:%i:%s') AND STR_TO_DATE('$pmonth_ld 23:59:59', '%Y-%m-%d %H:%i:%s')");
								foreach($sales_period as $sales_periods){
									$sales_tmonth += substr($sales_periods->price, 1);
								}
								echo $sales_tmonth;
	echo '					$</span>
						</li>
						<li>
							Orders placed:
							<span>
	';
								$orders_placed = $wpdb->get_results("SELECT * FROM $table_name WHERE date BETWEEN STR_TO_DATE('$pmonth_fd 00:00:00', '%Y-%m-%d %H:%i:%s') AND STR_TO_DATE('$pmonth_ld 23:59:59', '%Y-%m-%d %H:%i:%s')");
								echo( sizeof($orders_placed) );
	echo '					</span>
						</li>
						<li>
							Platinum Package:
							<span>
	';
								$products_purchased = $wpdb->get_results("SELECT * FROM $table_name WHERE post_content = 'Platinum Package' AND date BETWEEN STR_TO_DATE('$pmonth_fd 00:00:00', '%Y-%m-%d %H:%i:%s') AND STR_TO_DATE('$pmonth_ld 23:59:59', '%Y-%m-%d %H:%i:%s')");
								echo( sizeof($products_purchased) );
	echo '
							</span>
						</li>
						<li>
							Premium Package:
							<span>
	';
								$products_purchased = $wpdb->get_results("SELECT * FROM $table_name WHERE post_content = 'Premium Package' AND date BETWEEN STR_TO_DATE('$pmonth_fd 00:00:00', '%Y-%m-%d %H:%i:%s') AND STR_TO_DATE('$pmonth_ld 23:59:59', '%Y-%m-%d %H:%i:%s')");
								echo( sizeof($products_purchased) );
	echo '
							</span>
						</li>
						<li>
							Starter Package:
							<span>
	';
								$products_purchased = $wpdb->get_results("SELECT * FROM $table_name WHERE post_content = 'Starter Package' AND date BETWEEN STR_TO_DATE('$pmonth_fd 00:00:00', '%Y-%m-%d %H:%i:%s') AND STR_TO_DATE('$pmonth_ld 23:59:59', '%Y-%m-%d %H:%i:%s')");
								echo( sizeof($products_purchased) );
	echo '
							</span>
						</li>
					</ul>
				</div>
				<div class="report-tab report-tab4">
					<ul>
						<li>
							Sales in this period:
							<span>
	';
								$sales_period = $wpdb->get_results("SELECT * FROM $table_name WHERE date BETWEEN STR_TO_DATE('$tmonth_fd 00:00:00', '%Y-%m-%d %H:%i:%s') AND STR_TO_DATE('$tmonth_ld 23:59:59', '%Y-%m-%d %H:%i:%s')");
								foreach($sales_period as $sales_periods){
									$sales_tmonth += substr($sales_periods->price, 1);
								}
								echo $sales_tmonth;
	echo '					$</span>
						</li>
						<li>
							Orders placed:
							<span>
	';
								$orders_placed = $wpdb->get_results("SELECT * FROM $table_name WHERE date BETWEEN STR_TO_DATE('$tmonth_fd 00:00:00', '%Y-%m-%d %H:%i:%s') AND STR_TO_DATE('$tmonth_ld 23:59:59', '%Y-%m-%d %H:%i:%s')");
								echo( sizeof($orders_placed) );
	echo '					</span>
						</li>
						<li>
							Platinum Package:
							<span>
	';
								$products_purchased = $wpdb->get_results("SELECT * FROM $table_name WHERE post_content = 'Platinum Package' AND date BETWEEN STR_TO_DATE('$tmonth_fd 00:00:00', '%Y-%m-%d %H:%i:%s') AND STR_TO_DATE('$tmonth_ld 23:59:59', '%Y-%m-%d %H:%i:%s')");
								echo( sizeof($products_purchased) );
	echo '
							</span>
						</li>
						<li>
							Premium Package:
							<span>
	';
								$products_purchased = $wpdb->get_results("SELECT * FROM $table_name WHERE post_content = 'Premium Package' AND date BETWEEN STR_TO_DATE('$tmonth_fd 00:00:00', '%Y-%m-%d %H:%i:%s') AND STR_TO_DATE('$tmonth_ld 23:59:59', '%Y-%m-%d %H:%i:%s')");
								echo( sizeof($products_purchased) );
	echo '
							</span>
						</li>
						<li>
							Starter Package:
							<span>
	';
								$products_purchased = $wpdb->get_results("SELECT * FROM $table_name WHERE post_content = 'Starter Package' AND date BETWEEN STR_TO_DATE('$tmonth_fd 00:00:00', '%Y-%m-%d %H:%i:%s') AND STR_TO_DATE('$tmonth_ld 23:59:59', '%Y-%m-%d %H:%i:%s')");
								echo( sizeof($products_purchased) );
	echo '
							</span>
						</li>
					</ul>
				</div>
				<div class="report-tab report-tab5">
					<ul>
						<li>
							Sales in this period:
							<span>
	';
								$sales_period = $wpdb->get_results("SELECT * FROM $table_name WHERE date BETWEEN STR_TO_DATE('$sdf 00:00:00', '%Y-%m-%d %H:%i:%s') AND STR_TO_DATE('$sdl 23:59:59', '%Y-%m-%d %H:%i:%s')");
								foreach($sales_period as $sales_periods){
									$sales_7days += substr($sales_periods->price, 1);
								}
								if ($sales_7days = 0) {
									echo "0";
								} else{
									echo $sales_7days;
								}
	echo '					$</span>
						</li>
						<li>
							Orders placed:
							<span>
	';
								$orders_placed = $wpdb->get_results("SELECT * FROM $table_name WHERE date BETWEEN STR_TO_DATE('$sdf 00:00:00', '%Y-%m-%d %H:%i:%s') AND STR_TO_DATE('$sdl 23:59:59', '%Y-%m-%d %H:%i:%s')");
								echo( sizeof($orders_placed) );
	echo '					</span>
						</li>
						<li>
							Platinum Package:
							<span>
	';
								$products_purchased = $wpdb->get_results("SELECT * FROM $table_name WHERE post_content = 'Platinum Package' AND date BETWEEN STR_TO_DATE('$sdf 00:00:00', '%Y-%m-%d %H:%i:%s') AND STR_TO_DATE('$sdl 23:59:59', '%Y-%m-%d %H:%i:%s')");
								echo( sizeof($products_purchased) );
	echo '
							</span>
						</li>
						<li>
							Premium Package:
							<span>
	';
								$products_purchased = $wpdb->get_results("SELECT * FROM $table_name WHERE post_content = 'Premium Package' AND date BETWEEN STR_TO_DATE('$sdf 00:00:00', '%Y-%m-%d %H:%i:%s') AND STR_TO_DATE('$sdl 23:59:59', '%Y-%m-%d %H:%i:%s')");
								echo( sizeof($products_purchased) );
	echo '
							</span>
						</li>
						<li>
							Starter Package:
							<span>
	';
								$products_purchased = $wpdb->get_results("SELECT * FROM $table_name WHERE post_content = 'Starter Package' AND date BETWEEN STR_TO_DATE('$sdf 00:00:00', '%Y-%m-%d %H:%i:%s') AND STR_TO_DATE('$sdl 23:59:59', '%Y-%m-%d %H:%i:%s')");
								echo( sizeof($products_purchased) );
	echo '
							</span>
						</li>
					</ul>
				</div>
				<div class="report-tab report-tab6">
					<form action="" id="mg_order_report" autocomplete="off" class="mg_order_form_date">
						<ul>
							<li>
								<input type="text" id="report_from" name="report_from" placeholder="from" required />
								<span>–</span>
								<input type="text" id="report_to" name="report_to" placeholder="to" required />
							</li>
							<li>
								<input type="submit" value="Show report">
							</li>
						</ul>
						<img class="loader" src="'.plugin_dir_url( __FILE__ ).'img/loading.gif">
					</form>
					<div class="clear"></div>
					<div id="report_custom_date">
					<ul>
						<li>Sales in this period: <span>0$</span></li>
						<li>Orders placed: <span>0</span></li>
						<li>Platinum Package: <span>0</span></li>
						<li>Premium Package: <span>0</span></li>
						<li>Starter Package: <span>0</span></li>
					</ul>
					</div>
				</div>

			</div>
		</div>
	';

}


function render_mg_shop_orders_page() {
	global $wpdb;
	$table_name = $wpdb->prefix . "mgshop_orders";
	$option = array(
		'Waiting processing',
		'Processing',
		'Pending payment',
		'Completed',
		'Cancelled administrator',
		'Payment failed'
	);
	echo '
		<div id="mg_order_sorting">
			<h2>Orders sorting:</h2>
			<form action="" id="mg_order_sort" autocomplete="off" class="mg_order_form_date">
				<ul>
					<li>
						<label for="sort_status">Status:</label>
						<select name="sort_status" id="sort_status" required>
	';
							foreach($option as $options){
								echo '<option value="'. $options .'"';
									if ($options == $orders_datas->status){ echo 'default selected'; }
								echo '>'. $options .'</option>';
							}
	echo '
						</select>
					</li>
					<li>
						<label for="sort_from">Date:</label>
						<input type="text" id="sort_from" name="sort_from" placeholder="from" />
						<span>–</span>
						<input type="text" id="sort_to" name="sort_to" placeholder="to" />
					</li>
					<li>
						<input type="submit" value="SORT">
					</li>
				</ul>
				<img class="loader" src="'.plugin_dir_url( __FILE__ ).'img/loading.gif">
			</form>
		</div>
	';

	$orders_data = $wpdb->get_results("SELECT * FROM $table_name ORDER BY id DESC");
	if($orders_data){
		echo '<div id="mg_shop_order_info">';
		foreach( $orders_data as $orders_datas ){
			echo '
			<div id="order-'.$orders_datas->id.'" class="order-box">
				<div class="order-title">
					Order #'.$orders_datas->id.'
					<em>('.$orders_datas->date.')</em>
					<span data-id="mg_order_status_'.$orders_datas->id.'">'.$orders_datas->status.'</span>
				</div>
				<button class="mg_order_remove" data-remove="'.$orders_datas->id.'">Remove</button>
				<div class="order-content row">
					<div class="col-md-6">
						<div class="mg_shop_customer">Customer: <span>'.$orders_datas->customer.'</span></div>
						<div class="mg_shop_email">Email: <span>'.$orders_datas->email.'</span></div>
						<div class="mg_shop_phone">Phone: <span>'.$orders_datas->phone.'</span></div>
						<div class="mg_shop_payment">Payment via: <span>'.$orders_datas->payment.'</span></div>
						<div class="mg_shop_price">Price: <span>'.$orders_datas->price.'</span></div>
					</div>
					<div class="col-md-6">
						<div class="mg_shop_status">
							Status:
							<span>
								<form class="mg_order_status_update">
									<input type="hidden" name="id" value="'.$orders_datas->id.'" >
									<select name="status" id="mg_order_status_'.$orders_datas->id.'" >';
										foreach($option as $options){
											echo '<option value="'. $options .'"';
												if ($options == $orders_datas->status){ echo 'default selected'; }
											echo '>'. $options .'</option>';
										}
			echo					'</select>
									<input type="submit" value="update">
									<img class="loader" src="'.plugin_dir_url( __FILE__ ).'img/loading.gif">
								</form>
							</span>
						</div>
						<div class="mg_shop_billing">Billing: <span>'.$orders_datas->billing.'</span></div>
						<div class="mg_shop_shipping">Shipping: <span>'.$orders_datas->shipping.'</span></div>
						<div class="mg_shop_info">Info: <span>'.$orders_datas->post_content.'</span></div>
					</div>
				</div>
			</div>';
		}
		echo '</div>';
		echo '
			<div class="feedback">
				<form id="feedback-form">
					<ul>
						<li class="input-bloc w1">
							<input id="feedback_name" name="name" type="text" placeholder="Name" value="Name" readonly="readonly">
						</li>
						<li class="input-bloc w1">
							<input id="feedback_email" name="email" type="text" placeholder="Email" value="Email" readonly="readonly">
						</li>
						<li class="input-bloc msg">
							<textarea id="feedback_message" name="message" placeholder="Message" ></textarea>
						</li>
						<li>
							<input id="feedback_send" type="submit" value="SEND" >
						</li>
						<li><h2 class="confirmation-message">Message sent!</h2></li>
					</ul>
				</form>
			</div>
		';
	}
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

// //Create DB
// global $wpdb;
// require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
// $table_name = $wpdb->prefix . "mgshop_orders";
// $sql = "CREATE TABLE {$table_name} (
// 	id mediumint(9) NOT NULL AUTO_INCREMENT,
// 	date DATETIME NOT NULL,
// 	customer text NOT NULL,
// 	email text NOT NULL,
// 	phone text NOT NULL,
// 	payment text NOT NULL,
// 	status text NOT NULL,
// 	billing text NOT NULL,
// 	shipping text NOT NULL,
// 	price text NOT NULL,
// 	post_content text NOT NULL,
// 	post_status text NOT NULL,
// 	UNIQUE KEY id (id)
// ) {$charset_collate};";
// // Создать таблицу.
// dbDelta( $sql );

//Additing orders to DB
function addPost(){

	$data = $_POST['dataObj'];

	global $wpdb;
	$date = date('Y-m-d H:i:s');

	if( $wpdb->insert(
			$wpdb->prefix . "mgshop_orders",
			array(
				'date'         => $date,
				'customer'     => $data['name'],
				'email'        => $data['email'],
				'phone'        => $data['phone'],
				'payment'      => 'Pending payment',
				'status'       => $data['status'],
				'billing'      => $data['address'],
				'shipping'     => $data['address'],
				'price'        => $data['price'],
				'post_content' => $data['product'],
				'post_status'  => 'publish',
			)
	) === false){
		return false;
	} else{
		echo $wpdb->insert_id;
	}

	die();
}
add_action('wp_ajax_addPost', 'addPost');
add_action('wp_ajax_nopriv_addPost', 'addPost');


//Additing orders to DB
function updateOrderStatus(){

	global $wpdb;

	if($wpdb->update(
		$wpdb->prefix . "mgshop_orders",
		array( 'status' => $_POST['status'] ),
		array( 'ID' => $_POST['id'] )
	) === false){
		echo "Error";
	} else{
		echo "Status updated";
	}

	die();
}
add_action('wp_ajax_updateOrderStatus', 'updateOrderStatus');
add_action('wp_ajax_nopriv_updateOrderStatus', 'updateOrderStatus');



function updatePostPaymentStatus(){

	$data = $_POST['dataObj'];
	echo 'Payment - '.$data['payment'];
	echo 'Status - '.$data['status'];
	echo 'ID - '.$data['id'];

	global $wpdb;

	if($wpdb->update(
		$wpdb->prefix . "mgshop_orders",
		array(
			'status'  => $data['status'],
			'payment' => $data['payment'],
		),
		array( 'ID' => $data['id'] )
	) === false){
		echo "Error";
	} else{
		echo "updatePostPaymentStatus Updated";
	}

	die();
}
add_action('wp_ajax_updatePostPaymentStatus', 'updatePostPaymentStatus');
add_action('wp_ajax_nopriv_updatePostPaymentStatus', 'updatePostPaymentStatus');


function updatePostStatusFailed(){

	$data = $_POST['dataObj'];

	global $wpdb;

	if($wpdb->update(
		$wpdb->prefix . "mgshop_orders",
		array(
			'status' => $data['status'],
			'payment' => $data['payment'],
		),
		array( 'ID' => $data['id'] )
	) === false){
		echo "Error";
	} else{
		echo "updatePostStatusFailed updated";
	}

	die();
}
add_action('wp_ajax_updatePostStatusFailed', 'updatePostStatusFailed');
add_action('wp_ajax_nopriv_updatePostStatusFailed', 'updatePostStatusFailed');



function updateOrderSort() {
	global $wpdb;

	$option = array(
		'Waiting processing',
		'Processing',
		'Pending payment',
		'Cancelled administrator',
		'Payment failed',
		'Completed'
	);

	$sort_status = $_POST['status'];
	$sort_date_from = $_POST['dateFrom'];
	$sort_date_to = $_POST['dateTo'];

	$table_name = $wpdb->prefix . "mgshop_orders";

	if ( $sort_date_from != "" && $sort_date_to != "" ) {
		$orders_data = $wpdb->get_results("SELECT * FROM $table_name WHERE status = '$sort_status' AND date BETWEEN STR_TO_DATE('$sort_date_from 00:00:00', '%Y-%m-%d %H:%i:%s') AND STR_TO_DATE('$sort_date_to 23:59:59', '%Y-%m-%d %H:%i:%s') ORDER BY id DESC");
	} else if ( $sort_date_from != "" && $sort_date_to == "" ){
		$orders_data = $wpdb->get_results("SELECT * FROM $table_name WHERE status = '$sort_status' AND date >= STR_TO_DATE('$sort_date_from 00:00:00', '%Y-%m-%d %H:%i:%s') ORDER BY id DESC");
	} else if ( $sort_date_from == "" && $sort_date_to != "" ){
		$orders_data = $wpdb->get_results("SELECT * FROM $table_name WHERE status = '$sort_status' AND date <= STR_TO_DATE('$sort_date_to 23:59:59', '%Y-%m-%d %H:%i:%s') ORDER BY id DESC");
	} else{
		$orders_data = $wpdb->get_results("SELECT * FROM $table_name WHERE status = '$sort_status' ORDER BY id DESC");
	}

	if($orders_data){
		echo '<div id="mg_shop_order_info">';
		foreach( $orders_data as $orders_datas ){
			echo '
			<div id="order-'.$orders_datas->id.'" class="order-box">
				<div class="order-title">
					Order #'.$orders_datas->id.'
					<em>('.$orders_datas->date.')</em>
					<span data-id="mg_order_status_'.$orders_datas->id.'">'.$orders_datas->status.'</span>
				</div>
				<button class="mg_order_remove" data-remove="'.$orders_datas->id.'">Remove</button>
				<div class="order-content row">
					<div class="col-md-6">
						<div class="mg_shop_customer">Customer: <span>'.$orders_datas->customer.'</span></div>
						<div class="mg_shop_email">Email: <span>'.$orders_datas->email.'</span></div>
						<div class="mg_shop_phone">Phone: <span>'.$orders_datas->phone.'</span></div>
						<div class="mg_shop_payment">Payment via: <span>'.$orders_datas->payment.'</span></div>
						<div class="mg_shop_price">Price: <span>'.$orders_datas->price.'</span></div>
					</div>
					<div class="col-md-6">
						<div class="mg_shop_status">
							Status:
							<span>
								<form class="mg_order_status_update">
									<input type="hidden" name="id" value="'.$orders_datas->id.'" >
									<select name="status" id="mg_order_status_'.$orders_datas->id.'" >';
										foreach($option as $options){
											echo '<option value="'. $options .'"';
												if ($options == $orders_datas->status){ echo 'default selected'; }
											echo '>'. $options .'</option>';
										}
			echo					'</select>
									<input type="submit" value="update">
									<img class="loader" src="'.plugin_dir_url( __FILE__ ).'img/loading.gif">
								</form>
							</span>
						</div>
						<div class="mg_shop_billing">Billing: <span>'.$orders_datas->billing.'</span></div>
						<div class="mg_shop_shipping">Shipping: <span>'.$orders_datas->shipping.'</span></div>
						<div class="mg_shop_info">Info: <span>'.$orders_datas->post_content.'</span></div>
					</div>
				</div>
			</div>';
		}
		echo '</div>';
	}

	die();
}
add_action('wp_ajax_updateOrderSort', 'updateOrderSort');
add_action('wp_ajax_nopriv_updateOrderSort', 'updateOrderSort');


function updateReportDate() {
	global $wpdb;

	$report_date_from = $_POST['dateFrom'];
	$report_date_to = $_POST['dateTo'];

	$table_name = $wpdb->prefix . "mgshop_orders";

	echo '
					<ul>
						<li>
							Sales in this period:
							<span>
	';
								$sales_period = $wpdb->get_results("SELECT * FROM $table_name WHERE date BETWEEN STR_TO_DATE('$report_date_from 00:00:00', '%Y-%m-%d %H:%i:%s') AND STR_TO_DATE('$report_date_to 23:59:59', '%Y-%m-%d %H:%i:%s')");
								foreach($sales_period as $sales_periods){
									$sales += substr($sales_periods->price, 1);
								}
								echo $sales;
	echo '					$</span>
						</li>
						<li>
							Orders placed:
							<span>
	';
								$orders_placed = $wpdb->get_results("SELECT * FROM $table_name WHERE date BETWEEN STR_TO_DATE('$report_date_from 00:00:00', '%Y-%m-%d %H:%i:%s') AND STR_TO_DATE('$report_date_to 23:59:59', '%Y-%m-%d %H:%i:%s')");
								echo( sizeof($orders_placed) );
	echo '					</span>
						</li>
						<li>
							Platinum Package:
							<span>
	';
								$products_purchased = $wpdb->get_results("SELECT * FROM $table_name WHERE post_content = 'Platinum Package' AND date BETWEEN STR_TO_DATE('$report_date_from 00:00:00', '%Y-%m-%d %H:%i:%s') AND STR_TO_DATE('$report_date_to 23:59:59', '%Y-%m-%d %H:%i:%s')");
								echo( sizeof($products_purchased) );
	echo '
							</span>
						</li>
						<li>
							Premium Package:
							<span>
	';
								$products_purchased = $wpdb->get_results("SELECT * FROM $table_name WHERE post_content = 'Premium Package' AND date BETWEEN STR_TO_DATE('$report_date_from 00:00:00', '%Y-%m-%d %H:%i:%s') AND STR_TO_DATE('$report_date_to 23:59:59', '%Y-%m-%d %H:%i:%s')");
								echo( sizeof($products_purchased) );
	echo '
							</span>
						</li>
						<li>
							Starter Package:
							<span>
	';
								$products_purchased = $wpdb->get_results("SELECT * FROM $table_name WHERE post_content = 'Starter Package' AND date BETWEEN STR_TO_DATE('$report_date_from 00:00:00', '%Y-%m-%d %H:%i:%s') AND STR_TO_DATE('$report_date_to 23:59:59', '%Y-%m-%d %H:%i:%s')");
								echo( sizeof($products_purchased) );
	echo '
							</span>
						</li>
					</ul>
	';

	die();
}
add_action('wp_ajax_updateReportDate', 'updateReportDate');
add_action('wp_ajax_nopriv_updateReportDate', 'updateReportDate');



//Additing orders to DB
function removeOrder(){

	global $wpdb;

	if($wpdb->delete(
		$wpdb->prefix . "mgshop_orders",
		array( 'ID' => $_POST['id'] )
	) === false){
		echo "Error";
	} else{
		echo "Order removed";
	}

	die();
}
add_action('wp_ajax_removeOrder', 'removeOrder');
add_action('wp_ajax_nopriv_removeOrder', 'removeOrder');