<!DOCTYPE html>
<html <?php language_attributes(); ?> xmlns:og="http://ogp.me/ns#">
	<head>
		<meta charset="<?php bloginfo( 'charset' ); ?>">
		<meta name="keywords" content="<?php bloginfo('keywords'); ?>"/>
		<meta name="description" content="<?php bloginfo('description'); ?>"/>
		<meta name="copyright" content="<?php bloginfo('copyright'); ?>">

		<meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
		<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0"><link href="https://fonts.googleapis.com/css?family=Open+Sans:400,700" rel="stylesheet">

		<link rel="icon" type="image/png" href="<?php echo get_template_directory_uri(); ?>/favicon.png" />

		<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/dist/main.min.css">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Swiper/4.5.0/css/swiper.min.css">

		<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/style.css">

		<meta name="format-detection" content="telephone=no">
		<meta name="robots" content="nofollow" />

		<?php wp_head(); ?>
	</head>
		<body <?php body_class(); ?>>

			<canvas id="canvas"></canvas>

			<header class="header wrapper">
			    <div class="content__wrapper">
			        <div class="content__logo-wrapper">
			            <h3 class="content__logo">
			                Mega logo
			            </h3>
			        </div>
			    </div>
			</header>