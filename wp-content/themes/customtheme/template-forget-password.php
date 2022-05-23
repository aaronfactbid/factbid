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
            <?php if (have_posts()):
                while(have_posts()):
                    the_post();
                    the_content();

                endwhile;
            endif;
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