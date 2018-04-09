<?php
/**
 * Customizer settings for Important Link Panel
 *
 * @package Theme Egg
 * @subpackage Miteri
 * @since 1.0.0
 */

add_action( 'customize_register', 'miteri_important_link_panel_register' );

function miteri_important_link_panel_register( $wp_customize ) {

	// Theme important links started
	class Miteri_Important_Links extends WP_Customize_Control {

		public $type = "miteri-important-links";

		public function render_content() {
			//Add Theme instruction, Support Forum, Demo Link, Rating Link
			$important_links = array(
				'view-pro'      => array(
					'link' => esc_url( 'https://goo.gl/aJw4YG' ),
					'text' => esc_html__( 'View Pro', 'miteri' ),
				),
				'theme-info'    => array(
					'link' => esc_url( 'https://themeegg.com/downloads/miteri/' ),
					'text' => esc_html__( 'Theme Info', 'miteri' ),
				),
				'support'       => array(
					'link' => esc_url( 'https://themeegg.com/support-forum/' ),
					'text' => esc_html__( 'Support', 'miteri' ),
				),
				'documentation' => array(
					'link' => esc_url( 'https://docs.themeegg.com/miteri/' ),
					'text' => esc_html__( 'Documentation', 'miteri' ),
				),
				'demo'          => array(
					'link' => esc_url( 'https://demo.themeegg.com/themes/miteri/' ),
					'text' => esc_html__( 'View Demo', 'miteri' ),
				),
				'rating'        => array(
					'link' => esc_url( 'https://wordpress.org/support/view/theme-reviews/miteri?filter=5' ),
					'text' => esc_html__( 'Rate this theme', 'miteri' ),
				),
			);
			foreach ( $important_links as $important_link ) {
				echo '<p><a target="_blank" href="' . $important_link['link'] . '" >' . esc_attr( $important_link['text'] ) . ' </a></p>';
			}
		}

	}

	$wp_customize->add_section( 'miteri_important_links', array(
		'priority' => 1,
		'title'    => __( 'Miteri Important Links', 'miteri' ),
	) );

	/**
	 * This setting has the dummy Sanitizaition function as it contains no value to be sanitized
	 */
	$wp_customize->add_setting( 'miteri_important_links', array(
		'capability'        => 'edit_theme_options',
		'sanitize_callback' => 'miteri_links_sanitize',
	) );

	$wp_customize->add_control( new Miteri_Important_Links( $wp_customize, 'important_links', array(
		'label'    => __( 'Important Links', 'miteri' ),
		'section'  => 'miteri_important_links',
		'settings' => 'miteri_important_links',
	) ) );
	// Theme Important Links Ended

}
