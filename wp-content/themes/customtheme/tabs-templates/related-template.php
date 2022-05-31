<div id="cards_landscape_wrap-1" class="card-related">
  <div class="container">
    <div class="row">
        <?php
                $related_results = $wpdb->get_results(
                        $wpdb->prepare("SELECT 
                        bids_count,
                        bids_total,
                        bids_paid,
                        claims_total,
                        view_count,
                        comment_count,
                        thumbs_up,
                        thumbs_down,
                        id_factbid_parent,
                        id_factbid,
                        country,
                        status,
                        post_id 
                        FROM ct_factbid 
                        WHERE id_factbid_parent = %d",$factbid_id
                ));
        ?>

        <?php 
                if(!empty($related_results)):
                foreach($related_results as $related_result):
                        if($related_result->id_factbid_parent == 0 || $related_result->id_factbid_parent == ''){
                                $factbid_id_inloop = $related_result->id_factbid;
                        } else {
                                $factbid_id_inloop = $related_result->id_factbid_parent;
                        }

                        $parent_post_id = $related_result->id_factbid_parent;
                        
                        if($parent_post_id !=0 || $parent_post_id != "0"){
                                $parent_post_data = $wpdb->get_results(
                                        $wpdb->prepare("SELECT post_id FROM ct_factbid WHERE id_factbid=%f",$parent_post_id));
                                $title_parent = get_the_title($parent_post_data[0]->post_id);
                        } else {
                                $title_parent = "No Parent Found";
                        }
                        $related_posts = get_post($related_result->post_id);
                        $post_image = wp_get_attachment_url( get_post_thumbnail_id($related_result->post_id), 'thumbnail' );
                        if($post_image){
                                $post_image = $post_image;
                        } else {
                                $post_image = catch_that_image($related_result->post_id);
                        }
                        if($related_result->claims_total != 0){
                                $claimed = "Claimed";
                        }
                        else{
                                $claimed = "Unclaimed";  
                        }
                        $content = get_the_excerpt($related_result->post_id);
                        $title = get_the_title($related_result->post_id);
                        $link = get_permalink($related_result->post_id);

                        $author_id=$related_posts->post_author;
        ?>
        <div class="col-sm-4">
                <div class="card-flyer">
                        <div class="text-box">
                                <div class="card card-text-bottom card-gradient-bottom card-inverse text-bottom">
                                <a href="<?=$link?>"><img class="card-img-top"  src="<?php echo $post_image; ?>" alt="" /></a>
                                        <div class="card-image-overlay">
                                                <span class="card-title"><?php echo $claimed; ?></span>
                                        </div>
                                </div>
                                <div class="text-container">
                                        <div class="body-section">
                                                <small><a href="#"> Parent Bid: <?php echo $title_parent; ?> </a></small>
                                                <h6><?php echo $title; ?></h6>
                                                <div class="meta-content"><p><small><?php echo get_the_date( 'd-M-Y', $related_result->post_id ); ?> - <?php echo show_verified($author_id) . get_the_author_meta( 'user_nicename' , $author_id ); ?> </small></p>
                                                        <?php echo display_rating($author_id); ?>
                                                </div>
                                                <div class="related-sm-btn">
                                                        <span> <a href="<?php echo esc_url(home_url('/edit-factbid?id=')) . $related_result->id_factbid; ?>" class="btn btn-sm btn-related-edit">Edit</a> </span>
                                                        <span> <a href="<?php echo esc_url(home_url('/create-factbid?parent=')) . $factbid_id_inloop; ?>" class="btn btn-sm btn-related-child">New child FactBid</a> </span>
                                                </div>
                                                <div class="card-sub-cnt">
                                                        <?php
                                                                $countries = $wpdb->get_results($wpdb->prepare("SELECT name FROM ct_countries WHERE iso=%s", $related_result->country));
                                                                
                                                        ?>
                                                        <p> 
                                                                <span> <strong> Country/Region: </strong> </span> 
                                                                <?php
                                                                        foreach($countries as $country){
                                                                ?>
                                                                <span> <?php echo $country->name; ?>  </span>
                                                                <?php } ?>
                                                        </p>
                                                        <p> <span> <strong>User:  </span></strong> <span> Lorem ipsum, Lorem, Ipsum, Lorem Ipsum,Lorem Ipsum  </span></p>
                                                </div>

                                                <p><?php echo $content; ?></p>
                                        </div>
                                        <div class="related_count">
                                                <div class="row">
                                                        <div class="col"><strong>Bids:<?php echo $related_result->bids_count; ?><span>$</span><?php echo $related_result->bids_total; ?></strong></div>
                                                        <div class="col"><strong>Claims:<?php echo $related_result->claims_total; ?></strong></div>
                                                        <div class="col"><strong>Payments:<?php echo $related_result->bids_paid; ?></strong></div>
                                                </div>
                                        </div>
                                </div>
                                <div class="bottom-content">
                                        <span class="block_view_count"> (<?php echo $related_result->view_count; ?>)</span>
                                        <span class="block_accept_count"> <?php echo (int)$related_result->thumbs_up/1000; ?>k</span>
                                        <span class="block_reject_count"> <?php echo (int)$related_result->thumbs_down/1000; ?>k</span>
                                        <span class="content-right block_response_count"> <?php echo $related_result->comment_count; ?></span>
                                </div>
                        </div>
                </div>
        </div>
        <?php
                
                endforeach;
                endif;
        ?>

     </div>
   </div>
</div>