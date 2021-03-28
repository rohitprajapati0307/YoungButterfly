<?php
/**
 * Theme header
 * @package ekko
 * by KeyDesign
 */
 ?>

<?php
  $redux_ThemeTek = get_option( 'redux_ThemeTek' );

  $wrapper_class = $navbar_class = $main_menu_class = $hide_title_section_class = $disable_animations_class = $button_hover_class =
  $nav_full_class = $fixed_menu_class = $enable_topbar_class = $sticky_topbar_class = $secondary_logo_class =
  $trans_sec_logo_class = $main_nav_alignment = $single_post_template = $dropdown_hover_effect = $header_bttns_wrapper = '';

  $themetek_page_showhide_title_section = get_post_meta( get_the_ID(), '_themetek_page_showhide_title_section', true );
  if ($themetek_page_showhide_title_section && !is_search()) {
    $hide_title_section_class = 'hide-title-section';
  }

  if (isset($redux_ThemeTek['tek-disable-animations']) && $redux_ThemeTek['tek-disable-animations'] == true ) {
    $disable_animations_class = 'no-mobile-animation';
  }

  if (isset($redux_ThemeTek['tek-btn-effect']) && $redux_ThemeTek['tek-btn-effect'] != '' ) {
    $button_hover_class = $redux_ThemeTek['tek-btn-effect'];
  }

  if (isset($redux_ThemeTek['tek-menu-style']) && $redux_ThemeTek['tek-menu-style'] == '2') {
    $nav_full_class = 'full-width';
  }

  if (isset($redux_ThemeTek['tek-menu-behaviour']) && $redux_ThemeTek['tek-menu-behaviour'] == '2') {
    $fixed_menu_class = 'fixed-menu';
  }

  if (isset($redux_ThemeTek['tek-topbar']) && $redux_ThemeTek['tek-topbar'] == '1') {
    $enable_topbar_class = 'with-topbar';
  }

  if (isset($redux_ThemeTek['tek-topbar-sticky']) && $redux_ThemeTek['tek-topbar-sticky'] == '1') {
    $sticky_topbar_class = 'with-topbar-sticky';
  }

  if (isset($redux_ThemeTek['tek-sticky-nav-logo']) && $redux_ThemeTek['tek-sticky-nav-logo'] == 'nav-secondary-logo') {
    $secondary_logo_class = 'nav-secondary-logo';
  }

  if (isset($redux_ThemeTek['tek-transparent-nav-logo']) && $redux_ThemeTek['tek-transparent-nav-logo'] == 'nav-secondary-logo' ) {
    $trans_sec_logo_class = 'nav-transparent-secondary-logo';
  }

  if (isset($redux_ThemeTek['tek-menu-alignment']) && $redux_ThemeTek['tek-menu-alignment'] == 'main-nav-left') {
    $main_nav_alignment = 'main-nav-left';
  } elseif ( $redux_ThemeTek['tek-menu-alignment'] == 'main-nav-center' ) {
    $main_nav_alignment = 'main-nav-center';
  } elseif ( $redux_ThemeTek['tek-menu-alignment'] == 'main-nav-right' ) {
    $main_nav_alignment = 'main-nav-right';
  } else {
    $main_nav_alignment = 'main-nav-right';
  }

  if (isset($redux_ThemeTek['tek-single-post-template']) && is_singular('post')) {
		$single_post_template = $redux_ThemeTek['tek-single-post-template'];
	}

  if (isset($redux_ThemeTek['tek-dropdown-nav-hover']) && $redux_ThemeTek['tek-dropdown-nav-hover'] != '' ) {
    $dropdown_hover_effect = $redux_ThemeTek['tek-dropdown-nav-hover'];
  } else {
    $dropdown_hover_effect = 'default-dropdown-effect';
  }

  if (isset($redux_ThemeTek['tek-modal-button']) || isset($redux_ThemeTek['tek-panel-button'])) {
    if($redux_ThemeTek['tek-modal-button'] || $redux_ThemeTek['tek-panel-button']) {
      $header_bttns_wrapper = true;
    }
  }

  $wrapper_class = implode(' ', array($hide_title_section_class, $disable_animations_class, $button_hover_class, $single_post_template));
  $navbar_class = implode(' ', array('navbar', 'navbar-default', 'navbar-fixed-top', $button_hover_class, $nav_full_class, $fixed_menu_class, $enable_topbar_class, $sticky_topbar_class, $secondary_logo_class, $trans_sec_logo_class ));
  $main_menu_class = implode(' ', array('collapse', 'navbar-collapse', $dropdown_hover_effect));
