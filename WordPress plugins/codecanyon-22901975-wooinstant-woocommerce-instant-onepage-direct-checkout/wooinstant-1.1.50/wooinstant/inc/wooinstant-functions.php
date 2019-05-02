<?php
/**
 * WooInstant Functions
 *
 * @package WooInstant
 */

defined( 'ABSPATH' ) || exit;

/**
 * Wooinstant Cart Fragments
 */
function wooinstant_cart_fragments( $fragments ) {
	global $woocommerce;

    ob_start();
    wi_cart_count();
    $fragments['span.wi_cart_total'] = ob_get_clean();

    ob_start();
    wi_checkout_inner();
    $fragments['div.wi-checkout-inner'] = ob_get_clean();
    
    return $fragments;
    
}
add_filter( 'woocommerce_add_to_cart_fragments', 'wooinstant_cart_fragments', 10, 1 );

/**
 * Cart Count function 
 */
if ( ! function_exists( 'wi_cart_count' ) ) {
	function wi_cart_count() { ?>		
		<span class="wi_cart_total">
			<script type='text/javascript'>
			/* <![CDATA[ */
				var wiCartTotal = <?php echo WC()->cart->get_cart_contents_count(); ?>;
			/* ]]> */
			</script>
			<?php if ( WC()->cart->get_cart_contents_count() == 0 ) : ?>
				<style type="text/css" version="1.0">
					.wi-container{
						right: -50% !important;
					}
					.wi-cart-header.hascart {
						left: 0;
					}
					@media (max-width: 767px){
						.wi-container{
							right: -100% !important;
						}
					}
				</style>
			<?php endif; ?>
			<?php echo WC()->cart->get_cart_contents_count(); ?>
		</span> <?php
	}
}

/**
 * Cart Area function
 */
if ( ! function_exists( 'wi_cart_inner' ) ) {
	function wi_cart_inner() { 
		include plugin_dir_path( __FILE__ ) . '/templates/cart/cart.php';
	}
}

/**
 * Checkout Area function
 */
if ( ! function_exists( 'wi_checkout_inner' ) ) {
	function wi_checkout_inner() { ?>
		<div class="wi-checkout-inner">
			<button type="button" class="button alt" id="back_to_cart"><?php echo esc_attr('Back to cart','wooinstant'); ?></button>
			<?php echo do_shortcode('[woocommerce_checkout]');  ?>
		</div> <?php
	}
}

/**
 * Add wooinstant-active class to body
 */
function wi_body_classes( $classes ) {
	$classes[] = 'wooinstant-active';
	return $classes;
}
add_filter( 'body_class', 'wi_body_classes' );

/**
 * Calculate Shipping on Update Order Review
 */
function wi_action_woocommerce_checkout_update_order_review( $posted_data ) {
    WC()->cart->calculate_shipping();
}
add_action( 'woocommerce_checkout_update_order_review', 'wi_action_woocommerce_checkout_update_order_review', 10, 1 );

/**
 *	WooInstant Ajax functions
 */
// variable product quick view ajax actions
add_action('wp_ajax_wi_variable_product_quick_view', 'wi_ajax_quickview_variable_products');
add_action('wp_ajax_nopriv_wi_variable_product_quick_view', 'wi_ajax_quickview_variable_products');

// variable product quick view ajax function
function wi_ajax_quickview_variable_products(){
	global $post, $product, $woocommerce;
	check_ajax_referer( 'wi_ajax_nonce', 'security', false );

	add_action( 'wcqv_product_data', 'woocommerce_template_single_add_to_cart');

	$product_id = $_POST['product_id'];
    $wiqv_loop = new WP_Query(
        array(
            'post_type' => 'product',
            'p' => $product_id,
        )
    );

    ob_start();
	if( $wiqv_loop->have_posts() ) :
		while ( $wiqv_loop->have_posts() ) : $wiqv_loop->the_post(); ?>
			<?php wc_get_template( 'single-product/add-to-cart/variation.php' ); ?>
			<script>
	            jQuery.getScript("<?php echo $woocommerce->plugin_url(); ?>/assets/js/frontend/add-to-cart-variation.min.js");
	 	    </script> <?php 
			do_action( 'wcqv_product_data' );
	 	endwhile;
	endif;

	echo ob_get_clean();

	wp_die();
}

// single product ajax add to cart actions
add_action('wp_ajax_wi_single_ajax_add_to_cart', 'wi_single_ajax_add_to_cart');
add_action('wp_ajax_nopriv_wi_single_ajax_add_to_cart', 'wi_single_ajax_add_to_cart');

