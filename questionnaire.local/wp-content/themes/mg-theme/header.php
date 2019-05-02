<!DOCTYPE html>
<html <?php language_attributes(); ?> xmlns:og="http://ogp.me/ns#">
	<head>
		<meta charset="<?php bloginfo( 'charset' ); ?>">
		<meta name="keywords" content="<?php bloginfo('keywords'); ?>"/>
		<meta name="description" content="<?php bloginfo('description'); ?>"/>
		<meta name="copyright" content="<?php bloginfo('copyright'); ?>">

		<meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
		<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0"><link href="https://fonts.googleapis.com/css?family=Open+Sans:400,700" rel="stylesheet">

		<?php if( get_field('favicon') ):?>
			<link rel="icon" type="image/png" href="<?php the_field('favicon'); ?>" />
		<?php else:?>
			<link rel="icon" type="image/png" href="<?php echo get_template_directory_uri(); ?>/favicon.png" />
		<?php endif; ?>

		<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/style.css">

		<meta name="format-detection" content="telephone=no">
		<meta name="robots" content="nofollow" />

		<?php wp_head(); ?>
	</head>
		<body <?php body_class(); ?>>

			<header id="header">
				<div class="container clearfix">
					<a href="<?php home_url(); ?>" class="logo">
						<img src="<?php the_field('logo'); ?>" alt="">
					</a>
					<button class="nav-btn">
						<span></span>
						<span></span>
						<span></span>
					</button>
				</div>
			</header>