<?php
/**
 * Template part for displaying Header.
 *
 * @package Miteri
 * @since Miteri 1.0
 */
?>

<div class="site-title-centered header-layout-1">

	<?php if ( get_header_image() ) { ?>
	<div class="header-image" style="background-image: url(<?php echo esc_url( get_header_image() ); ?>)">
		<div class="header-image-container">
			<?php } ?>

			<div class="site-branding">
				<?php miteri_custom_logo(); ?>
				<?php $description = get_bloginfo( 'description', 'display' );
				if ( $description || is_customize_preview() ) :
					?>
					<p class="site-description"><?php echo esc_html( $description ); ?></p>
				<?php endif;

				$miteri_social_media_header = get_theme_mod( 'miteri_social_media_header', 'enable' );
				if ( $miteri_social_media_header === 'enable' ) {
					miteri_social_media();
				}
				?>

			</div><!-- .site-branding -->


			<?php if ( get_header_image() ) { ?>
		</div>
	</div><!-- .header-image-->
<?php } ?>

	<div class="main-navbar">
		<div class="container">
			<?php get_template_part( 'template-parts/navigation/navigation', 'main' ); // Main Menu ?>
			<?php if ( get_theme_mod( 'show_header_search' ) ) { ?>
				<div class="top-search">
					<span id="top-search-button" class="top-search-button"><i class="search-icon"></i></span>
					<?php get_search_form(); ?>
				</div>
			<?php } // Search Icon ?>
		</div>
	</div>
	<?php get_template_part( 'template-parts/header/mobile', 'navbar' ); ?>
</div>
