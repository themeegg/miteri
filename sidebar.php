<?php
/**
 * The sidebar containing the main widget area.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-template-parts
 *
 * @package Miteri
 * @since Miteri 1.0
 */

?>

<aside id="secondary" class="sidebar widget-area" role="complementary">
		<?php if ( is_active_sidebar( 'sidebar-1' ) ) { dynamic_sidebar( 'sidebar-1' ); } ?>
</aside><!-- #secondary -->



