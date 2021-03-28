<?php
/**
 * The template for displaying Archive pages.
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 * @package ekko
 * by KeyDesign
 */

 get_header(); ?>

<?php
	$redux_ThemeTek = get_option( 'redux_ThemeTek' );
  $kd_post_content = $blog_template_class = $page_layout = $sticky_sidebar = $blog_active_widgets = '';

  if (!isset($redux_ThemeTek['tek-blog-sidebar'])) {
		$redux_ThemeTek['tek-blog-sidebar'] = 1;
	}

  if( !class_exists( 'ReduxFrameworkPlugin' ) ) {
    $kd_post_content .= "img-top-list";
  } elseif (isset($redux_ThemeTek['tek-blog-template']) && ($redux_ThemeTek['tek-blog-template'] != '')) {
    $kd_post_content .= $redux_ThemeTek['tek-blog-template'];
    $blog_template_class .= 'blog-'.$redux_ThemeTek['tek-blog-template'];
  }

  if ($redux_ThemeTek['tek-blog-sidebar']) {
    $page_layout = "use-sidebar";
  }

  if (!isset($redux_ThemeTek['tek-blog-listing-sticky-sidebar'])) {
		$redux_ThemeTek['tek-blog-listing-sticky-sidebar'] = 1;
		$sticky_sidebar = 'post-sticky-sidebar';
	}

	if ($redux_ThemeTek['tek-blog-listing-sticky-sidebar']) {
		$sticky_sidebar = 'post-sticky-sidebar';
	}

  $blog_active_widgets = is_active_sidebar( 'blog-sidebar' );
?>

<div id="posts-content" class="container <?php echo esc_attr( $page_layout ); ?> <?php echo esc_attr( $blog_template_class ); ?>" >
	<?php if ( ($redux_ThemeTek['tek-blog-sidebar']) && $blog_active_widgets ) { ?>
		<div class="col-xs-12 col-sm-12 col-lg-8">
	<?php } else { ?>
		<div class="col-xs-12 col-sm-12 col-lg-8 BlogFullWidth">
	<?php } ?>
	<?php
		if ( have_posts() ) :

			/* Start the Loop */
			while ( have_posts() ) : the_post();

				get_template_part( 'core/templates/post/blog', $kd_post_content );

			endwhile;

      /* Numeric posts pagination */
			keydesign_numeric_posts_nav();

		else :

			get_template_part( 'core/templates/post/content', 'none' );

		endif;
	?>
	</div>
  <?php if ( ($redux_ThemeTek['tek-blog-sidebar']) && $blog_active_widgets ) : ?>
    <div class="col-xs-12 col-sm-12 col-lg-4 <?php echo esc_attr( $sticky_sidebar ); ?>">
      <div class="right-sidebar">
		     <?php get_sidebar(); ?>
      </div>
		</div>
	<?php endif; ?>
</div>

<?php get_footer(); ?>
