<?php
/**
 * Template Name: Edit Claim
*/
 
    get_header();

    global $wpdb;
    $user_id = get_current_user_id();
    if(isset($_GET['id']) && isset($_GET['factbid_id'])){
        $claims_id = $_GET['id'];
        $factbid_id = $_GET['factbid_id'];
    
        if($factbid_id && $claims_id){
            $claims = $wpdb->get_results($wpdb->prepare("SELECT * FROM ct_claim WHERE post_id = %d",$claims_id));
            $res = $wpdb->get_results($wpdb->prepare("SELECT thumbs_up,thumbs_down,id_factbid_parent,id_factbid,post_id FROM ct_factbid WHERE id_factbid = %d",$factbid_id));
            
            
            foreach($claims as $claimD):

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
                <?php
                    $check1 = $check2 = $check3 = "";
                    if($claimD->visibility == 1) {
                        $check1 = "checked";
                    } else if($claimD->visibility == 2){
                        $check2 = "checked";
                    } else if($claimD->visibility == 3){
                        $check3 = "checked";
                    }
                ?>
                <div class="radio-btn-area">
                    <div class="form-check claim-radio-box">
                        <input class="form-check-input" type="radio" name="visibility" id="flexRadioDefault1" value="1" <?php echo $check1; ?>>
                        <label class="form-check-label" for="flexRadioDefault1">
                            <strong>Show my profile</strong>  (visitors can see your username and profile)
                        </label>
                    </div>
                    <div class="form-check claim-radio-box">
                        <input class="form-check-input" type="radio" name="visibility" id="flexRadioDefault2" value="2" <?php echo $check2; ?>>
                        <label class="form-check-label" for="flexRadioDefault2">
                            <strong>Only show bidders my profile</strong>  (only those who create a claim can see it)
                        </label>
                    </div>
                    <div class="form-check claim-radio-box">
                        <input class="form-check-input" type="radio" name="visibility" id="flexRadioDefault3" value="3" <?php echo $check3; ?>>
                        <label class="form-check-label" for="flexRadioDefault3">
                            <strong>Remain anonymous</strong>  (nobody can see it.  Bidders will own see the payment information below and can only communicate to you through FactBid)
                        </label>
                    </div>
                </div>
                <div class="payment-method">
                    <h5 class="contents-heading">Payment methods : </h5>
                    <div class="container-fluid">
                        <a class ="btn btn-primary" data-bs-toggle="modal" data-bs-target="#paymentModal" href="#">Add Payment Method</a>
                        <?php
                            $payM = $claimD->payment_method;


                            

                            
                            $paypal = $bitcoin = $zelle = $aba = $swift = $account = "";
                            if(!empty($payM)){
                                foreach(json_decode($payM, true) as $pay){
                                    
                                    foreach($pay as $key => $value){

                                        if($key == "paypal") {
                                            $paypal = $value;
                                        }
                                        if($key == "bitcoin") {
                                            $bitcoin = $value;
                                        }
                                        if($key == "zelle") {
                                            $zelle = $value;
                                        }
                                        if($key == "aba") {
                                            $aba = $value;
                                        }
                                        if($key == "swift") {
                                            $swift = $value;
                                        }
                                        if($key == "account") {
                                            $account = $value;
                                        }


                                    }
                                    
                                }
                            }

                            

                        ?>
                        <!-- Modal -->
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
                                                <input class="form-check-input selected-method" type="checkbox" value="bitcoin" name="paymentMethods" id="flexCheckChecked1" <?php if($bitcoin) {?>checked<?php } ?>>
                                                <label class="form-check-label" for="flexCheckChecked">
                                                    <strong>Bitcoin</strong>
                                                </label>
                                                <div class="col-auto">
                                                <input type="text" placeholder="Wallet" id="wallet" class="form-control" value="<?php if($bitcoin) { echo $bitcoin; } ?>"> 
                                                </div>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input selected-method" type="checkbox" value="paypal" name="paymentMethods" id="flexCheckChecked2" <?php if($paypal) {?>checked<?php } ?>>
                                                <label class="form-check-label" for="flexCheckChecked">
                                                    <strong>Paypal</strong>
                                                </label>
                                                <div class="col-auto">
                                                <input type="text" placeholder="Email Address" id="paypal-email" class="form-control" value="<?php if($paypal) { echo $paypal; } ?>"> 
                                                </div>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input selected-method" type="checkbox" value="zelle" name="paymentMethods" id="flexCheckChecked3" <?php if($zelle) {?>checked<?php } ?>>
                                                <label class="form-check-label" for="flexCheckChecked">
                                                    <strong>Zelle</strong>
                                                </label>
                                                <div class="col-auto">
                                                <input type="text" placeholder="Zelle Address" id="zelle-address"  class="form-control" value="<?php if($zelle) { echo $zelle; } ?>"> 
                                                </div>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input selected-method" type="checkbox" value="aba" name="paymentMethods" id="flexCheckChecked4" <?php if($aba) {?>checked<?php } ?>>
                                                <label class="form-check-label" for="flexCheckChecked">
                                                    <strong>ABA:</strong>
                                                </label>
                                                <div class="col-auto">
                                                <input type="text" placeholder="ABA" id="aba" class="form-control" value="<?php if($aba) { echo $aba; } ?>"> 
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col payment-mth">
                                            <div class="form-check">
                                                <input class="form-check-input selected-method" type="checkbox" value="swift" name="paymentMethods" id="flexCheckChecked5" <?php if($swift) {?>checked<?php } ?>>
                                                <label class="form-check-label" for="flexCheckChecked">
                                                    <strong>Wire Transfer Swift</strong>
                                                </label>
                                                <div class="col-auto">
                                                <input type="text" placeholder="Swift" id="swift" class="form-control" value="<?php if($swift) { echo $swift; } ?>"> 
                                                </div>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input selected-method" type="checkbox" value="account" name="paymentMethods" id="flexCheckChecked6" <?php if($account) {?>checked<?php } ?>>
                                                <label class="form-check-label" for="flexCheckChecked">
                                                    <strong>Account</strong>
                                                </label>
                                                <div class="col-auto">
                                                    <?php 
                                                        if($account) { 
                                                            $addr = explode(",", $account); 
                                                        } 
                                                    ?>
                                                    <input type="text" placeholder="Bank name" id="bank-name" class="form-control" value="<?php echo $addr[0]; ?>"> 
                                                    <input type="text" placeholder="Beneficiary name" id="beneficiary-name" class="form-control" value="<?php echo $addr[1]; ?>"> 
                                                    <input type="text" placeholder="Beneficiary Address" id="beneficiary-address" class="form-control" value="<?php echo $addr[2]; ?>"> 
                                                
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
                        <!-- /Modal -->


                        
                    </div>
                </div>
                <?php
                    $claim_post =  get_post($claims_id);
                ?>

                <div class="listing-claim">
                    <h6 class="contents-heading">Comments or Restrictions:</h6>
                    <div class="form-check">
                        <textarea required class="form-control" name="comments" id="comments"><?php echo get_post_meta($claims_id, "claim_comments", true); ?></textarea>
                        
                    </div>
                    
                </div>

                <div class="sub-cnt-create">
                    <h5 class="contents-heading">Explain:</h5>
                    <?php
                        $content = get_the_content($res[0]->post_id);
                        echo $content;
                    ?>


                    <div class="form-check">
                        <label class="form-label" for="title">
                            <strong>Title:- </strong>
                        </label>
                        <input required class="form-control" type="text" value="<?php echo $claimD->title; ?>" name="title" id="title">
                        
                    </div>
                    <div class="form-check">
                        <label class="form-label" for="subtitle">
                            <strong>Sub Title:- </strong>
                        </label>
                        <textarea required class="form-control" name="subtitle" id="subtitle"><?php echo wp_strip_all_tags($claimD->subtitle); ?></textarea>
                        
                    </div>
                    <div class="form-check">
                        <label class="form-label" for="description">
                            <strong>Description:- </strong>
                        </label>
                            <?php
                                $content   = $claim_post->post_content;
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
                        <button type="button" class="btn btn-primary update-claim" data-claimid="<?php echo $claims_id;?>" data-factbid="<?php echo $res[0]->id_factbid;?>" data-user="<?php echo $user_id;?>">Update Claim</button>
                    </div>
                </div>

            </form>
            
        </div>
    </div>
<?php
    endforeach;
    } else {
        get_template_part( "template-parts/auth", "fail" );
    }
} else {
    get_template_part( "template-parts/auth", "fail" );
}
?>
<?php

    get_footer();
?>