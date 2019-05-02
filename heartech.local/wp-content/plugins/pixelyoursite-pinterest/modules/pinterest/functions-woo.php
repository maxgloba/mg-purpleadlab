<?php

namespace PixelYourSite\Pinterest;

use PixelYourSite;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

function getWooCustomAudiencesOptimizationParams( $post_id ) {
	
	$post = get_post( $post_id );
	
	$params = array(
		'content_name'  => '',
		'category_name' => '',
	);
	
	if ( ! $post ) {
		return $params;
	}
	
	if ( $post->post_type == 'product_variation' ) {
		$post_id = $post->post_parent; // get terms from parent
	}
	
	$params['content_name']  = $post->post_title;
	$params['category_name'] = implode( ', ', PixelYourSite\getObjectTerms( 'product_cat', $post_id ) );
	
	return $params;
	
}

function getWooSingleAddToCartParams( $product_id, $qty = 1, $is_external = false ) {
	
	$params = array(
		'post_type'        => 'product',
		'product_id'       => $product_id,
		'product_quantity' => 1,
	);
	
	//@todo: track "product_variant_id"
	
	// content_name, category_name, tags
	$params['tags'] = implode( ', ', PixelYourSite\getObjectTerms( 'product_tag', $product_id ) );
	$params = array_merge( $params, getWooCustomAudiencesOptimizationParams( $product_id ) );
	
	// set option names
	$value_enabled_option = $is_external ? 'woo_affiliate_value_enabled' : 'woo_add_to_cart_value_enabled';
	$value_option_option  = $is_external ? 'woo_affiliate_value_option' : 'woo_add_to_cart_value_option';
	$value_global_option  = $is_external ? 'woo_affiliate_value_global' : 'woo_add_to_cart_value_global';
	$value_percent_option = $is_external ? '' : 'woo_add_to_cart_value_percent';
	
	// currency, value
	if ( PixelYourSite\PYS()->getOption( $value_enabled_option ) ) {
		
		if ( PixelYourSite\PYS()->getOption( 'woo_event_value' ) == 'custom' ) {
			$amount = PixelYourSite\getWooProductPrice( $product_id, $qty );
		} else {
			$amount = PixelYourSite\getWooProductPriceToDisplay( $product_id, $qty );
		}
		
		$value_option   = PixelYourSite\PYS()->getOption( $value_option_option );
		$global_value   = PixelYourSite\PYS()->getOption( $value_global_option, 0 );
		$percents_value = PixelYourSite\PYS()->getOption( $value_percent_option, 100 );
		
		$params['value']    = PixelYourSite\getWooEventValue( $value_option, $amount, $global_value, $percents_value );
		$params['currency'] = get_woocommerce_currency();
		
	}
	
	$params['product_price'] = PixelYourSite\getWooProductPriceToDisplay( $product_id );
	
	if ( $is_external ) {
		$params['action'] = 'affiliate button click';
	}
	
	return $params;
	
}

function getWooCartParams( $context = 'cart' ) {
	
	$params = array(
		'post_type' => 'product',
	);
	
	$line_items = array();
	
	foreach ( WC()->cart->cart_contents as $cart_item_key => $cart_item ) {
		
		$product_id = $cart_item['product_id'];
		
		//@todo: track "product_variant_id"
		
		// content_name, category_name, tags
		$cd_params = getWooCustomAudiencesOptimizationParams( $product_id );
		$tags = PixelYourSite\getObjectTerms( 'product_tag', $product_id );
		
		$line_item = array(
			'product_id' => $product_id,
			'product_quantity' => $cart_item['quantity'],
			'product_price' => PixelYourSite\getWooProductPriceToDisplay( $product_id, $cart_item['quantity'] ),
			'product_name' => $cd_params['content_name'],
			'product_category' => $cd_params['category_name'],
			'tags' => implode( ', ', $tags )
		);
		
		$line_items[] = $line_item;
		
	}
	
	$params['line_items'] = $line_items;
	
	if ( $context == 'InitiateCheckout' ) {
	
		$params['num_items'] = WC()->cart->get_cart_contents_count();

		$value_enabled_option = 'woo_initiate_checkout_value_enabled';
		$value_option_option  = 'woo_initiate_checkout_value_option';
		$value_global_option  = 'woo_initiate_checkout_value_global';
		$value_percent_option = 'woo_initiate_checkout_value_percent';

		$params['subtotal'] = PixelYourSite\getWooCartSubtotal();
	
	} elseif ( $context == 'PayPal' ) {
	
		$params['num_items'] = WC()->cart->get_cart_contents_count();

		$value_enabled_option = 'woo_paypal_value_enabled';
		$value_option_option  = 'woo_paypal_value_option';
		$value_global_option  = 'woo_paypal_value_global';
		$value_percent_option = '';

		$params['subtotal'] = PixelYourSite\getWooCartSubtotal();

		$params['action'] = 'PayPal';
	
	} else {
		
		$value_enabled_option = 'woo_add_to_cart_value_enabled';
		$value_option_option  = 'woo_add_to_cart_value_option';
		$value_global_option  = 'woo_add_to_cart_value_global';
		$value_percent_option = 'woo_add_to_cart_value_percent';
		
	}
	
	if ( PixelYourSite\PYS()->getOption( $value_enabled_option ) ) {
		
		if ( PixelYourSite\PYS()->getOption( 'woo_event_value' ) == 'custom' ) {
			$amount = PixelYourSite\getWooCartTotal();
		} else {
			$amount = $params['value'] = WC()->cart->subtotal;
		}
		
		$value_option   = PixelYourSite\PYS()->getOption( $value_option_option );
		$global_value   = PixelYourSite\PYS()->getOption( $value_global_option, 0 );
		$percents_value = PixelYourSite\PYS()->getOption( $value_percent_option, 100 );
		
		$params['value']    = PixelYourSite\getWooEventValue( $value_option, $amount, $global_value, $percents_value );
		$params['currency'] = get_woocommerce_currency();
		
	}
	
	return $params;
	
}

