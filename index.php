<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Miteri
 * @since Miteri 1.0
 */
get_header();
$show_cta = absint(get_theme_mod('blog_show_cta', 1));
if (is_home() && $show_cta):
    get_template_part('template-parts/page/blog', 'box');
endif;
/* Blog Options */
$blog_layout = get_theme_mod('blog_layout', 'list');
$blog_sidebar_position = get_theme_mod('blog_sidebar_position', 'content-sidebar');
$post_template = miteri_blog_template();
$post_column = miteri_blog_column();
if (have_posts()) :
    ?>
    <div id="primary" class="content-area">
        <main id="main" class="site-main" role="main">
            <?php
            $blog_lazy_loading = absint(get_theme_mod('blog_lazy_loading', 0));
            $lazy_loading_class = ($blog_lazy_loading) ? ' miteri-lazy-loading ' : ' ';
            $data_lazyload = miteri_lazyload_data();
            ?>
            <section data-lazyload="<?php echo esc_attr(json_encode($data_lazyload)); ?>" class="row posts-loop wrapper-type-<?php echo esc_attr($post_template . $lazy_loading_class); ?> <?php
            if ('grid' == $blog_layout) {
                echo esc_attr(' flex-row');
            }
            ?>">
                         <?php
                         /* Start the Loop */
                         while (have_posts()) : the_post();
                             ?>
                    <div class="post-wrapper <?php echo esc_attr($post_column); ?>">
                        <?php get_template_part('template-parts/post/content', $post_template); ?>
                    </div>
                <?php endwhile; ?>
            </section>
            <div class="loading-image">
                <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/img/ajax-loading.gif'); ?>" title="<?php esc_html_e('Loading Image', 'miteri'); ?>" alt="<?php esc_html_e('Loading Image', 'miteri'); ?>" height="50" width="50" />
            </div>
            <?php
            if (!$blog_lazy_loading):
                the_posts_navigation();
            endif;
            ?>
        </main><!-- #main -->
    </div><!-- #primary -->

<?php else : ?>
    <?php get_template_part('template-parts/post/content', 'none'); ?>
<?php endif; ?>

<?php
// Sidebar
if ('content-sidebar' == $blog_sidebar_position || 'sidebar-content' == $blog_sidebar_position) {
    get_sidebar();
}
?>
<?php get_footer(); ?>
