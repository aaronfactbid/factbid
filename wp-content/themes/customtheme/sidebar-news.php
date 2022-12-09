<div id="sidebar-news" class="sidebar">
<div class="sidebar_pop-news">
    <?php
        $the_query = new WP_Query( array( 
            "orderby" => 'meta_value_num',
            "meta_key" => 'post_views_count',
            "order" => 'DESC'
            ));
            if ( $the_query->have_posts() ) {
                echo "<h5>Most Popular News</h5>";
                echo "<ul class='news-listing-area'>";
                while ( $the_query->have_posts() ) {
                    $the_query->the_post();
                    echo "<li class='popular-news-li'>";
            ?> 
                <div class="popular-news-box">
                    <h6><a href="<?php the_permalink(); ?>"><?php echo get_the_title(); ?></a></h6>
                    <p><time class="post-date" datetime="<?php echo get_the_date('c'); ?>" itemprop="datePublished"><?php echo get_the_date(); ?></time></p>
                <div>
            <?php
                    echo "</li>";
                }
                echo "</ul>";
                
                
            } else {

            }
            wp_reset_postdata();
    ?>
    </div>
    <hr>
    <div class="sidebar_filter_box">
        <h5>Filter</h5>
        <ul>
            <li>
                <label>Sort:</label>
                <select id="sort_filter">
                    <option value="1">Most Viewed</option>
                    <option value="2">Alphabetical (ASC)</option>
                    <option value="3">Alphabetical (DESC)</option>
                    <option value="4">Date</option>
                </select>
            </li>
            <li>
                <label>Status:</label>
                <select id="status_filter">
                    <option value="1">Closed</option>
                    <option value="2">Published</option>
                    <option value="3">Draft</option>
                </select>
            </li>
            <li>
                <label>Topics:</label>
                <select id="category_filter">
                    <?php 
                        $categories = get_categories();
                        foreach($categories as $category) {
                    ?>
                        <option value="<?php echo $category->term_id; ?>"><?php echo $category->name; ?></option>
                    <?php
                        }
                    ?>
                </select>
            </li>
        </ul>
    </div>
</div>