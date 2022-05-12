<?php
    get_header();
?>
    <div class="title-bar news-title">
        <h1>News</h1>
    </div>
    <div class="container">

        <div class="row">
            <div class="col-sm-9 content-area">
                <div class="with-sidebar">
                    <?php if (have_posts()):
                        while(have_posts()):
                            the_post();
                    ?>
                    <article class="inner-block">
                        <div class="row single-news-block">
                            <div class="col-sm-5">
                                <div class="img-col">
                                    <?php if ( has_post_thumbnail() ) : ?>
                                        <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
                                            <?php the_post_thumbnail('medium'); ?>
                                        </a>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="col-sm-7">
                                <div class="cat-list">
                                    <?php
                                        $categories = get_the_category();
                                        if ( ! empty( $categories ) ) {
                                            foreach($categories as $category) {
                                                echo '<a class="cat-item" href="' . esc_url( get_category_link( $category->term_id ) ) . '">' . esc_html( $category->name ) . '</a>';
                                            }
                                        }
                                    ?>
                                </div>
                                <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                                <?php the_excerpt(); ?>
                                    
                                <time class="post-date" datetime="<?php echo get_the_date('c'); ?>" itemprop="datePublished"><?php echo get_the_date(); ?></time>

                                <?php wp_link_pages(); ?>
                                <?php edit_post_link(); ?>
                            </div>
                        </div>
                    </article>
                    <?php
                        endwhile;

                    ?>
                </div>
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
            <div class="container-fluid d-none" id="collapse-news-page">
                <button type="button" class="btn btn-collp-btn-news" data-bs-toggle="collapse" data-bs-target="#collapseSidebar">
                <img alt="Mobile Menu" src="<?php echo get_stylesheet_directory_uri() .'/assets/images/menu.svg';?>>
                </button>
            </div>
            <div class="col-sm-3 collapse show news-sidebar" id="collapseSidebar">
                <?php get_sidebar( 'news' ); ?>
            </div>
        </div>
    </div>
</div>
<?php

    get_footer();
?>