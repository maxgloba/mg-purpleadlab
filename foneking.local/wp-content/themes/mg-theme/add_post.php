<?php
	global $wpdb;

	$title = strip_tags($_POST['post_title']);
	$content = wp_kses_post($_POST['post_content']);
	echo $title .'Lorem ipsum dolor sit amet.';

	// if( $wpdb->insert(
	// 		$wpdb->prefix . 'posts',
	// 		array(
	// 			'post_title' => $post_title,
	// 			'post_content' => $post_content,
	// 			'post_type' => 'orders'
	// 		),
	// 		array( '%s', '%s', '%s' )
	// ) === false){
	// 	echo "Ошибка!";
	// } else{
	// 	echo "Пост добавлен!";
	// }

	// die();
//$posts = $wpdb->get_results("SELECT ID, post_title, post_content FROM $wpdb->posts WHERE post_status = 'publish' AND post_type='orders'");
//echo '<pre>'; var_dump($posts); echo '</pre>';




    // $to = "onyx18121990@gmail.com";
    // $subject = "Check form";
    // $text =  "\nMessage: $post_title\n--\n$post_content";

    // $headers = 'From: Max<onyx18121990@mail.ru>' . "\r\n" .
    // 'Reply-To: onyx18121990@mail.ru'"\r\n" .
    // 'X-Mailer: PHP/' . phpversion();

    // $sending = mail($to, $subject, $text, $headers);

    // if($sending) echo "Email sent!";

?>