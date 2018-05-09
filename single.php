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
<?php 
    if (have_posts()) :
        $post_format = get_post_format();
        get_template_part('template-parts/post-format/single', $post_format)  
    ?>
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
