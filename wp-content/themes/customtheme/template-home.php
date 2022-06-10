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
		<div style="padding:56.25% 0 0 0;position:relative;"><iframe src="https://player.vimeo.com/video/717614886?h=333e31dbab&amp;badge=0&amp;autopause=0&amp;player_id=0&amp;app_id=58479" frameborder="0" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen style="position:absolute;top:0;left:0;width:100%;height:100%;" title="FactBid 1: COVID &amp;amp; AIDS - Lab Leaks? Crowd-funding rewards for whistleblowers!"></iframe></div><script src="https://player.vimeo.com/api/player.js"></script>		
        <!--<iframe allowfullscreen width="100%" height="600" src="https://www.youtube.com/embed/6Y2UO7OOHfA?rel=0&enablejsapi=1"></iframe>-->
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
<p>The lab leak is the US's Tiananmen Square and still <a href="/launch">heavily censored.</a>
Unless a whistleblower comes forward, we'll probably never know, there will be no accountability, and it will keep happening.
You can help stop the pandemic in 60 seconds.  Start with <a href="/1.01">1.01, a reward for the Wuhan lab's missing database</a>.
Sign up with an  email, and make a pledge, or bid, to compensate the whistleblower for the hardship and costs.
It's free, non-profit, open-source.  If our leaders told us the truth, nothing happens.  If they're hiding 
something, your reward may help expose it.  You can then pay the whistleblower directly.  <a href="/about">learn more</a>

The launch video is public domain.  It's on <a href="https://vimeo.com/717614886"><img src="/wp-content/uploads/2022/06/vimeo.png" height="25"/></a> and <a href="https://archive.org/details/factbid1"><img src="/wp-content/uploads/2022/06/InternetArchive.jpg" height="25"/></a>.
All source files and mp4's to mirror or make your own version are <a href="https://drive.google.com/drive/folders/12jowu830StoWdjTzKwccV3oXPAVtC3vb?usp=sharing">here</a>.
</p>

<?php get_template_part( "template-parts/factbid", "filter" ); ?>
 
<?php get_template_part( "template-parts/factbid", "list" ); ?>
     

    </div>
  </div>
</div>

<?php get_footer(); ?>