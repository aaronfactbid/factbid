<div class="bid-data-body">
        <?php
                if($res[0]->nobid != 1 || $res[0]->nobid != "1"){
        ?>
        <span class="sub-cont"> <strong>Bids: <?php echo $total_bids; ?>  </strong> </span>
        <span class="sub-cont"> <strong> Total: $<?php echo $total_bid_amount; ?> </strong> </span>
        
        <!-- Button trigger modal -->
        <button type="button" class="btn crate-bit" data-bs-toggle="modal" data-bs-target="#bidModal">
        Create New Bid
        </button>
        <?php
                }
        ?>
</div>

<!-- Modal -->
<div class="modal fade" id="bidModal" tabindex="-1" aria-labelledby="bidModalLabel" aria-hidden="true">
        <div class="modal-dialog">
                <div class="modal-content container">
                        <div class="modal-header">
                                <h5 class="modal-title" id="bidModalLabel">Add my bid</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                
                
                                <div class="form-check">
                                        <input class="form-check-input" type="radio" name="visibility" id="visibility1" value="1" checked>
                                        <label class="form-check-label" for="visibility1">
                                        <strong>Show my profile</strong>  (visitors can see your username and profile)
                                        </label>
                                </div>
                                <div class="form-check">
                                        <input class="form-check-input" type="radio" name="visibility" id="visibility2" value="2">
                                        <label class="form-check-label" for="visibility2">
                                        <strong>Only show claimants my profile</strong>   (only those who create a claim can see it)
                                        </label>
                                </div>
                                <div class="form-check">
                                        <input class="form-check-input" type="radio" name="visibility" id="visibility3" value="3">
                                        <label class="form-check-label" for="visibility3">
                                        <strong>Remain anonymous</strong>   (nobody can see it.  You will get an email when a claim is made, but the claimant will only see an anonymous username and cannot see your profile)
                                        </label>
                                </div>

                                <table class="table">
                                        <thead>
                                                <tr>
                                                        <th scope="col">Related FactBid's</th>
                                                        <th scope="col">Amount of bid</th>
                                                </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                                // $parent_id = $res[0]->id_factbid_parent;
                                                $parent_id = $factbid_id;
                                                // $results = $wpdb->get_results($wpdb->prepare("SELECT c.id_factbid,p.post_name,p.post_title FROM ct_factbid as c JOIN wp_posts as p WHERE c.post_id=p.id AND (c.id_factbid_parent=%d OR c.id_factbid=%d)",$parent_id,$parent_id));
                                                if($res[0]->nobid == 1 || $res[0]->nobid == "1"){
                                                        $results = $wpdb->get_results($wpdb->prepare("SELECT id_factbid FROM ct_factbid WHERE post_id=%f",$res[0]->id_factbid_parent));
                                                        $post_title = get_the_title($results[0]->id_factbid);
                                                } else {
                                                        $results = $res;
                                                        $post_title = get_the_title($post_id);
                                                }
                                                
                                                foreach($results as $result){
                                                echo '<tr><td>'.$result->id_factbid.'&nbsp'.$post_title.'</td><td><input onkeypress="return /[0-9]/i.test(event.key)" type="text" class="amount"></td></tr>';   
                                                }
                                        ?>        
                                        
                                        <tr>
                                                <td><strong>Total<strong></td>
                                                <td><input disabled="disabled" type="text" id="totalAmount" class="totalAmount disabled"></td>
                                        </tr>
                                        </tbody>
                                </table>
                                <div class="child-content">
                                        <small><strong>Comments or Restrictions :</strong></small>
                                        
                                        <?php
                                        $content   = '';
                                        $editor_id = 'bid_comments';
                                        $settings  = array( 
                                                'media_buttons' => true, 
                                                'textarea_name'=> 'bid_comments',
                                                'textarea_rows' => 5

                                        ); 
                                        wp_editor($content, $editor_id, $settings); 
                                        ?>
                                        
                                        <small><strong>Conditions :</strong></small>
                                        <?php
                                        $content   = '';
                                        $editor_id = 'bid_conditions';
                                        $settings  = array( 
                                                'media_buttons' => true, 
                                                'textarea_name'=> 'bid_conditions',
                                                'textarea_rows' => 5

                                        ); 
                                        wp_editor($content, $editor_id, $settings);

                                        ?>
                                        
                                        <button type="button" class="btn place-bid" data-factbid="<?php echo $res[0]->id_factbid;?>" data-user="<?php echo $user_id;?>">Place bid</button>
                                        <button type="button" class="btn cancel-bid" data-bs-dismiss="modal" aria-label="Close">Cancel</button>
                                </div>

                        </div>
      
                </div>
        </div>
</div>

<!-- view body section -->
<div class="container">
        <div class="bid-view-table">
                <?php
                        if($res[0]->nobid != 1 || $res[0]->nobid != "1"){
                ?>
                
                <div class="select-option">
                        <span >Sort</span>

                        <select class="form-select form-select-sm" aria-label=".form-select-sm example">
                                <option selected>Most recent</option>
                                <option value="1">One</option>
                                <option value="2">Two</option>
                                <option value="3">Three</option>
                        </select>
                </div>
                <table class="table">
                        <thead>
                                <tr>
                                        <th scope="col">Date</th>
                                        <th scope="col">Bidder</th>
                                        <th scope="col">Amount</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Actions</th>
                                </tr>
                        </thead>                                                                                                                        
                        <tbody>
                                <?php
                                        $bids_data = $wpdb->get_results( 
                                                
                                                $wpdb->prepare(
                                                        "SELECT * FROM ct_bid WHERE id_factbid = %f AND id_bid_next IS NULL",
                                                        $res[0]->id_factbid
                                                    )
                                            );
                                        foreach($bids_data as $bid){
                                                $bid_user = get_user_by( 'id', $bid->id_user );
                                                $status = get_bid_status($bid->status);
                                                $userName = "";
                                                if ( ! empty( $bid_user ) ) {
                                                        
                                                        $fname = $bid_user->first_name;
                                                        $lname = $bid_user->last_name;
                                                        $userName = $fname . " " . $lname;

                                                        if($userName == ""){
                                                                $userName = $bid_user->display_name;
                                                        }
                                                        if($userName == ""){
                                                                $userName = $bid_user->user_login;
                                                        }
                                                }
                                ?>

                                <?php 
                                        include('bids-row/main-bid.php');
                                        if($bid->id_bid_prev != NULL){
                                                $bids_child_data = $wpdb->get_results( 
                                                
                                                $wpdb->prepare(
                                                        "SELECT * FROM ct_bid WHERE id_bid_next = %d",
                                                        $bid->id_bid
                                                        )
                                                );
                                                if(!empty($bids_child_data)){
                                                        $bid_child_data = $bids_child_data[0];
                                                        include('bids-row/child-bid.php');
                                                }
                                        }
                                ?>
                                <?php } ?>
                        </tbody>                        
                </table>
                <?php
                        } else {
                                echo "<h2 class='text-center'>No Bids Allowed.</h2>";
                        }
                ?>
        </div>
</div>