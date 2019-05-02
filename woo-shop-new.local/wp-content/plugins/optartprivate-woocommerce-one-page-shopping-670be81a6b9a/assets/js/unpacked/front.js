/**
 * JS scripts processed on front page.
 *
 *
 * ATTENTION!
 * Please remember about packing this file after you'll finish working on it.
 * Otherwise plugin won't work on production servers. Packed version of this
 * file should be placed in /assets/js/front-min.js. While packing, remember to check
 * option "Shrink variables".
 *
 *
 * @packer http://dean.edwards.name/packer/
 */

( function( $ ){
    $( document ).ready( function(){

    function set_cookie(cname, cvalue, exdays) {
        var d = new Date();
        d.setTime(d.getTime() + (exdays*24*60*60*1000));
        var expires = "expires="+ d.toUTCString();
        document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
    }

    function get_cookie(cname) {
        var name = cname + "=";
        var decodedCookie = decodeURIComponent(document.cookie);
        var ca = decodedCookie.split(';');
        for(var i = 0; i <ca.length; i++) {
            var c = ca[i];
            while (c.charAt(0) == ' ') {
                c = c.substring(1);
            }
            if (c.indexOf(name) == 0) {
                return c.substring(name.length, c.length);
            }
        }
        return "";
    }

    function delete_cookie( name ) {
      document.cookie = name + '=; expires=Thu, 01 Jan 1970 00:00:01 GMT;';
    }

    function copy_events($from, $to) {
        var events = $from.data('events');

        if ( events ) {
            for ( var eventType in events ) {
                for ( var idx in events[eventType] ) {
                    $to.on(eventType, events[eventType][idx].handler);
                }
            }
        }
    };

    if( ops_php_data.scroll_enabled ) {
    	//first visit scroll
    	$(window).load(function(){
    	    var scroll_cookie = get_cookie("ops_scroll_cookie");

    		if( scroll_cookie !== "scroll_done" ){

    			var scroll_to = scroll_cookie;
    			if ( scroll_cookie) {
    				$.scrollTo( scroll_cookie, {
    					duration: 'slow'
    				});
    			}

                delete_cookie('ops_scroll_cookie');
    		}
    	});
    }

	//function updates sidebar elements
	function ajax_cart_sidebar(){
		var ajax_data = {
			action: 'ops_update_header'
		};
		ajax_data[ops_php_data.nonce_post_id] = ops_php_data.nonce;

		$.ajax({
			type: 'post',
			url: ops_php_data.ajax_url,
			data: ajax_data,
			success: function( ajax_response ) {

				var sidebar = ops_php_data.sidebar_tag + ops_php_data.sidebar_attribute + ops_php_data.sidebar_attribute_value;
				var amount = ops_php_data.amount_tag + ops_php_data.amount_attribute + ops_php_data.amount_attribute_value;
				var contents = ops_php_data.contents_tag + ops_php_data.contents_attribute + ops_php_data.contents_attribute_value;

				if( ops_php_data.enable_cart_amount_update ){
					$(sidebar + " " + amount).html( $(ajax_response).filter('.amount').text() );
				}
				if( ops_php_data.enable_cart_contents_update ){
					$(sidebar + " " + contents).html( $(ajax_response).filter('.contents').text() );
				}
			}
		});
	};


        /**
         * Function makes an AJAX request and puts the response into cart container
         * @param ajax_data
         * @param update_cart
         * @param scroll_to
         * @param update_checkout
         */
        function ajax_request( $element, ajax_data, update_cart, scroll_to, update_checkout )
        {

        setTimeout(function(){
            console.log('go function');
            $('.checkout').remove();
            var checkoutPage = 'http://woo-shop-new.local/checkout/';
            $.ajax({
                type: 'POST',
                url: checkoutPage,
                dataType: "html",
                success: function (response) {
                    // var newForm = $(response).find('.checkout').html();
                    $('body').append('<div id="checkoutPage" style="max-height: 0px; overflow: hidden;">'+response+'</div>');
                    setTimeout(function(){
                        var newCheckout = $('#checkoutPage').find('form.checkout');
                        $('#one-page-shopping-checkout').append(newCheckout);
                    }, 500);
                }
            });
        }, 500);


            $.ajax({
                type: 'post',
				url: ops_php_data.ajax_url,
                data: ajax_data,
                success: function( response ) {
	                $element.removeClass('disabled');

    				if(ajax_data.action != 'ops_remove_coupon') {
                        $('#one-page-shopping-cart-content input[name="_wpnonce"]').val(response.cart_nonce);
                        if(response.fragments !== undefined){
    				    $( document.body ).trigger( 'added_to_cart', [ response.fragments.fragments, response.fragments.cart_hash, $element ] );
                        }
                        $element.closest('form').find('.added_to_cart').hide();

    	                wc_checkout_params.update_order_review_nonce = response.order_review_nonce;
                        wc_checkout_params.apply_coupon_nonce = response.apply_coupon_nonce;
                        wc_checkout_params.remove_coupon_nonce = response.remove_coupon_nonce;
    	                response = response.data;
    				}

					// put the html code into container
                    if ( update_cart ) {
                        $( '#one-page-shopping-cart-content' ).html( response );
                    }
                    if ( ops_php_data.display_cart ){
                        $( '#one-page-shopping-cart' ).show();
                    }else{
						$( '#one-page-shopping-cart' ).hide();
					}

                    // update checkout container if needed
                    if ( update_checkout === true ) {

                        $( '#one-page-shopping-checkout' ).show();

                        $( document.body ).trigger('update_checkout');
                        $(document.body).trigger('country_to_state_changed');

                        if( scroll_to !== false && scroll_to.length && !ops_php_data.force_refresh){

                            $( 'body' ).scrollTo( scroll_to, {
                                 duration: 'slow'
                            });

                        }

                    }

                    //ajax hack. refresh page
                    // ops_php_data.force_refresh
                    if( ops_php_data.force_refresh ){
                        if( scroll_to !== false && scroll_to.length ){
                            set_cookie("ops_scroll_cookie", scroll_to, 1);
                        }
                        if( $( '#one-page-shopping-cart-content table' ).length === 0 && update_cart ){
                            $( '#one-page-shopping-checkout, #one-page-shopping-cart' ).hide();
                            set_cookie("ops_scroll_cookie", "#page", 1);
                        }

                        location.reload();
                    }

                    // this part of code is copied from original WooCommerce file 'add-to-cart.js'
                    $( 'div.quantity:not(.buttons_added), td.quantity:not(.buttons_added)' )
                            .addClass( 'buttons_added' );

                    // hide the checkout when cart is empty
                    // ajax hack. disable scrolling on page refresh forced
                    // ops_php_data.force_refresh
                    if ( $( '#one-page-shopping-cart-content table' ).length === 0 && update_cart && !ops_php_data.force_refresh) {
                        $( '#one-page-shopping-checkout, #one-page-shopping-cart' ).hide();
                        $( 'body' ).scrollTo( '#page', {
                            duration: 'slow'
                        });
                    }

					//check if user want to update sidebar
					if( ops_php_data.enable_sidebar_update ){
						ajax_cart_sidebar();
					}

                    remove_unused_markup();

                }
            });
        };

        /**
         * remove all unnecessary markup which is automatically generated by cart/checkout
         */
        function remove_unused_markup()
        {
            for( var i = 0; i < ops_php_data.remove_items.length; i++ ) {
                $( ops_php_data.remove_items[i] ).remove();
            }
        }

        if( !ops_php_data.scroll_enabled ) {
            $('#one-page-shopping-checkout').find('input[autofocus]').removeAttr('autofocus');
        }

        // show the checkout in case when cart is not empty
        if ( ops_php_data.cart_count > 0 ) {
            $( '#one-page-shopping-checkout' ).css('display', 'block');
        }

        // Deprecated since WooCommerce 2.1, can be removed in a future;
        // set the functionality under "Ship to billing address" checkbox
        $( '#one-page-shopping-checkout-content' ).on( 'change', '#shiptobilling input', function() {
            $( 'div.shipping_address' ).hide();
            if ( !$(this).is( ':checked' ) ) {
                $( 'div.shipping_address' ).slideDown();
            }
        });
        $( '#shiptobilling input' ).change();

        // Used since WooCommerce 2.1;
        // set the functionality under "Ship to a different address?" checkbox
        $( '#one-page-shopping-checkout-content' ).on( 'change', '#ship-to-different-address-checkbox', function() {
            $( 'div.shipping_address' ).hide();
            if ( $(this).is( ':checked' ) ) {
                $( 'div.shipping_address' ).slideDown();
            }
        });
        $( '#ship-to-different-address-checkbox' ).change();


        /*
         * Helper function
         */
        function getFormData($form){
            var unindexed_array = $form.serializeArray();
            var indexed_array = {};

            $.map(unindexed_array, function(n, i){
                indexed_array[n['name']] = n['value'];
            });

            return indexed_array;
        }

        /**
         * Click on "Add to Cart" button, displayed on product page
         */
        $( 'form.cart' ).on( 'submit', function(event) {

            var $this = $(this);

            var ajax_data = getFormData($this),
                scroll_to = ops_php_data.display_cart ? '#one-page-shopping-header' : '#one-page-shopping-checkout-header',
                product_id =$this.find('[name="add-to-cart"]').val();

            // ajax_data = {
            //     'add-to-cart':  $( this ).data( 'product_id' ),
            // };
            ajax_data.action =  'ops_add_to_cart';

            ajax_data['add-to-cart'] = product_id;

            ajax_data[ops_php_data.nonce_post_id] = ops_php_data.nonce;
            //ajax_data.add_to_cart = $( this ).data( 'product_id' );

            var $buttons = $('button[type="submit"]');
            if(ops_php_data.scroll_enabled) ajax_request( $buttons, ajax_data, ops_php_data.display_cart, scroll_to, true );
            else ajax_request( $buttons, ajax_data, ops_php_data.display_cart, false, true );

            return false;
        });

        /**
         * Returns id and name for given input field
         * @param $input
         * @returns {{name: *}}
         */
        function getInputData($input)
        {
            var nameParts = $input.attr('name').split('['),
                data = {
                    name: nameParts[0]
                };

            if (nameParts[1] !== undefined) {
                data.id = nameParts[1].replace(']', '');
            }

            return data;
        }

        /**
         * Click on "Add to Cart" button, displayed on product list
         */
        $( '.products' ).on( 'click', '.product_type_simple', function( event ) {

            var $this = $(this);

            var prod_id = $( this ).data( 'product_id' ),
                scroll_to = ops_php_data.display_cart ? '#one-page-shopping-header' : '#one-page-shopping-checkout-header',
                ajax_data = {
                    action: 'ops_add_to_cart',
                    'add-to-cart': prod_id,
                    prod_id: prod_id,
                    quantity: $this.data('quantity') || 1
                };
            ajax_data[ops_php_data.nonce_post_id] = ops_php_data.nonce;

            if(ops_php_data.scroll_enabled) ajax_request( $(event.target), ajax_data, ops_php_data.display_cart, scroll_to, true );
            else ajax_request( $(event.target), ajax_data, ops_php_data.display_cart, false, true );
            return false;
        } );

		/*	Simple Type Product
		*	Click on "Add to cart" on post page - shortcode "[ops_to_cart]"
		*/
		$( '.one-page-shopping-add-to-cart' ).on( 'click', '.product_type_simple', function( event ) {

            var scroll_to = ops_php_data.display_cart ? '#one-page-shopping-header' : '#one-page-shopping-checkout-header',
                prod_id = $( this ).data( 'product_id' ),
                ajax_data = {
                    action: 'ops_add_to_cart',
                    'add-to-cart': prod_id,
                    prod_id: prod_id,
                    quantity: 1
                }

            if(ops_php_data.scroll_enabled)ajax_request( $(event.target), ajax_data, ops_php_data.display_cart, scroll_to, true );
            else ajax_request( $(event.target), ajax_data, ops_php_data.display_cart, false, true );
            return false;
        } );


        /**
         * Click on remove product from cart icon, on product page
         */
        $( '#one-page-shopping-cart-content' ).on( 'click', '.product-remove > a', function(event) {

            var parts = this.search.split( 'remove_item=' );
            if ( parts[1] !== undefined ) {

                parts = parts[1].split( '&' );
                if ( parts[0] !== undefined ) {

                    var ajax_data = {
                        action: 'ops_remove_from_cart',
                        cart_item: parts[0]
                    };
                    ajax_data[ops_php_data.nonce_post_id] = ops_php_data.nonce;

                    ajax_request( $(event.target).closest('form'), ajax_data, true, false, true );
                    return false;
                }
            }
        });

        /**
         * Click on remove product from cart icon, on product page
         */
        $( '#one-page-shopping-cart-content' ).on( 'click', '.product-remove > a', function(event) {

            var parts = this.search.split( 'remove_item=' );
            if ( parts[1] !== undefined ) {

                parts = parts[1].split( '&' );
                if ( parts[0] !== undefined ) {

                    var ajax_data = {
                        action: 'ops_remove_from_cart',
                        cart_item: parts[0]
                    };
                    ajax_data[ops_php_data.nonce_post_id] = ops_php_data.nonce;

                    ajax_request( $(event.target).closest('form'), ajax_data, true, false, true );
                    return false;
                }
            }
        });

        /**
         * Click on "Update Cart" button
         */
        $( '#one-page-shopping-cart-content' ).on( 'click', '[name=update_cart]', function(event) {

            var match,
                pattern = /\[(\w*)\]\[(\w*)\]/,
                ajax_data = {
                    action: 'ops_update_cart',
                    cart: new Object()
                };
            ajax_data[ops_php_data.nonce_post_id] = ops_php_data.nonce;

            // this part here generates the array with cart items. Format fits WC standards.
            $( this ).parents( 'form' ).find( 'input[name^=cart]' ).each( function() {
                match = $( this ).attr( 'name' ).match( pattern );
                if ( match[2] !== undefined ) {
                    // create a new cart item if doesn't exist
                    if ( ajax_data.cart[match[1]] === undefined ) {
                        ajax_data.cart[match[1]] = new Object();
                    }
                    ajax_data.cart[match[1]][match[2]] = $( this ).val();
                }
            });

            ajax_request( $(event.target), ajax_data, true, false, true );
            return false;
        });


        remove_unused_markup();

        if( ops_php_data.scroll_enabled ) {
        	if ( ops_php_data.display_cart && ( $( '#one-page-shopping-cart-content table' ).length !== 0 || ops_php_data.cart_count > 0 ) ) {
        		$( '#one-page-shopping-cart' ).show();
        	}else{
        		$( '#one-page-shopping-cart' ).hide();
        	}
        } else
        if( $( '#one-page-shopping-cart-content table' ).length !== 0 ) {
            var $divs = $( '#one-page-shopping-cart, #one-page-shopping-checkout' );
            $divs.find('[autofocus]').removeAttr('autofocus');
            $divs.css('display', 'block');
        }
    });
})( jQuery );
