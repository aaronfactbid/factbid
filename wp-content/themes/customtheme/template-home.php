<?php
/**
 * Template Name: Home Page
*/
    get_header();
?>
<!--Slider menus -->
  <div id="carouselExampleIndicators" class="carousel slide " data-bs-ride="carousel">
  <!-- Temporarily disable until we have more than 1 item
    <div class="carousel-indicators">
      <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
      <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
    </div>-->
    <div class="carousel-inner">
	<!-- 
      <div class="carousel-item active">
        <img src="<?php echo get_stylesheet_directory_uri() .'/assets/images/slider1.png'; ?>" width="100%" height="100%"  alt="...">
        div class="carousel-caption-text">
          <p class="text-left">Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
        </div 
      </div>-->
      <div class="carousel-item active">
        <!-- img src="<?php // echo get_stylesheet_directory_uri() .'/assets/images/slider2.png'; ?>" width="100%" height="100%" alt="..."-->
        <iframe allowfullscreen width="100%" height="600" src="https://www.youtube.com/embed/6Y2UO7OOHfA?rel=0&enablejsapi=1"></iframe>
        <!-- div class="carousel-caption-text">
        </div -->
      </div>
      
    </div>
	<!--  temporarily disable the buttons until we have more than 1 item to show
    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
      <span class="carousel-control-prev-icon" aria-hidden="true"></span>
      <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
      <span class="carousel-control-next-icon" aria-hidden="true"></span>
      <span class="visually-hidden">Next</span>
    </button>
	-->
  </div>
  <div class="button-container floating-button">
    
    <?php echo show_create_factbid_button(); ?>
  </div>
<!-- menus -->
<p>Within hours of posting this video on YouTube, Google suspended the account <a href="/launch">(read more)</a>.
It has been reposted, and now is mirrored on <a href="https://vimeo.com/717614886"><img src="/wp-content/uploads/2022/06/vimeo.png" height="25"/></a> and <a href="https://archive.org/details/factbid1"><img src="/wp-content/uploads/2022/06/InternetArchive.jpg" height="25"/></a>.
The video is public domain. Download and mirror the mp4, or get a 40GB zip all the source files (Premiere, etc.) from <a href="https://drive.proton.me/urls/32BCFJ3628#awmpIMVsPudh"><img src="/wp-content/uploads/2022/06/Proton-Drive.png" height="25"/></a>.  Feel free to make your own version of the video, especially a shorter version for a younger audience.
</p>

<?php get_template_part( "template-parts/factbid", "filter" ); ?>
 
<?php get_template_part( "template-parts/factbid", "list" ); ?>
     

    </div>
  </div>
</div>

<?php get_footer(); ?>