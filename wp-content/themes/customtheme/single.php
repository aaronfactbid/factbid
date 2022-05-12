<?php
    get_header();
?>
<?php if (have_posts()):
        while(have_posts()):
            the_post();
            gt_set_post_view();
?>
    <div class="title-bar">
        <h1><?php the_title(); ?></h1>
    </div>
    <div class="container">
        <div class="row">
            <article class="col-xs-12 content-area">
                <?php the_content(); ?>
            </article>
            <?php 
            //gt_get_post_view(); 
            ?>
        </div>
    </div>
<?php
    endwhile;
endif;
?>
<?php

    get_footer();
?>