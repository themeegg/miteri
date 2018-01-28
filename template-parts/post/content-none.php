<?php
/**
 * Template part for displaying a message that posts cannot be found.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Miteri
 * @since Miteri 1.0
 */
?>
<div id="primary" class="content-area">
	<main id="main" class="site-main" role="main">
		<section class="no-results not-found">
			<header class="entry-header">
				<div class="page-header-wrapper">
					<h1 class="page-title"><?php esc_html_e( 'Nothing Found', 'miteri' ); ?></h1>
				</div>
			</header><!-- .entry-header -->
			<div class="entry-content">
				<?php
				if ( is_home() && current_user_can( 'publish_posts' ) ) : ?>
					<p><?php printf( esc_html__( 'Ready to publish your first post? <a href="%1$s">Get started here</a>.', 'miteri' ), esc_url( admin_url( 'post-new.php' ) ) ); ?></p>
				<?php else : ?>
					<p><?php esc_html_e( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'miteri' ); ?></p>
					<?php
					get_search_form();
				endif; ?>
			</div><!-- .entry-content -->
		</section><!-- .no-results -->
	</main><!-- #main -->
</div><!-- #primary -->