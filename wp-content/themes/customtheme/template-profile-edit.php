<?php
/**
 * Template Name: Profile Edit Page
*/
 
    get_header();
?>
<?php 

        if(is_user_logged_in()){
            $cuser = wp_get_current_user();
            global $signUpSuccess, $signUpError;
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
                        <h3 class="user_name"><?php echo $cuser->user_login;?></h3>

                        <div class="row profile-data">
                            <div class="col-sm-12">
                                <p><strong>Email: </strong>
                                <input type="text" readonly placeholder="Enter your email Address" class="form-control edit-profile-email-1" value="<?php echo $cuser->user_email; ?>">
                                </p>

                                <a href="<?php echo esc_url(home_url('/reset-password')) ?>" class="btn change-psw">Change password</a>

                            </div>

                            <div class="row g-3 edit-form">
                                <div class="row">
									<p>
									<b>IMPORTANT: So potential whistleblowers know you are legitimate, post something in your social media that includes this:
									<a style="color:lightblue" href="https://factbid.org/author/<?php echo $cuser->user_login;?>">https://factbid.org/author/<?php echo $cuser->user_login;?></a>
									</b>
									</p>

									<div class="col-6 ">
										<lable class="text-right"><b>Then copy/paste the link to your post here:</b></lable>
									</div>
									<div class="col-6 ">
										<input type="text" name="verifylink" class="form-control" placeholder="Enter verification link" aria-label="Enter verification link" value="<?php echo get_user_meta($cuser->ID, "verifylink", true); ?>">
									</div>
									<p>
									<b>Your FactBid username will then have this verified check <img width="20" height="auto" src="<?php echo get_template_directory_uri();?>/assets/images/verified-profile.png"> 
									which takes a potential whistleblower to your social media post.</b>
									</p>
                                </div>
                            </div>                            
                        </div>
						
						<div class="edit-submit-btn">
							<input type="submit" class="btn btn-submit-edit" value="Save" name="edit_profile">
						</div>

                        <div class="social_media">
                            <h3>Social Media (optional):</h3>
                            
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

<?php
    if(isset($_GET['errordata'])){
    echo '<div class="toast-container">';
?>
<div class="position-fixed bottom-0 end-0 p-3" style="z-index: 11">
    <div class="toast show" role="alert" aria-live="assertive" aria-atomic="true">
    <div class="toast-header">
        <strong class="me-auto">Alert..!!</strong>
        <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
    </div>
    <div class="toast-body">
        <?php echo $_GET['errordata']; ?>
    </div>
    </div>
</div>
<?php
    echo "</div>";
}
?>
<?php get_footer(); ?>