<div class="container">
    <div class="claims-data-body">
        <?php
                if($res[0]->nobid != 1 || $res[0]->nobid != "1"){
        ?>
        <span class="claims-sub-cont"> <strong>Bids: <?php echo $total_bids; ?> $<?php echo $total_bid_amount; ?> </strong> </span>
        <span class="claims-sub-cont"> <strong>Claims: <?php echo $total_claims; ?> </strong> </span>
        
            <?php echo show_create_claim_button($post_id); ?>
        
        <?php
                }
        ?>
    </div>
        <div class="claims-view-table container">
            <?php
              if($res[0]->nobid != 1 || $res[0]->nobid != "1"){
            ?>  
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
                                    $claim_user = factbid_get_author_name($claim->id_user);
                                        if($claim->visibility != 1){
                                            $userNameshow = "Anonymous";
                                        } else {
                                            $userNameshow = $claim_user;
                                }
                            ?>

                                <tr>
                                    <td><?php echo get_the_date( 'd-m-Y', $claim->post_id ); ?></td>
                                    <td><?php echo show_verified($claim->id_user) . $userNameshow; ?></td>
                                    <td><?php echo $claim->bidders_accepted; ?> </td>
                                    <td><?php echo $claim->bidders_rejected; ?></td>
                                    <td><?php echo $claim->bidders_pending; ?></td>
                                    <td><a class="btn btn-view-claim" href="<?php echo get_post_permalink( $claim->post_id ); ?>">View</a></td>
                                </tr>
                                <?php unset($userNameshow); } ?>
                        </tbody>                        
                </table>
                <?php
                    } else {
                            echo "<h2 class='text-center'>No Claims Allowed.</h2>";
                    }
                ?>      
        </div>
</div>