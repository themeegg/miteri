<?php

/**
 * Miteri Theme Customizer.
 *
 * @package Miteri
 * @since Miteri 1.0
 */

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function miteri_customize_preview_js() {
    wp_enqueue_script( 'miteri_customizer', get_template_directory_uri() . '/assets/js/customizer.js', array( 'customize-preview' ), '20171005', true );
}

add_action( 'customize_preview_init', 'miteri_customize_preview_js' );
/* ----------------------------------------------------------------------------------------------------------------------- */

/**
 * Enqueue required scripts/styles for customizer panel
 *
 * @since 1.0.0
 */
function miteri_customize_backend_scripts() {

    wp_enqueue_style( 'font-awesome', get_template_directory_uri() . '/assets/lib/font-awesome/css/font-awesome.min.css', array(), '4.7.0' );

    if ( is_rtl() ):
        wp_enqueue_style( 'miteri_admin_customizer_style', get_template_directory_uri() . '/assets/css/miteri-customizer-rtl.css' );
    else:
        wp_enqueue_style( 'miteri_admin_customizer_style', get_template_directory_uri() . '/assets/css/miteri-customizer.css' );
    endif;


    wp_enqueue_script( 'miteri_admin_customizer', get_template_directory_uri() . '/assets/js/miteri-customizer-controls.js', array(
        'jquery',
    ), '20170616', true );
}

add_action( 'customize_controls_enqueue_scripts', 'miteri_customize_backend_scripts', 10 );

/**
 * Theme Settings
 */
