(function(){

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
                mySwiper.slideNext();
            }
        });

    });

}());