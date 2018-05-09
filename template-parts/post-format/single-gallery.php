<?php
/**
 * Template part for displaying single link post format
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package miteri
 */
$gallery                = get_post_gallery( get_the_ID(), false );
$gallery_attachment_ids = isset($gallery['ids']) ? explode( ',', $gallery['ids'] ) : array();
$post_style = get_theme_mod('post_style', 'fimg-classic');
$thumbnail_size = ($post_style=='fimg-banner') ? 'miteri-cp-1200x580' : 'miteri-cp-1200x580';
$post_format = get_post_format();
if ( $post_style == 'fimg-fullwidth' || $post_style == 'fimg-banner' ):
    ?>
    <div class="gallery-image <?php echo ($post_style=='fimg-banner') ? 'gallery-parallax' : '' ; ?>">
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
        <div class="post-format-wraper entry-thumbnail">
			<?php if ( ! empty( $gallery_attachment_ids ) ) : ?>
				<div class="post-format post-format-<?php echo $post_format; ?>">
					<div class="format-<?php echo esc_attr($post_format); ?> owl-carousel">
						<?php foreach ( $gallery_attachment_ids as $gallery_attachment_id ) : ?>
							<div class="post-format-gallery-item swiper-slide">
								<?php 
                                $image_details = wp_get_attachment_image_src($gallery_attachment_id, $thumbnail_size);
                                $image_src=$image_details[0];
                                ?>
                                <figure class="entry-thumbnail <?php echo esc_attr($post_style == 'fimg-banner' ) ? 'css-parallax-window' : ''; ?>" style="background-image:url(<?php echo ($post_style == 'fimg-banner' ) ? esc_url($image_src) : ''; ?>);">
                                        <?php
                                            if($post_style=='fimg-fullwidth'):
                                                echo wp_get_attachment_image( $gallery_attachment_id, $thumbnail_size ); // WPCS xss ok. 
                                            endif;
                                        ?>
                                </figure>
							</div>
						<?php endforeach; ?>
					</div>
					<!-- /.post-format-gallery -->
				</div>
			<?php endif; ?>
		</div>
    </div>
<?php 
else:

endif;