function miteri_theme_customizer( $wp_customize ) {

    // Add postMessage support for site title and description for the Theme Customizer.
    $wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
    $wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
    $wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';

    $wp_customize->get_control( 'header_image' )->section = 'header_section';

    // Change default WordPress customizer settings
    $wp_customize->get_control( 'background_color' )->section  = 'colors_general';
    $wp_customize->get_control( 'background_color' )->priority = 1;
    $wp_customize->get_control( 'header_textcolor' )->section  = 'colors_header';
    $wp_customize->get_control( 'header_textcolor' )->priority = 2;
    $wp_customize->get_control( 'header_textcolor' )->label    = esc_html__( 'Site Title', 'miteri' );

    //Retrieve list of Categories
    $blog_categories     = array();
    $blog_categories_obj = get_categories();
    foreach ( $blog_categories_obj as $category ) {
        $blog_categories[ $category->cat_ID ] = $category->cat_name;
    }

    // Miteri Links
    $wp_customize->add_section( 'miteri_links_section', array(
        'priority' => 2,
        'title'    => esc_html__( 'Miteri Links', 'miteri' ),
    ) );

    $wp_customize->add_setting( 'miteri_links', array(
        'capability'        => 'edit_theme_options',
        'sanitize_callback' => 'esc_url_raw',
    ) );

    // Theme Settings
    $wp_customize->add_panel( 'miteri_panel', array(
        'title'    => esc_html__( 'Theme Settings', 'miteri' ),
        'priority' => 10,
    ) );

    // General Section
    $wp_customize->add_section( 'general_section', array(
        'title'    => esc_html__( 'General', 'miteri' ),
        'priority' => 5,
        'panel'    => 'miteri_panel',
    ) );


    // Read More Link
    $wp_customize->add_setting( 'show_read_more', array(
        'default'           => 1,
        'sanitize_callback' => 'miteri_sanitize_checkbox',
    ) );

    $wp_customize->add_control( 'show_read_more', array(
        'label'   => esc_html__( 'Display Read More Link', 'miteri' ),
        'section' => 'general_section',
        'type'    => 'checkbox',
    ) );
    /**
    * Back to top
    * @package Theme Egg
    * @subpackage Miteri 
    * @since 1.1.2
    */  
    $wp_customize->add_setting( 'back_to_top_button', array(
        'default'           => 0,
        'sanitize_callback' => 'miteri_sanitize_checkbox',
    ) );

    $wp_customize->add_control( 'back_to_top_button', array(
        'label'   => esc_html__( 'Display Back To Top Button?', 'miteri' ),
        'section' => 'general_section',
        'type'    => 'checkbox',
    ) );

    // Header Section
    $wp_customize->add_section( 'header_section', array(
        'title'       => esc_html__( 'Header', 'miteri' ),
        'priority'    => 10,
        'panel'       => 'miteri_panel',
        'description' => esc_html__( 'Header settings.', 'miteri' ),
    ) );

    // Show social media on top bar
    $wp_customize->add_setting( 'show_on_branding', array(
        'default'           => 'disble',
        'sanitize_callback' => 'sanitize_text_field',
    ) );

    $wp_customize->add_control( 'show_on_branding', array(
        'label'   => esc_html__( 'Social media on branding?', 'miteri' ),
        'section' => 'header_section',
        'type'    => 'radio',
        'choices' => array(
            'enable' => esc_html__( 'Enable(When no header ads)', 'miteri' ),
            'disble' => esc_html__( 'Disable', 'miteri' ),
        ),
    ) );


    // Header Layout
    $wp_customize->add_setting( 'header_layout', array(
        'default'           => 'header-layout1',
        'sanitize_callback' => 'miteri_sanitize_choices',
    ) );

    $wp_customize->add_control( 'header_layout', array(
        'label'   => esc_html__( 'Style', 'miteri' ),
        'section' => 'header_section',
        'type'    => 'radio',
        'choices' => array(
            'header-layout1' => esc_html__( 'Header Layout 1 (Center align layout)', 'miteri' ),
            'header-layout2' => esc_html__( 'Header Layout 2 (Left align layout)', 'miteri' ),
            'header-layout3' => esc_html__( 'Layout 3(Top Header, Branding and Menu)', 'miteri' ),
        )
    ) );

    // Show Logo On Menu
    $wp_customize->add_setting( 'show_headerimage_parallax', array(
        'default'           => 0,
        'sanitize_callback' => 'absint',
    ) );

    $wp_customize->add_control( 'show_headerimage_parallax', array(
        'label'   => esc_html__( 'Parallax header image', 'miteri' ),
        'section' => 'header_section',
        'type'    => 'checkbox',
    ) );

    // Social Media
    $wp_customize->add_setting( 'miteri_social_media_header', array(
        'default'           => 'enable',
        'sanitize_callback' => 'miteri_sanitize_choices',
    ) );

    $wp_customize->add_control( 'miteri_social_media_header', array(
        'label'   => esc_html__( 'Enable/disable social media on header', 'miteri' ),
        'section' => 'header_section',
        'type'    => 'radio',
        'choices' => array(
            'enable'  => esc_html__( 'Enable', 'miteri' ),
            'disable' => esc_html__( 'Disable', 'miteri' ),
        )
    ) );

    // Show Logo On Menu
    $wp_customize->add_setting( 'show_searchform_onmenu', array(
        'default'           => 0,
        'sanitize_callback' => 'absint',
    ) );

    $wp_customize->add_control( 'show_searchform_onmenu', array(
        'label'   => esc_html__( 'Show Search form on menu', 'miteri' ),
        'section' => 'header_section',
        'type'    => 'checkbox',
    ) );


    //Top Breaking News Label
    $wp_customize->add_setting( 'breaking_news_label', array(
        'default'           => esc_html__( 'Breaking News', 'miteri' ),
        'sanitize_callback' => 'sanitize_text_field',
    ) );

    $wp_customize->add_control( 'breaking_news_label', array(
        'label'   => esc_html__( 'Breaking News Label', 'miteri' ),
        'section' => 'header_section',
        'type'    => 'text',
    ) );

    //Top Header Category
    $wp_customize->add_setting( 'top_header_category', array(
        'default'           => '',
        'sanitize_callback' => 'miteri_sanitize_choices',
    ) );

    $wp_customize->add_control( 'top_header_category', array(
        'label'   => esc_html__( 'Breaking News Category', 'miteri' ),
        'section' => 'header_section',
        'type'    => 'select',
        'choices' => miteri_get_categories(),
    ) );

    // Blog Section
    $wp_customize->add_section( 'blog_section', array(
        'title'       => esc_html__( 'Blog', 'miteri' ),
        'priority'    => 20,
        'panel'       => 'miteri_panel',
        'description' => esc_html__( 'Settings for Blog Posts Index Page.', 'miteri' ),
    ) );

    // Blog Post Layout
    $wp_customize->add_setting( 'blog_layout', array(
        'default'           => 'list',
        'sanitize_callback' => 'miteri_sanitize_choices',
    ) );

    $wp_customize->add_control( 'blog_layout', array(
        'label'   => esc_html__( 'Post Layout', 'miteri' ),
        'section' => 'blog_section',
        'type'    => 'radio',
        'choices' => array(
            'list'  => esc_html__( 'List', 'miteri' ),
            'grid'  => esc_html__( 'Grid', 'miteri' ),
            'large' => esc_html__( 'Large', 'miteri' ),
        )
    ) );

    // Blog Sidebar Position
    $wp_customize->add_setting( 'blog_sidebar_position', array(
        'default'           => 'content-sidebar',
        'sanitize_callback' => 'miteri_sanitize_choices',
    ) );

    $wp_customize->add_control( 'blog_sidebar_position', array(
        'label'   => esc_html__( 'Sidebar Position', 'miteri' ),
        'section' => 'blog_section',
        'type'    => 'select',
        'choices' => array(
            'content-sidebar'   => esc_html__( 'Right Sidebar', 'miteri' ),
            'sidebar-content'   => esc_html__( 'Left Sidebar', 'miteri' ),
            'content-fullwidth' => esc_html__( 'No Sidebar Full width', 'miteri' ),
        )
    ) );

    // Blog Excerpt Length
    $wp_customize->add_setting( 'blog_excerpt_length', array(
        'default'           => 25,
        'sanitize_callback' => 'absint',
    ) );

    $wp_customize->add_control( 'blog_excerpt_length', array(
        'label'   => esc_html__( 'Excerpt length', 'miteri' ),
        'section' => 'blog_section',
        'type'    => 'number',
    ) );

    // Show CTA Section
    $wp_customize->add_setting( 'blog_show_cta', array(
        'default'           => 1,
        'sanitize_callback' => 'absint',
    ) );

    $wp_customize->add_control( 'blog_show_cta', array(
        'label'   => esc_html__( 'Show CTA?', 'miteri' ),
        'section' => 'blog_section',
        'type'    => 'checkbox',
    ) );

    // Lazy Loading
    $wp_customize->add_setting( 'blog_lazy_loading', array(
        'default'           => 0,
        'sanitize_callback' => 'absint',
    ) );

    $wp_customize->add_control( 'blog_lazy_loading', array(
        'label'   => esc_html__( 'Infinite Scrolling?', 'miteri' ),
        'section' => 'blog_section',
        'type'    => 'checkbox',
    ) );

    // Archives Section
    $wp_customize->add_section( 'archive_section', array(
        'title'       => esc_html__( 'Categories & Archives', 'miteri' ),
        'priority'    => 25,
        'panel'       => 'miteri_panel',
        'description' => esc_html__( 'Settings for Category, Tag, Search and Archive Pages.', 'miteri' ),
    ) );
    


    // Archives Post Layout
    $wp_customize->add_setting('archive_layout', array(
        'default'           => 'list',
        'sanitize_callback' => 'miteri_sanitize_choices',
    ) );

    $wp_customize->add_control( 'archive_layout', array(
        'label'   => esc_html__( 'Post Layout', 'miteri' ),
        'section' => 'archive_section',
        'type'    => 'radio',
        'choices' => array(
            'list'  => esc_html__( 'List', 'miteri' ),
            'grid'  => esc_html__( 'Grid', 'miteri' ),
            'large' => esc_html__( 'Large', 'miteri' ),
        )
    ) );

    // Archives Sidebar Position
    $wp_customize->add_setting( 'archive_sidebar_position', array(
        'default'           => 'content-sidebar',
        'sanitize_callback' => 'miteri_sanitize_choices',
    ) );

    $wp_customize->add_control( 'archive_sidebar_position', array(
        'label'   => esc_html__( 'Sidebar Position', 'miteri' ),
        'section' => 'archive_section',
        'type'    => 'select',
        'choices' => array(
            'content-sidebar'   => esc_html__( 'Right Sidebar', 'miteri' ),
            'sidebar-content'   => esc_html__( 'Left Sidebar', 'miteri' ),
            'content-fullwidth' => esc_html__( 'No Sidebar Full width', 'miteri' ),
        )
    ) );

    // Archives Excerpt Length
    $wp_customize->add_setting( 'archive_excerpt_length', array(
        'default'           => 25,
        'sanitize_callback' => 'absint',
    ) );

    $wp_customize->add_control( 'archive_excerpt_length', array(
        'label'   => esc_html__( 'Excerpt length', 'miteri' ),
        'section' => 'archive_section',
        'type'    => 'number',
    ) );
    /**
    * parallax footer
    * @package Theme Egg
    * @subpackage Miteri
    * @since 1.1.2
    */
    // Footer section
    $wp_customize->add_section( 'miteri_footer_section', array(
        'title'       => esc_html__( 'Footer', 'miteri' ),
        'priority'    => 10,
        'panel'       => 'miteri_panel',
        'description' => esc_html__( 'Settings for footer section.', 'miteri' ),
    ) );
    $wp_customize->add_setting( 'miteri_parallax_footer', array(
        'sanitize_callback' => 'esc_url',
    ) );

   $wp_customize->add_control(
       new WP_Customize_Image_Control(
           $wp_customize,
           'miteri_parallax_footer',
           array(
               'label'      => __('Upload Image For Parallax Footer Background', 'miteri' ),
               'section'    => 'miteri_footer_section',
               'settings'   => 'miteri_parallax_footer',
           )
       )
   );

    // Post Section
    $wp_customize->add_section( 'post_section', array(
        'title'    => esc_html__( 'Post', 'miteri' ),
        'priority' => 30,
        'panel'    => 'miteri_panel',
    ) );

    // Feauted Image
    $wp_customize->add_setting( 'post_has_featured_image', array(
        'default'           => 1,
        'sanitize_callback' => 'miteri_sanitize_checkbox',
    ) );

    $wp_customize->add_control( 'post_has_featured_image', array(
        'label'   => esc_html__( 'Display Featured Image', 'miteri' ),
        'section' => 'post_section',
        'type'    => 'checkbox',
    ) );

    // Post Styles
    $wp_customize->add_setting( 'post_style', array(
        'default'           => 'fimg-classic',
        'sanitize_callback' => 'miteri_sanitize_choices',
    ) );

    $wp_customize->add_control( 'post_style', array(
        'label'           => esc_html__( 'Style', 'miteri' ),
        'section'         => 'post_section',
        'type'            => 'radio',
        'choices'         => array(
            'fimg-classic'   => esc_html__( 'Classic Featured Image', 'miteri' ),
            'fimg-fullwidth' => esc_html__( 'Full width Featured Image', 'miteri' ),
            'fimg-banner'    => esc_html__( 'Full width with parallax Image', 'miteri' ),
        ),
        'active_callback' => 'miteri_post_has_featured_image',
    ) );

    // Post Sidebar Position
    $wp_customize->add_setting( 'post_sidebar_position', array(
        'default'           => 'content-sidebar',
        'sanitize_callback' => 'miteri_sanitize_choices',
    ) );

    $wp_customize->add_control( 'post_sidebar_position', array(
        'label'   => esc_html__( 'Sidebar Position', 'miteri' ),
        'section' => 'post_section',
        'type'    => 'select',
        'choices' => array(
            'content-sidebar'   => esc_html__( 'Right Sidebar', 'miteri' ),
            'sidebar-content'   => esc_html__( 'Left Sidebar', 'miteri' ),
            'content-centered'  => esc_html__( 'No Sidebar Centered', 'miteri' ),
            'content-fullwidth' => esc_html__( 'No Sidebar Full width', 'miteri' ),
        )
    ) );

    // Author Bio
    $wp_customize->add_setting( 'show_author_bio', array(
        'default'           => '',
        'sanitize_callback' => 'miteri_sanitize_checkbox',
    ) );

    $wp_customize->add_control( 'show_author_bio', array(
        'label'   => esc_html__( 'Display Author Bio', 'miteri' ),
        'section' => 'post_section',
        'type'    => 'checkbox',
    ) );

    // Page Section
    $wp_customize->add_section( 'page_section', array(
        'title'    => esc_html__( 'Page', 'miteri' ),
        'priority' => 35,
        'panel'    => 'miteri_panel',
    ) );

    // Featured Image
    $wp_customize->add_setting( 'page_has_featured_image', array(
        'default'           => 1,
        'sanitize_callback' => 'miteri_sanitize_checkbox',
    ) );

    $wp_customize->add_control( 'page_has_featured_image', array(
        'label'   => esc_html__( 'Display Featured Image', 'miteri' ),
        'section' => 'page_section',
        'type'    => 'checkbox',
    ) );

    // Page Styles
    $wp_customize->add_setting( 'page_style', array(
        'default'           => 'fimg-classic',
        'sanitize_callback' => 'miteri_sanitize_choices',
    ) );

    $wp_customize->add_control( 'page_style', array(
        'label'           => esc_html__( 'Style', 'miteri' ),
        'section'         => 'page_section',
        'type'            => 'radio',
        'choices'         => array(
            'fimg-classic'   => esc_html__( 'Large Featured Image', 'miteri' ),
            'fimg-fullwidth' => esc_html__( 'Full width Featured Image', 'miteri' ),
            'fimg-banner'    => esc_html__( 'Full width with parallax Image', 'miteri' ),
        ),
        'active_callback' => 'miteri_page_has_featured_image',
    ) );

    // Page Sidebar Position
    $wp_customize->add_setting( 'page_sidebar_position', array(
        'default'           => 'content-sidebar',
        'sanitize_callback' => 'miteri_sanitize_choices',
    ) );

    $wp_customize->add_control( 'page_sidebar_position', array(
        'label'       => esc_html__( 'Sidebar Position', 'miteri' ),
        'description' => esc_html__( 'Sidebar options for Static Pages. To remove the Sidebar apply No Sidebar Template to the Page.', 'miteri' ),
        'section'     => 'page_section',
        'type'        => 'select',
        'choices'     => array(
            'content-sidebar' => esc_html__( 'Right Sidebar', 'miteri' ),
            'sidebar-content' => esc_html__( 'Left Sidebar', 'miteri' ),
        )
    ) );

    // Logo Max Width (desktop)
    $wp_customize->add_setting( 'logo_width_lg', array(
        'default'           => 220,
        'sanitize_callback' => 'absint',
    ) );

    $wp_customize->add_control( 'logo_width_lg', array(
        'label'    => esc_html__( 'Logo Max Width (desktop)', 'miteri' ),
        'section'  => 'title_tagline',
        'type'     => 'number',
        'priority' => 10,
    ) );

    // Logo Max Width (mobile)
    $wp_customize->add_setting( 'logo_width_sm', array(
        'default'           => 180,
        'sanitize_callback' => 'absint',
    ) );

    $wp_customize->add_control( 'logo_width_sm', array(
        'label'    => esc_html__( 'Logo Max Width (mobile)', 'miteri' ),
        'section'  => 'title_tagline',
        'type'     => 'number',
        'priority' => 11,
    ) );

    // Theme Colors
    $wp_customize->add_panel( 'miteri_colors', array(
        'title'    => esc_html__( 'Colors', 'miteri' ),
        'priority' => 15,
    ) );

    // Colors: General
    $wp_customize->add_section( 'colors_general', array(
        'title' => esc_html__( 'General', 'miteri' ),
        'panel' => 'miteri_colors',
    ) );
    // Colors: Header
    $wp_customize->add_section( 'colors_header', array(
        'title' => esc_html__( 'Header', 'miteri' ),
        'panel' => 'miteri_colors',
    ) );

    // Header Background
    $wp_customize->add_setting( 'header_background', array(
        'default'           => '#ffffff',
        'sanitize_callback' => 'sanitize_hex_color',
    ) );

    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'header_background', array(
        'label'    => esc_html__( 'Header Background', 'miteri' ),
        'section'  => 'colors_header',
        'priority' => 1,
    ) ) );

    // Site Tagline Color
    $wp_customize->add_setting( 'site_tagline_color', array(
        'default'           => '#888888',
        'sanitize_callback' => 'sanitize_hex_color',
    ) );

    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'site_tagline_color', array(
        'label'    => esc_html__( 'Site Tagline', 'miteri' ),
        'section'  => 'colors_header',
        'priority' => 3,
    ) ) );


    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'search_icon_color', array(
        'label'    => esc_html__( 'Search Icon', 'miteri' ),
        'section'  => 'colors_header',
        'priority' => 8,
    ) ) );

    // Colors: Footer
    $wp_customize->add_section( 'colors_footer', array(
        'title' => esc_html__( 'Footer', 'miteri' ),
        'panel' => 'miteri_colors',
    ) );

    // Footer Widget Area Background
    $wp_customize->add_setting( 'footer_background', array(
        'default'           => '#1b2126',
        'sanitize_callback' => 'sanitize_hex_color',
    ) );

    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'footer_background', array(
        'label'   => esc_html__( 'Footer Widget Area Background', 'miteri' ),
        'section' => 'colors_footer',
    ) ) );


    // Archives Section
    $wp_customize->add_section( 'layout_section', array(
        'title'       => esc_html__( 'Layout', 'miteri' ),
        'priority'    => 25,
        'panel'       => 'miteri_panel',
        'description' => esc_html__( 'Settings for website layout.', 'miteri' ),
    ) );

    // Archives Post Layout
    $wp_customize->add_setting( 'website_layout', array(
        'default'           => 'box',
        'sanitize_callback' => 'sanitize_miteri_website_layout',
    ) );

    $wp_customize->add_control( 'website_layout', array(
        'label'   => esc_html__( 'Website Layout', 'miteri' ),
        'section' => 'layout_section',
        'type'    => 'radio',
        'choices' => array(
            'box'  => esc_html__( 'Box Width', 'miteri' ),
            'full' => esc_html__( 'Full Width', 'miteri' ),
        )
    ) );

     $wp_customize->add_setting('website_skin', array(
        'default' => 'no_skin',
        'sanitize_callback' => 'sanitize_miteri_website_skin',

     ));

    $wp_customize->add_control('website_skin', array(
        'label' => esc_html__('Website Skin', 'miteri'),
        'section' => 'layout_section',
        'type' => 'radio',
        'choices' => array(
            'no_skin' => esc_html__('Default', 'miteri'),
            'dark_skin' => esc_html__('Dark Skin', 'miteri'),
            'skin_one' => esc_html__('Skin One', 'miteri'),
        )
    ));


    require get_template_directory() . '/inc/customizer/parts/miteri-additional-panel.php';         // Additional Panel


    /* --------------------------------------------- additional settings ------- */


    /* End of additional settings */
}

