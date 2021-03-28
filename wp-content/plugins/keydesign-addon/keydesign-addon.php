<?php
/*
	Plugin Name: KeyDesign Addon
	Plugin URI: http://keydesign-themes.com/
	Author: KeyDesign
	Author URI: http://keydesign-themes.com/
	Version: 4.2
	Description: KeyDesign Core Plugin for Ekko Theme
	Text Domain: keydesign
*/

/*
	If accesed directly, exit.
*/
if (!defined('ABSPATH')) die('-1');
if (!defined('KEYDESIGN_PLUGIN_PATH')){
	define('KEYDESIGN_PLUGIN_PATH', dirname(__FILE__));
}

	/* Load admin area */
	require_once ( trailingslashit( KEYDESIGN_PLUGIN_PATH ) . 'theme/admin/admin-init.php' );

	/* Import OCDI files */
	require_once ( trailingslashit( KEYDESIGN_PLUGIN_PATH ) . 'theme/vendors/ocdi/one-click-demo-import.php' );

	/* Theme demo import config */
	require_once ( trailingslashit( KEYDESIGN_PLUGIN_PATH ) . 'theme/admin/theme-demo-config.php' );

	/* Theme redux  */
	require_once ( trailingslashit( KEYDESIGN_PLUGIN_PATH ) . 'keydesign-extensions.php' );

	/* Theme page meta boxes  */
	if ( ! file_exists( get_stylesheet_directory() . '/core/theme-pagemeta.php' ) ) {
		require_once ( trailingslashit( KEYDESIGN_PLUGIN_PATH ) . 'theme/admin/theme-pagemeta.php' );
	}

	if( class_exists('WPBakeryShortCode') && get_option( 'keydesign-verify' ) == 'yes' ){
		require_once ( trailingslashit( KEYDESIGN_PLUGIN_PATH ) . 'templates/templates-init.php' );
		require_once ( trailingslashit( KEYDESIGN_PLUGIN_PATH ) . 'templates-panel.php' );
	}

	add_action('admin_init','initiate_keydesign_addon');
	function initiate_keydesign_addon() {
		if( defined('WPB_VC_VERSION') ){
			if( version_compare( 6.0, WPB_VC_VERSION, '>' )){
				add_action( 'admin_notices', 'keydesign_version_notice' );
				add_action( 'network_admin_notices','keydesign_version_notice' );
			}
		} else {
			add_action( 'admin_notices', 'keydesign_activation_notice' );
			add_action( 'network_admin_notices','keydesign_activation_notice' );
		}
	}

	function keydesign_version_notice() {
		$is_multisite = is_multisite();
		$is_network_admin = is_network_admin();
		if( ( $is_multisite && $is_network_admin ) || !$is_multisite ) {
			echo '<div class="updated">
				<p>'.__('The','keydesign').' <strong>Keydesign Addon</strong> '.__('plugin requires','keydesign').' <strong>WPBakery Page Builder</strong> '.__('version 6.0.5 or greater.','keydesign').'</p>
			</div>';
		}
	}

	function keydesign_activation_notice() {
		$is_multisite = is_multisite();
		$is_network_admin = is_network_admin();
		if( ( $is_multisite && $is_network_admin) || !$is_multisite ) {
			echo '<div class="updated">
				<p>'.__('The','keydesign').' <strong>KeyDesign Addon</strong> '.__('plugin requires','keydesign').' <strong>WPBakery Page Builder</strong> '.__('Plugin installed and activated.','keydesign').'</p>
			</div>';
		}
	}

	/*	Load plugin textdomain. */
	add_action( 'plugins_loaded', 'keydesign_addon_load_textdomain' );
	function keydesign_addon_load_textdomain() {
		load_plugin_textdomain( 'keydesign', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
	}

	/* Activation hook */
	register_activation_hook( __FILE__, 'keydesign_addon_activate' );
	function keydesign_addon_activate() {
		update_option( 'keydesign_addon_version', '4.2' );
	}

	/* Allow SVG icon upload */
	add_filter( 'upload_mimes', 'keydesign_svg_upload' );
	function keydesign_svg_upload( $mimes ){
		$mimes['svg'] = 'image/svg+xml';
		return $mimes;
	}

	/* Contact form 7 shortcode init */
	add_action( 'plugins_loaded', 'kd_init_vendor_cf7' );
	function kd_init_vendor_cf7() {
		include_once( ABSPATH . 'wp-admin/includes/plugin.php' ); // Require plugin.php to use is_plugin_active() below
		if ( is_plugin_active( 'contact-form-7/wp-contact-form-7.php' ) || defined( 'WPCF7_PLUGIN' ) ) {
			require_once ( plugin_dir_path( __FILE__ ).'elements/vendors/vendor-contact-form-7.php' );
		} // if contact form7 plugin active
	}

	/* Before VC init */
	add_action( 'vc_before_init', 'keydesign_vc_before_init_actions' );
	function keydesign_vc_before_init_actions() {
		// Force WPBakery Page Builder to initialize as "built into the theme"
		if( function_exists('vc_set_as_theme') ){
			vc_set_as_theme();
		}

		// Link VC elements's folder
    if( function_exists('vc_set_shortcodes_templates_dir') ){
      vc_set_shortcodes_templates_dir( plugin_dir_path( __FILE__ ).'templates/vc-elements' );
		}
	}

	/* After VC init */
	add_action( 'vc_after_init', 'keydesign_vc_after_init_actions' );
	function keydesign_vc_after_init_actions() {

	// Enable VC by default on a list of Post Types
	if ( get_option( 'kd-default-post-types' ) != 'yes' ) {
	if( function_exists('vc_set_default_editor_post_types') ) {
        $list = array(
            'page',
            'post',
            'portfolio',
        );
        vc_set_default_editor_post_types( $list );
		vc_editor_set_post_types($list);
    }
  		 update_option( 'kd-default-post-types', 'yes' );
    }


    if( function_exists('vc_remove_param') ){
      vc_remove_param( 'vc_masonry_grid', 'initial_loading_animation' );
			vc_remove_param( 'vc_masonry_grid', 'filter_color' );
			vc_remove_param( 'vc_masonry_grid', 'filter_size' );
    }

		if ( function_exists('vc_add_param') ) {

        //Add parameters to vc_row
        $base = 'vc_row';

        $attributes = array(
					array(
						'type' => 'checkbox',
						'heading' => esc_html__( 'Fixed background', 'keydesign' ),
						'param_name' => 'kd_fixed_background',
						'description' => esc_html__( 'If checked the background image stays fixed.', 'keydesign' ),
						'group' => esc_html__( 'Background', 'keydesign' ),
					),
					array(
						'type' => 'checkbox',
						'heading' => esc_html__( 'Image overlay', 'keydesign' ),
						'param_name' => 'kd_image_overlay',
						'description' => esc_html__( 'If checked a layer will be applied over the row background image.', 'keydesign' ),
						'group' => esc_html__( 'Background', 'keydesign' ),
					),
					array(
						'type' => 'colorpicker',
						'class' => '',
						'heading' => esc_html__('Overlay color', 'keydesign'),
						'param_name' => 'kd_image_overlay_color',
						'value' => '',
						'dependency' => array(
							 'element' => 'kd_image_overlay',
							 'value'	=> 'true',
				 		),
					 	'group' => esc_html__( 'Background', 'keydesign' ),
					),
					array(
						'type' => 'kd_param_title',
						'text' => 'Top separator',
						'description' => esc_html__( 'Configure top row separator.', 'keydesign' ),
						'param_name' => 'top_section_title',
						'group' => esc_html__( 'Separator', 'keydesign' ),
					),
					array(
						'type' => 'checkbox',
						'heading' => esc_html__( 'Enable top separator', 'keydesign' ),
						'param_name' => 'kd_top_separator',
						'group' => esc_html__( 'Separator', 'keydesign' ),
					),
					array(
						'type' => 'dropdown',
						'heading' => esc_html__( 'Style', 'keydesign' ),
						'param_name' => 'kd_top_separator_style',
						'value' =>	array(
								'Rounded up' => 'rounded-up',
								'Rounded down' => 'rounded-down',
								'Skew left' => 'skew-left',
								'Skew right' => 'skew-right',
								'Big triangle down' => 'arrow-down',
								'Big triangle up' => 'arrow-up',
								'Big triangle left' => 'triangle-left',
								'Big triangle right' => 'triangle-right',
								'Small triangle center' => 'small-triangle',
						),
						'edit_field_class' => 'vc_col-sm-6',
						'dependency' => array(
							 'element' => 'kd_top_separator',
							 'value'	=> 'true',
				 		),
						'save_always' => true,
						'group' => esc_html__( 'Separator', 'keydesign' ),
					),
					array(
						'type' => 'colorpicker',
						'class' => '',
						'heading' => esc_html__('Background', 'keydesign'),
						'param_name' => 'kd_top_separator_bg',
						'edit_field_class' => 'vc_col-sm-6',
						'dependency' => array(
							 'element' => 'kd_top_separator',
							 'value'	=> 'true',
				 		),
					 	'group' => esc_html__( 'Separator', 'keydesign' ),
					),
					array(
						'type' => 'dropdown',
						'heading' => esc_html__( 'Height', 'keydesign' ),
						'param_name' => 'kd_top_separator_height',
						'value' =>	array(
								'Small (50px)' => 'separator-height-small',
								'Medium (100px)' => 'separator-height-medium',
								'Large (150px)' => 'separator-height-large',
						),
						'dependency' => array(
							 'element' => 'kd_top_separator',
							 'value'	=> 'true',
				 		),
						'save_always' => true,
						'group' => esc_html__( 'Separator', 'keydesign' ),
					),
					array(
						'type' => 'kd_param_title',
						'text' => 'Bottom separator',
						'description' => esc_html__( 'Configure bottom row separator.', 'keydesign' ),
						'param_name' => 'bottom_section_title',
						'group' => esc_html__( 'Separator', 'keydesign' ),
					),
					array(
						'type' => 'checkbox',
						'heading' => esc_html__( 'Enable bottom separator', 'keydesign' ),
						'param_name' => 'kd_bottom_separator',
						'group' => esc_html__( 'Separator', 'keydesign' ),
					),
					array(
						'type' => 'dropdown',
						'heading' => esc_html__( 'Style', 'keydesign' ),
						'param_name' => 'kd_bottom_separator_style',
						'value' =>	array(
								'Rounded up' => 'rounded-up',
								'Rounded down' => 'rounded-down',
								'Skew left' => 'skew-left',
								'Skew right' => 'skew-right',
								'Big triangle down' => 'arrow-down',
								'Big triangle up' => 'arrow-up',
								'Big triangle left' => 'triangle-left',
								'Big triangle right' => 'triangle-right',
								'Small triangle center' => 'small-triangle',
						),
						'edit_field_class' => 'vc_col-sm-6',
						'dependency' => array(
							 'element' => 'kd_bottom_separator',
							 'value'	=> 'true',
				 		),
						'save_always' => true,
						'group' => esc_html__( 'Separator', 'keydesign' ),
					),
					array(
						'type' => 'colorpicker',
						'class' => '',
						'heading' => esc_html__('Background', 'keydesign'),
						'param_name' => 'kd_bottom_separator_bg',
						'edit_field_class' => 'vc_col-sm-6',
						'dependency' => array(
							 'element' => 'kd_bottom_separator',
							 'value'	=> 'true',
				 		),
					 	'group' => esc_html__( 'Separator', 'keydesign' ),
					),
					array(
						'type' => 'dropdown',
						'heading' => esc_html__( 'Height', 'keydesign' ),
						'param_name' => 'kd_bottom_separator_height',
						'value' =>	array(
								'Small (50px)' => 'separator-height-small',
								'Medium (100px)' => 'separator-height-medium',
								'Large (150px)' => 'separator-height-large',
						),
						'dependency' => array(
							 'element' => 'kd_bottom_separator',
							 'value'	=> 'true',
				 		),
						'save_always' => true,
						'group' => esc_html__( 'Separator', 'keydesign' ),
					),
				);

				foreach ($attributes as $attribute) {
					vc_add_param( $base, $attribute );
				}

    	}
	}

	if ( ! function_exists( 'kd_output_post_socials' ) ) {
		function kd_output_post_socials() {
			$redux_ThemeTek = get_option( 'redux_ThemeTek' );
			$socials_sharing_content = '<div class="blog-social-sharing">';
			if (isset($redux_ThemeTek['tek-blog-social-sharing-buttons']) && $redux_ThemeTek['tek-blog-social-sharing-buttons']['1'] == '1') {
				$socials_sharing_content .= '
				  <a class="tt_button btn-facebook" target="_blank" href="//www.facebook.com/sharer/sharer.php?u='.get_permalink().'">
				    <span class="btn-text"><i class="fab fa-facebook-f"></i>'.apply_filters( 'blog_share_facebook', esc_html__("Share on Facebook", "keydesign") ).'</span>
				  </a>';
			}
			if (isset($redux_ThemeTek['tek-blog-social-sharing-buttons']) && $redux_ThemeTek['tek-blog-social-sharing-buttons']['2'] == '1') {
				$socials_sharing_content .= '
				  <a class="tt_button btn-twitter" target="_blank" href="//twitter.com/share?url='.get_permalink().'">
				    <span class="btn-text"><i class="fab fa-twitter"></i>'.apply_filters( 'blog_share_twitter', esc_html__("Share on Twitter", "keydesign") ).'</span>
				  </a>';
			}
			if (isset($redux_ThemeTek['tek-blog-social-sharing-buttons']) && $redux_ThemeTek['tek-blog-social-sharing-buttons']['3'] == '1') {
				$socials_sharing_content .= '
				  <a class="tt_button btn-pinterest" target="_blank" href="https://pinterest.com/pin/create/link/?url='.get_permalink().'">
				    <span class="btn-text"><i class="fab fa-pinterest"></i>'.apply_filters( 'blog_share_pinterest', esc_html__("Share on Pinterest", "keydesign") ).'</span>
				  </a>';
			}
			if (isset($redux_ThemeTek['tek-blog-social-sharing-buttons']) && $redux_ThemeTek['tek-blog-social-sharing-buttons']['4'] == '1') {
				$socials_sharing_content .= '
				  <a class="tt_button btn-linkedin" target="_blank" href="https://www.linkedin.com/shareArticle?mini=true&url='.get_permalink().'">
				    <span class="btn-text"><i class="fab fa-linkedin"></i>'.apply_filters( 'blog_share_linkedin', esc_html__("Share on LinkedIn", "keydesign") ).'</span>
				  </a>';
			}
			$socials_sharing_content .= '</div>';
			echo $socials_sharing_content;
		}
	}
	add_filter( 'ekko_post_after_main_content', 'kd_output_post_socials', 30, 0 );

	if ( ! function_exists( 'keydesign_photoswipe' ) ) {
		function keydesign_photoswipe() {
			if ( file_exists( dirname( __FILE__ ) . '/elements/templates/photoswipe.php' ) ) {
        require_once dirname( __FILE__ ) . '/elements/templates/photoswipe.php';
    	}
		}
	}

if (!class_exists('KEYDESIGN_ADDON_CLASS')) {
	class KEYDESIGN_ADDON_CLASS {
		function __construct() {
			$this->elements_folder	=	plugin_dir_path( __FILE__ ).'elements/';
			$this->templates_folder	=	plugin_dir_path( __FILE__ ).'templates/';
			$this->params_dir = plugin_dir_path( __FILE__ ).'params/';
			add_action( 'after_setup_theme', array( $this, 'integrate_with_vc' ) );
			add_action( 'wp_enqueue_scripts', array( $this, 'keydesign_load_front_scripts' ) );
			add_action( 'vc_load_iframe_jscss', array( $this, 'keydesign_load_front_editor_scripts' ) );
			add_action( 'admin_enqueue_scripts', array( $this, 'keydesign_load_admin_scripts') );
			add_action( 'init', array( $this, 'keydesign_init_portfolio_cpt' ) );
			$this->keydesign_templates();
		}

		public function keydesign_templates() {
			if( class_exists('WPBakeryShortCode') && get_option( 'keydesign-verify' ) == 'yes' ){
				$KeyDesignTemplates = new KeyDesign_Vc_Templates_Panel_Editor();
				return $KeyDesignTemplates->init();
			}
		}

		public function keydesign_init_portfolio_cpt() {
			if ( function_exists( 'ekko_get_option' ) ) {
				if ( ekko_get_option( 'tek-portfolio-cpt' ) ) {
					require_once ( trailingslashit( KEYDESIGN_PLUGIN_PATH ) . 'custom-post-type.php' );
				}
			}
		}

		public function integrate_with_vc() {
			if( class_exists( 'WPBakeryShortCode' ) ) {
				foreach(glob($this->elements_folder."/*.php") as $elem) {
					require_once($elem);
				}
				foreach(glob($this->params_dir."/*.php") as $param)
				{
					require_once($param);
				}
			}
		}

		public function keydesign_load_front_editor_scripts() {
			wp_enqueue_script( 'masonry' );
			wp_enqueue_script( 'kd_easypiechart_script', plugins_url('assets/js/jquery.easypiechart.min.js', __FILE__), array('jquery') );
			wp_enqueue_script( 'kd_easytabs_script', plugins_url('assets/js/jquery.easytabs.min.js', __FILE__), array('jquery') );
			wp_enqueue_script( 'kd_countdown_script', plugins_url('assets/js/jquery.countdown.js', __FILE__), array('jquery') );
			wp_enqueue_script( 'kd_countto', plugins_url('assets/js/kd_countto.js', __FILE__), array('jquery') );
			wp_enqueue_script( 'kd_front_editor', plugins_url('assets/js/kd_addon_front.js', __FILE__), array('jquery'),'2' );
		}

		public function keydesign_load_front_scripts() {

			// Register & Load plug-in main style sheet
			wp_register_style( 'kd-addon-style', plugins_url('assets/css/kd_vc_front.css',  __FILE__), array('keydesign-style') );
			wp_enqueue_style( 'kd-addon-style' );

			// Easing Script
			wp_register_script( 'kd_easing_script', plugins_url('assets/js/jquery.easing.min.js', __FILE__), array('jquery') );
			wp_enqueue_script ( 'kd_easing_script' );

			// Owl Carousel
			wp_register_script( 'kd_carousel_script', plugins_url('assets/js/owl.carousel.min.js', __FILE__), array('jquery') );
			wp_enqueue_script ( 'kd_carousel_script' );

			// Easy Tabs
			wp_register_script( 'kd_easytabs_script', plugins_url('assets/js/jquery.easytabs.min.js', __FILE__), array('jquery') );

	    // Countdown Element
			wp_register_script( 'kd_countdown_script', plugins_url('assets/js/jquery.countdown.js', __FILE__), array('jquery') );

			// Pie Chart Element
			wp_register_script( 'kd_easypiechart_script', plugins_url('assets/js/jquery.easypiechart.min.js', __FILE__), array('jquery') );

			// Event session Element
			wp_register_script( 'kd_jquery_appear', plugins_url('assets/js/jquery.appear.js', __FILE__), array('jquery') );
			wp_enqueue_script ( 'kd_jquery_appear' );

			// Register & Load Photoswipe
			wp_register_style( 'photoswipe', plugins_url('assets/css/photoswipe.css', __FILE__), 'all' );
			wp_register_script( 'photoswipejs', plugins_url('assets/js/photoswipe.min.js', __FILE__), array('jquery') );

			// Progressbar element
			wp_register_script( 'kd_progressbar', plugins_url('assets/js/kd_progressbar.js', __FILE__), array('jquery') );

			// Counter element
			wp_register_script( 'kd_countto', plugins_url('assets/js/kd_countto.js', __FILE__), array('jquery') );

			// FontAwesome font pack resources
			wp_register_style( 'font-awesome', plugins_url( 'assets/css/font-awesome.min.css', __FILE__) );

			// Plugin Front End Script
			wp_register_script( 'kd_addon_script', plugins_url('assets/js/kd_addon_script.js?ver=5.5', __FILE__), array('jquery') );
			wp_enqueue_script ( 'kd_addon_script' );
		}

		public function keydesign_load_admin_scripts() {
			wp_enqueue_style( 'keydesign-iconsmind', plugins_url('assets/css/iconsmind.min.css', __FILE__));
			wp_enqueue_style( 'kd_addon_backend_style', plugins_url('assets/admin/css/kd_vc_backend.css', __FILE__));
			wp_enqueue_script( 'kd_addon_backend_script', plugins_url('assets/admin/js/kd_addon_backend.js', __FILE__));
		}

	}
}
// Finally initialize code
new KEYDESIGN_ADDON_CLASS();
