<?php
/*
 * Template Name: Main
 */
get_header(); ?>

<?php while ( have_posts() ) : the_post(); ?>

	<?php echo do_shortcode('[chargify]'); ?>

<!-- content -->
<section class="brand">
	<div class="container">
		<ul>
			<?php while(has_sub_field('brands')): ?>
				<li class="anim_box" data-animate="zoomIn"><img src="<?php the_sub_field('image'); ?>" alt=""></li>
			<?php endwhile; ?>
		</ul>
	</div>
</section>

<section class="who_we_are">
	<div class="container">
		<h1 class="anim_box" data-animate="fadeInLeft"><?php the_field('wwa_title'); ?></h1>
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
			<div class="col-md-8 anim_box" data-animate="fadeInLeft">
				<p class="mb60"><b><?php the_field('am_text'); ?></b></p>
			</div>
		</div>
		<div class="row">
			<div class="col-md-5 anim_box" data-animate="fadeInLeft">
				<p><?php the_field('am_desc'); ?></p>
			</div>
		</div>
		<div class="row">
			<div class="col-md-5 anim_box" data-animate="fadeInLeft">
				<div class="mom">
					<img src="<?php the_field('am_image'); ?>" alt="mom" class="anim_box" data-animate="zoomIn" data-delay=".5s">
					<span><?php the_field('am_muva'); ?></span>
				</div>
			</div>
		</div>
	</div>
</section>

<section class="how_it_works">
	<div class="container">
		<h1 class="anim_box" data-animate="fadeInLeft"><?php the_field('hiw_title'); ?></h1>
		<div class="row">
			<div class="col-md-5"><?php the_field('hiw_content'); ?></div>
			<div class="col-md-7 pl80"><?php the_field('hiw_content_wi'); ?></div>
		</div>
	</div>
</section>

<section class="past_boxes">
	<div class="container">
		<h1 class="anim_box" data-animate="fadeInLeft"><?php the_field('pb_title'); ?></h1>
		<div class="row">
			<?php $i=0; while(has_sub_field('past_boxes')): $i++; ?>
				<div class="col-md-6 anim_box" data-animate="<?php if($i%2==0): echo 'fadeInRight'; else: echo 'fadeInLeft'; endif?>">
					<span class="img-box"><img src="<?php the_sub_field('image'); ?>" alt="<?php the_sub_field('title'); ?>"></span>
					<span class="date"><?php the_sub_field('date'); ?></span>
					<h3><?php the_sub_field('title'); ?></h3>
					<p><?php the_sub_field('text'); ?></p>
				</div>
			<?php endwhile; ?>
		</div>
	</div>
</section>

<section class="testimonials">
	<div class="container">
		<h1 class="anim_box" data-animate="fadeInLeft"><?php the_field('t_title'); ?></h1>
		<div class="row">
			<?php $i=0; while(has_sub_field('testimonials')): $i++;?>
				<div class="col-md-3 col-xs-6 anim_box" data-animate="fadeInUp" data-delay=".<?php echo $i; ?>s">
					<img src="<?php the_sub_field('image'); ?>" alt="<?php the_sub_field('title'); ?>">
					<h3><?php the_sub_field('title'); ?></h3>
					<h4><?php the_sub_field('subtitle'); ?></h4>
					<p><?php the_sub_field('text'); ?></p>
				</div>
			<?php endwhile; ?>
		</div>
	</div>
</section>

<section class="product-section" id="product-section">
	<div class="container">
		<h1 class="anim_box" data-animate="fadeInLeft"><?php the_field('ps_title'); ?></h1>
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
						<div class="col-md-5 pull_right">
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