add_action( 'customize_register', 'miteri_theme_customizer' );

require get_template_directory() . '/inc/customizer/parts/miteri-custom-classes.php';         // Custom Classes


/**
 * Sanitize Checkbox
 *
 */
function miteri_sanitize_checkbox( $input ) {
    if ( $input == 1 ) {
        return 1;
    } else {
        return '';
    }
}

/**
 * Sanitize Radio Buttons and Select Lists
 *
 */
function miteri_sanitize_choices( $input, $setting ) {
    global $wp_customize;

    $control = $wp_customize->get_control( $setting->id );

    if ( array_key_exists( $input, $control->choices ) ) {
        return $input;
    } else {
        return $setting->default;
    }
}

function sanitize_miteri_website_layout( $input, $setting ) {
    global $wp_customize;

    $control = $wp_customize->get_control( $setting->id );

    if ( array_key_exists( $input, $control->choices ) ) {
        return $input;
    } else {
        return $setting->default;
    }
}
function sanitize_miteri_website_skin( $input, $setting ) {
	global $wp_customize;

	$control = $wp_customize->get_control( $setting->id );

	if ( array_key_exists( $input, $control->choices ) ) {
		return $input;
	} else {
		return $setting->default;
	}
}

/**
 * Checks if Single Post has featured image
 */
