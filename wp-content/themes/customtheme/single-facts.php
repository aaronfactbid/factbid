<?php 
  get_header(); 
?>
<?php if (have_posts()):
        while(have_posts()):
            the_post();
            global $wpdb;
            $user_id = get_current_user_id();
   
    $post_id = get_the_id();
    $wpdb->query($wpdb->prepare("UPDATE ct_factbid SET view_count=view_count+1 WHERE post_id=%d",$post_id));

    $res = $wpdb->get_results($wpdb->prepare("SELECT nobid, thumbs_up,thumbs_down,id_factbid_parent,id_factbid,status,visibility FROM ct_factbid WHERE post_id = %d",$post_id));
    $tab_class="";
    $tab_status=1;
    $status_code = (int)trim($res[0]->status);
    if($status_code != 5){
      $tab_class='disabled';
      $tab_status = 0;
    }
    $visibilty = $res[0]->visibility;

?>
<?php 
    if($res[0]->id_factbid_parent == 0 || $res[0]->id_factbid_parent == ''){
            $factbid_id = $res[0]->id_factbid;
    } else {
            $factbid_id = $res[0]->id_factbid_parent;
    }
    $bid_data = $wpdb->get_results( 
        $wpdb->prepare(
            "SELECT * FROM ct_bid WHERE id_factbid = %f AND id_bid_next IS NULL",
            $res[0]->id_factbid
        )
    );
    $total_bids = count($bid_data);
    $total_bid_amount = 0;
    foreach($bid_data as $bid){
      $total_bid_amount += $bid->amount;
    }
    $claims_data = $wpdb->get_results( 
      $wpdb->prepare(
          "SELECT * FROM ct_claim WHERE id_factbid = %f",
          $res[0]->id_factbid
      )
    );
    $total_claims = count($claims_data);
    
  ?>
