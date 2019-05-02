<?php 
/**
 * WooInstant Layout Design
 *
 * @package  WooInstant
 */

defined( 'ABSPATH' ) || exit;

function wooinstant_layout( ){
	global $woocommerce;

	global $wiopt;
	
	if ( $wiopt['wi-active'] != true ) {
	    return;
	}
	if ( $wiopt['wi-show-oncart'] != '1' && is_cart() ) {
	    return;
	}
	if ( $wiopt['wi-show-oncheckout'] != '1' && is_checkout() ) {
	    return;
	}

	if ( class_exists('Woocommerce') ): ?>
		<div class="wi-container <?php if( $wiopt["wi-drawer-direction"] == '1' ){ echo 'drawer-left'; } ?>">
			<a id="wi-toggler" class="wi-cart-header <?php if( $wiopt['wi-cart-image']['url'] && $wiopt['wi-icon-choice']==2 ){ echo 'icon-img'; }?> <?php if( WC()->cart->get_cart_contents_count() > 0 ){ echo 'hascart'; } ?>">

				<?php if( $wiopt['wi-cart-image']['url'] && $wiopt['wi-icon-choice']==2 ){ ?>
					<img src="<?php echo $wiopt['wi-cart-image']['url']; ?>" alt="">
				<?php }else{ ?>
					<i class="fa fa-shopping-cart"></i>
				<?php } ?>

				<?php echo wi_cart_count(); ?>
			</a>
			<div class="wi-inner">
				<div class="wooinstant-content woocommerce">
					<div id="wi-cart-area">
						<?php do_action('before_cart_inner'); ?>
						<?php echo wi_cart_inner(); ?>
						<?php do_action('after_cart_inner'); ?>
					</div>
					<div id="wi-checkout-area">
						<?php do_action('before_checkout_inner'); ?>
						<?php echo wi_checkout_inner(); ?>
						<?php do_action('after_checkout_inner'); ?>
					</div>
				</div>
			</div>
		</div>
		<?php
	endif;
}
add_action( 'wp_footer', 'wooinstant_layout' );