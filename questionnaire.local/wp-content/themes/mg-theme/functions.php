<?php

function admin_style() {
	wp_enqueue_style('admin-styles', get_template_directory_uri().'/admin.css');
}
add_action('admin_enqueue_scripts', 'admin_style');

function onyx_scripts() {
	wp_enqueue_script( 'circul', get_template_directory_uri() . '/js/circle-progress.min.js', array( 'jquery' ));
	wp_enqueue_script( 'scripts', get_template_directory_uri() . '/js/scripts.js', array( 'jquery', 'circul' ));
}
add_action( 'wp_enqueue_scripts', 'onyx_scripts' );

function admin_scripts() {
	wp_enqueue_script('admin_scripts', get_template_directory_uri() . '/admin.js', array( 'jquery' ));
}
add_action('admin_enqueue_scripts', 'admin_scripts');


if(!is_admin()){

	remove_action('wp_head', 'wp_print_scripts');
	remove_action('wp_head', 'wp_print_head_scripts', 9);
	remove_action('wp_head', 'wp_enqueue_scripts', 1);

	add_action('wp_footer', 'wp_print_scripts', 5);
	add_action('wp_footer', 'wp_print_head_scripts', 5);
	add_action('wp_footer', 'wp_enqueue_scripts', 5);

	wp_deregister_script('jquery');
	wp_register_script('jquery', get_template_directory_uri() . '/js/jquery-2.2.4.min.js', false, 'all', true);
	wp_enqueue_script('jquery');

}


// //Create DB
// global $wpdb;
// require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
// $table_name = $wpdb->prefix . "quiz_answers";
// $sql = "CREATE TABLE {$table_name} (
// 	id mediumint(9) NOT NULL AUTO_INCREMENT,
// 	date DATETIME NOT NULL,
// 	last_name text NOT NULL,
// 	first_name text NOT NULL,
// 	email text NOT NULL,
// 	phone text NOT NULL,
// 	answers text NOT NULL,
// 	UNIQUE KEY id (id)
// ) {$charset_collate};";
// // Создать таблицу.
// dbDelta( $sql );


function addPost(){

	parse_str($_POST['form_data'], $formdata);
	$c1_list_array = $formdata['q1_list'];
	$c2_list_array = $formdata['q2_list'];
	$c3_list_array = $formdata['q3_list'];
	$c4_list_array = $formdata['q4_list'];

	// c1_list
	$c1_list = [];
	foreach ( $c1_list_array as $check ) {
		$c1_list[] = '<li>'.$check.'</li>';
	}
	$c1_list = '<div class="answers-list"><h2>Have You Advertised online before?</h2><ul>'. implode( '', $c1_list ) .'</ul></div>';

	// c2_list
	$c2_list = [];
	foreach ( $c2_list_array as $check ) {
		$c2_list[] = '<li>'.$check.'</li>';
	}
	$c2_list = '<div class="answers-list"><h2>Where have You advertised?</h2><ul>'. implode( '', $c2_list ) .'</ul></div>';

	// c3_list
	$c3_list = [];
	foreach ( $c3_list_array as $check ) {
		$c3_list[] = '<li>'.$check.'</li>';
	}
	$c3_list = '<div class="answers-list"><h2>What is the most you spent in one month?</h2><ul>'. implode( '', $c3_list ) .'</ul></div>';

	// c4_list
	$c4_list = [];
	foreach ( $c4_list_array as $check ) {
		$c4_list[] = '<li>'.$check.'</li>';
	}
	$c4_list = '<div class="answers-list"><h2>What do You Advertise?</h2><ul>'. implode( '', $c4_list ) .'</ul></div>';

	$answers = $c1_list.$c2_list.$c3_list.$c4_list;

	global $wpdb;
	$date = date('Y-m-d H:i:s');

	if( $wpdb->insert(
		$wpdb->prefix . "quiz_answers",
		array(
			'date'       => $date,
			'answers'    => $answers,
			'first_name' => $formdata['first_name'],
			'email'      => $formdata['email'],
		)
	) === false){
		echo "Error";
	} else{
		echo 'Post added';
	}

	die();
}
add_action('wp_ajax_addPost', 'addPost');
add_action('wp_ajax_nopriv_addPost', 'addPost');

// Add custom MG Shop page in Admin
function add_quiz() {
	add_menu_page('Quiz page', 'Quiz', 0, 'mg_quiz', 'render_quiz_page', 'dashicons-list-view', 5);
}
add_action('admin_menu', 'add_quiz');

function render_quiz_page(){

	global $wpdb;

	$table_name = $wpdb->prefix . "quiz_answers";
	// $i = 0;
	// $a = 0;
	$quiz_datas = $wpdb->get_results("SELECT * FROM $table_name ORDER BY date DESC");

	if($quiz_datas){
		echo '<div id="quiz_info">';
		foreach( $quiz_datas as $data ){
			// $i++;
			// $a++;
			// if( ($i % 2) == 1 ){
			// 	echo '<div class="tab">';
			// }

			echo '
			<div id="quiz-'.$data->id.'" class="quiz-box">
				<div class="quiz-title">
					Quiz #'.$data->id.'
					<em>('.$data->date.')</em>
				</div>
				<div class="quiz-content">
					<div class="mg_shop_customer"><span class="label">Name:</span> '.$data->first_name.' '.$data->last_name.'</div>
					<div class="mg_shop_email"><span class="label">Email:</span> '.$data->email.'</div>
					<div class="mg_shop_info"><span class="label">Answers:</span> '.$data->answers.'</div>
				</div>
			</div>';

			// if( ($a % 2) != 1 ){
			// 	echo '</div>';
			// }
		}
		echo '</div>';
	}

}