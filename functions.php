<?php
/**
 * Miteri functions and definitions.
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Miteri
 * @since Miteri 1.0
 */
define('MITERI_PARENT_DIR', get_template_directory());
define('MITERI_CHILD_DIR', get_stylesheet_directory());

define('MITERI_INCLUDES_DIR', MITERI_PARENT_DIR . '/inc');

if (!function_exists('miteri_setup')) :

    /**
     * Sets up theme defaults and registers support for various WordPress features.
     *
     * Note that this function is hooked into the after_setup_theme hook, which
     * runs before the init hook. The init hook is too late for some features, such
     * as indicating support for post thumbnails.
     */
    function miteri_setup() {

        // Make theme available for translation. Translations can be filed in the /languages/ directory
        load_theme_textdomain('miteri', get_template_directory() . '/languages');

        // Add default posts and comments RSS feed links to head.
        add_theme_support('automatic-feed-links');

        // Let WordPress manage the document title
        add_theme_support('title-tag');

        // Enable support for Post Thumbnail
        add_theme_support('post-thumbnails');
        add_image_size('miteri-cp-520x400', 520, 400, true);
        add_image_size('miteri-cp-700x700', 450, 450, true);
        add_image_size('miteri-cp-800x500', 800, 500, true);
        add_image_size('miteri-cp-1200x580', 1200, 580, true);

        // Set the default content width.
        $GLOBALS['content_width'] = 1160;

        // This theme uses wp_nav_menu() in one location.
        register_nav_menus(array(
            'main_menu' => esc_html__('Main Menu', 'miteri'),
        ));
        /*
         * Switch default core markup for search form, comment form, and comments
         * to output valid HTML5.
         */
        add_theme_support('html5', array('comment-form', 'comment-list', 'gallery', 'caption'));

        // Enable support for Post Formats
        add_theme_support('post-formats', array('image', 'video', 'audio', 'gallery', 'quote'));

        // Enable support for custom logo.
        add_theme_support('custom-logo', array(
            'height' => 400,
            'width' => 400,
            'flex-height' => true,
        ));

        // Set up the WordPress Custom Background Feature.
        $defaults = array(
            'default-color' => '#ffffff',
            'default-image' => '',
        );
        add_theme_support('custom-background', $defaults);

        // This theme styles the visual editor to resemble the theme style,
        add_editor_style(array('assets/css/editor-style.css', miteri_fonts_url()));

        // Custom template tags for this theme
        require get_template_directory() . '/inc/template-tags.php';
        /**
         * Additional features to allow styling of the templates.
         */
        require get_template_directory() . '/inc/template-functions.php';

        // Theme Customizer
        require get_template_directory() . '/inc/customizer/customizer.php';

        // Load Jetpack compatibility file
        require get_template_directory() . '/inc/jetpack.php';
    }

endif;
add_action('after_setup_theme', 'miteri_setup');


if (!function_exists('miteri_fonts_url')) :

    /**
     * Register Google fonts.
     *
     * @return string Google fonts URL for the theme.
     */
    function miteri_fonts_url() {
        $fonts_url = '';
        $fonts = array();
        $subsets = 'latin,latin-ext';

        /* translators: If there are characters in your language that are not supported by Nunito Sans, translate this to 'off'. Do not translate into your own language. */
        if ('off' !== _x('on', 'Open Sans: on or off', 'miteri')) {
            $fonts[] = 'Open Sans:400,700,300,400italic,700italic';
        }

        /* translators: If there are characters in your language that are not supported by Poppins, translate this to 'off'. Do not translate into your own language. */
        if ('off' !== _x('on', 'Poppins: on or off', 'miteri')) {
            $fonts[] = 'Open Sans:400,700';
        }

        /* translators: To add an additional character subset specific to your language, translate this to 'greek', 'cyrillic', 'devanagari' or 'vietnamese'. Do not translate into your own language. */
        $subset = _x('no-subset', 'Add new subset (greek, cyrillic, devanagari, vietnamese)', 'miteri');

        if ('cyrillic' == $subset) {
            $subsets .= ',cyrillic,cyrillic-ext';
        } elseif ('greek' == $subset) {
            $subsets .= ',greek,greek-ext';
        } elseif ('devanagari' == $subset) {
            $subsets .= ',devanagari';
        } elseif ('vietnamese' == $subset) {
            $subsets .= ',vietnamese';
        }

        if ($fonts) {
            $fonts_url = add_query_arg(array(
                'family' => urlencode(implode('|', $fonts)),
                'subset' => urlencode($subsets),
                    ), '//fonts.googleapis.com/css');
        }

        return $fonts_url;
    }

