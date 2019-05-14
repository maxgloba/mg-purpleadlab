(function(){

	$("#main-header").addClass("loaded");

	$(window).on("load", function(){
		$("#main").css('display', 'block');
	});

	$('#openOffer').on("click", function(){
		$('#offer').addClass('active');
		$("html, body").animate({ scrollTop: $('#offer').offset().top }, 800);
	});

	$('#closeOffer').on("click", function(e){
		e.preventDefault();
		$('#offer').removeClass('active');
		$("html, body").animate({ scrollTop: 0 }, 800);
	});

	$(window).scroll(function(){
		var winHeight = $(this).height();
		var winTop = $(window).scrollTop();
		$('.anim_box').each(function(){
			var elemDataAnim = $(this).data('animate');
			var elemDataDelay = $(this).data('delay');
			var elemHeight = $(this).height() * 0.35;
			var elemPosition = $(this).offset().top - winTop - winHeight + elemHeight;

			if (elemPosition <= 0) {
				$(this).addClass('animated '+elemDataAnim).css('animation-delay', elemDataDelay);
			}
		});
	});

	$(document).on('click', '.openModal', function(e){
		e.preventDefault();

		var modalName = $(this).data('modal');
		var modalContent = $('#'+modalName).html();
		var winWidth = $(window).width();

		if (winWidth>1200) {
			$('html').css({
				'overflow-y': 'hidden',
				'margin-right': '17px',
			});
		} else {
			$('html').css('overflow-y', 'hidden');
		}

		$('#modal').remove();
		$('body').append('<section class="modal" id="modal"><div class="modal-inner"><button id="closeModal">+</button><div class="container">'+modalContent+'</div></div></section>');

		setTimeout(function(){

			$('#modal').fadeIn('fast').addClass('modal-active');
			$('#modal .modal-inner').css({
				'transform': 'translate(0, 0)',
				'opacity': 1,
			});
		}, 100);
	});
	$(document).on('click', '#closeModal', function(e){
		e.preventDefault();

		var winWidth = $(window).width();

		$('#modal .modal-inner').css({
			'transform': 'translate(0, 1000px)',
			'opacity': 0,
		});
		$('#modal').fadeOut('slow', function(){
			$(this).remove();
			if (winWidth>1200) {
				$('html').css({
					'overflow-y': 'auto',
					'margin-right': '0px',
				});
			} else {
				$('html').css('overflow-y', 'auto');
			}
		});
	});

})();