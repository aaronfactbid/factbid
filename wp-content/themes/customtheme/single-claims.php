<?php
  get_header(); 
?>

<?php
  if (have_posts()):
    while(have_posts()):
      the_post();
      global $wpdb;
      $user_id = get_current_user_id();

    $post_id = get_the_id();
    $res = $wpdb->get_results($wpdb->prepare("SELECT * FROM ct_claim WHERE post_id=%d",$post_id));
    $tab_class="";
    $tab_status=1;
    $status_code = trim($res[0]->status);
    if($status_code != "Completed"){
      $tab_class='disabled';
      $tab_status = 0;
    }
     if(!empty($claim_num)){$total_claims =count($claim_num);}
    $claim_factbid = $wpdb->get_results($wpdb->prepare("SELECT * FROM ct_factbid WHERE id_factbid=%d",$res[0]->id_factbid));

?>
    <div class="single-page-claim">
      <div class="container">
        <div class="middled-block">
          <h1 class="title_left"><?php the_title(); ?> to the FactBid <?php echo $res[0]->id_factbid; ?> <a href="<?php echo get_the_permalink($claim_factbid[0]->post_id); ?>"> <?php echo $claim_factbid[0]->title; ?></a></h1>
          <!-- About header and Discuss-->
          <div id="about-header-area" class="show">
            <div class="like_unlike">
                <?php if($user_id !=0 || $user_id !=""){ ?>
                  <span class="claim_like_b" data-id="<?php the_id() ?>" data-user="<?php echo $user_id;?>"><?php echo $res[0]->thumbs_up?></span>
                  <span class="claim_unlike_b" data-id="<?php the_id() ?>" data-user="<?php echo $user_id;?>"><?php echo $res[0]->thumbs_down?></span>
                <?php } else {?>
                  <span class="claim_like_b" data-id="<?php the_id() ?>" data-user="<?php echo $user_id;?>" data-bs-toggle="modal" data-bs-target="#reportModalerror"><?php echo $res[0]->thumbs_up?></span>
                  <span class="claim_unlike_b" data-id="<?php the_id() ?>" data-user="<?php echo $user_id;?>" data-bs-toggle="modal" data-bs-target="#reportModalerror"><?php echo $res[0]->thumbs_down?></span>
                  <?php get_template_part( "popups/report", "popuperror" ); ?>
                <?php } ?>
                
            </div>
            <div class="edit_post_links">
              <?php if (is_user_logged_in() && ($user_id == $post->post_author || current_user_can('administrator'))) { ?>
              <a href="<?php echo esc_url(home_url('/edit-claim?id=')) . $post_id . '&factbid_id='. $res[0]->id_factbid; ?>" class="btn edit-claim">Edit</a>
              
              <?php 
              if($res[0]->status != "Completed"):
              ?>
              <a href="#" class="btn post-claim" data-id="<?php echo $res[0]->id_claim; ?>">Post</a>
              <?php
                else:
              ?>
              <span class="btn post-claim">Posted</span>
              <?php 
              endif; ?>
              
              <?php } if (is_user_logged_in() && current_user_can('administrator')) { ?>
              
              <?php } ?>
            </div>
          </div>
        </div>

      </div>
  </div>


  <div class="about-page-vew">
    <ul class="nav nav-tabs" id="myTab" role="tablist">
      <li class="nav-item" role="presentation">
        <a class="nav-link active" id="claim-about-tab" data-bs-toggle="tab" href="#claim-about" role="tab" aria-controls="claim-about" aria-selected="true">About</a>
      </li>
      <li class="nav-item <?php echo $tab_class; ?>" role="presentation">
        <a class="nav-link" id="claim-discuss-tab" <?php if($tab_status) { ?>data-bs-toggle="tab"<?php } ?> href="#claim-discuss" role="tab" aria-controls="claim-discuss" aria-selected="false">Discuss</a>
      </li>
      <li class="nav-item <?php echo $tab_class; ?>" role="presentation">
        <a class="nav-link" id="claim-response-tab" <?php if($tab_status) { ?>data-bs-toggle="tab"<?php } ?> href="#claim-response" role="tab" aria-controls="claim-response" aria-selected="false">Response</a>
      </li>
      
    </ul>
    <div class="tab-content container" id="myTabContent">
      
      <div class="tab-pane fade show active container" id="claim-about" role="tabpanel" aria-labelledby="claim-about-tab">
        <?php include( get_template_directory() . '/tabs-templates/claim-about-template.php' ); ?>
      </div>

      <div class="tab-pane container fade" id="claim-discuss" role="tabpanel" aria-labelledby="claim-discuss-tab">
        <?php include( get_template_directory() . '/tabs-templates/claim-discuss-template.php' ); ?>
      </div>

      <div class="tab-pane container fade" id="claim-response" role="tabpanel" aria-labelledby="claim-response-tab">
        <?php include( get_template_directory() . '/tabs-templates/claim-response-template.php' ); ?>
      </div>
      

    </div>
  </div>
  <?php
    endwhile;
endif;
?>

<?php get_footer(); ?>