<?php

namespace PixelYourSite\Pinterest;

use PixelYourSite;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

function maybeMigrate() {
	
	if ( defined( 'DOING_AJAX' ) && DOING_AJAX ) {
		return;
	}
	
	if ( ! is_admin() || ! current_user_can( 'manage_options' ) ) {
		return;
	}
	
	$pinterest_version = get_option( 'pys_pinterest_version', false );
	
	// migrate from 1.x
	if ( $pinterest_version && version_compare( $pinterest_version, PYS_PINTEREST_VERSION, '<' ) ) {
		
		migrate_v1_options();
		migrate_v1_pinterest_events();

		update_option( 'pys_pinterest_version', PYS_PINTEREST_VERSION );
	
	}
	
}

function migrate_v1_pinterest_events() {
	global $post;
	
	$query = new \WP_Query( array(
		'post_type'      => 'pys_pinterest_event',
		'posts_per_page' => - 1
	) );
	
	/**
	 * Dynamic events on v6 can has various types of triggers per event. Script collects common event params and
	 * creates new v7 event for each trigger type from source event.
	 */
	$customEvents = array();
	
	if ( $query->have_posts() ) {
		while ( $query->have_posts() ) {
			$query->the_post();
			
			/**
			 * Collect common event params: custom event state, Facebook event type and params
			 */
			$v6_state = get_post_meta( $post->ID, '_state', true ); // active/paused
			$v1_pinterest_event_type = get_post_meta( $post->ID, '_pinterest_event_type', true );
			
			if ( $v1_pinterest_event_type == 'CustomEvent' ) {
				$pinterest_event_type = 'CustomEvent';
				$pinterest_custom_event_type = get_post_meta( $post->ID, '_pinterest_event_custom_name', true );
			} else {
				$pinterest_event_type = $v1_pinterest_event_type;
				$pinterest_custom_event_type = null;
			}
			
			$pinterest_custom_params = array();
			$v1_pinterest_props = get_post_meta( $post->ID, '_pinterest_event_properties', true );
			
			if ( is_array( $v1_pinterest_props ) ) {
				foreach ( $v1_pinterest_props as $v1_pinterest_prop_name => $v1_pinterest_prop_value ) {
					$pinterest_custom_params[] = array(
						'name'  => $v1_pinterest_prop_name,
						'value' => $v1_pinterest_prop_value,
					);
				}
			}
			
			$customEventCommonParams = array(
				'title'                       => $post->post_title,
				'enabled'                     => $v6_state == 'active',
				'delay'                       => null,
				'triggers'                    => array(),
				'url_filters'                 => array(),
				'pinterest_enabled'           => true,
				'pinterest_event_type'        => $pinterest_event_type,
				'pinterest_custom_event_type' => $pinterest_custom_event_type,
				'pinterest_params_enabled'    => empty( $pinterest_custom_params ) ? false : true,
				'pinterest_custom_params'     => $pinterest_custom_params,
			);
			
			/**
			 * Collect custom event triggers
			 */
			$v6_type = get_post_meta( $post->ID, '_type', true );  // on_page/dynamic
			
			if ( $v6_type == 'on_page' ) {
				
				$page_visit_triggers = array();
				$v6_triggers         = get_post_meta( $post->ID, '_on_page_triggers', true );
				
				foreach ( $v6_triggers as $v6_trigger ) {
					
					if ( ! empty( $v6_trigger ) ) {
						
						$page_visit_triggers[] = array(
							'rule'  => 'contains',
							'value' => $v6_trigger,
						);
						
					}
					
				}
				
				$customEvent                        = $customEventCommonParams;
				$customEvent['delay']               = (int) get_post_meta( $post->ID, '_delay', true );
				$customEvent['trigger_type']        = 'page_visit';
				$customEvent['page_visit_triggers'] = $page_visit_triggers;
				
				$customEvents[] = $customEvent;
				
			} else {
				
				$triggers    = array();
				$v6_triggers = get_post_meta( $post->ID, '_dynamic_triggers', true );
				
				// collect and group triggers by type
				foreach ( $v6_triggers as $v6_trigger ) {
					
					if ( ! empty( $v6_trigger ) ) {
						
						if ( $v6_trigger['type'] == 'url_click' ) {
							
							if ( ! empty( $v6_trigger['value'] ) ) {
								
								$triggers['url_click'][] = array(
									'rule'  => 'contains',
									'value' => $v6_trigger['value'],
								);
								
							}
							
						} elseif ( $v6_trigger['type'] == 'css_click' ) {
							
							if ( ! empty( $v6_trigger['value'] ) ) {
								
								$triggers['css_click'][] = array(
									'rule'  => null,
									'value' => $v6_trigger['value'],
								);
								
							}
							
						} elseif ( $v6_trigger['type'] == 'css_mouseover' ) {
							
							if ( ! empty( $v6_trigger['value'] ) ) {
								
								$triggers['css_mouseover'][] = array(
									'rule'  => null,
									'value' => $v6_trigger['value'],
								);
								
							}
							
						} elseif ( $v6_trigger['type'] == 'scroll_pos' ) {
							
							if ( ! empty( $v6_trigger['value'] ) ) {
								
								$triggers['scroll_pos'][] = array(
									'rule'  => null,
									'value' => $v6_trigger['value'],
								);
								
							}
							
						}
						
					}
					
				}
				
				// sanitize url filters
				$url_filters    = array();
				$v6_url_filters = get_post_meta( $post->ID, '_dynamic_url_filters', true );
				
				if ( is_array( $v6_url_filters ) ) {
					foreach ( $v6_url_filters as $v6_url_filter ) {
						
						if ( ! empty( $v6_url_filter ) ) {
							$url_filters[] = $v6_url_filter;
						}
						
					}
				}
				
				// create new custom event for each trigger type
				foreach ( $triggers as $trigger_type => $triggers_values ) {
					
					$customEvent                                = $customEventCommonParams;
					$customEvent['trigger_type']                = $trigger_type;
					$customEvent[ $trigger_type . '_triggers' ] = $triggers_values;
					$customEvent['url_filters']                 = $url_filters;
					
					$customEvents[] = $customEvent;
					
				}
				
			}
			
		}
	}
	
	wp_reset_postdata();
	
	foreach ( $customEvents as $eventParams ) {
		PixelYourSite\CustomEventFactory::create( $eventParams );
	}

}

