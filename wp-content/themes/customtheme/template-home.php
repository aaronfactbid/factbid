<?php
	if (isset($_GET['referral'])) {
		setcookie('referral', $_GET['referral'], 0, "/");
	}
?>

<?php
/**
 * Template Name: Home Page
*/
    get_header();
?>

<div id="whatIsFactbid">
<p>Every <a href="/browse">FactBid</a> is a quest to uncover a particular fact of public interest that can only be revealed if a whistleblower risks it all to come forward.
It would be selfish and unrealistic for us to expect somebody else to be a martyr for our benefit, if we're not willing to support them.
So FactBid is a free, public forum to bring together whistleblowers with those who are willing to have their back.
Any support occurs directly between the whistleblower and the supporters.  FactBid is non-commercial and never intermediates or touches any money.
<a href="/how">How it works</a>
</div>

<div id="promotion">
<p><h1>Weekly $300 giveaway + $1,000 for the most referrals</h1></p>
<p>Every Monday RandomPicker.com will award $300 to someone who posted on social media their support of whistleblowers.  On February 6, 2023, whoever referred the most will receive $1,000. <a href="/reward">details</a>.
</div>

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

<p>Featured factbids</p>
<?php get_template_part( "template-parts/factbid", "list" ); ?>
<p><a href="/browse">Browse</a> all FactBid's</p>     

    </div>
  </div>
</div>

<?php get_footer(); ?>