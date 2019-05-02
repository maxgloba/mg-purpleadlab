(function( $ ) {
	'use strict';
	$(function() {

		$.fn.BeerSlider = function ( options ) {
			options = options || {};
			return this.each(function() {
				new BeerSlider(this, options);
			});
		};
		$('.beer-slider').BeerSlider({start: 50});

		$(document).on('click', '.faq-quest', function(){
			if ( $(this).parent().hasClass('open') ) {
				$('.faq-item').removeClass('open').find('.faq-answer').slideUp('fast');
			} else {
				$('.faq-item').removeClass('open').find('.faq-answer').slideUp('fast');
				$(this).parent().addClass('open').find('.faq-answer').slideDown('fast');
			}
		});

		$(document).on('click', '.top-section .scroll-btn', function(e){
			e.preventDefault();
			$('html, body').animate({
				scrollTop: $('#product-section').offset().top
			}, 600);
			return false;
		});

		$(document).on('click', '.modal-triger', function(e){
			e.preventDefault();
			var href = $(this).attr('href');
			$('body, html').css('overflow', 'hidden');
			$('html').css('width', 'calc(100% - 17px)');
			$('body').append('<section id="modal" class="modal"><span id="modal-close">×</span><div class="modal-container"></div></div>');
			setTimeout(function(){
				var template = $('template'+href).html();
				$('#modal').css({
					'visibility': 'visible',
					'opacity': '1',
				});
				$('#modal .modal-container').html(template).css('transform', 'scale(1)');
			}, 100);
			console.log('modal open');
		});

		$(document).on('click', '#modal-close', function(e){
			e.preventDefault();
			$('body, html').css('overflow', 'visible');
			$('html').css('width', '100%');
			$('#modal .modal-container').css('transform', 'scale(0)');
			$('#modal').css({
				'visibility': 'hidden',
				'opacity': '0',
			});
			setTimeout(function(){
				$('#modal').remove();
			}, 250);
			console.log('modal close');
		});

		$(document).on('click', '.product-item__more', function(e){
			e.preventDefault();

			$('body, html').css('overflow', 'hidden');
			$('html').css('width', 'calc(100% - 17px)');
			$('body').append('<section id="modal" class="modal"><span id="modal-close">×</span><div class="modal-container"></div></div>');

			var productUrl = $(this).attr('href');
			$.ajax({
				url: productUrl,
				dataType: "html",
				cache: true,
				method: 'POST',
				success: function (data) {
					var
						image = $(data).find('.product .wp-post-image').attr('data-src'),
						title = $(data).find('.product .product-item__title').html(),
						description = $(data).find('.product .woocommerce-product-details__short-description').html(),
						oldPrice = $(data).find('.product .old-price').html(),
						newPrice = $(data).find('.product .old-price + div').html(),
						savePrice = $(data).find('.product .new-price').html(),
						tabs = $(data).find('.product #tab-description').html(),
						html = '<div class="row">';
						html += '	<div class="col-md-6"><img src="'+image+'" ></div>';
						html += '	<div class="col-md-6"><h1>'+title+'</h1><div class="description">'+tabs+'</div>';
						html += '		<div class="price"><div class="text old-price m-spacer">'+oldPrice+'</div>';
						html += '		<div class="text bold big">'+newPrice+'</div>';
						html += '		<div class="text new-price">'+savePrice+'</div></div>';
						html += '	</div>';
						html += '</div>';
					setTimeout(function(){
						$('#modal').css({
							'visibility': 'visible',
							'opacity': '1',
						});
						$('#modal .modal-container').html(html).css('transform', 'scale(1)');
						// setTimeout(function(){
						// 	$('ul.tabs li:first-child').addClass('active');
						// 	$('ul.tabs + div').addClass('active');
						// }, 100);
					}, 100);
				}
			});
			console.log('product modal');
		});

		$(document).on('click', '.faq-triger', function(e){
			e.preventDefault();
			$('.faq_full').toggleClass('opened');
			$('html, body').animate({
				scrollTop: $('.main-footer').offset().top
			}, 600);
			console.log('faq');
		});

		$(document).on('click', 'ul.tabs li', function(e){
			e.preventDefault();

			if ( $(this).hasClass('active') ) {
				return
			} else {
				var tab = $(this).attr('aria-controls');

				$('ul.tabs li').removeClass('active');
				$(this).addClass('active');

				$('.woocommerce-Tabs-panel').hide();
				$('#'+tab).fadeIn().css('display', 'inline-block');
			}

		});

		$(document).on('click', '.customBoxDisplay', function(e){
			e.preventDefault();
			var templateId = $(this).data('template');
			var templateData = $('#'+templateId).html();
			$('#one-page-shopping-checkout').hide();
			$('#one-page-shopping-cart').hide();
			$('#offer').html(templateData).css('max-height', '2000px');
			setTimeout(function(){
				$('html, body').animate({
					scrollTop: $('#offer').offset().top
				}, 600);
			}, 100);
		});

		console.log('script loaded 777');

		// $(document).on('click', 'body', function(e){
		// 	e.preventDefault();
		// 	var flag1 = true;
		// 	var flag2 = true;
		// 	var flag3 = true;
		// 	$('#wowp_iptwpg_ipaytotal-card-number').keypress('change', function() {
		// 		console.log(flag1);
		// 		if (flag1){
		// 			$(this).mask("9999 9999 9999 9999");
		// 			console.log('#wowp_iptwpg_ipaytotal-card-number');
		// 			flag1 = false;
		// 		}
		// 	});
		// 	$('#wowp_iptwpg_ipaytotal-card-expiry').keypress('change', function() {
		// 		console.log(flag2);
		// 		if (flag2){
		// 			$(this).mask("99 / 9999");
		// 			console.log('#wowp_iptwpg_ipaytotal-card-expiry');
		// 			flag2 = false;
		// 		}
		// 	});
		// 	$('#wowp_iptwpg_ipaytotal-card-cvc').keypress('change', function() {
		// 		console.log(flag3);
		// 		if (flag3){
		// 			$(this).mask("999");
		// 			console.log('#wowp_iptwpg_ipaytotal-card-cvc');
		// 			flag3 = false;
		// 		}
		// 	});
		// });


		// $(document).on('click', '.closeOffer', function(e){
		// 	e.preventDefault();
		// 	$('#offer').css('max-height', '0px');
		// 	setTimeout(function(){
		// 		$('#one-page-shopping-cart').css('max-height', '2000px');
		// 		$('html, body').animate({
		// 			scrollTop: $('#one-page-shopping-cart').offset().top
		// 		}, 600);
		// 	}, 800);
		// });

		// $(document).on('click', '.add_to_cart_button', function(e){
		// 	e.preventDefault();
		// 	$('#offer').css('max-height', '0px');
		// 	$('#one-page-shopping-cart').css('max-height', '2000px');
		// 	$('html, body').animate({
		// 		scrollTop: $('#one-page-shopping-cart').offset().top
		// 	}, 600);
		// 	// return false;
		// });

		// $(document).on('click', '#openCheckout', function(e){
		// 	e.preventDefault();
		// 	$('#one-page-shopping-cart').css('max-height', '0px');
		// 	setTimeout(function(){
		// 		$('#one-page-shopping-checkout').css('max-height', '2000px');
		// 		$('html, body').animate({
		// 			scrollTop: $('#one-page-shopping-checkout').offset().top
		// 		}, 600);
		// 	}, 800);
		// });
		// $(document).on('click', '#openCart', function(e){
		// 	e.preventDefault();
		// 	$('#one-page-shopping-checkout').css('max-height', '0px');
		// 	setTimeout(function(){
		// 		$('#one-page-shopping-cart').css('max-height', '2000px');
		// 		$('html, body').animate({
		// 			scrollTop: $('#one-page-shopping-cart').offset().top
		// 		}, 600);
		// 	}, 800);
		// });

		// #one-page-shopping-cart
		// #one-page-shopping-checkout



	});
})( jQuery );