<?php
/*
 * Template Name: Main
 */
get_header(); ?>

<?php while ( have_posts() ) : the_post(); ?>

<!-- content -->
<section class="brand">
	<div class="container">
		<ul>
			<?php while(has_sub_field('brands')): ?>
				<li><img src="<?php the_sub_field('image'); ?>" alt=""></li>
			<?php endwhile; ?>
		</ul>
	</div>
</section>

<section class="who_we_are">
	<div class="container">
		<h1>Who we are</h1>
		<div class="row">
			<div class="col-md-7">
				<img src="<?php the_field('wwa_image'); ?>" alt="" class="who_we_are__image">
			</div>
			<div class="col-md-5"><?php the_field('wwa_content'); ?></div>
		</div>
	</div>
</section>

<section class="who_we_are who_we_are__info">
	<div class="container" style="background-image: url(<?php the_field('am_model'); ?>);">
		<div class="row">
			<div class="col-md-8">
				<p class="mb60"><b><?php the_field('am_text'); ?></b></p>
			</div>
		</div>
		<div class="row">
			<div class="col-md-5">
				<p><?php the_field('am_desc'); ?></p>
			</div>
		</div>
		<div class="row">
			<div class="col-md-5">
				<div class="mom">
					<img src="<?php the_field('am_image'); ?>" alt="">
					<span><?php the_field('am_muva'); ?></span>
				</div>
			</div>
		</div>
	</div>
</section>

<section class="how_it_works">
	<div class="container">
		<h1><?php the_field('hiw_title'); ?></h1>
		<div class="row">
			<div class="col-md-5"><?php the_field('hiw_content'); ?></div>
			<div class="col-md-7 pl80"><?php the_field('hiw_content_wi'); ?></div>
		</div>
	</div>
</section>

