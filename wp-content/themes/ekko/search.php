<?php
/**
 * The template for displaying Search Results pages.
 * @package ekko
 * by KeyDesign
 */

 get_header(); ?>

 <?php
 	$redux_ThemeTek = get_option( 'redux_ThemeTek' );
  $sticky_sidebar = $page_layout = '';
   if (!isset($redux_ThemeTek['tek-blog-sidebar'])) {
 		$redux_ThemeTek['tek-blog-sidebar'] = 0;
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
 ?>

<div id="posts-content" class="container" >
  <?php if (($redux_ThemeTek['tek-blog-sidebar'])) : ?>
    <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
  <?php else : ?>
    <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8 BlogFullWidth">
  <?php endif; ?>
    	<?php
    		if ( have_posts() ) :

    			while ( have_posts() ) : the_post();
    				get_template_part( 'core/templates/post/content', 'search' );
    			endwhile;

          /* Numeric posts pagination */
    			keydesign_numeric_posts_nav();
      ?>
    <?php
		  else :
        get_template_part( 'core/templates/post/content', 'none' );
      endif;
    ?>
    </div>
    <?php if (($redux_ThemeTek['tek-blog-sidebar'])) : ?>
      <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 <?php echo esc_attr( $sticky_sidebar ); ?>">
        <div class="right-sidebar">
  		     <?php get_sidebar(); ?>
        </div>
  		</div>
  	<?php endif; ?>
</div>

<?php get_footer(); ?>
