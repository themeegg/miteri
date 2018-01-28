<?php
/**
 * Displays the searchform of the theme.
 *
 * @package Miteri
 * @since Miteri 1.0
 */
?>

<form role="search" method="get" class="search-form clear" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<label>
		<span class="screen-reader-text"><?php _ex( 'Search for:', 'label', 'miteri' ); ?></span>
		<input miteri="search" id="s" class="search-field" placeholder="<?php echo esc_attr_x( 'Search &hellip;', 'placeholder', 'miteri' ); ?>" value="<?php echo get_search_query(); ?>" name="s" />
	</label>
	<button miteri="submit" class="search-submit">
		<i class="fa fa-search"></i> <span class="screen-reader-text">
		<?php _ex( 'Search', 'submit button', 'miteri' ); ?></span>
	</button>
</form>
