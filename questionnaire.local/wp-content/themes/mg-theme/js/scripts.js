$(function(){

	$('#q1_1').on('click', function() {
		if( $(this).is(':checked') ){
			$('.question_1').removeClass('active').addClass('prev');
			$('.question_2').addClass('active');
			$("html, body").animate({ scrollTop: $('#quiz-block').offset().top }, 800);
			setTimeout(function(){
				$('.quiz-num').html('2');
				$('.quiz-progress span').css('width', '25%');
			}, 250);
		}
	});

	$('.question_2 input').on('click', function(){
		if( $('input[name="q2_list[]"]:checked').length > 0 ) {
			$('#goTo_question_3').fadeIn();
		} else {
			$('#goTo_question_3').hide();
		}
	});

	$('#goTo_question_3').on('click', function() {
		$('.question_2').removeClass('active').addClass('prev');
		$('.question_3').addClass('active');
		setTimeout(function(){
			$('.quiz-num').html('3');
			$('.quiz-progress span').css('width', '50%');
		}, 250);
	});

	$('.question_3 input').on('click', function(){
		if ( $('input[name="q3_list[]"]:checked') ) {
			$('.question_3').removeClass('active').addClass('prev');
			$('.question_4').addClass('active');
			setTimeout(function(){
				$('.quiz-num').html('4');
				$('.quiz-progress span').css('width', '75%');
			}, 250);
		}
	});

	$('.question_4 input').on('click', function(){
		if( $('input[name="q4_list[]"]:checked').length > 0 ) {
			$('#goTo_question_5').fadeIn();
		} else{
			$('#goTo_question_5').hide();
		}
	});

	$('#goTo_question_5').on('click', function() {
		$('.question_4').removeClass('active').addClass('prev');
		setTimeout(function(){
			$('.quiz-progress span').css('width', '100%');
			setTimeout(function(){
				$('.quiz-title').slideUp('fast', function(){
					$('.question_5').addClass('active');
				});
				setTimeout(function(){
					$('#q5_num').fadeIn('fast', function(){
						$(this).circleProgress({
							value: 1,
							size: 115,
							startAngle: -Math.PI / 4 * 2,
							lineCap: 'round',
							fill: {color: '#00FF85'}
						}).on('circle-animation-progress', function(event, progress) {
							$(this).find('strong').html(Math.round(100 * progress) + '<i>%</i>');
						});
						setTimeout(function(){
							$('.question_5').removeClass('active').addClass('prev');
							$('.question_6').addClass('active');
						}, 2500);
					});
				}, 800);
			}, 150);
		}, 250);
	});

	// $('#quiz_form').on('submit', function(e){
	// 	e.preventDefault();
	// 	$('.question_6').removeClass('active').addClass('prev');
	// 	$('.question_7').addClass('active');
	// 	setTimeout(function(){
	// 		$('.q7_check').addClass('active');
	// 		setTimeout(function(){
	// 			$("html, body").animate({ scrollTop: $('#header').offset().top }, 800);
	// 			$('.landing').addClass('active');
	// 		}, 2500);
	// 	}, 500);
	// });

	var ajaxUrl = "/wp-admin/admin-ajax.php";

    $('body').on('submit', '#quiz_form', function(e){
        e.preventDefault();

        var form_data = $(this).serialize();

        $.ajax({
            url: ajaxUrl,
            type: 'POST',
            data: {
                form_data: form_data,
                action: 'addPost',
            },
            beforeSend: function(xhr, textStatus){
                console.log('Ajax go');
            },
            success: function(response){
                console.log(response);
                console.log('Ajax done');
                $('.question_6').removeClass('active').addClass('prev');
				$('.question_7').addClass('active');
				setTimeout(function(){
					$('.q7_check').addClass('active');
					setTimeout(function(){
						$("html, body").animate({ scrollTop: $('#header').offset().top }, 800);
						$('.landing').addClass('active');
					}, 2500);
				}, 500);
            }
        });

    });

});