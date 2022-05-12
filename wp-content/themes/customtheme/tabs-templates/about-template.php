<?php
    $postId =  get_the_ID();
?>
<div class="content-area">
    <div class="sub-cnt">
        <h5 class="contents-heading">What will it prove if claimed:</h5>
            <?php
                $if_claimed = get_post_meta($postId, "if_claimed", true);
                echo apply_filters('the_content', $if_claimed);
            ?>
    </div>

    <div class="sub-cnt">
        <h5 class="contents-heading">What will it prove if unclaimed:</h5>
        <?php
            $if_unclaimed = get_post_meta($postId, "if_unclaimed", true);
            echo apply_filters('the_content', $if_unclaimed);
        ?>
    </div>

    <div class="sub-cnt">
        <h5 class="contents-heading">What is an acceptable claim:</h5>
        <?php
            $acceptable_claim = get_post_meta($postId, "acceptable_claim", true);
            echo apply_filters('the_content', $acceptable_claim);
        ?>
    </div>

    <div class="sub-cnt ">
        <h5 class="contents-heading">Description:</h5>
        <?php the_content(); ?>
    </div>
</div>
