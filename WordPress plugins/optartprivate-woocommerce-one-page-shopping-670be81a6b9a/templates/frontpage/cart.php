<?php
/**
 * This template renders just a cart
 */
?>
<?php if (  WC()->cart && sizeof( WC()->cart->get_cart() ) > 0 ) : ?>
    <?php echo do_shortcode( '[woocommerce_cart]'); ?>
<?php endif;