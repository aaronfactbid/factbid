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
<h1>What is FactBid?</h1>

<p>
FactBid is the 21st century answer to the question: what is the truth?
Are those in power trying to keep it from me and how can I get the answers still?
FactBid uses a simple, intuitive system to crowd fund the truth.
To offer potential whistle blowers crowd sourced rewards to answer simple questions,
provide evidence and to be able to avoid the financial risks associated with speaking truth to power.
More and more wealthy and powerful elites control both the presses,
influences our democracy and threaten others with financial ruin.
We at FactBid believe we can’t take the blindfold off of truth or their thumbs off of the scales of justice. We can however lift that thumb and loosen that blindfold.
</p>
<h1>Would you like to help us?</h1>
<p>
Let's try out FactBid by crowd sourcing the origins of COVID.  It's been reported that most people believe the
Wuhan Lab had something to do with the pandemic.  Government officials concede that is a possiblity. The <a href="https://www.france24.com/en/live-news/20220609-covid-lab-leak-theory-needs-more-research-who-advisors">WHO said</a> it is important "to evaluate the possibility [COVID came from] a laboratory incident".
Yet <a href="https://unherd.com/2022/06/what-happened-to-the-lab-leak-hypothesis/">scientists report</a> "the topic remains taboo in much of the mainstream media" and mainstream scientific organizations have said "it’s not a proper topic for scientific discussion."
The lab leak is the new Tiananmen Square.  Even the Wuhan Lab's formerly-public database of their research experiments
has mysteriously disappeared and is being withheld from the scientists who need it to investigate the <a href="https://twitter.com/hashtag/OriginsOfCOVID">Origins of COVID</a>.
Unless a whistleblower comes forward, 
we'll probably never know what happened. Without that, there will be no accountability, and it will keep happening.
You can help stop the next pandemic in 60 seconds.  Visit <a href="/1.01">FactBid.org/1.01: a reward for the Wuhan lab's missing database</a>.
Sign up with an email, and make a pledge, or bid, to compensate the whistleblower for the hardship and costs.
Then share on your social media and copy the link in your <a href="/profile">profile</a> so your bid shows up as verified
It's free, non-profit, open-source.  If our leaders told us everything, nothing happens.  If they're hiding 
something, your reward may help expose it.  If a whistleblower posts the data and claims the reward,
all the bidders will get an email with the whisteblower's payment instructions.  If you are satisfied, 
you can then pay the whistleblower directly.  It’s an honor system and there’s no ulterior motive.
FactBid doesn’t have ads, or revenue, or use your personal data.  It’s just a free forum for us to crowd fund rewards for whistleblowers to show them we appreciate their service. 
</p>
<?php get_template_part( "template-parts/factbid", "filter" ); ?>
 
<?php get_template_part( "template-parts/factbid", "list" ); ?>
     

    </div>
  </div>
</div>

<?php get_footer(); ?>