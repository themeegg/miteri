<?php
/**
 * Template part for displaying page content.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Miteri
 * @since Miteri 1.0.8
 */
?>
<section id="blog-box" class="blog-box">
    <div class="container-fluid container"> 
        <div class="row">
            <?php
           wp_reset_postdata();
            $args = array(
                'post_type' => 'post',
                'posts_per_page' => 2,
                'nopaging' => false,
                'paged'=>1,
                'posts_per_archive_page'=>3,
                'posts_status' => 'publish',
            );
            $blog_result = new WP_Query($args);
            echo $blog_result->post_count;
            //miteri_debug($blog_result);
            echo '<div style="clear:both;"></div>';
            if ($blog_result->have_posts()):
                while ($blog_result->have_posts()):
                    $blog_result->the_post();
                    ?>
                    <div class="col-4 col-sm-12 col-md-6">
                        <div class="innerbox-wraper">                             
                            <div class="featured-image">
                                <?php the_post_thumbnail('miteri-cp-700x700'); ?>
                            </div>
                            <div class="btn-wraper">
                                <?php the_category(); ?>
                            </div>
                        </div>
                    </div>
                    <?php
                endwhile;
            endif;
            wp_reset_query();
            ?>
            <div class="clear"></div>
        </div>
    </div>
</section>