<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}

$redux_ThemeTek = get_option( 'redux_ThemeTek' );
$social_icon_class = $content_to_display = $topbar_left_content = $topbar_right_content = $topbar_content_design = $topbar_left_empty = $topbar_right_empty = '';

if ( ! function_exists( 'kd_topbar_content' ) ) {
	function kd_topbar_content ( $topbar_section ) {
    $redux_ThemeTek = get_option( 'redux_ThemeTek' );
		$section_content  = '';
		$content_to_display = $redux_ThemeTek[$topbar_section];

		if ( 'contact-info' === $content_to_display ) {
      $section_content = '<div class="topbar-contact">';
      if (isset($redux_ThemeTek['tek-business-phone']) && $redux_ThemeTek['tek-business-phone'] != '' ) {
          $section_content .= '<span class="topbar-phone"><i class="fa fa-phone"></i><a href="tel:'. esc_attr($redux_ThemeTek['tek-business-phone']) .'">'. esc_html($redux_ThemeTek['tek-business-phone']) .'</a></span>';
      }
      if (isset($redux_ThemeTek['tek-business-email']) && $redux_ThemeTek['tek-business-email'] != '' ) {
          $section_content .= '<span class="topbar-email"><i class="fa fa-envelope-o"></i><a href="mailto:'. esc_attr($redux_ThemeTek['tek-business-email']) .'">'. esc_html($redux_ThemeTek['tek-business-email']) .'</a></span>';
      }
      if (isset($redux_ThemeTek['tek-business-opening-hours']) && $redux_ThemeTek['tek-business-opening-hours'] != '' ) {
          $section_content .= '<span class="topbar-opening-hours"><i class="fa fa-clock-o"></i>'. esc_html($redux_ThemeTek['tek-business-opening-hours']) .'</span>';
      }
      $section_content .= '</div>';
		} elseif ( 'social-links' === $content_to_display ) {
      $section_content = '<div class="topbar-socials">';
      if( class_exists( 'ReduxFramework' )) {
        $section_content .= do_shortcode('[social_profiles]');
      }
      $section_content .= '</div>';
		} elseif ( 'navigation' === $content_to_display ) {
      $section_content = '<div class="topbar-menu">';
      if ( has_nav_menu( 'topbar-menu' ) ) {
          $section_content .= wp_nav_menu( array( 'theme_location' => 'topbar-menu', 'depth' => 1, 'container' => false, 'menu_class' => 'navbar-topbar', 'fallback_cb' => 'false', 'echo' => false ) );
      }
      $section_content .= '</div>';
		}

		return $section_content;
	}
}

if (isset($redux_ThemeTek['tek-topbar-content-design']) && 'empty' != $redux_ThemeTek['tek-topbar-content-design']) {
	$topbar_content_design = $redux_ThemeTek['tek-topbar-content-design'];
}

$topbar_left_content = kd_topbar_content( 'tek-topbar-left-content' );
$topbar_right_content = kd_topbar_content( 'tek-topbar-right-content' );

if ( $redux_ThemeTek['tek-topbar-left-content'] == 'empty' ) {
	$topbar_left_empty = 'content-empty';
}
if ( $redux_ThemeTek['tek-topbar-right-content'] == 'empty' ) {
	$topbar_right_empty = 'content-empty';
}
?>

<?php if ($redux_ThemeTek['tek-topbar']) : ?>
  <?php if ( 'empty' != $redux_ThemeTek['tek-topbar-left-content'] || 'empty' != $redux_ThemeTek['tek-topbar-right-content'] ) : ?>
	<div class="topbar <?php echo esc_attr($topbar_content_design); ?>">
		<div class="container">
			<div class="topbar-left-content <?php echo esc_attr($topbar_left_empty); ?>">
				<?php
				// This variable ($topbar_left_content) has been safely escaped in the following file: ekko/core/templates/header/content-topbar.php Lines: 10-44
				?>
				<?php echo $topbar_left_content; ?>
			</div>
			<div class="topbar-right-content <?php echo esc_attr($topbar_right_empty); ?>">
				<?php
				// This variable ($topbar_right_content) has been safely escaped in the following file: ekko/core/templates/header/content-topbar.php Lines: 10-44
				?>
				<?php echo $topbar_right_content; ?>
			</div>
			<div class="topbar-extra-content">
        <?php if( !empty($redux_ThemeTek['tek-topbar-search']) && $redux_ThemeTek['tek-topbar-search'] == 1 ) : ?>
            <div class="topbar-search">
               <span class="toggle-search fa-search fa"></span>
               <div class="topbar-search-container">
                 <?php get_search_form(); ?>
               </div>
            </div>
        <?php endif; ?>

        <?php if ( function_exists('wpml_loaded') ) : ?>
            <div class="topbar-lang-switcher">
              <div class="lang-switcher-wpml">
                <?php do_action( 'wpml_add_language_selector' ); ?>
              </div>
            </div>
        <?php elseif ( class_exists('Polylang') && function_exists('pll_the_languages')) : ?>
            <div class="topbar-lang-switcher">
              <ul class="lang-switcher-polylang">
                <?php pll_the_languages( array( 'show_flags' => 1,'show_names' => 1) ); ?>
              </ul>
            </div>
        <?php endif; ?>

        <?php if (class_exists( 'WooCommerce' )) {
            if( isset($redux_ThemeTek['tek-woo-display-cart-icon']) && ($redux_ThemeTek['tek-woo-display-cart-icon'] == '1')) {
                $keydesign_minicart = '';
                $keydesign_minicart = keydesign_add_cart_in_menu();
                echo do_shortcode( shortcode_unautop( $keydesign_minicart ) );
            }
        } ?>
			</div>
		</div>
	</div>
  <?php endif; ?>
<?php endif; ?>
