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

    $res = $wpdb->get_results($wpdb->prepare("SELECT nobid, thumbs_up,thumbs_down,id_factbid_parent,id_factbid,type,status,language,visibility,topics FROM ct_factbid WHERE post_id = %d",$post_id));
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

                  $fb_types = $res[0]->type;
                  $fb_type = "";
                  $type_options = get_option("fact_bid_type", true);
                  foreach($type_options as $key => $type_option){
                    if($fb_types == $key){
                      $fb_type = $type_option;
                    }
                  }
                  $fb_stat = $res[0]->status;
                  $status_options = get_option("fact_bid_status", true);
                  foreach($status_options as $key => $status_option){
                    if($fb_stat == $key){
                      $fb_status = $status_option;
                    }
                  }
                  $fb_topics = $res[0]->topics;
                  $fb_topic = "";
                  $topics_options = get_option("fact_bid_topics", true);
                  foreach($topics_options as $key => $topics_option){
                    if($fb_topics == $key){
                      $fb_topic = $topics_option;
                    }
                  }
                  
                  $meta_data = $fb_type . ' - ' . $fb_status . ' - ' . $fb_topic;

                  if($visibilty != 1){
                    $author_name = 'user';
                  }
                echo '<div class="meta-content">'.$res[0]->id_factbid.' <small>'.$date. ' - ' . show_verified($author) . $author_name . ' </small>
					'.display_rating($author). ' ' .$meta_data. '</div>';
                echo '<div class="meta-content">Bids: ' . $total_bids . ' bids totalling $' . $total_bid_amount . ' <a href="view_bids">view bids</a> ';
				if (is_user_logged_in()) {
					echo ' Add my bid: <input type="text" id="name" name="name" size="7"> <input type="submit" value="add bid">';
				}
				else {
					  echo '<a href="/sign-in">Login/signup to add a bid</a>';
				}
				echo '</div>';
                echo '<div class="meta-content">Claims: ';
				if( $total_claims > 0 ) {
					echo $total_claims;
				}
				echo ' <a href="view_claims">view claims</a> ';
				if (is_user_logged_in()) {
					echo '<a href="view_claims">claim this</a>';
				}
				else {
					  echo '<a href="/sign-in">Login/signup to claim this</a>';
				}
				echo '</div>';
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

	<?php include( get_template_directory() . '/tabs-templates/about-template.php' ); ?>

<?php
    endwhile;
endif;
?>

<?php get_footer(); ?>