// single product ajax add to cart actions
function wi_single_ajax_add_to_cart() {

    $product_id = apply_filters('woocommerce_add_to_cart_product_id', absint($_POST['product_id']));
    $quantity = empty($_POST['quantity']) ? 1 : wc_stock_amount($_POST['quantity']);
    $variation_id = absint($_POST['variation_id']);
    $passed_validation = apply_filters('woocommerce_add_to_cart_validation', true, $product_id, $quantity);
    $product_status = get_post_status($product_id);

    if ($passed_validation && WC()->cart->add_to_cart($product_id, $quantity, $variation_id) && 'publish' === $product_status) {

        do_action('woocommerce_ajax_added_to_cart', $product_id);

        if ('yes' === get_option('woocommerce_cart_redirect_after_add')) {
            wc_add_to_cart_message(array($product_id => $quantity), true);
        }

        WC_AJAX :: get_refreshed_fragments();
    } else {

        $data = array(
            'error' => true,
            'product_url' => apply_filters('woocommerce_cart_redirect_after_error', get_permalink($product_id), $product_id));

        echo wp_send_json($data);
    }

    wp_die();
}

/**
 *	Custom CSS function 
 */
if( !function_exists( 'wi_custom_css' ) ){
	function wi_custom_css(){

		global $wiopt;
		$output = '';

		if( $wiopt["wi-zindex"] != '999' ) :
			$output .= '
			.wi-container{
				z-index: '.$wiopt["wi-zindex"].';
			}
			.select2-container{
				z-index: '.$wiopt["wi-zindex"].';
			}
			';
		endif;

		if( $wiopt["wi-container-bg"] != '#f5f5f5' ) :
			$output .= '
			.wi-container{
				background-color: '.$wiopt["wi-container-bg"].';
			}
			';
		endif;
		
		if( $wiopt["wi-quickview-bg"] != '#f5f5f5' ) :
			$output .= '
			.wi-quick-view{
				background-color: '.$wiopt["wi-quickview-bg"].';
			}
			';
		endif;

		if( $wiopt["wi-header-bg"] != '#f5f5f5' ) :
			$output .= '
			.wi-cart-header{
				background-color: '.$wiopt["wi-header-bg"].';
			}
			';
		endif;

		if( $wiopt["wi-header-text-color"] != '#272727' ) :
			$output .= '
			.wi-cart-header,
			.wi-cart-header:not([href]):not([tabindex]){ /*for bootstrap override*/
				color: '.$wiopt["wi-header-text-color"].';
			}
			';
		endif;
		if( $wiopt["wi-header-text-hovcolor"] != '' ) :
			$output .= '
			.wi-cart-header:hover,
			.wi-cart-header:not([href]):not([tabindex]):hover,
			.wi-cart-header:not([href]):not([tabindex]):focus{
				color: '.$wiopt["wi-header-text-hovcolor"].';
			}
			';
		endif;

		if( $wiopt["wi-drawer-direction"] == '1' ) :
			$output .= '
			.wi-container.drawer-left {
			    left: -50%;
			    right: unset;
			}
			.drawer-left .wi-cart-header{
			    right: 0;
			    left: unset;
			    border-top-left-radius: 0;
			    border-bottom-left-radius: 0;
			    border-top-right-radius: 4px;
			    border-bottom-right-radius: 4px;
			}

			.drawer-left .wi-cart-header.hascart{
			    z-index: 999;
			    right: -70px;
			}

			@media(max-width: 767px){
			    .wi-container.drawer-left{
			        width: 100%;
			        right: unset;
			        left: -100%;
			    }
			    .drawer-left .wi-cart-header.hascart.open {
			        right: 0;
			        z-index: 1;
			    }
			}

			';
		endif;

		$output .= $wiopt["wi-custom-css"]; //Custom css

		wp_add_inline_style( 'wooinstant-stylesheet', $output );
	}
}
add_action( 'wp_enqueue_scripts', 'wi_custom_css', 200 );


if( !function_exists( 'wi_custom_js' ) ){
	function wi_custom_js(){

		global $wiopt;

		$output = "
		(function($) {
    		'use strict';
    		jQuery(document).ready(function() { ";

    			if( $wiopt['wi-active-window'] == '1' ) : 

			    	$output .= "$(document).on('click', '#wi-toggler, .added_to_cart', function() {			    	    

			    	    $('#wi-cart-area .checkout-button').click();

			    	});";

    			endif;
	
		$output .= "    
			});
		})(jQuery);" ;

		wp_add_inline_script( 'wi-ajax-script', $output );
	}
}
add_action( 'wp_enqueue_scripts', 'wi_custom_js', 200 );