<?php
/*
 * Template adds the cart into product page
 * @param string $plugin_identifier
 */
?>

<script type="text/javascript">
    /* global ops_php_data */
    ops_php_data['display_cart'] = true;
</script>
<section class="one-page-shopping-section" id="one-page-shopping-cart">
    <h1 class="one-page-shopping-header" id="one-page-shopping-header">
        <?php _e( 'Cart', 'woocommerce' ); ?>
    </h1>
    <div id="one-page-shopping-cart-content">
        <?php require('cart.php'); ?>
    </div>
</section>
