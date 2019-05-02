<?php

namespace PixelYourSite\Pinterest;

use PixelYourSite;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

function isPysProActive() {
	
	if ( ! function_exists( 'is_plugin_active' ) ) {
		include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
	}
	
	return is_plugin_active( 'pixelyoursite-pro/pixelyoursite-pro.php' );
	
}

function pysProVersionIsCompatible() {
	
	if ( ! function_exists( 'get_plugin_data' ) ) {
		include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
	}

	$data = get_plugin_data( WP_PLUGIN_DIR   . '/pixelyoursite-pro/pixelyoursite-pro.php', false, false );

	return version_compare( $data['Version'], PYS_PINTEREST_PRO_MIN_VERSION, '>=' );
	
}

function isPysFreeActive() {
    
    if ( ! function_exists( 'is_plugin_active' ) ) {
        include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
    }
    
    return is_plugin_active( 'pixelyoursite/facebook-pixel-master.php' );
    
}

function pysFreeVersionIsCompatible() {
    
    if ( ! function_exists( 'get_plugin_data' ) ) {
        include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
    }
    
    $data = get_plugin_data( WP_PLUGIN_DIR . '/pixelyoursite/facebook-pixel-master.php', false, false );
    
    return version_compare( $data['Version'], PYS_PINTEREST_FREE_MIN_VERSION, '>=' );
    
}

/**
 * Retrieves parameters values for for current queried object
 *
 * @return array
 */
function getTheContentParams( $allowedContentTypes = array() ) {
	global $post;
	
	$defaults = array(
		'on_posts_enabled'      => true,
		'on_pages_enables'      => true,
		'on_taxonomies_enabled' => true,
		'on_cpt_enabled'        => true,
		'on_woo_enabled'        => true,
		'on_edd_enabled'        => true,
	);
	
	$contentTypes = wp_parse_args( $allowedContentTypes, $defaults );
	
	$params = array();
	$cpt    = get_post_type();
	
	/**
	 * POSTS
	 */
	if ( $contentTypes['on_posts_enabled'] && is_singular( 'post' ) ) {
		
		$params['post_type'] = 'post';
		$params['post_id']   = $post->ID;
		$params['name']      = $post->post_title;
		$params['category']  = implode( ', ', PixelYourSite\getObjectTerms( 'category', $post->ID ) );
		$params['tags']      = implode( ', ', PixelYourSite\getObjectTerms( 'post_tag', $post->ID ) );
		
		return $params;
		
	}
	
	/**
	 * PAGES or FRONT PAGE
	 */
	if ( $contentTypes['on_pages_enables'] && ( is_singular( 'page' ) || is_home() ) ) {
		
		$params['post_type'] = 'page';
		$params['post_id']   = is_home() ? null : $post->ID;
		$params['name']      = is_home() == true ? get_bloginfo( 'name' ) : $post->post_title;
		
		return $params;
		
	}
	
	// WooCommerce Shop page
	if ( $contentTypes['on_pages_enables'] && PixelYourSite\isWooCommerceActive() && is_shop() ) {
		
		$page_id = (int) wc_get_page_id( 'shop' );
		
		$params['post_type'] = 'page';
		$params['post_id']   = $page_id;
		$params['name']      = get_the_title( $page_id );
		
		return $params;
		
	}
	
	/**
	 * TAXONOMIES
	 */
	if ( $contentTypes['on_taxonomies_enabled'] && ( is_category() || is_tax() || is_tag() ) ) {
		
		if ( is_category() ) {
			
			$cat  = get_query_var( 'cat' );
			$term = get_category( $cat );
			
			$params['taxonomy_type']    = 'category';
			$params['taxonomy_id']      = $cat;
			$params['taxonomy_name'] = $term->name;
			
		} elseif ( is_tag() ) {
			
			$slug = get_query_var( 'tag' );
			$term = get_term_by( 'slug', $slug, 'post_tag' );
			
			$params['taxonomy_type']    = 'tag';
			$params['taxonomy_id']      = $term->term_id;
			$params['taxonomy_name'] = $term->name;
			
		} else {
			
			$term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) );
			
			$params['taxonomy_type']    = get_query_var( 'taxonomy' );
			$params['taxonomy_id']      = $term->term_id;
			$params['taxonomy_name'] = $term->name;
			
		}
		
		return $params;
		
	}
	
	// WooCommerce Products
	if ( $contentTypes['on_woo_enabled'] && PixelYourSite\isWooCommerceActive() && $cpt == 'product' ) {
		
		$params['post_type']    = 'product';
		$params['product_id']   = $post->ID;
		$params['product_name'] = $post->post_title;
		
		$params['product_category'] = implode( ', ', PixelYourSite\getObjectTerms( 'product_cat', $post->ID ) );
		$params['tags']       = implode( ', ', PixelYourSite\getObjectTerms( 'product_tag', $post->ID ) );
		
		return $params;
		
	}
	
	// Easy Digital Downloads
	if ( $contentTypes['on_edd_enabled'] && PixelYourSite\isEddActive() && $cpt == 'download' ) {
		
		$params['post_type']    = 'download';
		$params['product_id']      = $post->ID;
		$params['product_name'] = $post->post_title;
		
		$params['product_category'] = implode( ', ', PixelYourSite\getObjectTerms( 'download_category', $post->ID ) );
		$params['tags']       = implode( ', ', PixelYourSite\getObjectTerms( 'download_tag', $post->ID ) );
		
		return $params;
		
	}
	
	/**
	 * Custom Post Type should be last one.
	 */
	
	// Custom Post Type
	if ( $contentTypes['on_cpt_enabled'] && $cpt ) {
		
		// skip products and downloads is plugins are activated
		if ( ( PixelYourSite\isWooCommerceActive() && $cpt == 'product' ) || ( PixelYourSite\isEddActive() && $cpt == 'download' ) ) {
			return $params;
		}
		
		$params['post_type'] = $cpt;
		$params['post_id']   = $post->ID;
		$params['name']      = $post->post_title;
		
		$params['tags'] = implode( ', ', PixelYourSite\getObjectTerms( 'post_tag', $post->ID ) );
		
		$taxonomies = get_post_taxonomies( get_post() );
		
		if ( ! empty( $taxonomies ) && $terms = PixelYourSite\getObjectTerms( $taxonomies[0], $post->ID ) ) {
			$params['category'] = implode( ', ', $terms );
		} else {
			$params['category'] = array();
		}
		
		return $params;
		
	}
	
	return array();
	
}

