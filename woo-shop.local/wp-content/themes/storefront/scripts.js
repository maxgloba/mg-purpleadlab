(function( $ ) {
	'use strict';
	$(function() {

		// Beer slider
		$.fn.BeerSlider = function ( options ) {
			options = options || {};
			return this.each(function() {
				new BeerSlider(this, options);
			});
		};
		$('.beer-slider').BeerSlider({start: 50});

		// FAQ toggle
		$(document).on('click', '.faq-quest', function(){
			if ( $(this).parent().hasClass('open') ) {
				$('.faq-item').removeClass('open').find('.faq-answer').slideUp('fast');
			} else {
				$('.faq-item').removeClass('open').find('.faq-answer').slideUp('fast');
				$(this).parent().addClass('open').find('.faq-answer').slideDown('fast');
			}
		});

		// Scroll btn
		$(document).on('click', '.top-section .scroll-btn', function(e){
			e.preventDefault();
			$('html, body').animate({
				scrollTop: $('#product-section').offset().top
			}, 600);
			return false;
		});

		// Modal open
		$(document).on('click', '.modal-triger', function(e){
			e.preventDefault();
			var href = $(this).attr('href');
			var winWidth = $(window).width();
			if (winWidth > 1024){
				$('body, html').css('overflow', 'hidden');
				$('html').css('width', 'calc(100% - 17px)');
			}
			$('body').append('<section id="modal" class="modal"><span id="modal-close">×</span><div class="modal-container"></div></div>');
			setTimeout(function(){
				var template = $('template'+href).html();
				$('#modal').css({
					'visibility': 'visible',
					'opacity': '1',
				});
				$('#modal .modal-container').html(template).css('transform', 'scale(1)');
			}, 100);
		});

		// Modal Close
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
		});

		// Modal MORE
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
					}, 100);
				}
			});
		});

		// FAQ open
		$(document).on('click', '.faq-triger', function(e){
			e.preventDefault();
			$('.faq_full').toggleClass('opened');
			$('html, body').animate({
				scrollTop: $('.main-footer').offset().top
			}, 600);
		});

		// Tab click
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

		// Offer display
		$(document).on('click', '.customBoxDisplay', function(e){
			e.preventDefault();
			var templateId = $(this).data('template');
			var templateData = $('#'+templateId).html();

			$('#offer').html(templateData);
			$('#offer').slideDown();

			setTimeout(function(){
				$('html, body').animate({
					scrollTop: $('#offer').offset().top
				}, 800);
			}, 100);
		});

		$(document).on('click', '#offer_place_order', function(e){
			e.preventDefault();

			$('#uppSelloffer').css({
				'visibility': 'visible',
				'opacity': '1',
			});
			$('#uppSelloffer .modal-container').css('transform', 'scale(1)');

		});

		// Modal Close
		$(document).on('click', '.modal-close__uppSelloffer, #place_order', function(){
			$('body, html').css('overflow', 'visible');
			$('html').css('width', '100%');
			$('#uppSelloffer .modal-container').css('transform', 'scale(0)');
			$('#uppSelloffer').css({
				'visibility': 'hidden',
				'opacity': '0',
			});
		});

		$(document).on('click', '.addProduct', function(e){
			e.preventDefault();
			console.log('product added to cart');
			$("[name='update_cart']").trigger("click");
			// setTimeout(function(){
			// 	$('#place_order').click();
			// }, 1500);
		});


	});
})( jQuery );