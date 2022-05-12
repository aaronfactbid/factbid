<?php
    get_header();
?>

<div class="title-bar title_small">
    <h1><?php the_title(); ?></h1>
</div>
<?php get_template_part( "template-parts/factbid", "filter" ); ?>
<?php get_template_part( "template-parts/factbid", "list" ); ?>

<?php get_footer(); ?>