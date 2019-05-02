<?php
/*
 * Template adds the checkout into product page
 * @param string $plugin_identifier
 */


// Add a flag to mark this is OPS checkout
add_action('woocommerce_checkout_after_customer_details', function(){
    echo '<input type="hidden" name="ops_checkout" value="true">';
});
?>

<script type="text/javascript">
    /* global ops_php_data */
    ops_php_data['display_checkout'] = true;
</script>
<section class="one-page-shopping-section" id="one-page-shopping-checkout">
    <h1 class="one-page-shopping-header" id="one-page-shopping-checkout-header">
        <?php _e( 'Checkout', 'woocommerce' ); ?>
    </h1>
    <div id="one-page-shopping-checkout-content">
        <?php require('checkout.php'); ?>
    </div>
</section>
