<?php /**
 * Customize controls for repeater field
 *
 * @since 1.0.0
 */
if ( class_exists( 'WP_Customize_Control' ) ) {

	class Miteri_Repeater_Controler extends WP_Customize_Control {
		/**
		 * The control type.
		 *
		 * @access public
		 * @var string
		 */
		public $type = 'repeater';

		public $miteri_box_label = '';

		public $miteri_box_add_control = '';

		/**
		 * The fields that each container row will contain.
		 *
		 * @access public
		 * @var array
		 */
		public $fields = array();

		/**
		 * Repeater drag and drop controller
		 *
		 * @since  1.0.0
		 */
		public function __construct( $manager, $id, $args = array(), $fields = array() ) {

			$this->fields                 = $fields;
			$this->miteri_box_label       = $args['miteri_box_label'];
			$this->miteri_box_add_control = $args['miteri_box_add_control'];
			parent::__construct( $manager, $id, $args );
		}

		public function render_content() {

			$values = json_decode( $this->value() );
			?>
			<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>

			<?php if ( $this->description ) { ?>
				<span class="description customize-control-description">
                    <?php echo wp_kses_post( $this->description ); ?>
                </span>
			<?php } ?>

			<ul class="miteri-repeater-field-control-wrap">
				<?php $this->miteri_get_fields(); ?>
			</ul>

			<input type="hidden" <?php esc_attr( $this->link() ); ?> class="miteri-repeater-collector"
			       value="<?php echo esc_attr( $this->value() ); ?>"/>
			<button type="button"
			        class="button miteri-repeater-add-control-field"><?php echo esc_html( $this->miteri_box_add_control ); ?></button>
			<?php
		}

		private function miteri_get_fields() {
			$fields = $this->fields;
			$values = json_decode( $this->value() );

			if ( is_array( $values ) ) {
				foreach ( $values as $value ) {
					?>
					<li class="miteri-repeater-field-control">
						<h3 class="miteri-repeater-field-title"><?php echo esc_html( $this->miteri_box_label ); ?></h3>

						<div class="miteri-repeater-fields">
							<?php
							foreach ( $fields as $key => $field ) {
								$class = isset( $field['class'] ) ? $field['class'] : '';
								?>
								<div
									class="miteri-repeater-field miteri-repeater-type-<?php echo esc_attr( $field['type'] ) . ' ' . $class; ?>">

									<?php
									$label       = isset( $field['label'] ) ? $field['label'] : '';
									$description = isset( $field['description'] ) ? $field['description'] : '';
									if ( $field['type'] != 'checkbox' ) {
										?>
										<span class="customize-control-title"><?php echo esc_html( $label ); ?></span>
										<span
											class="description customize-control-description"><?php echo esc_html( $description ); ?></span>
										<?php
									}

									$new_value = isset( $value->$key ) ? $value->$key : '';
									$default   = isset( $field['default'] ) ? $field['default'] : '';

									switch ( $field['type'] ) {
										case 'text':
											echo '<input data-default="' . esc_attr( $default ) . '" data-name="' . esc_attr( $key ) . '" type="text" value="' . esc_attr( $new_value ) . '"/>';
											break;

										case 'url':
											echo '<input data-default="' . esc_attr( $default ) . '" data-name="' . esc_attr( $key ) . '" type="text" value="' . esc_url( $new_value ) . '"/>';
											break;

										case 'social_icon':
											echo '<div class="miteri-repeater-selected-icon">';
											echo '<i class="' . esc_attr( $new_value ) . '"></i>';
											echo '<span><i class="fa fa-angle-down"></i></span>';
											echo '</div>';
											echo '<ul class="miteri-repeater-icon-list miteri-clearfix">';
											$miteri_font_awesome_social_icon_array = miteri_font_awesome_social_icon_array();
											foreach ( $miteri_font_awesome_social_icon_array as $miteri_font_awesome_icon ) {
												$icon_class = $new_value == $miteri_font_awesome_icon ? 'icon-active' : '';
												echo '<li class=' . $icon_class . '><i class="' . $miteri_font_awesome_icon . '"></i></li>';
											}
											echo '</ul>';
											echo '<input data-default="' . esc_attr( $default ) . '" type="hidden" value="' . esc_attr( $new_value ) . '" data-name="' . esc_attr( $key ) . '"/>';
											break;

										default:
											break;
									}
									?>
								</div>
								<?php
							} ?>

							<div class="miteri-clearfix miteri-repeater-footer">
								<div class="alignright">
									<a class="miteri-repeater-field-remove"
									   href="#remove"><?php _e( 'Delete', 'miteri' ) ?></a> |
									<a class="miteri-repeater-field-close"
									   href="#close"><?php _e( 'Close', 'miteri' ) ?></a>
								</div>
							</div>
						</div>
					</li>
					<?php
				}
			}
		}
	}
} // end Miteri_Repeater_Controler
/*-----------------------------------------------------------------------------------------------------------------------*/
