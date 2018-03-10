<?php
/**
 * Template part for displaying Site Branding.
 *
 * @package Miteri
 * @since Miteri 1.0
 */
$header_template = sanitize_file_name(get_theme_mod('header_layout', 'header-layout1'));
$branding_class = ' left-brand';
if ($header_template == "header-layout1") {
    $branding_class = ' center-brand';
}

$show_logo_on_menu = get_theme_mod('logo_on_navenu', 0);
$logo_class = ' logo-exist';
if ($show_logo_on_menu) {
    $logo_class = '';
}
?>
<div class="site-branding <?php echo $logo_class; ?>">
    <div class="container">
        <div class="<?php echo $branding_class; ?>">
            <?php
            if (!$show_logo_on_menu) {
                miteri_custom_logo();

                $description = get_bloginfo('description', 'display');
                if ($description || is_customize_preview()) :
                    ?>
                    <p class="site-description"><?php echo $description; ?></p>
                    <?php
                endif;
            }
            ?>
        </div>
        <?php
        if (is_active_sidebar('header-1')):
            dynamic_sidebar('header-1');
        else:
            $show_on_branding = get_theme_mod('show_on_branding', 'disable');
            if ($show_on_branding == 'enable') {
                //get_template_part('template-parts/snipits/miteri-social', 'icons');
                miteri_social_media();
            }
        endif;
        ?>
        <div class="clear"></div>
    </div>
</div><!-- .site-branding -->