endif;

/**
 * Enqueue scripts and styles.
 */
function miteri_scripts() {

    // Add Google Fonts
    wp_enqueue_style('miteri-fonts', miteri_fonts_url(), array(), null);

    // Add Material Icons
    wp_enqueue_style('font-awesome', get_template_directory_uri() . '/assets/lib/font-awesome/css/font-awesome.css', array(), '4.7');

    wp_enqueue_style('miteri-default-style', get_template_directory_uri() . '/assets/css/miteri.css', array(), '1.0.0');

    // Theme stylesheet
    wp_enqueue_style('miteri-style', get_stylesheet_uri(), array(), '1.0.0');

    wp_localize_script('jquery', 'miteri_global_object', array('ajax_url' => admin_url('admin-ajax.php')));

    wp_enqueue_script('miteri-skip-link-focus-fix', get_template_directory_uri() . '/assets/js/skip-link-focus-fix.js', array(), '20151215', true);

    if (is_singular() && comments_open() && get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }

    wp_enqueue_script('jquery-masonry');

    wp_enqueue_script('miteri-script', get_template_directory_uri() . '/assets/js/main.js', array('jquery'), '20171003', true);
}

add_action('wp_enqueue_scripts', 'miteri_scripts');

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function miteri_widgets_init() {
    register_sidebar(array(
        'name' => esc_html__('Sidebar', 'miteri'),
        'id' => 'sidebar-1',
        'description' => esc_html__('Add widgets here to appear in your sidebar.', 'miteri'),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget' => '</section>',
        'before_title' => '<h3 class="widget-title"><span>',
        'after_title' => '</span></h3>',
    ));
    register_sidebar(array(
        'name' => esc_html__('Footer Widget Area 1', 'miteri'),
        'id' => 'footer-1',
        'description' => esc_html__('Add widgets here to appear in your footer.', 'miteri'),
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget' => '</aside>',
        'before_title' => '<h3 class="widget-title"><span>',
        'after_title' => '</span></h3>',
    ));
    register_sidebar(array(
        'name' => esc_html__('Footer Widget Area 2', 'miteri'),
        'id' => 'footer-2',
        'description' => esc_html__('Add widgets here to appear in your footer.', 'miteri'),
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget' => '</aside>',
        'before_title' => '<h3 class="widget-title"><span>',
        'after_title' => '</span></h3>',
    ));
    register_sidebar(array(
        'name' => esc_html__('Footer Widget Area 3', 'miteri'),
        'id' => 'footer-3',
        'description' => esc_html__('Add widgets here to appear in your footer.', 'miteri'),
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget' => '</aside>',
        'before_title' => '<h3 class="widget-title"><span>',
        'after_title' => '</span></h3>',
    ));
}

add_action('widgets_init', 'miteri_widgets_init');


/**
 * Implement the Custom Header feature.
 */
require get_parent_theme_file_path('/inc/custom-header.php');

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 *
 * @return array
 */
function miteri_body_classes($classes) {
    // Adds a class of group-blog to blogs with more than 1 published author.
    if (is_multi_author()) {
        $classes[] = 'group-blog';
    }

    // Adds a class of hfeed to non-singular pages.
    if (!is_singular()) {
        $classes[] = 'hfeed';
    }

    $header_layout = esc_attr(get_theme_mod('header_layout', 'header-layout1'));
    $blog_sidebar_position = get_theme_mod('blog_sidebar_position', 'content-sidebar');
    $archive_sidebar_position = get_theme_mod('archive_sidebar_position', 'content-sidebar');
    $post_sidebar_position = esc_attr(get_theme_mod('post_sidebar_position', 'content-sidebar'));
    $post_style = esc_attr(get_theme_mod('post_style', 'fimg-classic'));
    $page_sidebar_position = esc_attr(get_theme_mod('page_sidebar_position', 'content-sidebar'));
    $page_style = esc_attr(get_theme_mod('page_style', 'fimg-classic'));

    // Adds a class for Header Layout
    $classes[] = $header_layout;

    // Adds a class to Posts
    if (is_single()) {
        $classes[] = $post_style;
    }

    // Adds a class to Pages
    if (is_page()) {
        $classes[] = $page_style;
    }

    // Check if there is no Sidebar.
    if (!is_active_sidebar('sidebar-1')) {
        $classes[] = 'has-no-sidebar';
    } else {
        if (is_home()) {
            $classes[] = $blog_sidebar_position;
        }
        if (is_archive() || is_search()) {
            $classes[] = $archive_sidebar_position;
        }
        if (is_single()) {
            $classes[] = $post_sidebar_position;
        }
        if (is_page() && !is_home()) {
            $classes[] = $page_sidebar_position;
        }
    }

    return $classes;
}

