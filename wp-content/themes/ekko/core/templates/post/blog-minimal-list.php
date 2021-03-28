<?php
/**
 * Template part for displaying standard posts
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
		<div class="entry-meta">
			<?php if ( is_sticky() ) echo '<span class="fa fa-thumb-tack"></span> Sticky <span class="blog-separator">|</span>  '; ?>
			<span class="published"><span class="fa fa-clock-o"></span><a href="<?php esc_url(the_permalink()); ?>" title="<?php the_title_attribute(); ?>"><?php  the_time( get_option('date_format') ); ?></a></span>
				<span class="author"><span class="fa fa-keyboard-o"></span><?php  the_author_posts_link(); ?></span>
				<span class="blog-label"><span class="fa fa-folder-open-o"></span><?php  the_category(', '); ?></span>
				<span class="comment-count"><span class="fa fa-comment-o"></span><?php  comments_popup_link( esc_html__('No comments yet', 'ekko'), esc_html__('1 comment', 'ekko'), esc_html__('% comments', 'ekko') ); ?></span>
		</div>
		<div class="entry-content">
			<?php the_excerpt(); ?>
			<?php wp_link_pages(); ?>
		</div>
</article>
