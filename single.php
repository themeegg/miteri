<?php
/**
 * The template for displaying all single posts.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package Miteri
 * @since Miteri 1.0
 */
// Sidebar Options
$post_sidebar_position = get_theme_mod('post_sidebar_position', 'content-sidebar');

get_header();
?>
<?php if (have_posts()) :
        $post_style = get_theme_mod('post_style', 'fimg-classic');
        $post_banner_thumbnail = ($post_style=='fimg-banner') ? 'full' : 'miteri-cp-1200x580';
        $show_post_thumbnail = has_post_thumbnail() && get_theme_mod('post_has_featured_image', 1);
        if ( $post_style == 'fimg-fullwidth' || $post_style == 'fimg-banner' ):
        ?>
        <div class="featured-image <?php echo ($show_post_thumbnail) ? ' has_featured_image' : ''; ?>">
            <div class="entry-header">
                <div class="entry-meta entry-category">
                    <span class="cat-links"><?php the_category(', '); ?></span>
                </div>
                <?php the_title('<h1 class="entry-title"><span>', '</span></h1>'); ?>
                <div class="entry-meta">
                    <span class="posted-on">
                        <?php the_time(get_option('date_format')); ?>
                    </span>
                </div>
            </div>
            <?php if ($show_post_thumbnail) : ?>
                <figure class="entry-thumbnail <?php echo esc_attr($post_style == 'fimg-banner' ) ? 'parallax-window' : ''; ?>" <?php echo ($post_style=='fimg-banner') ? 'data-parallax="scroll" data-image-src="'.get_the_post_thumbnail_url(get_the_ID(), $post_banner_thumbnail).'"' : ''; ?>>
                    <?php
                    if($post_style=='fimg-fullwidth'):
                        the_post_thumbnail($post_banner_thumbnail); 
                    endif;
                     //the_post_thumbnail($post_banner_thumbnail); 
                    ?>
                </figure>
            <?php endif; // Featured Image ?>
        </div>
    <?php endif; ?>
    <div id="primary" class="content-area">
        <main id="main" class="site-main" role="main">
            <?php
            while (have_posts()) : the_post();
                get_template_part('template-parts/post/content', 'single');
                the_post_navigation();
                // If comments are open or we have at least one comment, load up the comment template.
                if (comments_open() || get_comments_number()) :
                    comments_template();
                endif;
            endwhile; // End of the loop.
            ?>
        </main><!-- #main -->
    </div><!-- #primary -->
<?php 
endif; 
// Sidebar
if ('content-sidebar' == $post_sidebar_position || 'sidebar-content' == $post_sidebar_position) {
    get_sidebar();
}
get_footer();
