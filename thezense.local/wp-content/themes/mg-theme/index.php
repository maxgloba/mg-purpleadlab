<?php
/*
 * Template Name: Main
 */
get_header(); ?>

<?php while ( have_posts() ) : the_post(); ?>

        <section class="top-section">
          <div class="container">
            <h1 class="title"><?php the_field('ts_title'); ?></h1>
            <div class="sub-title"><?php the_field('ts_subtitle'); ?></div>
            <div class="top-section__dscr-wrap">
              <div class="top-section__gallery-col">
                <?php $images = get_field('ts_gallery'); if( $images ): ?>
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
                <?php the_field('ts_description'); ?>
              </div>
            </div>
          </div>
        </section>

        <section class="howtouse-section">
          <div class="container">
            <h2 class="title accented"><?php the_field('hts_title'); ?></h2>
            <div class="sub-title"><?php the_field('hts_title'); ?></div>
            <?php if( have_rows('hts_steps') ): ?>
              <ul class="howtouse-section__steps-list">
                <?php while ( have_rows('hts_steps') ) : the_row(); ?>
                  <li class="howtouse-section__steps-item">
                    <?php the_sub_field('text'); ?>
                  </li>
                <?php endwhile; ?>
              </ul>
            <?php endif; ?>
            <?php the_field('hts_notes'); ?>
          </div>
        </section>

        <section class="feedback-section">
          <div class="container">
            <h2 class="title gray"><?php the_field('fbs_notes'); ?></h2>

            <?php if( have_rows('feedback') ): ?>
              <ul class="feedback__list">

                <?php
                  while ( have_rows('feedback') ) : the_row();
                    $stars = get_sub_field('stars');
                ?>
                  <?php if( have_rows('beer_slider') ): ?>
                    <li class="feedback">
                  <?php else: ?>
                    <li class="feedback noslider">
                  <?php endif; ?>

                    <?php if( have_rows('beer_slider') ): ?>
                      <div class="feedback__sliders-col">
                        <?php while ( have_rows('beer_slider') ) : the_row(); ?>
                          <div class="beer-slider"><img src="<?php the_sub_field('right_image'); ?>" />
                            <div class="beer-reveal"><img src="<?php the_sub_field('left_image'); ?>" /></div>
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
                      <h6 class="feedback__title"><?php the_sub_field('title'); ?></h6>
                      <p class="feedback__text"><?php the_sub_field('text'); ?></p>
                      <div class="feedback__name"><?php the_sub_field('name'); ?></div>
                    </div>
                  </li>
                <?php endwhile; ?>

              </ul>
            <?php endif; ?>

          </div>
        </section>

        <section class="product-section" id="product-section">
          <div class="container">
            <h2 class="title"><?php the_field('ps_title'); ?></h2>
            <div class="text"><?php the_field('ps_subtitle'); ?></div>
              <?php
                $args = array(
                  'post_type'      => 'mg_shop_products',
                  'posts_per_page' => 3,
                  'orderby'        => 'date',
                  'order'          => 'ASC'
                );
                $myQuery = new WP_Query($args);
              ?>
              <?php if ($myQuery->have_posts()): ?>
                <ul class="product-section__product-list">
                <?php
                  while ($myQuery->have_posts()): $myQuery->the_post();

                    $product_id = get_field('product_id');
                    $most_popular = get_field('most_popular');
                    $best_deal = get_field('best_deal');
                    $price = get_field('price');
                    $issubscribe = get_field('issubscribe');
                    $canbesubscribed = get_field('canbesubscribed');
                    $shipping = get_field('shipping');

                  if(!$issubscribe):
                ?>
                  <li class="product-section__product-item <?php if($best_deal){echo 'accented-item';} else if($most_popular){echo 'most_popular';} ?>">
                    <a class="product-item__link" href="#" data-product-id="<?php echo $product_id; ?>" data-product-name="<?php the_title(); ?>" data-product-price="<?php echo $price; ?>" <?php if($shipping > 0){ echo 'data-product-shipping="'. $shipping .'"'; } ?> <?php if( $canbesubscribed ){ echo "data-product-canbesubscribed"; } ?> data-product-cartimg="<?php echo get_the_post_thumbnail_url(); ?>" data-step="1">
                    <div class="product-item__title bold"><?php the_title(); ?></div>
                    <div class="product-item__flex">
                      <div class="product-item__checkbox-container">
                        <input type="checkbox">
                      </div>
                      <div class="product-item__left"><img src="<?php echo get_the_post_thumbnail_url(); ?>" alt="<?php the_title(); ?>"></div>
                      <div class="product-item__right">
                        <?php the_content(); ?>
                      </div>
                    </div>
                    </a>
                  </li>
                <?php endif; endwhile;  wp_reset_postdata(); ?>
                </ul>
              <?php endif; ?>
          </div>
        </section>

        <section class="s-offer-section">
          <div class="container">
            <h2 class="title">Special Limited-Time Offer!</h2>
            <div class="sub-title">Save more with a monthly subscription!</div>
              <?php
                $args = array(
                  'post_type'      => 'mg_shop_products',
                  'posts_per_page' => -1,
                  'orderby'        => 'date',
                  'order'          => 'ASC'
                );
                $myQuery = new WP_Query($args);
                if ($myQuery->have_posts()): while ($myQuery->have_posts()): $myQuery->the_post();

                  $issubscribe = get_field('issubscribe');
                  $shipping = get_field('shipping');

                  if($issubscribe):
              ?>
                <div class="s-offer-section__dscr-wrap">
                  <div class="s-offer-section__img-col"><img src="<?php echo get_the_post_thumbnail_url(); ?>" alt="<?php the_title(); ?>"></div>
                  <div class="s-offer-section__dscr-col">
                    <?php the_content(); ?>
                    <div id="subscribe-btns">
                      <a class="accent-btn alert" href="#" data-step="2" data-answer="yes" data-product-id="<?php the_field('product_id'); ?>" data-product-name="<?php the_title(); ?>" <?php if($shipping > 0){ echo 'data-product-shipping="'. $shipping .'"'; } ?> data-product-price="<?php the_field('price'); ?>" data-product-issubscribe="data-product-issubscribe" data-product-cartimg="<?php echo get_the_post_thumbnail_url(); ?>">Yes! I want to save with a monthly subscription!</a>
                      <a class="s-offer-section__no-s-offer-link" href="#" data-step="2" data-answer="no">No, I don’t want to save money</a>
                    </div>
                  </div>
                </div>
              <?php endif; endwhile;  wp_reset_postdata(); endif; ?>
          </div>
        </section>

        <section class="form-section">
          <div class="container">
            <h3 class="title">Complete your order</h3>
            <div class="form-section__wrap">
              <div class="form-section__payform-container">
                <div class="form-lay">
                  <p class="shipping-info">Shipping information</p>
                  <form id="address-form">
                    <div class="row">
                      <div class="field">
                        <input class="input empty" id="email" type="email" placeholder="Email" required="" name="email">
                        <label for="email">Email</label>
                      </div>
                    </div>
                    <div class="row">
                      <div class="field half-width">
                        <input class="input empty" id="first-name" type="text" placeholder="First Name" required="" name="first-name">
                        <label for="first-name">First Name</label>
                      </div>
                      <div class="field half-width">
                        <input class="input empty" id="last-name" type="text" placeholder="Last Name" required="" name="last-name">
                        <label for="last-name">Last Name</label>
                      </div>
                    </div>
                    <div class="row">
                      <div class="field half-width">
                        <input class="input empty" id="address" type="text" placeholder="Address" required="" name="line1">
                        <label for="address">Address</label>
                      </div>
                      <div class="field half-width">
                        <input class="input empty" id="apt" type="text" placeholder="Apt/Suite (optional)" name="line2">
                        <label for="apt">Apt/Suite (optional)</label>
                      </div>
                    </div>
                    <div class="row">
                      <div class="field">
                        <input class="input empty" id="city" type="text" placeholder="City" required="" name="city">
                        <label for="city">City</label>
                      </div>
                    </div>
                    <div class="row" data-locale-reversible>
                      <div class="field half-width">
                        <select class="input empty" id="country" name="country" required=""></select>
                        <label for="country">Country</label>
                      </div>
                      <div class="field quarter-width">
                        <input class="input empty" id="state" type="text" placeholder="State" required="" name="state">
                        <label for="state">State</label>
                      </div>
                      <div class="field quarter-width">
                        <input class="input empty" id="zip" type="text" placeholder="ZIP" required="" name="zip" pattern="[0-9]{5}" maxlength="5">
                        <label for="zip">ZIP</label>
                      </div>
                    </div>
                    <div class="row">
                      <div class="field">
                        <input class="input empty" id="phone" type="tel" placeholder="Phone number (optional)" name="phone">
                        <label for="phone">Phone number</label>
                      </div>
                    </div>
                    <button class="accent-btn import" type="submit">NEXT</button>
                  </form>
                </div>
              </div>
              <div class="form-section__cart-list-container">
                <ul class="cart-list"></ul>
                <div class="total-block">
                  <div class="total-block__style-line"></div>
                  <div class="total-block__price-row">
                    <div class="total-block__name"><span>Tax </span></div>
                    <div class="total-block__price"><span data-tax>---</span></div>
                  </div>
                  <div class="total-block__price-row">
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
          <template id="cart-item">
            <li class="cart-item">
              <div class="cart-item__img-container"><img class="img-responsive" src="" alt="cart img"></div>
              <div class="cart-item__dscr-container">
                <p class="text bold" data-dscr></p>
              </div>
              <div class="cart-item__price-container">
                <p class="text bold"><span class="span"> </span><span class="span" data-price></span></p>
              </div>
            </li>
          </template>
        </section>

        <section class="payment-section">
          <div class="container">
            <div class="form-group">
              <p class="pay-info">Choose payment method</p>
              <div id="pay-trigers"></div>
            </div>
          </div>
        </section>

        <section class="guarantee-section">
          <div class="container">
            <div class="text bold"><?php the_field('gs_note'); ?></div>
          </div>
        </section>

<?php endwhile; ?>
<?php get_footer(); ?>