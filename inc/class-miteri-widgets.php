<?php
defined( 'ABSPATH' ) or exit;

class Miteri_Widgets {

	function __construct() {
		$this->require_files();
		$this->hooks_filters();
	}

	function require_files() {

		require get_template_directory() . '/inc/widgets/class-author-widget.php';
	}

	function widgets_init() {

		register_widget( 'Miteri_Author_Details' );

	}

	function hooks_filters() {
		add_action( 'widgets_init', array( $this, 'widgets_init' ) );
	}

	function __destruct() {

	}

}

new Miteri_Widgets();
