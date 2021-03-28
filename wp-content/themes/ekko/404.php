<?php
/**
 * The template for displaying 404 pages (Not Found)
 * @package ekko
 * by KeyDesign
 */

get_header(); ?>

<section class="page-404">
	<div class="container">
	    <div class="row" >
			<h2 class="section-heading"><?php if (isset($redux_ThemeTek['tek-404-title'])) { echo esc_html($redux_ThemeTek['tek-404-title']); } else { echo "Page 404"; } ?></h2>
			<p class="section-subheading"><?php if (isset($redux_ThemeTek['tek-404-subtitle'])) { echo esc_html($redux_ThemeTek['tek-404-subtitle']); } else { echo "This page could not be found!"; } ?></p>
			<a href="<?php echo esc_url(get_site_url()); ?>" class="tt_button tt_primary_button"><?php if (isset($redux_ThemeTek['tek-404-back'])) { echo esc_html($redux_ThemeTek['tek-404-back']); } else { echo "Back to Homepage"; } ?></a>
	    </div>
    </div>
</section>

<?php get_footer(); ?>