?>
<!DOCTYPE html>
<html <?php language_attributes( 'html' ); ?>>
   <head>
      <meta charset="<?php echo esc_attr( get_bloginfo( 'charset' ) ); ?>">
      <meta name="viewport" content="width=device-width, initial-scale=1.0" />
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <?php if (isset($redux_ThemeTek['tek-main-color']) && $redux_ThemeTek['tek-main-color'] != '' ) : ?>
        <meta name="theme-color" content="<?php echo esc_attr($redux_ThemeTek['tek-main-color']); ?>" />
      <?php endif; ?>
      <link rel="profile" href="http://gmpg.org/xfn/11">
      <?php if ( ! function_exists( 'has_site_icon' ) || ! has_site_icon() ) : ?>
        <link href="<?php echo esc_url($redux_ThemeTek['tek-favicon']['url']); ?>" rel="icon">
      <?php endif; ?>
      <link rel="pingback" href="<?php esc_url(bloginfo( 'pingback_url' )); ?>" />
      <?php wp_head(); ?>
   </head>
    <body <?php body_class();?>>

      <nav class="<?php echo esc_attr( trim( $navbar_class ) ); ?>" >
        <?php /* Topbar template */ ?>
        <?php if( !empty($redux_ThemeTek['tek-topbar']) && $redux_ThemeTek['tek-topbar'] == 1 ) : ?>
          <?php get_template_part( 'core/templates/header/content', 'topbar' ); ?>
        <?php endif; ?>
        <?php /* END Topbar template */ ?>

        <div class="menubar <?php echo esc_attr($main_nav_alignment); ?>">
          <div class="container">
           <div id="logo">
             <?php if (isset($redux_ThemeTek['tek-logo-style']) && $redux_ThemeTek['tek-logo-style'] != '' ) : ?>
               <?php if ($redux_ThemeTek['tek-logo-style'] == '1') : ?>
                 <?php /* Image logo */ ?>
                 <a class="logo" href="<?php echo esc_url(home_url()); ?>">
                   <?php if (isset($redux_ThemeTek['tek-logo']['url'])) { ?>
                     <img class="fixed-logo" src="<?php echo esc_url($redux_ThemeTek['tek-logo']['url']); ?>"  width="<?php echo esc_attr($redux_ThemeTek['tek-logo-size']['width']);?>" alt="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" />

                     <?php if (isset($redux_ThemeTek['tek-logo2']['url']) && $redux_ThemeTek['tek-logo2']['url'] != '' ) { ?>
                     <img class="nav-logo" src="<?php echo esc_url($redux_ThemeTek['tek-logo2']['url']); ?>"  width="<?php echo esc_attr($redux_ThemeTek['tek-logo-size']['width']);?>" alt="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" />
                     <?php } ?>

                   <?php } else { ?>
                     <img class="fixed-logo" src="<?php echo esc_url(get_template_directory_uri() . '/core/assets/images/logo.png'); ?>" alt="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" />
                     <img class="nav-logo" src="<?php echo esc_url(get_template_directory_uri() . '/core/assets/images/logo-2.png'); ?>" alt="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" />
                   <?php } ?>
                 </a>
               <?php elseif ($redux_ThemeTek['tek-logo-style'] == '2') : ?>
                 <?php /* Text logo */ ?>
                 <a class="logo" href="<?php echo esc_url(home_url()); ?>"><?php echo esc_html($redux_ThemeTek['tek-text-logo']);?></a>
               <?php endif; ?>
             <?php endif; ?>
             <?php if (!isset($redux_ThemeTek['tek-logo']['url']) && !isset($redux_ThemeTek['tek-text-logo']) ) : ?>
                <a class="logo blog-info-name" href="<?php echo esc_url(site_url()); ?>"><?php bloginfo( 'name' ); ?></a>
             <?php endif; ?>
           </div>
           <div class="navbar-header page-scroll">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#main-menu">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    </button>
                    <div class="mobile-cart">
                      <?php if (isset($redux_ThemeTek['tek-woo-display-cart-icon']) && ($redux_ThemeTek['tek-woo-display-cart-icon'] == '1')) {
                          if( class_exists( 'WooCommerce' ) && (isset($redux_ThemeTek['tek-topbar'])) && ($redux_ThemeTek['tek-topbar'] == '1')) {
                              $keydesign_minicart = '';
                              $keydesign_minicart = keydesign_add_cart_in_menu();
                              echo do_shortcode( shortcode_unautop( $keydesign_minicart ) );
                          }
                        } ?>
                    </div>
            </div>
            <div id="main-menu" class="<?php echo esc_attr( trim( $main_menu_class ) ); ?>">
               <?php wp_nav_menu( array( 'theme_location' => 'header-menu', 'depth' => 3, 'container' => false, 'menu_class' => 'nav navbar-nav', 'fallback_cb' => 'wp_bootstrap_navwalker::fallback', 'walker' => new wp_bootstrap_navwalker()) ); ?>
            </div>
            <?php if (class_exists( 'WooCommerce' ) ) {
              if (isset($redux_ThemeTek['tek-topbar']) && ($redux_ThemeTek['tek-topbar'] == '0')) {
                if( isset($redux_ThemeTek['tek-woo-display-cart-icon']) && ($redux_ThemeTek['tek-woo-display-cart-icon'] == '1')) {
                  $keydesign_minicart = '';
                  $keydesign_minicart = keydesign_add_cart_in_menu();
                  echo do_shortcode( shortcode_unautop( $keydesign_minicart ) );
                }
              }
            } ?>
            <?php if ($header_bttns_wrapper) : ?>
              <div class="header-bttn-wrapper">
            <?php endif; ?>
            <?php /* Modal Header Button */ ?>
            <?php if ($redux_ThemeTek['tek-modal-button']){
                get_template_part( 'core/templates/header/content', 'modal-button' );
            } ?>
            <?php /* END Modal Header Button */ ?>

            <?php /* Side Panel Header Button */ ?>
            <?php if ($redux_ThemeTek['tek-panel-button']){
                get_template_part( 'core/templates/header/content', 'panel-button' );
            } ?>
            <?php /* END Side Panel Header Button */ ?>
            <?php if ($header_bttns_wrapper) : ?>
              </div>
            <?php endif; ?>
            </div>
         </div>
      </nav>

      <div id="wrapper" class="<?php echo esc_attr( trim( $wrapper_class ) ); ?>">
        <?php if (is_home() && $redux_ThemeTek['tek-blog-header-template'] == 'blog-header-revslider') {
            if (isset($redux_ThemeTek['tek-blog-header-slider-alias']) && $redux_ThemeTek['tek-blog-header-slider-alias'] != '' ) : ?>
             <div id="kd-blog-slider" class="container">
                <?php echo do_shortcode('[rev_slider alias="'. esc_attr($redux_ThemeTek['tek-blog-header-slider-alias']). '"]' ); ?>
             </div>
           <?php endif; ?>
        <?php } else {
            get_template_part( 'core/templates/header/content', 'title-bar' );
          }
        ?>
