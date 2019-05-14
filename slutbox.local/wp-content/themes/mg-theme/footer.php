
		</main>
		<footer class="white">
			<div class="container">
				<h1 class="anim_box" data-animate="fadeInLeft"><?php the_field('gtl_title'); ?></h1>
				<div class="row">
					<div class="col-md-6 anim_box" data-animate="fadeInLeft" data-delay=".2s">
						<p><?php the_field('gtl_text'); ?></p>
					</div>
					<div class="col-md-6">
						<form action="" method="POST">
							<input type="email" placeholder="Enter Your e-mail adress" required>
							<input type="submit" value="Get Updates">
						</form>
					</div>
				</div>
				<p class="anim_box" data-animate="fadeInLeft"><small><?php the_field('copyright'); ?> See our <a href="#" class="openModal" data-modal="terms">Terms & Conditions</a> and <a href="#" class="openModal" data-modal="privacy">Privacy Policy</a></small></p>
			</div>
		</footer>

		<template id="terms"><?php the_field('terms'); ?></template>
		<template id="privacy"><?php the_field('privacy'); ?></template>

		<script>
			var getUrl = window.location;
			var baseUrl = getUrl.protocol + "//" + getUrl.host + "/" + getUrl.pathname.split('/')[1];
		</script>
		<script src="https://www.paypalobjects.com/api/checkout.js"></script>
		<script src="<?php echo get_template_directory_uri(); ?>/js/main.js'"></script>
		<script src="<?php echo get_template_directory_uri(); ?>/js/scripts.js'"></script>
		<?php wp_footer(); ?>
	</body>
</html>