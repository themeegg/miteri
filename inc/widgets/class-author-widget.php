<?php
/* ----------------------------------------------------------------------------------- */
/* 	Author Widget Class
  /*----------------------------------------------------------------------------------- */
if ( ! class_exists( 'Miteri_Author_Details' ) ) {

	class Miteri_Author_Details extends WP_Widget {

		private $users_split_at = 200; //Do not run get_users() if there are more than 200 users on the website
		public $defaults;

		public function __construct() {

			$widget_ops = array(
				'classname'                   => 'miteri_author_details',
				'description'                 => esc_html__( 'Use this widget to display author/user profile Details', 'miteri' ),
				'customize_selective_refresh' => true
			);

			parent::__construct( 'miteri_author_details', esc_html__( 'Author Details', 'miteri' ), $widget_ops );

			//Allow themes or plugins to modify default parameters
			$author_detauls_params = array(
				'title'             => esc_attr__( 'Author', 'miteri' ),
				'author'            => 0,
				'auto_detect'       => 0,
				'display_avatar'    => 1,
				'display_desc'      => 1,
				'display_all_posts' => 1,
				'avatar_size'       => 120,
				'link_text'         => esc_attr__( 'View all posts', 'miteri' ),
				'limit_chars'       => '',
				'designation'       => esc_attr__( 'CEO / Co-Founder', 'miteri' ),
			);

			$defaults = apply_filters( 'miteri_author_details_modify_defaults', $author_detauls_params );

			$this->defaults = $defaults;
		}

		public function widget( $args, $instance ) {

			$before_widget = isset( $args['before_widget'] ) ? $args['before_widget'] : '';
			$after_widget  = isset( $args['after_widget'] ) ? $args['after_widget'] : '';

			$before_title = isset( $args['before_title'] ) ? $args['before_title'] : '';
			$after_title  = isset( $args['after_title'] ) ? $args['after_title'] : '';

			$instance          = wp_parse_args( (array) $instance, $this->defaults );
			$title             = isset( $instance['title'] ) ? sanitize_text_field( $instance['title'] ) : '';
			$author            = absint( $instance['author'] );
			$display_avatar    = isset( $instance['display_avatar'] ) ? absint( $instance['display_avatar'] ) : 0;
			$display_desc      = isset( $instance['display_desc'] ) ? absint( $instance['display_desc'] ) : 0;
			$display_all_posts = isset( $instance['display_all_posts'] ) ? absint( $instance['display_all_posts'] ) : 0;
			$show_social_media = isset( $instance['show_social_media'] ) ? absint( $instance['show_social_media'] ) : 0;
			$link_text         = isset( $instance['link_text'] ) ? strip_tags( $instance['link_text'] ) : '';
			$avatar_size       = ! empty( $instance['avatar_size'] ) ? absint( $instance['avatar_size'] ) : 120;
			$limit_chars       = isset( $instance['limit_chars'] ) ? absint( $instance['limit_chars'] ) : 0;
			$designation       = isset( $instance['designation'] ) ? sanitize_text_field( $instance['designation'] ) : '';


			//Check for user_id
			$user_id = $author;

			$author_link = ! empty( $instance['link_url'] ) ? esc_url( $instance['link_url'] ) : get_author_posts_url( get_the_author_meta( 'ID', $user_id ) );

			echo $before_widget;

			if ( ! empty( $instance['title'] ) ) {

				$title = apply_filters( 'widget_title', $title, $instance, $this->id_base );

				echo $before_title . $title . $after_title;
			}
			?>
			<div class="card card-profile">
				<?php if ( $display_avatar ) { ?>
					<div class="card-avatar">
						<?php echo get_avatar( get_the_author_meta( 'ID', $user_id ), $avatar_size ); ?>
					</div>
				<?php } ?>
				<div class="card-content">
					<?php if ( $show_social_media ) { ?>
						<?php miteri_social_media(); ?>
					<?php } ?>
					<?php if ( ! empty( $designation ) ): ?>
						<h5 class="category text-gray"><?php echo $designation ?></h5>
					<?php endif; ?>
					<?php echo '<h4 class="card-title">' . get_the_author_meta( 'display_name', $user_id ) . '</h4>'; ?>
					<?php if ( $display_desc ) : ?>
						<p class="card-description">
							<?php $description = get_the_author_meta( 'description', $user_id ); ?>
							<?php echo wpautop( $this->trim_chars( $description, $limit_chars, $user_id ) ); ?>
						</p>
					<?php endif; ?>
					<?php if ( $display_all_posts && $link_text ) : ?>
						<a href="<?php echo $author_link; ?>"
						   class="button secondary radius "><?php echo $link_text; ?></a>
					<?php endif; ?>
				</div>
			</div>
			<?php echo $after_widget; ?>
			<?php
		}

		public function update( $new_instance, $old_instance ) {

			$instance                      = $old_instance;
			$instance['title']             = sanitize_text_field( $new_instance['title'] );
			$instance['author']            = absint( $new_instance['author'] );
			$instance['display_avatar']    = isset( $new_instance['display_avatar'] ) ? absint( $new_instance['display_avatar'] ) : 0;
			$instance['display_desc']      = isset( $new_instance['display_desc'] ) ? absint( $new_instance['display_desc'] ) : 0;
			$instance['display_all_posts'] = isset( $new_instance['display_all_posts'] ) ? absint( $new_instance['display_all_posts'] ) : 0;
			$instance['link_text']         = strip_tags( $new_instance['link_text'] );
			$instance['avatar_size']       = ! empty( $new_instance['avatar_size'] ) ? absint( $new_instance['avatar_size'] ) : 120;
			$instance['limit_chars']       = isset( $new_instance['limit_chars'] ) ? absint( $new_instance['limit_chars'] ) : '';
			$instance['designation']       = isset( $new_instance['designation'] ) ? sanitize_text_field( $new_instance['designation'] ) : '';
			$instance['show_social_media'] = isset( $new_instance['show_social_media'] ) ? absint( $new_instance['show_social_media'] ) : 0;

			return $instance;
		}

		public function form( $instance ) {
			$instance          = wp_parse_args( (array) $instance, $this->defaults );
			$title             = isset( $instance['title'] ) ? sanitize_text_field( $instance['title'] ) : '';
			$author            = absint( $instance['author'] );
			$display_avatar    = isset( $instance['display_avatar'] ) ? absint( $instance['display_avatar'] ) : 0;
			$display_desc      = isset( $instance['display_desc'] ) ? absint( $instance['display_desc'] ) : 0;
			$display_all_posts = isset( $instance['display_all_posts'] ) ? absint( $instance['display_all_posts'] ) : 0;
			$show_social_media = isset( $instance['show_social_media'] ) ? absint( $instance['show_social_media'] ) : 0;
			$link_text         = isset( $instance['link_text'] ) ? strip_tags( $instance['link_text'] ) : '';
			$avatar_size       = ! empty( $instance['avatar_size'] ) ? absint( $instance['avatar_size'] ) : 120;
			$limit_chars       = isset( $instance['limit_chars'] ) ? absint( $instance['limit_chars'] ) : 0;
			$designation       = isset( $instance['designation'] ) ? sanitize_text_field( $instance['designation'] ) : '';
			?>

			<p>
				<label
					for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title', 'miteri' ); ?></label>
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"
				       name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text"
				       value="<?php echo esc_attr( $title ); ?>"/>
			</p>
			<p>
				<?php if ( $this->count_users() <= $this->users_split_at ) : ?>
					<?php $authors = get_users(); ?>
					<label
						for="<?php echo $this->get_field_id( 'author' ); ?>"><?php esc_html_e( 'Choose author/user', 'miteri' ); ?>
						:</label>
					<select name="<?php echo $this->get_field_name( 'author' ); ?>"
					        id="<?php echo $this->get_field_id( 'author' ); ?>" class="widefat">
						<?php foreach ( $authors as $author_value ) : ?>
							<option
								value="<?php echo $author_value->ID; ?>" <?php selected( $author_value->ID, $author ); ?>><?php echo $author_value->data->user_login; ?></option>
						<?php endforeach; ?>
					</select>
				<?php else: ?>
					<label
						for="<?php echo $this->get_field_id( 'author' ); ?>"><?php esc_html_e( 'Enter author/user ID', 'miteri' ); ?>
						:</label>
					<input id="<?php echo $this->get_field_id( 'author' ); ?>" type="text"
					       name="<?php echo $this->get_field_name( 'author' ); ?>"
					       value="<?php echo $author; ?>" class="small-text"/>
				<?php endif; ?>
			</p>

			<p>
				<label
					for="<?php echo esc_attr( $this->get_field_id( 'designation' ) ); ?>"><?php esc_html_e( 'Author designation', 'miteri' ); ?></label>
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'designation' ) ); ?>"
				       name="<?php echo esc_attr( $this->get_field_name( 'designation' ) ); ?>" type="text"
				       value="<?php echo esc_attr( $designation ); ?>"/>
			</p>

			<h4><?php esc_html_e( 'Display Options', 'miteri' ); ?></h4>
			<ul>
				<li>
					<input id="<?php echo $this->get_field_id( 'display_avatar' ); ?>" type="checkbox"
					       name="<?php echo $this->get_field_name( 'display_avatar' ); ?>"
					       value="1" <?php checked( 1, $display_avatar ); ?>/>
					<label
						for="<?php echo $this->get_field_id( 'display_avatar' ); ?>"><?php esc_html_e( 'Display author avatar', 'miteri' ); ?></label>
				</li>
				<li>
					<label
						for="<?php echo $this->get_field_id( 'avatar_size' ); ?>"><?php esc_html_e( 'Avatar size:', 'miteri' ); ?></label>
					<input id="<?php echo $this->get_field_id( 'avatar_size' ); ?>" type="number"
					       name="<?php echo $this->get_field_name( 'avatar_size' ); ?>"
					       value="<?php echo $avatar_size; ?>" class="small-text"/>
				</li>
			</ul>

			<hr/>
			<ul>
				<li>
					<input id="<?php echo $this->get_field_id( 'display_desc' ); ?>" type="checkbox"
					       name="<?php echo $this->get_field_name( 'display_desc' ); ?>"
					       value="1" <?php checked( 1, $display_desc ); ?>/>
					<label
						for="<?php echo $this->get_field_id( 'display_desc' ); ?>"><?php esc_html_e( 'Display author description', 'miteri' ); ?></label>
				</li>
				<li>
					<label
						for="<?php echo $this->get_field_id( 'limit_chars' ); ?>"><?php esc_html_e( 'Limit description:', 'miteri' ); ?></label>
					<input id="<?php echo $this->get_field_id( 'limit_chars' ); ?>" type="number"
					       name="<?php echo $this->get_field_name( 'limit_chars' ); ?>"
					       value="<?php echo $limit_chars; ?>" class="widefat"/>
					<small
						class="howto"><?php esc_html_e( 'Specify number of characters to limit author description length', 'miteri' ); ?></small>
				</li>
			</ul>

			<hr/>
			<ul>
				<li>
					<input id="<?php echo $this->get_field_id( 'display_all_posts' ); ?>" type="checkbox"
					       name="<?php echo $this->get_field_name( 'display_all_posts' ); ?>"
					       value="1" <?php checked( 1, $display_all_posts ); ?>/>
					<label
						for="<?php echo $this->get_field_id( 'display_all_posts' ); ?>"><?php esc_html_e( 'Display author "all posts" archive link', 'miteri' ); ?></label>
				</li>
				<li>
					<input id="<?php echo $this->get_field_id( 'show_social_media' ); ?>" type="checkbox"
					       name="<?php echo $this->get_field_name( 'show_social_media' ); ?>"
					       value="1" <?php checked( 1, $show_social_media ); ?>/>
					<label
						for="<?php echo $this->get_field_id( 'show_social_media' ); ?>"><?php esc_html_e( 'Show Social media', 'miteri' ); ?></label>
				</li>
				<li>
					<label
						for="<?php echo $this->get_field_id( 'link_text' ); ?>"><?php esc_html_e( 'Link text:', 'miteri' ); ?></label>
					<input id="<?php echo $this->get_field_id( 'link_text' ); ?>" type="text"
					       name="<?php echo $this->get_field_name( 'link_text' ); ?>"
					       value="<?php echo $link_text; ?>" class="widefat"/>
					<small
						class="howto"><?php esc_html_e( 'Specify text for "all posts" link if you want to show separate link', 'miteri' ); ?></small>
				</li>

			</ul>


			<?php do_action( 'miteri_author_details_add_opts', $this, $instance ); ?>
			<?php
		}

		/* Check total number of users on the website */

		public function count_users() {
			$user_count = count_users();
			if ( isset( $user_count['total_users'] ) && ! empty( $user_count['total_users'] ) ) {
				return $user_count['total_users'];
			}

			return 0;
		}

		/**
		 * Limit character description
		 *
		 * @param string $string Content to trim
		 * @param int $limit Number of characters to limit
		 * @param string $more Chars to append after trimmed string
		 *
		 * @return string Trimmed part of the string
		 */
		public function trim_chars( $string, $limit, $more = '...' ) {
			if ( ! empty( $limit ) ) {
				$text = trim( preg_replace( "/[\n\r\t ]+/", ' ', $string ), ' ' );
				preg_match_all( '/./u', $text, $chars );
				$chars = $chars[0];
				$count = count( $chars );

				if ( $count > $limit ) {
					$chars = array_slice( $chars, 0, $limit );

					for ( $i = ( $limit - 1 ); $i >= 0; $i -- ) {
						if ( in_array( $chars[ $i ], array( '.', ' ', '-', '?', '!' ) ) ) {
							break;
						}
					}

					$chars  = array_slice( $chars, 0, $i );
					$string = implode( '', $chars );
					$string = rtrim( $string, ".,-?!" );
					$string .= $more;
				}
			}

			return $string;
		}

	}

}
