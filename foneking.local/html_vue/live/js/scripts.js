var phone_list = new Vue({
	el: '#phone-list',
	data: {
		lists: [
			{
				list_id: 'iphone_list',
				list_name: 'IPHONE REPAIRS',
				list_items: [
					{ phone_name: 'iPhone X',		hover: false },
					{ phone_name: 'iPhone 8 Plus',	hover: false },
					{ phone_name: 'iPhone 8',		hover: false },
					{ phone_name: 'iPhone 7 Plus',	hover: false },
					{ phone_name: 'iPhone 7',		hover: false },
					{ phone_name: 'iPhone 6S Plus',	hover: false },
					{ phone_name: 'iPhone 6S',		hover: false },
					{ phone_name: 'iPhone 6 Plus',	hover: false },
					{ phone_name: 'iPhone 6',		hover: false },
					{ phone_name: 'iPhone 5S',		hover: false },
					{ phone_name: 'iPhone 5C',		hover: false },
					{ phone_name: 'iPhone 5',		hover: false },
					{ phone_name: 'iPhone SE',		hover: false },
					{ phone_name: 'iPhone 4S',		hover: false },
					{ phone_name: 'iPhone 4',		hover: false },
					{ phone_name: 'iPhone 3GS',		hover: false }
				]
			},
			{
				list_id: 'ipad_list',
				list_name: 'IPAD REPAIRS',
				list_items: [
					{ phone_name: 'iPad Pro 12.9',	hover: false },
					{ phone_name: 'iPad Pro 9.7',	hover: false },
					{ phone_name: 'iPad Mini 4',	hover: false },
					{ phone_name: 'iPad Mini 3',	hover: false },
					{ phone_name: 'iPad Mini 2',	hover: false },
					{ phone_name: 'iPad Mini',		hover: false },
					{ phone_name: 'iPad Air 2',		hover: false },
					{ phone_name: 'iPad Air',		hover: false },
					{ phone_name: 'iPad 5th Gen',	hover: false },
					{ phone_name: 'iPad 4',			hover: false },
					{ phone_name: 'iPad 3',			hover: false },
					{ phone_name: 'iPad 2',			hover: false },
					{ phone_name: 'iPad 1 Wi-Fi',	hover: false },
					{ phone_name: 'iPad 1 3G',		hover: false }
				]
			},
			{
				list_id: 'samsung_list',
				list_name: 'SAMSUNG REPAIRS',
				list_items: [
					{ phone_name: 'Galaxy S9 Plus',			hover: false },
					{ phone_name: 'Galaxy S9',				hover: false },
					{ phone_name: 'Galaxy S8 Plus',			hover: false },
					{ phone_name: 'Galaxy S8',				hover: false },
					{ phone_name: 'Galaxy S7 Edge Duos',	hover: false },
					{ phone_name: 'Galaxy S7 Edge',			hover: false },
					{ phone_name: 'Galaxy S7',				hover: false },
					{ phone_name: 'Galaxy S6 Edge Plus',	hover: false },
					{ phone_name: 'Galaxy S6 Edge',			hover: false },
					{ phone_name: 'Galaxy S6',				hover: false },
					{ phone_name: 'Galaxy S5 Series',		hover: false },
					{ phone_name: 'Galaxy S4 Series',		hover: false },
					{ phone_name: 'Galaxy S3 Series',		hover: false },
					{ phone_name: 'Galaxy S2 Series',		hover: false },
					{ phone_name: 'Galaxy S1',				hover: false },
					{ phone_name: 'Galaxy S Duos',			hover: false }
				]
			},
			{
				list_id: 'other_list',
				list_name: 'OTHER MODELS WE REPAIR',
				list_items: [
					{ phone_name: 'iPhone X', 				hover: false },
					{ phone_name: 'ASUS Phones', 			hover: false },
					{ phone_name: 'BlackBerry Bold', 		hover: false },
					{ phone_name: 'BlackBerry Classic', 	hover: false },
					{ phone_name: 'BlackBerry Keyone', 		hover: false },
					{ phone_name: 'BlackBerry Passport', 	hover: false },
					{ phone_name: 'BlackBerry Priv', 		hover: false },
					{ phone_name: 'BlackBerry Q Series', 	hover: false },
					{ phone_name: 'BlackBerry Torch', 		hover: false },
					{ phone_name: 'BlackBerry Z Series', 	hover: false },
					{ phone_name: 'Google Pixel', 			hover: false },
					{ phone_name: 'Google Pixel XL', 		hover: false },
					{ phone_name: 'HTC Desire Series', 		hover: false },
					{ phone_name: 'HTC M10', 				hover: false },
					{ phone_name: 'HTC One Series', 		hover: false },
					{ phone_name: 'HTC Sensation Series', 	hover: false },
					{ phone_name: 'HTC Wildfire Series', 	hover: false },
					{ phone_name: 'Huawei G/GR Series', 	hover: false },
					{ phone_name: 'Huawei Mate', 			hover: false },
					{ phone_name: 'Huawei Nexus 6P', 		hover: false },
					{ phone_name: 'Huawei P Series', 		hover: false },
					{ phone_name: 'LG G5', 					hover: false },
					{ phone_name: 'LG K/L Series', 			hover: false },
					{ phone_name: 'LG Nexus Series', 		hover: false },
					{ phone_name: 'LG Optimus Series', 		hover: false },
					{ phone_name: 'LG Prada 3.0', 			hover: false },
					{ phone_name: 'Motorola Moto Series',	hover: false },
					{ phone_name: 'Motorola Nexus 6', 		hover: false },
					{ phone_name: 'Motorola Razr Series', 	hover: false },
					{ phone_name: 'Nokia Lumia Series', 	hover: false },
					{ phone_name: 'OnePlus One', 			hover: false },
					{ phone_name: 'Oppo F/R Series', 		hover: false },
					{ phone_name: 'Sony Xperia Series', 	hover: false },
					{ phone_name: 'Sony Z2/Z4 Tablet', 		hover: false }
				]
			}
		],
	},
	methods: {
		selectedPhone: function(event){
			alert( this.phone_name );
		}
	}
})


