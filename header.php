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

<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#main"><?php esc_html_e( 'Skip to content', 'miteri' ); ?></a>
	<header id="masthead" class="site-header <?php if ( get_header_image() ) { echo 'has-header-image'; } ?>" role="banner">
		<?php
			$header_template = sanitize_file_name( get_theme_mod('header_layout', 'header-layout1') );
			get_template_part( 'template-parts/header/' . $header_template );
		?>

	</header><!-- #masthead -->

	<div id="content" class="site-content">
		<div class="container">
			<div class="inside">
