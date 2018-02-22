<?php
/**
 * Template part for displaying single posts.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Miteri
 * @since Miteri 1.0
 */
// Sidebar Options
$post_sidebar_position = get_theme_mod('post_sidebar_position', 'content-sidebar');
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

    <?php if (get_theme_mod('post_style', 'fimg-classic') == 'fimg-classic') : ?>	
        <header class="entry-header">
            <div class="entry-meta entry-category">
                <span class="cat-links"><?php the_category(', '); ?></span>
            </div>
            <?php the_title('<h1 class="entry-title"><span>', '</span></h1>'); ?>
            <div class="entry-meta">
                <?php miteri_posted_on(); ?>
            </div>
        </header><!-- .entry-header -->
    <?php endif; ?>	

    <?php if (has_post_thumbnail() && get_theme_mod('post_has_featured_image', 1) && get_theme_mod('post_style', 'fimg-classic') == 'fimg-classic') : ?>
        <figure class="entry-thumbnail">
            <?php
            if ('content-centered' == $post_sidebar_position || 'content-fullwidth' == $post_sidebar_position) {
                the_post_thumbnail('miteri-cp-1200x580');
            } else {
                the_post_thumbnail('miteri-cp-800x500');
            }
            ?>
        </figure>
    <?php endif; // Featured Image ?>

    <div class="entry-content">
        <?php
        the_content();
        wp_link_pages(array(
            'before' => '<div class="page-links"><span>' . esc_html__('Pages:', 'miteri') . '</span>',
            'after' => '</div>',
        ));
        ?>
    </div><!-- .entry-content -->

    <footer class="entry-footer">
        <?php miteri_entry_footer(); ?>
    </footer><!-- .entry-footer -->

</article><!-- #post-## -->

<?php
// Author bio.
if (get_theme_mod('show_author_bio') && is_single() && get_the_author_meta('description')) {
    get_template_part('template-parts/post/author-bio');
}
?>
