<?php

/**
 * The file that defines the global plugin functions.
 *
 * All Global functions that are used through out the plugin.  
 *
 * @link       https://makewebbetter.com/
 * @since      2.0.0
 *
 * @package    Woocommerce_one_click_upsell_funnel
 * @subpackage Woocommerce_one_click_upsell_funnel/includes
 */

/**
 * Check if Elementor plugin is active or not.
 *
 * @since    3.0.0
 */
function mwb_upsell_lite_elementor_plugin_active() {

	if ( is_plugin_active( 'elementor/elementor.php' ) ) {

		return true;
	}

	else {	

		return false;
	}
}

/**
 * Validate upsell nonce.
 *
 * @since    3.0.0
 */
function mwb_upsell_lite_validate_upsell_nonce() {

	if (  isset( $_GET['ocuf_ns'] ) && wp_verify_nonce( sanitize_text_field( $_GET['ocuf_ns'] ) , 'funnel_offers' ) ) {

		return true;
	}

	else {	

		return false;
	}
}

/**
 * Get product discount.
 *
 * @since    3.0.0
 */
function mwb_upsell_lite_get_product_discount() {

	$mwb_wocuf_pro_offered_discount = '';

	$funnel_id = isset( $_GET[ 'ocuf_fid' ] )? sanitize_text_field( $_GET[ 'ocuf_fid' ] ) : 'not_set';
	$offer_id = isset( $_GET[ 'ocuf_ofd' ] )? sanitize_text_field( $_GET[ 'ocuf_ofd' ] ) : 'not_set';
	
	// If Live offer.
	if( 'not_set' !== $funnel_id && 'not_set' !== $offer_id ) {

		$mwb_wocuf_pro_all_funnels = get_option( 'mwb_wocuf_funnels_list' );

		$mwb_wocuf_pro_offered_discount	= $mwb_wocuf_pro_all_funnels[$funnel_id]["mwb_wocuf_offer_discount_price"][$offer_id];

		$mwb_wocuf_pro_offered_discount	= !empty( $mwb_wocuf_pro_all_funnels[$funnel_id]["mwb_wocuf_offer_discount_price"][$offer_id] ) ? $mwb_wocuf_pro_all_funnels[$funnel_id]["mwb_wocuf_offer_discount_price"][$offer_id] : '';
	}

	// When not live and only for admin view.
	elseif( current_user_can( 'manage_options' ) ) {

		// Get funnel and offer id from current offer page post id.
		global $post;
		$offer_page_id = $post->ID;

		$funnel_data = get_post_meta( $offer_page_id, 'mwb_upsell_funnel_data', true );

		$product_found_in_funnel = false;

		if( !empty( $funnel_data ) && is_array( $funnel_data ) && count( $funnel_data ) ) {

			$funnel_id = $funnel_data['funnel_id'];
			$offer_id = $funnel_data['offer_id'];

			if( isset( $funnel_id ) && isset( $offer_id ) ) {

				$mwb_wocuf_pro_all_funnels = get_option( 'mwb_wocuf_funnels_list' );

				// When New offer is added ( Not saved ) so only at that time it will return 50%.
				$mwb_wocuf_pro_offered_discount	= isset( $mwb_wocuf_pro_all_funnels[$funnel_id]["mwb_wocuf_offer_discount_price"][$offer_id] ) ? $mwb_wocuf_pro_all_funnels[$funnel_id]["mwb_wocuf_offer_discount_price"][$offer_id] : '50%';

				$mwb_wocuf_pro_offered_discount	= !empty( $mwb_wocuf_pro_offered_discount ) ? $mwb_wocuf_pro_offered_discount : '';
			}
		}

		// For Custom Page for Offer.
		else {

			// Get global product discount.

			$mwb_upsell_global_settings = get_option( 'mwb_upsell_lite_global_options', array() );
										
			$global_product_discount = isset( $mwb_upsell_global_settings['global_product_discount'] ) ? $mwb_upsell_global_settings['global_product_discount'] : '50%'; 

			$mwb_wocuf_pro_offered_discount = $global_product_discount;
		}
	}

	return $mwb_wocuf_pro_offered_discount;
}

/**
 * Upsell product id from url funnel and offer params.
 *
 * @since    3.0.0
 */
