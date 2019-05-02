<?php
/**
 * The Template for displaying product archives, including the main shop page which is a post type archive
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/archive-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.4.0
 */

defined( 'ABSPATH' ) || exit;

get_header( 'shop' ); ?>

<section class="product-section" id="product-section">
	<div class="container">
		<h2 class="title"><?php the_field('pr_title', 5); ?></h2>
		<div class="text"><?php the_field('pr_subtitle', 5); ?></div>



<?php
if ( woocommerce_product_loop() ) {

	/**
	 * Hook: woocommerce_before_shop_loop.
	 *
	 * @hooked woocommerce_output_all_notices - 10
	 * @hooked woocommerce_result_count - 20
	 * @hooked woocommerce_catalog_ordering - 30
	 */
	//do_action( 'woocommerce_before_shop_loop' );

	woocommerce_product_loop_start();

	if ( wc_get_loop_prop( 'total' ) ) {
		while ( have_posts() ) {
			the_post();

			/**
			 * Hook: woocommerce_shop_loop.
			 *
			 * @hooked WC_Structured_Data::generate_product_data() - 10
			 */
			do_action( 'woocommerce_shop_loop' );

/**
 * The template for displaying product content within loops
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.4.0
 */


global $product;

// Ensure visibility.
if ( empty( $product ) || ! $product->is_visible() ) {
	return;
}
?>
<li class="product-section__product-item <?php if( $i=='2' ){echo 'accented-item';} ?>">
	<?php
	/**
	 * Hook: woocommerce_before_shop_loop_item.
	 *
	 * @hooked woocommerce_template_loop_product_link_open - 10
	 */
	do_action( 'woocommerce_before_shop_loop_item' );

	/**
	 * Hook: woocommerce_before_shop_loop_item_title.
	 *
	 * @hooked woocommerce_show_product_loop_sale_flash - 10
	 * @hooked woocommerce_template_loop_product_thumbnail - 10
	 */
	do_action( 'woocommerce_before_shop_loop_item_title' );

	/**
	 * Hook: woocommerce_shop_loop_item_title.
	 *
	 * @hooked woocommerce_template_loop_product_title - 10
	 */
	do_action( 'woocommerce_shop_loop_item_title' );

	/**
	 * Hook: woocommerce_after_shop_loop_item_title.
	 *
	 * @hooked woocommerce_template_loop_rating - 5
	 * @hooked woocommerce_template_loop_price - 10
	 */
	do_action( 'woocommerce_after_shop_loop_item_title' );


	/**
	 * Hook: woocommerce_after_shop_loop_item.
	 *
	 * @hooked woocommerce_template_loop_product_link_close - 5
	 * @hooked woocommerce_template_loop_add_to_cart - 10
	 */

	$is_offset = get_field('is_offset');
	$of_title = get_field('of_title');
	$of_subtitle = get_field('of_subtitle');
	$of_image = get_field('of_image');
	$of_description = get_field('of_description');
	$btn_green = get_field('btn_green');
	$btn_light = get_field('btn_light');
	$post_id = get_the_ID();

	if ($is_offset) {
		echo '<a class="button scroll-btn customBoxDisplay" data-template="product_'.$post_id.'" >Add to cart</a>';
		echo '
			<template id="product_'.$post_id.'">
				<div class="container">
					<h2 class="title">'.$of_title.'</h2>
					<div class="sub-title">'.$of_subtitle.'</div>
					<div class="s-offer-section__dscr-wrap">
						<div class="s-offer-section__img-col"><img src="'.$of_image.'" alt="'.$of_title.'"></div>
						<div class="s-offer-section__dscr-col">
							'.$of_description.'
							<div class="subscribe-btns">
		';
								if( have_rows('btn_green') ): while ( have_rows('btn_green') ) : the_row(); ?>
									<a href="/quiz/woo/?add-to-cart=<?php the_sub_field('product_id'); ?>" class="accent-btn alert product_type_simple add_to_cart_button ajax_add_to_cart" rel="nofollow" data-quantity="<?php the_sub_field('product_quantity'); ?>" data-product_id="<?php the_sub_field('product_id'); ?>" aria-label="Add “<?php the_sub_field('product_name'); ?>” to your cart">YES I WANT</a>
								<?php endwhile; endif; ?>

								<?php if( have_rows('btn_light') ): while ( have_rows('btn_light') ) : the_row(); ?>
									<a href="/quiz/woo/?add-to-cart=<?php the_sub_field('product_id'); ?>" class="s-offer-section__no-s-offer-link alert product_type_simple add_to_cart_button ajax_add_to_cart" rel="nofollow" data-quantity="<?php the_sub_field('product_quantity'); ?>" data-product_id="<?php the_sub_field('product_id'); ?>" aria-label="Add “<?php the_sub_field('product_name'); ?>” to your cart">NO, I DON’T WANT</a>
								<?php endwhile; endif;
		echo '
							</div>
						</div>
					</div>
				</div>
			</template>
		';
	} else {
		do_action( 'woocommerce_after_shop_loop_item' );
	}
	?>
</li>
<?php
		}
	}

	woocommerce_product_loop_end();

	/**
	 * Hook: woocommerce_after_shop_loop.
	 *
	 * @hooked woocommerce_pagination - 10
	 */
	echo '<section class="s-offer-section" id="offer"></section>';

	do_action( 'woocommerce_after_shop_loop' );
} else {
	/**
	 * Hook: woocommerce_no_products_found.
	 *
	 * @hooked wc_no_products_found - 10
	 */
	do_action( 'woocommerce_no_products_found' );
}
?>


	</div>
</section>
<?php
	get_footer( 'shop' );