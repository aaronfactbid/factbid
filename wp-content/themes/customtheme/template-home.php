<?php
/**
 * Template Name: Home Page
*/
    get_header();
?>
<!--Slider menus -->
  <div id="carouselExampleIndicators" class="carousel slide " data-bs-ride="carousel">
    <div class="carousel-indicators">
      <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
      <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
      </div>
    <div class="carousel-inner">
      <div class="carousel-item active">
        <img src="<?php echo get_stylesheet_directory_uri() .'/assets/images/slider1.png'; ?>" width="100%" height="100%"  alt="...">
        <div class="carousel-caption-text">
          <p class="text-left"></p>
        </div>
      </div>
      <div class="carousel-item">
        <img src="<?php echo get_stylesheet_directory_uri() .'/assets/images/slider1.png'; ?>" width="100%" height="100%" alt="...">
        <div class="carousel-caption-text">
          <p class="text-left"></p>
        </div>
      </div>
      
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
      <span class="carousel-control-prev-icon" aria-hidden="true"></span>
      <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
      <span class="carousel-control-next-icon" aria-hidden="true"></span>
      <span class="visually-hidden">Next</span>
    </button>
  </div>
  <div class="button-container floating-button">
    
    <?php echo show_create_factbid_button(); ?>
  </div>
<!-- menus -->

<?php get_template_part( "template-parts/factbid", "filter" ); ?>
 
<?php get_template_part( "template-parts/factbid", "list" ); ?>
     

    </div>
  </div>
</div>

<?php get_footer(); ?>