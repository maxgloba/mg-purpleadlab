<?php

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {

	exit;
}
/**
 * Funnel Creation Template.
 *
 * This template is used for creating new funnel as well
 * as viewing/editing previous funnels.
 * 
 */

// Push POST array data one by one.
function mwb_wocuf_pro_array_push_assoc( $array, $key, $value ) {

	$array[$key] = $value;
	return $array;
}

// New Funnel id.
if( !isset( $_GET['funnel_id'] ) ) {

	// Get all funnels.
	$mwb_wocuf_pro_funnels = get_option( 'mwb_wocuf_funnels_list', array() );

	if( !empty( $mwb_wocuf_pro_funnels ) ) {

		// Temp funnel variable.
		$mwb_wocuf_pro_funnel_duplicate = $mwb_wocuf_pro_funnels;

		// Make key pointer point to the end funnel.
		end( $mwb_wocuf_pro_funnel_duplicate );

		// Now key function will return last funnel key.
		$mwb_wocuf_pro_funnel_number = key( $mwb_wocuf_pro_funnel_duplicate );

		/**
		 * So new funnel id will be last key+1.
		 *
		 * Funnel key in array is funnel id. ( not really.. need to find, if funnel is deleted then keys change)
		 *
		 * Yes Funnel is identified by key, if deleted.. other funnel key ids will change.
		 * The array field mwb_wocuf_pro_funnel_id is not used so ignore it.
		 * if it is different from key means some funnel was deleted.
		 * So remember funnel id is its array[key].
		 *
		 * UPDATE : Remove array values, so now from v3 funnel id keys wont change after
		 * funnel deletion.
		 * The array field mwb_wocuf_pro_funnel_id will equal to funnel key from v3.
		 */
		$mwb_wocuf_pro_funnel_id = $mwb_wocuf_pro_funnel_number + 1;
	}

	else {

		// First funnel.
		// Firstly it was 0 now changed it to 1, make sure that doesn't cause any issues.
		$mwb_wocuf_pro_funnel_id = 1;	
	}
}

// Retrieve new funnel id from GET parameter when redirected from funnel list's page.
else {

	$mwb_wocuf_pro_funnel_id = sanitize_text_field( $_GET["funnel_id"] );
}

// When save changes is clicked.
if( isset( $_POST['mwb_wocuf_pro_creation_setting_save'] ) ) {
	
	unset( $_POST['mwb_wocuf_pro_creation_setting_save'] );

	// Saved funnel id.
	$mwb_wocuf_pro_funnel_id = sanitize_text_field( $_POST['mwb_wocuf_funnel_id'] );

	if( empty( $_POST["mwb_wocuf_target_pro_ids"] ) ) {

		$_POST["mwb_wocuf_target_pro_ids"] = array();
	}

	if( empty( $_POST['mwb_upsell_funnel_status'] ) ) {

		$_POST['mwb_upsell_funnel_status'] = 'no';
	}

	$mwb_wocuf_pro_funnel = array();

	// It's kind of $mwb_wocuf_pro_funnel =  $_POST, don't know why foreach, will find tomorrow.
	// Yes right $_POST and $mwb_wocuf_pro_funnel are same.
	// But still will keep it.
	// Why loop through each, so just removing it.
	// foreach( $_POST as $key => $data ) {

	// 	$mwb_wocuf_pro_funnel = mwb_wocuf_pro_array_push_assoc( $mwb_wocuf_pro_funnel, $key, $data );
	// }

	$mwb_wocuf_pro_funnel = $_POST;

	$mwb_wocuf_pro_funnel_series = array();
	
	// POST funnel as array at funnel id key.
	$mwb_wocuf_pro_funnel_series[$mwb_wocuf_pro_funnel_id] = $mwb_wocuf_pro_funnel;

	// Get all funnels.
	$mwb_wocuf_pro_created_funnels = get_option( "mwb_wocuf_funnels_list", array() );

	// If there are other funnels.
	if( is_array( $mwb_wocuf_pro_created_funnels ) && count( $mwb_wocuf_pro_created_funnels ) ) {

		$flag = 0;

		foreach( $mwb_wocuf_pro_created_funnels as $key => $data ) {

			// If funnel id key is already present, then replace that key in array.
			if( $key == $mwb_wocuf_pro_funnel_id ) {

				$mwb_wocuf_pro_created_funnels[$key] = $mwb_wocuf_pro_funnel_series[$mwb_wocuf_pro_funnel_id];
				$flag = 1;
				break;
			}
		}

		// If funnel id key not present then merge array.
		if( $flag != 1 ) {

			// Array merge was reindexing keys so using array union operator.
			$mwb_wocuf_pro_created_funnels = $mwb_wocuf_pro_created_funnels + $mwb_wocuf_pro_funnel_series;
		}

		update_option( 'mwb_wocuf_funnels_list', $mwb_wocuf_pro_created_funnels );
	}

	// If there are no other funnels.
	else {

		update_option( 'mwb_wocuf_funnels_list', $mwb_wocuf_pro_funnel_series );
	}

	// After funnel is saved.
	// Handling Funnel offer-page posts deletion which are dynamically assigned.
	mwb_upsell_lite_offer_page_posts_deletion();

	?>

	<!-- Settings saved notice -->
	<div class="notice notice-success is-dismissible"> 
		<p><strong><?php esc_html_e( 'Settings saved', 'woocommerce_one_click_upsell_funnel' ); ?></strong></p>
	</div>

	<?php
	
}	

