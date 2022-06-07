<?php
/**
 * Template Name: Responses Page
*/

    get_header();
?>
<?php if (have_posts()):
        while(have_posts()):
            the_post();
?>
    <div class="title-bar">
        <h1><?php the_title(); ?></h1>
    </div>
    <div class="container">
        <div class="row">
            <article class="col-xs-12 content-area">
                <?php the_content(); ?>
                <?php
                    $var = "";
                    if(get_query_var('response_id')){
                        $var =  get_query_var('response_id');
                    }
                    $responses = $wpdb->get_results($wpdb->prepare("SELECT * FROM ct_response WHERE id_response = %d",$var));
                    if(!empty($responses)){
                        $response = $responses[0];
                        $response_user = get_user_by( 'id', $response->id_user );
                        // $status = get_bid_status($response->status);
                        $status = $response->status;
                        $factbid = $wpdb->get_results($wpdb->prepare("SELECT title FROM ct_factbid WHERE id_factbid = %f",$response->id_factbid));
                        $claim = $wpdb->get_results($wpdb->prepare("SELECT title, post_id FROM ct_claim WHERE id_claim = %d",$response->id_claim));
                        if ( ! empty( $response_user ) ) {
                            $userName = $response_user->first_name . ' ' . $response_user->last_name;
                        }
                        // if($bid->visibility != 1) {
                        //     $userNameshow = "Anonymous";
                        // } else {
                        //         $userNameshow = $userName;
                        // }
                        $userNameshow = $userName;
                        $factbid_title = "";
                        if(!empty($factbid)){
                            $factbid_title = $factbid[0]->title;
                        }

                    ?>
                    <table class="table table-striped table-hover bidsShowTable">
                        <tbody>
                            <tr>
                                <th>For Claim</th>
                                <td><a href="<?php echo get_the_permalink($claim[0]->post_id); ?>"><?php echo $claim[0]->title; ?></a></td>
                            </tr>
                            <tr>
                                <th>For FactBid</th>
                                <td><?php echo $response->id_factbid; ?> <?php echo $factbid_title; ?></td>
                            </tr>
                            <tr>
                                <th>By User</th>
                                <td><?php echo $userNameshow; ?></td>
                            </tr>
                            <tr>
                                <th>Amount</th>
                                <td>$<?php echo $response->amount_paid; ?></td>
                            </tr>
                            <tr>
                                <th>Status</th>
                                <td><?php echo $status; ?></td>
                            </tr>
                            <tr>
                                <th>Comments</th>
                                <td><?php echo $response->comments; ?></td>
                            </tr>
                            <tr>
                                <th>Payment Method</th>
                                <td>
                                    <?php
                                        if(!empty($response->payment_method)){
                                            echo "<ol>";
                                            $p_method = json_decode($response->payment_method, true);
                                            foreach($p_method as $payment){
                                                foreach($payment as $key =>$pay) {
                                                    echo "<li><strong>".$key." => </strong><em>".$pay."<em></li>";
                                                }
                                            }
                                            echo "</ol>";
                                        }
                                        
                                    ?>
                                </td>
                            </tr>
                        </tbody>
                    </table>

                    <?php
                    } else {
                        echo "<h3>No such Response found..!!!<h3>";
                    }
                ?>
            </article>
            
        </div>
    </div>
<?php
    endwhile;
endif;
?>
<?php

    get_footer();
?>