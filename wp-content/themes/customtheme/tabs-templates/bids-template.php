<div class="bid-data-body">
        <span class="sub-cont"> <strong>Bids: <?php echo $total_bids; ?>  </strong> </span>
        <span class="sub-cont"> <strong> Total: $<?php echo $total_bid_amount; ?> </strong> </span>
        <!-- Button trigger modal -->
        <button type="button" class="btn crate-bit" data-bs-toggle="modal" data-bs-target="#bidModal">
        Create New Bid
        </button>
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
                                        
                                        <button type="button" class="btn place-bid" data-factbid="<?php echo $factbid_id;?>" data-user="<?php echo $user_id;?>">Place bid</button>
                                        <button type="button" class="btn cancel-bid" data-bs-dismiss="modal" aria-label="Close">Cancel</button>
                                </div>

                        </div>
      
                </div>
        </div>
</div>

<!-- view body section -->
<div class="container">
        <div class="bid-view-table">
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
                                                        "SELECT * FROM ct_bid WHERE id_factbid = %d AND id_bid_next IS NULL",
                                                        $factbid_id,NULL
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

                                <tr>
                                        <th>
                                                <?php 
                                                        if($bid->id_bid_prev != NULL || $bid->id_bid_prev != ''){
                                                                echo "<small class='change-flag'>Changed</small>";
                                                        }
                                                ?>
                                                <?php echo $bid->date; ?>
                                        </th>
                                        <td>
                                                <?php 
                                                        if($bid->visibility != 1) {
                                                                if($user_id != $bid->id_user){
                                                                        $userNameshow = "Anonymous";
                                                                }
                                                        } else {
                                                                $userNameshow = $userName;
                                                        }
                                                        
                                                        ?>
                                                <?php echo $userNameshow; ?>
                                        </td>
                                        <td>$<?php echo $bid->amount; ?></td>
                                        <td><?php echo $status; ?></td>
                                        <td>
                                                <?php if($user_id == $bid->id_user){
                                                        echo "<a href='#' data-id='" . $bid->id_bid . "' class='btn btn-primary btn-bidEdit'>Edit</a>";
                                                }
                                                
                                                ?>
                                                <!-- Edit Modal -->
                                                <!-- Modal -->
                                                <div class="modal fade bidEditModal" id="bidModalEdit<?php echo $bid->id_bid; ?>" tabindex="-1" aria-labelledby="bidModalEditLabel" aria-hidden="true">
                                                        <div class="modal-dialog">
                                                                <div class="modal-content container">
                                                                        <div class="modal-header">
                                                                                <h5 class="modal-title" id="bidModalEditLabel">Edit my bid</h5>
                                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                        </div>
                                                                        <div class="modal-body">
                                                                                <div class="form-check">
                                                                                        
                                                                                        <input class="form-check-input" type="radio" name="visibility<?php echo $bid->id_bid; ?>" id="visibility1-<?php echo $bid->id_bid; ?>" value="1" <?php if($bid->visibility == 1){ ?>checked<?php } ?>>
                                                                                        <label class="form-check-label" for="visibility1-<?php echo $bid->id_bid; ?>">
                                                                                        <strong>Show my profile</strong>  (visitors can see your username and profile)
                                                                                        </label>
                                                                                </div>
                                                                                <div class="form-check">
                                                                                        <input class="form-check-input" type="radio" name="visibility<?php echo $bid->id_bid; ?>" id="visibility2-<?php echo $bid->id_bid; ?>" value="2" <?php if($bid->visibility == 2){ ?>checked<?php } ?>>
                                                                                        <label class="form-check-label" for="visibility2-<?php echo $bid->id_bid; ?>">
                                                                                        <strong>Only show claimants my profile</strong>   (only those who create a claim can see it)
                                                                                        </label>
                                                                                </div>
                                                                                <div class="form-check">
                                                                                        <input class="form-check-input" type="radio" name="visibility<?php echo $bid->id_bid; ?>" id="visibility3-<?php echo $bid->id_bid; ?>" value="3" <?php if($bid->visibility == 3){ ?>checked<?php } ?>>
                                                                                        <label class="form-check-label" for="visibility3-<?php echo $bid->id_bid; ?>">
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
                                                                                                
                                                                                                $parent_id = $factbid_id;
                                                                                                
                                                                                                if($res[0]->nobid == 1 || $res[0]->nobid == "1"){
                                                                                                        $results = $wpdb->get_results($wpdb->prepare("SELECT id_factbid FROM ct_factbid WHERE post_id=%f",$res[0]->id_factbid_parent));
                                                                                                        $post_title = get_the_title($results[0]->id_factbid);
                                                                                                } else {
                                                                                                        $results = $res;
                                                                                                        $post_title = get_the_title($post_id);
                                                                                                }
                                                                                                
                                                                                                foreach($results as $result){
                                                                                                echo '<tr><td>'.$result->id_factbid.'&nbsp'.$post_title.'</td><td><input onkeypress="return /[0-9]/i.test(event.key)" type="text" class="amount" value="'.$bid->amount.'"></td></tr>';   
                                                                                                }
                                                                                        ?>        
                                                                                        
                                                                                        <tr>
                                                                                                <td><strong>Total<strong></td>
                                                                                                <td><input disabled="disabled" type="text" id="totalAmount<?php echo $bid->id_bid; ?>" class="totalAmount disabled" value="<?php echo $bid->amount;?>"></td>
                                                                                        </tr>
                                                                                        </tbody>
                                                                                </table>
                                                                                <div class="child-content">
                                                                                        <small><strong>Comments or Restrictions :</strong></small>
                                                                                        
                                                                                        <?php
                                                                                        
                                                                                        $content   = $bid->comments;
                                                                                        $editor_id = 'bid_comments'.$bid->id_bid;
                                                                                        $settings  = array( 
                                                                                                'media_buttons' => true, 
                                                                                                'textarea_name'=> 'bid_comments'.$bid->id_bid,
                                                                                                'textarea_rows' => 5

                                                                                        ); 
                                                                                        wp_editor($content, $editor_id, $settings); 
                                                                                        ?>
                                                                                        
                                                                                        <small><strong>Conditions :</strong></small>
                                                                                        <?php
                                                                                        
                                                                                        $content   = $bid->conditions;
                                                                                        $editor_id = 'bid_conditions'.$bid->id_bid;
                                                                                        $settings  = array( 
                                                                                                'media_buttons' => true, 
                                                                                                'textarea_name'=> 'bid_conditions'.$bid->id_bid,
                                                                                                'textarea_rows' => 5

                                                                                        ); 
                                                                                        wp_editor($content, $editor_id, $settings);

                                                                                        ?>
                                                                                        
                                                                                        <button type="button" class="btn place-bid" data-bidid="<?php echo $bid->id_bid; ?>" data-factbid="<?php echo $factbid_id;?>" data-user="<?php echo $user_id;?>">Place bid</button>
                                                                                
                                                                                </div>
                                                                        </div>
                                                                        
                                                                </div>
                                                        </div>
                                                </div>

                                                <!-- /Edit Modal -->
                                                <a data-id="<?php echo $bid->id_bid; ?>" class='btn btn-primary btn-bidView'>View</a>

                                                <!-- View Modal -->
                                                <!-- Modal -->
                                                <div class="modal fade bidModalView" id="bidModalView<?php echo $bid->id_bid; ?>" tabindex="-1" aria-labelledby="bidModalViewLabel" aria-hidden="true">
                                                        <div class="modal-dialog">
                                                                <div class="modal-content container">
                                                                        <div class="modal-header">
                                                                                <h5 class="modal-title" id="bidModalViewLabel">Bid</h5>
                                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                        </div>
                                                                        <div class="modal-body">
                                                                                <div class="form-check">
                                                                                        

                                                                                        
                                                                                        <input disabled="disabled" class="form-check-input" type="radio" name="visibilityv" id="visibilityv1" value="1" <?php if($bid->visibility == 1){ ?>checked<?php } ?>>
                                                                                        <label class="form-check-label" for="visibilityv1">
                                                                                        <strong>Show my profile</strong>  (visitors can see your username and profile)
                                                                                        </label>
                                                                                </div>
                                                                                <div class="form-check">
                                                                                        <input disabled="disabled" class="form-check-input" type="radio" name="visibilityv" id="visibilityv2" value="2" <?php if($bid->visibility == 2){ ?>checked<?php } ?>>
                                                                                        <label class="form-check-label" for="visibilityv2">
                                                                                        <strong>Only show claimants my profile</strong>   (only those who create a claim can see it)
                                                                                        </label>
                                                                                </div>
                                                                                <div class="form-check">
                                                                                        <input disabled="disabled" class="form-check-input" type="radio" name="visibilityv" id="visibilityv3" value="3" <?php if($bid->visibility == 3){ ?>checked<?php } ?>>
                                                                                        <label class="form-check-label" for="visibilityv3">
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
                                                                                                
                                                                                                $parent_id = $factbid_id;
                                                                                                
                                                                                                if($res[0]->nobid == 1 || $res[0]->nobid == "1"){
                                                                                                        $results = $wpdb->get_results($wpdb->prepare("SELECT id_factbid FROM ct_factbid WHERE post_id=%f",$res[0]->id_factbid_parent));
                                                                                                        $post_title = get_the_title($results[0]->id_factbid);
                                                                                                } else {
                                                                                                        $results = $res;
                                                                                                        $post_title = get_the_title($post_id);
                                                                                                }
                                                                                                
                                                                                                foreach($results as $result){
                                                                                                echo '<tr><td>'.$result->id_factbid.'&nbsp'.$post_title.'</td><td><input disabled="disabled" onkeypress="return /[0-9]/i.test(event.key)" type="text" class="amount"></td></tr>';   
                                                                                                }
                                                                                        ?>        
                                                                                        
                                                                                        <tr>
                                                                                                <td><strong>Total<strong></td>
                                                                                                <td><input disabled="disabled" type="text" class="totalAmount disabled" value="<?php echo $bid->amount;?>"></td>
                                                                                        </tr>
                                                                                        </tbody>
                                                                                </table>
                                                                                <div class="child-content">
                                                                                        <small><strong>Comments or Restrictions :</strong></small>
                                                                                        <div id="bid_commentsv<?php echo $bid->id_bid ?>">
                                                                                                <?php echo $bid->comments;?>
                                                                                        </div>
                                                                                        
                                                                                        <small><strong>Conditions :</strong></small>
                                                                                        <div id="bid_conditionsv<?php echo $bid->id_bid ?>">
                                                                                                <?php echo $bid->conditions;?>
                                                                                        </div>
                                                                                        
                                                                                </div>
                                                                        </div>
                                                                
                                                                </div>
                                                        </div>
                                                </div>
                                                <!-- View Modal -->
                                                
                                        </td>
                                </tr>
                                <?php } ?>
                        </tbody>                        
                </table>
        </div>
</div>