// Get all funnels.
$mwb_wocuf_pro_funnel_data = get_option( 'mwb_wocuf_funnels_list', array() );

// Not used anywhere I guess.
$mwb_wocuf_pro_custom_th_page = !empty( $mwb_wocuf_pro_funnel_data[$mwb_wocuf_pro_funnel_id]["mwb_wocuf_pro_custom_th_page"] )?$mwb_wocuf_pro_funnel_data[$mwb_wocuf_pro_funnel_id]["mwb_wocuf_pro_custom_th_page"]:"off";

$mwb_wocuf_pro_funnel_schedule_options = array(
		'0'		=> __( 'on every Sunday', 'woocommerce_one_click_upsell_funnel' ),
		'1'		=> __( 'on every Monday', 'woocommerce_one_click_upsell_funnel'),
		'2'		=> __( 'on every Tuesday', 'woocommerce_one_click_upsell_funnel' ),
		'3'		=> __( 'on every Wednesday', 'woocommerce_one_click_upsell_funnel' ),
		'4'		=> __( 'on every Thursday', 'woocommerce_one_click_upsell_funnel' ),
		'5'		=> __( 'on every Friday', 'woocommerce_one_click_upsell_funnel' ),
		'6'		=> __( 'on every Saturday', 'woocommerce_one_click_upsell_funnel' ),
		'7'  	=> __( 'Daily', 'woocommerce_one_click_upsell_funnel' ),
	);

?>

