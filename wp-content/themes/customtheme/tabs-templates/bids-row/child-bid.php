<tr class="child-bid">
    <th>
        <?php 
            if($bid_child_data->id_bid_prev != NULL || $bid_child_data->id_bid_prev != ''){
                    echo "<small class='change-flag'>Changed</small>";
            }
        ?>
        <small><?php echo date( "Y-m-d",strtotime($bid_child_data->date)); ?></small>
        
    </th>
    <td>
        <?php 
            if($bid_child_data->visibility != 1) {
                    if($user_id != $bid_child_data->id_user){
                            $userNameshow = "Anonymous";
                    }
            } else {
                    $userNameshow = $userName;
            }
            
        ?>
        <small><?php echo show_verified($bid_child_data->id_user) . $userNameshow; ?></small>
    </td>
    <td><small>$<?php echo $bid_child_data->amount; ?></small></td>
    <td><small><?php echo $status; ?></small></td>
    <td>
        <a href="#" data-id="<?php echo $bid_child_data->id_bid; ?>" class='btn btn-primary btn-bidView'>View</a>

        <!-- View Modal -->
        <!-- Modal -->
        <div class="modal fade bidModalView" id="bidModalView<?php echo $bid_child_data->id_bid; ?>" tabindex="-1" aria-labelledby="bidModalViewLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content container">
                    <div class="modal-header">
                        <h5 class="modal-title" id="bidModalViewLabel">Bid</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-check">
                            

                            
                            <input disabled="disabled" class="form-check-input" type="radio" name="visibilityv" id="visibilityv1" value="1" <?php if($bid_child_data->visibility == 1){ ?>checked<?php } ?>>
                            <label class="form-check-label" for="visibilityv1">
                            <strong>Show my profile</strong>  (visitors can see your username and profile)
                            </label>
                        </div>
                        <div class="form-check">
                            <input disabled="disabled" class="form-check-input" type="radio" name="visibilityv" id="visibilityv2" value="2" <?php if($bid_child_data->visibility == 2){ ?>checked<?php } ?>>
                            <label class="form-check-label" for="visibilityv2">
                            <strong>Only show claimants my profile</strong>   (only those who create a claim can see it)
                            </label>
                        </div>
                        <div class="form-check">
                            <input disabled="disabled" class="form-check-input" type="radio" name="visibilityv" id="visibilityv3" value="3" <?php if($bid_child_data->visibility == 3){ ?>checked<?php } ?>>
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
                                                $post_title = get_the_title($results[0]->post_id);
                                        } else {
                                                $results = $res;
                                                $post_title = get_the_title($post_id);
                                        }
                                        
                                        foreach($results as $result){
                                        echo '<tr><td>'.$result->id_factbid.'&nbsp'.$post_title.'</td><td><input disabled="disabled" onkeypress="return /[0-9]/i.test(event.key)" type="text" class="amount" value="'.$bid_child_data->amount.'"></td></tr>';   
                                        }
                                ?>        
                                
                                <tr>
                                        <td><strong>Total<strong></td>
                                        <td><input disabled="disabled" type="text" class="totalAmount disabled" value="<?php echo $bid_child_data->amount;?>"></td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="child-content">
                            <small><strong>Comments or Restrictions :</strong></small>
                            <div id="bid_commentsv<?php echo $bid_child_data->id_bid ?>">
                                    <?php echo $bid_child_data->comments;?>
                            </div>
                            
                            <small><strong>Conditions :</strong></small>
                            <div id="bid_conditionsv<?php echo $bid_child_data->id_bid ?>">
                                    <?php echo $bid_child_data->conditions;?>
                            </div>
                            
                        </div>
                    </div>
    
                </div>
            </div>
        </div>
        <!-- View Modal -->
                
    </td>
</tr>