function getEnhancedMatchingParams() {
	
	$params = array();
	$user = wp_get_current_user();
	
	if ( $user->ID ) {
		$params['em'] = $user->get( 'user_email' );
	}
	
	/**
	 * Add purchase WooCommerce Enhanced Matching params
	 */
	if ( PixelYourSite\isWooCommerceActive() && PixelYourSite\PYS()->getOption( 'woo_enabled' ) ) {
		
		if ( is_order_received_page() && isset( $_REQUEST['key'] ) ) {
			
			$order_id = wc_get_order_id_by_order_key( $_REQUEST['key'] );
			$order    = wc_get_order( $order_id );
			
			if ( $order ) {
				
				if ( PixelYourSite\isWooCommerceVersionGte( '3.0.0' ) ) {
					$params['em'] = $order->get_billing_email();
				} else {
					$params['em'] = $order->billing_email;
				}
				
			}
			
		}
		
	}
	
	/**
	 * Add purchase EDD Enhanced Matching params
	 */
	
	if ( PixelYourSite\isEddActive() && PixelYourSite\PYS()->getOption( 'edd_enabled' ) ) {
		
		// skip payment confirmation page
		if ( edd_is_success_page() && ! isset( $_GET['payment-confirmation'] ) ) {
			global $edd_receipt_args;
			
			$session = edd_get_purchase_session();
			if ( isset( $_GET['payment_key'] ) ) {
				$payment_key = urldecode( $_GET['payment_key'] );
			} else if ( $session ) {
				$payment_key = $session['purchase_key'];
			} elseif ( $edd_receipt_args['payment_key'] ) {
				$payment_key = $edd_receipt_args['payment_key'];
			}
			
			if ( isset( $payment_key ) ) {
				
				$payment_id = edd_get_purchase_id_by_key( $payment_key );
				
				if ( $payment = edd_get_payment( $payment_id ) ) {
					$params['em'] = $payment->email;
				}
				
			}
			
		}
		
	}
	
	$sanitized = array();
	
	foreach ( $params as $key => $value ) {

		if ( ! empty( $value ) ) {
			$sanitized[ $key ] = sanitizeEnhancedMatchingParam( $value, $key );
		}

	}
	
	return $sanitized;
	
}

function sanitizeEnhancedMatchingParam( $value, $key ) {
	
	$value = strtolower( $value );
	
	if ( $key == 'ph' ) {
		$value = preg_replace( '/\D/', '', $value );
	} elseif ( $key == 'em' ) {
		$value = preg_replace( '/[^a-z0-9._+-@]+/i', '', $value );
	} else {
		$value = preg_replace( '/[^a-z]/', '', $value );
	}
	
	return $value;
	
}