<section class="past_boxes">
	<div class="container">
		<h1>Past Boxes</h1>
		<div class="row">
			<div class="col-md-6">
				<span class="img-box"><img src="<?php echo get_template_directory_uri(); ?>/img/past/past-img-1.jpg" alt=""></span>
				<span class="date">April 2019</span>
				<h3>Spring Fling</h3>
				<p>Spring is in the air! The seasons are changin’, the days are gettin’ longer and hemlines are gettin’ shorter. Everyone’s…</p>
			</div>
			<div class="col-md-6">
				<span class="img-box"><img src="<?php echo get_template_directory_uri(); ?>/img/past/past-img-2.jpg" alt=""></span>
				<span class="date">March 2019</span>
				<h3>Get Lucky</h3>
				<p>Happy Spring, gorgeous! March is all about easing into the new season and gearing up for spring break. (Hey –…</p>
			</div>
			<div class="col-md-6">
				<span class="img-box"><img src="<?php echo get_template_directory_uri(); ?>/img/past/past-img-3.jpg" alt=""></span>
				<span class="date">February 2019</span>
				<h3>Stupid Cupid</h3>
				<p>Hey Sluts! Happy V-Day to my slutty Valentines! February is one of my favorite months of the year, and I…</p>
			</div>
			<div class="col-md-6">
				<span class="img-box"><img src="<?php echo get_template_directory_uri(); ?>/img/past/past-img-4.jpg" alt=""></span>
				<span class="date">January 2019</span>
				<h3>Salty x Amber Rose Box</h3>
				<p>Happy New Year, Heauxs! I’m so proud to be walkin’ into 2019 with you bad bitches at my side. Issa…</p>
			</div>
			<div class="col-md-6">
				<span class="img-box"><img src="<?php echo get_template_directory_uri(); ?>/img/past/past-img-5.jpg" alt=""></span>
				<span class="date">December 2018</span>
				<h3>Ho Ho Ho</h3>
				<p>Happy ho-ho-holidays, Heauxs! Now matter what or how you celebrate, December is one of the most magical months of the…</p>
			</div>
			<div class="col-md-6">
				<span class="img-box"><img src="<?php echo get_template_directory_uri(); ?>/img/past/past-img-6.jpg" alt=""></span>
				<span class="date">November 2018</span>
				<h3>Love Urself</h3>
				<p>It’s November! Time for pumpkin pie, collard greens, mama’s mac n’ cheese and MUVA’s November Amber Rose Box ! November is…</p>
			</div>
		</div>
	</div>
</section>

<section class="testimonials">
	<div class="container">
		<h1>Testimonials</h1>
		<div class="row">
			<div class="col-md-3 col-xs-6">
				<img src="<?php echo get_template_directory_uri(); ?>/img/testimonials/testimonials-img-1.svg" alt="">
				<h3>SLUT Girl 1</h3>
				<h4>Los Santos</h4>
				<p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo.</p>
			</div>
			<div class="col-md-3 col-xs-6">
				<img src="<?php echo get_template_directory_uri(); ?>/img/testimonials/testimonials-img-2.svg" alt="">
				<h3>SLUT Girl 2</h3>
				<h4>Los Santos</h4>
				<p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae.</p>
			</div>
			<div class="col-md-3 col-xs-6">
				<img src="<?php echo get_template_directory_uri(); ?>/img/testimonials/testimonials-img-3.svg" alt="">
				<h3>SLUT Girl 3</h3>
				<h4>Los Santos</h4>
				<p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis.</p>
			</div>
			<div class="col-md-3 col-xs-6">
				<img src="<?php echo get_template_directory_uri(); ?>/img/testimonials/testimonials-img-4.svg" alt="">
				<h3>SLUT Girl 4</h3>
				<h4>Los Santos</h4>
				<p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo.</p>
			</div>
		</div>
	</div>
</section>

<section class="product-section" id="product-section">
	<div class="container">
		<h1><?php the_field('ps_title'); ?></h1>
		<?php
			$args = array(
				'post_type'			=> 'mg_shop_products',
				'posts_per_page'	=> 4,
				'orderby'			=> 'date',
				'order'				=> 'ASC'
			);
			$myQuery = new WP_Query($args);
		?>
		<?php if ($myQuery->have_posts()): ?>
			<ul class="product-section__product-list row">
			<?php while ($myQuery->have_posts()): $myQuery->the_post();

				$product_id = get_field('product_id');
				$most_popular = get_field('most_popular');
				$best_deal = get_field('best_deal');
				$price = get_field('price');
				$issubscribe = get_field('issubscribe');
				$canbesubscribed = get_field('canbesubscribed');
				$shipping = get_field('shipping');

				if($issubscribe):
			?>
			<li class="product-section__product-item <?php if($most_popular){echo 'product-section__product-accent';} ?> col-md-3 col-xs-6">
				<div class="product-item__price"><?php echo $price; ?></div>
				<div class="product-item__shipping">+Free Shipping*<br>*US Only</div>
				<div class="product-item__title"><?php the_title(); ?></div>
				<a class="product-item__link" href="#" data-step="2" data-answer="yes" data-product-id="<?php echo $product_id; ?>" data-product-name="<?php the_title(); ?>" <?php if($shipping > 0){ echo 'data-product-shipping="'. $shipping .'"'; } ?> <?php if( $canbesubscribed ){ echo "data-product-canbesubscribed"; } ?> data-product-price="<?php echo $price; ?>" data-product-issubscribe="data-product-issubscribe" data-product-cartimg="<?php echo get_the_post_thumbnail_url(); ?>" >Choose</a>
				<div class="product-item__description"><?php the_content(); ?></div>
			</li>
			<?php endif; endwhile; wp_reset_postdata(); ?>
		</ul>
		<?php endif; ?>
	</div>
</section>

<section class="form-section" id="formSection">
	<div class="container">
		<div class="form-section__wrap">
			<div class="form-section__payform-container">
				<div class="form-lay">
					<div class="row">
						<div class="col-md-7">
							<form id="address-form">
								<h3>Contact information</h3>
								<input class="input empty" id="email" type="email" placeholder="Email" required="" name="email">
								<h3>Shipping address</h3>
								<div class="row">
									<div class="col-md-6">
										<input class="input empty" id="first-name" type="text" placeholder="First Name" required="" name="first-name">
									</div>
									<div class="col-md-6">
										<input class="input empty" id="last-name" type="text" placeholder="Last Name" required="" name="last-name">
									</div>
									<div class="col-md-12">
										<input class="input empty" id="phone" type="tel" placeholder="Phone number (optional)" name="phone">
									</div>
									<div class="col-md-8">
										<input class="input empty" id="address" type="text" placeholder="Address" required="" name="line1">
									</div>
									<div class="col-md-4">
										<input class="input empty" id="apt" type="text" placeholder="Apt/Suite (optional)" name="line2">
									</div>
									<div class="col-md-12">
										<input class="input empty" id="city" type="text" placeholder="City" required="" name="city">
									</div>
									<div class="col-md-6" data-locale-reversible>
										<select class="input empty" id="country" name="country" required="">
											<option value="">Option 1</option>
											<option value="">Option 2</option>
										</select>
									</div>
									<div class="col-md-4">
										<input class="input empty" id="state" type="text" placeholder="State" required="" name="state">
									</div>
									<div class="col-md-2">
										<input class="input empty" id="zip" type="text" placeholder="ZIP" required="" name="zip" pattern="[0-9]{5}" maxlength="5">
									</div>
									<div class="col-md-12">
										<button class="accent-btn import" type="submit">Order NOW</button>
									</div>
								</div>
							</form>
						</div>
						<div class="col-md-5">
							<h3>Your order</h3>
							<div class="form-section__cart-list-container">
								<ul class="cart-list"></ul>
								<div class="total-block">
									<div class="total-block__style-line"></div>
									<div class="total-block__info-row">
										<div class="total-block__name"><span>Tax </span></div>
										<div class="total-block__price"><span data-tax>---</span></div>
									</div>
									<div class="total-block__info-row">
										<div class="total-block__name"> <span>Shipping</span></div>
										<div class="total-block__price" data-shipping> <span data-shipping>---</span></div>
									</div>
									<div class="total-block__style-line"></div>
									<div class="total-block__price-row">
										<div class="total-block__name"><span>Total</span></div>
										<div class="total-block__price large"><span data-total>---</span></div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<template id="cart-item">
		<li class="cart-item row">
			<div class="cart-item__img-container col-xs-5"><img class="img-responsive" src="" alt="cart img"></div>
			<div class="col-xs-7">
				<div class="cart-item__dscr-container" data-dscr></div>
				<div class="cart-item__price-container" data-price></div>
			</div>
		</li>
	</template>
	<section class="payment-section">
		<div class="container">
			<p class="pay-info">Choose payment method</p>
			<div id="pay-trigers"></div>
		</div>
	</section>
</section>

<?php endwhile; ?>
<?php get_footer(); ?>