<?php  get_header(); ?>
<!-- menus -->
<div class="title-bar">
  <h1>Browse</h1>
  <div class="button-container">
    <?php echo show_create_factbid_button(); ?>
  </div>
</div>
<?php get_template_part( "template-parts/factbid", "filter" ); ?>
 
<?php get_template_part( "template-parts/factbid", "list" ); ?>

    </div>
  </div>
</div>
<?php get_footer(); ?>