<!-- About area -->
  <div class="title-bar about-facts-header show">
      <div class="container">
        <div class="middled-block">
          <h1 class="title_left"><?php the_title(); ?></h1>
            <div class="like_unlike">
                <?php if($user_id !=0 || $user_id !=""){ ?>
                  <?php get_template_part( "popups/report", "popup", array('factbid_id'=> $res[0]->id_factbid, 'factbid_post_id'=> $post_id) ); ?>
                  <span class="like_b" data-id="<?php the_id(); ?>" data-user="<?php echo $user_id;?>"><?php echo $res[0]->thumbs_up?></span>
                  <span class="unlike_b" data-id="<?php the_id(); ?>" data-user="<?php echo $user_id;?>"><?php echo $res[0]->thumbs_down?></span>
                  <a class="report_b" href="#" data-bs-toggle="modal" data-bs-target="#reportModal">Report</a>
                <?php } else {?>
                  
                  <span class="like_b" data-id="<?php the_id(); ?>" data-user="<?php echo $user_id;?>" data-bs-toggle="modal" data-bs-target="#reportModalerror"><?php echo $res[0]->thumbs_up?></span>
                  <span class="unlike_b" data-id="<?php the_id(); ?>" data-user="<?php echo $user_id;?>" data-bs-toggle="modal" data-bs-target="#reportModalerror"><?php echo $res[0]->thumbs_down?></span>
                  <a class="report_b" href="#" data-bs-toggle="modal" data-bs-target="#reportModalerror">Report</a>
                  <?php get_template_part( "popups/report", "popuperror" ); ?>
                <?php } ?>
            </div>
            <?php
                  $author = get_the_author_ID();
                  $date = get_the_date('d-M-Y', $post_id);
                  $author_name = factbid_get_author_link($author);

                  if($visibilty != 1){
                    $author_name = 'user';
                  }
                  echo '<div class="meta-content"><p><small>'.$date. ' - ' . $author_name . ' </small></p>
                '.display_rating($author).'</div>';
                ?>
            <div class="edit_post_links">
              <?php if (is_user_logged_in() && ($user_id == $post->post_author || current_user_can('administrator'))) { ?>
              <a href="<?php echo esc_url(home_url('/edit-factbid?id=')) . $res[0]->id_factbid; ?>" class="btn edit-factbid">Edit</a>
              <?php  if($res[0]->status != 5):
              ?>
              <a href="#" class="btn post-factbid" data-id="<?php echo $res[0]->id_factbid; ?>">Post</a>
              <?php
              else:
              ?>
              <span class="btn post-factbid">Posted</span>
              <?php 
              endif; ?>
              <?php } if (is_user_logged_in() && current_user_can('administrator')) { ?>
              
              <?php } ?>
              <a href="<?php echo esc_url(home_url('/create-factbid?parent=')) . $factbid_id; ?>" class="btn create-child-factbid">Create Related Factbid</a>
            </div>
        </div>
      </div>
    </div>
   
    <!-- other header area -->
    <div class="othertabs-facts-header d-none">
      <div class="container">
        <div class="middled-block">
            <h1>Fact Bid</h1>
            <div class="edit_post_links">
              <a href="<?php echo esc_url(home_url('/edit-factbid?id=')) . $res[0]->id_factbid; ?>" class="btn edit-factbid">Edit</a>
              <a href="#" class="btn post-factbid" data-id="<?php echo $res[0]->id_factbid; ?>">Post</a>
              <a href="<?php echo esc_url(home_url('/create-factbid?parent=')) . $factbid_id; ?>" class="btn create-child-factbid">Create Related Factbid</a>
            </div>
        </div>
      </div>
    </div>


  <div class="about-page-vew">
    <ul class="nav nav-tabs" id="myTab" role="tablist">
      <li class="nav-item" role="presentation">
        <a class="nav-link active" id="about-tab" data-bs-toggle="tab" href="#about" role="tab" aria-controls="about" aria-selected="true">About</a>
      </li>
      <li class="nav-item <?php echo $tab_class; ?>" role="presentation">
        <a class="nav-link" id="discuss-tab" <?php if($tab_status) { ?>data-bs-toggle="tab"<?php } ?> href="#discuss" role="tab" aria-controls="discuss" aria-selected="false">Discuss</a>
      </li>
      <li class="nav-item <?php echo $tab_class; ?>" role="presentation">
        <a class="nav-link" id="bids-tab" <?php if($tab_status) { ?>data-bs-toggle="tab"<?php } ?> href="#bids" role="tab" aria-controls="bids" aria-selected="false">Bids</a>
      </li>
      <li class="nav-item <?php echo $tab_class; ?>" role="presentation">
        <a class="nav-link" id="claims-tab" <?php if($tab_status) { ?>data-bs-toggle="tab"<?php } ?> href="#claims" role="tab" aria-controls="claims" aria-selected="false">Claims</a>
      </li>
      <li class="nav-item <?php echo $tab_class; ?>" role="presentation">
        <a class="nav-link" id="related-tab" <?php if($tab_status) { ?>data-bs-toggle="tab"<?php } ?> href="#related" role="tab" aria-controls="related" aria-selected="false">Related</a>
      </li>
    </ul>
    <div class="tab-content container" id="myTabContent">
      
        <div class="tab-pane fade show active container" id="about" role="tabpanel" aria-labelledby="about-tab">
          <?php include( get_template_directory() . '/tabs-templates/about-template.php' ); ?>
        </div>

        <div class="tab-pane container fade" id="discuss" role="tabpanel" aria-labelledby="discuss-tab">
          <?php include( get_template_directory() . '/tabs-templates/discuss-template.php' ); ?>
        </div>

        <div class="tab-pane container fade" id="bids" role="tabpanel" aria-labelledby="bids-tab">
          <?php include( get_template_directory() . '/tabs-templates/bids-template.php' ); ?>
        </div>
        
        <div class="tab-pane container fade" id="claims" role="tabpanel" aria-labelledby="claims-tab">
          <?php include( get_template_directory() . '/tabs-templates/claims-template.php' ); ?>
        </div>

        <div class="tab-pane container fade" id="related" role="tabpanel" aria-labelledby="related-tab">
          <?php include( get_template_directory() . '/tabs-templates/related-template.php' ); ?>
        </div>
      
    </div>
  </div>

<?php
    endwhile;
endif;
?>

<?php get_footer(); ?>