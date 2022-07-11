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
      <!--<div class="carousel-item active">-->
        <!-- img src="<?php // echo get_stylesheet_directory_uri() .'/assets/images/slider2.png'; ?>" width="100%" height="100%" alt="..."-->
		<!--<div style="padding:56.25% 0 0 0;position:relative;"><iframe src="https://player.vimeo.com/video/717614886?h=333e31dbab&amp;badge=0&amp;autopause=0&amp;player_id=0&amp;app_id=58479" frameborder="0" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen style="position:absolute;top:0;left:0;width:100%;height:100%;" title="FactBid 1: COVID &amp;amp; AIDS - Lab Leaks? Crowd-funding rewards for whistleblowers!"></iframe></div><script src="https://player.vimeo.com/api/player.js"></script>		-->
        <!--<iframe allowfullscreen width="100%" height="600" src="https://www.youtube.com/embed/6Y2UO7OOHfA?rel=0&enablejsapi=1"></iframe>-->
        <!-- div class="carousel-caption-text">
        </div -->
      <!--</div>-->
      
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
<h1>Do you want to uncover the origins of covid?</h1>
<h2>To prevent future pandemics we need to understand where they come from</h2>
<p><b>1.</b> Click sign up and provide an email.  It's free, there's no tracking or collection of personal information.</p>
<p><b>2.</b> Go to <a href="/1.01">FactBid.org/1.01</a>, click 'Bids' and 'Create New Bid' to pledge to support a whistleblower who comes forward with the data about the origins of COVID.  Even the WHO and intelligence agencies concede the data is out there and unless a whistleblower comes forward we will never get to the bottom of the mystery.</p>
<p><b>3.</b> Post your support on social media and include the link in your <a href="/profile">FactBid profile</a> so your pledge has a verified logo, showing a whistleblower you're serious.</p>
<p>That's it.  If a whisteblower courageously risks it all to come forward with the hard evidence to claim FactBid 1.01, you will get an email with the whistleblower's donation instructions.  FactBid never touches the money and is purely an altruistic forum to connect whistleblowers with those who want to support their service.</p>
<p>To learn more about the lab leak theory and how the very same bureaucrats and scientists investigating this lab leak successfully swept under the rug 20 years ago a different lab leak that was much bigger and more obvious see <a href="/1.00">FactBid.org/1.00</a>.</p>

<h1>What is FactBid?</h1>

<p>
Uncovering the origins of covid is just the topic of FactBid #1.  FactBid is an unbiased, truth-finding platform to uncover any type of fact that requires a whistleblower.
Are those in power trying to keep us from finding the truth?  We know powerful elites control much of the press, influence our democracy, and threaten with financial ruin those who dare speak truth to power.
We can’t take the blindfold off of truth or their thumbs off of the scales of justice.  But we can however lift that thumb and loosen that blindfold by pledging to support whistleblowers who risk their livelihood to do the right thing and expose injustice.
</p>
<h1>Would you like to help?</h1>
<p>FactBid is free, open-source, non-commercial and has no ads or tracking or business model.  It is a grassroots effort uncover facts for the public good.  The most important thing you can do is spread the word.  You can also <a href="/contribute">contribute</a> to the platform.</p>
</p>
<!--?php get_template_part( "template-parts/factbid", "filter" ); ?->
<!--?php get_template_part( "template-parts/factbid", "list" ); ?->
     

    </div>
  </div>
</div>

<?php get_footer(); ?>