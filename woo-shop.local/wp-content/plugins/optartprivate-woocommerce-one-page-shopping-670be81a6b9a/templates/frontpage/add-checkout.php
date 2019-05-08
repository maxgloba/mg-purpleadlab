<?php
/*
 * Template adds the checkout into product page
 * @param string $plugin_identifier
 */

?>

<script type="text/javascript">
	(function( $ ) {
		'use strict';
		$(function() {
			function checkoutLoad(){
				$.ajax({
					type: 'POST',
					url: checkoutUrl,
					dataType: "html",
					success: function (response) {
						$('.checkoutPage').html(response);
						$('.checkoutPage').slideDown('slow');
					}
				});
			}checkoutLoad();
		});
	})( jQuery );
</script>
<section class="one-page-shopping-section" id="one-page-shopping-checkout" >
	<div id="one-page-shopping-checkout-content">
		<div class="checkoutPage" style="display:none;"></div>
	</div>
</section>
