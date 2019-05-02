<?php
add_action( 'wp_footer', 'learn_q_view_product', PHP_INT_MAX );
function learn_q_view_product() {
	if ( is_product() ) {
		global $product;
		$parent_product_id = $product->get_parent_id();
        if ($product->get_parent_id() == 0 ) {
			$parent_product_id = $product->get_id();
        }
		$product_title    = (string) $product->get_name();
		$product_id       = (int) $product->get_id();
		$parent_product_id = (int) $parent_product_id;
		$permalink        = (string) get_permalink( $product->get_id() );
		$price            = (float) $product->get_price();
		$image            = (string) wp_get_attachment_url(get_post_thumbnail_id($product->get_id()));
		$categories_array = get_the_terms( $product->get_id(), 'product_cat' );
		if ($categories_array === false) {
			$categories_array = array();
		}
		$categories       = (string) json_encode( wp_list_pluck( $categories_array, 'name' ) );
		$output = <<<EOT
			<script>
			    var title = "{$product_title}";
				var _learnq = _learnq || [];
				_learnq.push(['track', 'Viewed Product', {
					Title: title,
					ItemId: {$parent_product_id},
					variantId: {$product_id},
					Categories: {$categories}, // The list of categories is an array of strings.
					ImageUrl: '{$image}',
					Url: '{$permalink}',
					Metadata: {
						Price: {$price},
					}
				}]);
			</script>
EOT;
		echo $output;
	}
}