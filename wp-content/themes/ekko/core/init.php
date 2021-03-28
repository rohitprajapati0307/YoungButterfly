<?php

// ------------------------------------------------------------------------
// Add Redux Framework & extras
// ------------------------------------------------------------------------


$redux_ThemeTek = get_option( 'redux_ThemeTek' );

define( 'KEYDESIGN_THEME_PATH', get_template_directory() );
define( 'KEYDESIGN_THEME_PLUGINS_DIR', KEYDESIGN_THEME_PATH . '/core/plugins' );

// ------------------------------------------------------------------------
// Theme includes
// ------------------------------------------------------------------------

// Wordpress Bootstrap Menu
require_once( get_template_directory() . '/core/assets/extra/wp_bootstrap_navwalker.php');

// ------------------------------------------------------------------------
// WooCommerce
// ------------------------------------------------------------------------
	if( class_exists( 'WooCommerce' )) {
		add_theme_support( 'woocommerce', array(
			'thumbnail_image_width' => 800,
			'gallery_thumbnail_image_width' => 800,
			'single_image_width' => 800,
		) );

		require_once( get_template_directory() . '/core/theme-woocommerce.php' );
	}

// ------------------------------------------------------------------------
// Enqueue scripts and styles front and admin
// ------------------------------------------------------------------------

	if( !function_exists('keydesign_enqueue_front') ) {
		function keydesign_enqueue_front() {
			$redux_ThemeTek = get_option( 'redux_ThemeTek' );
			// Bootstrap CSS
			wp_enqueue_style( 'bootstrap', get_template_directory_uri() . '/core/assets/css/bootstrap.min.css', '', '' );
			// Theme main style CSS
			wp_enqueue_style( 'keydesign-style', get_stylesheet_uri(), array('bootstrap'), '' );
			// Font Awesome
			wp_enqueue_style( 'font-awesome', get_template_directory_uri() . '/core/assets/css/font-awesome.min.css', '', '' );
			// Iconsmind
			wp_enqueue_style( 'keydesign-iconsmind', get_template_directory_uri() . '/core/assets/css/iconsmind.min.css', '', '' );

			wp_enqueue_style( 'keydesign-default-fonts', keydesign_default_fonts_url(), array(), '' );
			// Bootstrap JS
			wp_enqueue_script( 'bootstrap', get_template_directory_uri() . '/core/assets/js/bootstrap.min.js', array('jquery'), '', true );
			// Masonry
			if( is_front_page() || is_page_template('portfolio.php') ) {
				wp_enqueue_script( 'masonry' );
			}

			if ( function_exists('is_product') ) {
				if ( is_product() ) {
					wp_enqueue_style( 'photoswipe', get_template_directory_uri() . '/core/assets/css/photoswipe.css', '', '' );
					wp_enqueue_style( 'photoswipe-skin', get_template_directory_uri() . '/core/assets/css/photoswipe-default-skin.css', '', '' );
					wp_enqueue_script( 'photoswipejs', get_template_directory_uri() . '/core/assets/js/photoswipe.min.js', array('jquery'), '', true );
					wp_enqueue_script( 'photoswipejs-ui', get_template_directory_uri() . '/core/assets/js/photoswipe-ui-default.min.js', array('jquery'), '', true );
				}
			}

			// Smooth mouse scrolling
			wp_register_script( 'keydesign-smooth-scroll', get_template_directory_uri() . '/core/assets/js/SmoothScroll.js', array('jquery'), '', true );
			if ( isset($redux_ThemeTek['tek-smooth-scroll']) && $redux_ThemeTek['tek-smooth-scroll'] != false ) {
				wp_enqueue_script( 'keydesign-smooth-scroll' );
			}

			// Theme main scripts
			wp_enqueue_script( 'keydesign-scripts', get_template_directory_uri() . '/core/assets/js/scripts.js', array(), '', true );

			// Visual composer - move styles to head
			wp_enqueue_style( 'js_composer_front' );
			wp_enqueue_style( 'js_composer_custom_css' );

		}
	}
	add_action( 'wp_enqueue_scripts', 'keydesign_enqueue_front' );

	// ------------------------------------------------------------------------
	// bbPress
	// ------------------------------------------------------------------------
	function keydesign_bbpress_css_enqueue(){
		if( function_exists( 'is_bbpress' ) ) {
			// Deregister default bbPress CSS
			wp_deregister_style( 'bbp-default' );

			$file = 'core/assets/css/bbpress.css';

			// Check child theme
			if ( file_exists( trailingslashit( get_stylesheet_directory() ) . $file ) ) {
				$location = trailingslashit( get_stylesheet_directory_uri() );
				$handle   = 'bbp-child-bbpress';

			// Check parent theme
			} elseif ( file_exists( trailingslashit( get_template_directory() ) . $file ) ) {
				$location = trailingslashit( get_template_directory_uri() );
				$handle   = 'bbp-parent-bbpress';
			}

			// Enqueue the bbPress styling
			wp_enqueue_style( $handle, $location . $file, 'screen' );
		}
	}
	add_action( 'wp_enqueue_scripts', 'keydesign_bbpress_css_enqueue' );

	function keydesign_default_fonts_url() {
        $font_url = add_query_arg( 'family', urlencode( 'Open Sans:300,400,600,700&subset=latin-ext' ), "//fonts.googleapis.com/css" );
    	return $font_url;
	}

	if( !function_exists('keydesign_enqueue_admin') ) {
		function keydesign_enqueue_admin() {
					wp_enqueue_style( 'keydesign-wp-admin-css', get_template_directory_uri() . '/core/assets/css/admin-styles.css', '', '' );
	        wp_enqueue_script( 'keydesign-wp-admin-js', get_template_directory_uri() . '/core/assets/js/admin-scripts.js', '', '1.0.0' );
		}
	}
	add_action( 'admin_enqueue_scripts', 'keydesign_enqueue_admin' );

