<?php
/**
 * The front page template file
 *
 * If the user has selected a static page for their homepage, this is what will
 * appear.
 * Learn more: https://codex.wordpress.org/Template_Hierarchy
 *
 * @package ekko
 * by KeyDesign
 */

 get_header(); ?>

 <?php
   $redux_ThemeTek = get_option( 'redux_ThemeTek' );

    $kd_post_content = $blog_template_class = $page_layout = $section_style = $sticky_sidebar = $style_escaped = $blog_active_widgets = '';

   $themetek_page_top_padding = get_post_meta( get_the_ID(), '_themetek_page_top_padding', true );
   $themetek_page_bottom_padding = get_post_meta( get_the_ID(), '_themetek_page_bottom_padding', true );

   if ( '' !== $themetek_page_top_padding ) {
     $section_style .= 'padding-top:' . ( preg_match( '/(px|em|\%|pt|cm)$/', $themetek_page_top_padding ) ? $themetek_page_top_padding : $themetek_page_top_padding . 'px' ) . ';';
   }
   if ( '' !== $themetek_page_bottom_padding ) {
     $section_style .= 'padding-bottom:' . ( preg_match( '/(px|em|\%|pt|cm)$/', $themetek_page_bottom_padding ) ? $themetek_page_bottom_padding : $themetek_page_bottom_padding . 'px' ) . ';';
   }
   $style_escaped = $section_style ? 'style="' . esc_attr( $section_style ) . '"' : '';

   if (!isset($redux_ThemeTek['tek-blog-sidebar'])) {
     $redux_ThemeTek['tek-blog-sidebar'] = 1;
   }

   if( !class_exists( 'ReduxFrameworkPlugin' ) ) {
     $kd_post_content .= "img-top-list";
     $blog_template_class .= "blog-img-top-list";
   } elseif (isset($redux_ThemeTek['tek-blog-template']) && ($redux_ThemeTek['tek-blog-template'] != '')) {
     $kd_post_content .= $redux_ThemeTek['tek-blog-template'];
     $blog_template_class .= 'blog-'.$redux_ThemeTek['tek-blog-template'];
   }

   if ($redux_ThemeTek['tek-blog-sidebar']) {
     $page_layout .= "use-sidebar";
   }

 	 if (isset($redux_ThemeTek['tek-blog-listing-sticky-sidebar']) && $redux_ThemeTek['tek-blog-listing-sticky-sidebar']) {
     $sticky_sidebar = 'post-sticky-sidebar';
 	 }

   $blog_active_widgets = is_active_sidebar( 'blog-sidebar' );
 ?>

<?php if( is_home() ) : ?>
	<div id="posts-content" class="container <?php echo esc_attr( $page_layout ); ?> <?php echo esc_attr( $blog_template_class ); ?>" >
	<?php if ( ($redux_ThemeTek['tek-blog-sidebar']) && $blog_active_widgets ) { ?>
		<div class="col-xs-12 col-sm-12 col-lg-8">
	<?php } else { ?>
		<div class="col-xs-12 col-sm-12 col-lg-8 BlogFullWidth">
	<?php } ?>
	<?php
		if ( have_posts() ) :
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
	<?php if ( ($redux_ThemeTek['tek-blog-sidebar']) && $blog_active_widgets ) { ?>
		<div class="col-xs-12 col-sm-12 col-lg-4 <?php echo esc_attr( $sticky_sidebar ); ?>">
      <div class="right-sidebar">
		     <?php get_sidebar(); ?>
      </div>
		</div>
	<?php } ?>
	</div>
<?php else : ?>
  <?php
  // This variable ($style_escaped) has been safely escaped in the following file: ekko/front-page.php Line: 29
  ?>
	<div id="primary" class="content-area" <?php echo $style_escaped; ?>>
		<main id="main" class="site-main" role="main">

			<?php // Show the selected frontpage content.
			if ( have_posts() ) :
				while ( have_posts() ) : the_post();
					get_template_part( 'core/templates/page/content', 'front-page' );
				endwhile;
			else :
				get_template_part( 'core/templates/post/content', 'none' );
			endif; ?>

		</main><!-- #main -->
	</div><!-- #primary -->
<?php endif; ?>

<?php get_footer(); ?>
