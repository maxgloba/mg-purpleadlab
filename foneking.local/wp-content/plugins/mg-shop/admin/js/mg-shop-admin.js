(function( $ ) {
	'use strict';

	/**
	 * All of the code for your admin-facing JavaScript source
	 * should reside in this file.
	 *
	 * Note: It has been assumed you will write jQuery code here, so the
	 * $ function reference has been prepared for usage within the scope
	 * of this function.
	 *
	 * This enables you to define handlers, for when the DOM is ready:
	 *
	 * $(function() {
	 *
	 * });
	 *
	 * When the window is loaded:
	 *
	 * $( window ).load(function() {
	 *
	 * });
	 *
	 * ...and/or other possibilities.
	 *
	 * Ideally, it is not considered best practise to attach more than a
	 * single DOM-ready or window-load handler for a particular page.
	 * Although scripts in the WordPress core, Plugins and Themes may be
	 * practising this, we should strive to set a better example in our own work.
	 */
	$(function() {

		var getUrl = window.location;
		var baseUrl = getUrl.protocol + "//" + getUrl.host + "/" + getUrl.pathname.split('/')[1];
		var ajaxUrl = baseUrl+"/wp-admin/admin-ajax.php";

		var href = myScript.pluginsUrl + '/';

		// Reports tabs
		$('body').on('click', '.report-nav li', function(e){
			e.preventDefault();
			var tab = $(this).data('tab');
			$('.report-nav li').removeClass('active');
			$(this).addClass('active');
			$('.report-tab').hide().removeClass('active');
			$('.report-'+tab).show();
		});

		// Remove Order from admin
		$('body').on('click', '.mg_order_remove', function(e) {
			e.preventDefault();

			var id = $(this).data('remove');
			console.log(id);

			$(this).parent().parent().find('.order-content').css('display', 'none !important');

			$.ajax({
				type:"POST",
				url: ajaxUrl,
				data: {
					action: 'removeOrder',
					id: id,
				},
				beforeSend: function(xhr, textStatus){
					console.log(id);
				},
				success:function(response){
					console.log(response);
					$('#order-'+id).slideUp('500', function(){
						$(this).remove();
					});
				}
			});
		});

		// Order box toggle
		$('body').on('click', '#mg_shop_order_info .order-title', function(e){
			e.preventDefault();
			$(this).parent().toggleClass('active');
			$(this).parent().find('.order-content').slideToggle();
		});

		// Order status updating
		$('body').on('submit', '.mg_order_status_update', function(e) {
			e.preventDefault();

			var color;
			var form = $(this);
			var id = form.find('input[name="id"]').val();
			var status = form.find('select[name="status"]').val();
			var email = $('#order-'+id+' .mg_shop_email span').html();
			var name = $('#order-'+id+' .mg_shop_customer span').html();
			console.log(id);
			console.log(status);

			$.ajax({
				type:"POST",
				url: ajaxUrl,
				data: {
					action: 'updateOrderStatus',
					status: status,
					id: id,
				},
				beforeSend: function(xhr, textStatus){
					form.addClass('loading');
				},
				success:function(response){
					form.removeClass('loading');
					$('span[data-id="mg_order_status_'+id+'"').html(status);
					if (status === 'Completed') {
						$('.feedback').fadeIn();
						$('#feedback_name').val(name);
						$('#feedback_email').val(email);
						$('#feedback_message').val('Hello '+name+', \n \n Your order has been sent to the specified address. \n Thanks for subscribing!');
					}
				}
			});
		});



		// Sent after confirm
		$('body').on('submit', '#feedback-form', function(e){
			e.preventDefault();

			$.ajax({
				url: href+'mg-shop/admin/send.php',
				type: 'post',
				data: $(this).serialize(),
				success: function(response){
					$('.confirmation-message').slideDown();
					console.log(response);
					setTimeout(function(){
						$('.feedback').fadeOut(500, function(){
							$(this).hide();
							$('#feedback-form').get(0).reset();
							$('.confirmation-message').hide();
						});
					}, 2000);
				}
			});
		});

		// Datepicker
		$('#sort_from, #report_from').datepicker({
			dateFormat: 'yy-mm-dd',
			defaultDate: "+1w",
			changeMonth: true,
			numberOfMonths: 1,
			onClose: function( selectedDate ) {
				$( "#sort_to" ).datepicker( "option", "minDate", selectedDate );
			}
		});
		$('#sort_to, #report_to').datepicker({
			dateFormat: 'yy-mm-dd',
			defaultDate: "+1w",
			changeMonth: true,
			numberOfMonths: 1,
			onClose: function( selectedDate ) {
				$( "#mg_order_sort" ).datepicker( "option", "maxDate", selectedDate );
			}
		});

		// Orders sorting
		$('body').on('submit', '#mg_order_sort', function(e) {
			e.preventDefault();

			var form = $(this);
			var status = form.find('#sort_status').val();
			var dateFrom = form.find('#sort_from').val();
			var dateTo = form.find('#sort_to').val();

			$.ajax({
				type:"POST",
				url: ajaxUrl,
				data: {
					action: 'updateOrderSort',
					status: status,
					dateFrom: dateFrom,
					dateTo: dateTo,
				},
				beforeSend: function(xhr, textStatus){
					$('#mg_shop_order_info').slideUp('fast');

					form.addClass('loading');
				},
				success:function(response){
					$('#mg_shop_order_info').html(response).slideDown('fast');
					form.removeClass('loading');
				}
			});
		});

		// Report custom date
		$('body').on('submit', '#mg_order_report', function(e) {
			e.preventDefault();

			var form = $(this);
			var dateFrom = form.find('#report_from').val();
			var dateTo = form.find('#report_to').val();

			$.ajax({
				type:"POST",
				url: ajaxUrl,
				data: {
					action: 'updateReportDate',
					dateFrom: dateFrom,
					dateTo: dateTo,
				},
				beforeSend: function(xhr, textStatus){
					form.addClass('loading');
				},
				success:function(response){
					$('#report_custom_date').html(response);
					form.removeClass('loading');
				}
			});
		});

	});

})( jQuery );