<?php
/*
 * Template Name: Main
 */
get_header(); ?>

<?php while ( have_posts() ) : the_post(); ?>

<section class="swiper wrapper">
    <form id="quiz_form">
        <div class="swiper-container">
            <div class="swiper-wrapper">
                <div class="swiper-slide">
                    <div class="swiper-slide__content">
                        <div class="slide-content__title-wrapper">
                            <div class="slide-title__wrapper">
                                <h3 class="slide-title">
                                    <?php the_field('s1_title'); ?>
                                </h3>
                            </div>
                            <div class="slide-descr__wrapper">
                                <p class="slide-descr">
                                    <?php the_field('s1_desc'); ?>
                                </p>
                            </div>
                        </div>
                        <div class="slide-btn__container">
                            <div class="slide-btn__title-wrapper">
                                <h3 class="slide-btn__title">
                                    <?php the_field('s1_quiz_title'); ?>
                                </h3>
                            </div>
                            <div id="start" class="slide-btn__wrapper">
                                <a href="#" class="slide-btn"><?php the_field('s1_btn_text'); ?></a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="swiper-slide">
                    <div class="swiper-slide__content">
                        <div class="slide-title__wrapper start-title-wrapper">
                            <div class="slide-descr__wrapper">
                                <p class="slide-descr number">
                                    1/4
                                </p>
                            </div>
                            <h3 class="slide-title">
                                <?php the_field('s2_title'); ?>
                            </h3>
                        </div>
                        <div class="slide-form__wrapper start-content-wrapper">
                            <?php if(get_field('s2_options')): $i=0; ?>
                                <ul class="slide-form__list start-list">
                                <?php while(has_sub_field('s2_options')): $i++; ?>
                                    <li class="slide-form__start-item start-item">
                                        <input id="c1-<?php echo $i; ?>" class="slide-form__start start-input" type="radio" name="c1_list[]" value="<?php the_sub_field('bullet'); ?> <?php the_sub_field('text'); ?>">
                                        <label for="c1-<?php echo $i; ?>" class="slide-form__start-label"><?php the_sub_field('text'); ?> <span class="start-label__span"><?php the_sub_field('desc'); ?></span></label>
                                        <p class="slide-form__start-par"><?php the_sub_field('bullet'); ?></p>
                                    </li>
                                <?php endwhile; ?>
                                </ul>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <div class="swiper-slide">
                    <div class="swiper-slide__content">
                        <div class="slide-title__wrapper social-title-wrapper">
                            <div class="slide-descr__wrapper">
                                <p class="slide-descr number">
                                    2/4
                                </p>
                            </div>
                            <h3 class="slide-title">
                                <?php the_field('s3_title'); ?>
                            </h3>
                            <div class="slide-title__descr-wrapper">
                                <p class="slide-title__descr">
                                    <?php the_field('s3_subtitle'); ?>
                                </p>
                            </div>
                        </div>
                        <div class="slide-form__wrapper social-content-wrapper">
                            <?php if(get_field('s3_options')): $i=0; ?>
                                <ul class="slide-form__list social-list-wrapper">
                                <?php while(has_sub_field('s3_options')): $i++; ?>
                                    <li class="slide-form__item social-item">
                                        <input id="c2-<?php echo $i; ?>" class="slide-form__social social-input" type="checkbox" name="c2_list[]" value="<?php the_sub_field('bullet'); ?> <?php the_sub_field('text'); ?>" >
                                        <label for="c2-<?php echo $i; ?>" class="slide-form__social-label"><?php the_sub_field('text'); ?></label>
                                        <p class="slide-form__social-par"><?php the_sub_field('bullet'); ?></p>
                                    </li>
                                <?php endwhile; ?>
                                </ul>
                            <?php endif; ?>
                            <div id="socialSubmit" class="slide-form__btn-wrapper social__submit-btn">
                                <a href="#" class="slide-form__btn"><?php the_field('s3_btn_text'); ?></a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="swiper-slide">
                    <div class="swiper-slide__content">
                        <div class="slide-title__wrapper text-title-wrapper">
                            <div class="slide-descr__wrapper">
                                <p class="slide-descr number">
                                    3/4
                                </p>
                            </div>
                            <h3 class="slide-title">
                                <?php the_field('s4_title'); ?>
                            </h3>
                        </div>
                        <div class="slide-form__list-wrapper text-content-wrapper">
                            <?php if(get_field('s4_options')): $i=0; ?>
                                <ul class="slide-form__list text-list text-list">
                                <?php while(has_sub_field('s4_options')): $i++; ?>
                                    <li class="slide-form__item text-item">
                                        <input id="c3-<?php echo $i; ?>" type="radio" name="c3_list[]" value="<?php the_sub_field('bullet'); ?> <?php the_sub_field('text'); ?>" class="slide-form__text text-input">
                                        <label for="c3-<?php echo $i; ?>" class="slide-form__text-label"><?php the_sub_field('text'); ?></label>
                                        <p class="slide-form__text-par"><?php the_sub_field('bullet'); ?></p>
                                    </li>
                                <?php endwhile; ?>
                                </ul>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <div class="swiper-slide">
                    <div class="swiper-slide__content">
                        <div class="slide-title__wrapper advertise-title-wrapper">
                            <div class="slide-descr__wrapper">
                                <p class="slide-descr number">
                                    4/4
                                </p>
                            </div>
                            <h3 class="slide-title">
                                <?php the_field('s5_title'); ?>
                            </h3>
                            <div class="slide-title__descr-wrapper">
                                <p class="slide-title__descr">
                                    <?php the_field('s5_subtitle'); ?>
                                </p>
                            </div>
                        </div>
                        <div class="slide-form__list-wrapper advertise-content-wrapper">
                            <?php if(get_field('s5_options')): $i=0; ?>
                                <ul class="slide-form__list advertise-list-wrapper">
                                <?php while(has_sub_field('s5_options')): $i++; ?>
                                    <li class="slide-form__item advertise-item">
                                        <input id="c4-<?php echo $i; ?>" type="checkbox" name="c4_list[]" value="<?php the_sub_field('bullet'); ?> <?php the_sub_field('text'); ?>" class="slide-form__advertise advertise-input">
                                        <label for="c4-<?php echo $i; ?>" class="slide-form__advertise-label">
                                            <?php the_sub_field('text'); ?>
                                            <?php if ( get_sub_field('desc') ): ?><span class="advertise-label__span"><?php the_sub_field('desc'); ?></span><?php endif; ?>
                                        </label>
                                        <p class="slide-form__advertise-par"><?php the_sub_field('bullet'); ?></p>
                                    </li>
                                <?php endwhile; ?>
                                </ul>
                            <?php endif; ?>
                            <div id="advertiseSubmit" class="slide-form__btn-wrapper advertise__submit-btn">
                                <a href="#" class="slide-form__btn"><?php the_field('s5_btn_text'); ?></a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="swiper-slide">
                    <div class="swiper-slide__content">
                        <div id="contactForm">
                            <h2><?php the_field('s6_title'); ?></h2>
                            <ul>
                                <li><input type="text" id="first_name" name="first_name" placeholder="First name" required></li>
                                <li><input type="text" id="last_name" name="last_name" placeholder="Last name" required></li>
                                <li><input type="email" id="email" name="email" placeholder="Email" required></li>
                                <li><input type="tel" id="phone" name="phone" placeholder="Phone" required></li>
                                <li><input type="submit" value="SEND"></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="swiper-slide">
                    <div class="finish__wrapper">
                        <div class="finish__title-wrapper">
                            <h3 class="finish__title">
                                <?php the_field('s7_title'); ?>
                            </h3>
                        </div>
                        <div class="finish__descr-wrapper">
                            <p class="finish__descr">
                                <?php the_field('s7_subtitle'); ?>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</section>
<?php endwhile; ?>


<script src="https://cdnjs.cloudflare.com/ajax/libs/Swiper/4.5.0/js/swiper.min.js"></script>
<script src="<?php echo get_template_directory_uri(); ?>/js/main.js"></script>
<?php get_footer(); ?>