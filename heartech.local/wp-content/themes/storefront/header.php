<?php

/**
 * The header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @package storefront
 */

?><!doctype html>
<html <?php language_attributes(); ?>>
	<head>
		<meta charset="<?php bloginfo( 'charset' ); ?>">

		<!-- Custom head settings -->
		<meta name="theme-color" content="#5f378f">
		<meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
		<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">

		<link href="https://fonts.googleapis.com/css?family=Roboto:400,700" rel="stylesheet">
		<link rel="shortcut icon" href="<?php echo get_template_directory_uri(); ?>/favicon.png" type="image/png">
		<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/styles/main.css">
		<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/styles/custom-styles.css">

		<?php wp_head(); ?>

		<?php if ( is_front_page() ) : ?>
			<script>
				var ajaxUrl = '<?php echo home_url(); ?>/wp-admin/admin-ajax.php';
				var cartUrl = '<?php echo get_permalink(6); ?>';
				var checkoutUrl = '<?php echo get_permalink(7); ?>';
			</script>
		<?php endif; ?>

	</head>

	<body <?php body_class(); ?>>

		<!-- #START wrapper -->
		<div class="wrapper">

			<header class="main-header">
				<div class="container">
					<a class="main-header__logo" href="<?php echo home_url(); ?>">
						<img src="<?php echo get_template_directory_uri(); ?>/img/logo.png" alt="">
					</a>
				</div>
			</header>

			<main class="main">
				<?php if ( is_front_page() ) : ?>
					<section class="top-section">
						<div class="container">
							<h1 class="title"><?php the_field('ts_title', 5); ?></h1>
							<div class="sub-title"><?php the_field('ts_subtitle', 5); ?></div>
							<div class="top-section__dscr-wrap">
								<div class="top-section__gallery-col">
									<img class="gallery-col__main-img" src="<?php the_field('ts_image', 5); ?>" alt="img">
								</div>
								<div class="top-section__dscr-col">
									<?php the_field('ts_description', 5); ?>
								</div>
							</div>
						</div>
					</section>

					<section class="howtouse-section">
						<div class="container">
							<h2 class="title accented"><?php the_field('hts_title', 5); ?></h2>
							<div class="sub-title"><?php the_field('hts_subtitle', 5); ?></div>
							<?php if( have_rows('hts_steps', 5) ): ?>
								<ul class="howtouse-section__steps-list">
									<?php while ( have_rows('hts_steps', 5) ) : the_row(); ?>
										<li class="howtouse-section__steps-item">
											<?php the_sub_field('text', 5); ?>
										</li>
									<?php endwhile; ?>
								</ul>
							<?php endif; ?>
							<?php the_field('hts_notes', 5); ?>
						</div>
					</section>

					<section class="feedback-section">
						<div class="container">
							<h2 class="title">Don't Take Our Word For it! <br> Here's What Our Customers Think:</h2>
							<?php if( have_rows('feedback', 5) ): ?>
								<div class="row">
									<?php while ( have_rows('feedback', 5) ) : the_row(); ?>
										<div class="col-sm-6 col-md-4">
											<article>
												<header>
													<img src="<?php the_sub_field('icon', 5); ?>" alt="">
													<h3><?php the_sub_field('name', 5); ?></h3>
												</header>
												<p><?php the_sub_field('text', 5); ?></p>
											</article>
										</div>
									<?php endwhile; ?>
								</div>
							<?php endif; ?>
						</div>
					</section>

				<?php endif; ?>

				<?php do_action( 'storefront_content_top' );