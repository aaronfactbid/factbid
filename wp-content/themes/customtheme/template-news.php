<?php
/**
 * Template Name: News Page
*/
get_header();
?>
<div class="title-bar">
    <h1>News</h1>
</div>
<div class="container">

    <div class="row">
        <div class="col-sm-8 content-area with-sidebar">
            <?php if (have_posts()):
                while(have_posts()):
                    the_post();
            ?>
            <article class="row single-news-block">
                <div class="col-sm-4">
                    <div class="img-col">
                        <?php if ( has_post_thumbnail() ) : ?>
                            <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
                                <?php the_post_thumbnail('medium'); ?>
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="col-sm-8">
                    <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                    <?php the_excerpt(); ?>
                    <?php wp_link_pages(); ?>
                    <?php edit_post_link(); ?>
                </div>
            </article>
            <?php
                endwhile;

            ?>
            <div class="pagination">
                <?php
                    the_posts_pagination( array(
                        'mid_size'  => 2,
                        'prev_text' => __( 'Back', 'textdomain' ),
                        'next_text' => __( 'Onward', 'textdomain' ),
                    ) );
                ?>
            </div>
            <?php
                endif;
            ?>
        </div>
        <div class="col-sm-4 news-sidebar">
            <?php get_sidebar( 'news' ); ?>
            <div class="filter-section">
                <h6>Filter</h6>
                <div class="fl-sort">
                    <span class="lable">Sort:</span> 
                    <span>
                        <select>
                        <option value="">Most Commented</option>
                        <option value="demo-1">demo-1</option>
                        <option value="demo-2">demo-1</option>
                        </select>
                    </span>
                </div>
                <div class="fl-status">
                    <span class="lable">Status:</span> 
                    <span>
                        <select>
                        <option value="">Unclaimed</option>
                        <option value="demo-1">demo-1</option>
                        <option value="demo-2">demo-1</option>
                        </select>
                    </span>
                </div>
                <div class="fl-topic">
                    <span class="lable">Topics:</span> 
                    <span>
                        <select>
                        <option value="">COVID</option>
                        <option value="demo-1">demo-1</option>
                        <option value="demo-2">demo-1</option>
                        </select>
                    </span>
                </div>

            </div>
        </div>
    </div>
</div>

<?php

get_footer();
?>