<?php
/**
 * Storefront engine room
 *
 * @package storefront
 */

/**
 * Assign the Storefront version to a var
 */
$theme              = wp_get_theme( 'storefront' );
$storefront_version = $theme['Version'];

/**
 * Set the content width based on the theme's design and stylesheet.
 */
if ( ! isset( $content_width ) ) {
	$content_width = 980; /* pixels */
}

$storefront = (object) array(
	'version'    => $storefront_version,

	/**
	 * Initialize all the things.
	 */
	'main'       => require 'inc/class-storefront.php',
	'customizer' => require 'inc/customizer/class-storefront-customizer.php',
);

require 'inc/storefront-functions.php';
require 'inc/storefront-template-hooks.php';
require 'inc/storefront-template-functions.php';

if ( class_exists( 'Jetpack' ) ) {
	$storefront->jetpack = require 'inc/jetpack/class-storefront-jetpack.php';
}

if ( storefront_is_woocommerce_activated() ) {
	$storefront->woocommerce            = require 'inc/woocommerce/class-storefront-woocommerce.php';
	$storefront->woocommerce_customizer = require 'inc/woocommerce/class-storefront-woocommerce-customizer.php';

	require 'inc/woocommerce/class-storefront-woocommerce-adjacent-products.php';

	require 'inc/woocommerce/storefront-woocommerce-template-hooks.php';
	require 'inc/woocommerce/storefront-woocommerce-template-functions.php';
	require 'inc/woocommerce/storefront-woocommerce-functions.php';
}

if ( is_admin() ) {
	$storefront->admin = require 'inc/admin/class-storefront-admin.php';

	require 'inc/admin/class-storefront-plugin-install.php';
}

/**
 * NUX
 * Only load if wp version is 4.7.3 or above because of this issue;
 * https://core.trac.wordpress.org/ticket/39610?cversion=1&cnum_hist=2
 */
if ( version_compare( get_bloginfo( 'version' ), '4.7.3', '>=' ) && ( is_admin() || is_customize_preview() ) ) {
	require 'inc/nux/class-storefront-nux-admin.php';
	require 'inc/nux/class-storefront-nux-guided-tour.php';

	if ( defined( 'WC_VERSION' ) && version_compare( WC_VERSION, '3.0.0', '>=' ) ) {
		require 'inc/nux/class-storefront-nux-starter-content.php';
	}
}

/**
 * Note: Do not add any custom code here. Please use a custom plugin so that your customizations aren't lost during updates.
 * https://github.com/woocommerce/theme-customisations
 */



	remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_title', 5 );
	remove_action( 'woocommerce_product_thumbnails', 'woocommerce_show_product_thumbnails', 20 );
	remove_action( 'woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_link_open', 20 );
	remove_action( 'woocommerce_after_product_thumbnails', 'woocommerce_template_single_excerpt', 20 );
	remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 10 );

	function open_block() {
		echo '<div class="product-item__right">';
	}
	function close_block() {
		echo '</div>';
	}
	function excerpt_to_product_archives() {
		echo get_the_excerpt();
	}
	function woocommerce_template_loop_product_title() {
		echo '<div class="product-item__title bold">' . get_the_title() . '</div>';
	}
	function woocommerce_template_loop_product_thumbnail() {
		echo '<div class="product-item__left">'.woocommerce_get_product_thumbnail().'</div>'; // WPCS: XSS ok.
	}
	function woocommerce_template_loop_product_link_open() {
		global $product;
		$link = apply_filters( 'woocommerce_loop_product_link', get_the_permalink(), $product );
		echo '<a href="' . esc_url( $link ) . '" class="product-item__link">';
	}
	function woocommerce_template_loop_product_link_more() {
		global $product;
		$link = apply_filters( 'woocommerce_loop_product_link', get_the_permalink(), $product );
		echo '<a href="' . esc_url( $link ) . '" class="product-item__more">Learn more</a>';
	}
	function woocommerce_template_loop_save() {
		global $product;
		echo '<img src="https://e-markethub.com/quiz/woo/wp-content/uploads/2019/04/trust-us-1.png" alt="" width="100%">';
	}
	function product_item_bottom_open() {
		echo '<div class="product-item__bottom">';
	}
	function product_item_bottom_close() {
		echo '</div>';
	}


	add_action( 'woocommerce_after_shop_loop_item_title', 'open_block', 1 );
		add_action( 'woocommerce_product_thumbnails', 'woocommerce_template_loop_product_title', 10 );
		add_action( 'woocommerce_product_thumbnails', 'woocommerce_template_loop_product_thumbnail', 20 );
		add_action( 'woocommerce_after_shop_loop_item_title', 'excerpt_to_product_archives', 40 );
		add_action( 'woocommerce_after_shop_loop_item_title', 'product_item_bottom_open', 45 );
			add_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 50 );
			add_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_save', 60 );
		add_action( 'woocommerce_after_shop_loop_item_title', 'product_item_bottom_close', 70 );
	add_action( 'woocommerce_after_shop_loop_item_title', 'close_block', 100 );
	add_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_product_link_more', 110 );