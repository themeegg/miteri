<?php        
$post_style = get_theme_mod('post_style', 'fimg-classic');
$post_banner_thumbnail = ($post_style=='fimg-banner') ? 'full' : 'miteri-cp-1200x580';
$show_post_thumbnail = has_post_thumbnail() && get_theme_mod('post_has_featured_image', 1);
$post_format = get_post_format();
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
            ?>
            </figure>
        <?php endif; // Featured Image ?>
    </div>
<?php endif;