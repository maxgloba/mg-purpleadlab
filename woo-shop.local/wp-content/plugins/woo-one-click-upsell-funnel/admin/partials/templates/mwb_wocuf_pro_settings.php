<?php
/**
 * Exit if accessed directly
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

 // Save settings on Save changes.
if( isset( $_POST["mwb_wocuf_pro_common_settings_save"] ) ) {

	$mwb_upsell_global_options = array();

	// Enable Plugin.
	$mwb_upsell_global_options['mwb_wocuf_enable_plugin'] = !empty( $_POST['mwb_wocuf_enable_plugin'] ) ? 'on' : 'off';

	// Global product id.
	$mwb_upsell_global_options['global_product_id'] = !empty( $_POST['global_product_id'] ) ? sanitize_text_field( $_POST['global_product_id'] ) : '';

	// Global product discount.
	$mwb_upsell_global_options['global_product_discount'] = !empty( $_POST['global_product_discount'] ) ? sanitize_text_field( $_POST['global_product_discount'] ) : '';

	// Skip similar offer.
	$mwb_upsell_global_options['skip_similar_offer'] = !empty( $_POST['skip_similar_offer'] ) ? sanitize_text_field( $_POST['skip_similar_offer'] ) : '';

	// Skip similar offer.
	$mwb_upsell_global_options['remove_all_styles'] = !empty( $_POST['remove_all_styles'] ) ? sanitize_text_field( $_POST['remove_all_styles'] ) : '';

	// Custom CSS.
	$mwb_upsell_global_options['global_custom_css'] = !empty( $_POST['global_custom_css'] ) ? sanitize_textarea_field( $_POST['global_custom_css'] ) : '';

	// Custom JS.
	$mwb_upsell_global_options['global_custom_js'] = !empty( $_POST['global_custom_js'] ) ? sanitize_textarea_field( $_POST['global_custom_js'] ) : '';

	// Save.
	update_option( 'mwb_wocuf_enable_plugin', $mwb_upsell_global_options['mwb_wocuf_enable_plugin'] );
	update_option( 'mwb_upsell_lite_global_options', $mwb_upsell_global_options );

	?>

	<!-- Settings saved notice. -->
	<div class="notice notice-success is-dismissible"> 
		<p><strong><?php _e('Settings saved','woocommerce_one_click_upsell_funnel'); ?></strong></p>
	</div>
	<?php
}  

// By default plugin will be enabled.
$mwb_wocuf_enable_plugin = get_option( 'mwb_wocuf_enable_plugin', 'on' );

$mwb_upsell_global_settings = get_option( 'mwb_upsell_lite_global_options', array() );

?>

<form action="" method="POST">
	<div class="mwb_upsell_table">
		<table class="form-table mwb_wocuf_pro_creation_setting">
			<tbody>

				<!-- Enable Plugin start -->
				<tr valign="top">

					<th scope="row" class="titledesc">
						<label for="mwb_wocuf_enable_plugin"><?php esc_html_e( 'Enable Upsell', 'woocommerce_one_click_upsell_funnel' );?></label>
					</th>

					<td class="forminp forminp-text">
						<?php 
						$attribut_description = esc_html__( 'Enable Upsell plugin.', 'woocommerce_one_click_upsell_funnel' );
						echo wc_help_tip( $attribut_description );
						?>

						<label class="mwb_wocuf_pro_enable_plugin_label">
							<input class="mwb_wocuf_pro_enable_plugin_input" type="checkbox" <?php echo ($mwb_wocuf_enable_plugin == 'on')?"checked='checked'":""?> name="mwb_wocuf_enable_plugin" >	
							<span class="mwb_wocuf_pro_enable_plugin_span"></span>
						</label>		
					</td>
				</tr>
				<!-- Enable Plugin end -->

				<!-- Payment Gateways start -->
				<tr valign="top">

					<th scope="row" class="titledesc">
						<label><?php esc_html_e( 'Payment Gateways', 'woocommerce_one_click_upsell_funnel' );?></label>
					</th>

					<td class="forminp forminp-text">
						<?php 
						$attribute_description = esc_html__( 'Please set up and activate Upsell supported payment gateways as offers will only appear through them.', 'woocommerce_one_click_upsell_funnel' );
						echo wc_help_tip( $attribute_description );
						?>
						<a href="<?php echo admin_url( 'admin.php?page=wc-settings&tab=checkout' ); ?>"><?php esc_html_e( 'Manage Upsell supported payment gateways &rarr;', 'woocommerce_one_click_upsell_funnel')?></a>		
					</td>
				</tr>
				<!-- Payment Gateways end -->

				<!-- Skip funnel for offers already in cart start -->
				<tr valign="top">

					<th scope="row" class="titledesc">
						<label><?php esc_html_e( 'Skip Funnel for Same Offer', 'woocommerce_one_click_upsell_funnel' );?></label>
					</th>

					<td>

						<?php 
						$attribut_description = __( 'Skip funnel if any offer product in funnel is already present during checkout.','woocommerce_one_click_upsell_funnel');
						echo wc_help_tip( $attribut_description );
						?>

						<?php 

						$skip_similar_offer = !empty( $mwb_upsell_global_settings['skip_similar_offer'] ) ? $mwb_upsell_global_settings['skip_similar_offer'] : 'yes';

						?>

						<select class="mwb_upsell_skip_similar_offer_select" name="skip_similar_offer">
						
							<option value="yes" <?php selected( $skip_similar_offer, 'yes' ); ?> ><?php esc_html_e( 'Yes', 'woocommerce_one_click_upsell_funnel' ); ?></option>
							<option value="no" <?php selected( $skip_similar_offer, 'no' ); ?> ><?php esc_html_e( 'No', 'woocommerce_one_click_upsell_funnel' ); ?></option>

						</select>
					</td>
				</tr>
				<!-- Skip funnel for offers already in cart end -->

				<!-- Remove all styles start -->
				<tr valign="top">

					<th scope="row" class="titledesc">
						<label><?php esc_html_e( 'Remove Styles from Offer Pages', 'woocommerce_one_click_upsell_funnel' );?></label>
					</th>

					<td>

						<?php 
						$attribut_description = __( 'Remove theme and other plugin styles from offer pages. (Not applicable for Custom Offer pages)','woocommerce_one_click_upsell_funnel');
						echo wc_help_tip( $attribut_description );
						?>

						<?php 

						$remove_all_styles = !empty( $mwb_upsell_global_settings['remove_all_styles'] ) ? $mwb_upsell_global_settings['remove_all_styles'] : 'yes';

						?>

						<select class="mwb_upsell_remove_all_styles_select" name="remove_all_styles">
						
							<option value="yes" <?php selected( $remove_all_styles, 'yes' ); ?> ><?php esc_html_e( 'Yes', 'woocommerce_one_click_upsell_funnel' ); ?></option>
							<option value="no" <?php selected( $remove_all_styles, 'no' ); ?> ><?php esc_html_e( 'No', 'woocommerce_one_click_upsell_funnel' ); ?></option>

						</select>
					</td>
				</tr>
				<!-- Remove all styles end -->

				<!-- Global product start -->
				<tr valign="top">

					<th scope="row" class="titledesc">
						<label><?php esc_html_e( 'Global Offer Product', 'woocommerce_one_click_upsell_funnel' );?></label>
					</th>

					<td>

						<?php 
						$attribut_description = __( '( Not for Live Offer ) Set Global Offer Product for Sandbox View of : 1) Offer page when no offer product is set. 2) Custom page for offer.','woocommerce_one_click_upsell_funnel');
						echo wc_help_tip( $attribut_description );
						?>

						<select class="wc-offer-product-search mwb_upsell_offer_product" name="global_product_id" data-placeholder="<?php esc_html_e( 'Search for a product&hellip;', 'woocommerce_one_click_upsell_funnel' ); ?>">
						<?php

							$global_product_id = !empty( $mwb_upsell_global_settings['global_product_id'] ) ? $mwb_upsell_global_settings['global_product_id'] : '';

							if ( !empty( $global_product_id ) ) {

								$global_product_title = get_the_title( $global_product_id );

								?>	

								<option value="<?php echo $global_product_id ?>" selected="selected"><?php echo $global_product_title . "( #$global_product_id )" ?>
									</option>

								<?php

							}
						?>
						</select>
					</td>
				</tr>
				<!-- Global product end -->

				<!-- Global Offer Discount start -->
				<tr valign="top">

					<th scope="row" class="titledesc">
						<label><?php esc_html_e( 'Global Offer Discount', 'woocommerce_one_click_upsell_funnel' );?></label>
					</th>

					<td>

						<div class="mwb_upsell_attribute_description">

							<?php 
							$attribut_description = __( '( Not for Live Offer ) Set Global Offer Discount in product price for Sandbox View of : 1) Custom page for offer.','woocommerce_one_click_upsell_funnel');
							echo wc_help_tip( $attribut_description );
							?>

							<?php

							$global_product_discount = isset( $mwb_upsell_global_settings['global_product_discount'] ) ? $mwb_upsell_global_settings['global_product_discount'] : '50%'; 

							?>

							<input type="text" name="global_product_discount" value="<?php echo $global_product_discount; ?>">
						</div>
						<span class="mwb_upsell_global_description"><?php esc_html_e( 'Specify new offer price or discount %' ,'woocommerce_one_click_upsell_funnel')?></span>
					</td>
				</tr>
				<!-- Global Offer Discount end -->

				<!-- Global Custom CSS start -->
				<tr valign="top">

					<th scope="row" class="titledesc">
						<label><?php esc_html_e( 'Global Custom CSS', 'woocommerce_one_click_upsell_funnel' );?></label>
					</th>

					<td>

						<div class="mwb_upsell_attribute_description">

							<?php 
							$attribut_description = __( 'Enter your Custom CSS without style tags.','woocommerce_one_click_upsell_funnel');
							echo wc_help_tip( $attribut_description );
							?>

							<?php

							$global_custom_css = !empty( $mwb_upsell_global_settings['global_custom_css'] ) ? $mwb_upsell_global_settings['global_custom_css'] : ''; 

							?>

							<textarea name="global_custom_css" rows="4" cols="50"><?php echo esc_html( wp_unslash( $global_custom_css ) ); ?></textarea>
						</div>
					</td>
				</tr>
				<!-- Global Custom CSS end -->

				<!-- Global Custom JS start -->
				<tr valign="top">

					<th scope="row" class="titledesc">
						<label><?php esc_html_e( 'Global Custom JS', 'woocommerce_one_click_upsell_funnel' );?></label>
					</th>

					<td>

						<div class="mwb_upsell_attribute_description">

							<?php 
							$attribut_description = __( 'Enter your Custom JS without script tags.','woocommerce_one_click_upsell_funnel');
							echo wc_help_tip( $attribut_description );
							?>

							<?php

							$global_custom_js = !empty( $mwb_upsell_global_settings['global_custom_js'] ) ? $mwb_upsell_global_settings['global_custom_js'] : ''; 

							?>

							<textarea name="global_custom_js" rows="4" cols="50"><?php echo esc_html( wp_unslash( $global_custom_js ) ); ?></textarea>
						</div>
					</td>
				</tr>
				<!-- Global Custom JS end -->
				
				
				<?php do_action("mwb_wocuf_pro_create_more_settings");?>
			</tbody>
		</table>
	</div>

	<p class="submit">
	<input type="submit" value="<?php _e('Save Changes', 'woocommerce_one_click_upsell_funnel'); ?>" class="button-primary woocommerce-save-button" name="mwb_wocuf_pro_common_settings_save" id="mwb_wocuf_pro_creation_setting_save" >
	</p>
</form>