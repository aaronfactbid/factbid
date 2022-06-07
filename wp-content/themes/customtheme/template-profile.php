<?php
/**
 * Template Name: Profile Page
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

<div class ="full-width theme-color">
    <div class="container">
        <div class="row">
            <?php 
                $dip_class = "";
                $diphtml = "";
                     
                     if(isset($_GET['id'])){
                         $id_user = $_GET['id'];
                     } else {
                         $id_user = "";
                     }
                 
             ?>
             <?php
                 if($id_user != ""){
                     $cuser = get_user_by('id', $id_user);
                 } else {
                     if(is_user_logged_in()){
                         $cuser = wp_get_current_user();
                     } else {
                         $dip_class = "d-none";
                         $diphtml = '<div class="col-xs-12 content-area">';
                         $diphtml .= '<figure class="text-center">
                                            <blockquote class="blockquote">
                                                <p>Sorry, You are not authorized to view this page.</p>
                                            </blockquote>
                                        </figure>';
                         $diphtml .= '</div>';
                     }
                     
                 }
                     
            ?>
            <?php
                if($diphtml != ""){
                    echo $diphtml;
                }
            ?>
            <div class="col-xs-12 content-area <?php echo $dip_class; ?>">
				<p>Select edit to change your password, username or name.  Changing the username will require you to login again.</p>
                <?php if($id_user == "" || ($id_user == $cuser->ID)){ ?>
                <div class="user_edit-pf">
                    <a href="<?php echo esc_url(home_url('/edit-profile'));?>" class="btn btn-light btn-sm profile-edit">Edit</a>
                    <a href="<?php echo esc_url( wp_logout_url(home_url()) ); ?>" class="btn btn-light btn-sm logout">Logout</a>
                </div>

                <?php } ?>
                <div class="username_wrapper">
                    <?php /* ?><h3 class="user_name"><?php echo factbid_get_author_name($cuser->ID) . ' #' . $cuser->ID; ?></h3><?php */ ?>
                    <h3 class="user_name"><small><small>Username</small></small>: <?php echo factbid_get_author_name($cuser->ID); ?></h3>
                        
                        <?php 
                            $profile = $wpdb->get_results($wpdb->prepare("SELECT verified FROM ct_profile WHERE id_user=%d",$cuser->ID));
                            if($profile[0]->verified == "Link Verified"):


                        ?>
                        <div class="verified-tick">
                            <img width="40" height="auto" src="<?php echo get_template_directory_uri();?>/assets/images/verified-profile.png">
                        </div>
                        <?php endif;?>
                    </div>
                </div>
                    <div class="row profile-data">
                        <div class="col-sm-6">
                            <p><strong>Name: </strong><?php echo factbid_get_author_name($cuser->ID) ?></p>
                            <p><strong>Languages:</strong>
                                <?php 
                                    $lang =  get_user_meta($cuser->ID, "languages", true);
                                    echo show_language_from_id ($lang);
                                ?>
                            </p>
                            <p><strong>Phone:</strong><?php echo get_user_meta($cuser->ID, "phone", true); ?></p>
                        </div>
                        <div class="col-sm-6">
                            <p><strong>Country: </strong><?php echo get_user_meta($cuser->ID, "country", true); ?></p>
                            <?php 
                                $show_email = get_user_meta($cuser->ID, "show_email", true);
                                $emailid = $cuser->user_email;
                            ?>
                            <p><strong>Email: </strong><?php echo $emailid; ?></p>
                            <p><strong>Website: </strong><?php echo $cuser->user_url; ?></p>
                        </div>
                    </div>
                    <div class="social_media">
                        <h3>Social Media:</h3>
                        
                        <div class="social-media-block">
                            <div class="row">
                                <label class="col-sm-2 col-form-label"><img alt="facebook" src="<?php echo get_stylesheet_directory_uri() .'/assets/images/facebook.png'; ?>"> Facebook</label>
                                <div class="col-sm-10">
                                    <input class="form-control" type="text" placeholder="@johndoe" value="<?php echo get_user_meta($cuser->ID, "facebook", true); ?>" aria-label="readonly input example" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="social-media-block">
                            <div class="row">
                                <label class="col-sm-2 col-form-label"><img alt="twitter" src="<?php echo get_stylesheet_directory_uri() .'/assets/images/twitter.png'; ?>"> Twitter</label>
                                <div class="col-sm-10">
                                    <input class="form-control" type="text" placeholder="@johndoe" value="<?php echo get_user_meta($cuser->ID, "twitter", true); ?>" aria-label="readonly input example" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="social-media-block">
                            <div class="row">
                                <label class="col-sm-2 col-form-label"><img alt="substack" src="<?php echo get_stylesheet_directory_uri() .'/assets/images/substack.png'; ?>"> Substack</label>
                                <div class="col-sm-10">
                                    <input class="form-control" type="text" placeholder="@johndoe" value="<?php echo get_user_meta($cuser->ID, "substack", true); ?>" aria-label="readonly input example" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="social-media-block">
                            <div class="row">
                                <label class="col-sm-2 col-form-label"><img alt="youtube" src="<?php echo get_stylesheet_directory_uri() .'/assets/images/youtube.png'; ?>"> Youtube</label>
                                <div class="col-sm-10">
                                    <input class="form-control" type="text" placeholder="@johndoe" value="<?php echo get_user_meta($cuser->ID, "youtube", true); ?>" aria-label="readonly input example" readonly>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="profile-comments">
                        <textarea class="form-control" placeholder="Enter your comments here"  aria-label="readonly input example" readonly><?php echo normalize_whitespace(get_user_meta($cuser->ID, "description", true)); ?></textarea>
                    </div>
            </div>

            <!-- User Posts -->
            <div class="user_posts">
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="factbid-tab" data-bs-toggle="tab" data-bs-target="#factbidsTab" type="button" role="tab" aria-controls="factbidsTab" aria-selected="true">Factbids</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="bid-tab" data-bs-toggle="tab" data-bs-target="#bidsTab" type="button" role="tab" aria-controls="bidsTab" aria-selected="false">Bids</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="claim-tab" data-bs-toggle="tab" data-bs-target="#claimsTab" type="button" role="tab" aria-controls="claimsTab" aria-selected="false">Claims</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="response-tab" data-bs-toggle="tab" data-bs-target="#responseTab" type="button" role="tab" aria-controls="responseTab" aria-selected="false">Response</button>
                    </li>
                </ul>
                <div class="tab-content" id="postList">
                    <div class="tab-pane fade show active" id="factbidsTab" role="tabpanel" aria-labelledby="factbid-tab">
                        <table class="table table-success table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>SL No.</th>
                                    <th>FactBid ID</th>
                                    <th>Title</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    global $wpdb;
                                    $factbids = $wpdb->get_results($wpdb->prepare("SELECT id_factbid_parent, id_factbid, post_id, title FROM ct_factbid WHERE id_user = %d",$cuser->ID));
                                    $a = 0;
                                    if(!empty($factbids)):
                                    foreach($factbids as $factbid):
                                        $a++;
                                ?>
                                <tr>
                                    <td><?php echo $a; ?></td>
                                    <td><?php echo $factbid->id_factbid; ?></td>
                                    <td><?php echo $factbid->title; ?></td>
                                    <td><a class="btn btn-primary" href="<?php echo esc_url(home_url('/')) . strval(number_format($factbid->id_factbid, 2)); ?>">View</a></td>
                                </tr>
                                <?php
                                    endforeach;
                                    else:
                                        echo "<tr><td colspan='4'>No Factbids Yet</td></tr>";
                                    endif;
                                ?>
                            </tbody>
                        </table>

                    </div>
                    <div class="tab-pane fade" id="bidsTab" role="tabpanel" aria-labelledby="bid-tab">
                        <table class="table table-success table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>SL No.</th>
                                    <th>FactBid ID</th>
                                    <th>Amount</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    
                                    $bids = $wpdb->get_results($wpdb->prepare("SELECT * FROM ct_bid WHERE id_user = %d",$cuser->ID));
                                    $b = 0;
                                    if(!empty($bids)):
                                    foreach($bids as $bid):
                                        $b++;
                                ?>
                                <tr>
                                    <td><?php echo $b; ?></td>
                                    <td><?php echo $bid->id_factbid; ?></td>
                                    <td><?php echo $bid->amount; ?></td>
                                    <td><a class="btn btn-primary" href="<?php echo esc_url(home_url('/bids/'. $bid->id_bid)); ?>">View</a></td>
                                </tr>
                                <?php
                                    endforeach;
                                    else:
                                        echo "<tr><td colspan='4'>No Bids Yet</td></tr>";
                                    endif;
                                ?>
                            </tbody>
                        </table>

                    </div>
                    <div class="tab-pane fade" id="claimsTab" role="tabpanel" aria-labelledby="claim-tab">
                        <table class="table table-success table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>SL No.</th>
                                    <th>FactBid ID</th>
                                    <th>Title</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    
                                    $claims = $wpdb->get_results($wpdb->prepare("SELECT id_factbid, post_id, title FROM ct_claim WHERE id_user = %d",$cuser->ID));
                                    $c = 0;
                                    if(!empty($claims)):
                                    foreach($claims as $claim):
                                        $c++;
                                ?>
                                <tr>
                                    <td><?php echo $c; ?></td>
                                    <td><?php echo $claim->id_factbid; ?></td>
                                    <td><?php echo $claim->title; ?></td>
                                    <td><a class="btn btn-primary" href="<?php echo get_the_permalink($claim->post_id); ?>">View</a></td>
                                </tr>
                                <?php
                                    endforeach;
                                    else:
                                        echo "<tr><td colspan='4'>No Claims Yet</td></tr>";
                                    endif;
                                ?>
                            </tbody>
                        </table>

                    </div>
                    <div class="tab-pane fade" id="responseTab" role="tabpanel" aria-labelledby="response-tab">
                        <table class="table table-success table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>SL No.</th>
                                    <th>FactBid ID</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    
                                    $responses = $wpdb->get_results($wpdb->prepare("SELECT id_response,id_factbid, status FROM ct_response WHERE id_user = %d",$cuser->ID));
                                    $c = 0;
                                    if(!empty($responses)):
                                    foreach($responses as $response):
                                        $c++;
                                ?>
                                <tr>
                                    <td><?php echo $c; ?></td>
                                    <td><?php echo $response->id_factbid; ?></td>
                                    <td><?php echo $response->status; ?></td>
                                    <td><a class="btn btn-primary" href="<?php echo esc_url(home_url('/responses/')).$response->id_response; ?>">View</a></td>
                                </tr>
                                <?php
                                    endforeach;
                                    else:
                                        echo "<tr><td colspan='4'>No Responses Yet</td></tr>";
                                    endif;
                                ?>
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
</div>
<?php
    endwhile;
endif;
?>
<?php get_footer(); ?>