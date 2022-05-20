<!-- view body section -->
<div class="container">
    <div class="bid-view-table">
        <?php if(is_user_logged_in()): 
            global $wpdb;
            $bid_factbid_id = $res[0]->id_factbid;
            $user_id = get_current_user_id();
            $bid = $wpdb->get_results( 
            $wpdb->prepare(
            "SELECT id_bid FROM ct_bid WHERE id_factbid = %f AND id_user = %d AND id_bid_next IS NULL",
            $bid_factbid_id,$user_id
            )
            );
            $disabled ='';
            if(empty($bid)){
                $disabled = "disabled";
            }
            ?>
        <button type="button" class="btn crate-bit" data-bs-toggle="modal" data-bs-target="#responseModal" <?php echo $disabled;?>>
        Create New Response
        </button>
        <?php else: ?>
        <a href="<?php echo esc_url(home_url('/sign-in')); ?>" class="btn crate-bit">
        Create New Response
        </a>
        <?php 
        
        endif;
        ?>
        <!-- Modal -->
        <div class="modal fade" id="responseModal" tabindex="-1" aria-labelledby="responseModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content container">
                    <div class="modal-header">
                        <h5 class="modal-title" id="responseModalLabel">Add Response</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        
                        
                        <div class="form-check">
                                <input class="form-check-input" type="radio" name="status" id="status1" value="1" checked>
                                <label class="form-check-label" for="status1">
                                <strong>Accept & promise to pay</strong>
                                </label>
                        </div>
                        <div class="form-check">
                                <input class="form-check-input" type="radio" name="status" id="status2" value="4">
                                <label class="form-check-label" for="status2">
                                <strong>Accepted & paid already</strong>
                                </label>
                        </div>
                        <div class="form-check">
                                <input class="form-check-input" type="radio" name="status" id="status3" value="2">
                                <label class="form-check-label" for="status3">
                                <strong>Rejected</strong>
                                </label>
                        </div>
                        <div class="form-check">
                                <input class="form-check-input" type="radio" name="status" id="status4" value="3">
                                <label class="form-check-label" for="status4">
                                <strong>Need more information</strong>
                                </label>
                        </div>
                        <div id="pay-amount">
                            <label class="form-check-label" for="amount">
                                <strong>Amount</strong>
                            </label>
                            <div class="col-auto">
                                <input type="number" id="amount" class="form-control"> 
                            </div>
                        </div>    
                        
                        <div class="child-content">
                                <small><strong>Please Explain :</strong></small>
                                
                                <?php
                                    $content   = '';
                                    $editor_id = 'status_explain';
                                    $settings  = array( 
                                        'media_buttons' => true, 
                                        'textarea_name'=> 'status_explain',
                                        'textarea_rows' => 5

                                    ); 
                                    wp_editor($content, $editor_id, $settings); 
                                ?>
                                
                                
                        </div>
                        <div class="payment-method">
        
                            <h5 class="modal-title" id="exampleModalLabel">Add Payment Method</h5>
                        

                            <div class="row">
                                <div class="col payment-mth">
                                    <div class="form-check">
                                        <input class="form-check-input selected-method" type="checkbox" value="bitcoin" name="paymentMethods" id="flexCheckChecked1" checked>
                                        <label class="form-check-label" for="flexCheckChecked">
                                            <strong>Bitcoin</strong>
                                        </label>
                                        <div class="col-auto">
                                        <input type="text" id="wallet" class="form-control"> 
                                        </div>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input selected-method" type="checkbox" value="paypal" name="paymentMethods" id="flexCheckChecked2">
                                        <label class="form-check-label" for="flexCheckChecked">
                                            <strong>Paypal</strong>
                                        </label>
                                        <div class="col-auto">
                                        <input type="text" id="paypal-email" class="form-control"> 
                                        </div>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input selected-method" type="checkbox" value="zelle" name="paymentMethods" id="flexCheckChecked3">
                                        <label class="form-check-label" for="flexCheckChecked">
                                            <strong>Zelle</strong>
                                        </label>
                                        <div class="col-auto">
                                        <input type="text" id="zelle-address"  class="form-control"> 
                                        </div>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input selected-method" type="checkbox" value="aba" name="paymentMethods" id="flexCheckChecked4">
                                        <label class="form-check-label" for="flexCheckChecked">
                                            <strong>ABA:</strong>
                                        </label>
                                        <div class="col-auto">
                                        <input type="text" id="aba" class="form-control"> 
                                        </div>
                                    </div>
                                </div>
                                <div class="col payment-mth">
                                    <div class="form-check">
                                        <input class="form-check-input selected-method" type="checkbox" value="swift" name="paymentMethods" id="flexCheckChecked5">
                                        <label class="form-check-label" for="flexCheckChecked">
                                            <strong>Wire Transfer Swift</strong>
                                        </label>
                                        <div class="col-auto">
                                        <input type="text" id="swift" class="form-control"> 
                                        </div>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input selected-method" type="checkbox" value="account" name="paymentMethods" id="flexCheckChecked6">
                                        <label class="form-check-label" for="flexCheckChecked">
                                            <strong>Account</strong>
                                        </label>
                                        <div class="col-auto">
                                        <input type="text" id="account" class="form-control"> 
                                        
                                        
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div> 
                        <?php

                        ?>
                        <button type="button" class="btn place-response" data-factbid="<?php echo $res[0]->id_factbid;?>" data-user="<?php echo $user_id;?>" data-claim="<?php echo $res[0]->id_claim;?>" data-bid="">Add Response</button>
                        <button type="button" data-bs-dismiss="modal" aria-label="Close" class="btn cancel-response">Cancel</button>
                    </div>

                </div>
                
            </div>
        </div>
    </div>
    <table class="table">
        <thead>
            <tr>
                <th scope="col">Username</th>
                <th scope="col">Status</th>
                <th scope="col">Amount paid</th>
                <th scope="col"></th>
            </tr>
        </thead>                                                                                                                        
            <tbody>
                    <?php
                    $id_claim = $res[0]->id_claim;

                    $responses = $wpdb->get_results("SELECT id_user,status,amount_paid,id_response,comments FROM ct_response WHERE id_claim=$id_claim AND id_response_next IS NULL");

                    if(!empty($responses)){
                            foreach($responses as $response){
                            $user = get_user_by('id', $response->id_user);
                        $html = '<tr>
                            <td>'.$user->user_nicename.'</td>
                            <td class="status-text">'.$response->status.'</td>
                            <td>'.$response->amount_paid.'</td>
                            <td>
                                <a href="'.esc_url(home_url('/responses/')).$response->id_response.'" class="btn btn-claim-response-view">View</a>
                                <button type="button" class="btn crate-bit" data-bs-toggle="modal" data-bs-target="#responseModal'.$response->id_response.'" >Edit</button>';
                                echo $html;
                            ?>
                            <?php
                        $html1 .= '</td>
                    </tr>';
                        echo $html1;
                        ?>
                        <div class="modal fade" id="responseModal12" tabindex="-1" aria-labelledby="responseModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content container">
                    <div class="modal-header">
                        <h5 class="modal-title" id="responseModalLabel">Add Response</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        
                        
                        <div class="form-check">
                                <input class="form-check-input" type="radio" name="status" id="status1" value="1" checked>
                                <label class="form-check-label" for="status1">
                                <strong>Accept & promise to pay</strong>
                                </label>
                        </div>
                        <div class="form-check">
                                <input class="form-check-input" type="radio" name="status" id="status2" value="2">
                                <label class="form-check-label" for="status2">
                                <strong>Accepted & paid already</strong>
                                </label>
                        </div>
                        <div class="form-check">
                                <input class="form-check-input" type="radio" name="status" id="status3" value="3">
                                <label class="form-check-label" for="status3">
                                <strong>Rejected</strong>
                                </label>
                        </div>
                        <div class="form-check">
                                <input class="form-check-input" type="radio" name="status" id="status4" value="4">
                                <label class="form-check-label" for="status4">
                                <strong>Need more information</strong>
                                </label>
                        </div>
                        <div id="pay-amount">
                            <label class="form-check-label" for="amount">
                                <strong>Amount</strong>
                            </label>
                            <div class="col-auto">
                                <input type="number" id="amount" class="form-control" value="<?php echo $response->amount_paid;?>"> 
                            </div>
                        </div>    
                        
                        <div class="child-content">
                                <small><strong>Please Explain :</strong></small>
                                
                                <?php
                                    $content   = $response->comments;
                                    $editor_id = 'status_explain';
                                    $settings  = array( 
                                        'media_buttons' => true, 
                                        'textarea_name'=> 'status_explain',
                                        'textarea_rows' => 5

                                    ); 
                                    wp_editor($content, $editor_id, $settings); 
                                ?>
                                
                                
                        </div>
                        <div class="payment-method">
        
                            <h5 class="modal-title" id="exampleModalLabel">Add Payment Method</h5>
                        

                            <div class="row">
                                <div class="col payment-mth">
                                    <div class="form-check">
                                        <input class="form-check-input selected-method" type="checkbox" value="bitcoin" name="paymentMethods" id="flexCheckChecked1" checked>
                                        <label class="form-check-label" for="flexCheckChecked">
                                            <strong>Bitcoin</strong>
                                        </label>
                                        <div class="col-auto">
                                        <input type="text" id="wallet" class="form-control"> 
                                        </div>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input selected-method" type="checkbox" value="paypal" name="paymentMethods" id="flexCheckChecked2">
                                        <label class="form-check-label" for="flexCheckChecked">
                                            <strong>Paypal</strong>
                                        </label>
                                        <div class="col-auto">
                                        <input type="text" id="paypal-email" class="form-control"> 
                                        </div>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input selected-method" type="checkbox" value="zelle" name="paymentMethods" id="flexCheckChecked3">
                                        <label class="form-check-label" for="flexCheckChecked">
                                            <strong>Zelle</strong>
                                        </label>
                                        <div class="col-auto">
                                        <input type="text" id="zelle-address"  class="form-control"> 
                                        </div>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input selected-method" type="checkbox" value="aba" name="paymentMethods" id="flexCheckChecked4">
                                        <label class="form-check-label" for="flexCheckChecked">
                                            <strong>ABA:</strong>
                                        </label>
                                        <div class="col-auto">
                                        <input type="text" id="aba" class="form-control"> 
                                        </div>
                                    </div>
                                </div>
                                <div class="col payment-mth">
                                    <div class="form-check">
                                        <input class="form-check-input selected-method" type="checkbox" value="swift" name="paymentMethods" id="flexCheckChecked5">
                                        <label class="form-check-label" for="flexCheckChecked">
                                            <strong>Wire Transfer Swift</strong>
                                        </label>
                                        <div class="col-auto">
                                        <input type="text" id="swift" class="form-control"> 
                                        </div>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input selected-method" type="checkbox" value="account" name="paymentMethods" id="flexCheckChecked6">
                                        <label class="form-check-label" for="flexCheckChecked">
                                            <strong>Account</strong>
                                        </label>
                                        <div class="col-auto">
                                        <input type="text" id="account" class="form-control"> 
                                        
                                        
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div> 
                        <?php

                        ?>
                        <button type="button" class="btn place-response" data-factbid="<?php echo $res[0]->id_factbid;?>" data-user="<?php echo $user_id;?>" data-claim="<?php echo $res[0]->id_claim;?>" data-bid="">Add Response</button>
                        <button type="button" data-bs-dismiss="modal" aria-label="Close" class="btn cancel-response">Cancel</button>
                    </div>

                </div>
                
            </div>
        </div>
        <?php   
                    }   
                    }
                    
                    ?>
            </tbody>                        
        </table>
    </div>
</div>