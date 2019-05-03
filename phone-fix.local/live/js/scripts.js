$(function(){

	var phone_Model, phone_Problem, phone_Diagnosis;
	console.log(phone_Model);

	$(document).on('mouseover', '.phone-list .option li', function(e){
		e.preventDefault();
		$('.phone-list .option li').removeClass('active');
		$(this).addClass('active');
	});

	var phoneListHeight = $('#phone-list').height();
	$('.phone-list').on('scroll', function(e){
		var listPosition = $(this).offset().top;
		e.preventDefault();
		$('.phone-list ul.option').each(function(){
			var elemText = $(this).parent().find('.data-fix').html();
			var elemPosition = $(this).offset().top - 49 - listPosition;
			if (elemPosition <= 0) {
				$('.fix-title').html(elemText);
			}
		});
	});

	function closeModal(){
		$('.modal').removeClass('modal-active');
		setTimeout(function(){
			$('.modal').fadeOut('fast');
		}, 200);
	}
	function openModal(modalID){
		$('.modal-'+modalID).fadeIn('fast', function(){
			$(this).css('display', 'flex').addClass('modal-active');
		});
	}

	$(document).on('click', '#phone-list ul.option li', function(e){
		e.preventDefault();
		phone_Model = $(this).html();
		$('.select-phone').html(phone_Model);
		console.log(phone_Model);
		closeModal();
	});

	$(document).on('click', '#problem-list ul.option li', function(e){
		e.preventDefault();
		phone_Problem = $(this).html();
		$('.select-problem').html(phone_Problem);
		console.log(phone_Problem);
		closeModal();
	});

	$(document).on('click', '.modalOpen', function(e){
		e.preventDefault();
		var modal = $(this).data('modal');
		openModal(modal)
	});

	$(document).on('click', '.close-modal', function(e){
		e.preventDefault();
		closeModal();
	});

	$(document).on('click', '.goToStep2', function(e){
		e.preventDefault();

		if(phone_Model != undefined && phone_Problem != undefined){

			$('.progress').addClass('active');
			$('.progress .step1').addClass('active');
			$('#step1Box').animate({
				opacity: 0,
				top: 0,
				height: 0,
			}, 600);
			setTimeout(function(){
				$('#step2Box').addClass('active');
			}, 300);

		} else if(phone_Model != undefined && phone_Problem === undefined){
			$('.select-problem').addClass('not-valid');
			setTimeout(function(){
				$('.select-problem').removeClass('not-valid');
			}, 500);
		} else if(phone_Model === undefined){
			$('.select-phone').addClass('not-valid');
			setTimeout(function(){
				$('.select-phone').removeClass('not-valid');
			}, 500);
		}
	});

	$(document).on('click', '.backToStep1', function(e){
		e.preventDefault();
		$('.progress').removeClass('active');
		$('.progress .step1').removeClass('active');
		$('#step2Box').removeClass('active');
		setTimeout(function(){
			$('#step1Box').animate({
				opacity: 1,
				top: '50%',
				height: '125px',
			}, 300);
		}, 300);
	});

	$(document).on('click', '.diagnosis-options button', function(e){
		e.preventDefault();
		phone_Diagnosis = $(this).html();
		$('#step2Box').addClass('active-hide');
		$('.progress .step2').addClass('active');
		setTimeout(function(){
			$('#step3Box').addClass('active');
		}, 150);
		console.log(phone_Diagnosis);
	});

});