// ------------------------------------------------------------------------
// Theme Setup
// ------------------------------------------------------------------------

	function keydesign_setup(){
			// Localization
			load_theme_textdomain( 'ekko', get_template_directory() . '/languages' );

			// Add theme support for feed links
			add_theme_support( 'automatic-feed-links' );

			// Enable support for Post Thumbnails on posts and pages.
			add_theme_support( 'post-thumbnails' );
			add_image_size( 'keydesign-grid-image', 400, 250, true );
			add_image_size( 'keydesign-left-image', 320, 320, true );

			// Let WordPress manage the document title.
			add_theme_support( 'title-tag' );

			// Enable support for page excerpts
			add_post_type_support( 'page', 'excerpt' );

			// Set up theme navigation locations
			if ( function_exists( 'register_nav_menus' ) ) {
				register_nav_menus(
					array(
					  'header-menu' => 'Header Menu',
						'topbar-menu' => 'Topbar Menu',
						'footer-menu' => 'Footer Menu',
					)
				);
			}

			// Enable support for Post Formats
			add_theme_support( 'post-formats', array(
				'gallery',
				'video',
				'audio',
				'quote',
			) );

			// Switch default core markup for search form, comment form, and comments to output valid HTML5.
			add_theme_support( 'html5', array(
					'search-form',
					'comment-form',
					'comment-list',
					'gallery',
					'caption',
			) );
	}
	add_action( 'after_setup_theme', 'keydesign_setup' );


// ------------------------------------------------------------------------
// Include plugin check, meta boxes, widgets, custom posts
// ------------------------------------------------------------------------

	// Redux theme options config
	include_once( get_template_directory() . '/core/options-init.php' );

	// Theme activation and plugin check
	include_once( get_template_directory() . '/core/theme-activation.php' );

	// Add post meta boxes
	include_once( get_template_directory() . '/core/theme-pagemeta.php' );

	// Register widgetized areas
	include_once( get_template_directory() . '/core/theme-sidebars.php' );

