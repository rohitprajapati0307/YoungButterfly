<?php
// ------------------------------------------------------------------------
// Include the TGM_Plugin_Activation class
// ------------------------------------------------------------------------

include_once (get_template_directory() . '/core/assets/extra/class-tgm-plugin-activation.php');

// Register the required plugins for this theme.

if (!function_exists('keydesign_register_plugins'))
	{
	function keydesign_register_plugins()
		{
		$plugins = array(
			array(
				'name' => esc_html__('Redux Framework', 'ekko'),
				'slug' => 'redux-framework',
				'required' => true,
			),
			array(
				'name' => esc_html__('WPBakery Page Builder', 'ekko'),
				'slug' => 'js_composer',
				'source' => KEYDESIGN_THEME_PLUGINS_DIR . '/js_composer.zip',
				'required' => true,
				'version' => '6.1',
				'force_activation' => false,
				'force_deactivation' => false,
			),
			array(
				'name' => esc_html__('KeyDesign Addon', 'ekko'),
				'slug' => 'keydesign-addon',
				'source' => 'http://www.ekko-wp.com/external/keydesign-addon.zip',
				'required' => true,
				'version' => '2.9',
				'force_activation' => false,
				'force_deactivation' => false,
				'external_url' => 'http://www.ekko-wp.com/external/keydesign-addon.zip',
			),
			array(
				'name' => esc_html__('Slider Revolution', 'ekko'),
				'slug' => 'revslider',
				'source' => KEYDESIGN_THEME_PLUGINS_DIR . '/revslider.zip',
				'required' => true,
				'version' => '6.1.8',
				'force_activation' => false,
				'force_deactivation' => false,
			),
			array(
				'name' => esc_html__('WooCommerce', 'ekko'),
				'slug' => 'woocommerce',
				'required' => false,
			),
			array(
				'name' => esc_html__('Contact Form 7', 'ekko'),
				'slug' => 'contact-form-7',
				'required' => true,
			),
			array(
				'name' => esc_html__('Breadcrumb NavXT', 'ekko'),
				'slug' => 'breadcrumb-navxt',
				'required' => false,
			),
		);

		$config = array(
			'id' => 'tgmpa',
			'domain' => 'ekko',
			'default_path' => '',
			'parent_slug' => 'themes.php',
			'capability' => 'edit_theme_options',
			'menu' => 'install-required-plugins',
			'has_notices' => true,
			'is_automatic' => false,
			'message' => '',
			'strings' => array(
				'page_title' => esc_html__('Install Required Plugins', 'ekko'),
				'menu_title' => esc_html__('Install Plugins', 'ekko'),
				'installing' => esc_html__('Installing Plugin: %s', 'ekko'),
				'oops' => esc_html__('Something went wrong with the plugin API.', 'ekko') ,
				'notice_can_install_required' => esc_html__('This theme requires the following plugin: %1$s.', 'ekko'),
				'notice_can_install_recommended' => esc_html__('This theme recommends the following plugin: %1$s.', 'ekko'),
				'notice_cannot_install' => esc_html__('Sorry, but you do not have the correct permissions to install the %s plugin. Contact the administrator of this site for help on getting the plugin installed.', 'ekko'),
				'notice_can_activate_required' => esc_html__('The following required plugin is currently inactive: %1$s.', 'ekko'),
				'notice_can_activate_recommended' => esc_html__('The following recommended plugin is currently inactive: %1$s.', 'ekko'),
				'notice_cannot_activate' => esc_html__('Sorry, but you do not have the correct permissions to activate the %s plugin. Contact the administrator of this site for help on getting the plugin activated.', 'ekko'),
				'notice_ask_to_update' => esc_html__('The following plugin needs to be updated to its latest version to ensure maximum compatibility with this theme: %1$s.', 'ekko'),
				'notice_cannot_update' => esc_html__('Sorry, but you do not have the correct permissions to update the %s plugin. Contact the administrator of this site for help on getting the plugin updated.', 'ekko'),
				'install_link' => esc_html__('Begin installing plugin', 'ekko') ,
				'activate_link' => esc_html__('Activate installed plugin', 'ekko') ,
				'return' => esc_html__('Return to Required Plugins Installer', 'ekko') ,
				'plugin_activated' => esc_html__('Plugin activated successfully.', 'ekko') ,
				'complete' => esc_html__('All plugins installed and activated successfully. %s', 'ekko'),
				'nag_type' => 'updated'
			)
		);
		tgmpa($plugins, $config);
		}
	}

add_action('tgmpa_register', 'keydesign_register_plugins');
?>
