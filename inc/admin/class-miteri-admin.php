<?php
/**
 * Miteri Admin Class.
 *
 * @author  ThemeEgg
 * @package Miteri
 * @since   1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Miteri_Admin' ) ) :

	/**
	 * Miteri_Admin Class.
	 */
	class Miteri_Admin {

		/**
		 * Constructor.
		 */
		public function __construct() {
			add_action( 'admin_menu', array( $this, 'admin_menu' ) );
			add_action( 'wp_loaded', array( __CLASS__, 'hide_notices' ) );
			add_action( 'load-themes.php', array( $this, 'admin_notice' ) );
		}

		/**
		 * Add admin menu.
		 */
		public function admin_menu() {
			$theme = wp_get_theme( get_template() );

			$page = add_theme_page( esc_html__( 'About', 'miteri' ) . ' ' . $theme->display( 'Name' ), esc_html__( 'About', 'miteri' ) . ' ' . $theme->display( 'Name' ), 'activate_plugins', 'miteri-welcome', array(
				$this,
				'welcome_screen'
			) );
			add_action( 'admin_print_styles-' . $page, array( $this, 'enqueue_styles' ) );
		}

		/**
		 * Enqueue styles.
		 */
		public function enqueue_styles() {
			global $miteri_version;

			wp_enqueue_style( 'miteri-welcome-admin', get_template_directory_uri() . '/inc/admin/css/welcome-admin.css', array(), $miteri_version );
		}

		/**
		 * Add admin notice.
		 */
		public function admin_notice() {
			global $miteri_version, $pagenow;
			wp_enqueue_style( 'miteri-message', get_template_directory_uri() . '/inc/admin/css/admin-notices.css', array(), $miteri_version );

			// Let's bail on theme activation.
			if ( 'themes.php' == $pagenow && isset( $_GET['activated'] ) ) {
				add_action( 'admin_notices', array( $this, 'welcome_notice' ) );
				update_option( 'miteri_admin_notice_welcome', 1 );

				// No option? Let run the notice wizard again..
			} elseif ( ! get_option( 'miteri_admin_notice_welcome' ) ) {
				add_action( 'admin_notices', array( $this, 'welcome_notice' ) );
			}
		}

		/**
		 * Hide a notice if the GET variable is set.
		 */
		public static function hide_notices() {
			if ( isset( $_GET['miteri-hide-notice'] ) && isset( $_GET['_miteri_notice_nonce'] ) ) {
				if ( ! wp_verify_nonce( wp_unslash( $_GET['_miteri_notice_nonce'] ), 'miteri_hide_notices_nonce' ) ) {
					wp_die( esc_html__( 'Action failed. Please refresh the page and retry.', 'miteri' ) );
				}

				if ( ! current_user_can( 'manage_options' ) ) {
					wp_die( esc_html__( 'Cheatin&#8217; huh?', 'miteri' ) );
				}

				$hide_notice = sanitize_text_field( wp_unslash( $_GET['miteri-hide-notice'] ) );
				update_option( 'miteri_admin_notice_' . $hide_notice, 1 );
			}
		}

		/**
		 * Show welcome notice.
		 */
		public function welcome_notice() {
			?>
			<div id="message" class="updated miteri-message">
				<a class="miteri-message-close notice-dismiss"
				   href="<?php echo esc_url( wp_nonce_url( remove_query_arg( array( 'activated' ), add_query_arg( 'miteri-hide-notice', 'welcome' ) ), 'miteri_hide_notices_nonce', '_miteri_notice_nonce' ) ); ?>"><?php esc_html_e( 'Dismiss', 'miteri' ); ?></a>
				<p><?php
					/* translators: 1: anchor tag start, 2: anchor tag end*/
					printf( esc_html__( 'Welcome! Thank you for choosing miteri! To fully take advantage of the best our theme can offer please make sure you visit our %1$swelcome page%1$s.', 'miteri' ), '<a href="' . esc_url( admin_url( 'themes.php?page=miteri-welcome' ) ) . '">', '</a>' );
					?></p>
				<p class="submit">
					<a class="button-secondary"
					   href="<?php echo esc_url( admin_url( 'themes.php?page=miteri-welcome' ) ); ?>"><?php esc_html_e( 'Get started with Miteri', 'miteri' ); ?></a>
				</p>
			</div>
			<?php
		}

		/**
		 * Intro text/links shown to all about pages.
		 *
		 * @access private
		 */
		private function intro() {
			global $miteri_version;
			$theme = wp_get_theme( get_template() );

			// Drop minor version if 0
			$major_version = substr( $miteri_version, 0, 3 );
			?>
			<div class="miteri-theme-info">
				<h1>
					<?php esc_html_e( 'About', 'miteri' ); ?>
					<?php echo esc_html( $theme->display( 'Name' ) ); ?>
					<?php printf( '%s', $major_version ); ?>
				</h1>

				<div class="welcome-description-wrap">
					<div class="about-text"><?php echo esc_html( $theme->display( 'Description' ) ); ?></div>

					<div class="miteri-screenshot">
						<img src="<?php echo esc_url( get_template_directory_uri() ) . '/screenshot.png'; ?>"/>
					</div>
				</div>
			</div>

			<p class="miteri-actions">
				<a href="<?php echo esc_url( 'https://themeegg.com/downloads/miteri/' ); ?>"
				   class="button button-secondary" target="_blank"><?php esc_html_e( 'Theme Info', 'miteri' ); ?></a>

				<a href="<?php echo esc_url( apply_filters( 'miteri_theme_url', 'http://demo.themeegg.com/themes/miteri/' ) ); ?>"
				   class="button button-secondary docs"
				   target="_blank"><?php esc_html_e( 'View Demo', 'miteri' ); ?></a>

				<a href="<?php echo esc_url( apply_filters( 'miteri_rate_url', 'https://wordpress.org/support/view/theme-reviews/miteri?filter=5#postform' ) ); ?>"
				   class="button button-secondary docs"
				   target="_blank"><?php esc_html_e( 'Rate this theme', 'miteri' ); ?></a>
				<a href="<?php echo esc_url( apply_filters( 'miteri_pro_theme_url', 'https://themeegg.com/downloads/miteri-pro-wordpress-theme/' ) ); ?>"
				   class="button button-primary docs"
				   target="_blank"><?php esc_html_e( 'View Pro Version', 'miteri' ); ?></a>
			</p>

			<h2 class="nav-tab-wrapper">
				<a class="nav-tab <?php if ( empty( $_GET['tab'] ) && $_GET['page'] == 'miteri-welcome' ) {
					echo 'nav-tab-active';
				} ?>"
				   href="<?php echo esc_url( admin_url( add_query_arg( array( 'page' => 'miteri-welcome' ), 'themes.php' ) ) ); ?>">
					<?php echo $theme->display( 'Name' ); ?>
				</a>
				<a class="nav-tab <?php if ( isset( $_GET['tab'] ) && $_GET['tab'] == 'changelog' ) {
					echo 'nav-tab-active';
				} ?>" href="<?php echo esc_url( admin_url( add_query_arg( array(
					'page' => 'miteri-welcome',
					'tab'  => 'changelog'
				), 'themes.php' ) ) ); ?>">
					<?php esc_html_e( 'Changelog', 'miteri' ); ?>
				</a>
				<a class="nav-tab <?php if ( isset( $_GET['tab'] ) && $_GET['tab'] == 'freevspro' ) {
					echo 'nav-tab-active';
				} ?>" href="<?php echo esc_url( admin_url( add_query_arg( array(
					'page' => 'miteri-welcome',
					'tab'  => 'freevspro'
				), 'themes.php' ) ) ); ?>">
					<?php esc_html_e( 'Free Vs Pro', 'miteri' ); ?>
				</a>
			</h2>
			<?php
		}

		/**
		 * Welcome screen page.
		 */
		public function welcome_screen() {
			$current_tab = empty( $_GET['tab'] ) ? 'about' : sanitize_title( wp_unslash( $_GET['tab'] ) );

			// Look for a {$current_tab}_screen method.
			if ( is_callable( array( $this, $current_tab . '_screen' ) ) ) {
				return $this->{$current_tab . '_screen'}();
			}

			// Fallback to about screen.
			return $this->about_screen();
		}

		/**
		 * Output the about screen.
		 */
		public function about_screen() {
			$theme = wp_get_theme( get_template() );
			?>
			<div class="wrap about-wrap">

				<?php $this->intro(); ?>

				<div class="changelog point-releases">
					<div class="under-the-hood two-col">

						<div class="col">
							<h3><?php esc_html_e( 'Theme Customizer', 'miteri' ); ?></h3>
							<p><?php esc_html_e( 'All Theme Options are available via Customize screen.', 'miteri' ) ?></p>
							<p><a href="<?php echo admin_url( 'customize.php' ); ?>"
							      class="button button-secondary"><?php esc_html_e( 'Customize', 'miteri' ); ?></a>
							</p>
						</div>

						<div class="col">
							<h3><?php esc_html_e( 'Documentation', 'miteri' ); ?></h3>
							<p><?php esc_html_e( 'Please view our documentation page to setup the theme.', 'miteri' ) ?></p>
							<p><a href="<?php echo esc_url( 'http://docs.themeegg.com/docs/miteri/' ); ?>"
							      class="button button-secondary"><?php esc_html_e( 'Documentation', 'miteri' ); ?></a>
							</p>
						</div>

						<div class="col">
							<h3><?php esc_html_e( 'Got theme support question?', 'miteri' ); ?></h3>
							<p><?php esc_html_e( 'Please put it in our dedicated support forum.', 'miteri' ) ?></p>
							<p><a href="<?php echo esc_url( 'https://themeegg.com/support-forum/' ); ?>"
							      class="button button-secondary"><?php esc_html_e( 'Support', 'miteri' ); ?></a></p>
						</div>

						<div class="col">
							<h3><?php esc_html_e( 'Any question about this theme or us?', 'miteri' ); ?></h3>
							<p><?php esc_html_e( 'Please send it via our sales contact page.', 'miteri' ) ?></p>
							<p><a href="<?php echo esc_url( 'http://themeegg.com/contact/' ); ?>"
							      class="button button-secondary"><?php esc_html_e( 'Contact Page', 'miteri' ); ?></a>
							</p>
						</div>

						<div class="col">
							<h3>
								<?php
								esc_html_e( 'Translate', 'miteri' );
								echo ' ' . $theme->display( 'Name' );
								?>
							</h3>
							<p><?php esc_html_e( 'Click below to translate this theme into your own language.', 'miteri' ) ?></p>
							<p>
								<a href="<?php echo esc_url( 'https://translate.wordpress.org/projects/wp-themes/miteri' ); ?>"
								   class="button button-secondary">
									<?php
									esc_html_e( 'Translate', 'miteri' );
									echo ' ' . $theme->display( 'Name' );
									?>
								</a>
							</p>
						</div>
					</div>
				</div>

				<div class="return-to-dashboard miteri">
					<?php if ( current_user_can( 'update_core' ) && isset( $_GET['updated'] ) ) : ?>
						<a href="<?php echo esc_url( self_admin_url( 'update-core.php' ) ); ?>">
							<?php is_multisite() ? esc_html_e( 'Return to Updates', 'miteri' ) : esc_html_e( 'Return to Dashboard &rarr; Updates', 'miteri' ); ?>
						</a> |
					<?php endif; ?>
					<a href="<?php echo esc_url( self_admin_url() ); ?>"><?php is_blog_admin() ? esc_html_e( 'Go to Dashboard &rarr; Home', 'miteri' ) : esc_html_e( 'Go to Dashboard', 'miteri' ); ?></a>
				</div>
			</div>
			<?php
		}

		/**
		 * Output the changelog screen.
		 */
		public function changelog_screen() {
			global $wp_filesystem;

			?>
			<div class="wrap about-wrap">

				<?php $this->intro(); ?>

				<p class="about-description"><?php esc_html_e( 'View changelog below:', 'miteri' ); ?></p>

				<?php
				$changelog_file = apply_filters( 'miteri_changelog_file', get_template_directory() . '/readme.txt' );

				// Check if the changelog file exists and is readable.
				if ( $changelog_file && is_readable( $changelog_file ) ) {
					WP_Filesystem();
					$changelog      = $wp_filesystem->get_contents( $changelog_file );
					$changelog_list = $this->parse_changelog( $changelog );

					echo wp_kses_post( $changelog_list );
				}
				?>
			</div>
			<?php
		}

		/**
		 * Output the changelog screen.
		 */
		public function freevspro_screen() {
			?>
			<div class="wrap about-wrap">

				<?php $this->intro(); ?>

				<p class="about-description"><?php esc_html_e( 'Upgrade to PRO version for more awesome features.', 'miteri' ); ?></p>

				<table>
					<thead>
					<tr>
						<th class="table-feature-title"><h3><?php esc_html_e( 'Features', 'miteri' ); ?></h3></th>
						<th><h3><?php esc_html_e( 'Miteri', 'miteri' ); ?></h3></th>
						<th><h3><?php esc_html_e( 'Miteri Pro', 'miteri' ); ?></h3></th>
					</tr>
					</thead>
					<tbody>
					<tr>
						<td><h3><?php esc_html_e( 'Support', 'miteri' ); ?></h3></td>
						<td><?php esc_html_e( 'Forum', 'miteri' ); ?></td>
						<td><?php esc_html_e( 'Forum + Emails/Support Ticket', 'miteri' ); ?></td>
					</tr>
					<tr>
						<td><h3><?php esc_html_e( 'Additional color options', 'miteri' ); ?></h3></td>
						<td><span class="dashicons dashicons-no"></span></td>
						<td><span class="dashicons dashicons-yes"></span></td>
					</tr>
					<tr>
						<td><h3><?php esc_html_e( 'Primary color option', 'miteri' ); ?></h3></td>
						<td><span class="dashicons dashicons-yes"></span></td>
						<td><span class="dashicons dashicons-yes"></span></td>
					</tr>
					<tr>
						<td><h3><?php esc_html_e( 'Font size options', 'miteri' ); ?></h3></td>
						<td><span class="dashicons dashicons-no"></span></td>
						<td><span class="dashicons dashicons-yes"></span></td>
					</tr>
					<tr>
						<td><h3><?php esc_html_e( 'Google fonts options', 'miteri' ); ?></h3></td>
						<td><span class="dashicons dashicons-no"></span></td>
						<td><?php esc_html_e( '500+', 'miteri' ); ?></td>
					</tr>
					<tr>
						<td><h3><?php esc_html_e( 'Custom widgets', 'miteri' ); ?></h3></td>
						<td><?php esc_html_e( '2', 'miteri' ); ?></td>
						<td><?php esc_html_e( '20', 'miteri' ); ?></td>
					</tr>
					<tr>
						<td><h3><?php esc_html_e( 'Social icons', 'miteri' ); ?></h3></td>
						<td><span class="dashicons dashicons-yes"></span></td>
						<td><span class="dashicons dashicons-yes"></span></td>
					</tr>
					<tr>
						<td><h3><?php esc_html_e( 'Site layout option', 'miteri' ); ?></h3></td>
						<td><span class="dashicons dashicons-yes"></span></td>
						<td><span class="dashicons dashicons-yes"></span></td>
					</tr>
					<tr>
						<td><h3><?php esc_html_e( 'Change read more text', 'miteri' ); ?></h3></td>
						<td><span class="dashicons dashicons-no"></span></td>
						<td><span class="dashicons dashicons-yes"></span></td>
					</tr>
					<tr>
						<td><h3><?php esc_html_e( 'Related posts', 'miteri' ); ?></h3></td>
						<td><span class="dashicons dashicons-yes"></span></td>
						<td><span class="dashicons dashicons-yes"></span></td>
					</tr>
					<tr>
						<td><h3><?php esc_html_e( 'Author biography', 'miteri' ); ?></h3></td>
						<td><span class="dashicons dashicons-yes"></span></td>
						<td><span class="dashicons dashicons-yes"></span></td>
					</tr>
					<tr>
						<td><h3><?php esc_html_e( 'Footer copyright editor', 'miteri' ); ?></h3></td>
						<td><span class="dashicons dashicons-no"></span></td>
						<td><span class="dashicons dashicons-yes"></span></td>
					</tr>
					<tr>
						<td><h3><?php esc_html_e( 'Author detail', 'miteri' ); ?></h3></td>
						<td><span class="dashicons dashicons-yes"></span></td>
						<td><span class="dashicons dashicons-yes"></span></td>
					</tr>
					<tr>
						<td><h3><?php esc_html_e( 'Featured category slider', 'miteri' ); ?></h3></td>
						<td><span class="dashicons dashicons-no"></span></td>
						<td><span class="dashicons dashicons-yes"></span></td>
					</tr>
					<tr>
						<td><h3><?php esc_html_e( 'Flicker Photo Widget', 'miteri' ); ?></h3></td>
						<td><span class="dashicons dashicons-no"></span></td>
						<td><span class="dashicons dashicons-yes"></span></td>
					</tr>
					<tr>
						<td><h3><?php esc_html_e( 'Facebook Page', 'miteri' ); ?></h3></td>
						<td><span class="dashicons dashicons-no"></span></td>
						<td><span class="dashicons dashicons-yes"></span></td>
					</tr>
					<tr>
						<td><h3><?php esc_html_e( 'Alternative Post', 'miteri' ); ?></h3></td>
						<td><span class="dashicons dashicons-no"></span></td>
						<td><span class="dashicons dashicons-yes"></span></td>
					</tr>
					<tr>
						<td><h3><?php esc_html_e( 'Counter blog widget', 'miteri' ); ?></h3></td>
						<td><span class="dashicons dashicons-no"></span></td>
						<td><span class="dashicons dashicons-yes"></span></td>
					</tr>
					<tr>
						<td><h3><?php esc_html_e( 'Portfolio widget', 'miteri' ); ?></h3></td>
						<td><span class="dashicons dashicons-no"></span></td>
						<td><span class="dashicons dashicons-yes"></span></td>
					</tr>
					<tr>
						<td><h3><?php esc_html_e( 'Post CTA widget', 'miteri' ); ?></h3></td>
						<td><span class="dashicons dashicons-no"></span></td>
						<td><span class="dashicons dashicons-yes"></span></td>
					</tr>
					<tr>
						<td><h3><?php esc_html_e( 'Post timeline', 'miteri' ); ?></h3></td>
						<td><span class="dashicons dashicons-no"></span></td>
						<td><span class="dashicons dashicons-yes"></span></td>
					</tr>
					<tr>
						<td><h3><?php esc_html_e( 'Instagram Widget', 'miteri' ); ?></h3></td>
						<td><span class="dashicons dashicons-no"></span></td>
						<td><span class="dashicons dashicons-yes"></span></td>
					</tr>
					<tr>
						<td><h3><?php esc_html_e( 'Tabbed widget', 'miteri' ); ?></h3></td>
						<td><span class="dashicons dashicons-no"></span></td>
						<td><span class="dashicons dashicons-yes"></span></td>
					</tr>
					<tr>
						<td><h3><?php esc_html_e( 'Youtube Videos', 'miteri' ); ?></h3></td>
						<td><span class="dashicons dashicons-no"></span></td>
						<td><span class="dashicons dashicons-yes"></span></td>
					</tr>
					<tr>
						<td><h3><?php esc_html_e( 'Logo slider widget', 'miteri' ); ?></h3></td>
						<td><span class="dashicons dashicons-no"></span></td>
						<td><span class="dashicons dashicons-yes"></span></td>
					</tr>

					<tr>
						<td><h3><?php esc_html_e( 'WooCommerce compatible', 'miteri' ); ?></h3></td>
						<td><span class="dashicons dashicons-no"></span></td>
						<td><span class="dashicons dashicons-yes"></span></td>
					</tr>
					<tr>
						<td><h3><?php esc_html_e( 'Multiple header options', 'miteri' ); ?></h3></td>
						<td><span class="dashicons dashicons-no"></span></td>
						<td><span class="dashicons dashicons-yes"></span></td>
					</tr>
					<tr>
						<td><h3><?php esc_html_e( 'Readmore flying card', 'miteri' ); ?></h3></td>
						<td><span class="dashicons dashicons-no"></span></td>
						<td><span class="dashicons dashicons-yes"></span></td>
					</tr>

					<tr>
						<td><h3><?php esc_html_e( 'Reading indicator option', 'miteri' ); ?></h3></td>
						<td><span class="dashicons dashicons-no"></span></td>
						<td><span class="dashicons dashicons-yes"></span></td>
					</tr>
					<tr>
						<td><h3><?php esc_html_e( 'Lightbox support', 'miteri' ); ?></h3></td>
						<td><span class="dashicons dashicons-no"></span></td>
						<td><span class="dashicons dashicons-yes"></span></td>
					</tr>
					<tr>
						<td><h3><?php esc_html_e( 'Call to action widget', 'miteri' ); ?></h3></td>
						<td><span class="dashicons dashicons-no"></span></td>
						<td><span class="dashicons dashicons-yes"></span></td>
					</tr>
					<tr>
						<td><h3><?php esc_html_e( 'Breadcrumbs', 'miteri' ); ?></h3></td>
						<td><span class="dashicons dashicons-no"></span></td>
						<td><span class="dashicons dashicons-yes"></span></td>
					</tr>
					<tr>
						<td></td>
						<td></td>
						<td class="btn-wrapper">
							<a href="<?php echo esc_url( apply_filters( 'miteri_pro_theme_url', 'https://themeegg.com/downloads/miteri-pro-wordpress-theme/' ) ); ?>"
							   class="button button-secondary docs"
							   target="_blank"><?php esc_html_e( 'View Pro', 'miteri' ); ?></a>
						</td>
					</tr>
					</tbody>
				</table>

			</div>
			<?php
		}

		/**
		 * Parse changelog from readme file.
		 *
		 * @param  string $content
		 *
		 * @return string
		 */
		private function parse_changelog( $content ) {
			$matches   = null;
			$regexp    = '~==\s*Changelog\s*==(.*)($)~Uis';
			$changelog = '';

			if ( preg_match( $regexp, $content, $matches ) ) {
				$changes = explode( '\r\n', trim( $matches[1] ) );

				$changelog .= '<pre class="changelog">';

				foreach ( $changes as $index => $line ) {
					$changelog .= wp_kses_post( preg_replace( '~(=\s*Version\s*(\d+(?:\.\d+)+)\s*=|$)~Uis', '<span class="title">${1}</span>', $line ) );
				}

				$changelog .= '</pre>';
			}

			return wp_kses_post( $changelog );
		}


		/**
		 * Output the supported plugins screen.
		 */
		public function supported_plugins_screen() {
			?>
			<div class="wrap about-wrap">

				<?php $this->intro(); ?>

				<p class="about-description"><?php esc_html_e( 'This theme recommends following plugins:', 'miteri' ); ?></p>
				<ol>
					<li><a href="<?php echo esc_url( 'https://wordpress.org/plugins/social-icons/' ); ?>"
					       target="_blank"><?php esc_html_e( 'Social Icons', 'miteri' ); ?></a>
						<?php esc_html_e( ' by ThemeEgg', 'miteri' ); ?>
					</li>
					<li><a href="<?php echo esc_url( 'https://wordpress.org/plugins/easy-social-sharing/' ); ?>"
					       target="_blank"><?php esc_html_e( 'Easy Social Sharing', 'miteri' ); ?></a>
						<?php esc_html_e( ' by ThemeEgg', 'miteri' ); ?>
					</li>
					<li><a href="<?php echo esc_url( 'https://wordpress.org/plugins/contact-form-7/' ); ?>"
					       target="_blank"><?php esc_html_e( 'Contact Form 7', 'miteri' ); ?></a></li>
					<li><a href="<?php echo esc_url( 'https://wordpress.org/plugins/wp-pagenavi/' ); ?>"
					       target="_blank"><?php esc_html_e( 'WP-PageNavi', 'miteri' ); ?></a></li>
					<li><a href="<?php echo esc_url( 'https://wordpress.org/plugins/woocommerce/' ); ?>"
					       target="_blank"><?php esc_html_e( 'WooCommerce', 'miteri' ); ?></a></li>
					<li>
						<a href="<?php echo esc_url( 'https://wordpress.org/plugins/polylang/' ); ?>"
						   target="_blank"><?php esc_html_e( 'Polylang', 'miteri' ); ?></a>
						<?php esc_html_e( 'Fully Compatible in Pro Version', 'miteri' ); ?>
					</li>
					<li>
						<a href="<?php echo esc_url( 'https://wpml.org/' ); ?>"
						   target="_blank"><?php esc_html_e( 'WPML', 'miteri' ); ?></a>
						<?php esc_html_e( 'Fully Compatible in Pro Version', 'miteri' ); ?>
					</li>
				</ol>

			</div>
			<?php
		}

	}

endif;

return new Miteri_Admin();
