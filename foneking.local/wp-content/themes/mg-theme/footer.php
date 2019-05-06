      </main>
      <footer class="main-footer">
        <div class="main-footer__top-row">
          <div class="top-row__inner">
            <div class="main-footer__text text bold">Have a Question? <a class="main-footer__link text bold" id="faq-triger" href="#">See our FAQs</a></div>
          </div>
          <?php if( have_rows('faqs') ): ?>
          <div class="top-row__faq-lay">
            <ul class="faq-list">
              <?php while ( have_rows('faqs') ) : the_row(); ?>
               <li class="faq-item">
	              <h6 class="faq-quest text bold"><?php the_sub_field('title'); ?></h6>
	              <div class="faq-answer"><p class="text"><?php the_sub_field('text'); ?></p></div>
	             </li>
              <?php endwhile; ?>
            </ul>
          </div>
          <?php endif; ?>
        </div>
        <div class="main-footer__bottom-row">
          <p class="main-footer__disclamer text">This product is not intended to diagnose, treat, cure, or prevent any disease or health condition. The information provided herein should not be considered as a substitute for the advice of a medical doctor or other healthcare professional. As each individual is different, results may vary.</p>
          <nav class="main-footer__main-nav">
            <ul class="main-footer__main-nav-list">
              <li class="main-footer__main-nav-item"><a class="main-footer__main-nav-link text modal-triger" href="#support">Support</a></li>
              <li class="main-footer__main-nav-item"> <a class="main-footer__main-nav-link text modal-triger" href="#returns">Returns</a></li>
              <li class="main-footer__main-nav-item"><a class="main-footer__main-nav-link text modal-triger" href="#privacy">Privacy</a></li>
              <li class="main-footer__main-nav-item"><a class="main-footer__main-nav-link text modal-triger" href="#terms">Terms</a></li>
            </ul>
          </nav>
        </div>
      </footer>
      <template id="support">
        <div class="modal-content">
          <?php the_field('support_content'); ?>
        </div>
      </template>
      <template id="returns">
        <div class="modal-content">
          <?php the_field('return_content'); ?>
        </div>
      </template>
      <template id="privacy">
        <div class="modal-content">
          <?php the_field('privacy_content'); ?>
        </div>
      </template>
      <template id="terms">
        <div class="modal-content">
          <?php the_field('terms_content'); ?>
        </div>
      </template>
    </div> <!-- #END wrapper -->
    <script>
      var getUrl = window.location;
      var baseUrl = getUrl.protocol + "//" + getUrl.host + "/" + getUrl.pathname.split('/')[1];
    </script>
    <script src="https://www.paypalobjects.com/api/checkout.js"></script>
    <script src="<?php echo get_template_directory_uri(); ?>/js/main.js'"></script>
    <script src="<?php echo get_template_directory_uri(); ?>/scripts.js'"></script>
    <?php wp_footer(); ?>

    <!-- LiveChat -->
    <script type="text/javascript">
    window.__lc = window.__lc || {};
    window.__lc.license = 10706777;
    (function() {
      var lc = document.createElement('script'); lc.type = 'text/javascript'; lc.async = true;
      lc.src = ('https:' == document.location.protocol ? 'https://' : 'http://') + 'cdn.livechatinc.com/tracking.js';
      var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(lc, s);
    })();
    </script>
    <!-- END LiveChat -->

  </body>
</html>