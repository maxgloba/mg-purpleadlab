<?php
/*
 * Template Name: Main
 */
get_header(); ?>

<?php while ( have_posts() ) : the_post(); ?>

<section class="main" style="background-image: url(<?php the_field('bg_image'); ?>); background-color: <?php the_field('bg_color'); ?>;">
    <div class="container">
        <div class="content-wrapper">
            <div class="clearfix">
                <div class="left-box">
                    <h1><?php the_field('s1_title'); ?></h1>
                    <p class="description"><?php the_field('s1_desc'); ?></p>
                </div>
                <div class="right-box"><img src="<?php the_field('s1_image'); ?>" alt=""></div>
            </div>
            <div class="quiz-block" id="quiz-block">
                <div class="quiz-title">
                    <h2>Question <span class="quiz-num">1</span> of 4</h2>
                    <div class="quiz-progress">
                        <span style="width: 0%;"></span>
                    </div>
                </div>
                <div class="quiz-content">
                    <form action="" id="quiz_form">
                        <div class="question question_1 active" >
                            <h3><?php the_field('s2_title'); ?></h3>
                            <p><?php the_field('s2_subtitle'); ?></p>
                            <?php if(get_field('s2_options')): $i=0; ?>
                            <ul>
                                <?php while(has_sub_field('s2_options')): $i++; ?>
                                <li>
                                    <div class="radio">
                                        <input type="radio" name="q1_list[]" id="q1_<?php echo $i; ?>" value="<?php the_sub_field('text'); ?>">
                                        <label for="q1_<?php echo $i; ?>"><?php the_sub_field('text'); ?></label>
                                    </div>
                                </li>
                                <?php endwhile; ?>
                            </ul>
                            <?php endif; ?>
                        </div>
                        <div class="question question_2">
                            <h3><?php the_field('s3_title'); ?></h3>
                            <p><?php the_field('s3_subtitle'); ?></p>
                            <?php if(get_field('s3_options')): $i=0; ?>
                            <ul class="clearfix col-3">
                                <?php while(has_sub_field('s3_options')): $i++; ?>
                                <li>
                                    <div class="checkbox">
                                        <input type="checkbox" name="q2_list[]" id="q2_<?php echo $i; ?>" value="<?php the_sub_field('text'); ?>">
                                        <label for="q2_<?php echo $i; ?>"><?php the_sub_field('text'); ?></label>
                                    </div>
                                </li>
                                <?php endwhile; ?>
                            </ul>
                            <?php endif; ?>
                            <div id="goTo_question_3" class="btn btn-green" style="display: none;"><?php the_field('s3_btn_text'); ?></div>
                        </div>
                        <div class="question question_3">
                            <h3><?php the_field('s4_title'); ?></h3>
                            <p><?php the_field('s4_subtitle'); ?></p>
                            <?php if(get_field('s4_options')): $i=0; ?>
                            <ul class="clearfix col-2">
                                <?php while(has_sub_field('s4_options')): $i++; ?>
                                <li>
                                    <div class="radio">
                                        <input type="radio" name="q3_list[]" id="q3_<?php echo $i; ?>" value="<?php the_sub_field('text'); ?>">
                                        <label for="q3_<?php echo $i; ?>"><?php the_sub_field('text'); ?></label>
                                    </div>
                                </li>
                                <?php endwhile; ?>
                            </ul>
                            <?php endif; ?>
                        </div>
                        <div class="question question_4">
                            <h3><?php the_field('s5_title'); ?></h3>
                            <p><?php the_field('s5_subtitle'); ?></p>
                            <?php if(get_field('s5_options')): $i=0; ?>
                            <ul class="col-2">
                                <?php while(has_sub_field('s5_options')): $i++; ?>
                                <li>
                                    <div class="checkbox">
                                        <input type="checkbox" name="q4_list[]" id="q4_<?php echo $i; ?>" value="<?php the_sub_field('text'); ?>">
                                        <label for="q4_<?php echo $i; ?>"><?php the_sub_field('text'); ?></label>
                                    </div>
                                </li>
                                <?php endwhile; ?>
                            </ul>
                            <?php endif; ?>
                            <div id="goTo_question_5" class="btn btn-green" style="display: none;"><?php the_field('s5_btn_text'); ?></div>
                        </div>
                        <div class="question question_5">
                            <h3><?php the_field('profress_title'); ?></h3>
                            <div id="q5_num" class="q5_num">
                                <strong>0<i>%</i></strong>
                            </div>
                        </div>
                        <div class="question question_6">
                            <h3><?php the_field('form_title'); ?></h3>
                            <p><?php the_field('form_subtitle'); ?></p>
                            <div class="form row">
                                <div class="col-sm-6"><input type="text" name="first_name" id="first_name" placeholder="First Name" required></div>
                                <div class="col-sm-6"><input type="email" name="email" id="email" placeholder="E-mail Adress" required></div>
                                <div class="col-sm-12"><input type="submit" value="Send My Free Book"></div>
                            </div>
                        </div>
                        <div class="question question_7">
                            <img src="<?php the_field('check_image'); ?>" alt="" class="q7_check">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="free-ebook">
    <div class="container">
        <div class="content-wrapper">
            <div class="right-box">
                <img src="<?php the_field('book_image'); ?>" alt="" class="book">
                <h2><?php the_field('s7_title'); ?></h2>
                <p><?php the_field('s7_description'); ?></p>
            </div>
        </div>
    </div>
</section>

<section class="landing">
    <div class="container">
        <div class="content-wrapper">
            <h2><?php the_field('landing_title'); ?></h2>
            <?php the_field('landing_content'); ?>
            <button class="btn btn-blue"><?php the_field('blue_btn'); ?></button>
        </div>
    </div>
</section>
<?php endwhile; ?>

<?php get_footer(); ?>