// ------------------------------------------------------------------------
// Content Width
// ------------------------------------------------------------------------

	if ( ! isset( $content_width ) ) $content_width = 1240;

// ------------------------------------------------------------------------
// Blog functionality
// ------------------------------------------------------------------------

	// Custom blog navigation
	function keydesign_link_attributes_1($themetek_output) {
			return str_replace('<a href=', '<a class="next" href=', $themetek_output);
	}
	function keydesign_link_attributes_2($themetek_output) {
			return str_replace('<a href=', '<a class="prev" href=', $themetek_output);
	}

	add_filter('next_post_link', 'keydesign_link_attributes_1');
	add_filter('previous_post_link', 'keydesign_link_attributes_2');

	// Comment reply script enqueued
	function keydesign_enqueue_comments_reply() {
		if( get_option( 'thread_comments' ) )  {
			wp_enqueue_script( 'comment-reply' );
		}
	}
	add_action( 'comment_form_before', 'keydesign_enqueue_comments_reply' );

	// Excerpt length
	if( class_exists( 'ReduxFramework' )) {
		function keydesign_excerpt_length( $length ) {
			$redux_ThemeTek = get_option( 'redux_ThemeTek' );
			return $redux_ThemeTek['tek-blog-excerpt'];
		}
		add_filter( 'excerpt_length', 'keydesign_excerpt_length', 999 );
	}

	// Post tags
	if ( ! function_exists( 'keydesign_output_post_tags' ) ) {
		function keydesign_output_post_tags() {
			get_template_part( 'core/templates/post/partials/content', 'tags' );
		}
	}
	add_action( 'keydesign_post_after_main_content', 'keydesign_output_post_tags', 10, 0 );

	// Post author box
	if ( ! function_exists( 'keydesign_output_post_author_box' ) ) {
		function keydesign_output_post_author_box() {
			$redux_ThemeTek = get_option( 'redux_ThemeTek' );
			if (isset($redux_ThemeTek['tek-author-box']) && $redux_ThemeTek['tek-author-box'] == true) {
				get_template_part( 'core/templates/post/partials/content', 'author' );
			}
		}
	}
	add_action( 'keydesign_post_after_main_content', 'keydesign_output_post_author_box', 20, 0 );

	// Post navigation
	if ( ! function_exists( 'keydesign_output_post_nav' ) ) {
		function keydesign_output_post_nav() {
			$redux_ThemeTek = get_option( 'redux_ThemeTek' );
			if (isset($redux_ThemeTek['tek-blog-single-nav']) && $redux_ThemeTek['tek-blog-single-nav'] == true) {
				get_template_part( 'core/templates/post/partials/content', 'navigation' );
			}
		}
	}
	add_action( 'keydesign_post_after_main_content', 'keydesign_output_post_nav', 40, 0 );


// ------------------------------------------------------------------------
// Output Theme Options custom code
// ------------------------------------------------------------------------

function keydesign_vc_custom_colors() {
		$redux_ThemeTek = get_option( 'redux_ThemeTek' );
		ob_start();
		include_once( get_template_directory() . '/core/dynamic-styles.css.php' );
		$keydesign_custom_colors = ob_get_clean();
		if (class_exists('KEYDESIGN_ADDON_CLASS')) {
			wp_add_inline_style('kd-addon-style', $keydesign_custom_colors);
		} else {
	    wp_add_inline_style('keydesign-style', $keydesign_custom_colors);
		}
}

add_action('wp_enqueue_scripts', 'keydesign_vc_custom_colors');


function keydesign_custom_theme_styles() {
		$redux_ThemeTek = get_option( 'redux_ThemeTek' );
		if ( isset($redux_ThemeTek['tek-css']) ) {
			if (class_exists('KEYDESIGN_ADDON_CLASS')) {
				wp_add_inline_style( 'kd-addon-style', $redux_ThemeTek['tek-css'] );
			} else {
		    wp_add_inline_style( 'keydesign-style', $redux_ThemeTek['tek-css'] );
			}
		}
}
add_action( 'wp_enqueue_scripts', 'keydesign_custom_theme_styles' );

