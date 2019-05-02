<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package storefront
 */

?>

				<section class="guarantee-section">
					<div class="container">
						<?php $payment_method = get_field('payment_method', 5); if( $payment_method ): ?>
							<ul class="guarantee-section__company-list">
								<?php foreach( $payment_method as $payment ): ?>
									<li class="guarantee-section__company-item <?php echo $payment; ?>"></li>
								<?php endforeach; ?>
							</ul>
						<?php endif; ?>
						<div class="text bold"><?php the_field('gs_note', 5); ?></div>
					</div>
				</section>

			</main>
			<footer class="main-footer">
				<div class="main-footer__top-row">
					<div class="top-row__inner">
						<div class="main-footer__text text bold"><?php the_field('faq_text', 5); ?></div>
					</div>
					<?php if( have_rows('faqs', 5) ): ?>
					<div class="top-row__faq-lay faq_full">
						<ul class="faq-list">
							<?php while ( have_rows('faqs', 5) ) : the_row(); ?>
								<li class="faq-item">
									<h6 class="faq-quest text bold"><?php the_sub_field('title', 5); ?></h6>
									<div class="faq-answer"><p class="text"><?php the_sub_field('text', 5); ?></p></div>
								</li>
							<?php endwhile; ?>
						</ul>
					</div>
					<?php endif; ?>
				</div>
				<div class="main-footer__bottom-row">
					<p class="main-footer__disclamer text"><?php the_field('footer_text', 5); ?></p>

					<?php if( have_rows('footer_menu', 5) ): $i=0; ?>
					<nav class="main-footer__main-nav">
						<ul class="main-footer__main-nav-list">
							<?php while ( have_rows('footer_menu', 5) ) : the_row(); $i++; ?>
								<li class="main-footer__main-nav-item"><a class="main-footer__main-nav-link text modal-triger" href="#template_<?php echo $i; ?>"><?php the_sub_field('name', 5); ?></a></li>
							<?php endwhile; ?>
						</ul>
					</nav>
					<?php endif; ?>

				</div>
			</footer>

			<?php if( have_rows('footer_menu', 5) ): $i=0; ?>
				<?php while ( have_rows('footer_menu', 5) ) : the_row(); $i++; ?>
					<template id="template_<?php echo $i; ?>">
						<div class="modal-content">
							<?php the_sub_field('content', 5); ?>
						</div>
					</template>
				<?php endwhile; ?>
			<?php endif; ?>

		</div><!-- #END wrapper -->

		<?php wp_footer(); ?>

		<script src="<?php echo get_template_directory_uri(); ?>/js/BeerSlider.js"></script>
		<script src="<?php echo get_template_directory_uri(); ?>/scripts.js"></script>
	</body>
</html>
