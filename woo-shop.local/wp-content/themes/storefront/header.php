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
									<?php $images = get_field('ts_gallery', 5); if( $images ): ?>
										<div class="gallery-col__wrap" id="gallery">
											<div class="gallery-col__media-container">
												<img class="gallery-col__main-img" src="<?php echo get_template_directory_uri(); ?>/img/gal/5.jpg" alt="" />
											</div>
											<ul class="gallery-col__prev-list">
												<?php foreach( $images as $image ): ?>
													<li class="gallery-col__prev-item">
														<img class="gallery-col__prev-img" src="<?php echo $image['sizes']['thumbnail']; ?>" data-src="<?php echo $image['sizes']['large']; ?>" alt="<?php echo $image['alt']; ?>" />
													</li>
												<?php endforeach; ?>
											</ul>
										</div>
									<?php else: ?>
									<img class="gallery-col__main-img" src="<?php echo get_template_directory_uri(); ?>/img/gal/5.jpg" alt="img">
									<?php endif; ?>
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
							<h2 class="title gray"><?php the_field('fbs_notes', 5); ?></h2>

							<?php if( have_rows('feedback', 5) ): ?>
								<ul class="feedback__list">

									<?php
										while ( have_rows('feedback', 5) ) : the_row();
											$stars = get_sub_field('stars', 5);
									?>
										<?php if( have_rows('beer_slider', 5) ): ?>
											<li class="feedback">
										<?php else: ?>
											<li class="feedback noslider">
										<?php endif; ?>

											<?php if( have_rows('beer_slider', 5) ): ?>
												<div class="feedback__sliders-col">
													<?php while ( have_rows('beer_slider', 5) ) : the_row(); ?>
														<div class="beer-slider">
															<img src="<?php the_sub_field('right_image', 5); ?>" />
															<div class="beer-reveal"><img src="<?php the_sub_field('left_image', 5); ?>" /></div>
														</div>
													<?php endwhile; ?>
												</div>
											<?php endif; ?>

											<div class="feedback__main-col">
												<div class="feedback__stars">
													<?php
														for( $i=1; $i <= $stars; $i++){
															echo '<svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 53.867 53.867" style="enable-background:new 0 0 53.867 53.867;" xml:space="preserve"> <polygon style="fill:#EFCE4A;" points="26.934,1.318 35.256,18.182 53.867,20.887 40.4,34.013 43.579,52.549 26.934,43.798 10.288,52.549 13.467,34.013 0,20.887 18.611,18.182 "/> </svg>';
														}
													?>
												</div>
												<h6 class="feedback__title"><?php the_sub_field('title', 5); ?></h6>
												<p class="feedback__text"><?php the_sub_field('text', 5); ?></p>
												<div class="feedback__name"><?php the_sub_field('name', 5); ?></div>
											</div>
										</li>
									<?php endwhile; ?>

								</ul>
							<?php endif; ?>

						</div>
					</section>
				<?php endif; ?>

				<?php do_action( 'storefront_content_top' );