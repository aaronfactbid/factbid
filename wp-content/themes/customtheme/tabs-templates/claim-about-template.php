<div class="sub-cnt ">
    <h5 class="contents-heading"><?php echo $res[0]->title; ?></h5>
    <div class="contents-sub-body">
        <?php echo $res[0]->subtitle; ?>
        
    </div>
    <div class="sub-cnt">
        <?php the_content(); ?>
    </div>
    <div class="sub-cnt">
        <h5>Comments or Restrictions</h5>
        <?php echo get_post_meta($post_id, 'claim_comments', true); ?>
    </div>
</div>
