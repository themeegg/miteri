<?php

$wp_customize->add_panel(
        'miteri_additional_settings_panel', array(
    'priority' => 20,
    'capability' => 'edit_theme_options',
    'theme_supports' => '',
    'title' => __('Additional Settings', 'miteri'),
        )
);

/* ----------------------------------------------------------------------------------------------------------------------- */
/**
 * Social Icons Section
 *
 * @since 1.0.0
 */
$wp_customize->add_section(
        'miteri_social_icons_section', array(
    'title' => esc_html__('Social Icons', 'miteri'),
    'panel' => 'miteri_additional_settings_panel',
    'priority' => 5,
        )
);

/**
 * Repeater field for social media icons
 *
 * @since 1.0.0
 */
$wp_customize->add_setting(
        'social_media_icons', array(
    'sanitize_callback' => 'miteri_sanitize_repeater',
    'default' => json_encode(
            array(
                array(
                    'social_icon_class' => 'fa fa-facebook-f',
                    'social_icon_url' => '',
                    'social_icon_bg' => '',
                )
            )
    )
        )
);
$wp_customize->add_control(new Miteri_Repeater_Controler(
        $wp_customize, 'social_media_icons', array(
    'label' => __('Social Media Icons', 'miteri'),
    'section' => 'miteri_social_icons_section',
    'settings' => 'social_media_icons',
    'priority' => 5,
    'miteri_box_label' => __('Social Media Icon', 'miteri'),
    'miteri_box_add_control' => __('Add Icon', 'miteri')
        ), array(
    'social_icon_class' => array(
        'type' => 'social_icon',
        'label' => __('Social Media Logo', 'miteri'),
        'description' => __('Choose social media icon.', 'miteri')
    ),
    'social_icon_url' => array(
        'type' => 'url',
        'label' => __('Social Icon Url', 'miteri'),
        'description' => __('Enter social media url.', 'miteri')
    ),
    'social_icon_bg' => array(
        'type' => 'color',
        'default' => '#214d74',
        'label' => esc_html__('Social Icon Background', 'miteri'),
        'description' => esc_html__('Choose social media icon background color.', 'miteri')
    ),
        )
        )
);
?>
