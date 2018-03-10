<div class="mobile-navbar clear">
    <a id="menu-toggle" class="menu-toggle" href="#mobile-navigation" title="<?php esc_attr_e('Menu', 'miteri'); ?>"><span class="button-toggle"></span></a>
    <?php if (get_theme_mod('show_header_search', 1)) { ?>
        <div class="top-search">
            <span id="top-search-button" class="top-search-button"><i class="search-icon"></i></span>
            <?php get_search_form(); ?>
        </div>
    <?php } // Search Icon  ?>
</div>
<div id="mobile-sidebar" class="mobile-sidebar">
    <?php
    $show_logo_on_menu = get_theme_mod('logo_on_navenu', 0);
    if ($show_logo_on_menu) {
        miteri_custom_logo();
    }
    ?>
    <div class="mobile-navbar">
        <a id="mobile-menu-toggle" class="menu-toggle" href="#mobile-navigation" title="<?php esc_attr_e('Menu', 'miteri'); ?>"><span class="button-toggle"></span></a>
    </div>
    <nav id="mobile-navigation" class="main-navigation mobile-navigation" role="navigation" aria-label="<?php esc_attr_e('Main Menu', 'miteri'); ?>"></nav>
</div>