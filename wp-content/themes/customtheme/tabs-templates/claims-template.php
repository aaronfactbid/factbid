<div class="container">
    <div class="claims-data-body">
        <span class="claims-sub-cont"> <strong>Bids: <?php echo $total_bids; ?> $<?php echo $total_bid_amount; ?> </strong> </span>
        <span class="claims-sub-cont"> <strong>Claims: <?php echo $total_claims; ?> </strong> </span>
        <!-- <span class="claims-sub-cont"> <strong>Total: <?php //echo $total_claims + $total_bids; ?>  </strong> </span> -->
        <a href="<?php echo esc_url(home_url('/create-claim?id=')) . $post_id; ?>" class="btn btn-primary create-claim-page" >Create New Claim</a>
    </div>
        <div class="claims-view-table container">
                
                <table class="table">
                        <thead>
                                <tr>
                                    <th scope="col"></th>
                                    <th scope="col"></th>
                                    <th scope="col"colspan="3" class="text-center">Responses from Bidders</th>
                                    <th scope="col"></th>
                                </tr>
                                <tr>
                                    <th scope="col">Date</th>
                                    <th scope="col">Claimant</th>
                                    <th scope="col">Accepted</th>
                                    <th scope="col">Rejected</th>
                                    <th scope="col">No Response</th>
                                    <th scope="col"></th>
                                </tr>
                        </thead>                                                                                                                        
                        <tbody>
                            <?php
                                $claims_data = $wpdb->get_results( 
                                    $wpdb->prepare(
                                        "SELECT * FROM ct_claim 
                                        WHERE id_factbid =%01.2f",
                                        $res[0]->id_factbid
                                    )
                                  );
                                
                                foreach($claims_data as $claim) {
                                    $claim_user = get_user_by('id', $claim->id_user);
                                        if($claim->visibility != 1){
                                            $userNameshow = "Anonymous";
                                        } else {
                                            $userNameshow = $claim_user->first_name ." " . $claim_user->last_name;
                                        }
                            ?>

                                <tr>
                                    <td><?php echo get_the_date( 'd-m-Y', $claim->post_id ); ?></td>
                                    <td><?php echo $userNameshow; ?></td>
                                    <td><?php echo $claim->bidders_accepted; ?> </td>
                                    <td><?php echo $claim->bidders_rejected; ?></td>
                                    <td><?php echo $claim->bidders_pending; ?></td>
                                    <td><a class="btn btn-view-claim" href="<?php echo get_post_permalink( $claim->post_id ); ?>">View</a></td>
                                </tr>
                                <?php unset($userNameshow); } ?>
                        </tbody>                        
                </table>
        </div>
</div>