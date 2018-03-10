<?php

/**
 * Additional features to allow styling of the templates
 *
 * @package ThemeEgg
 * @subpackage Education Master
 * @since 1.0.0
 */
/* ------------------------------------------------------------------------------------------------ */
/**
 * Define font awesome social media icons
 *
 * @return array();
 * @since 1.0.0
 */
if (!function_exists('miteri_font_awesome_social_icon_array')) :

    function miteri_font_awesome_social_icon_array() {
        return array(
            "fa fa-facebook-square",
            "fa fa-facebook-f",
            "fa fa-facebook",
            "fa fa-facebook-official",
            "fa fa-twitter-square",
            "fa fa-twitter",
            "fa fa-yahoo",
            "fa fa-google",
            "fa fa-google-wallet",
            "fa fa-google-plus-circle",
            "fa fa-google-plus-official",
            "fa fa-instagram",
            "fa fa-linkedin-square",
            "fa fa-linkedin",
            "fa fa-pinterest-p",
            "fa fa-pinterest",
            "fa fa-pinterest-square",
            "fa fa-google-plus-square",
            "fa fa-google-plus",
            "fa fa-youtube-square",
            "fa fa-youtube",
            "fa fa-youtube-play",
            "fa fa-vimeo",
            "fa fa-vimeo-square",
        );
    }

endif;

/*
 * website layout
 */
if (!function_exists('miteri_website_layout')) :

    function miteri_website_layout() {
        $website_layout = get_theme_mod('website_layout', 'box');
        return $website_layout;
    }

endif;

/* --------------------------------------------------------------------------------------------------------------- */
/**
 * Social media function
 *
 * @since 1.0.0
 */
if (!function_exists('miteri_social_media')):

    function miteri_social_media() {
        $get_social_media_icons = get_theme_mod('social_media_icons', '');
        $get_decode_social_media = json_decode($get_social_media_icons);
        if (!empty($get_decode_social_media)) {
            echo '<div class="miteri-social-icons-wrapper">';
            foreach ($get_decode_social_media as $single_icon) {
                $icon_class = isset($single_icon->social_icon_class) ? $single_icon->social_icon_class : '';
                $icon_url = isset($single_icon->social_icon_url) ? $single_icon->social_icon_url : '';
                $icon_bg = isset($single_icon->social_icon_bg) ? $single_icon->social_icon_bg : '';
                if (!empty($icon_url)) {
                    echo '<span class="social-link"><a href="' . esc_url($icon_url) . '" target="_blank"><i class="' . esc_attr($icon_class) . '" style="background-color:'.$icon_bg.'"></i></a></span>';
                }
            }
            echo '</div><!-- .miteri-social-icons-wrapper -->';
        }
    }

endif;

if (!function_exists('miteri_debug')):

    function miteri_debug($value, $dump = false) {
        if ($dump) {
            echo "<pre>";
            var_dump($value);
            echo "</pre>";
        } else {
            echo "<pre>";
            print_r($value);
            echo "</pre>";
        }
    }

endif;


if (!function_exists('miteri_lazyload_data')):

    function miteri_lazyload_data() {

        global $wp_query;
        $data_lazyload = array(
            'post_count' => $wp_query->post_count,
            'where' => is_home() ? 'home' : 'category',
        );
        return $data_lazyload;
    }



endif;


/**
 * categories in dropdown
 *
 * @since 1.0.9
 */
if (!function_exists('miteri_category_dropdown')) :

    function miteri_category_dropdown() {
        $miteri_categories = get_categories(array('hide_empty' => 0));
        $miteri_category_dropdown['0'] = esc_html__('Select Category', 'miteri-pro');
        foreach ($miteri_categories as $miteri_category) {
            $miteri_category_dropdown[$miteri_category->term_id] = $miteri_category->cat_name;
        }
        return $miteri_category_dropdown;
    }

endif;

/**
 * Custom function for wp_query args
 * @since 1.0.9
 */
if (!function_exists('miteri_query_args')):

    function miteri_query_args($cat_id, $post_count = null) {
        if (!empty($cat_id)) {
            $miteri_args = array(
                'post_type' => 'post',
                'cat' => $cat_id,
                'posts_per_page' => $post_count
            );
        } else {
            $miteri_args = array(
                'post_type' => 'post',
                'posts_per_page' => $post_count,
                'ignore_sticky_posts' => 1
            );
        }

        return $miteri_args;
    }

endif;

if (!function_exists('miteri_get_categories')):
/**
 * Get all Categories
 */
function miteri_get_categories() {
    $args = array('fields' => 'ids');
    $categories = get_categories();
    $categories_list = array(
        '' => esc_html__('Select Category', 'miteri-pro')
    );
    foreach ($categories as $category) {
        $categories_list['' . $category->term_id . ''] = $category->name;
    }
    return $categories_list;
}
endif;