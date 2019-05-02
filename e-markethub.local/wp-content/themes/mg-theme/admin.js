(function( $ ) {
	'use strict';

	$(function() {

		$('body').on('click', '#quiz_info .quiz-title', function(e){
			e.preventDefault();
			$(this).parent().toggleClass('active');
			$(this).parent().find('.quiz-content').slideToggle('fast');
		});

	});

})( jQuery );