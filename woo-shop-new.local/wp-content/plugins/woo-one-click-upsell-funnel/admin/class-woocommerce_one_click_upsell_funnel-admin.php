<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://makewebbetter.com/
 * @since      1.0.0
 *
 * @package    Woocommerce_one_click_upsell_funnel
 * @subpackage Woocommerce_one_click_upsell_funnel/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Woocommerce_one_click_upsell_funnel
 * @subpackage Woocommerce_one_click_upsell_funnel/admin
 * @author     makewebbetter <webmaster@makewebbetter.com>
 */
class Woocommerce_one_click_upsell_funnel_Admin 
{

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

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
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) 
	{
		$this->plugin_name = $plugin_name;
		$this->version = $version;
	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() 
	{

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in woocommerce_one_click_upsell_funnel_pro_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The woocommerce_one_click_upsell_funnel_pro_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		$screen = get_current_screen();

		if( isset( $screen->id ) )
		{
			$pagescreen = $screen->id;

			if( $pagescreen == 'toplevel_page_mwb-wocuf-setting' )
			{
				wp_register_style( 'mwb_wocuf_pro_admin_style', plugin_dir_url( __FILE__ ) . 'css/woocommerce_one_click_upsell_funnel_pro-admin.css', array(), $this->version, 'all' );

				wp_enqueue_style( 'mwb_wocuf_pro_admin_style' );

				wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/select2.min.css', array(), $this->version, 'all' );

				wp_register_style( 'woocommerce_admin_styles', WC()->plugin_url() . '/assets/css/admin.css', array(), WC_VERSION );

				wp_enqueue_style( 'woocommerce_admin_menu_styles' );
				
				wp_enqueue_style( 'woocommerce_admin_styles' );
			}
		}
	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() 
	{

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in woocommerce_one_click_upsell_funnel_pro_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The woocommerce_one_click_upsell_funnel_pro_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */
		
		$screen = get_current_screen();
		
		if( isset( $screen->id ) )
		{
			$pagescreen = $screen->id;
			
			if( $pagescreen == 'toplevel_page_mwb-wocuf-setting' )
			{
				wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/select2.min.js', array( 'jquery' ), $this->version, false );

				wp_enqueue_script('mwb_wocuf_pro_admin_script', plugin_dir_url( __FILE__ ) . 'js/woocommerce_one_click_upsell_funnel_pro-admin.js', array( 'jquery' ), $this->version, false );
				
				wp_register_script( 'woocommerce_admin', WC()->plugin_url() . '/assets/js/admin/woocommerce_admin.js', array( 'jquery', 'jquery-blockui', 'jquery-ui-sortable', 'jquery-ui-widget', 'jquery-ui-core', 'jquery-tiptip', 'wc-enhanced-select' ), WC_VERSION );

				wp_register_script( 'jquery-tiptip', WC()->plugin_url() . '/assets/js/jquery-tiptip/jquery.tipTip.js', array( 'jquery' ), WC_VERSION, true );	
					$locale  = localeconv();
					$decimal = isset( $locale['decimal_point'] ) ? $locale['decimal_point'] : '.';
					$params = array(
						/* translators: %s: decimal */
						'i18n_decimal_error'                => sprintf( __( 'Please enter in decimal (%s) format without thousand separators.', 'woocommerce_one_click_upsell_funnel' ), $decimal ),
						/* translators: %s: price decimal separator */
						'i18n_mon_decimal_error'            => sprintf( __( 'Please enter in monetary decimal (%s) format without thousand separators and currency symbols.', 'woocommerce_one_click_upsell_funnel' ), wc_get_price_decimal_separator() ),
						'i18n_country_iso_error'            => __( 'Please enter in country code with two capital letters.', 'woocommerce_one_click_upsell_funnel' ),
						'i18_sale_less_than_regular_error'  => __( 'Please enter in a value less than the regular price.', 'woocommerce_one_click_upsell_funnel' ),
						'decimal_point'                     => $decimal,
						'mon_decimal_point'                 => wc_get_price_decimal_separator(),
						'strings' => array(
							'import_products' => __( 'Import', 'woocommerce_one_click_upsell_funnel' ),
							'export_products' => __( 'Export', 'woocommerce_one_click_upsell_funnel' ),
						),
						'urls' => array(
							'import_products' => esc_url_raw( admin_url( 'edit.php?post_type=product&page=product_importer' ) ),
							'export_products' => esc_url_raw( admin_url( 'edit.php?post_type=product&page=product_exporter' ) ),
						),
					);
			
				wp_localize_script( 'mwb_wocuf_pro_admin_script', 'mwb_wocuf_pro_ajaxurl', admin_url('admin-ajax.php') );

				wp_localize_script( 'mwb_wocuf_pro_admin_script', 'mwb_wocuf_pro_location', admin_url('admin.php').'?page=mwb-wocuf-setting&tab=settings' );

				wp_localize_script( 'mwb_wocuf_pro_admin_script', 'mwb_wocuf_pro_offer_deletion', __( "Are you sure to delete this offer",'woocommerce_one_click_upsell_funnel' ) );

				wp_enqueue_script('mwb_wocuf_pro_admin_script');

				wp_localize_script( 'woocommerce_admin', 'woocommerce_admin', $params );
				
				wp_enqueue_script( 'woocommerce_admin' );

				wp_enqueue_script('mwb-wocuf-pro-add_new-offer-script',plugin_dir_url( __FILE__ ) . 'js/mwb_wocuf_pro_add_new_offer_script.js', array('woocommerce_admin','wc-enhanced-select'), $this->version,false);

				wp_localize_script( 'mwb-wocuf-pro-add_new-offer-script', 'ajax_url', admin_url('admin-ajax.php') );

				if( !empty( $_GET['mwb-upsell-offer-section'] ) ) {

					$upsell_offer_section['value'] = sanitize_text_field( $_GET['mwb-upsell-offer-section'] );

					wp_localize_script( 'mwb-wocuf-pro-add_new-offer-script', 'offer_section_obj', $upsell_offer_section );
				}

				wp_enqueue_style( 'wp-color-picker' ); 		       

				wp_enqueue_script('mwb-wocuf-pro-color-picker-handle', plugin_dir_url( __FILE__ ) . 'js/mwb_wocuf_pro_color_picker_handle.js', array('jquery','wp-color-picker' ), $this->version, true);
			}

			if( isset( $_GET["section"] ) && $_GET["section"] == "mwb-wocuf-pro-paypal-gateway" )
			{
				wp_enqueue_script( 'mwb-wocuf-pro-paypal-script', plugin_dir_url( __FILE__ ) . 'js/woocommerce_one_click_upsell_funnel_pro-paypal.js', array('jquery'), $this->version, false );
			}
			elseif( isset( $_GET["section"] ) && $_GET["section"] == "mwb-wocuf-pro-stripe-gateway" )
			{
				wp_enqueue_script( 'mwb-wocuf-pro-stripe-script', plugin_dir_url( __FILE__ ) . 'js/woocommerce_one_click_upsell_funnel_pro-stripe.js', array('jquery'), $this->version, false );
			}			
		}
	}

	/**
	 * adding upsell menu page
	 *
	 * @since    1.0.0
	 */
	public function mwb_wocuf_pro_admin_menu()
	{
		add_menu_page(
			__( '1 Click Upsell', 'woocommerce_one_click_upsell_funnel' ),
			__( '1 Click Upsell', 'woocommerce_one_click_upsell_funnel' ),
			'manage_woocommerce',
			'mwb-wocuf-setting',
			array( $this, 'upsell_menu_html' ),
			'dashicons-chart-area',
			56
		);
	}

	/**
	 * callable function for upsell menu page
	 *
	 * @since    1.0.0
	 */

	public function upsell_menu_html() {

       	require_once plugin_dir_path( __FILE__ ).'/partials/woocommerce_one_click_upsell_funnel_pro-admin-display.php';
	}

	/**
	 * Offer Html for appending in funnel when add new offer is clicked - ajax handle function.
	 * Also Dynamic page post is created while adding new offer.
	 *
	 * @since    1.0.0
	 */
	public function return_funnel_offer_section_content() {

		if( isset( $_POST['mwb_wocuf_pro_flag'] ) && isset( $_POST['mwb_wocuf_pro_funnel'] ) ) {

			// New Offer id.
			$offer_index = sanitize_text_field( $_POST['mwb_wocuf_pro_flag'] );
			// Funnel id.
			$funnel_id = sanitize_text_field( $_POST['mwb_wocuf_pro_funnel'] );

			unset( $_POST['mwb_wocuf_pro_flag'] );
			unset( $_POST['mwb_wocuf_pro_funnel'] );

			$funnel_offer_post_html = '<input type="hidden" name="mwb_upsell_post_id_assigned[' . $offer_index . ']" value="">';

			$funnel_offer_template_section_html = '';
			$funnel_offer_post_id = '';

			if( mwb_upsell_lite_elementor_plugin_active() ) {

				// Create post for corresponding funnel and offer id.
				$funnel_offer_post_id = wp_insert_post( 
					array(
						'comment_status' 		=> 'closed',
						'ping_status' 			=> 'closed',
						'post_content' 			=> '',
						'post_name' 			=> uniqid( 'special-offer-' ), // post slug
						'post_title' 			=> "Special Offer",
						'post_status' 			=> 'publish',
						'post_type' 			=> 'page',
						'page_template'			=> 'elementor_canvas',
					)
				);

				if( $funnel_offer_post_id ) {

					$elementor_data = mwb_upsell_lite_elementor_offer_template_1();
					update_post_meta( $funnel_offer_post_id, '_elementor_data', $elementor_data );
					update_post_meta( $funnel_offer_post_id, '_elementor_edit_mode', 'builder' );

					$mwb_upsell_funnel_data = array(
						'funnel_id' => $funnel_id,
						'offer_id' => $offer_index
					);

					update_post_meta( $funnel_offer_post_id, 'mwb_upsell_funnel_data', $mwb_upsell_funnel_data );

					$funnel_offer_post_html = '<input type="hidden" name="mwb_upsell_post_id_assigned[' . $offer_index . ']" value="' . $funnel_offer_post_id . '">';

					$funnel_offer_template_section_html = $this->get_funnel_offer_template_section_html( $funnel_offer_post_id, $offer_index, $funnel_id );

					// Save an array of all created upsell offer-page post ids.
					$upsell_offer_post_ids = get_option( 'mwb_upsell_lite_offer_post_ids', array() );

					$upsell_offer_post_ids[] = $funnel_offer_post_id;

					update_option( 'mwb_upsell_lite_offer_post_ids', $upsell_offer_post_ids );

				}
			}

			// When Elementor is not active.
			else {
				
				// Will return 'Feature not supported' part as $funnel_offer_post_id is empty.
				$funnel_offer_template_section_html = $this->get_funnel_offer_template_section_html( $funnel_offer_post_id, $offer_index, $funnel_id );
			}

			// Get all funnels.
			$mwb_wocuf_pro_funnel = get_option( 'mwb_wocuf_funnels_list' );

			// Funnel offers array.
			$mwb_wocuf_pro_offers_to_add = isset( $mwb_wocuf_pro_funnel[$funnel_id]['mwb_wocuf_applied_offer_number'] )?$mwb_wocuf_pro_funnel[$funnel_id]['mwb_wocuf_applied_offer_number']:array();

			// Buy now action select html.
			$buy_now_action_select_html = '<select name="mwb_wocuf_attached_offers_on_buy[' . $offer_index . ']"><option value="thanks">' . __( 'Order ThankYou Page', 'woocommerce_one_click_upsell_funnel' ) . '</option>';

			// No thanks action select html.
			$no_thanks_action_select_html = '<select name="mwb_wocuf_attached_offers_on_no[' . $offer_index . ']"><option value="thanks">' . __( 'Order ThankYou Page', 'woocommerce_one_click_upsell_funnel' ) . '</option>';

			// If there are other offers then add them to select html.
			if( !empty( $mwb_wocuf_pro_offers_to_add ) ) {

				foreach( $mwb_wocuf_pro_offers_to_add as $offer_id ) {

					$buy_now_action_select_html .= '<option value=' . $offer_id . '>' . __(  'Offer #', 'woocommerce_one_click_upsell_funnel' ) . $offer_id . '</option>';

					$no_thanks_action_select_html .= '<option value=' . $offer_id . '>' . __(  'Offer #', 'woocommerce_one_click_upsell_funnel' ) . $offer_id . '</option>';
				}
			}

			$buy_now_action_select_html .= '</select>';
			$no_thanks_action_select_html .= '</select>';

			$offer_scroll_id_val = "#offer-section-$offer_index";

			$data = '<div style="display:none;" data-id="' . $offer_index . '" data-scroll-id="' . $offer_scroll_id_val . '" class="new_created_offers mwb_upsell_single_offer">
			<h2 class="mwb_upsell_offer_title">' . __( 'Offer #','woocommerce_one_click_upsell_funnel' ) . $offer_index . '</h2>
			<table>
			<tr>
			<th><label><h4>' . __( 'Offer Product', 'woocommerce_one_click_upsell_funnel' ) . '</h4></label></th>
			<td><select class="wc-offer-product-search mwb_upsell_offer_product" name="mwb_wocuf_products_in_offer[' . $offer_index . ']" data-placeholder="' . esc_html__(  'Search for a product&hellip;', 'woocommerce_one_click_upsell_funnel' ) . '"></select></td>
			</tr>
			<tr>
			<th><label><h4>' . __( 'Offer Price / Discount','woocommerce_one_click_upsell_funnel' ) . '</h4></label></th>
			<td>
			<input type="text" class="mwb_upsell_offer_price" name="mwb_wocuf_offer_discount_price[' . $offer_index . ']" value="50%" >
			<span class="mwb_upsell_offer_description" >' . esc_html__( 'Specify new offer price or discount %','woocommerce_one_click_upsell_funnel' ) . '</span>
			</td>
			</tr>
		    <tr>
		    <th><label><h4>' . esc_html__( 'After \'Buy Now\' go to','woocommerce_one_click_upsell_funnel' ) . '</h4></label></th>
		    <td>' . $buy_now_action_select_html . '<span class="mwb_upsell_offer_description">' . esc_html__( 'Select where the customer will be redirected after accepting this offer' , 'woocommerce-one-click-upsell-funnel-pro ') . '</span></td>
		    </tr>
		    <tr>
		    <th><label><h4>' . esc_html__( 'After \'No thanks\' go to','woocommerce_one_click_upsell_funnel' ) . '</h4></label></th>
		    <td>' . $no_thanks_action_select_html . '<span class="mwb_upsell_offer_description">' . esc_html__( 'Select where the customer will be redirected after rejecting this offer' , 'woocommerce-one-click-upsell-funnel-pro ') . '</td>
		    </tr>' . $funnel_offer_template_section_html . '
		    <tr>
		    <th><label><h4>' . __( 'Offer Custom Page Link','woocommerce_one_click_upsell_funnel' ) . '</h4></label></th>
		    <td>
		    <input type="text" class="mwb_upsell_custom_offer_page_url" name="mwb_wocuf_offer_custom_page_url[' . $offer_index . ']" >
		    </td>
		    </tr>
		    <tr>
		    <td colspan="2">
		    <button class="button mwb_wocuf_pro_delete_new_created_offers" data-id="' . $offer_index . '">' . __( "Remove",'woocommerce_one_click_upsell_funnel' ) . '</button>
		    </td>
		    </tr>
		    </table>
		    <input type="hidden" name="mwb_wocuf_applied_offer_number[' . $offer_index . ']" value="' . $offer_index . '">
		    ' . $funnel_offer_post_html . '

		    </div>';

		    $new_data = apply_filters( 'mwb_wocuf_pro_add_more_to_offers' , $data );

			echo $new_data;
		}

		wp_die();
	}

	/**
	 * Returns Funnel Offer Template section html.
	 *
	 * @since    3.0.0
	 */
	public function get_funnel_offer_template_section_html( $funnel_offer_post_id, $offer_index, $funnel_id ) {

		ob_start();

		?>

		<!-- Section : Offer template start -->
	    <tr>
		    <th><label><h4><?php esc_html_e( 'Offer Template', 'woocommerce_one_click_upsell_funnel' )?></h4></label>
		    </th>

		    <?php 

	    	$assigned_post_id = !empty( $funnel_offer_post_id ) ? $funnel_offer_post_id : '';
	    	$current_offer_id = $offer_index;
	    	$mwb_wocuf_pro_funnel_id = $funnel_id;

		    ?>

		    <td>

				<?php if( !empty( $assigned_post_id ) ) : ?>

			    	<?php 

			    	// As default is "one".
			    	$offer_template_active = 'one';

			    	$offer_templates_array = array(
			    		'one' => esc_html__( 'STANDARD TEMPLATE' , 'woocommerce_one_click_upsell_funnel' ),
			    		'two' => esc_html__( 'CREATIVE TEMPLATE' , 'woocommerce_one_click_upsell_funnel' ),
			    		'three' => esc_html__( 'VIDEO TEMPLATE' , 'woocommerce_one_click_upsell_funnel' ),
		    		);

			    	?>

			    	<!-- Offer templates parent div start -->
			    	<div class="mwb_upsell_offer_templates_parent">

				    	<input class="mwb_wocuf_pro_offer_template_input" type="hidden" name="mwb_wocuf_pro_offer_template[<?php echo $current_offer_id;?>]" value="<?php echo $offer_template_active; ?>">

				    	<?php foreach ( $offer_templates_array as $template_key => $template_name ) : ?>
				    		<!-- Offer templates foreach start-->
				    		<div class="mwb_upsell_offer_template <?php echo $template_key == $offer_template_active ? 'active' : ''; ?>">

				    			<div class="mwb_upsell_offer_template_sub_div"> 

							    	<h5><?php echo $template_name; ?></h5>

							    	<div class="mwb_upsell_offer_preview">

							    		<a href="javascript:void(0)" class="mwb_upsell_view_offer_template" data-template-id="<?php echo $template_key; ?>" ><img src="<?php echo MWB_WOCUF_URL . "admin/resources/offer-thumbnails/offer-template-$template_key.jpg"; ?>"></a>
						    		</div>

						    		<div class="mwb_upsell_offer_action">

								    	<?php if( $template_key != $offer_template_active ) : ?>

								    	<button class="button-primary mwb_upsell_activate_offer_template" data-template-id="<?php echo $template_key; ?>" data-offer-id="<?php echo $current_offer_id;?>" data-funnel-id="<?php echo $mwb_wocuf_pro_funnel_id; ?>" data-offer-post-id="<?php echo $assigned_post_id; ?>" ><?php esc_html_e( 'Insert and Activate' , 'woocommerce_one_click_upsell_funnel');?></button>

							    		<?php else: ?>

							    			<a class="button" href="<?php echo get_permalink( $assigned_post_id ); ?>" target="_blank"><?php esc_html_e( 'View &rarr;' , 'woocommerce_one_click_upsell_funnel');?></a>

							    			<a class="button" href="<?php echo admin_url( "post.php?post=$assigned_post_id&action=elementor" ); ?>" target="_blank"><?php esc_html_e( 'Customize &rarr;' , 'woocommerce_one_click_upsell_funnel');?></a>

								    	<?php endif; ?>
							    	</div>
						    	</div>
						    	
						    </div>
						    <!-- Offer templates foreach end-->
					    <?php endforeach; ?>
						    
					    <!-- Offer link to custom page start-->
					    <div class="mwb_upsell_offer_template mwb_upsell_custom_page_link_div <?php echo 'custom' == $offer_template_active ? 'active' : ''; ?>">

					    	<h5><?php esc_html_e( 'LINK TO CUSTOM PAGE' , 'woocommerce_one_click_upsell_funnel' ); ?></h5>

					    	<?php if( 'custom' != $offer_template_active ) : ?>

					    		<button class="button-primary mwb_upsell_activate_offer_template" data-template-id="custom" data-offer-id="<?php echo $current_offer_id;?>" data-funnel-id="<?php echo $mwb_wocuf_pro_funnel_id; ?>" data-offer-post-id="<?php echo $assigned_post_id; ?>" ><?php esc_html_e( 'Activate' , 'woocommerce_one_click_upsell_funnel');?></button>

					    	<?php else : ?>	

					    		<h5><?php esc_html_e( 'Activated' , 'woocommerce_one_click_upsell_funnel' ); ?></h5>
					    		<p><?php esc_html_e( 'Please enter and save your custom page link below.' , 'woocommerce_one_click_upsell_funnel' ); ?></p>


					    	<?php endif; ?>
					    	
					    </div>
					    <!-- Offer link to custom page end-->
					    
				    </div>
				    <!-- Offer templates parent div end -->
				

				<?php else : ?>

					<div class="mwb_upsell_offer_template_unsupported">
						
					<h4><?php esc_html_e( 'Feature not supported for this Offer, please add a new Offer with Elementor active.' , 'woocommerce_one_click_upsell_funnel' ); ?></h4>
					</div>

				<?php endif; ?>
			</td>
	    </tr>
	    <!-- Section : Offer template end -->

		<?php

		return ob_get_clean();
	}

	/**
	 * Insert and Activate respective template ajax handle function.
	 *
	 * @since    3.0.0
	 */
	public function activate_respective_offer_template() {

		$funnel_id = isset( $_POST['funnel_id'] ) ? sanitize_text_field(  $_POST['funnel_id'] ) : '';
		$offer_id = isset( $_POST['offer_id'] ) ? sanitize_text_field(  $_POST['offer_id'] ) : '';
		$template_id = isset( $_POST['template_id'] ) ? sanitize_text_field(  $_POST['template_id'] ) : '';
		$offer_post_id = isset( $_POST['offer_post_id'] ) ? sanitize_text_field(  $_POST['offer_post_id'] ) : '';

		// IF custom then don't update and just return.
		if( 'custom' == $template_id ) {

			echo json_encode( array( 'status' => true ) );
			wp_die();
		}


		$offer_templates_array = array(
    		'one' => 'mwb_upsell_lite_elementor_offer_template_1',
    		'two' => 'mwb_upsell_lite_elementor_offer_template_2',
    		'three' => 'mwb_upsell_lite_lite_elementor_offer_template_3',
		);

		foreach ( $offer_templates_array as $template_key => $callback_function ) {

			if( $template_id == $template_key ) {

				// Delete previous elementor css.
				delete_post_meta( $offer_post_id, '_elementor_css' );
				
				$elementor_data = $callback_function();
				update_post_meta( $offer_post_id, '_elementor_data', $elementor_data );

				break;
			}
		}

		echo json_encode( array( 'status' => true ) );

		wp_die();
	}

	/**
	 * select2 search for adding funnel target products
	 *
	 * @since    1.0.0
	 */

	public function seach_products_for_funnel()
	{
		$return = array();
 	
		$search_results = new WP_Query( array( 
			's'						=> $_GET['q'],
			'post_type' 			=> array( 'product' ),
			'post_status' 			=> array( 'publish' ),
			'ignore_sticky_posts' 	=> 1,
			'posts_per_page' 		=> -1 
		) );

		if( $search_results->have_posts() ) :

			while( $search_results->have_posts() ): 

				$search_results->the_post();
					
				$title = ( mb_strlen( $search_results->post->post_title ) > 50 ) ? mb_substr( $search_results->post->post_title, 0, 49 ) . '...' : $search_results->post->post_title;

				/**
				 * Check for post type as query sometimes returns posts even after mentioning post_type.
				 * As some plugins alter query which causes issues.
				 */
				$post_type = get_post_type( $search_results->post->ID );

				if( 'product' != $post_type ) {

					continue;
				}

				$product = wc_get_product( $search_results->post->ID );
				$downloadable = $product->is_downloadable();
				$stock = $product->get_stock_status();

				if( $product->is_type('variable') || $product->is_type('grouped') ||  $product->is_type('external') || $stock === "outofstock" )
				{
					continue;
				}

				$return[] = array( $search_results->post->ID, $title ); 

			endwhile;

		endif;

		echo json_encode( $return );

		wp_die();
	}


	/**
	 * select2 search for adding offer products
	 *
	 * @since    1.0.0
	 */

	public function seach_products_for_offers()
	{
		$return = array();
 	
		$search_results = new WP_Query( array( 
			's'						=> $_GET['q'],
			'post_type' 			=> array( 'product' ),
			'post_status' 			=> array( 'publish' ),
			'ignore_sticky_posts' 	=> 1,
			'posts_per_page' 		=> -1 
		) );

		if( $search_results->have_posts() ) :

			while( $search_results->have_posts() ): 

				$search_results->the_post();	

				$title = ( mb_strlen( $search_results->post->post_title ) > 50 ) ? mb_substr( $search_results->post->post_title, 0, 49 ) . '...' : $search_results->post->post_title;

				/**
				 * Check for post type as query sometimes returns posts even after mentioning post_type.
				 * As some plugins alter query which causes issues.
				 */
				$post_type = get_post_type( $search_results->post->ID );

				if( 'product' != $post_type ) {

					continue;
				}

				$product = wc_get_product( $search_results->post->ID );
				$downloadable = $product->is_downloadable();
				$stock = $product->get_stock_status();

				if( $product->is_type('variable') || $product->is_type('grouped') ||  $product->is_type('external') || $stock === "outofstock" )
				{
					continue;
				} 

				$return[] = array( $search_results->post->ID, $title ); 

			endwhile;

		endif;
		
		echo json_encode( $return );

		wp_die();
	}

	/**
	 * Adding custom column in orders table at backend
	 *
	 * @since    1.0.0
	 * @param    array    $columns    array of columns on orders table 
	 * @return   array    $columns    array of columns on orders table alongwith upsell column
	 */

	public function mwb_wocuf_pro_add_columns_to_admin_orders($columns)
	{

	  	$columns['mwb-upsell-orders'] = __( 'Upsell Orders','woocommerce_one_click_upsell_funnel' );

    	return $columns;
	}


	/**
	 * Populating Upsell Orders column with Single Order or Upsell order.
	 *
	 * @since    1.0.0
	 * @param    array   $column    Array of available columns.
	 * @param    int     $post_id   Current Order post id.
	 */

	public function mwb_wocuf_pro_populate_upsell_order_column( $column, $post_id ) {

		$upsell_order = get_post_meta( $post_id, 'mwb_wocuf_upsell_order', true );

		switch( $column ) {

			case 'mwb-upsell-orders':

			$data = '';

			if( 'true' === $upsell_order ) {

				$data .= sprintf( '<a href="%s" >%s</a>', get_edit_post_link( $post_id ), __( 'Upsell Order', 'woocommerce_one_click_upsell_funnel' ) );
			}

			else {

				$data .= __( 'Single Order', 'woocommerce_one_click_upsell_funnel' );
			}

			echo $data;
			
			break;	
		}	
	}


	/**
	 * Add Upsell Filtering dropdown for All Orders, No Upsell Orders, Only Upsell Orders.
	 *
	 * @since    1.0.0
	 */
	public function mwb_wocuf_pro_restrict_manage_posts()
	{
		if( isset( $_GET["post_type"] ) && $_GET["post_type"] == "shop_order" )
		{
			if( isset( $_GET["mwb_wocuf_pro_upsell_filter"] ) ):?>
				<select name="mwb_wocuf_pro_upsell_filter">
					<option value="all" <?php echo $_GET["mwb_wocuf_pro_upsell_filter"]=="all"?"selected=selected":""?>><?php _e('All Orders','woocommerce_one_click_upsell_funnel')?></option>
					<option value="no_upsells" <?php echo $_GET["mwb_wocuf_pro_upsell_filter"]=="no_upsells"?"selected=selected":""?>><?php _e('No Upsell Orders','woocommerce_one_click_upsell_funnel')?></option>
					<option value="all_upsells" <?php echo $_GET["mwb_wocuf_pro_upsell_filter"]=="all_upsells"?"selected=selected":""?>><?php _e('Only Upsell Orders','woocommerce_one_click_upsell_funnel')?></option>
				</select>
			<?php endif;

			if( !isset( $_GET["mwb_wocuf_pro_upsell_filter"] ) ):?>
				<select name="mwb_wocuf_pro_upsell_filter">
					<option value="all"><?php _e('All Orders','woocommerce_one_click_upsell_funnel')?></option>
					<option value="no_upsells"><?php _e('No Upsell Orders','woocommerce_one_click_upsell_funnel')?></option>
					<option value="all_upsells"><?php _e('Only Upsell Orders','woocommerce_one_click_upsell_funnel')?></option>
				</select>
			<?php endif;
		}
	}

	/**
	 * Modifying query vars for filtering Upsell Orders.
	 *
	 * @since    1.0.0
	 * @param    array    $vars    array of queries
	 * @return   array    $vars    array of queries alongwith select dropdown query for upsell
	 */

	public function mwb_wocuf_pro_request_query( $vars )
	{

		if( isset( $_GET["mwb_wocuf_pro_upsell_filter"] ) && $_GET["mwb_wocuf_pro_upsell_filter"] == "all_upsells" )
		{
			$vars = array_merge( $vars, array( 'meta_key' => 'mwb_wocuf_upsell_order' ) );
		}
		elseif( isset( $_GET["mwb_wocuf_pro_upsell_filter"] ) && $_GET["mwb_wocuf_pro_upsell_filter"] == "no_upsells" )
		{
			$vars = array_merge( $vars, array( 'meta_key' => 'mwb_wocuf_upsell_order' , 'meta_compare' => 'NOT EXISTS' ) );
		}

		return $vars;
	} 


	/**
	 * adding distraction free mode to the offers page.
	 *
	 * @since    	1.0.0
	 * @param  		$page_template 		default template for the page
	 */

	public function mwb_wocuf_pro_page_template( $page_template )
	{
		$pages_available = get_posts(array(
			'posts_per_page' 		=> -1,
			'post_type' 			=> 'any',
			'post_status' 			=> 'publish',
			's' 					=> '[mwb_wocuf_pro_funnel_default_offer_page]',
			'orderby' 				=> 'ID',
			'order' 				=> 'ASC',
		));

		$pages_available = array_merge( get_posts(array(
			'posts_per_page' 		=> -1,
			'post_type' 			=> 'any',
			'post_status' 			=> 'publish',
			's' 					=> '[mwb_upsell_default_offer_identification]',
			'orderby' 				=> 'ID',
			'order' 				=> 'ASC',
		)), $pages_available );

		
		foreach( $pages_available as $single_page ) {

			if( is_page( $single_page->ID ) ) {
				
				$page_template = dirname( __FILE__ ) .'/partials/templates/mwb-wocuf-pro-template.php';
			}
		}

		return $page_template;
	}

	/**
	 * Adding new tab for upsell sales report in admin reports section
	 *
	 * @since    	1.0.0
	 * @param  		$tabs 		tabs of the report section
	 */

	public function mwb_wocuf_pro_maintain_report( $tabs ) {

		$tabs['mwb_wocuf_reports'] = array(
			'title' 		=>  __( 'WooCommerce One Click Upsell Funnel', 'woocommerce_one_click_upsell_funnel' ),
			'reports' 		=> array(
				'mwb_wocuf_report_by_date' => array(
					'title'       => __( 'Upsell Funnel Revenue By Date', 'woocommerce_one_click_upsell_funnel' ),
					'description' => '',
					'hide_title'  => FALSE,
					'callback'    => array( $this, 'mwb_wocuf_pro_get_upsell_report' ),
				),
			)
		);

		return $tabs;
	}

	/**
	 * Hide Upsell offer pages in admin panel 'Pages'.
	 *
	 * @since    	3.0.0
	 */
	public function hide_upsell_offer_pages_in_admin( $query ) {

		// Make sure we're in the admin and it's the main query
	    if ( !is_admin() && !$query->is_main_query() ) {

	        return;
	    }

	    global $typenow;

	    // Only do this for pages
	    if ( !empty( $typenow ) && 'page' == $typenow ) {

	    	$saved_offer_post_ids = get_option( 'mwb_upsell_lite_offer_post_ids', array() );

			if( !empty( $saved_offer_post_ids ) && is_array( $saved_offer_post_ids ) && count( $saved_offer_post_ids ) ) {

		        // Don't show the special pages.
		        $query->set( 'post__not_in', $saved_offer_post_ids );

		        return;
		    }

	    }

	}

	/**
	 * Add 'Upsell Support' column on payment gateways page.
	 *
	 * @since    	3.0.0
	 */
	public function upsell_support_in_payment_gateway( $default_columns ) {

		$new_column['mwb_upsell'] =  esc_html__( 'Upsell Supported', 'woocommerce_one_click_upsell_funnel' );

		// Place at second last position.
		$position = count( $default_columns ) - 1;

		$default_columns = array_slice( $default_columns, 0, $position, true) + $new_column + array_slice( $default_columns, $position, count( $default_columns ) - $position, true );

		return $default_columns;
	}

	/**
	 * 'Upsell Support' content on payment gateways page.
	 *
	 * @since    	3.0.0
	 */
	public function upsell_support_content_in_payment_gateway( $gateway ) {

		$supported_gateways = mwb_upsell_lite_supported_gateways();

		echo '<td class="mwb_upsell_supported">';

		if( in_array( $gateway->id, $supported_gateways ) ) {

			echo '<span class="status-enabled">' . esc_html__(  'Yes', 'woocommerce_one_click_upsell_funnel' ) . '</span>';
		}
		else {

			echo '<span class="status-disabled">' . esc_html__(  'No', 'woocommerce_one_click_upsell_funnel' ) . '</span>';
		}	

		echo '</td>';
	}

	/**
	 * Dismiss Elementor inactive notice.
	 *
	 * @since    	3.0.0
	 */
	public function dismiss_elementor_inactive_notice() {

		set_transient( 'mwb_upsell_elementor_inactive_notice', 'notice_dismissed' );

		wp_die();
	}

}
?>