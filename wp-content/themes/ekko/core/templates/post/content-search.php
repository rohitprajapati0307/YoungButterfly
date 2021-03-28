<?php
/**
 * Template part for displaying posts with excerpts
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package ekko
 * by KeyDesign
 */

?>

<?php
	$redux_ThemeTek = get_option( 'redux_ThemeTek' );

  if (!isset($redux_ThemeTek['tek-blog-sidebar'])) {
		$redux_ThemeTek['tek-blog-sidebar'] = 0;
	}
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?> >
	<h2 class="blog-single-title"><a href="<?php esc_url(the_permalink()); ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>
	<?php if ( 'post' === get_post_type() ) : ?>
		<div class="entry-meta">
			<span class="page-type"><span class="fa fa-file-text-o"></span><?php esc_html_e( 'Post', 'ekko' ); ?></span>
			<span class="published"><span class="fa fa-clock-o"></span><a href="<?php esc_url(the_permalink()); ?>" title="<?php the_title_attribute(); ?>"><?php  the_time( get_option('date_format') ); ?></a></span>
			<span class="author"><span class="fa fa-keyboard-o"></span><?php  the_author_posts_link(); ?></span>
			<span class="blog-label"><span class="fa fa-folder-open-o"></span><?php  the_category(', '); ?></span>
			<span class="comment-count"><span class="fa fa-comment-o"></span><?php  comments_popup_link( esc_html__('No comments yet', 'ekko'), esc_html__('1 comment', 'ekko'), esc_html__('% comments', 'ekko') ); ?></span>
		</div>
	<?php else : ?>
		<div class="entry-meta">
			<?php if ( 'page' === get_post_type() ) : ?>
				<span class="page-type"><span class="fa fa-file-text-o"></span><?php esc_html_e( 'Page', 'ekko' ); ?></span>
			<?php elseif ( 'portfolio' === get_post_type() ) : ?>
				<span class="page-type"><span class="fa fa-file-image-o"></span><?php esc_html_e( 'Portfolio', 'ekko' ); ?></span>
			<?php elseif ( 'product' === get_post_type() ) : ?>
				<span class="page-type"><span class="fa fa-shopping-cart"></span><?php esc_html_e( 'Product', 'ekko' ); ?></span>
			<?php endif; ?>
			<span class="published"><span class="fa fa-clock-o"></span><a href="<?php esc_url(the_permalink()); ?>" title="<?php the_title_attribute(); ?>"><?php  the_time( get_option('date_format') ); ?></a></span>
		</div>
	<?php endif; ?>
		<div class="entry-content">
			<?php if ( has_excerpt() ) {
				the_excerpt();
			} ?>
			<a class="post-link" href="<?php esc_url(the_permalink()); ?>"><?php esc_html_e( 'Read more', 'ekko' ); ?></a>
		</div>
</article>
