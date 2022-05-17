<?php
/**
 * Template Name: Forgot Password Page
*/
get_header();
?>
<div class="auth-wrapper theme-color">
    <div id="card-block" class="row align-items-center text-center">
        <div class="col-md-12"><div class="card-body forget-password-card">  
           <h4>Forgot Password?</h4>
            <form id="password_forget_form" action="<?php echo esc_url(home_url('/forgot-password')); ?>" method="post" name="password_forget">
                
                 <input type="email" name="emailid" class="text form-control" placeholder="email address" required /> <br />
                 <input type="submit" name="forget-password" class="btn btn-primary" value="Submit" />
            </form>
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