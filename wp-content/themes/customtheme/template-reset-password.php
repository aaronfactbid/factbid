<?php
/**
 * Template Name: Reset Password
*/
    get_header();
?>

<?php
    if(is_user_logged_in()){
        $cuser = wp_get_current_user();

        if (isset($_POST['password_reset_form']))
        {
            
            global $reg_errors;
            $reg_errors = new WP_Error;
            $password=$_POST['password'];
            $password_confirmation=$_POST['password_confirmation'];
            
            
            if(empty( $password_confirmation ) || empty($password))
            {
                $reg_errors->add('field', 'Required form field is missing');
            }    
            
            if ( 8 > strlen( $password ) ) {
                $reg_errors->add( 'password', 'Password length must be greater than 8!' );
            }
            // Check password confirmation_matches  
            if(0 !== strcmp($password, $password_confirmation))
            {  
                $reg_errors->add( 'password', 'Passwords do not match!' );
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
                $password   =   esc_attr( $_POST['password'] );
                reset_password( $cuser, $_POST['password'] );
                
                send_password_reset_email($cuser->user_email);
                $signUpError='<p style="color:#466bb8; text-aling:left;"><strong>Success</strong>: Your Password has been Successfully Reset..!!!<br /></p>';
            }

        }

        ?>




        <?php if (have_posts()):
                while(have_posts()):
                    the_post();
        ?>
            <div class="auth-wrapper theme-color">
                <div id="card-block" class="row align-items-center text-center">
                    <div class="col-md-12"><div class="card-body reset-password-card">

                        <?php
                            global $wpdb, $user_ID;  
                            if ($user_ID) {  ?>
                                <?php 
                                    if(isset($signUpError)){
                                        echo '<div class="signup_error">'.$signUpError.'</div>';
                                    }
                                ?>
                                <h4>Reset Your Password</h4>
                                <form id="password_reset_form" action="<?php echo esc_url(home_url('/reset-password')); ?>" method="post" name="password_reset">
                                    
                                    <label>Password <span class="error">*</span></label>
                                    <input type="password" name="password" class="text form-control" placeholder="Enter Your password" required /> <br />
                                    <input type="password" name="password_confirmation" class="text form-control" placeholder="Confirm Your password" required /> <br />
                                    <input type="submit" name="password_reset_form" class="btn btn-primary" value="Reset" />
                                </form>
                                
                        <?php
                            }
                        ?>
                        
                    </div>
                </div>
            </div>
        <?php
            endwhile;
        endif;
        ?>
        <?php
    } else {
        get_template_part( "template-parts/auth", "fail" );
    }
        ?>

<?php
    get_footer();
?>