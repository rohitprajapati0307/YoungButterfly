<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package ekko
 * by KeyDesign
 */

get_header();

$section_style = $style_escaped = '';

$themetek_page_top_padding = get_post_meta( get_the_ID(), '_themetek_page_top_padding', true );
$themetek_page_bottom_padding = get_post_meta( get_the_ID(), '_themetek_page_bottom_padding', true );

if ( '' !== $themetek_page_top_padding ) {
  $section_style .= 'padding-top:' . ( preg_match( '/(px|em|\%|pt|cm)$/', $themetek_page_top_padding ) ? $themetek_page_top_padding : $themetek_page_top_padding . 'px' ) . ';';
}
if ( '' !== $themetek_page_bottom_padding ) {
  $section_style .= 'padding-bottom:' . ( preg_match( '/(px|em|\%|pt|cm)$/', $themetek_page_bottom_padding ) ? $themetek_page_bottom_padding : $themetek_page_bottom_padding . 'px' ) . ';';
}
$style_escaped = $section_style ? 'style="' . esc_attr( $section_style ) . '"' : '';

?>

<?php
// This variable ($style_escaped) has been safely escaped in the following file: ekko/page.php Line: 29
?>
<div id="primary" class="content-area" <?php echo $style_escaped; ?>>
	<main id="main" class="site-main" role="main">

		<?php
			while ( have_posts() ) : the_post();
				get_template_part( 'core/templates/page/content', 'page' );
				// If comments are open or we have at least one comment, load up the comment template.
				if ( comments_open() || get_comments_number() ) : ?>
					<div class="page-content comments-content container">
						<?php comments_template(); ?>
					</div>
				<?php endif;
			endwhile; // End of the loop.
		?>

	</main><!-- #main -->
</div><!-- #primary -->

<?php get_footer(); ?>
