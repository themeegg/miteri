<?php
if (!class_exists('Miteri_Slider')) {
    /**
     * Miteri: Post Slider (Grid)
     *
     * Widget show block posts in grid layout
     *
     * @package Theme Egg
     * @subpackage Miteri
     * @since 1.0.0
     */
    class Miteri_Slider extends WP_Widget {

        /**
         * Register widget with WordPress.
         */
        public function __construct() {
            $widget_ops = array(
                'classname' => 'miteri_banner',
                'description' => esc_html__('Display block posts in grid layout.', 'miteri')
            );
            parent::__construct('miteri_banner', esc_html__('Post Slider', 'miteri'), $widget_ops);
        }

        /**
         * Helper function that holds widget fields
         * Array is used in update and form functions
         */
        private function widget_fields() {

            $miteri_grid_columns = miteri_bootstrap_grid();

            $miteri_category_dropdown = miteri_category_dropdown();

            $fields = array(
                'title' => array(
                    'miteri_widgets_name' => 'title',
                    'miteri_widgets_title' => esc_html__('Title', 'miteri'),
                    'miteri_widgets_field_type' => 'text'
                ),
                'miteri_slider_category' => array(
                    'miteri_widgets_name' => 'miteri_slider_category',
                    'miteri_widgets_title' => esc_html__('Category for slider', 'miteri'),
                    'miteri_widgets_default' => 0,
                    'miteri_widgets_field_type' => 'select',
                    'miteri_widgets_field_options' => $miteri_category_dropdown
                ),
                'miteri_no_of_slide' => array(
                    'miteri_widgets_name' => 'miteri_no_of_slide',
                    'miteri_widgets_title' => esc_html__('No. of Posts', 'miteri'),
                    'miteri_widgets_default' => 4,
                    'miteri_widgets_field_type' => 'number'
                ),
                'miteri_read_more_text' => array(
                    'miteri_widgets_name' => 'miteri_read_more_text',
                    'miteri_widgets_title' => esc_html__('Read More', 'miteri'),
                    'miteri_widgets_default' => '',
                    'miteri_widgets_field_type' => 'text'
                ),
                'miteri_show_full_height' => array(
                    'miteri_widgets_name' => 'miteri_show_full_height',
                    'miteri_widgets_title' => esc_html__('Full Height', 'miteri'),
                    'miteri_widgets_default' => 0,
                    'miteri_widgets_field_type' => 'checkbox'
                ),
                'miteri_widget_width' => array(
                    'miteri_widgets_name' => 'miteri_widget_width',
                    'miteri_widgets_title' => esc_html__('Width', 'miteri'),
                    'miteri_widgets_default' => 'container',
                    'miteri_widgets_field_type' => 'select',
                    'miteri_widgets_field_options' => array(
                        'container' => esc_html__('Box Width', 'miteri'),
                        'container-fluid' => esc_html__('Full Width', 'miteri'),
                    ),
                ),
            );

            return $fields;
        }

        /**
         * Front-end display of widget.
         *
         * @see WP_Widget::widget()
         *
         * @param array $args Widget arguments.
         * @param array $instance Saved values from database.
         */
        public function widget($args, $instance) {
            extract($args);
            if (empty($instance)) {
                return;
            }
            $title = apply_filters('widget_title', empty($instance['title']) ? '' : $instance['title'], $instance, $this->id_base);
            $miteri_slider_category = isset($instance['miteri_slider_category']) ? absint($instance['miteri_slider_category']) : '';
            $miteri_no_of_slide = isset($instance['miteri_no_of_slide']) ? absint($instance['miteri_no_of_slide']) : 4;
            $miteri_read_more_text = empty($instance['miteri_read_more_text']) ? '' : sanitize_text_field($instance['miteri_read_more_text']);
            $miteri_show_full_height = isset($instance['miteri_show_full_height']) ? absint($instance['miteri_show_full_height']) : 0;
            $miteri_widget_width = isset($instance['miteri_widget_width']) ? sanitize_text_field($instance['miteri_widget_width']) : 'container';
            echo $before_widget;
            if ($title) {
                echo $args['before_title'] . $title . $args['after_title'];
            }
            ?>
            <div class="slides_wraper <?php echo $miteri_widget_width; ?>">
                <div class="row">
                    <div class="slider_home owl-carousel miteri-slider-carousel">
                        <?php
                        $block_grid_args = miteri_query_args($miteri_slider_category, $miteri_no_of_slide);
                        $block_grid_query = new WP_Query($block_grid_args);
                        if ($block_grid_query->have_posts()) {
                            while ($block_grid_query->have_posts()) {
                                $block_grid_query->the_post();
                                ?>
                                <div class="single_slider <?php echo ($miteri_show_full_height) ? 'miteri-full-height' : ''; ?>" style="background-image:url('<?php the_post_thumbnail_url(); ?>');">
                                    <div class="slider_item_tb">
                                        <div class="slider_item_tbcell">
                                            <div class="container">
                                                <div class="row">
                                                    <div class="col-md-12 col-12">
                                                        <h2 class="wow fadeInDown" data-wow-delay="0.3s"><?php the_title(); ?></h2>
                                                        <div class="short-description wow fadeInRight" data-wow-delay="0.6s">
                                                            <?php the_excerpt(); ?>
                                                        </div>
                                                        <?php if ($miteri_read_more_text) { ?> 
                                                            <div class="slider_btn wow fadeInDown" data-wow-delay="0.9s">
                                                                <a href="<?php the_permalink(); ?>" class="slider_btn_one"><?php echo $miteri_read_more_text; ?></a>
                                                            </div>
                                                        <?php } ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php
                            }
                        }
                        ?>
                        <?php wp_reset_postdata(); ?>
                    </div>
                </div>
            </div>

            <?php
            echo $after_widget;
        }

        /**
         * Sanitize widget form values as they are saved.
         *
         * @see     WP_Widget::update()
         *
         * @param   array $new_instance Values just sent to be saved.
         * @param   array $old_instance Previously saved values from database.
         *
         * @uses    miteri_widgets_updated_field_value()     defined in miteri-widget-fields.php
         *
         * @return  array Updated safe values to be saved.
         */
        public function update($new_instance, $old_instance) {

            $instance                           = $old_instance;
            $instance['title']                  =  isset( $new_instance['title'] ) ? sanitize_text_field( $new_instance['title'] ) : '';
            $instance['miteri_slider_category'] = isset( $new_instance['miteri_slider_category'] ) ? absint($new_instance['miteri_slider_category']) : 0;
            $instance['miteri_no_of_slide']     = isset( $new_instance['miteri_no_of_slide'] ) ? absint( $new_instance['miteri_no_of_slide'] ) : 4;
            $instance['miteri_read_more_text']  = isset( $new_instance['miteri_read_more_text'] ) ? sanitize_text_field( $new_instance['miteri_read_more_text'] ) : '';
            $instance['miteri_show_full_height'] = isset( $new_instance['miteri_show_full_height'] ) ? absint( $new_instance['miteri_show_full_height'] ) : 0;
            $instance['miteri_widget_width']       = isset( $new_instance['miteri_widget_width'] ) ? sanitize_text_field( $new_instance['miteri_widget_width'] ) : 'container';

            return $instance;
        }

        /**
         * Back-end widget form.
         *
         * @see     WP_Widget::form()
         *
         * @param   array $instance Previously saved values from database.
         *
         * @uses    miteri_widgets_show_widget_field()       defined in miteri-widget-fields.php
         */
        public function form($instance) {

            $title                  =  isset( $instance['title'] ) ? sanitize_text_field( $instance['title'] ) : '';
            $miteri_slider_category = isset( $instance['miteri_slider_category'] ) ? absint($instance['miteri_slider_category']) : 0;
            $miteri_no_of_slide     = isset( $instance['miteri_no_of_slide'] ) ? absint( $instance['miteri_no_of_slide'] ) : 4;
            $miteri_read_more_text  = isset( $instance['miteri_read_more_text'] ) ? sanitize_text_field( $instance['miteri_read_more_text'] ) : '';
            $miteri_show_full_height = isset( $instance['miteri_show_full_height'] ) ? absint( $instance['miteri_show_full_height'] ) : 0;
            $miteri_widget_width       = isset( $instance['miteri_widget_width'] ) ? sanitize_text_field( $instance['miteri_widget_width'] ) : 'container';

           ?>
           <p>
                <label
                    for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title', 'miteri' ); ?></label>
                <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"
                       name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text"
                       value="<?php echo esc_attr( $title ); ?>"/>
            </p>
            <p>
                <label
                    for="<?php echo esc_attr( $this->get_field_id( 'miteri_slider_category' ) ); ?>"><?php esc_html_e('Category for slider', 'miteri'); ?></label>
                <select class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'miteri_slider_category' ) ); ?>"
                       name="<?php echo esc_attr( $this->get_field_name( 'miteri_slider_category' ) ); ?>">
                    <?php
                        $miteri_category_dropdown = miteri_category_dropdown();
                        foreach ($miteri_category_dropdown as $cat_id => $cat_title) { ?>
                           <option value="<?php echo absint($cat_id); ?>" <?php selected($miteri_slider_category, $cat_id, true) ?>><?php echo $cat_title; ?></option>
                    <?php 
                        } 
                    ?>
                </select>
            </p>
             <p>
                <label
                    for="<?php echo esc_attr( $this->get_field_id( 'miteri_no_of_slide' ) ); ?>"><?php esc_html_e('No. of Posts', 'miteri'); ?></label>
                <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'miteri_no_of_slide' ) ); ?>"
                       name="<?php echo esc_attr( $this->get_field_name( 'miteri_no_of_slide' ) ); ?>" type="number"
                       value="<?php echo esc_attr( $miteri_no_of_slide ); ?>"/>
            </p>
            <p>
                <label
                    for="<?php echo esc_attr( $this->get_field_id( 'miteri_read_more_text' ) ); ?>"><?php esc_html_e( 'Read More Text', 'miteri' ); ?></label>
                <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'miteri_read_more_text' ) ); ?>"
                       name="<?php echo esc_attr( $this->get_field_name( 'miteri_read_more_text' ) ); ?>" type="text"
                       value="<?php echo esc_attr( $miteri_read_more_text ); ?>"/>
            </p>
            <p>
                <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'miteri_show_full_height' ) ); ?>"
                       name="<?php echo esc_attr( $this->get_field_name( 'miteri_show_full_height' ) ); ?>" <?php checked( $miteri_show_full_height, 1, true ); ?> type="checkbox" value="1"/>
                <label for="<?php echo esc_attr( $this->get_field_id( 'miteri_show_full_height' ) ); ?>"><?php esc_html_e('Full Height', 'miteri'); ?></label>
            </p>

             <p>
                <label for="<?php echo esc_attr( $this->get_field_id( 'miteri_widget_width' ) ); ?>"><?php esc_html_e('Full Width', 'miteri'); ?></label>
                <select class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'miteri_widget_width' ) ); ?>"
                       name="<?php echo esc_attr( $this->get_field_name( 'miteri_widget_width' ) ); ?>" type="text"
                       value="<?php echo esc_attr( $miteri_widget_width ); ?>">
                       <?php
                            $widget_width = array(
                                'container' => 'Box Width',
                                'container-fluid' => 'Full Width',
                            );
                            foreach($widget_width as $width_class=>$width_title){
                       ?>
                       <option value="<?php echo $width_class; ?>" <?php echo selected($miteri_widget_width, $width_class, true); ?> ><?php echo $width_title; ?></option>
                       <?php 
                        } 
                   ?>
                </select>
            </p>
            <?php
        }

    }

}