<?php
/**
 * Template Name: Contribute Page
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
        </article>
    </div>
</div>
<?php
    endwhile;
endif;
?>
<?php get_footer(); ?>