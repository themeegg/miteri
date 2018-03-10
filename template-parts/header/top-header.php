<?php
/**
 * Template part for displaying Site Branding.
 *
 * @package Miteri
 * @since Miteri 1.0
 */
$cat_id = absint(get_theme_mod('top_header_category', 0));
$show_on_topbar = esc_attr(get_theme_mod('show_on_topbar', 'social'));
if ($cat_id) {
    ?>
    <div class="top-header category-id<?php echo absint(get_theme_mod('top_header_category', 0)); ?>">
        <div class="container">
            <div class="row">
                <div class="col-sm-12 col-12">
                    <?php
                    $args = array(
                        'post_type' => 'post',
                        'posts_per_page' => 10,
                        'cat' => $cat_id
                    );
                    $query = new WP_Query($args);
                    if ($query->have_posts()):
                        ?>
                        <div class="breaking-wrap">
                            <?php $breaking_news_label = get_theme_mod('breaking_news_label', esc_html__('Breaking News', 'miteri')); ?>
                            <span class="breaking-news-title"><?php echo $breaking_news_label; ?></span>
                            <ul class="breaking-news owl-carousel">
                                <?php while ($query->have_posts()): $query->the_post(); ?>
                                    <li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
                                <?php endwhile; ?>
                            </ul>
                        </div>
                        <?php
                    endif;
                    ?>
                </div>
            </div>
        </div>
    </div>
    <?php
}