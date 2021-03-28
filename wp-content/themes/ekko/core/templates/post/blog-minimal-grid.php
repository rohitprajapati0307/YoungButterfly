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
	$without_image_class = '';

  if (!isset($redux_ThemeTek['tek-blog-sidebar'])) {
		$redux_ThemeTek['tek-blog-sidebar'] = 0;
	}

	if (!has_post_thumbnail()) {
		$without_image_class .= 'without-image';
	}
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?> >
	<?php if (has_post_thumbnail()) : ?>
		<div class="entry-image">
			<a href="<?php esc_url(the_permalink()); ?>" title="<?php the_title_attribute(); ?>"><?php the_post_thumbnail('keydesign-grid-image'); ?></a>
		</div>
	<?php endif; ?>
	<div class="entry-wrapper <?php echo esc_attr($without_image_class); ?>">
		<div class="entry-meta">
			<?php if ( is_sticky() ) echo '<span class="fa fa-thumb-tack"></span> Sticky <span class="blog-separator">|</span>  '; ?>
			<span class="published"><span class="fa fa-clock-o"></span><a href="<?php esc_url(the_permalink()); ?>" title="<?php the_title_attribute(); ?>"><?php the_time( get_option('date_format') ); ?></a></span>
			<span class="blog-label"><span class="fa fa-folder-open-o"></span><?php the_category(', '); ?></span>
		</div>
		<h5 class="blog-single-title"><a href="<?php esc_url(the_permalink()); ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h5>
		<div class="entry-content">
			<a class="post-link" href="<?php esc_url(the_permalink()); ?>"><?php esc_html_e( 'Read more', 'ekko' ); ?></a>
		</div>
	</div>
</article>