function keydesign_hook_javascript() {
		$redux_ThemeTek = get_option( 'redux_ThemeTek' );
		if( ! empty( $redux_ThemeTek['tek-javascript'] ) || isset( $redux_ThemeTek['tek-javascript'] ) ) {
			wp_add_inline_script( 'keydesign-scripts', $redux_ThemeTek['tek-javascript'] );
		}
}
add_action( 'wp_enqueue_scripts', 'keydesign_hook_javascript' );

// ------------------------------------------------------------------------
// Output Typekit Custom Javascript
// ------------------------------------------------------------------------

	function keydesign_custom_typekit() {
		$redux_ThemeTek = get_option( 'redux_ThemeTek' );
		if ( isset($redux_ThemeTek['tek-typekit']) && $redux_ThemeTek['tek-typekit'] != '' ) {
			wp_enqueue_script( 'keydesign-typekit', '//use.typekit.net/'.esc_js($redux_ThemeTek['tek-typekit']).'.js', array(), '1.0' );
   			wp_add_inline_script( 'keydesign-typekit', 'try{Typekit.load({ async: true });}catch(e){}' );
		}
	}
	add_action('wp_enqueue_scripts', 'keydesign_custom_typekit');


// ------------------------------------------------------------------------
// Theme activation
// ------------------------------------------------------------------------

   add_option( 'keydesign-verify', 'no', '', 'yes' );

// ------------------------------------------------------------------------
// Load maintenance page template
// ------------------------------------------------------------------------

add_action( 'template_include', 'keydesign_maintenance_mode', 1 );
function keydesign_maintenance_mode( $template ) {
	$redux_ThemeTek = get_option( 'redux_ThemeTek' );
	if ( ! class_exists( 'ReduxFramework' ) ) {
		return $template;
	}

	$new_template = locate_template( array( '/core/templates/maintenance-page-template.php' ) );

	if ( $redux_ThemeTek['tek-maintenance-mode'] && !is_user_logged_in() ) {
		return $new_template;
	}

	return $template;
}

// ------------------------------------------------------------------------
// Add boxed body class
// ------------------------------------------------------------------------

if (isset($redux_ThemeTek['tek-layout-style'])) {
	if ($redux_ThemeTek['tek-layout-style'] == 'boxed') {
		add_filter( 'body_class','keydesign_body_class' );
		function keydesign_body_class( $classes ) {
		   $classes[] = 'boxed';
		   return $classes;
		}
	}
}


// ------------------------------------------------------------------------
// Preloader effect
// ------------------------------------------------------------------------

if (isset($redux_ThemeTek['tek-preloader'])) {
	if ($redux_ThemeTek['tek-preloader'] == true) {
		add_filter( 'body_class','keydesign_preloader' );
		function keydesign_preloader( $classes ) {
		   $classes[] = 'loading-effect';
		   $classes[] = 'fade-in';
		   return $classes;
		}
	}
}


// ------------------------------------------------------------------------
// Page transparent navigation
// ------------------------------------------------------------------------


function keydesign_transparent_nav($classes) {
		if( class_exists( 'WooCommerce' ) && is_shop() ) {
		  $post_id = wc_get_page_id( 'shop' );
		} else {
		  $post_id = get_the_ID();
		}

    $page_transparent_navigation = get_post_meta( $post_id, '_themetek_page_transparent_navbar', true );
    if ( !empty($page_transparent_navigation)) {
	    $classes[] = 'transparent-navigation';
    }
    return $classes;
}
add_filter('body_class', 'keydesign_transparent_nav');

