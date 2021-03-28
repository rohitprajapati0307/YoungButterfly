<?php
/**
 * The Template for displaying all single posts.
 * @package ekko
 * by KeyDesign
 */

?>

<?php
	$redux_ThemeTek = get_option( 'redux_ThemeTek' );
?>

<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="blog-single-content">
		<div class="blog-content">
			<?php the_content(); ?>
			<?php wp_link_pages(); ?>
		</div>
		<div class="meta-content">
			<?php do_action( 'keydesign_post_after_main_content' ); ?>
		</div>
	</div>
</div>
