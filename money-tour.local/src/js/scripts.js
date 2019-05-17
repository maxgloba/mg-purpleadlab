//= modules/jquery.min.js

(function(){

	$(document).ready(function(){
		$('.animate').each(function(){
			var delay = $(this).data('animation-delay');
			$(this).css('transition-delay', delay+'s');
		});
		$('.earth').addClass('active');
	});

	$(document).on('click', '.gotToSlide', function(e){
		e.preventDefault();
		var slideName = $(this).data('slide');
		$(this).closest('section').fadeOut('fast', function(){
			$('.'+slideName).fadeIn('fast', function(){
				$(this).addClass('active');
			});
		});
	});

	$(document).on('click', '.checkbox li', function(e){
		e.preventDefault();
		$(this).toggleClass('active');
		if( $('.checkbox li.active').length > 0 ) {
			$(this).parent().parent().find('li.button').show();
		} else{
			$(this).parent().parent().find('li.button').hide();
		}
	});

})();