if (isset($redux_ThemeTek['tek-blog-transparent-nav'])) {
	if ($redux_ThemeTek['tek-blog-transparent-nav'] == true) {
		add_filter( 'body_class','keydesign_blog_transparent_nav' );
			function keydesign_blog_transparent_nav( $classes ) {
				$classes[] = '';
				if (is_home() || is_search() || is_category() || is_tag() || is_author()) {
			  	$classes[] = 'transparent-navigation';
				}
		   	return $classes;
			}
	}
}

// ------------------------------------------------------------------------
// Replace blog post video structure
// ------------------------------------------------------------------------
if( class_exists( 'KEYDESIGN_ADDON_CLASS' ) ) {
	function keydesign_embed_oembed_html($html, $url, $args) {
		global $post;

		if( false !== strpos( $html, 'youtube.com' ) && has_post_thumbnail() && is_single() ){
			$html = '<div class="entry-video"><div class="video-cover">
	        <div class="background-video-image">'. wp_get_attachment_image(get_post_thumbnail_id(), 'large') .'</div>
	        <div class="play-video"><span class="fa fa-play"></span></div>'. $html .'</div></div>';
		}
	    return $html;
	}
	add_filter('embed_oembed_html','keydesign_embed_oembed_html', 10, 3);
}


// ------------------------------------------------------------------------
// Add numeric pagination to blog listing pages
// ------------------------------------------------------------------------
function keydesign_numeric_posts_nav() {

    if( is_singular() )
        return;

    global $wp_query;

    /** Stop execution if there's only 1 page */
    if( $wp_query->max_num_pages <= 1 )
        return;

    $paged = get_query_var( 'paged' ) ? absint( get_query_var( 'paged' ) ) : 1;
    $max   = intval( $wp_query->max_num_pages );

    /** Add current page to the array */
    if ( $paged >= 1 )
        $links[] = $paged;

    /** Add the pages around the current page to the array */
    if ( $paged >= 3 ) {
        $links[] = $paged - 1;
        $links[] = $paged - 2;
    }

    if ( ( $paged + 2 ) <= $max ) {
        $links[] = $paged + 2;
        $links[] = $paged + 1;
    }

    echo '<nav class="blog-pagination"><ul class="blog-page-numbers">' . "\n";

    /** Previous Post Link */
    if ( get_previous_posts_link() )
        printf( '<li class="prev-post-link">%s</li>' . "\n", get_previous_posts_link() );

    /** Link to first page, plus ellipses if necessary */
    if ( ! in_array( 1, $links ) ) {
        $class = 1 == $paged ? ' class="active"' : '';

        printf( '<li%s><a href="%s">%s</a></li>' . "\n", $class, esc_url( get_pagenum_link( 1 ) ), '1' );

        if ( ! in_array( 2, $links ) )
            echo '<li>...</li>';
    }

    /** Link to current page, plus 2 pages in either direction if necessary */
    sort( $links );
    foreach ( (array) $links as $link ) {
        $class = $paged == $link ? ' class="active"' : '';
        printf( '<li%s><a href="%s">%s</a></li>' . "\n", $class, esc_url( get_pagenum_link( $link ) ), $link );
    }

    /** Link to last page, plus ellipses if necessary */
    if ( ! in_array( $max, $links ) ) {
        if ( ! in_array( $max - 1, $links ) )
            echo '<li>...</li>' . "\n";

        $class = $paged == $max ? ' class="active"' : '';
        printf( '<li%s><a href="%s">%s</a></li>' . "\n", $class, esc_url( get_pagenum_link( $max ) ), $max );
    }

    /** Next Post Link */
    if ( get_next_posts_link() )
        printf( '<li class="next-post-link">%s</li>' . "\n", get_next_posts_link() );

    echo '</ul></nav>' . "\n";

}

// ------------------------------------------------------------------------
// Deactivate OCDI on theme activation
// ------------------------------------------------------------------------
	add_action('admin_init','keydesign_deactivate_ocdi');
	function keydesign_deactivate_ocdi() {
		if( class_exists('OCDI_Plugin') ) {
			deactivate_plugins('one-click-demo-import/one-click-demo-import.php');
		}
	}
