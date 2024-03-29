<!DOCTYPE html>
<html <?php language_attributes(); ?> xmlns:og="http://ogp.me/ns#">
	<head>
		<meta charset="<?php bloginfo( 'charset' ); ?>">
		<meta name="keywords" content="<?php bloginfo('keywords'); ?>"/>
		<meta name="description" content="<?php bloginfo('description'); ?>"/>
		<meta name="copyright" content="<?php bloginfo('copyright'); ?>">

		<meta name="theme-color" content="#ff4ca8">
		<meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
		<meta content="initial-scale=1,user-scalable=no,maximum-scale=1,width=device-width" name="viewport">

		<link rel="shortcut icon" href="<?php echo get_template_directory_uri(); ?>/img/favicon.ico" type="image/x-icon">
		<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/style.css">

		<meta name="format-detection" content="telephone=no">
		<meta name="robots" content="nofollow" />

		<?php wp_head(); ?>
	</head>
	<body <?php body_class(); ?>>

		<!-- Global site tag (gtag.js) - Google Analytics -->
		<script async src="https://www.googletagmanager.com/gtag/js?id=UA-125459388-1"></script>
		<script>
		  window.dataLayer = window.dataLayer || [];
		  function gtag(){dataLayer.push(arguments);}
		  gtag('js', new Date());

		  gtag('config', 'UA-125459388-1');


		</script><!-- Google Tag Manager -->
		<script>
		  (function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
		  new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
		  j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
		  'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
		  })(window,document,'script','dataLayer','GTM-PFKNQHM');
		</script><!-- End Google Tag Manager -->
		<!-- google--><noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-PFKNQHM" height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
		<!-- amplify-->
		<script data-obct type="text/javascript">
		  !function(_window, _document) {
		    var OB_ADV_ID='008800d5494aecff4a7d0fcf514a110239';
		    if (_window.obApi) {
		      var toArray = function(object) {
		        return Object.prototype.toString.call(object) === '[object Array]' ? object : [object];
		      };
		      _window.obApi.marketerId = toArray(_window.obApi.marketerId).concat(toArray(OB_ADV_ID));
		      return;
		    }
		    var api = window.obApi = function() {
		      api.dispatch ? api.dispatch.apply(api, arguments) : api.queue.push(arguments);
		      };
		      api.version = '1.1';
		      api.loaded = true;
		      api.marketerId = OB_ADV_ID;
		      api.queue = [];
		      var tag = document.createElement('script');
		      tag.async = true;
		      tag.src = '//amplify.outbrain.com/cp/obtp.js';
		      tag.type = 'text/javascript';
		      var script = _document.getElementsByTagName('script')[0];
		      script.parentNode.insertBefore(tag, script);
		    }(window, document);

		</script>
		<!-- facebook-->
		<script>
		  !function(f,b,e,v,n,t,s)
		  {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
		  n.callMethod.apply(n,arguments):n.queue.push(arguments)};
		  if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
		  n.queue=[];t=b.createElement(e);t.async=!0;
		  t.src=v;s=b.getElementsByTagName(e)[0];
		  s.parentNode.insertBefore(t,s)}(window, document,'script',
		  'https://connect.facebook.net/en_US/fbevents.js');
		  fbq('init', '1073962692805700');
		  fbq('track', 'ViewContent');
		</script><noscript><img height="1" width="1" style="display:none" src="https://www.facebook.com/tr?id=1073962692805700&ev=PageView&noscript=1" /></noscript>
		<!-- taboola--><!-- Taboola Pixel Code -->
		<script>
		  window._tfa = window._tfa || [];
		  window._tfa.push({notify: 'event', name: 'page_view', id: 1165403});
		  !function (t, f, a, x) {
		         if (!document.getElementById(x)) {
		            t.async = 1;t.src = a;t.id=x;f.parentNode.insertBefore(t, f);
		         }
		  }(document.createElement('script'),
		  document.getElementsByTagName('script')[0],
		  '//cdn.taboola.com/libtrc/unip/1165403/tfa.js',
		  'tb_tfa_script');
		</script><noscript> <img src='//trc.taboola.com/1165403/log/3/unip?en=page_view' width='0' height='0' style='display:none'/> </noscript>
		<!-- End of Taboola Pixel Code -->


		<header id="main-header">
			<div class="container">
				<a href="<?php echo home_url(); ?>" class="logo"><img src="<?php the_field('logo'); ?>" alt="SlutBox logo"></a>
				<h1><?php the_field('ts_title'); ?></h1>
				<p class="title-note"><?php the_field('ts_subtitle'); ?></p>
				<button class="btn btn__purple" id="openOffer"><?php the_field('ts_btn_text'); ?></button>
				<p class="foot-note"><?php the_field('ts_note'); ?></p>
			</div>
		</header>

		<section class="s-offer-section" id="offer">
			<div class="container">
				<h1><?php the_field('sos_title'); ?></h1>
				<div class="s-offer-section__dscr-wrap row">
					<div class="col-sm-5">
						<img src="<?php the_field('sos_image'); ?>" alt="<?php the_field('sos_title'); ?>">
					</div>
					<div class="col-sm-7">
						<?php the_field('sos_content'); ?>
						<div id="subscribe-btns">
							<?php
								$args = array(
									'post_type'			=> 'mg_shop_products',
									'posts_per_page'	=> -1,
									'orderby'			=> 'date',
									'order'				=> 'ASC'
								);
								$myQuery = new WP_Query($args);
							?>
							<?php if ($myQuery->have_posts()): ?>
								<?php while ($myQuery->have_posts()): $myQuery->the_post();

									$product_id = get_field('product_id');
									$most_popular = get_field('most_popular');
									$best_deal = get_field('best_deal');
									$price = get_field('price');
									$issubscribe = get_field('issubscribe');
									$canbesubscribed = get_field('canbesubscribed');
									$shipping = get_field('shipping');

									if(!$issubscribe):
								?>
									<a id="scrollToForm" class="btn btn__purple accent-btn alert" href="#" data-step="2" data-answer="yes" data-product-id="<?php echo $product_id; ?>" data-product-name="<?php the_title(); ?>" <?php if($shipping > 0){ echo 'data-product-shipping="'. $shipping .'"'; } ?> data-product-price="<?php echo $price; ?>" data-product-cartimg="<?php echo get_the_post_thumbnail_url(); ?>">YES I WANT</a>
								</li>
								<?php endif; endwhile; wp_reset_postdata(); ?>
							<?php endif; ?>
							<a class="btn btn__no s-offer-section__no-s-offer-link" href="#" data-step="2" data-answer="no" id="closeOffer">No, I don’t want</a>
						</div>
					</div>
				</div>
			</div>
		</section>

		<main id="main">