<?php
/**
 * The Header for our theme.
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-template-parts
 *
 * @package Miteri
 * @since Miteri 1.0
 */

?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<?php if ( is_singular() && pings_open( get_queried_object() ) ) : ?>
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
<?php endif; ?>
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
	<?php $website_layout = miteri_website_layout(); ?>
	<div id="page" class="site <?php echo esc_attr($website_layout); ?>-layout">
		<?php 
		/**
		* Back to top
		* @package Theme Egg
		* @subpackage Miteri 
		* @since 1.1.2
		*/	
		$backtotop = get_theme_mod('back_to_top_button');
		if($backtotop){ ?>
			<button onclick="topFunction()" id="myBtn" title="Go to top"><i class="fa fa-angle-up"></i></button><?php 
		} ?>
		<a class="skip-link screen-reader-text" href="#main"><?php esc_html_e( 'Skip to content', 'miteri' ); ?></a>
		<?php
		$show_searchform_onmenu = absint(get_theme_mod('show_searchform_onmenu', 0));
		$header_class = '';
		if(!$show_searchform_onmenu){
			$header_class = ' hide_search ';
		}
		?>
		<header id="masthead" class="site-header <?php echo (get_header_image()) ? ' has-header-image ' : ''; echo esc_attr($header_class); ?>" role="banner">
			<?php get_template_part( 'template-parts/header/header', 'layout' ); ?>


		</header><!-- #masthead -->

		<div id="content" class="site-content">
			<div class="container">
				<div class="inside">
