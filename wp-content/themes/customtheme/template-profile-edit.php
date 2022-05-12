<?php
/**
 * Template Name: Profile Edit Page
*/
 
    get_header();
?>
<?php 

            if(is_user_logged_in()){
            $cuser = wp_get_current_user();


            if (isset($_POST['edit_profile']))
            {
                
                global $reg_errors;
                $reg_errors = new WP_Error;

                $old_username = $_POST['old_username'];
                $semail_show = $_POST['show_email']; // alternate, show, hide
                $salternate_email = $_POST['alternate_email'];

                $susername = $_POST['fusername'];
                $sname = trim($_POST['fname']);
                $scountry = $_POST['country'];
                $slanguage = $_POST['language'];
                $sphone = $_POST['phone'];
                $swebsite = $_POST['website'];

                $sfacebook = $_POST['facebook'];
                $stwitter = $_POST['twitter'];
                $ssubstack = $_POST['substack'];
                $syoutube = $_POST['youtube'];

                $sdescription = $_POST['description'];

                $fullname = array_pad(explode(" ", $sname), 2, "");
                $sfirst_name = @$fullname[0];
                $slast_name = @$fullname[1];
                
                
                
                if(!empty($old_username) && ($old_username != $susername)) {
                    if(empty( $susername ))
                    {
                        $reg_errors->add('field', 'Required form field is missing');
                    }    
                    if ( 6 > strlen( $username ) )
                    {
                        $reg_errors->add('username_length', 'Username too short. At least 6 characters is required' );
                    }
                    if ( username_exists( $username ) )
                    {
                        $reg_errors->add('user_name', 'The username you entered already exists!');
                    }
                    if ( ! validate_username( $username ) )
                    {
                        $reg_errors->add( 'username_invalid', 'The username you entered is not valid!' );
                    } 
                }
                if (is_wp_error( $reg_errors ))
                { 
                    foreach ( $reg_errors->get_error_messages() as $error )
                    {
                        $signUpError='<p style="color:#FF0000; text-aling:left;"><strong>ERROR</strong>: '.$error . '<br /></p>';
                    } 
                }
                
                
                if ( 1 > count( $reg_errors->get_error_messages() ) )
                {
                    // sanitize user form input
                    global $username, $wpdb;
                    $username   =   sanitize_user( $susername );
                    
                    $userdata = array(
                        'ID' => $cuser->ID,
                        'user_url'    =>   $swebsite,
                        'user_nicename'     =>   $username,
                        'first_name'     =>   $sfirst_name,
                        'last_name'     =>   $slast_name,
                        'description'     =>   $sdescription,
                        );
                    $user = wp_update_user( $userdata );
                    $wpdb->update(
                        $wpdb->users, 
                        ['user_login' => $username], 
                        ['ID' => $cuser->ID]
                    );
                    update_user_meta($cuser->ID, "facebook", $sfacebook);
                    update_user_meta($cuser->ID, "twitter", $stwitter);
                    update_user_meta($cuser->ID, "substack", $ssubstack);
                    update_user_meta($cuser->ID, "youtube", $syoutube);

                    update_user_meta($cuser->ID, "country", $scountry);
                    update_user_meta($cuser->ID, "phone", $sphone);
                    update_user_meta($cuser->ID, "languages", $slanguage);
                    update_user_meta($cuser->ID, "show_email", $semail_show);
                    if($semail_show == "alternate"){
                        update_user_meta($cuser->ID, "alternate_email", $salternate_email);
                    }

                }
                $signUpSuccess='<p style="color:#466bb8; text-aling:left;"><strong>Success</strong>: Your Profile has been successfully saved..!!!<br /></p>';

            }
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
                <div class="col-xs-12 content-area">
                    <form class="edit-form-data" action="<?php echo esc_url(home_url('/edit-profile')); ?>" method="post" name="edit_profile"> 
                    <svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
                        <symbol id="check-circle-fill" fill="currentColor" viewBox="0 0 16 16">
                            <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
                        </symbol>
                        <symbol id="info-fill" fill="currentColor" viewBox="0 0 16 16">
                            <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z"/>
                        </symbol>
                        <symbol id="exclamation-triangle-fill" fill="currentColor" viewBox="0 0 16 16">
                            <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>
                        </symbol>
                    </svg>
                    
                    <?php 
                        if(isset($signUpSuccess)){ ?>
                    
                    <div class="alert alert-success d-flex align-items-center alert-dismissible fade show" role="alert">
                        <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Success:"><use xlink:href="#check-circle-fill"/></svg>
                        <div>
                            <?php echo '<div class="signup_error">'.$signUpSuccess.'</div>'; ?>
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    <?php   
                        }
                    ?>
                    <?php 
                        if(isset($signUpError)){ ?>
                    
                    <div class="alert alert-primary alert-dismissible d-flex align-items-center fade show" role="alert">
                        <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Info:"><use xlink:href="#info-fill"/></svg>
                        <div>
                            <?php echo '<div class="signup_error">'.$signUpError.'</div>'; ?>
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    <?php   
                        }
                    ?>
                        <h3 class="user_name">Edit Profile</h3>

                        <div class="row profile-data">
                            <div class="col-sm-12">
                                <?php 
                                    $show_email = get_user_meta($cuser->ID, "show_email", true);
                                    $checked1 = $checked2 = $checked3 = "";
                                    if($show_email == "show"){
                                        $checked1 = "checked";
                                    } else if($show_email == "alternate"){
                                        $checked2 = "checked";
                                    } else if($show_email == "hide") {
                                        $checked3 = "checked";
                                    } else {
                                        $checked1 = "checked";
                                    }
                                ?>
                                <p><strong>Email: </strong>
                                <input type="text" placeholder="Enter your email Address" class="form-control edit-profile-email-1" value="<?php echo $cuser->user_email; ?>">
                                </p>
                                <div class="form-check-edit">
                                    <input class="form-check-input" value="show" type="radio" name="show_email" <?php echo $checked1; ?> id="show_email1">
                                    <label class="form-check-label" for="show_email">
                                        Show my email on my profile
                                    </label>
                                </div>
                                <?php
                                    $alternate_email = get_user_meta($cuser->ID, "alternate_email", true);
                                ?>
                                <div class="form-check-edit">
                                    <input class="form-check-input" <?php echo $checked2; ?> value="alternate" type="radio" name="show_email" id="show_email2">
                                    <label class="form-check-label" for="show_email2">
                                        Show another email on my profile
                                    </label>
                                    <input name="alternate_email" type="text" value="<?php if($alternate_email): echo $alternate_email; endif; ?>" class="form-control form-control edit-profile-email-2" placeholder="Enter your email Address" aria-label="email">
                                    
                                </div>
                                <div class="form-check-edit">
                                    <input class="form-check-input" <?php echo $checked3; ?> value="hide" type="radio" name="show_email" id="show_email3">
                                    <label class="form-check-label" for="show_email3">
                                        Do not show reveal my email
                                    </label>
                                </div>

                                <a href="<?php echo esc_url(home_url('/reset-password')) ?>" class="btn change-psw">Change password</a>

                            </div>
                            

                            <div class="row g-3 edit-form">
                                <div class="row">
                                    <div class="col-6 ">
                                        <lable class="text-right">Username :</lable>
                                    </div>
                                    <div class="col-6 ">
                                        <input type="text" name="fusername" class="form-control" placeholder="Enter Username" aria-label="Enter Username" value="<?php echo $cuser->user_login;?>" readonly>
                                        <input type="hidden" name="old_username" value="<?php echo $cuser->user_login;?>">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6 ">
                                        <lable>Name :</lable>
                                    </div>
                                    <div class="col-6 ">
                                        <input type="text" name="fname" class="form-control" placeholder="Enter Name" aria-label="Enter Name" value="<?php echo $cuser->user_firstname . ' ' . $cuser->user_lastname; ?>">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6 ">
                                        <lable>Country :</lable>
                                    </div>
                                    <div class="col-6 ">
                                        <?php $countryname = get_user_meta($cuser->ID, "country", true); ?>
                                        <select name="country" aria-label="Country" class="form-control">
                                            <?php
                                                global $wpdb;
                                                
                                                $cntry = $wpdb->get_results("SELECT id,name,iso FROM ct_countries");
                                                if($countryname):
                                                    if(!empty($cntry)):
                                                        foreach($cntry as $cn):
                                            ?>
                                            <option <?php selected($countryname, $cn->iso); ?> value="<?php echo $cn->iso; ?>"><?php echo $cn->name; ?></option>
                                            <?php
                                                        endforeach;
                                                    endif;
                                                else:
                                                    if(!empty($cntry)):
                                                        foreach($cntry as $cn):
                                            ?>
                                            <option <?php selected($cn->iso, "US"); ?> value="<?php echo $cn->iso; ?>"><?php echo $cn->name; ?></option>
                                            <?php
                                                        endforeach;
                                                    endif;
                                                endif;
                                            ?>
                                        </select>
                                        
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6 ">
                                        <lable>Preferred Language :</lable>
                                    </div>
                                    <div class="col-6 ">
                                    <?php 
                                        $lang = get_user_meta($cuser->ID, "languages", true);
                                        $langs = get_option("languages", true);
                                    ?>
                                    

                                        <select class="form-select" aria-label="language" name="language">
                                            <?php
                                                if($lang){
                                                    if($langs && !empty($langs)){
                                                        foreach($langs as $key => $language){
                                                            $lan = $language['name'];
                                                            echo '<option '.$class.' value="'.$key.'"'.selected($key, $lang).'>'.$lan.'</option>';
                                                        }
                                                    } else {
                                                        echo "<option value='en'>English</option>";
                                                    }
                                                } else {
                                                    if($langs && !empty($langs)){
                                                        foreach($langs as $key => $language){
                                                            $lan = $language['name'];
                                                            echo '<option '.$class.' value="'.$key.'"'.selected($key, "en").'>'.$lan.'</option>';
                                                        }
                                                    } else {
                                                        echo "<option value='en'>English</option>";
                                                    }
                                                }
                                            
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6 ">
                                        <lable>Phone :</lable>
                                    </div>
                                    <div class="col-6 ">
                                        <input type="text" name="phone" class="form-control" placeholder="Enter Phone Number" aria-label="Enter Phone Number" value="<?php echo get_user_meta($cuser->ID, "phone", true); ?>">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6 ">
                                        <lable>Website :</lable>
                                    </div>
                                    <div class="col-6 ">
                                        <input type="text" name="website" class="form-control" placeholder="Enter Website" aria-label="Enter Website" value="<?php echo $cuser->user_url; ?>">
                                    </div>
                                </div>
                            </div>
                            
                        </div>
                        <div class="social_media">
                            <h3>Social Media:</h3>
                            
                            <div class="social-media-block">
                                <div class="row">
                                    <label class="col-sm-2 col-form-label"><img alt="facebook" src="<?php echo get_stylesheet_directory_uri() .'/assets/images/facebook.png'; ?>"> Facebook</label>
                                    <div class="col-sm-10">
                                        <input name="facebook" class="form-control" type="text" placeholder="@johndoe" value="<?php echo get_user_meta($cuser->ID, "facebook", true); ?>" aria-label="input example">
                                    </div>
                                </div>
                            </div>
                            <div class="social-media-block">
                                <div class="row">
                                    <label class="col-sm-2 col-form-label"><img alt="twitter" src="<?php echo get_stylesheet_directory_uri() .'/assets/images/twitter.png'; ?>"> Twitter</label>
                                    <div class="col-sm-10">
                                        <input name="twitter" class="form-control" type="text" placeholder="@johndoe" value="<?php echo get_user_meta($cuser->ID, "twitter", true); ?>" aria-label="input example">
                                    </div>
                                </div>
                            </div>
                            <div class="social-media-block">
                                <div class="row">
                                    <label class="col-sm-2 col-form-label"><img alt="substack" src="<?php echo get_stylesheet_directory_uri() .'/assets/images/substack.png'; ?>"> Substack</label>
                                    <div class="col-sm-10">
                                        <input name="substack" class="form-control" type="text" placeholder="@johndoe" value="<?php echo get_user_meta($cuser->ID, "substack", true); ?>" aria-label="input example">
                                    </div>
                                </div>
                            </div>
                            <div class="social-media-block">
                                <div class="row">
                                    <label class="col-sm-2 col-form-label"><img alt="youtube" src="<?php echo get_stylesheet_directory_uri() .'/assets/images/youtube.png'; ?>"> Youtube</label>
                                    <div class="col-sm-10">
                                        <input name="youtube" class="form-control" type="text" placeholder="@johndoe" value="<?php echo get_user_meta($cuser->ID, "youtube", true); ?>" aria-label="input example">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="profile-comments">
                            <textarea class="form-control" name="description" placeholder="Enter your comments here"  aria-label="input example"><?php echo normalize_whitespace(get_user_meta($cuser->ID, "description", true)); ?></textarea>
                        </div>
                        <div class="edit-submit-btn">
                            <input type="submit" class="btn btn-submit-edit" value="Save" name="edit_profile">
                        </div>
                    
                    </form >
                </div>
            </div>
        </div>
    </div> 
<?php
    endwhile;
endif;
?>
<?php } ?>
<?php get_footer(); ?>