$(function(){

	var phone_Model, phone_Problem, phone_Diagnosis;

	$(window).on('load resize', function(){
		var winWidth = $(window).width();
		console.log(winWidth);
	});

	// $(document).on('mouseover', '.phone-list .option li', function(e){
	// 	e.preventDefault();
	// 	$('.phone-list .option li').removeClass('active');
	// 	$(this).addClass('active');
	// });


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
		$('[name="phone_Model"]').val(phone_Model);
		closeModal();
	});

	$(document).on('click', '#problem-list ul.option li', function(e){
		e.preventDefault();
		phone_Problem = $(this).html();
		$('.select-problem').html(phone_Problem);
		$('[name="phone_Problem"]').val(phone_Problem);
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
			$('.progress .step2').addClass('active');
			$('#step1Box').animate({
				opacity: 0,
				top: 0,
			}, 400);
			setTimeout(function(){
				$('#step2Box').addClass('active');
			}, 300);

		} else if(phone_Model != undefined && phone_Problem === undefined){
			$('.select-problem').addClass('not-valid');
			setTimeout(function(){
				$('.select-problem').removeClass('not-valid');
			}, 1000);
		} else if(phone_Model === undefined){
			$('.select-phone').addClass('not-valid');
			setTimeout(function(){
				$('.select-phone').removeClass('not-valid');
			}, 1000);
		}
	});

	$(document).on('click', '.backToStep1', function(e){
		e.preventDefault();
		$('.progress').removeClass('active');
		$('.progress .step2').removeClass('active');
		$('#step2Box').removeClass('active');
		setTimeout(function(){

			$('#step1Box').animate({
				opacity: 1,
				top: '50%',
			}, 300);

		}, 300);
	});


	$(document).on('click', '.diagnosis-options button', function(e){
		e.preventDefault();
		phone_Diagnosis = $(this).html();
		$('#step2Box').addClass('active-hide');
		$('.progress .step3').addClass('active');
		setTimeout(function(){
			$('#step3Box').addClass('active');
		}, 150);
		$('[name="phone_Diagnosis"]').val(phone_Diagnosis);
	});

	$(document).on('click', '.backToStep2', function(e){
		e.preventDefault();
		$('#step3Box').removeClass('active');
		$('.progress .step3').removeClass('active');
		setTimeout(function(){
			$('#step2Box').removeClass('active-hide');
		}, 150);
	});

	$(document).on('click', '.goToStep4', function(e){
		e.preventDefault();
		$('.summary-wrapper').addClass('active-hide');
		setTimeout(function(){
			$('.info-wrapper').addClass('active');
		}, 150);
	});

	$(document).on('click', '.goToStep5', function(e){
		e.preventDefault();
		$('.summary-wrapper').addClass('active-hide');
		setTimeout(function(){
			$('.contact-wrapper').addClass('active');
		}, 150);
	});

	$(document).on('click', '.backToStep3', function(e){
		e.preventDefault();
		$('#step4Box, #step5Box').removeClass('active');
		setTimeout(function(){
			$('#step3Box').removeClass('active-hide');
		}, 150);
	});

	$(document).on('submit', '#contactForm', function(e){
		e.preventDefault();
		var captchaLabel = $(this).find('[for="captcha"]').html();
		var captchaInput = $(this).find('[name="captcha"]').val();
		if (captchaLabel == captchaInput) {
			$.ajax({
				url: './send.php',
				type: 'post',
				data: $(this).serialize()
			}).done(function(data){
				alert(data); location.reload();
			});
		} else {
			alert('Try againe and check captcha!');
		}
	});

	$(document).on('click', '.box .button-link_modal', function(e){
		e.preventDefault();
		var link = $(this).attr('href');
		$('.modal-map iframe').prop('src', link+'&zoom=9');
		openModal('map');
	});

});