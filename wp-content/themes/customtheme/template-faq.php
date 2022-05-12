<?php
/**
 * Template Name: FAQ Page
*/
 
    get_header();
    
?>
<div class="title-bar">
    <h1><?php the_title(); ?></h1>
</div>
<div class="container">
    <div class="row">
        <div class="col-xs-12 content-area">
            
<?php 
    $the_query = new WP_Query( array(
        'post_type' => 'faq',
        'showposts' => 10,
        'orderby' => 'title', 
        'order' => 'ASC',
    ) );  

if ($the_query->have_posts()):
    $c=0;
    ?>
    <div class="accordion" id="accordionExample">
    <?php
        while($the_query->have_posts()):
            $the_query->the_post();
            $c++;
    ?>

            

        <div class="accordion-item">
            <h2 class="accordion-header" id="heading<?php echo $c; ?>">
            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse<?php echo $c; ?>" aria-expanded="<?php if($c==1){echo "true";} else {echo "false";} ?>" aria-controls="collapse<?php echo $c; ?>">
            <?php the_title(); ?>
            </button>
            </h2>
            <div id="collapse<?php echo $c; ?>" class="accordion-collapse collapse" aria-labelledby="heading<?php echo $c; ?>" data-bs-parent="#accordionExample">
            <div class="accordion-body">
                <?php the_content(); ?>
            </div>
            </div>
        </div>
    
    <?php
        endwhile;
    ?>
    </div>
    <?php
        endif;
        wp_reset_postdata();
?>
</div>
    
        
</div>
<?php get_footer(); ?>