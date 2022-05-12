<!-- Topic Cards -->
<div id="cards_landscape_wrap-2">
  <div class="container">
    <div class="row" id="append-html">
      <?php
        global $wpdb;
        if(isset($_GET['search2']) && $_GET['search2'] != ''){
          $tablename = $wpdb->prefix.'posts';
          $sql1 = "SELECT ID FROM ".$tablename." WHERE post_content LIKE '%".$_GET['search2']."%' OR post_title LIKE '%".$_GET['search2']."%'";
          $results1 = $wpdb->get_results($sql1);
          $post_ids1 = array();
          foreach($results1 as $result1){
              array_push($post_ids1, $result1->ID);
          }
          $post_ids = "(" . implode(",", $post_ids1) . ")";
          $sql2 = "SELECT id_factbid,post_id,bids_count,bids_total,bids_paid,claims_total,view_count,thumbs_up,thumbs_down,comment_count FROM ct_factbid WHERE post_id IN ".$post_ids." AND status=5";
          $results = $wpdb->get_results($sql2);
          
        }
        else{
            
                query_posts(array( 
                'post_type' => 'facts',
                'showposts' => 10,
                'orderby' => 'date', 
                'order' => 'DESC',
                ) );
          
            
          $post_ids2 = [];
          if (have_posts() ){
            while(have_posts()){
                the_post();
                $post_id = get_the_ID();
                array_push($post_ids2, $post_id);
                
            }
          } 
          if(!empty($post_ids2)){
            $post_ids = "(" . implode(",", $post_ids2) . ")";
            $sql3 = "SELECT id_factbid,post_id,bids_count,bids_total,bids_paid,claims_total,view_count,thumbs_up,thumbs_down,comment_count,visibility FROM ct_factbid WHERE post_id IN ".$post_ids." AND status=5";
            $results = $wpdb->get_results($sql3); 
          }
            
        }
        $html = '';
        if(!empty($results)){
          foreach($results as $result){

              $post_image = wp_get_attachment_url( get_post_thumbnail_id($result->post_id), 'thumbnail' );
              if($post_image){
                $post_image = $post_image;
              } else {
                $post_image = catch_that_image($result->post_id);
              }
              if($result->claims_total != 0){
                $claimed = "Claimed";
              }
              else{
                $claimed = "Unclaimed";  
              }
              $post = get_post($result->post_id);
              $content = get_the_excerpt($result->post_id);
              $title = get_the_title($result->post_id);
              $link = get_permalink($result->post_id);
              $author = $post->post_author;
              $date = get_the_date('d-M-Y', $result->post_id);
              $author_name = factbid_get_author_link($author);
              if($result->visibility != 1){
                    $author_name = 'user';
              }
            // $bids_count = $result->bids_count;
            // $bids_total = $result->bids_total;
            // $claims_total = $result->claims_total;
            // $bids_paid = $result->bids_paid;

            $bc = get_bid_count($result->id_factbid);
            $bids_count = $bc['bid_count'];
            $bids_total = $bc['bid_amount'];
            $claims_total = get_claims_count($result->id_factbid);
            $bids_paid = $result->bids_paid;



              $html .= '<div class="col-sm-4">
          <div class="card-flyer">
            <div class="text-box">
              <div class="card card-text-bottom card-gradient-bottom card-inverse text-bottom">
                <a href="'.$link.'"><img class="card-img-top"  src="'.$post_image.'" alt="" /></a>
                <div class="card-image-overlay">
                  <span class="card-title">'.$claimed.'</span>
                </div>
              </div>
              <div class="text-container">
                <h6><a href="'.$link.'">'.$title.'</a></h6>
                <div class="meta-content"><p><small>'.$date. ' - ' . $author_name . ' </small></p>
                '.display_rating($author).'</div>
                <p class="w3-opacity">'.$content.'</p>
              </div>
              <div class="bid_count">
                <div class="row">
                  <div class="col-4"><strong>Bids:'.$bids_count.'<span>&nbsp;$</span>'.$bids_total.'</strong></div>
                  <div class="col-3"><strong>Claims:'.$claims_total.'</strong></div>
                  <div class="col-4 ms-auto text-end"><strong>Payments:'.$bids_paid.'</strong></div>
                </div>
              </div>
              <div class="bottom-content">
                <span class="block_view_count"> '.$result->view_count.'</span>
                <span class="block_accept_count"> '.$result->thumbs_up.'</span>
                <span class="block_reject_count"> '.$result->thumbs_down.'</span>
                <span class="content-right block_response_count"> '.$result->comment_count.'</span>
              </div>
            </div>
          </div>
        </div>';
        }
       } 
          echo $html;
?>  