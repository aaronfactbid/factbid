<?php
/**
 * Template Name: Bids Page
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
                    if(get_query_var('bid_id')){
                        $var =  get_query_var('bid_id');
                    }
                    $bids = $wpdb->get_results($wpdb->prepare("SELECT * FROM ct_bid WHERE id_bid = %d",$var));
                    if(!empty($bids)){
                        $bid = $bids[0];
                        $bid_user = get_user_by( 'id', $bid->id_user );
                        $status = get_bid_status($bid->status);
                        $factbid = $wpdb->get_results($wpdb->prepare("SELECT title FROM ct_factbid WHERE id_factbid = %d",$bid->id_factbid));
                        if ( ! empty( $bid_user ) ) {
                            $userName = $bid_user->first_name . ' ' . $bid_user->last_name;
                        }
                        if($bid->visibility != 1) {
                            $userNameshow = "Anonymous";
                        } else {
                                $userNameshow = $userName;
                        }
                        $factbid_title = "";
                        if(!empty($factbid)){
                            $factbid_title = $factbid[0]->title;
                        }

                    ?>
                    <table class="table table-striped table-hover bidsShowTable">
                        <tbody>
                            <tr>
                                <th>On Date</th>
                                <td><?php echo $bid->date; ?></td>
                            </tr>
                            <tr>
                                <th>For FactBid</th>
                                <td><?php echo $bid->id_factbid; ?> <?php echo $factbid_title; ?></td>
                            </tr>
                            <tr>
                                <th>By User</th>
                                <td><?php echo $userNameshow; ?></td>
                            </tr>
                            <tr>
                                <th>For Amount</th>
                                <td>$<?php echo $bid->amount; ?></td>
                            </tr>
                            <tr>
                                <th>Status</th>
                                <td><?php echo $status; ?></td>
                            </tr>
                            <tr>
                                <th>Comments</th>
                                <td><?php echo $bid->comments; ?></td>
                            </tr>
                            <tr>
                                <th>Conditions</th>
                                <td><?php echo $bid->conditions; ?></td>
                            </tr>
                        </tbody>
                    </table>

                    <?php
                    } else {
                        echo "<h3>No such bid found..!!!<h3>";
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