function getWooPurchaseParams( $context ) {
	
	$order_id = (int) wc_get_order_id_by_order_key( $_REQUEST['key'] );
	$order    = new \WC_Order( $order_id );
	
	$params = array(
		'post_type' => 'product',
	);
	
	$num_items = 0;
	$line_items = array();
	
	foreach ( $order->get_items( 'line_item' ) as $item ) {
		
		$product_id = $item['product_id'];
		
		//@todo: track "product_variant_id"
		
		// content_name, category_name, tags
		$cd_params = getWooCustomAudiencesOptimizationParams( $product_id );
		$tags      = PixelYourSite\getObjectTerms( 'product_tag', $product_id );
		
		$line_item = array(
			'product_id'       => $product_id,
			'product_quantity' => $item['qty'],
			'product_price'    => PixelYourSite\getWooProductPriceToDisplay( $product_id, $item['qty'] ),
			'product_name'     => $cd_params['content_name'],
			'product_category' => $cd_params['category_name'],
			'tags'             => implode( ', ', $tags )
		);
		
		$line_items[] = $line_item;
		$num_items += $item['qty'];

	}
	
	$params['line_items'] = $line_items;
	$params['order_quantity'] = $num_items;
	$params['currency']  = get_woocommerce_currency();
	
	// add "value" only on Purchase event
	if ( $context == 'Purchase' ) {
		
		if ( PixelYourSite\PYS()->getOption( 'woo_event_value' ) == 'custom' ) {
			$amount = PixelYourSite\getWooOrderTotal( $order );
		} else {
			$amount = $order->get_total();
		}
		
		$value_option   = PixelYourSite\PYS()->getOption( 'woo_purchase_value_option' );
		$global_value   = PixelYourSite\PYS()->getOption( 'woo_purchase_value_global', 0 );
		$percents_value = PixelYourSite\PYS()->getOption( 'woo_purchase_value_percent', 100 );
		
		$params['value'] = PixelYourSite\getWooEventValue( $value_option, $amount, $global_value, $percents_value );
		
	}
	
	if ( PixelYourSite\isWooCommerceVersionGte( '3.0.0' ) ) {

		$params['town']    = $order->get_billing_city();
		$params['state']   = $order->get_billing_state();
		$params['country'] = $order->get_billing_country();
		$params['payment'] = $order->get_payment_method_title();

	} else {

		$params['town']    = $order->billing_city;
		$params['state']   = $order->billing_state;
		$params['country'] = $order->billing_country;
		$params['payment'] = $order->payment_method_title;

	}
	
	// shipping method
	if ( $shipping_methods = $order->get_items( 'shipping' ) ) {

		$labels = array();
		foreach ( $shipping_methods as $shipping ) {
			$labels[] = $shipping['name'] ? $shipping['name'] : null;
		}

		$params['shipping'] = implode( ', ', $labels );

	}
	
	// coupons
	if ( $coupons = $order->get_items( 'coupon' ) ) {

		$labels = array();
		foreach ( $coupons as $coupon ) {
			$labels[] = $coupon['name'] ? $coupon['name'] : null;
		}

		$params['promo_code_used'] = 'yes';
		$params['promo_code'] = implode( ', ', $labels );

	} else {

		$params['promo_code_used'] = 'no';

	}
	
	$params['total'] = (float) $order->get_total( 'edit' );
	$params['tax']   = (float) $order->get_total_tax( 'edit' );
	
	if ( PixelYourSite\isWooCommerceVersionGte( '2.7' ) ) {
		$params['shipping_cost'] = (float) $order->get_shipping_total( 'edit' ) + (float) $order->get_shipping_tax( 'edit' );
	} else {
		$params['shipping_cost'] = (float) $order->get_total_shipping() + (float) $order->get_shipping_tax();
	}

	$customer_params = PixelYourSite\PYS()->getEventsManager()->getWooCustomerTotals();

	$params['lifetime_value']     = $customer_params['ltv'];
	$params['average_order']      = $customer_params['avg_order_value'];
	$params['transactions_count'] = $customer_params['orders_count'];
	
	return $params;
	
}