function migrate_v1_options() {

	$v1 = get_option( 'pys_pinterest', array() );
	
	$v2 = array(
		'license_key'     => isset( $v1['license_key'] ) ? $v1['license_key'] : null,
		'license_status'  => isset( $v1['license_status'] ) ? $v1['license_status'] : null,
		'license_expires' => isset( $v1['license_expires'] ) ? $v1['license_expires'] : null,
		
		'pixel_id'                 => isset( $v1['pixel_id'] ) ? array( $v1['pixel_id'] ) : null,
		'general_event_enabled'    => isset( $v1['general_event_enabled'] ) ? $v1['general_event_enabled'] : null,
		'adsense_enabled'          => isset( $v1['adsense_enabled'] ) ? $v1['adsense_enabled'] : null,
		'click_event_enabled'      => isset( $v1['click_event_enabled'] ) ? $v1['click_event_enabled'] : null,
		'watchvideo_event_enabled' => isset( $v1['youtube_enabled'] ) ? $v1['youtube_enabled'] : null,
		'search_event_enabled'     => isset( $v1['search_event_enabled'] ) ? $v1['search_event_enabled'] : null,
		
		'woo_purchase_enabled'          => isset( $v1['woo_purchase_enabled'] ) ? $v1['woo_purchase_enabled'] : null,
		'woo_initiate_checkout_enabled' => isset( $v1['woo_initiate_checkout_enabled'] ) ? $v1['woo_initiate_checkout_enabled'] : null,
		'woo_view_content_enabled'      => isset( $v1['woo_view_content_enabled'] ) ? $v1['woo_view_content_enabled'] : null,
		'woo_view_category_enabled'     => isset( $v1['woo_view_category_enabled'] ) ? $v1['woo_view_category_enabled'] : null,
		'woo_affiliate_enabled'         => isset( $v1['woo_affiliate_enabled'] ) ? $v1['woo_affiliate_enabled'] : null,
		'woo_paypal_enabled'            => isset( $v1['woo_paypal_enabled'] ) ? $v1['woo_paypal_enabled'] : null,
		
		'edd_purchase_enabled'          => isset( $v1['edd_purchase_enabled'] ) ? $v1['edd_purchase_enabled'] : null,
		'edd_initiate_checkout_enabled' => isset( $v1['edd_initiate_checkout_enabled'] ) ? $v1['edd_initiate_checkout_enabled'] : null,
		'edd_add_to_cart_enabled'       => isset( $v1['edd_add_to_cart_enabled'] ) ? $v1['edd_add_to_cart_enabled'] : null,
		'edd_view_content_enabled'      => isset( $v1['edd_view_content_enabled'] ) ? $v1['edd_view_content_enabled'] : null,
		'edd_view_category_enabled'     => isset( $v1['edd_view_category_enabled'] ) ? $v1['edd_view_category_enabled'] : null,
	);
	
	// cleanup
	foreach ( $v2 as $key => $value ) {
		if ( $value === null ) {
			unset( $v2[ $key ] );
		}
	}
	
	// update settings
	PixelYourSite\Pinterest()->updateOptions( $v2 );
	PixelYourSite\Pinterest()->reloadOptions();
	
}