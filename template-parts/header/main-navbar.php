<?php
/**
 * Template part for displaying Main Navbar.
 *
 * @package Miteri
 * @since Miteri 1.0
 */
$header_template = sanitize_file_name(get_theme_mod('header_layout', 'header-layout1'));
$show_logo_on_menu = get_theme_mod('logo_on_navenu', 0);
$sticky_navigation_menu = absint(get_theme_mod('sticky_navigation_menu', 1));
$navbar_class = ' navbar-left';
if ($header_template == "header-layout1") {
    $navbar_class = ' ';
}
if ($show_logo_on_menu) {
    $navbar_class .= ' logo-exist';
}
?>
<div class="main-navbar <?php echo ($sticky_navigation_menu) ? 'sticky-nav ' : '';
echo $navbar_class; ?>">
    <div class="container">
        <?php
        if ($show_logo_on_menu) {
            miteri_custom_logo();
        }
        get_template_part('template-parts/navigation/navigation', 'main'); // Main Menu 
        ?>
    </div>
</div>
<?php
get_template_part('template-parts/header/mobile', 'navigation');
