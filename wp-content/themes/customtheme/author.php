<?php
    get_header();
?>
<?php 
?>
<div class="title-bar">
    <h1>Profile</h1>
</div>

<div class ="full-width theme-color">
    <div class="container">
        <div class="row">
        <?php
            $curauth = (isset($_GET['author_name'])) ? get_user_by('slug', $author_name) : get_userdata(intval($author));
        ?>

            <?php 
                $dip_class = "";
                $diphtml = "";
                     
                     if(isset($curauth->ID)){
                         $id_user = $curauth->ID;
                     } else {
                         $id_user = "";
                     }
                 
            ?>
            <?php
                if($id_user != ""){
                    $cuser = $curauth;
                    $current_useris = "";
                    if(is_user_logged_in()){
                        $current_useris = get_current_user_id();
                    }
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
                <?php if($id_user == "" || ($id_user == $current_useris)){ ?>
                <div class="user_edit-pf">
                    <a href="<?php echo esc_url(home_url('/edit-profile?id=' . $cuser->ID));?>" class="btn btn-light btn-sm profile-edit">Edit</a>
                </div>
                <?php } ?>

                    <h3 class="user_name">
                        <?php // echo $cuser->user_firstname . ' ' . $cuser->user_lastname . ' #' . $cuser->ID; ?>
                        <?php
                            echo '<small><small>Username</small></small>: ' . factbid_get_author_name($cuser->ID);
                        ?>
                    </h3>
                     <?php 
                            global $wpdb;
                            $profile = $wpdb->get_results($wpdb->prepare("SELECT verified FROM ct_profile WHERE id_user=%d",$cuser->ID));
                            if($profile[0]->verified == "Link Verified"):


                        ?>
                        <div class="verified-tick" style="top:26px">
                            <img width="40" height="auto" src="<?php echo get_template_directory_uri();?>/assets/images/verified-profile.png">
                        </div>
                        <?php else: ?>
                            <?php if(current_user_can('administrator')){ ?>
                            <div class="verified-tick" style="top:64px">
                            <button class="btn btn-light btn-sm" id="verify" data-user="<?php echo $cuser->ID;?>">Verify</button>
                            </div>
                            <?php } ?>
                        <?php endif; ?>
                    <div class="row profile-data">
                        <div class="col-sm-6">
							<p>Send a private message in the <a href="/community/profile/<?php echo factbid_get_author_name($cuser->ID); ?>/">forum</a></p>
                            <p><strong>Name: </strong><?php echo $cuser->user_firstname . ' ' . $cuser->user_lastname; ?></p>
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
                                if($show_email == "show"){
                                    $emailid = $cuser->user_email;
                                } else if($show_email == "alternate"){
                                    $emailid = get_user_meta($cuser->ID, "alternate_email", true);
                                } else if($show_email == "hide") {
                                    $emailid = "This user's Privacy settings doesn't allow to show email ID";
                                } else {
                                    $emailid = $cuser->user_email;
                                }
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
</div>
<?php get_footer(); ?>