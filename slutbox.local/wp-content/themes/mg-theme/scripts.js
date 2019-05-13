(function () {
	$('.faq-quest').on('click', function(){
		if ( $(this).parent().hasClass('open') ) {
			$('.faq-item').removeClass('open').find('.faq-answer').slideUp('fast');
		} else {
			$('.faq-item').removeClass('open').find('.faq-answer').slideUp('fast');
			$(this).parent().addClass('open').find('.faq-answer').slideDown('fast');
		}
	});
}());