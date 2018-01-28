<?php
/**
 * Additional features to allow styling of the templates
 *
 * @package ThemeEgg
 * @subpackage Education Master
 * @since 1.0.0
 */

/*------------------------------------------------------------------------------------------------*/
/**
 * Define font awesome social media icons
 *
 * @return array();
 * @since 1.0.0
 */
if ( ! function_exists( 'miteri_font_awesome_social_icon_array' ) ) :
	function miteri_font_awesome_social_icon_array() {
		return array(
			"fa fa-facebook-square",
			"fa fa-facebook-f",
			"fa fa-facebook",
			"fa fa-facebook-official",
			"fa fa-twitter-square",
			"fa fa-twitter",
			"fa fa-yahoo",
			"fa fa-google",
			"fa fa-google-wallet",
			"fa fa-google-plus-circle",
			"fa fa-google-plus-official",
			"fa fa-instagram",
			"fa fa-linkedin-square",
			"fa fa-linkedin",
			"fa fa-pinterest-p",
			"fa fa-pinterest",
			"fa fa-pinterest-square",
			"fa fa-google-plus-square",
			"fa fa-google-plus",
			"fa fa-youtube-square",
			"fa fa-youtube",
			"fa fa-youtube-play",
			"fa fa-vimeo",
			"fa fa-vimeo-square",
		);
	}
endif;
/*---------------------------------------------------------------------------------------------------------------*/
/**
 * Social media function
 *
 * @since 1.0.0
 */

if ( ! function_exists( 'miteri_social_media' ) ):
	function miteri_social_media() {
		$get_social_media_icons  = get_theme_mod( 'social_media_icons', '' );
		$get_decode_social_media = json_decode( $get_social_media_icons );
		if ( ! empty( $get_decode_social_media ) ) {
			echo '<div class="miteri-social-icons-wrapper">';
			foreach ( $get_decode_social_media as $single_icon ) {
				$icon_class = $single_icon->social_icon_class;
				$icon_url   = $single_icon->social_icon_url;
				if ( ! empty( $icon_url ) ) {
					echo '<span class="social-link"><a href="' . esc_url( $icon_url ) . '" target="_blank"><i class="' . esc_attr( $icon_class ) . '"></i></a></span>';
				}
			}
			echo '</div><!-- .miteri-social-icons-wrapper -->';
		}
	}
endif;