add_filter('body_class', 'miteri_body_classes');

/**
 * // Set the default content width.
 *
 */
function miteri_fallback_menu() {
    $home_url = esc_url(home_url('/'));
    echo '<ul class="main-menu"><li><a href="' . esc_url($home_url) . '" rel="home">' . esc_html__('Home', 'miteri') . '</a></li></ul>';
}

/**
 * Display Custom Logo
 *
 */
function miteri_custom_logo() {

    if (is_front_page() && is_home()) {
        if (function_exists('the_custom_logo') && has_custom_logo()) {
            ?>
            <h1 class="site-title site-logo"><?php the_custom_logo(); ?></h1>
        <?php } else { ?>
            <h1 class="site-title"><a href="<?php echo esc_url(home_url('/')); ?>"
                                      rel="home"><?php bloginfo('name'); ?></a></h1>
                <?php
            }
        } else {
            if (function_exists('the_custom_logo') && has_custom_logo()) {
                ?>
            <p class="site-title site-logo"><?php the_custom_logo(); ?></p>
        <?php } else { ?>
            <p class="site-title"><a href="<?php echo esc_url(home_url('/')); ?>"
                                     rel="home"><?php bloginfo('name'); ?></a></p>
                <?php
            }
        }
    }

    /**
     * Filter the except length.
     *
     */
    function miteri_excerpt_length($excerpt_length) {

        if (is_admin()) {
            return $excerpt_length;
        }

        if (is_home()) {
            $excerpt_length = get_theme_mod('blog_excerpt_length', 25);
        } elseif (is_archive() || is_search()) {
            $excerpt_length = get_theme_mod('archive_excerpt_length', 25);
        } else {
            $excerpt_length = 25;
        }

        return intval($excerpt_length);
    }

    add_filter('excerpt_length', 'miteri_excerpt_length', 999);

    /**
     * Filter the "read more" excerpt string link to the post.
     *
     * @param string $more "Read more" excerpt string.
     */
    function miteri_excerpt_more($more) {
        if (is_admin()) {
            return $more;
        }
        if (get_theme_mod('show_read_more', 1)) {
            $more = sprintf('<span class="read-more-link"><a class="read-more" href="%1$s">%2$s</a></span>', esc_url(get_permalink(get_the_ID())), esc_html__('Read More', 'miteri')
            );

            return $more;
        }
    }

    add_filter('excerpt_more', 'miteri_excerpt_more');

    /**
     * Blog: Post Templates
     *
     */
    function miteri_blog_template() {
        $blog_layout = get_theme_mod('blog_layout', 'list');
        if ('list' == $blog_layout) {
            return sanitize_file_name('list');
        } elseif ('grid' == $blog_layout) {
            return sanitize_file_name('grid');
        } else {
            return;
        }
    }

    /**
     * Blog: Post Columns
     *
     */
    function miteri_blog_column() {
        $blog_layout = get_theme_mod('blog_layout', 'list');
        $blog_sidebar_position = get_theme_mod('blog_sidebar_position', 'content-sidebar');

        if ('list' == $blog_layout) {
            if (!is_active_sidebar('sidebar-1') || 'content-fullwidth' == $blog_sidebar_position) {
                $blog_column = 'col-6 col-sm-6';
            } else {
                $blog_column = 'col-12';
            }
        } elseif ('grid' == $blog_layout) {
            if (!is_active_sidebar('sidebar-1') || 'content-fullwidth' == $blog_sidebar_position) {
                $blog_column = 'col-4 col-sm-6';
            } else {
                $blog_column = 'col-6 col-sm-6';
            }
        } else {
            $blog_column = 'col-12';
        }

        return ( $blog_column );
    }

    /**
     * Archive: Post Templates
     *
     */
    function miteri_archive_template() {
        $archive_layout = get_theme_mod('archive_layout', 'list');
        if ('list' == $archive_layout) {
            return sanitize_file_name('list');
        } elseif ('grid' == $archive_layout) {
            return sanitize_file_name('grid');
        } else {
            return;
        }
    }

    /**
     * Archive: Post Columns
     *
     */
    function miteri_archive_column() {
        $archive_layout = get_theme_mod('archive_layout', 'list');
        $archive_sidebar_position = get_theme_mod('archive_sidebar_position', 'content-sidebar');

        if ('list' == $archive_layout) {
            if (!is_active_sidebar('sidebar-1') || 'content-fullwidth' == $archive_sidebar_position) {
                $archive_column = 'col-6 col-sm-6';
            } else {
                $archive_column = 'col-12';
            }
        } elseif ('grid' == $archive_layout) {
            if (!is_active_sidebar('sidebar-1') || 'content-fullwidth' == $archive_sidebar_position) {
                $archive_column = 'col-4 col-sm-6';
            } else {
                $archive_column = 'col-6 col-sm-6';
            }
        } else {
            $archive_column = 'col-12';
        }

        return ( $archive_column );
    }

    /**
     * Exclude Featured Posts from the Main Loop
     */
    if (get_theme_mod('show_featured_posts') && get_theme_mod('exclude_featured_posts', 1)) {

        function miteri_get_featured_posts_ids() {
            $featured_posts_cat = absint(get_theme_mod('featured_posts_category', get_option('default_category')));
            $featured_posts_ids = array();

            $featured_posts = get_posts(array(
                'get_post' => 'post',
                'posts_per_page' => 5,
                'orderby' => 'date',
                'order' => 'DESC',
                'cat' => $featured_posts_cat,
                'ignore_sticky_posts' => true,
            ));

            if ($featured_posts) {
                foreach ($featured_posts as $post) :
                    $featured_posts_ids[] = $post->ID;
                endforeach;
                wp_reset_postdata();
            }

            return $featured_posts_ids;
        }

        function miteri_exclude_featured_posts($query) {
            if ($query->is_main_query() && $query->is_home()) {
                $query->set('post__not_in', miteri_get_featured_posts_ids());
            }
        }

        add_action('pre_get_posts', 'miteri_exclude_featured_posts');
    }

    if (!function_exists('miteri_lazy_load_post')):

        function miteri_lazy_load_post() {

            $lazy_load_data = isset($_POST['lozyload']) ? wp_unslash($_POST['lozyload']) : array();
            $offset = isset($lazy_load_data['offset']) ? absint($lazy_load_data['offset']) : 0;
            $posts_per_page = isset($lazy_load_data['post_count']) ? absint($lazy_load_data['post_count']) : 0;
            $post_template = miteri_blog_template();
            $post_column = miteri_blog_column();
            $lazy_load_args = array(
                'post_type' => 'post',
                'post_status' => 'publish',
                'offset' => $offset,
                'posts_per_page' => $posts_per_page,
            );
            $lazy_load_query = new WP_Query($lazy_load_args);
            if ($lazy_load_query->have_posts()):
                ?>
            <div class="miteri-ajax-wraper">
                <?php
                while ($lazy_load_query->have_posts()):
                    $lazy_load_query->the_post();
                    ?>
                    <div class="post-wrapper <?php echo esc_attr($post_column); ?>">
                        <?php get_template_part('template-parts/post/content', $post_template); ?>
                    </div>
                    <?php
                endwhile;
                ?>
            </div>
            <?php
        endif;
        wp_die();
    }

endif;
add_action('wp_ajax_lazy_load_post', 'miteri_lazy_load_post');
add_action('wp_ajax_nopriv_lazy_load_post', 'miteri_lazy_load_post');

/**
 * Prints Credits in the Footer
 */
function miteri_credits() {
    $website_credits = '';
    $website_author = get_bloginfo('name');
    $website_date = date_i18n(esc_html__('Y', 'miteri'));
    $website_credits = '&copy; ' . $website_date . ' ' . $website_author;
    echo esc_html($website_credits);
}

require_once( MITERI_INCLUDES_DIR . '/class-miteri-widgets.php' );

/**
 * Load TGMPA Configs.
 */
require_once( MITERI_INCLUDES_DIR . '/tgm-plugin-activation/class-tgm-plugin-activation.php' );

require_once( MITERI_INCLUDES_DIR . '/tgm-plugin-activation/tgmpa-miteri.php' );
