<?php
/**
 * The template part for displaying an Author biography
 *
 * @package Miteri
 * @since Miteri 1.0
 */
 
?>

<div class="author-info">
	<div class="row">
		<div class="col-2 col-sm-2">
			<div class="author-avatar">
				<?php echo get_avatar( get_the_author_meta( 'user_email' ), 60 ); ?>
			</div><!-- .author-avatar -->
		</div>
		<div class="col-10 col-sm-10">
			<div class="author-description">
				<h3 class="author-title"><span class="author-heading"><?php esc_html_e( 'Author:', 'miteri' ); ?></span> <?php echo get_the_author(); ?></h3>
				<p class="author-bio">
					<?php the_author_meta( 'description' ); ?>
					<a class="author-link" href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>" rel="author">
						<?php printf( esc_html__( 'View all posts by %s', 'miteri' ), get_the_author() ); ?>
					</a>
				</p><!-- .author-bio -->
			</div><!-- .author-description -->
		</div>
	</div>
</div><!-- .author-info -->
