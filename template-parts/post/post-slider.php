<?php
// Fetch posts from database.
$post_slider_args = array(
    //'category__in' => array(1),
    'posts_per_page' => 5,
    'no_found_rows' => true,
);
$post_slider_result = new WP_Query($post_slider_args);
// Check if there are posts.
if ($post_slider_result->have_posts()):
    // Limit the number of words in slideshow post excerpts.
    ?>
    <div id="post-slider-container" class="post-slider-container clearfix">
        <div id="post-slider-wrap" class="post-slider-wrap clearfix">
            <div id="post-slider" class="post-slider zeeflexslider">
                <ul class="miteri-slides-wraper owl-carousel">
                    <?php
                    while ($post_slider_result->have_posts()) :
                        $post_slider_result->the_post();
                        ?>
                        <li id="slide-<?php echo get_the_ID(); ?>" class="miteri-post-slide clearfix">
                            <a class="slide-image-link" href="<?php the_permalink(); ?>" rel="bookmark">
                                <figure class="slide-image-wrap">
                                    <?php the_post_thumbnail('full'); ?>
                                </figure>
                            </a>
                            <div class="slide-post clearfix">
                                <div class="slide-content container clearfix">
                                    <h2 class="entry-title"><a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
                                    <div class="entry-meta">
                                        <?php miteri_posted_on(); ?>
                                        <span class="cat-links">
                                            <?php the_category(', '); ?>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <?php
                    endwhile;
                    ?>
                </ul>
            </div>
        </div>
    </div>
    <?php
endif;