function mwb_upsell_lite_get_pid_from_url_params() {

	$params['status'] = 'false';

	if ( isset( $_GET['ocuf_ofd'] ) && isset( $_GET['ocuf_fid'] ) ) {	

		$params['status'] = 'true';

		$params['offer_id'] = sanitize_text_field( $_GET["ocuf_ofd"] );
		$params['funnel_id'] = sanitize_text_field( $_GET["ocuf_fid"] );
	}

	return $params;
}

/**
 * Upsell Live Offer URL parameters.
 *
 * @since    3.0.0
 */
function mwb_upsell_lite_live_offer_url_params() {

	$params['status'] = 'false';

	if ( isset( $_POST['ocuf_ns'] ) && isset( $_POST['ocuf_ok'] ) && isset( $_POST['ocuf_ofd'] ) && isset( $_POST['ocuf_fid'] ) && isset( $_POST['product_id'] ) ) {

		$params['status'] = 'true';

		$params['upsell_nonce'] = sanitize_text_field( $_POST["ocuf_ns"] );
		$params['order_key'] = sanitize_text_field( $_POST["ocuf_ok"] );
		$params['offer_id'] = sanitize_text_field( $_POST["ocuf_ofd"] );
		$params['funnel_id'] = sanitize_text_field( $_POST["ocuf_fid"] );
		$params['product_id'] = sanitize_text_field( $_POST["product_id"] );
	}

	elseif( isset( $_GET['ocuf_ns'] ) && isset( $_GET['ocuf_ok'] ) && isset( $_GET['ocuf_ofd'] ) && isset( $_GET['ocuf_fid'] ) && isset( $_GET['product_id'] ) ) {	

		$params['status'] = 'true';

		$params['upsell_nonce'] = sanitize_text_field( $_GET["ocuf_ns"] );
		$params['order_key'] = sanitize_text_field( $_GET["ocuf_ok"] );
		$params['offer_id'] = sanitize_text_field( $_GET["ocuf_ofd"] );
		$params['funnel_id'] = sanitize_text_field( $_GET["ocuf_fid"] );
		$params['product_id'] = sanitize_text_field( $_GET["product_id"] );
	}

	return $params;
}

/**
 * Handling Funnel offer-page posts deletion which are dynamically assigned.
 *
 * @since    3.0.0
 */
function mwb_upsell_lite_offer_page_posts_deletion() {

	// Get all funnels.
	$all_created_funnels = get_option( 'mwb_wocuf_funnels_list', array() );
	// Get all saved offer post ids.
	$saved_offer_post_ids = get_option( 'mwb_upsell_lite_offer_post_ids', array() );

	if( !empty( $all_created_funnels ) && is_array( $all_created_funnels ) && count( $all_created_funnels
	 ) && !empty( $saved_offer_post_ids ) && is_array( $saved_offer_post_ids ) && count( $saved_offer_post_ids
	 ) ) {

		$funnel_offer_post_ids = array();

	 	// Retrieve all valid( present in funnel ) offer assigned page post ids.
		foreach ( $all_created_funnels as $funnel_id => $single_funnel ) {

			if( !empty( $single_funnel['mwb_upsell_post_id_assigned'] ) && is_array( $single_funnel['mwb_upsell_post_id_assigned'] ) && count( $single_funnel['mwb_upsell_post_id_assigned'] ) ) {

				foreach ( $single_funnel['mwb_upsell_post_id_assigned'] as $offer_post_id ) {
					
					if( !empty( $offer_post_id ) ) {

						$funnel_offer_post_ids[] = $offer_post_id;
					}
				}
			}
		}

		// Now delete save posts which are not present in funnel.
		foreach ( $saved_offer_post_ids as $saved_offer_post_key => $saved_offer_post_id ) {
			
			if( !in_array( $saved_offer_post_id, $funnel_offer_post_ids ) ) {

				unset( $saved_offer_post_ids[$saved_offer_post_key] );

				// Delete post permanently.
				wp_delete_post( $saved_offer_post_id, true );
			}
		}

		// Update saved offer post ids array.
		$saved_offer_post_ids = array_values( $saved_offer_post_ids );
		update_option( 'mwb_upsell_lite_offer_post_ids', $saved_offer_post_ids );

	}
}

/**
 * Upsell supported payment gateways.
 *
 * @since    3.0.0
 */