function miteri_post_has_featured_image( $control ) {
    if ( $control->manager->get_setting( 'post_has_featured_image' )->value() == 1 ) {
        return true;
    } else {
        return false;
    }
}

/**
 * Checks Header Layout
 */
function miteri_header_layout( $control ) {
    if ( $control->manager->get_setting( 'header_layout' )->value() != 'header-layout4' ) {
        return true;
    } else {
        return false;
    }
}

/**
 * Checks if Page has featured image
 */
function miteri_page_has_featured_image( $control ) {
    if ( $control->manager->get_setting( 'page_has_featured_image' )->value() == 1 ) {
        return true;
    } else {
        return false;
    }
}

/**
 * Checks whether a header image is set or not.
 */
function miteri_has_header_image( $control ) {
    if ( has_header_image() ) {
        return true;
    } else {
        return false;
    }
}

/**
 * Get Contrast
 *
 */
function miteri_get_brightness( $hex ) {
    // returns brightness value from 0 to 255
    // strip off any leading #
    $hex = str_replace( '#', '', $hex );

    $c_r = hexdec( substr( $hex, 0, 2 ) );
    $c_g = hexdec( substr( $hex, 2, 2 ) );
    $c_b = hexdec( substr( $hex, 4, 2 ) );

    return ( ( $c_r * 299 ) + ( $c_g * 587 ) + ( $c_b * 114 ) ) / 1000;
}

