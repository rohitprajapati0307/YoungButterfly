<?php
/**
 * The Template for displaying all single posts.
 * @package ekko
 * by KeyDesign
 */

get_header(); ?>

<?php
	$redux_ThemeTek = get_option( 'redux_ThemeTek' );
	$page_layout = $single_post_template = $sticky_sidebar = $post_header_image = $post_image_class = $blog_active_widgets = '';

	if (has_post_thumbnail($post->ID)) {
		$post_header_image = wp_get_attachment_url( get_post_thumbnail_id(get_option($post->ID)), 'full' );
	}

	if ($post_header_image != '') {
		$post_image_class = 'post-with-image';
	}

	if (!isset($redux_ThemeTek['tek-blog-single-sidebar'])) {
		$redux_ThemeTek['tek-blog-single-sidebar'] = 1;
	}

	$blog_active_widgets = is_active_sidebar( 'blog-sidebar' );

	if (!$blog_active_widgets) {
		$redux_ThemeTek['tek-blog-single-sidebar'] = 0;
	}

	if (!isset($redux_ThemeTek['tek-blog-sticky-sidebar'])) {
		$redux_ThemeTek['tek-blog-sticky-sidebar'] = 1;
		$sticky_sidebar = 'post-sticky-sidebar';
	}

	if ($redux_ThemeTek['tek-blog-sticky-sidebar']) {
		$sticky_sidebar = 'post-sticky-sidebar';
	}

	if ($redux_ThemeTek['tek-blog-single-sidebar']) {
		$page_layout .= "use-sidebar";
	}

	if (isset($redux_ThemeTek['tek-single-post-template']) && is_singular('post')) {
		$single_post_template = $redux_ThemeTek['tek-single-post-template'];
	} else {
		$single_post_template = 'single-post-layout-one';
	}

?>

<div id="posts-content" class="blog-single <?php echo esc_attr( $page_layout ); ?>">
	<?php while ( have_posts() ) : the_post(); ?>
		<?php if ( ($single_post_template == 'single-post-layout-two') && $post_header_image != '' ) : ?>
			<div class="blog-single-header-wrapper <?php echo esc_attr($post_image_class); ?>" style="background-image:url('<?php echo esc_url($post_header_image); ?>')">
		<?php else: ?>
			<div class="blog-single-header-wrapper">
		<?php endif; ?>
			<div class="container blog-single-title-meta-wrapper">
				<?php if ($single_post_template == 'single-post-layout-one') : ?>
					<div class="col-xs-12 col-sm-12 col-md-8 col-lg-8 layout-one-title">
				<?php else: ?>
					<div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
				<?php endif; ?>
					<?php get_template_part( 'core/templates/post/partials/content', 'title' );
					get_template_part( 'core/templates/post/partials/content', 'meta' ); ?>
				</div>
			</div>
		</div>

		<div class="container">
			<div class="row">

				<?php if ($redux_ThemeTek['tek-blog-single-sidebar']) { ?>
					<div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
				<?php } else { ?>
					<div class="col-xs-12 col-sm-12 col-md-8 col-lg-8 BlogFullWidth">
				<?php } ?>
					<?php if ($single_post_template == 'single-post-layout-one') {
						get_template_part( 'core/templates/post/post-type/content', get_post_format() );
					} ?>
					<?php get_template_part( 'core/templates/post/content', 'single' ); ?>

					</div>

					<?php if ($redux_ThemeTek['tek-blog-single-sidebar']) { ?>
						<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 <?php echo esc_attr( $sticky_sidebar ); ?>">
							<div class="right-sidebar">
								<?php get_sidebar(); ?>
							</div>
						</div>
					<?php } ?>
				</div>
			</div>

		<?php if (isset($redux_ThemeTek['tek-related-posts']) && $redux_ThemeTek['tek-related-posts'] == true) :
			get_template_part( 'core/templates/post/partials/content', 'related' );
		endif; ?>

		<?php get_template_part( 'core/templates/post/partials/content', 'comments' );

		endwhile; // End of the loop.
		?>
</div>

<?php get_footer(); ?>
