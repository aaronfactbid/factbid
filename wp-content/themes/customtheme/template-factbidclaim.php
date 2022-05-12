<?php 
/**
 * Template Name: FactBid Claim
*/

get_header(); ?>

  <div class="about-page-vew">
    <ul class="nav nav-tabs" id="myTab" role="tablist">
      <li class="nav-item" role="presentation">
        <a class="nav-link active" id="claim-about-tab" data-bs-toggle="tab" href="#claim-about" role="tab" aria-controls="claim-about" aria-selected="true">About</a>
      </li>
      <li class="nav-item" role="presentation">
        <a class="nav-link" id="claim-discuss-tab" data-bs-toggle="tab" href="#claim-discuss" role="tab" aria-controls="claim-discuss" aria-selected="false">Discuss</a>
      </li>
      <li class="nav-item" role="presentation">
        <a class="nav-link" id="claim-response-tab" data-bs-toggle="tab" href="#claim-response" role="tab" aria-controls="response" aria-selected="false">Response</a>
      </li>
      
    </ul>
    <div class="tab-content container" id="myTabContent">
      
      <div class="tab-pane fade show active container" id="claim-about" role="tabpanel" aria-labelledby="claim-about-tab">
        <?php include( get_template_directory() . '/tabs-templates/claim-about-template.php' ); ?>
      </div>

      <div class="tab-pane container fade" id="claim-discuss" role="tabpanel" aria-labelledby="claim-discuss-tab">
        <?php include( get_template_directory() . '/tabs-templates/claim-discuss-template.php' ); ?>
      </div>

      <div class="tab-pane container fade" id="response" role="tabpanel" aria-labelledby="claim-response-tab">
        <?php include( get_template_directory() . '/tabs-templates/claim-response-template.php' ); ?>
      </div>
      

    </div>
  </div>


<?php get_footer(); ?>