function mwb_upsell_lite_supported_gateways() {

	$supported_gateways = array(
		'cod', // Cash on delivery
	);

	return $supported_gateways;
}

/**
 * Elementor Upsell offer template 1.
 *
 * ( Default Template ).
 *
 * @since    3.0.0
 */
function mwb_upsell_lite_elementor_offer_template_1() {

	$elementor_data = file_get_contents( MWB_WOCUF_DIRPATH . 'json/offer-template-1.json' );

	return $elementor_data;
}

/**
 * Elementor Upsell offer template 2.
 *
 * @since    3.0.0
 */
function mwb_upsell_lite_elementor_offer_template_2() {

	$elementor_data = file_get_contents( MWB_WOCUF_DIRPATH . 'json/offer-template-2.json' );

	return $elementor_data;
}

/**
 * Elementor Upsell offer template 3.
 *
 * Video Offer Template.
 *
 * @since    3.0.0
 */
function mwb_upsell_lite_lite_elementor_offer_template_3() {

	$elementor_data = file_get_contents( MWB_WOCUF_DIRPATH . 'json/offer-template-3.json' );

	return $elementor_data;
}

/**
 * Elementor Upsell offer template 3.
 *
 * Video Offer Template.
 *
 * @since    3.0.0
 */
function mwb_upsell_lite_gutenberg_offer_content() {


	$post_content = '<!-- wp:spacer {"height":50} -->
		<div style="height:50px" aria-hidden="true" class="wp-block-spacer"></div>
		<!-- /wp:spacer -->

		<!-- wp:heading {"align":"center"} -->
		<h2 style="text-align:center">Exclusive Special One time Offer for you</h2>
		<!-- /wp:heading -->

		<!-- wp:spacer {"height":50} -->
		<div style="height:50px" aria-hidden="true" class="wp-block-spacer"></div>
		<!-- /wp:spacer -->

		<!-- wp:html -->
		<div class="mwb_upsell_default_offer_image">[mwb_upsell_image]</div>
		<!-- /wp:html -->

		<!-- wp:spacer {"height":20} -->
		<div style="height:20px" aria-hidden="true" class="wp-block-spacer"></div>
		<!-- /wp:spacer -->

		<!-- wp:heading {"align":"center"} -->
		<h2 style="text-align:center">[mwb_upsell_title]</h2>
		<!-- /wp:heading -->

		<!-- wp:html -->
		<div class="mwb_upsell_default_offer_description">[mwb_upsell_desc]</div>
		<!-- /wp:html -->

		<!-- wp:heading {"level":3,"align":"center"} -->
		<h3 style="text-align:center">Special Offer Price : [mwb_upsell_price]</h3>
		<!-- /wp:heading -->

		<!-- wp:spacer {"height":15} -->
		<div style="height:15px" aria-hidden="true" class="wp-block-spacer"></div>
		<!-- /wp:spacer -->

		<!-- wp:html -->
		<div class="mwb_upsell_default_offer_variations">[mwb_upsell_variations]</div>
		<!-- /wp:html -->

		<!-- wp:button {"customBackgroundColor":"#78c900","align":"center","className":"mwb_upsell_default_offer_buy_now"} -->
		<div class="wp-block-button aligncenter mwb_upsell_default_offer_buy_now"><a class="wp-block-button__link has-background" href="[mwb_upsell_yes]" style="background-color:#78c900">Add this to my Order</a></div>
		<!-- /wp:button -->

		<!-- wp:spacer {"height":25} -->
		<div style="height:25px" aria-hidden="true" class="wp-block-spacer"></div>
		<!-- /wp:spacer -->

		<!-- wp:button {"customBackgroundColor":"#e50000","align":"center","className":"mwb_upsell_default_offer_no_thanks"} -->
		<div class="wp-block-button aligncenter mwb_upsell_default_offer_no_thanks"><a class="wp-block-button__link has-background" href="[mwb_upsell_no]" style="background-color:#e50000">No thanks</a></div>
		<!-- /wp:button -->

		<!-- wp:html -->
		[mwb_upsell_default_offer_identification]
		<!-- /wp:html -->

		<!-- wp:spacer {"height":50} -->
		<div style="height:50px" aria-hidden="true" class="wp-block-spacer"></div>
		<!-- /wp:spacer -->';

		return $post_content;
}	