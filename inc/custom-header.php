<?php
/**
 * Custom header implementation
 *
 * @link https://codex.wordpress.org/Custom_Headers
 *
 * @package Miteri
 * @since Miteri 1.0
 *


/**
 * Set up the WordPress core custom header feature.
 *
 * @uses miteri_header_style()
 */
function miteri_custom_header_setup() {
	add_theme_support( 'custom-header', apply_filters( 'miteri_custom_header_args', array(
		'default-image'          => '',
		'default-text-color'     => '222222',
		'width'                  => 1600,
		'height'                 => 960,
		'flex-height'            => true,
		'wp-head-callback'       => 'miteri_header_style',
	) ) );
}
add_action( 'after_setup_theme', 'miteri_custom_header_setup' );

if ( ! function_exists( 'miteri_header_style' ) ) :
/**
 * Styles the header image and text displayed on the blog.
 *
 * @see miteri_custom_header_setup().
 */
function miteri_header_style() {
	$header_text_color = get_header_textcolor();

	/*
	 * If no custom options for text are set, let's bail.
	 * get_header_textcolor() options: Any hex value, 'blank' to hide text. Default: add_theme_support( 'custom-header' ).
	 */
	if ( get_theme_support( 'custom-header', 'default-text-color' ) === $header_text_color ) {
		return;
	}

	// If we get this far, we have custom styles. Let's do this.
	?>
	<style miteri="text/css">
	<?php
		// Has the text been hidden?
		if ( ! display_header_text() ) :
	?>
		.site-title,
		.site-description {
			position: absolute;
			clip: rect(1px, 1px, 1px, 1px);
		}
	<?php
		// If the user has set a custom color for the text use that.
		else :
	?>
		#masthead .site-branding h1.site-title a, #masthead .site-branding h1.site-title a:hover {
			color: #<?php echo esc_attr( $header_text_color ); ?>;
		}
	<?php endif; ?>
	</style>
	<?php
}
endif;
