<?php
/**
 * Template Name: Register Page
*/
get_header();
?>
    <?php

    
    ?>

    <div class="auth-wrapper theme-color">
        <div id="card-block" class="row align-items-center text-center">
            <div class="col-md-12"><div class="card-body">

                <?php
                    global $wpdb, $user_ID;  
                    if (!$user_ID) {  ?>
                        <?php if(isset($signUpError)){echo '<div class="signup_error">'.$signUpError.'</div>';}?>
                        <h4>Create your account</h4>
                        <form id="register_form" action="<?php echo esc_url(home_url('/register')); ?>" method="post" name="user_registeration">
                            <label>Username <span class="error">*</span></label>  
                            <input id="username" type="text" name="username" placeholder="Enter Your Username" class="text" required /><br />
                            <label>Email address <span class="error">*</span></label>
                            <input id="useremail" type="text" name="useremail" class="text" placeholder="Enter Your Email" required /> <br />
                            <label>Password <span class="error">*</span></label>
                            <input id="password" type="password" name="password" class="text" placeholder="Enter Your password" required /> <br />
                            <input id="password_confirmation" type="password" name="password_confirmation" class="text" placeholder="Confirm Your password" required /> <br />
                            <?php echo apply_filters( 'cptch_display', '', 'register' ); ?>
                            <input type="submit" name="user_registeration" value="SignUp" />
                        </form>
                        
                <?php
                    }
                ?>
                
            </div>
        </div>
    </div>
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