<!-- FOR SINGLE FUNNEL -->
<form action="" method="POST">

	<div class="mwb_upsell_table">

		<table class="form-table mwb_wocuf_pro_creation_setting">

			<tbody>

				<input type="hidden" name="mwb_wocuf_funnel_id" value="<?php echo $mwb_wocuf_pro_funnel_id?>">

				<!-- Funnel saved after version 3. TO differentiate between new v3 users and old users. -->
				<input type="hidden" name="mwb_upsell_fsav3" value="true">

				<?php 

				$funnel_name = !empty( $mwb_wocuf_pro_funnel_data[$mwb_wocuf_pro_funnel_id]["mwb_wocuf_funnel_name"] ) ? $mwb_wocuf_pro_funnel_data[$mwb_wocuf_pro_funnel_id]["mwb_wocuf_funnel_name"] : esc_html__( 'Funnel', 'woocommerce_one_click_upsell_funnel' ) . " #$mwb_wocuf_pro_funnel_id";

				$funnel_status = !empty( $mwb_wocuf_pro_funnel_data[$mwb_wocuf_pro_funnel_id]["mwb_upsell_funnel_status"] ) ? $mwb_wocuf_pro_funnel_data[$mwb_wocuf_pro_funnel_id]["mwb_upsell_funnel_status"] : 'no';

				// Pre v3.0.0 Funnels will be live.
				// The first condition to ensure funnel is already saved. 
				if( !empty( $mwb_wocuf_pro_funnel_data[$mwb_wocuf_pro_funnel_id]["mwb_wocuf_funnel_name"] ) && empty( $mwb_wocuf_pro_funnel_data[$mwb_wocuf_pro_funnel_id]["mwb_upsell_fsav3"] ) ) {

					$funnel_status = 'yes';
				}


				?>

				<div id="mwb_upsell_funnel_name_heading" >

					<h2><?php echo $funnel_name; ?></h2>

					<div id="mwb_upsell_funnel_status" >
						<label>
							<input type="checkbox" id="mwb_upsell_funnel_status_input" name="mwb_upsell_funnel_status" value="yes" <?php checked( 'yes', $funnel_status ); ?> >
							<span class="mwb_upsell_funnel_span"></span>
						</label>

						<span class="mwb_upsell_funnel_status_on <?php echo 'yes' == $funnel_status ? 'active' : ''; ?>"><?php esc_html_e( 'Live', 'woocommerce_one_click_upsell_funnel' ); ?></span>
						<span class="mwb_upsell_funnel_status_off <?php echo 'no' == $funnel_status ? 'active' : ''; ?>"><?php esc_html_e( 'Sandbox', 'woocommerce_one_click_upsell_funnel' ); ?></span>
					</div>

				</div>

				<div class="mwb_upsell_offer_template_previews">

					<div class="mwb_upsell_offer_template_preview_one">
						<div class="mwb_upsell_offer_template_preview_one_sub_div"><img src="<?php echo MWB_WOCUF_URL . 'admin/resources/offer-previews/offer-template-one.png' ?>">
						</div>
					</div>

					<div class="mwb_upsell_offer_template_preview_two">
						<div class="mwb_upsell_offer_template_preview_two_sub_div"><img src="<?php echo MWB_WOCUF_URL . 'admin/resources/offer-previews/offer-template-two.png' ?>">
						</div>
					</div>

					<div class="mwb_upsell_offer_template_preview_three">
						<div class="mwb_upsell_offer_template_preview_three_sub_div"><img src="<?php echo MWB_WOCUF_URL . 'admin/resources/offer-previews/offer-template-three.png' ?>">
						</div>
					</div>

					<a href="javascript:void(0)" class="mwb_upsell_offer_preview_close"><span class="mwb_upsell_offer_preview_close_span"></span></a>
				</div>


				<!-- Funnel Name start-->
				<tr valign="top">

					<th scope="row" class="titledesc">
						<label for="mwb_wocuf_funnel_name"><?php esc_html_e('Name of the funnel','woocommerce_one_click_upsell_funnel');?></label>
					</th>

					<td class="forminp forminp-text">

						<?php 

						$description = esc_html__( 'Provide the name of your funnel','woocommerce_one_click_upsell_funnel' );
						echo wc_help_tip( $description );

						?>

						<input type="text" id="mwb_upsell_funnel_name" name="mwb_wocuf_funnel_name" value="<?php echo $funnel_name; ?>" id="mwb_wocuf_pro_funnel_name" class="input-text mwb_wocuf_pro_commone_class" required="" maxlength="30">
					</td>
				</tr>
				<!-- Funnel Name end-->

				<!-- Select Target product start -->
				<tr valign="top">

					<th scope="row" class="titledesc">
						<label for="mwb_wocuf_target_pro_ids"><?php esc_html_e( 'Select target product(s)', 'woocommerce_one_click_upsell_funnel');?></label>
					</th>

					<td class="forminp forminp-text">

						<?php 

						$description = esc_html__( 'If any one of these Target Products is checked out then the this funnel will be triggered and the below offers will be shown.', 'woocommerce_one_click_upsell_funnel' );

						echo wc_help_tip( $description );

						?>

						<select class="wc-funnel-product-search" multiple="multiple" style="" name="mwb_wocuf_target_pro_ids[]" data-placeholder="<?php esc_attr_e( 'Search for a product&hellip;', 'woocommerce_one_click_upsell_funnel' ); ?>">

						<?php

						if( !empty( $mwb_wocuf_pro_funnel_data ) ) {

							$mwb_wocuf_pro_target_products = isset( $mwb_wocuf_pro_funnel_data[$mwb_wocuf_pro_funnel_id]["mwb_wocuf_target_pro_ids"] ) ? $mwb_wocuf_pro_funnel_data[$mwb_wocuf_pro_funnel_id]["mwb_wocuf_target_pro_ids"] : array();

							// array_map with absint converts negative array values to positive, so that we dont get negative ids.
							$mwb_wocuf_pro_target_product_ids = !empty( $mwb_wocuf_pro_target_products ) ? array_map( 'absint',  $mwb_wocuf_pro_target_products ) : null;
							
							if ( $mwb_wocuf_pro_target_product_ids ) {

								foreach ( $mwb_wocuf_pro_target_product_ids as $mwb_wocuf_pro_single_target_product_id ) {

									$product_name =  get_the_title( $mwb_wocuf_pro_single_target_product_id );

									echo '<option value="' . $mwb_wocuf_pro_single_target_product_id . '" selected="selected" >' . $product_name . '(#' . $mwb_wocuf_pro_single_target_product_id . ')' . '</option>';
								}
							}
						}
						
						?>
						</select>		
					</td>	
				</tr>
				<!-- Select Target product end -->

				<!-- Schedule your Funnel start -->
				<tr valign="top">

					<th scope="row" class="titledesc">
						<label for="mwb_wocuf_pro_funnel_schedule"><?php _e('Funnel Schedule','woocommerce_one_click_upsell_funnel');?></label>
					</th>

					<td class="forminp forminp-text">

						<?php 

						$description = __('Schedule your funnel for specific weekdays.','woocommerce_one_click_upsell_funnel');

						echo wc_help_tip( $description );

						?>

						<select class="mwb_wocuf_pro_funnel_schedule" name="mwb_wocuf_pro_funnel_schedule">

							<?php

							$selected_week = !empty( $mwb_wocuf_pro_funnel_data[$mwb_wocuf_pro_funnel_id]["mwb_wocuf_pro_funnel_schedule"] ) ? $mwb_wocuf_pro_funnel_data[$mwb_wocuf_pro_funnel_id]["mwb_wocuf_pro_funnel_schedule"] : 7;

							foreach( $mwb_wocuf_pro_funnel_schedule_options as $key => $value ) {

								?>

								<option <?php echo $selected_week == $key ? 'selected=""' : ''; ?> value="<?php echo $key ?>"><?php echo $value ?></option>

								<?php
							}

							?>
						</select>			
					</td>	
				</tr>
				<!-- Schedule your Funnel end -->
				
			</tbody>
		</table>
		

		<div class="mwb_wocuf_pro_offers"><h1><?php esc_html_e( 'Funnel Offers', 'woocommerce_one_click_upsell_funnel');?></h1>
		</div>
		<br>
		<?php 

		// Funnel Offers array.
		$mwb_wocuf_pro_existing_offers = !empty( $mwb_wocuf_pro_funnel_data[$mwb_wocuf_pro_funnel_id]['mwb_wocuf_applied_offer_number'] ) ? $mwb_wocuf_pro_funnel_data[$mwb_wocuf_pro_funnel_id]['mwb_wocuf_applied_offer_number'] : '';

		// Array of offers with product Id.
		$mwb_wocuf_pro_product_in_offer = !empty( $mwb_wocuf_pro_funnel_data[$mwb_wocuf_pro_funnel_id]['mwb_wocuf_products_in_offer'] ) ? $mwb_wocuf_pro_funnel_data[$mwb_wocuf_pro_funnel_id]['mwb_wocuf_products_in_offer'] : '';

		// Array of offers with discount.
		$mwb_wocuf_pro_products_discount = !empty( $mwb_wocuf_pro_funnel_data[$mwb_wocuf_pro_funnel_id]['mwb_wocuf_offer_discount_price'] ) ? $mwb_wocuf_pro_funnel_data[$mwb_wocuf_pro_funnel_id]['mwb_wocuf_offer_discount_price'] : '';

		// Array of offers with Buy now go to link.
		$mwb_wocuf_pro_offers_buy_now_offers = !empty( $mwb_wocuf_pro_funnel_data[$mwb_wocuf_pro_funnel_id]['mwb_wocuf_attached_offers_on_buy'] ) ? $mwb_wocuf_pro_funnel_data[$mwb_wocuf_pro_funnel_id]['mwb_wocuf_attached_offers_on_buy'] : '';

		// Array of offers with No thanks go to link.
		$mwb_wocuf_pro_offers_no_thanks_offers = !empty( $mwb_wocuf_pro_funnel_data[$mwb_wocuf_pro_funnel_id]['mwb_wocuf_attached_offers_on_no'] ) ? $mwb_wocuf_pro_funnel_data[$mwb_wocuf_pro_funnel_id]['mwb_wocuf_attached_offers_on_no'] : '';

		// Array of offers with active template.
		$mwb_wocuf_pro_offer_active_template = !empty( $mwb_wocuf_pro_funnel_data[$mwb_wocuf_pro_funnel_id]['mwb_wocuf_pro_offer_template'] ) ? $mwb_wocuf_pro_funnel_data[$mwb_wocuf_pro_funnel_id]['mwb_wocuf_pro_offer_template'] : '';

		// Array of offers with custom page url.
		$mwb_wocuf_pro_offer_custom_page_url = !empty( $mwb_wocuf_pro_funnel_data[$mwb_wocuf_pro_funnel_id]['mwb_wocuf_offer_custom_page_url'] ) ? $mwb_wocuf_pro_funnel_data[$mwb_wocuf_pro_funnel_id]['mwb_wocuf_offer_custom_page_url'] : '';

		// Array of offers with their post id.
		$post_id_assigned_array = !empty( $mwb_wocuf_pro_funnel_data[$mwb_wocuf_pro_funnel_id]['mwb_upsell_post_id_assigned'] ) ? $mwb_wocuf_pro_funnel_data[$mwb_wocuf_pro_funnel_id]['mwb_upsell_post_id_assigned'] : '';

		// Funnel Offers array.
		// To be used for showing other offers except for itself in 'buy now' and 'no thanks' go to link.
		$mwb_wocuf_pro_existing_offers_2 = $mwb_wocuf_pro_existing_offers;

		?>

		<!-- Funnel Offers Start-->
		<div class="new_offers">

			<div class="new_created_offers" data-id="0"></div>

			<!-- FOR each SINGLE OFFER start -->

			<?php 

			if( !empty( $mwb_wocuf_pro_existing_offers ) ) {

				// Funnel Offers array. Foreach as offer_id => offer_id.
				// Key and value are always same as offer array keys are not reindexed.
				foreach( $mwb_wocuf_pro_existing_offers as $current_offer_id => $current_offer_id_val ) {

					$mwb_wocuf_pro_buy_attached_offers = '';

					$mwb_wocuf_pro_no_attached_offers = '';

					// Creating options html for showing other offers except for itself in 'buy now' and 'no thanks' go to link.
					if( !empty( $mwb_wocuf_pro_existing_offers_2 ) ) {

						foreach( $mwb_wocuf_pro_existing_offers_2 as $current_offer_id_2 ):

							if( $current_offer_id_2 != $current_offer_id ) {

								$mwb_wocuf_pro_buy_attached_offers .= '<option value=' . $current_offer_id_2 . '>' . __( 'Offer #', 'woocommerce_one_click_upsell_funnel' ) . $current_offer_id_2 . '</option>';
							
								$mwb_wocuf_pro_no_attached_offers .= '<option value=' . $current_offer_id_2 . '>' . __( 'Offer #', 'woocommerce_one_click_upsell_funnel' ) . $current_offer_id_2 . '</option>';
							}

						endforeach;
					}

					$mwb_wocuf_pro_buy_now_action_html = '';

					// For showing Buy Now selected link.
					if( !empty( $mwb_wocuf_pro_offers_buy_now_offers ) ) {
						
						// If link is set to No thanks.
						if( $mwb_wocuf_pro_offers_buy_now_offers[$current_offer_id] == 'thanks' ) {

							$mwb_wocuf_pro_buy_now_action_html = '<select name="mwb_wocuf_attached_offers_on_buy[' . $current_offer_id . ']"><option value="thanks" selected="">' . __( 'Order ThankYou Page', 'woocommerce_one_click_upsell_funnel') . '</option>' . $mwb_wocuf_pro_buy_attached_offers;
						}

						// If link is set to other offer.
						elseif( $mwb_wocuf_pro_offers_buy_now_offers[$current_offer_id] > 0 ) {

							$mwb_wocuf_pro_buy_now_action_html = '<select name="mwb_wocuf_attached_offers_on_buy[' . $current_offer_id . ']"><option value="thanks">' . __( 'Order ThankYou Page', 'woocommerce_one_click_upsell_funnel') . '</option>';
 
							if( !empty( $mwb_wocuf_pro_existing_offers_2 ) ) {

								// Loop through offers and set the saved one as selected.
								foreach( $mwb_wocuf_pro_existing_offers_2 as $current_offer_id_2 ) {

									if( $current_offer_id_2 != $current_offer_id ) {

										if( $mwb_wocuf_pro_offers_buy_now_offers[$current_offer_id] == $current_offer_id_2 ) {

											$mwb_wocuf_pro_buy_now_action_html .= '<option value=' . $current_offer_id_2 . ' selected="">' . __( 'Offer #', 'woocommerce_one_click_upsell_funnel' ) . $current_offer_id_2 . '</option>';
										}

										else {

											$mwb_wocuf_pro_buy_now_action_html .= '<option value=' . $current_offer_id_2 . '>' . __( 'Offer #', 'woocommerce_one_click_upsell_funnel' ) . $current_offer_id_2 . '</option>';
										}
									}
								}
							}
						}
					}

					$mwb_wocuf_pro_no_thanks_action_html = '';

					// For showing No Thanks selected link.
					if( !empty( $mwb_wocuf_pro_offers_no_thanks_offers ) ) {

						// If link is set to No thanks.
						if( $mwb_wocuf_pro_offers_no_thanks_offers[$current_offer_id] == 'thanks' ) {

							$mwb_wocuf_pro_no_thanks_action_html = '<select name="mwb_wocuf_attached_offers_on_no[' . $current_offer_id . ']"><option value="thanks" selected="">' . __( 'Order ThankYou Page', 'woocommerce_one_click_upsell_funnel' ) . '</option>' . $mwb_wocuf_pro_no_attached_offers;
						}

						// If link is set to other offer.
						elseif( $mwb_wocuf_pro_offers_no_thanks_offers[$current_offer_id] > 0 ) {

							$mwb_wocuf_pro_no_thanks_action_html = '<select name="mwb_wocuf_attached_offers_on_no[' . $current_offer_id . ']"><option value="thanks">' . __( 'Order ThankYou Page', 'woocommerce_one_click_upsell_funnel') . '</option>';

							if( !empty( $mwb_wocuf_pro_existing_offers_2 ) ) {

								// Loop through offers and set the saved one as selected.
								foreach( $mwb_wocuf_pro_existing_offers_2 as $current_offer_id_2 ) {  
								
									if( $current_offer_id != $current_offer_id_2 ) {

										if( $mwb_wocuf_pro_offers_no_thanks_offers[$current_offer_id]==$current_offer_id_2 ) {

											$mwb_wocuf_pro_no_thanks_action_html .= '<option value=' . $current_offer_id_2 . ' selected="">' . __( 'Offer #','woocommerce_one_click_upsell_funnel' ) . $current_offer_id_2.'</option>';
										}

										else {

											$mwb_wocuf_pro_no_thanks_action_html .= '<option value='.$current_offer_id_2 . '>' . __( 'Offer #','woocommerce_one_click_upsell_funnel' ) . $current_offer_id_2 . '</option>';
										}
									}
								}
							}
						}
					}
					
					$mwb_wocuf_pro_buy_now_action_html .= '</select>';

					$mwb_wocuf_pro_no_thanks_action_html .= '</select>';

					?>

					<!-- Single offer html start -->
					<div class="new_created_offers mwb_upsell_single_offer" data-id="<?php echo $current_offer_id ?>" data-scroll-id="#offer-section-<?php echo $current_offer_id ?>">

						<h2 class="mwb_upsell_offer_title" >
							<?php echo esc_html__( 'Offer #', 'woocommerce_one_click_upsell_funnel' ) . $current_offer_id; ?>
						</h2>

						<table>
							<!-- Offer product start -->
							<tr>
								<th><label><h4><?php esc_html_e( 'Offer Product', 'woocommerce_one_click_upsell_funnel')?></h4></label>
								</th>

								<td>
								<select class="wc-offer-product-search mwb_upsell_offer_product" name="mwb_wocuf_products_in_offer[<?php echo $current_offer_id; ?>]" data-placeholder="<?php esc_html_e( 'Search for a product&hellip;', 'woocommerce_one_click_upsell_funnel' ); ?>">
								<?php

									$current_offer_product_id = '';

									if( !empty( $mwb_wocuf_pro_product_in_offer[$current_offer_id] ) ) {

										// In v2.0.0, it was array so handling to get the first product id.
										if( is_array( $mwb_wocuf_pro_product_in_offer[$current_offer_id] ) && count( $mwb_wocuf_pro_product_in_offer[$current_offer_id] ) ) {

											foreach ( $mwb_wocuf_pro_product_in_offer[$current_offer_id] as $handling_offer_product_id ) {
												
												$current_offer_product_id = absint( $handling_offer_product_id );
												break;
											}

										}

										else {

											$current_offer_product_id = absint( $mwb_wocuf_pro_product_in_offer[$current_offer_id] );
										}
									}
								
									if ( !empty( $current_offer_product_id ) ) {

										$product_title = get_the_title( $current_offer_product_id );

										?>	

										<option value="<?php echo $current_offer_product_id ?>" selected="selected"><?php echo $product_title . "( #$current_offer_product_id )" ?>
											</option>

										<?php

									}
								?>
								</select>
								</td>
							</tr>
							<!-- Offer product end -->
							
							<!-- Offer price start -->
						    <tr>
							    <th><label><h4><?php esc_html_e( 'Offer Price / Discount', 'woocommerce_one_click_upsell_funnel' )?></h4></label>
							    </th>

							    <td>
							    <input type="text" class="mwb_upsell_offer_price" name="mwb_wocuf_offer_discount_price[<?php echo $current_offer_id?>]" value="<?php echo $mwb_wocuf_pro_products_discount[$current_offer_id]?>">
							    <span class="mwb_upsell_offer_description"><?php esc_html_e( 'Specify new offer price or discount %' ,'woocommerce_one_click_upsell_funnel')?></span>

							    </td>
						    </tr>
						    <!-- Offer price end -->

					    	<!-- Buy now go to link start -->
						    <tr>
							    <th><label><h4><?php _e('After \'Buy Now\' go to','woocommerce_one_click_upsell_funnel')?></h4></label>
							    </th>

							    <td>
							    	<?php echo $mwb_wocuf_pro_buy_now_action_html;?>
							    	<span class="mwb_upsell_offer_description"><?php esc_html_e( 'Select where the customer will be redirected after accepting this offer' ,'woocommerce_one_click_upsell_funnel')?></span>
							    </td>
							</tr>
							<!-- Buy now go to link end -->

							<!-- Buy now no thanks link start -->
							<tr>
								<th><label><h4><?php _e('After \'No thanks\' go to','woocommerce_one_click_upsell_funnel')?></h4></label>
								</th>

							    <td>
							    	<?php echo $mwb_wocuf_pro_no_thanks_action_html;?>
							    	<span class="mwb_upsell_offer_description"><?php esc_html_e( 'Select where the customer will be redirected after rejecting this offer' ,'woocommerce_one_click_upsell_funnel')?></span>
							    </td>
						    </tr>
						   <!-- Buy now no thanks link end -->

						   <!-- Section : Offer template start -->
						    <tr>
							    <th><label><h4><?php esc_html_e( 'Offer Template', 'woocommerce_one_click_upsell_funnel' )?></h4></label>
							    </th>

							    <?php 

						    	$assigned_post_id = !empty( $post_id_assigned_array[$current_offer_id] ) ? $post_id_assigned_array[$current_offer_id] : '';

							    ?>

							    <td>

									<?php if( !empty( $assigned_post_id ) ) : ?>

								    	<?php 

								    	$offer_template_active = !empty( $mwb_wocuf_pro_offer_active_template[$current_offer_id] ) ? $mwb_wocuf_pro_offer_active_template[$current_offer_id] : 'one';

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

										    	<div class="mwb_upsell_offer_template_sub_div"> 

											    	<h5><?php esc_html_e( 'LINK TO CUSTOM PAGE' , 'woocommerce_one_click_upsell_funnel' ); ?></h5>

											    	<?php if( 'custom' != $offer_template_active ) : ?>

											    		<button class="button-primary mwb_upsell_activate_offer_template" data-template-id="custom" data-offer-id="<?php echo $current_offer_id;?>" data-funnel-id="<?php echo $mwb_wocuf_pro_funnel_id; ?>" data-offer-post-id="<?php echo $assigned_post_id; ?>" ><?php esc_html_e( 'Activate' , 'woocommerce_one_click_upsell_funnel');?></button>

											    	<?php else : ?>	

											    		<h6><?php esc_html_e( 'Activated' , 'woocommerce_one_click_upsell_funnel' ); ?></h6>
											    		<p><?php esc_html_e( 'Please enter and save your custom page link below.' , 'woocommerce_one_click_upsell_funnel' ); ?></p>


											    	<?php endif; ?>

										    	</div>
										    	
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

						   <!-- Custom offer page url start -->
						    <tr>
							    <th><label><h4><?php esc_html_e( 'Offer Custom Page Link', 'woocommerce_one_click_upsell_funnel' )?></h4></label>
							    </th>

							    <td>
							    <input type="text" class="mwb_upsell_custom_offer_page_url" name="mwb_wocuf_offer_custom_page_url[<?php echo $current_offer_id?>]" value="<?php echo $mwb_wocuf_pro_offer_custom_page_url[$current_offer_id]?>">
							    </td>
						    </tr>
						    <!-- Custom offer page url end -->

						    <!-- Delete current offer ( Saved one ) -->
						    <tr>
							    <td colspan="2">
							    <button class="button mwb_wocuf_pro_delete_old_created_offers" data-id="<?php echo $current_offer_id ?>"><?php _e('Delete','woocommerce_one_click_upsell_funnel');?></button>
							    </td>
						    </tr>
						    <!-- Delete current offer ( Saved one ) -->
						    
					    </table>

					    <input type="hidden" name="mwb_wocuf_applied_offer_number[<?php echo $current_offer_id?>]" value="<?php echo $current_offer_id; ?>">

					    <input type="hidden" name="mwb_upsell_post_id_assigned[<?php echo $current_offer_id?>]" value="<?php echo $assigned_post_id; ?>">

				    </div>
				    <!-- Single offer html end -->
			    <?php
				}
			}
			?>
			<!-- FOR each SINGLE OFFER end -->
		</div>
		<!-- Funnel Offers End -->

		<!-- Add new Offer button with current funnel id as data-id -->
		<div class="mwb_wocuf_pro_new_offer">
			<button id="mwb_upsell_create_new_offer" class="mwb_wocuf_pro_create_new_offer" data-id="<?php echo $mwb_wocuf_pro_funnel_id?>">
			<?php esc_html_e( 'Add New Offer', 'woocommerce_one_click_upsell_funnel' );?>
			</button>
		</div>
		
		<!-- Save Changes for whole funnel -->
		<p class="submit">
			<input type="submit" value="<?php esc_html_e( 'Save Changes', 'woocommerce_one_click_upsell_funnel'); ?>" class="button-primary woocommerce-save-button" name="mwb_wocuf_pro_creation_setting_save" id="mwb_wocuf_pro_creation_setting_save" >
		</p>
	</div>
</form>