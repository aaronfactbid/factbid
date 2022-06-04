<?php
/**
 * Template Name: Create Claim
*/
 
    get_header();

    global $wpdb;
    $user_id = get_current_user_id();
    $factbid_id = $_GET['id'];
    if($factbid_id){

    
    $res = $wpdb->get_results($wpdb->prepare("SELECT thumbs_up,thumbs_down,id_factbid_parent,id_factbid,post_id FROM ct_factbid WHERE post_id = %d",$factbid_id));
    $parent_id = $res[0]->id_factbid;

    $related_facts = array();
    $factbid_array = $wpdb->get_results( 
        $wpdb->prepare(
            "SELECT id_factbid FROM ct_factbid 
            WHERE id_factbid_parent=%f 
            OR (id_factbid_parent=%f AND id_factbid_parent!= 0) 
            OR (id_factbid=%f) 
            OR (id_factbid=%f)", 
            $res[0]->id_factbid, 
            $res[0]->id_factbid_parent,
            $res[0]->id_factbid_parent,
            $res[0]->id_factbid
        ));
   
    foreach($factbid_array as $factbid_ids){
        $related_facts[] = $factbid_ids->id_factbid;
    }
    $related_facts[] = $res[0]->id_factbid;
    $related_facts = array_unique($related_facts);

    $claim_num = $wpdb->get_results( 
      $wpdb->prepare(
        "SELECT * FROM ct_claim 
        WHERE id_factbid = %f",
          $res[0]->id_factbid
      )
    );
    $total_claims = count($claim_num);


?>
<div class="title-bar">
      <div class="container">
        <div class="middled-block">
            <h1 class="title_left">Claim #<?php echo $total_claims + 1; ?> for <?php echo get_the_title($factbid_id); ?></h1>
            <div class="like_unlike">
              <span class="like_b" data-id="<?php echo $factbid_id; ?>" data-user="<?php echo $user_id;?>"><?php echo $res[0]->thumbs_up?></span>
              <span class="unlike_b" data-id="<?php echo $factbid_id; ?>" data-user="<?php echo $user_id;?>"><?php echo $res[0]->thumbs_down?></span>
            </div>
        </div>
    </div>
    
</div>

<div class="full-width pale_blue-bg-new">
    <div class="container"> 
        <form class ="claim-create-main">


            <div class="check-box-area">
                <h6 class="contents-heading">What Factbid's are you claiming?</h6>
                    <?php
                    
                    foreach($res as $result){
                        $title = get_the_title($result->post_id);
                        
                        echo '<div class="form-check claim-check-box">
                            <input class="form-check-input selected-factbids" type="checkbox" value="'.$result->id_factbid.'" name="selected-factbids" checked data-postid="'.$result->post_id.'">
                            <label class="form-check-label" for="flexCheckChecked">
                        '.$result->id_factbid. ' ' .$title.'
                            </label>
                            </div>';
                    }
                    ?> 
            </div>
            <div class="radio-btn-area">
                <div class="form-check claim-radio-box">
                    <input class="form-check-input" type="radio" name="visibility" id="flexRadioDefault2" value="1" checked>
                    <label class="form-check-label" for="flexRadioDefault2">
                        <strong>Show my profile</strong>  (visitors can see your username and profile)
                    </label>
                </div>
                <div class="form-check claim-radio-box">
                    <input class="form-check-input" type="radio" name="visibility" id="flexRadioDefault1" value="2">
                    <label class="form-check-label" for="flexRadioDefault1">
                        <strong>Only show bidders my profile</strong>  (only those who create a claim can see it)
                    </label>
                </div>
                <div class="form-check claim-radio-box">
                    <input class="form-check-input" type="radio" name="visibility" id="flexRadioDefault1" value="3">
                    <label class="form-check-label" for="flexRadioDefault1">
                        <strong>Remain anonymous</strong>  (nobody can see it.  Bidders will own see the payment information below and can only communicate to you through FactBid)
                    </label>
                </div>
            </div>
            <!-- <div class="payment-method">
                <h5 class="contents-heading">Payment methods : </h5>
                <div class="container-fluid">
                    <a class ="btn btn-primary" data-bs-toggle="modal" data-bs-target="#paymentModal" href="#">Add Payment Method</a>
                    
                                   <div class="modal fade" id="paymentModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Add Payment Method</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">

                                <div class="row">
                                    <div class="col payment-mth">
                                        <div class="form-check">
                                            <input class="form-check-input selected-method" type="checkbox" value="bitcoin" name="paymentMethods" id="flexCheckChecked1" checked>
                                            <label class="form-check-label" for="flexCheckChecked">
                                                <strong>Bitcoin</strong>
                                            </label>
                                            <div class="col-auto">
                                            <input type="text" placeholder="Wallet" id="wallet" class="form-control"> 
                                            </div>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input selected-method" type="checkbox" value="paypal" name="paymentMethods" id="flexCheckChecked2">
                                            <label class="form-check-label" for="flexCheckChecked">
                                                <strong>Paypal</strong>
                                            </label>
                                            <div class="col-auto">
                                            <input type="text" placeholder="Email Address" id="paypal-email" class="form-control"> 
                                            </div>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input selected-method" type="checkbox" value="zelle" name="paymentMethods" id="flexCheckChecked3">
                                            <label class="form-check-label" for="flexCheckChecked">
                                                <strong>Zelle</strong>
                                            </label>
                                            <div class="col-auto">
                                            <input type="text" placeholder="Zelle Address" id="zelle-address"  class="form-control"> 
                                            </div>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input selected-method" type="checkbox" value="aba" name="paymentMethods" id="flexCheckChecked4">
                                            <label class="form-check-label" for="flexCheckChecked">
                                                <strong>ABA:</strong>
                                            </label>
                                            <div class="col-auto">
                                            <input type="text" placeholder="ABA" id="aba" class="form-control"> 
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
                                            <input type="text" placeholder="Swift" id="swift" class="form-control"> 
                                            </div>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input selected-method" type="checkbox" value="account" name="paymentMethods" id="flexCheckChecked6">
                                            <label class="form-check-label" for="flexCheckChecked">
                                                <strong>Account</strong>
                                            </label>
                                            <div class="col-auto">
                                            <input type="text" placeholder="Bank name" id="bank-name" class="form-control"> 
                                            <input type="text" placeholder="Beneficiary name" id="beneficiary-name" class="form-control"> 
                                            <input type="text" placeholder="Beneficiary Address" id="beneficiary-address" class="form-control"> 
                                            
                                            </div>

                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-primary"  data-bs-dismiss="modal">Save changes</button>
                            </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
			-->

            <div class="listing-claim">
                <h6 class="contents-heading">List all the ways bidders can pay you, such as crypto wallets, paypal addresses, detailed SWIFT/IBAN instrucions:</h6>
                <div class="form-check">
                    <textarea required class="form-control" name="comments" id="comments"></textarea>
                    
                </div>
            </div>


            <div class="sub-cnt-create">
                <h5 class="contents-heading">Your claim:</h5>
                <?php
                    $content = get_the_content($res[0]->post_id);
                    echo $content;
                ?>


                <div class="form-check">
                    <label class="form-label" for="title">
                        <strong>Title:</strong>
                    </label>
                    <input required class="form-control" type="text" value="" name="title" id="title">
                    
                </div>
                <div class="form-check">
                    <label class="form-label" for="subtitle">
                        <strong>Sub Title:</strong>
                    </label>
                    <textarea required class="form-control" name="subtitle" id="subtitle"></textarea>
                    
                </div>
                <div class="form-check">
                    <label class="form-label" for="description">
                        <strong>Details of your claim:</strong>
                    </label>
                        <?php
                            $content   = '';
                            $editor_id = 'description';
                            $settings  = array( 
                                'media_buttons' => true, 
                                'textarea_name'=> 'description',
                                'textarea_rows' => 5

                            ); 
                            wp_editor($content, $editor_id, $settings); 
                        ?>
                </div>
            </div>
            <div class="row">
                <div class="col m-t-20">
                    <button type="button" class="btn btn-primary create-claim" data-factbid="<?php echo $res[0]->id_factbid;?>" data-user="<?php echo $user_id;?>">Save Draft</button>
                    <p><small><em>When you are ready to go live, click POST at the top.</em></small><p>
                </div>
            </div>
            
        </form>
        
    </div>
</div>
<?php
    } else {
        get_template_part( "template-parts/auth", "fail" );
    }
?>
<?php

    get_footer();
?>