<?php
/**
 * Template Name: Login Page
*/
 
    get_header();
?>
<div class="auth-wrapper theme-color">
    <div id="card-block" class="row align-items-center text-center">
        <div class="col-md-12"><div class="card-body">
            <?php
                do_action("show_error_message_custom");
                if ( ! is_user_logged_in() ) { // Display WordPress login form:
                    $args = array(
                        'redirect' => esc_url(home_url('/profile')), 
                        'form_id' => 'loginform-custom',
                        'label_username' => __( 'Username' ),
                        'label_password' => __( 'Password' ),
                        'label_remember' => __( 'Remember Me' ),
                        'label_log_in' => __( 'Sign In' ),
                        'remember' => true
                    );
                    wp_login_form( $args );
                    echo apply_filters( 'cptch_display', '', 'sign-in' );
                } else { // If logged in:
                    wp_loginout( home_url() ); // Display "Log Out" link.
                    echo " | ";
                    wp_register('', ''); // Display "Site Admin" link.
                }
                ?>
                <div class="forget-password-area"><a href="<?php echo esc_url(home_url('/forget-password')); ?>">Forget Password </a> </div>
                <div class="create-new-account"><a href="<?php echo esc_url(home_url('/register')); ?>"><input type="button" name="create-account" class="create-account btn btn-success" value="Create account"></a></div>
        </div>
    </div>
    </div>
</div>
<?php
if(isset($_GET['errordata']) || isset($_GET['login'])){
    $errordata = "";
    if(isset( $_GET['login'] ) && ($_GET['login'] == 'failed' )){
        $errordata = "The password you entered is incorrect, Please try again.";
    }
    if(isset( $_GET['login'] ) && ($_GET['login'] == 'empty' )){
        $errordata = "Please enter both username and password.";
    }
    if(isset( $_GET['errordata'] )){
        $errordata = $_GET['errordata'];
    }
    echo '<div class="toast-container">';
?>
<div class="position-fixed bottom-0 end-0 p-3" style="z-index: 11">
    <div class="toast show" role="alert" aria-live="assertive" aria-atomic="true">
    <div class="toast-header">
        <strong class="me-auto">Alert..!!</strong>
        <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
    </div>
    <div class="toast-body">
        <?php echo $errordata; print_r($_POST['log']);?>
    </div>
    </div>
</div>
<?php
    echo "</div>";
}
?>
<?php get_footer(); ?>