/**
 * Sanitize repeater value
 *
 * @since 1.0.0
 */
function miteri_sanitize_repeater( $input ) {
    $input_decoded = json_decode( $input, true );

    if ( ! empty( $input_decoded ) ) {
        foreach ( $input_decoded as $boxes => $box ) {
            foreach ( $box as $key => $value ) {
                $input_decoded[ $boxes ][ $key ] = wp_kses_post( $value );
            }
        }

        return json_encode( $input_decoded );
    }

    return $input;
}

/**
 * Add inline CSS for styles handled by the Theme customizer
 *
 */
function miteri_add_styles() {
    $logo_width_desktop   = esc_attr( get_theme_mod( 'logo_width_lg' ) );
    $logo_width_mobile    = esc_attr( get_theme_mod( 'logo_width_sm' ) );
    $header_image_padding = esc_attr( get_theme_mod( 'header_image_padding', 20 ) );
    $header_image_opacity = esc_attr( get_theme_mod( 'header_image_opacity', 40 ) );
    $site_tagline_color   = esc_attr( get_theme_mod( 'site_tagline_color' ) );
    $header_background    = esc_attr( get_theme_mod( 'header_background' ) );
    $footer_background    = esc_attr( get_theme_mod( 'footer_background' ) );

    $custom_styles = "";

    // Custom Logo
    if ( $logo_width_mobile != '' ) {
        $custom_styles .= "
        @media screen and (max-width: 599px) {
        .site-logo .custom-logo {max-width: {$logo_width_mobile}px;}
        }";
    }
    if ( $logo_width_desktop != '' ) {
        $custom_styles .= "
        @media screen and (min-width: 600px) {
        .site-logo .custom-logo {max-width: {$logo_width_desktop}px;}
        }";
    }

    // Header Image Padding
    if ( $header_image_padding != '' ) {
        $custom_styles .= ".header-image {padding-top: {$header_image_padding}px;padding-bottom: {$header_image_padding}px;}";
    }

    // Header Image Opacity
    if ( $header_image_opacity != '' ) {
        $custom_styles .= "
        .header-image:before {opacity: 0.{$header_image_opacity};}
        ";
    }


    // Site Tagline Color
    if ( $site_tagline_color != '' ) {
        $custom_styles .= "#masthead .site-description {color: {$site_tagline_color};}";
    }


    // Header Background Color
    $no_parallax_header = absint( get_theme_mod( 'show_headerimage_parallax', 0 ) ) ? 0 : 1;
    if ( $header_background != '' && $no_parallax_header ) {
        $custom_styles .= ".site-header {background-color: {$header_background};}";
    }


    // Footer Widget Area Background Color
    if ( $footer_background != '' ) {
        $custom_styles .= ".site-footer .widget-area {background-color: {$footer_background};}";

        if ( miteri_get_brightness( $footer_background ) > 155 ) {
            $custom_styles .= "
            .site-footer .widget-area  {
            color: rgba(0,0,0,.7);
            }
            .site-footer .widget-title,
            .site-footer .widget a, .site-footer .widget a:hover {
            color: rgba(0,0,0,.8);
            }
            .site-footer .widget-area ul li {
            border-bottom-color: rgba(0,0,0,.05);
            }
            .site-footer .widget_tag_cloud a {
            border-color: rgba(0,0,0,.05);
            background-color: rgba(0,0,0,.05);
            }";
        }
    }

    if ( $custom_styles != '' ) {
        wp_add_inline_style( 'miteri-style', $custom_styles );
    }
}

add_action( 'wp_enqueue_scripts', 'miteri_add_styles' );
