      </div>
    </div>
    <!-- Footer -->
    <footer class="page-footer font-small indigo">

      <!-- Footer Links -->
      <div class="container text-md-left">

        <!-- Grid row -->
        <div class="row">

          <!-- Grid column -->
          <div class="col-md-3 mx-auto footer-contents">
            <?php if ( is_active_sidebar( 'footer-1' ) ) : ?>
              <?php dynamic_sidebar( 'footer-1' ); ?>
            <?php else : ?>
                <h4>Sidebar is not active</h4>
            <?php endif; ?>

          </div>
          <!-- Grid column -->

          <hr class="clearfix w-100 d-md-none">

          <!-- Grid column -->
          <div class="col-md-3 mx-auto footer-contents">


            <?php if ( is_active_sidebar( 'footer-2' ) ) : ?>
              <?php dynamic_sidebar( 'footer-2' ); ?>
            <?php else : ?>
                <h4>Sidebar is not active</h4>
            <?php endif; ?>

          </div>
          <!-- Grid column -->

          <hr class="clearfix w-100 d-md-none">

          <!-- Grid column -->
          <div class="col-md-3 mx-auto">
          
            <h4>Connect With Us</h4>
            <div class="social-media-icons">
              <a href="https://facebook.com/factbid"><img alt="facebook" src="<?php echo get_stylesheet_directory_uri() .'/assets/images/footer_fb.png'; ?>"></a>
              <a href="https://twitter.com/factbid"><img alt="twitter" src="<?php echo get_stylesheet_directory_uri() .'/assets/images/footer_twitter.png'; ?>"></a>
            </div>
            <div class="footer-email">
              <a href="mailto:info@factbid.org">info@factbid.org</a>
            </div>
          

          </div>
          <!-- Grid column -->

          <hr class="clearfix w-100 d-md-none">
        </div>
      
    </footer>
    <div class="loader">
      <div class="ajax-loader">
        <span></span>
        <span></span>
        <span></span>
        <br>
        <h6>LOADING...</h6>
      </div>
    </div>
    <!-- /Footer -->
    <!-- Footer Links -->
    <?php wp_footer(); ?>
  </body>
</html>