<?php
/**
*ReduxFramework Sample Config File
*For full documentation, please visit: https://docs.reduxframework.com
**/
if (!class_exists('keydesign_Redux_Framework_config')) {
    class keydesign_Redux_Framework_config
    {
        public $args = array();
        public $sections = array();
        public $theme;
        public $ReduxFramework;
        public function __construct()
        {
            if (!class_exists('ReduxFramework')) {
                return;
            }
            // This is needed. Bah WordPress bugs.  ;)
            if (true == Redux_Helpers::isTheme(__FILE__)) {
                $this->initSettings();
            } else {
                add_action('plugins_loaded', array(
                    $this,
                    'initSettings'
                ), 10);
            }
        }
        public function initSettings()
        {
            // Just for demo purposes. Not needed per say.
            $this->theme = wp_get_theme();
            // Set the default arguments
            $this->setArguments();
            // Set a few help tabs so you can see how it's done
            $this->setSections();
            if (!isset($this->args['opt_name'])) { // No errors please
                return;
            }
            $this->ReduxFramework = new ReduxFramework($this->sections, $this->args);
        }
        /**
        * Custom function for filtering the sections array. Good for child themes to override or add to the sections.
        * Simply include this function in the child themes functions.php file.

        * NOTE: the defined constants for URLs, and directories will NOT be available at this point in a child theme,
        * so you must use get_template_directory_uri() if you want to use any of the built in icons
        **/
        function dynamic_section($sections)
        {
            //$sections = array();
            $sections[] = array(
                'title' => esc_html__('Section via hook', 'ekko'),
                'desc' => esc_html__('This is a section created by adding a filter to the sections array. Can be used by child themes to add/remove sections from the options.', 'ekko'),
                'icon' => 'el-icon-paper-clip',
                // Leave this as a blank section, no options just some intro text set above.
                'fields' => array()
            );
            return $sections;
        }
        /**
        *Filter hook for filtering the args. Good for child themes to override or add to the args array. Can also be used in other functions.
        **/
        function change_arguments($args)
        {
            //$args['dev_mode'] = true;
            return $args;
        }
        /**
        * Filter hook for filtering the default value of any given field. Very useful in development mode.
        **/
        function change_defaults($defaults)
        {
            $defaults['str_replace'] = 'Testing filter hook!';
            return $defaults;
        }
        public function setSections()
        {
            /**
            *Used within different fields. Simply examples. Search for ACTUAL DECLARATION for field examples
            **/
            // Background Patterns Reader
            $sample_patterns_path = ReduxFramework::$_dir . '../sample/patterns/';
            $sample_patterns_url  = ReduxFramework::$_url . '../sample/patterns/';
            $sample_patterns      = array();
            ob_start();
            $ct              = wp_get_theme();
            $this->theme     = $ct;
            $item_name       = $this->theme->get('Name');
            $tags            = $this->theme->Tags;
            $screenshot      = $this->theme->get_screenshot();
            $class           = $screenshot ? 'has-screenshot' : '';
            $customize_title = sprintf(esc_html__('Customize &#8220;%s&#8221;', 'ekko'), $this->theme->display('Name'));
?>
    <div id="current-theme" class="<?php
            echo esc_attr($class);
?>
        ">
        <?php
            if ($screenshot):
?>
        <?php
                if (current_user_can('edit_theme_options')):
?>
        <a href="<?php
                    echo esc_url(wp_customize_url());
?>
            " class="load-customize hide-if-no-customize" title="
            <?php
                    echo esc_attr($customize_title);
?>
            ">
            <img src="<?php
                    echo esc_url($screenshot);
?>
            " alt="
            <?php
                    esc_attr_e('Current theme preview','ekko');
?>" /></a>
        <?php
                endif;
?>
        <img class="hide-if-customize" src="<?php
                echo esc_url($screenshot);
?>
        " alt="
        <?php
                esc_attr_e('Current theme preview','ekko');
?>
        " />
        <?php
            endif;
?>

        <h4>
            <?php
            echo esc_attr($this->theme->display('Name'));
?></h4>

        <div>
            <ul class="theme-info">
                <li>
                    <?php
            printf(esc_html__('By %s', 'ekko'), $this->theme->display('Author'));
?></li>
                <li>
                    <?php
            printf(esc_html__('Version %s', 'ekko'), $this->theme->display('Version'));
?></li>
                <li>
                    <?php
            echo '<strong>' . esc_html__('Tags', 'ekko') . ':</strong>
                ';
?>
                <?php
            printf($this->theme->display('Tags'));
?></li>
        </ul>
        <p class="theme-description">
            <?php
            echo esc_attr($this->theme->display('Description'));
?></p>

    </div>
</div>

<?php
            $item_info = ob_get_contents();
            ob_end_clean();
            $sampleHTML = '';
            // ACTUAL DECLARATION OF SECTIONS

            $this->sections[] = array(
                'icon' => 'el-icon-bookmark',
                'title' => esc_html__('Business Info', 'ekko'),
                'fields' => array(
                    array(
                        'id' => 'tek-business-phone',
                        'type' => 'text',
                        'title' => esc_html__('Business Phone', 'ekko'),
                        'default' => '(222) 400-630',
                    ),
                    array(
                        'id' => 'tek-business-email',
                        'type' => 'text',
                        'title' => esc_html__('Business Email', 'ekko'),
                        'default' => 'contact@ekko.com',
                    ),
                    array(
                        'id' => 'tek-business-opening-hours',
                        'type' => 'text',
                        'title' => esc_html__('Business Opening Hours', 'ekko'),
                        'default' => 'Mon - Fri: 10:00 - 22:00',
                    ),
                    array(
                        'id'            => 'tek-social-profiles',
                        'type'          => 'social_profiles',
                        'title'         => 'Social Icons',
                        'subtitle'      => 'Click on icon to activate it, drag and drop to change the icon order.',
                    ),
                )
            );

            $this->sections[] = array(
                'icon' => 'el-icon-globe',
                'title' => esc_html__('Global Options', 'ekko'),
                'fields' => array(
                    array(
                        'id' => 'tek-preloader',
                        'type' => 'switch',
                        'title' => esc_html__('Preloader', 'ekko'),
                        'subtitle' => esc_html__('Turn on to display a preloader screen before loading the page.', 'ekko'),
                        'default' => true
                    ),
                    array(
                        'id' => 'tek-smooth-scroll',
                        'type' => 'switch',
                        'title' => esc_html__('Smooth Mouse Scroll', 'ekko'),
                        'subtitle' => esc_html__('Turn on to replace basic website scrolling effect with nice smooth scroll.', 'ekko'),
                        'default' => false
                    ),
                    array(
                        'id' => 'tek-backtotop',
                        'type' => 'switch',
                        'title' => esc_html__(' Go to Top Button', 'ekko'),
                        'subtitle' => esc_html__('Turn on to display a "Go to top" button in the right bottom corner the page.', 'ekko'),
                        'default' => true
                    ),
                    array(
                        'id' => 'tek-google-api',
                        'type' => 'text',
                        'title' => esc_html__('Google Map API Key', 'ekko'),
                        'default' => '',
                        'subtitle' => esc_html__('Generate, copy and paste here Google Maps API Key.', 'ekko'),
                    ),
                    array(
                        'id' => 'tek-disable-animations',
                        'type' => 'switch',
                        'title' => esc_html__('Disable Animations on Mobile', 'ekko'),
                        'subtitle' => esc_html__('Turn on/off element animation on mobile.', 'ekko'),
                        'default' => true
                    ),
                )
            );

            $this->sections[] = array(
                'title' => esc_html__('Color Schemes', 'ekko'),
                'subsection' => true,
                'fields' => array(
                  array(
                    'id' => 'tek-main-color',
                    'type' => 'color',
                    'transparent' => false,
                    'title' => esc_html__('Primary Accent Color', 'ekko'),
                    'default' => '#25b15f',
                    'validate' => 'color'
                  ),

                  array(
                    'id' => 'tek-secondary-color',
                    'type' => 'color',
                    'transparent' => false,
                    'title' => esc_html__('Secondary Accent Color', 'ekko'),
                    'default' => '#000000',
                    'validate' => 'color'
                  ),

                  array(
                    'id' => 'tek-titlebar-color',
                    'type' => 'color',
                    'transparent' => false,
                    'title' => esc_html__('Title Bar Background Color', 'ekko'),
                    'default' => '',
                    'subtitle' => esc_html__('Use this colorpicker to override the title bar default background color.', 'ekko'),
                    'validate' => 'color'
                  ),

                  array(
                      'id' => 'tek-titlebar-text-color',
                      'type' => 'color',
                      'transparent' => false,
                      'title' => esc_html__('Title Bar Text Color', 'ekko'),
                      'default' => '',
                      'subtitle' => esc_html__('Use this colorpicker to override the title bar default text color.', 'ekko'),
                      'validate' => 'color'
                  ),

                  array(
                        'id' => 'tek-link-color',
                        'type' => 'link_color',
                        'title' => esc_html__( 'Links Color', 'ekko' ),
                        'active' => false,
                        'visited' => true,
                    ),
              )
          );

          $this->sections[] = array(
              'icon' => 'el-icon-star',
              'title' => esc_html__('Logo', 'ekko'),
              'fields' => array(
                array(
                    'id' => 'tek-logo-style',
                    'type' => 'select',
                    'title' => esc_html__('Logo Style', 'ekko'),
                    'select2' => array('allowClear' => false, 'minimumResultsForSearch' => '-1'),
                    'options'  => array(
                        '1' => 'Image logo',
                        '2' => 'Text logo'
                    ),
                    'default' => '2'
                ),
                array(
                    'id' => 'tek-logo',
                    'type' => 'media',
                    'readonly' => false,
                    'url' => true,
                    'title' => esc_html__('Primary Image Logo', 'ekko'),
                    'subtitle' => esc_html__('Upload primary logo image. Recommended image size: 195x64px', 'ekko'),
                    'required' => array('tek-logo-style','equals','1'),
                ),
                array(
                    'id' => 'tek-logo2',
                    'type' => 'media',
                    'readonly' => false,
                    'url' => true,
                    'title' => esc_html__('Secondary Image Logo', 'ekko'),
                    'subtitle' => esc_html__('Upload secondary image logo. Recommended image size: 195x64px', 'ekko'),
                    'required' => array('tek-logo-style','equals','1'),
                ),
                array(
                    'id' => 'tek-logo-size',
                    'type' => 'dimensions',
                    'height' => false,
                    'units'    => false,
                    'url' => true,
                    'title' => esc_html__('Image Logo Size', 'ekko'),
                    'subtitle' => esc_html__('Choose logo width. Pixels value.', 'ekko'),
                    'required' => array('tek-logo-style','equals','1'),
                ),
                array(
                    'id' => 'tek-text-logo',
                    'type' => 'text',
                    'title' => esc_html__('Text Logo', 'ekko'),
                    'required' => array('tek-logo-style','equals','2'),
                    'default' => 'Ekko'
                ),
                array(
                    'id' => 'tek-text-logo-typo',
                    'type' => 'typography',
                    'title' => esc_html__('Text Logo Font Settings', 'ekko'),
                    'required' => array('tek-logo-style','equals', '2'),
                    'google' => true,
                    'font-family' => true,
                    'font-style' => true,
                    'font-size' => true,
                    'line-height' => false,
                    'color' => false,
                    'text-align' => false,
                    'all_styles' => false,
                    'units' => 'px',
                ),
                array(
                    'id' => 'tek-main-logo-color',
                    'type' => 'color',
                    'transparent' => false,
                    'title' => esc_html__('Primary Logo Text Color', 'ekko'),
                    'required' => array('tek-logo-style','equals','2'),
                    'default' => '#000',
                    'validate' => 'color'
                ),
                array(
                    'id' => 'tek-secondary-logo-color',
                    'type' => 'color',
                    'transparent' => false,
                    'title' => esc_html__('Secondary Logo Text Color', 'ekko'),
                    'subtitle' => esc_html__('Logo text color for sticky navigation', 'ekko'),
                    'required' => array('tek-logo-style','equals','2'),
                    'default' => '#000',
                    'validate' => 'color'
                ),
                array(
                    'id' => 'tek-favicon',
                    'type' => 'media',
                    'readonly' => false,
                    'preview' => false,
                    'url' => true,
                    'title' => esc_html__('Favicon', 'ekko'),
                    'subtitle' => esc_html__('Upload favicon image', 'ekko'),
                    'default' => array(
                        'url' => get_template_directory_uri() . '/core/assets/images/favicon.png'
                    )
                ),
              )
          );

            $this->sections[] = array(
                'icon' => 'el-icon-lines',
                'title' => esc_html__('Header', 'ekko'),
                'fields' => array(
                    array(
                        'id'=>'tek-header-bar-section-start',
                        'type' => 'section',
                        'title' => esc_html__('Header Bar Settings', 'ekko'),
                        'indent' => true,
                    ),
                    array(
                        'id' => 'tek-menu-style',
                        'type' => 'button_set',
                        'title' => esc_html__('Header Bar Width', 'ekko'),
                        'subtitle' => esc_html__('You can choose between full width and contained.', 'ekko'),
                        'options' => array(
                            '1' => 'Contained',
                            '2' => 'Full-Width'
                         ),
                        'default' => '1'
                    ),
                    array(
                        'id' => 'tek-menu-behaviour',
                        'type' => 'button_set',
                        'title' => esc_html__('Header Bar Behaviour', 'ekko'),
                        'subtitle' => esc_html__('You can choose between a sticky or a fixed top menu.', 'ekko'),
                        'options' => array(
                            '1' => 'Sticky',
                            '2' => 'Fixed'
                         ),
                        'default' => '1'
                    ),
                    array(
                        'id' => 'tek-header-spacing',
                        'type' => 'spinner',
                        'title' => esc_html__('Header Bar Spacing', 'ekko'),
                        'subtitle' => esc_html__('Control the top and bottom padding for the header bar. Pixel value.', 'ekko'),
                        'min' => 0,
                        'max' => 30,
                        'default' => 1,
                    ),
                    array(
                        'id' => 'tek-header-menu-bg',
                        'type' => 'color',
                        'transparent' => false,
                        'title' => esc_html__('Header Bar Background Color', 'ekko'),
                        'default' => '#ffffff',
                        'validate' => 'color'
                    ),
                    array(
                        'id' => 'tek-header-menu-bg-sticky',
                        'type' => 'color',
                        'transparent' => false,
                        'title' => esc_html__('Sticky Header Bar Background Color', 'ekko'),
                        'default' => '#ffffff',
                        'required' => array('tek-menu-behaviour','equals', '1'),
                        'validate' => 'color'
                    ),
                    array(
                        'id'=>'tek-header-bar-section-end',
                        'type' => 'section',
                        'indent' => false,
                    ),
                    array(
                        'id'=>'tek-menu-settings-section-start',
                        'type' => 'section',
                        'title' => esc_html__('Main Menu Settings', 'ekko'),
                        'indent' => true,
                    ),
                    array(
                        'id' => 'tek-menu-alignment',
                        'type' => 'button_set',
                        'title' => esc_html__('Menu Alignment', 'ekko'),
                        'subtitle' => esc_html__('Control the position of the main menu.', 'ekko'),
                        'options' => array(
                            'main-nav-left' => 'Left',
                            'main-nav-center' => 'Center',
                            'main-nav-right' => 'Right'
                         ),
                        'default' => 'main-nav-right'
                    ),
                    array(
                        'id' => 'tek-menu-typo',
                        'type' => 'typography',
                        'title' => esc_html__('Menu Font Settings', 'ekko'),
                        'google' => true,
                        'font-style' => true,
                        'font-size' => true,
                        'line-height' => false,
                        'text-transform' => true,
                        'color' => false,
                        'text-align' => false,
                        'letter-spacing' => true,
                        'all_styles' => false,
                        'default' => array(
                            'font-weight' => '700',
                            'font-family' => '',
                            'font-size' => '14',
                            'text-transform' => '',
                            'letter-spacing' => '1',
                        ),
                        'units' => 'px',
                    ),

                    array(
                        'id' => 'tek-header-menu-color',
                        'type' => 'color',
                        'transparent' => false,
                        'title' => esc_html__('Menu Link Color', 'ekko'),
                        'default' => '',
                        'validate' => 'color'
                    ),
                    array(
                        'id' => 'tek-header-menu-color-hover',
                        'type' => 'color',
                        'transparent' => false,
                        'title' => esc_html__('Menu Link Hover Color', 'ekko'),
                        'default' => '',
                        'validate' => 'color'
                    ),
                    array(
                        'id' => 'tek-header-menu-color-sticky',
                        'type' => 'color',
                        'transparent' => false,
                        'title' => esc_html__('Sticky Menu Link Color', 'ekko'),
                        'default' => '',
                        'required' => array('tek-menu-behaviour','equals', '1'),
                        'validate' => 'color'
                    ),
                    array(
                        'id' => 'tek-header-menu-color-sticky-hover',
                        'type' => 'color',
                        'transparent' => false,
                        'title' => esc_html__('Sticky Menu Link Hover Color', 'ekko'),
                        'default' => '',
                        'required' => array('tek-menu-behaviour','equals', '1'),
                        'validate' => 'color'
                    ),
                    array(
                        'id' => 'tek-sticky-nav-logo',
                        'type' => 'select',
                        'title' => esc_html__('Sticky Navigation Logo Image', 'ekko'),
                        'subtitle' => esc_html__('Select which logo image to be used with the sticky navigation bar.', 'ekko'),
                        'select2' => array('allowClear' => false, 'minimumResultsForSearch' => '-1'),
                        'options'  => array(
                            'nav-primary-logo' => 'Primary logo image',
                            'nav-secondary-logo' => 'Secondary logo image',
                        ),
                        'default' => 'nav-primary-logo',
                        'required' => array('tek-logo-style','equals','1'),
                    ),
                    array(
                        'id' => 'tek-dropdown-nav-hover',
                        'type' => 'select',
                        'title' => esc_html__('Dropdown Menu Link Hover Effect', 'ekko'),
                        'subtitle' => esc_html__('Select the hover effect on dropdown menu links.', 'ekko'),
                        'select2' => array('allowClear' => false, 'minimumResultsForSearch' => '-1'),
                        'options'  => array(
                            'default-dropdown-effect' => 'Default',
                            'background-dropdown-effect' => 'Background color',
                            'underline-effect' => 'Underline animation',
                        ),
                        'default' => 'underline-effect',
                    ),
                    array(
                        'id'=>'tek-menu-settings-section-end',
                        'type' => 'section',
                        'indent' => false,
                    ),
                    array(
                        'id'=>'tek-home-transparent-section-start',
                        'type' => 'section',
                        'title' => esc_html__('Transparent Navigation Options', 'ekko'),
                        'indent' => true,
                    ),
                   array(
                       'id' => 'tek-transparent-nav-logo',
                       'type' => 'select',
                       'title' => esc_html__('Transparent Header Logo Image', 'ekko'),
                       'subtitle' => esc_html__('Select which logo image to be used with the transparent navigation bar.', 'ekko'),
                       'select2' => array('allowClear' => false, 'minimumResultsForSearch' => '-1'),
                       'options'  => array(
                           'nav-primary-logo' => 'Primary logo image',
                           'nav-secondary-logo' => 'Secondary logo image',
                       ),
                       'default' => 'nav-secondary-logo',
                       'required' => array('tek-logo-style','equals','1'),
                   ),
                   array(
                       'id' => 'tek-transparent-homepage-menu-colors',
                       'type' => 'color',
                       'transparent' => false,
                       'title' => esc_html__('Menu Link Color', 'ekko'),
                       'subtitle' => esc_html__('Navigation color when using a transparent background.', 'ekko'),
                       'default' => '#fff',
                       'validate' => 'color',
                   ),
                   array(
                        'id'=>'tek-home-transparent-section-end',
                        'type' => 'section',
                        'indent' => false,
                  ),
                  )
              );
              $this->sections[] = array(
                  'title' => esc_html__('Topbar', 'ekko'),
                  'subsection' => true,
                  'fields' => array(
                    array(
                        'id' => 'tek-topbar',
                        'type' => 'switch',
                        'title' => esc_html__('Enable Topbar', 'ekko'),
                        'subtitle' => esc_html__('Turn on to display topbar.', 'ekko'),
                        'default' => false
                    ),
                        array(
                        'id' => 'tek-topbar-sticky',
                        'type' => 'switch',
                        'title' => esc_html__('Sticky Topbar', 'ekko'),
                        'required' => array('tek-topbar','equals', true),
                        'subtitle' => esc_html__('Turn on to enable sticky topbar.', 'ekko'),
                        'default' => false
                    ),
                    array(
                        'id' => 'tek-topbar-left-content',
                        'type' => 'select',
                        'title' => esc_html__('Topbar Left Content', 'ekko'),
                        'subtitle' => esc_html__('Select the content for the topbar left section.', 'ekko'),
                        'required' => array('tek-topbar','equals', true),
                        'select2' => array('allowClear' => false, 'minimumResultsForSearch' => '-1'),
                        'options'  => array(
                            'contact-info' => 'Contact info',
                            'social-links' => 'Social links',
                            'navigation' => 'Navigation',
                            'empty' => 'Empty',
                        ),
                        'default' => 'contact-info',
                    ),
                    array(
                        'id' => 'tek-topbar-right-content',
                        'type' => 'select',
                        'title' => esc_html__('Topbar Right Content', 'ekko'),
                        'subtitle' => esc_html__('Select the content for the topbar right section.', 'ekko'),
                        'required' => array('tek-topbar','equals', true),
                        'select2' => array('allowClear' => false, 'minimumResultsForSearch' => '-1'),
                        'options'  => array(
                            'contact-info' => 'Contact info',
                            'social-links' => 'Social links',
                            'navigation' => 'Navigation',
                            'empty' => 'Empty',
                        ),
                        'default' => 'empty',
                    ),
                    array(
                        'id' => 'tek-topbar-content-design',
                        'type' => 'select',
                        'title' => esc_html__('Topbar Content Design', 'ekko'),
                        'subtitle' => esc_html__('Select the topbar content design.', 'ekko'),
                        'required' => array('tek-topbar','equals', true),
                        'select2' => array('allowClear' => false, 'minimumResultsForSearch' => '-1'),
                        'options'  => array(
                            'tb-default-design' => 'Default',
                            'tb-border-design' => 'Borders between content areas',
                        ),
                        'default' => 'tb-border-design',
                    ),
                    array(
                        'id' => 'tek-topbar-search',
                        'type' => 'switch',
                        'title' => esc_html__('Search Bar', 'ekko'),
                        'subtitle' => esc_html__('Turn on to display search bar.', 'ekko'),
                        'required' => array(
                          array ('tek-topbar','equals', true),
                        ),
                        'default' => true
                    ),
                    array(
                        'id' => 'tek-topbar-typo',
                        'type' => 'typography',
                        'title' => esc_html__('Topbar Font Settings', 'ekko'),
                        'required' => array('tek-topbar','equals', true),
                        'google' => false,
                        'font-family' => false,
                        'font-style' => true,
                        'font-size' => true,
                        'line-height' => false,
                        'color' => false,
                        'text-align' => false,
                        'all_styles' => false,
                        'units' => 'px',
                    ),
                    array(
                        'id' => 'tek-topbar-bg-color',
                        'type' => 'color',
                        'transparent' => false,
                        'title' => esc_html__('Topbar Background Color', 'ekko'),
                        'default' => '',
                        'validate' => 'color',
                        'required' => array('tek-topbar','equals', true),
                    ),
                    array(
                        'id' => 'tek-topbar-text-color',
                        'type' => 'color',
                        'transparent' => false,
                        'title' => esc_html__('Topbar Text Color', 'ekko'),
                        'default' => '',
                        'validate' => 'color',
                        'required' => array('tek-topbar','equals', true),
                    ),
                    array(
                        'id' => 'tek-topbar-hover-text-color',
                        'type' => 'color',
                        'transparent' => false,
                        'title' => esc_html__('Topbar Text Hover Color', 'ekko'),
                        'default' => '',
                        'validate' => 'color',
                        'required' => array('tek-topbar','equals', true),
                    ),
                )
            );

            $this->sections[] = array(
                'title' => esc_html__('Popup Modal', 'ekko'),
                'desc' => esc_html__('Control the settings of the Modal Popup used to display additional content on all pages and posts, without sacrificing space. The Modal Box is hidden by default and can only be triggered using the Header Button displayed near the Main Menu. This button can also be used to open a new page or smooth scroll to a page section ID.', 'ekko'),
                'subsection' => true,
                'fields' => array(
                    array(
                        'id'=>'tek-btn-settings-section-start',
                        'type' => 'section',
                        'title' => esc_html__('Header Button Settings', 'ekko'),
                        'indent' => true,
                    ),
                    array(
                        'id' => 'tek-modal-button',
                        'type' => 'switch',
                        'title' => esc_html__('Enable Header Button', 'ekko'),
                        'default' => false
                    ),
                    array(
                        'id' => 'tek-header-button-text',
                        'type' => 'text',
                        'title' => esc_html__('Button Text', 'ekko'),
                        'required' => array('tek-modal-button','equals', true),
                        'default' => 'Get a quote'
                    ),
                    array(
                        'id' => 'tek-header-button-style',
                        'type' => 'select',
                        'title' => esc_html__('Button Style', 'ekko'),
                        'required' => array('tek-modal-button','equals', true),
                        'select2' => array('allowClear' => false, 'minimumResultsForSearch' => '-1'),
                        'options'  => array(
                            'solid-button' => 'Solid',
                            'outline-button' => 'Outline',
                        ),
                        'default' => 'outline-button'
                    ),
                    array(
                        'id' => 'tek-header-button-color',
                        'type' => 'select',
                        'title' => esc_html__('Button Color Scheme', 'ekko'),
                        'required' => array('tek-modal-button','equals', true),
                        'select2' => array('allowClear' => false, 'minimumResultsForSearch' => '-1'),
                        'options'  => array(
                            'primary-color' => 'Primary color',
                            'secondary-color' => 'Secondary color',
                        ),
                        'default' => 'primary-color'
                    ),
                    array(
                        'id' => 'tek-header-button-hover-style',
                        'type' => 'select',
                        'title' => esc_html__('Button Hover State', 'ekko'),
                        'required' => array('tek-modal-button','equals', true),
                        'select2' => array('allowClear' => false, 'minimumResultsForSearch' => '-1'),
                        'options'  => array(
                            'default_header_btn' => 'Default',
                            'hover_solid_primary' => 'Solid - Primary color',
                            'hover_solid_secondary' => 'Solid - Secondary color',
                            'hover_outline_primary' => 'Outline - Primary color',
                            'hover_outline_secondary' => 'Outline - Secondary color',
                        ),
                        'default' => 'default_header_btn'
                    ),
                    array(
                        'id' => 'tek-header-button-action',
                        'type' => 'select',
                        'title' => esc_html__('Button Action', 'ekko'),
                        'required' => array('tek-modal-button','equals', true),
                        'select2' => array('allowClear' => false, 'minimumResultsForSearch' => '-1'),
                        'options'  => array(
                            '1' => 'Open Modal Box',
                            '2' => 'Scroll to section',
                            '3' => 'Open a new page'
                        ),
                        'default' => '3'
                    ),
                    array(
                        'id'=>'tek-btn-settings-section-end',
                        'type' => 'section',
                        'indent' => false,
                    ),
                    array(
                        'id'=>'tek-modal-section-start',
                        'type' => 'section',
                        'title' => esc_html__('Modal Box Settings', 'ekko'),
                        'indent' => true,
                        'required' => array('tek-header-button-action','equals','1'),
                    ),
                    array(
                        'id' => 'tek-modal-title',
                        'type' => 'text',
                        'title' => esc_html__('Modal Heading', 'ekko'),
                        'subtitle' => esc_html__('Heading text for the modal.', 'ekko'),
                        'required' => array('tek-header-button-action','equals','1'),
                        'default' => 'Lets get in touch'
                    ),
                    array(
                        'id' => 'tek-modal-subtitle',
                        'type' => 'editor',
                        'title' => esc_html__('Modal Contents', 'ekko'),
                        'subtitle' => esc_html__('Content text for the modal.', 'ekko'),
                        'required' => array('tek-header-button-action','equals','1'),
                        'default' => '',
                            'args' => array(
                          'teeny' => true,
                          'textarea_rows' => 10,
                          'media_buttons' => false,
                              ),
                    ),
                    array(
                        'id' => 'tek-modal-bg-image',
                        'type' => 'media',
                        'readonly' => false,
                        'url' => true,
                        'title' => esc_html__('Modal Background Image', 'ekko'),
                        'subtitle' => esc_html__('Upload modal background image.', 'ekko'),
                        'required' => array('tek-header-button-action','equals','1'),
                        'default' => '',
                    ),
                    array(
                        'id' => 'tek-modal-socials',
                        'type' => 'switch',
                        'title' => esc_html__('Social Icons', 'ekko'),
                        'subtitle' => esc_html__('Enable to display the social icons list. The list can be configured in the Business Info panel.', 'ekko'),
                        'default' => true
                    ),
                    array(
                        'id' => 'tek-modal-form-select',
                        'type' => 'select',
                        'title' => esc_html__('Contact Form Plugin', 'ekko'),
                        'subtitle' => esc_html__('Display a contact form inside the Modal Box. Select the contact vendor from the dropdown list.', 'ekko'),
                        'required' => array('tek-header-button-action','equals','1'),
                        'select2' => array('allowClear' => false, 'minimumResultsForSearch' => '-1'),
                        'options'  => array(
                            '1' => 'Contact Form 7',
                            '2' => 'Ninja Forms',
                            '3' => 'Gravity Forms',
                            '4' => 'WP Forms',
                        ),
                        'default' => '1'
                    ),
                    array(
                        'id' => 'tek-modal-contactf7-formid',
                        'type' => 'select',
                        'data' => 'posts',
                        'args' => array( 'post_type' => 'wpcf7_contact_form', 'posts_per_page' => -1, ),
                        'title' => esc_html__('Contact Form 7 Title', 'ekko'),
                        'required' => array('tek-modal-form-select','equals','1'),
                        'select2' => array('allowClear' => false, 'minimumResultsForSearch' => '-1'),
                        'default' => ''
                    ),
                    array(
                        'id' => 'tek-modal-ninja-formid',
                        'type' => 'text',
                        'title' => esc_html__('Ninja Form ID', 'ekko'),
                        'required' => array('tek-modal-form-select','equals','2'),
                        'default' => ''
                    ),
                    array(
                        'id' => 'tek-modal-gravity-formid',
                        'type' => 'text',
                        'title' => esc_html__('Gravity Form ID', 'ekko'),
                        'required' => array('tek-modal-form-select','equals','3'),
                        'default' => ''
                    ),
                    array(
                        'id' => 'tek-modal-wp-formid',
                        'type' => 'text',
                        'title' => esc_html__('WP Form ID', 'ekko'),
                        'required' => array('tek-modal-form-select','equals','4'),
                        'default' => ''
                    ),
                    array(
                        'id' => 'tek-modal-css-class',
                        'type' => 'text',
                        'title' => esc_html__('CSS Class', 'ekko'),
                        'subtitle' => esc_html__('Add a class to the wrapping HTML element for further CSS customization.', 'ekko'),
                        'required' => array('tek-modal-button','equals', true),
                        'default' => ''
                    ),
                    array(
                        'id'=>'tek-modal-section-end',
                        'type' => 'section',
                        'indent' => false,
                        'required' => array('tek-header-button-action','equals','1'),
                    ),
                    array(
                        'id'=>'tek-scroll-section-start',
                        'type' => 'section',
                        'title' => esc_html__('Scroll Section Settings', 'ekko'),
                        'indent' => true,
                        'required' => array('tek-header-button-action','equals','2'),
                    ),
                    array(
                        'id' => 'tek-scroll-id',
                        'type' => 'text',
                        'title' => esc_html__('Scroll to Section ID', 'ekko'),
                        'required' => array('tek-header-button-action','equals','2'),
                        'default' => '#download-ekko'
                    ),
                    array(
                        'id'=>'tek-scroll-section-end',
                        'type' => 'section',
                        'indent' => false,
                        'required' => array('tek-header-button-action','equals','2'),
                    ),
                    array(
                        'id'=>'tek-new-page-settings-start',
                        'type' => 'section',
                        'title' => esc_html__('New Page Link Settings', 'ekko'),
                        'indent' => true,
                        'required' => array('tek-header-button-action','equals','3'),
                    ),
                    array(
                        'id' => 'tek-button-new-page',
                        'type' => 'text',
                        'title' => esc_html__('Button Link', 'ekko'),
                        'required' => array('tek-header-button-action','equals','3'),
                        'default' => '#'
                    ),
                    array(
                        'id' => 'tek-button-target',
                        'type' => 'select',
                        'title' => esc_html__('Link Target', 'ekko'),
                        'required' => array('tek-header-button-action','equals','3'),
                        'select2' => array('allowClear' => false, 'minimumResultsForSearch' => '-1'),
                        'options'  => array(
                            'new-page' => 'Open in a new page',
                            'same-page' => 'Open in same page'
                        ),
                        'default' => 'new-page'
                    ),
                    array(
                        'id'=>'tek-new-page-settings-end',
                        'type' => 'section',
                        'indent' => false,
                        'required' => array('tek-header-button-action','equals','3'),
                    ),
                )
            );

            $this->sections[] = array(
                'title' => esc_html__('Side Panel', 'ekko'),
                'desc' => esc_html__('Control the settings of the Side Panel used to display additional content on all pages and posts, without sacrificing space. The Side Panel is hidden by default and can only be triggered using the Header Button displayed near the Main Menu. This button can also be used to open a new page or smooth scroll to a page section ID.', 'ekko'),
                'subsection' => true,
                'fields' => array(
                    array(
                        'id'=>'tek-panel-btn-section-start',
                        'type' => 'section',
                        'title' => esc_html__('Header Button Settings', 'ekko'),
                        'indent' => true,
                    ),
                    array(
                        'id' => 'tek-panel-button',
                        'type' => 'switch',
                        'title' => esc_html__('Enable Header Button', 'ekko'),
                        'default' => false
                    ),
                    array(
                        'id' => 'tek-panel-button-text',
                        'type' => 'text',
                        'title' => esc_html__('Button Text', 'ekko'),
                        'required' => array('tek-panel-button','equals', true),
                        'default' => 'Purchase Ekko'
                    ),
                    array(
                        'id' => 'tek-panel-button-style',
                        'type' => 'select',
                        'title' => esc_html__('Button Style', 'ekko'),
                        'required' => array('tek-panel-button','equals', true),
                        'select2' => array('allowClear' => false, 'minimumResultsForSearch' => '-1'),
                        'options'  => array(
                            'solid-button' => 'Solid',
                            'outline-button' => 'Outline',
                        ),
                        'default' => 'solid-button'
                    ),
                    array(
                        'id' => 'tek-panel-button-color',
                        'type' => 'select',
                        'title' => esc_html__('Button Color Scheme', 'ekko'),
                        'required' => array('tek-panel-button','equals', true),
                        'select2' => array('allowClear' => false, 'minimumResultsForSearch' => '-1'),
                        'options'  => array(
                            'primary-color' => 'Primary color',
                            'secondary-color' => 'Secondary color',
                        ),
                        'default' => 'primary-color'
                    ),
                    array(
                        'id' => 'tek-panel-button-hover-style',
                        'type' => 'select',
                        'title' => esc_html__('Button Hover State', 'ekko'),
                        'required' => array('tek-panel-button','equals', true),
                        'select2' => array('allowClear' => false, 'minimumResultsForSearch' => '-1'),
                        'options'  => array(
                            'default_header_btn' => 'Default',
                            'hover_solid_primary' => 'Solid - Primary color',
                            'hover_solid_secondary' => 'Solid - Secondary color',
                            'hover_outline_primary' => 'Outline - Primary color',
                            'hover_outline_secondary' => 'Outline - Secondary color',
                        ),
                        'default' => 'default_header_btn'
                    ),
                    array(
                        'id' => 'tek-panel-button-action',
                        'type' => 'select',
                        'title' => esc_html__('Button Action', 'ekko'),
                        'required' => array('tek-panel-button','equals', true),
                        'select2' => array('allowClear' => false, 'minimumResultsForSearch' => '-1'),
                        'options'  => array(
                            '1' => 'Open Side Panel',
                            '2' => 'Scroll to section',
                            '3' => 'Open a new page'
                        ),
                        'default' => '1'
                    ),
                    array(
                        'id'=>'tek-panel-btn-section-end',
                        'type' => 'section',
                        'indent' => false,
                    ),
                    array(
                        'id'=>'tek-panel-section-start',
                        'type' => 'section',
                        'title' => esc_html__('Side Panel Settings', 'ekko'),
                        'indent' => true,
                        'required' => array('tek-panel-button-action','equals','1'),
                    ),
                    array(
                        'id' => 'tek-panel-title',
                        'type' => 'text',
                        'title' => esc_html__('Panel Heading', 'ekko'),
                        'subtitle' => esc_html__('Heading text for the side panel.', 'ekko'),
                        'required' => array('tek-panel-button-action','equals','1'),
                        'default' => 'Enquire now'
                    ),
                    array(
                        'id' => 'tek-panel-subtitle',
                        'type' => 'editor',
                        'title' => esc_html__('Panel Contents', 'ekko'),
                        'subtitle' => esc_html__('Content text for the side panel.', 'ekko'),
                        'required' => array('tek-panel-button-action','equals','1'),
                        'default' => 'Give us a call or fill in the form below and we will contact you. We endeavor to answer all inquiries within 24 hours on business days.',
                            'args' => array(
                          'teeny' => true,
                          'textarea_rows' => 10,
                          'media_buttons' => false,
                              ),
                    ),
                    array(
                        'id' => 'tek-panel-socials',
                        'type' => 'switch',
                        'title' => esc_html__('Social Icons', 'ekko'),
                        'subtitle' => esc_html__('Enable to display the social icons list. The list can be configured in the Business Info panel.', 'ekko'),
                        'default' => true
                    ),
                    array(
                        'id' => 'tek-panel-form-select',
                        'type' => 'select',
                        'title' => esc_html__('Contact Form Plugin', 'ekko'),
                        'subtitle' => esc_html__('Display a contact form inside the Side Panel. Select the contact vendor from the dropdown list.', 'ekko'),
                        'required' => array('tek-panel-button-action','equals','1'),
                        'select2' => array('allowClear' => false, 'minimumResultsForSearch' => '-1'),
                        'options'  => array(
                            '1' => 'Contact Form 7',
                            '2' => 'Ninja Forms',
                            '3' => 'Gravity Forms',
                            '4' => 'WP Forms',
                        ),
                        'default' => '1'
                    ),
                    array(
                        'id' => 'tek-panel-contactf7-formid',
                        'type' => 'select',
                        'data' => 'posts',
                        'args' => array( 'post_type' => 'wpcf7_contact_form', 'posts_per_page' => -1, ),
                        'title' => esc_html__('Contact Form 7 Title', 'ekko'),
                        'required' => array('tek-panel-form-select','equals','1'),
                        'select2' => array('allowClear' => false, 'minimumResultsForSearch' => '-1'),
                        'default' => ''
                    ),
                    array(
                        'id' => 'tek-panel-ninja-formid',
                        'type' => 'text',
                        'title' => esc_html__('Ninja Form ID', 'ekko'),
                        'required' => array('tek-panel-form-select','equals','2'),
                        'default' => ''
                    ),
                    array(
                        'id' => 'tek-panel-gravity-formid',
                        'type' => 'text',
                        'title' => esc_html__('Gravity Form ID', 'ekko'),
                        'required' => array('tek-panel-form-select','equals','3'),
                        'default' => ''
                    ),
                    array(
                        'id' => 'tek-panel-wp-formid',
                        'type' => 'text',
                        'title' => esc_html__('WP Form ID', 'ekko'),
                        'required' => array('tek-panel-form-select','equals','4'),
                        'default' => ''
                    ),
                    array(
                        'id' => 'tek-panel-css-class',
                        'type' => 'text',
                        'title' => esc_html__('CSS Class', 'ekko'),
                        'subtitle' => esc_html__('Add a class to the wrapping HTML element for further CSS customization.', 'ekko'),
                        'required' => array('tek-panel-button','equals', true),
                        'default' => ''
                    ),
                    array(
                        'id'=>'tek-panel-section-end',
                        'type' => 'section',
                        'indent' => false,
                        'required' => array('tek-panel-button-action','equals','1'),
                    ),
                    array(
                        'id'=>'tek-panel-scroll-section-start',
                        'type' => 'section',
                        'title' => esc_html__('Scroll Section Settings', 'ekko'),
                        'indent' => true,
                        'required' => array('tek-panel-button-action','equals','2'),
                    ),
                    array(
                        'id' => 'tek-panel-scroll-id',
                        'type' => 'text',
                        'title' => esc_html__('Scroll to Section ID', 'ekko'),
                        'required' => array('tek-panel-button-action','equals','2'),
                        'default' => '#download-ekko'
                    ),
                    array(
                        'id'=>'tek-panel-scroll-section-end',
                        'type' => 'section',
                        'indent' => false,
                        'required' => array('tek-panel-button-action','equals','2'),
                    ),
                    array(
                        'id'=>'tek-panel-new-page-settings-start',
                        'type' => 'section',
                        'title' => esc_html__('New Page Settings', 'ekko'),
                        'indent' => true,
                        'required' => array('tek-panel-button-action','equals','3'),
                    ),
                    array(
                        'id' => 'tek-panel-button-new-page',
                        'type' => 'text',
                        'title' => esc_html__('Button Link', 'ekko'),
                        'required' => array('tek-panel-button-action','equals','3'),
                        'default' => '#'
                    ),
                    array(
                        'id' => 'tek-panel-button-target',
                        'type' => 'select',
                        'title' => esc_html__('Link Target', 'ekko'),
                        'required' => array('tek-panel-button-action','equals','3'),
                        'select2' => array('allowClear' => false, 'minimumResultsForSearch' => '-1'),
                        'options'  => array(
                            'new-page' => 'Open in a new page',
                            'same-page' => 'Open in same page'
                        ),
                        'default' => 'new-page'
                    ),
                    array(
                        'id'=>'tek-panel-new-page-settings-end',
                        'type' => 'section',
                        'indent' => false,
                        'required' => array('tek-panel-button-action','equals','3'),
                    ),
                )
            );

            $this->sections[] = array(
                'icon' => 'el-icon-website',
                'title' => esc_html__('Layout', 'ekko'),
                'fields' => array(
                    array(
                        'id' => 'tek-layout-style',
                        'type' => 'button_set',
                        'title' => esc_html__('Layout Style', 'ekko'),
                        'subtitle' => esc_html__('Select the layout appearance.', 'ekko'),
                        'options' => array(
                            'full-width' => 'Full-Width',
                            'boxed' => 'Boxed'
                         ),
                        'default' => 'full-width'
                    ),
                    array(
                        'id' => 'tek-layout-boxed-body-bg',
                        'type' => 'background',
                        'transparent' => false,
                        'title' => esc_html__('Body Background Settings', 'ekko'),
                        'preview' => false,
                        'required' => array('tek-layout-style','equals','boxed'),
                    ),
                    array(
                        'id' => 'tek-layout-fw-content-bg',
                        'type' => 'color',
                        'transparent' => false,
                        'title' => esc_html__('Content Background Color', 'ekko'),
                        'default' => '',
                        'validate' => 'color'
                    ),
                )
            );

            $this->sections[] = array(
                'icon' => 'el-icon-photo',
                'title' => esc_html__('Footer', 'ekko'),
                'fields' => array(

                    array(
                        'id' => 'tek-footer-fixed',
                        'type' => 'switch',
                        'title' => esc_html__('Fixed Footer', 'ekko'),
                        'subtitle' => esc_html__('Enable to activate this feature.', 'ekko'),
                        'default' => false
                    ),
                    array(
                        'id' => 'tek-footer-bar',
                        'type' => 'switch',
                        'title' => esc_html__('Footer Bar', 'ekko'),
                        'subtitle' => esc_html__('Activate to display footer bar. Contains footer menu and social icons.', 'ekko'),
                        'default' => false
                    ),
                    array(
                        'id' => 'tek-upper-footer-color',
                        'type' => 'color',
                        'transparent' => false,
                        'title' => esc_html__('Upper Footer Background', 'ekko'),
                        'default' => '#0a0a0a',
                        'validate' => 'color'
                    ),
                    array(
                        'id' => 'tek-lower-footer-color',
                        'type' => 'color',
                        'transparent' => false,
                        'title' => esc_html__('Lower Footer Background', 'ekko'),
                        'default' => '#0a0a0a',
                        'validate' => 'color'
                    ),
                    array(
                        'id' => 'tek-footer-typo',
                        'type' => 'typography',
                        'title' => esc_html__('Footer Typography', 'ekko'),
                        'google' => true,
                        'font-style' => true,
                        'font-size' => true,
                        'line-height' => false,
                        'text-transform' => true,
                        'color' => false,
                        'text-align' => false,
                        'letter-spacing' => true,
                        'all_styles' => false,
                        'default' => array(
                            'font-weight' => '',
                            'font-family' => '',
                            'font-size' => '',
                            'text-transform' => '',
                        ),
                        'units' => 'px',
                    ),
                    array(
                        'id' => 'tek-footer-heading-color',
                        'type' => 'color',
                        'transparent' => false,
                        'title' => esc_html__('Footer Heading Color', 'ekko'),
                        'default' => '#ffffff',
                        'validate' => 'color'
                    ),
                    array(
                        'id' => 'tek-footer-text-color',
                        'type' => 'color',
                        'transparent' => false,
                        'title' => esc_html__('Footer Text Color', 'ekko'),
                        'default' => '#ffffff',
                        'validate' => 'color'
                    ),
                    array(
                          'id' => 'tek-footer-link-color',
                          'type' => 'link_color',
                          'title' => esc_html__( 'Footer Link Color', 'ekko' ),
                          'active' => false,
                          'visited' => false,
                    ),
                    array(
                        'id' => 'tek-footer-link-hover-effect',
                        'type' => 'select',
                        'title' => esc_html__('Footer Link Hover Effect', 'ekko'),
                        'subtitle' => esc_html__('Select the hover effect on footer links.', 'ekko'),
                        'select2' => array('allowClear' => false, 'minimumResultsForSearch' => '-1'),
                        'options'  => array(
                            'default-footer-link-effect' => 'Default',
                            'underline-effect' => 'Underline animation',
                        ),
                        'default' => 'underline-effect',
                    ),
                    array(
                        'id' => 'tek-footer-text',
                        'type' => 'editor',
                        'title' => esc_html__('Copyright Text', 'ekko'),
                        'subtitle' => esc_html__('Enter footer bottom copyright text', 'ekko'),
                        'default' => 'Ekko by KeyDesign. All rights reserved.',
                        'args' => array(
                            'teeny' => true,
                            'textarea_rows' => 3,
                            'media_buttons' => false,
                        ),
                    ),

                )
            );

            $this->sections[] = array(
                'icon' => 'el-icon-fontsize',
                'title' => esc_html__('Typography', 'ekko'),
                'fields' => array(
                    array(
                        'id' => 'tek-default-typo',
                        'type' => 'typography',
                        'title' => esc_html__('Body Typography', 'ekko'),
                        'line-height' => true,
                        'text-align' => false,
                        'all_styles' => false,
                        'units' => 'px',
                        'default' => array(
                            'color' => '#838383',
                            'font-weight' => '400',
                            'font-family' => 'Roboto',
                        ),
                    ),
                    array(
                        'id' => 'tek-h1-heading',
                        'type' => 'typography',
                        'title' => esc_html__('H1 Heading', 'ekko'),
                        'line-height' => true,
                        'text-align' => true,
                        'text-transform' => true,
                        'letter-spacing' => true,
                        'units' => 'px',
                        'default' => array(
                            'font-weight' => '600',
                            'font-family' => 'Josefin Sans',
                        ),
                    ),
                    array(
                        'id' => 'tek-h2-heading',
                        'type' => 'typography',
                        'title' => esc_html__('H2 Heading', 'ekko'),
                        'line-height' => true,
                        'text-align' => true,
                        'text-transform' => true,
                        'letter-spacing' => true,
                        'units' => 'px',
                        'default' => array(
                            'font-weight' => '600',
                            'font-family' => 'Josefin Sans',
                        ),
                    ),
                    array(
                        'id' => 'tek-h3-heading',
                        'type' => 'typography',
                        'title' => esc_html__('H3 Heading', 'ekko'),
                        'line-height' => true,
                        'text-align' => true,
                        'text-transform' => true,
                        'letter-spacing' => true,
                        'units' => 'px',
                        'default' => array(
                            'font-weight' => '700',
                            'font-family' => 'Roboto',
                        ),
                    ),
                    array(
                        'id' => 'tek-h4-heading',
                        'type' => 'typography',
                        'title' => esc_html__('H4 Heading', 'ekko'),
                        'line-height' => true,
                        'text-align' => true,
                        'text-transform' => true,
                        'letter-spacing' => true,
                        'units' => 'px',
                        'default' => array(
                            'font-weight' => '500',
                            'font-family' => 'Roboto',
                        ),
                    ),
                    array(
                        'id' => 'tek-h5-heading',
                        'type' => 'typography',
                        'title' => esc_html__('H5 Heading', 'ekko'),
                        'line-height' => true,
                        'text-align' => true,
                        'text-transform' => true,
                        'letter-spacing' => true,
                        'units' => 'px',
                        'default' => array(
                            'font-weight' => '500',
                            'font-family' => 'Roboto',
                        ),
                    ),
                    array(
                        'id' => 'tek-h6-heading',
                        'type' => 'typography',
                        'title' => esc_html__('H6 Heading', 'ekko'),
                        'line-height' => true,
                        'text-align' => true,
                        'text-transform' => true,
                        'letter-spacing' => true,
                        'units' => 'px',
                    ),
                )
            );

            $this->sections[] = array(
                'title' => esc_html__('Typekit Fonts', 'ekko'),
                'subsection' => true,
                'fields' => array(
                  array(
                      'id' => 'tek-typekit-switch',
                      'type' => 'switch',
                      'title' => esc_html__('Enable Typekit', 'ekko'),
                      'subtitle' => esc_html__('Select to enable Typekit fonts and display options below.', 'ekko'),
                      'default' => true
                  ),
                  array(
                      'id' => 'tek-typekit',
                      'type' => 'text',
                      'title' => esc_html__('Typekit ID', 'ekko'),
                      'subtitle' => esc_html__('Enter in the ID for your kit here. Only published data is accessible, so make sure that any changes you make to your kit are updated.', 'ekko'),
                      'mode' => 'text',
                      'default' => '',
                      'theme' => 'chrome',
                      'required' => array('tek-typekit-switch','equals', true),
                  ),
                  array(
                      'id' => 'tek-body-typekit-selector',
                      'type' => 'text',
                      'title' => esc_html__('Body Typography', 'ekko'),
                      'subtitle' => esc_html__('Add the Typekit font family name.', 'ekko'),
                      'default' => '',
                      'required' => array('tek-typekit-switch','equals', true),
                  ),
                  array(
                      'id' => 'tek-heading-typekit-selector',
                      'type' => 'text',
                      'title' => esc_html__('Headings Typography', 'ekko'),
                      'subtitle' => esc_html__('Add the Typekit font family name.', 'ekko'),
                      'default' => '',
                      'required' => array('tek-typekit-switch','equals', true),
                  ),
                )
            );

            if (class_exists('WooCommerce')) {
              $this->sections[] = array(
                  'icon' => 'el-icon-shopping-cart',
                  'title' => esc_html__('WooCommerce', 'ekko'),
                  'fields' => array(
                      array(
                          'id' => 'tek-woo-catalog-style',
                          'type' => 'select',
                          'title' => esc_html__('Catalog Style', 'ekko'),
                          'select2' => array('allowClear' => false, 'minimumResultsForSearch' => '-1'),
                          'options'  => array(
                              'woo-minimal-style' => 'Minimal',
                              'woo-detailed-style' => 'Detailed',
                          ),
                          'default' => 'woo-detailed-style'
                      ),
                      array(
                          'id' => 'tek-woo-products-number',
                          'type' => 'text',
                          'title' => esc_html__('Products per Page', 'ekko'),
                          'subtitle' => esc_html__('Change the products number listed per page.', 'ekko'),
                          'default' => '9',
                      ),
                      array(
                          'id' => 'tek-woo-shop-columns',
                          'type' => 'select',
                          'title' => esc_html__('Shop Columns', 'ekko'),
                          'select2' => array('allowClear' => false, 'minimumResultsForSearch' => '-1'),
                          'options'  => array(
                              'woo-2-columns' => '2',
                              'woo-3-columns' => '3',
                              'woo-4-columns' => '4',
                          ),
                          'default' => 'woo-3-columns'
                      ),
                      array(
                          'id' => 'tek-woo-sidebar-position',
                          'type' => 'select',
                          'title' => esc_html__('Sidebar Position', 'ekko'),
                          'options'  => array(
                              'woo-sidebar-left' => 'Left',
                              'woo-sidebar-right' => 'Right',
                          ),
                          'required' => array('tek-woo-shop-columns','equals','woo-2-columns'),
                          'default' => 'woo-sidebar-right'
                      ),
                      array(
                        'id' => 'tek-woo-display-cart-icon',
                        'type' => 'switch',
                        'title' => esc_html__('Display Cart Icon', 'ekko'),
                        'subtitle' => esc_html__('Activate to display cart icon in topbar.', 'ekko'),
                        'default' => '1',
                        '1' => 'Show',
                        '0' => 'Hide',
                    ),
                    array(
                        'id' => 'tek-woo-cart-icon-selector',
                        'type' => 'select',
                        'title' => esc_html__('Cart Icon', 'ekko'),
                        'select2' => array('allowClear' => false, 'minimumResultsForSearch' => '-1'),
                        'options'  => array(
                            'shopping-cart' => 'Shopping cart',
                            'shopping-bag' => 'Shopping bag',
                            'shopping-basket' => 'Shopping basket',
                        ),
                        'required' => array('tek-woo-display-cart-icon','equals','1'),
                        'default' => 'shopping-basket'
                    ),
                  )
              );

              $this->sections[] = array(
                  'title' => esc_html__('Single Product', 'ekko'),
                  'subsection' => true,
                  'fields' => array(
                    array(
                        'id' => 'tek-woo-single-sidebar',
                        'type' => 'switch',
                        'title' => esc_html__('Product Sidebar', 'ekko'),
                        'subtitle' => esc_html__('Enable/Disable Shop sidebar on single product page.', 'ekko'),
                        'default' => '1',
                        '1' => 'Yes',
                        '0' => 'No',
                    ),
                    array(
                        'id' => 'tek-woo-single-sidebar-position',
                        'type' => 'select',
                        'title' => esc_html__('Sidebar Position', 'ekko'),
                        'select2' => array('allowClear' => false, 'minimumResultsForSearch' => '-1'),
                        'options'  => array(
                            'woo-single-sidebar-left' => 'Left',
                            'woo-single-sidebar-right' => 'Right',
                        ),
                        'required' => array('tek-woo-single-sidebar','equals','1'),
                        'default' => 'woo-single-sidebar-right'
                    ),
                    array(
                        'id' => 'tek-woo-single-image-position',
                        'type' => 'select',
                        'title' => esc_html__('Featured Image Position', 'ekko'),
                        'select2' => array('allowClear' => false, 'minimumResultsForSearch' => '-1'),
                        'options' => array(
                            'woo-image-left' => 'Left',
                            'woo-image-right' => 'Right',
                        ),
                        'default' => 'woo-image-left'
                    ),
                    array(
                        'id' => 'tek-woo-single-gallery',
                        'type' => 'select',
                        'title' => esc_html__('Gallery Template', 'ekko'),
                        'select2' => array('allowClear' => false, 'minimumResultsForSearch' => '-1'),
                        'options' => array(
                            'woo-gallery-thumbnails' => 'Thumbnails',
                            'woo-gallery-list' => 'List',
                        ),
                        'default' => 'woo-gallery-thumbnails'
                    ),
                  )
              );
            }

            $this->sections[] = array(
                'icon' => 'el-icon-th-list',
                'title' => esc_html__('Portfolio', 'ekko'),
                'fields' => array(
                  array(
                      'id' => 'tek-portfolio-single-nav',
                      'type' => 'switch',
                      'title' => esc_html__('Previous/Next Pagination', 'ekko'),
                      'subtitle' => esc_html__('Enable to display the previous/next portfolio pagination. Pagination section will be displayed below the content.', 'ekko'),
                      'default' => false
                  ),
                  array(
                      'id' => 'tek-portfolio-related-posts',
                      'type' => 'switch',
                      'title' => esc_html__('Related Projects', 'ekko'),
                      'subtitle' => esc_html__('Enable to display related projects on single portfolio pages.', 'ekko'),
                      'default' => true
                  ),
                  array(
                      'id' => 'tek-portfolio-related-posts-title',
                      'type' => 'text',
                      'title' => esc_html__('Related Projects Title', 'ekko'),
                      'default' => 'Related projects',
                      'required' => array(
                        'tek-portfolio-related-posts',
                        'equals',
                        true
                      ),
                  ),
                  array(
                      'id' => 'tek-portfolio-related-posts-number',
                      'type' => 'slider',
                      'title' => esc_html__( 'Number of Related Projects', 'ekko' ),
                      'subtitle' => esc_html__( 'Controls the number of items that display under related projects section.', 'ekko' ),
                      'default' => 3,
                      'max' => 20,
                      'required' => array(
                        'tek-portfolio-related-posts',
                        'equals',
                        true
                      ),
                  ),
                  array(
                      'id' => 'tek-portfolio-comments',
                      'type' => 'switch',
                      'title' => esc_html__('Comments Section', 'ekko'),
                      'subtitle' => esc_html__('Enable to display the comments section below the content.', 'ekko'),
                      'default' => false
                  ),
                )
            );

            $this->sections[] = array(
                'icon' => 'el-icon-pencil-alt',
                'title' => esc_html__('Blog', 'ekko'),
                'fields' => array(
                    array(
                        'id'=>'tek-blog-settings-section-start',
                        'type' => 'section',
                        'title' => esc_html__('General Settings', 'ekko'),
                        'indent' => true,
                    ),
                    array(
                        'id' => 'tek-blog-transparent-nav',
                        'type' => 'switch',
                        'title' => esc_html__('Transparent Navbar', 'ekko'),
                        'subtitle' => esc_html__('If enabled, the navbar section will take a transparent color. This option is linked with the homepage transparent settings.', 'ekko'),
                        'default' => false
                    ),
                    array(
                        'id' => 'tek-blog-header-template',
                        'type' => 'select',
                        'title' => esc_html__('Blog Header Template', 'ekko'),
                        'subtitle' => esc_html__('Select the blog header template style.', 'ekko'),
                        'select2' => array('allowClear' => false, 'minimumResultsForSearch' => '-1'),
                        'options'  => array(
                            'blog-header-titlebar' => 'Title bar',
                            'blog-header-revslider' => 'Revolution Slider',
                        ),
                        'default' => 'blog-header-titlebar'
                    ),
                    array(
                        'id' => 'tek-blog-template',
                        'type' => 'select',
                        'title' => esc_html__('Blog Articles Template', 'ekko'),
                        'subtitle' => esc_html__('Select the blog articles template style.', 'ekko'),
                        'select2' => array('allowClear' => false, 'minimumResultsForSearch' => '-1'),
                        'options'  => array(
                            'img-top-list' => 'List - Top image',
                            'img-left-list' => 'List - Left image',
                            'minimal-list' => 'List minimal',
                            'minimal-grid' => 'Grid minimal',
                            'detailed-grid' => 'Grid detailed',
                        ),
                        'default' => 'img-top-list'
                    ),
                    array(
                        'id' => 'tek-blog-sidebar',
                        'type' => 'switch',
                        'title' => esc_html__('Display Sidebar', 'ekko'),
                        'subtitle' => esc_html__('Turn on to display the blog sidebar.', 'ekko'),
                        'default' => true
                    ),
                    array(
                        'id' => 'tek-blog-listing-sticky-sidebar',
                        'type' => 'switch',
                        'title' => esc_html__('Sticky Sidebar', 'ekko'),
                        'subtitle' => esc_html__('Enable sticky sidebar for blog archive pages.', 'ekko'),
                        'default' => true,
                        'required' => array(
                            'tek-blog-sidebar',
                            'equals',
                            true
                        ),
                    ),
                    array(
                        'id' => 'tek-blog-excerpt',
                        'type' => 'text',
                        'title' => esc_html__('Blog Post Excerpt', 'ekko'),
                        'default' => '20'
                    ),
                    array(
                        'id'=>'tek-blog-settings-section-end',
                        'type' => 'section',
                        'indent' => false,
                    ),
                    array(
                        'id'=>'tek-blog-title-section-start',
                        'type' => 'section',
                        'title' => esc_html__('Blog Header Title Bar', 'ekko'),
                        'indent' => true,
                        'required' => array('tek-blog-header-template','equals','blog-header-titlebar'),
                    ),
                    array(
                        'id' => 'tek-blog-title-switch',
                        'type' => 'switch',
                        'title' => esc_html__('Blog Page Title', 'ekko'),
                        'subtitle' => esc_html__('Turn on to show the page title of the assigned blog page.', 'ekko'),
                        'default' => true
                    ),
                    array(
                        'id' => 'tek-blog-subtitle',
                        'type' => 'text',
                        'title' => esc_html__('Blog Page Subtitle', 'ekko'),
                        'subtitle' => esc_html__('Add the subtitle text that displays in the page title bar of the assigned blog page.', 'ekko'),
                        'default' => ''
                    ),
                    array(
                        'id' => 'tek-blog-header-text-align',
                        'type' => 'select',
                        'title' => esc_html__('Title Bar Text Alignment', 'ekko'),
                        'select2' => array('allowClear' => false, 'minimumResultsForSearch' => '-1'),
                        'options'  => array(
                            'blog-title-left' => 'Left',
                            'blog-title-center' => 'Center',
                        ),
                        'required' => array('tek-blog-title-switch','equals', true),
                        'subtitle' => esc_html__('Select Text Alignment in the Title Bar Area.', 'ekko'),
                        'default' => 'blog-title-left'
                    ),
                    array(
                        'id' => 'tek-blog-titlebar-background',
                        'type' => 'color',
                        'transparent' => false,
                        'title' => esc_html__('Title Bar Background Color', 'ekko'),
                        'default' => '',
                        'subtitle' => esc_html__('Use this colorpicker to override the title bar default background color.', 'ekko'),
                        'validate' => 'color'
                    ),
                    array(
                        'id' => 'tek-blog-text-color',
                        'type' => 'color',
                        'transparent' => false,
                        'title' => esc_html__('Title Bar Text Color', 'ekko'),
                        'default' => '',
                        'subtitle' => esc_html__('Use this colorpicker to override the title bar default text color.', 'ekko'),
                        'validate' => 'color'
                    ),
                    array(
                        'id' => 'tek-blog-header-form',
                        'type' => 'switch',
                        'title' => esc_html__('Show Newsletter Form', 'ekko'),
                        'subtitle' => esc_html__('Turn on to display a form in the header area.', 'ekko'),
                        'default' => false
                    ),
                    array(
                        'id' => 'tek-blog-header-form-id',
                        'type' => 'select',
                        'data' => 'posts',
                        'args' => array( 'post_type' => 'wpcf7_contact_form', 'posts_per_page' => -1, ),
                        'title' => esc_html__('Newsletter Form Title', 'ekko'),
                        'subtitle' => esc_html__('Select the Contact Form 7 to be used as a newsletter in the title bar area.', 'ekko'),
                        'select2' => array('allowClear' => false, 'minimumResultsForSearch' => '-1'),
                        'required' => array('tek-blog-header-form','equals', true),
                    ),
                    array(
                        'id'=>'tek-blog-title-section-end',
                        'type' => 'section',
                        'indent' => false,
                        'required' => array('tek-blog-header-template','equals','blog-header-titlebar'),
                    ),
                    array(
                        'id'=>'tek-blog-revslider-section-start',
                        'type' => 'section',
                        'title' => esc_html__('Blog Header Revolution Slider', 'ekko'),
                        'indent' => true,
                        'required' => array('tek-blog-header-template','equals','blog-header-revslider'),
                    ),
                    array(
                        'id' => 'tek-blog-header-slider-alias',
                        'type' => 'text',
                        'title' => esc_html__('Revolution Slider Alias Name', 'ekko'),
                        'required' => array('tek-blog-header-template','equals','blog-header-revslider'),
                        'default' => ''
                    ),
                    array(
                        'id'=>'tek-blog-revslider-section-end',
                        'type' => 'section',
                        'indent' => false,
                        'required' => array('tek-blog-header-template','equals','blog-header-revslider'),
                    ),
                )
            );

            $this->sections[] = array(
                'title' => esc_html__('Single Post', 'ekko'),
                'subsection' => true,
                'fields' => array(
                  array(
                      'id' => 'tek-single-post-template',
                      'type' => 'select',
                      'title' => esc_html__('Single Post Template', 'ekko'),
                      'subtitle' => esc_html__('Select the single post template style.', 'ekko'),
                      'select2' => array('allowClear' => false, 'minimumResultsForSearch' => '-1'),
                      'options'  => array(
                          'single-post-layout-one' => 'Title above featured image',
                          'single-post-layout-two' => 'Title on top featured image',
                      ),
                      'default' => 'single-post-layout-one'
                  ),
                  array(
                      'id' => 'tek-blog-single-sidebar',
                      'type' => 'switch',
                      'title' => esc_html__('Display Sidebar', 'ekko'),
                      'subtitle' => esc_html__('Enable to display the single post sidebar.', 'ekko'),
                      'default' => true
                  ),
                  array(
                      'id' => 'tek-blog-sticky-sidebar',
                      'type' => 'switch',
                      'title' => esc_html__('Sticky Sidebar', 'ekko'),
                      'subtitle' => esc_html__('Enable sticky sidebar for single blog posts.', 'ekko'),
                      'default' => true,
                      'required' => array(
                          'tek-blog-single-sidebar',
                          'equals',
                          true
                      ),
                  ),
                  array(
                      'id' => 'tek-blog-social-sharing',
                      'type' => 'switch',
                      'title' => esc_html__('Social Sharing', 'ekko'),
                      'subtitle' => esc_html__('Enable to display the social sharing buttons on single posts.', 'ekko'),
                      'default' => true
                  ),
                  array(
                      'id' => 'tek-author-box',
                      'type' => 'switch',
                      'title' => esc_html__('Author Box', 'ekko'),
                      'subtitle' => esc_html__('Enable to display author box below post content.', 'ekko'),
                      'default' => true
                  ),
                  array(
                      'id' => 'tek-blog-single-nav',
                      'type' => 'switch',
                      'title' => esc_html__('Previous/Next Pagination', 'ekko'),
                      'subtitle' => esc_html__('Enable to display the previous/next post pagination for single posts.', 'ekko'),
                      'default' => false
                  ),
                  array(
                      'id' => 'tek-related-posts',
                      'type' => 'switch',
                      'title' => esc_html__('Related Posts', 'ekko'),
                      'subtitle' => esc_html__('Enable to display related posts on single post pages.', 'ekko'),
                      'default' => true
                  ),
                  array(
                      'id' => 'tek-related-posts-title',
                      'type' => 'text',
                      'title' => esc_html__('Related Posts Title', 'ekko'),
                      'default' => 'Related articles',
                      'required' => array(
                                'tek-related-posts',
                                'equals',
                                true
                            ),
                  ),
                  array(
                            'id'       => 'tek-related-posts-number',
                      'type'     => 'slider',
                            'title'    => esc_html__( 'Number of Related Posts', 'ekko' ),
                            'subtitle' => esc_html__( 'Controls the number of posts that display under related posts section.', 'ekko' ),
                            'default'  => 3,
                            'max'      => 20,
                            'required' => array(
                                'tek-related-posts',
                                'equals',
                                true
                            ),
                    )
                )
            );

            $this->sections[] = array(
                'icon' => 'el-icon-check',
                'title' => esc_html__('Elements', 'ekko'),
                'desc' => esc_html__('These options will globally affect all elements.', 'ekko'),
                'fields' => array(

                    array(
                        'id' => 'tek-global-radius',
                        'type' => 'spinner',
                        'title' => esc_html__('Border Radius', 'ekko'),
                        'subtitle' => esc_html__('Control the border radius for all elements. Pixel value.', 'ekko'),
                        'min' => 0,
                        'max' => 25,
                        'default' => 25,
                    ),

                    array(
                        'id' => 'tek-cards-border-radius',
                        'type' => 'spinner',
                        'title' => esc_html__('Cards Border Radius', 'ekko'),
                        'subtitle' => esc_html__('Control the border radius for card elements. Pixel value.', 'ekko'),
                        'min' => 0,
                        'max' => 25,
                        'default' => 5,
                    ),

                )
            );

            $this->sections[] = array(
                'title' => esc_html__('Button Element', 'ekko'),
                'subsection' => true,
                'fields' => array(
                  array(
                      'id' => 'tek-button-typo',
                      'type' => 'typography',
                      'title' => esc_html__('Button Typography', 'ekko'),
                      'subtitle' => esc_html__('These settings control the typography for all button text.', 'ekko'),
                      'line-height' => false,
                      'text-align' => false,
                      'color' => true,
                      'text-transform' => true,
                      'letter-spacing' => true,
                      'units' => 'px',
                      'default' => array(
                        'font-size' => '14px',
                        'letter-spacing' => '1',
                      ),
                  ),

                  array(
                      'id' => 'tek-btn-border',
                      'type' => 'spinner',
                      'title'   => esc_html__('Button Border Width', 'ekko'),
                      'subtitle' => esc_html__('Control the border width for buttons. Pixel value.', 'ekko'),
                      'min' => 0,
                      'max' => 10,
                      'default' => 2,
                  ),

                  array(
                      'id' => 'tek-btn-radius',
                      'type' => 'spinner',
                      'title' => esc_html__('Button Border Radius', 'ekko'),
                      'subtitle' => esc_html__('Control the border radius for buttons. Pixel value.', 'ekko'),
                      'min' => 0,
                      'default' => 30,
                  ),

                  array(
                      'id' => 'tek-btn-padding',
                      'type' => 'spacing',
                      'mode' => 'padding',
                      'units' => array('em', 'px'),
                      'title' => esc_html__('Button Box Padding', 'ekko'),
                      'subtitle' => esc_html__('Controls the top/right/bottom/left padding of the button element.', 'ekko'),
                      'default' => array(
                          'padding-top' => '13px',
                          'padding-right' => '30px',
                          'padding-bottom' => '13px',
                          'padding-left' => '30px',
                          'units' => 'px',
                      )
                  ),

                  array(
                      'id' => 'tek-btn-effect',
                      'type' => 'select',
                      'title' => esc_html__('Button Hover Effect', 'ekko'),
                      'subtitle' => esc_html__('Select the button hover effect.', 'ekko'),
                      'select2' => array('allowClear' => false, 'minimumResultsForSearch' => '-1'),
                      'options'  => array(
                          '' => 'Default',
                          'btn-hover-1' => 'Float shadow',
                          'btn-hover-2' => 'Sweep to right',
                      ),
                      'default' => 'btn-hover-2'
                  ),
                )
            );

            $this->sections[] = array(
                'title' => esc_html__('Contact Form', 'ekko'),
                'desc' => esc_html__('The options on this tab apply to all forms throughout the site, including the 3rd party plugins that Ekko has design integration with.', 'ekko'),
                'subsection' => true,
                'fields' => array(
                  array(
                      'id' => 'tek-contact-form-typo',
                      'type' => 'typography',
                      'title' => esc_html__('Form Typography', 'ekko'),
                      'subtitle' => esc_html__('These settings control the typography for form fields.', 'ekko'),
                      'google' => false,
                      'font-family' => false,
                      'font-style' => true,
                      'font-size' => true,
                      'line-height' => false,
                      'color' => true,
                      'text-align' => false,
                      'text-transform' => true,
                      'all_styles' => false,
                      'units' => 'px',
                  ),
                  array(
                    'id' => 'tek-contact-form-bg-color',
                    'type' => 'color',
                    'transparent' => false,
                    'title' => esc_html__('Form Background Color', 'ekko'),
                    'subtitle' => esc_html__('Controls the background color of form fields.', 'ekko'),
                    'default' => '',
                    'validate' => 'color'
                  ),
                  array(
                    'id' => 'tek-contact-form-placeholder-color',
                    'type' => 'color',
                    'transparent' => false,
                    'title' => esc_html__('Form Placeholder Text Color', 'ekko'),
                    'subtitle' => esc_html__('Controls the placeholder text color of form fields.', 'ekko'),
                    'default' => '',
                    'validate' => 'color'
                  ),
                )
            );

            $this->sections[] = array(
                'icon' => 'el-icon-error-alt',
                'title' => esc_html__('404 Page', 'ekko'),
                'fields' => array(
                    array(
                        'id' => 'tek-404-title',
                        'type' => 'text',
                        'title' => esc_html__('Page Title', 'ekko'),
                        'default' => 'Error 404'
                    ),
                    array(
                        'id' => 'tek-404-subtitle',
                        'type' => 'text',
                        'title' => esc_html__('Page Subtitle', 'ekko'),
                        'default' => 'This page could not be found!'
                    ),
                    array(
                        'id' => 'tek-404-back',
                        'type' => 'text',
                        'title' => esc_html__('Back to Homepage Button Text', 'ekko'),
                        'default' => 'Back to homepage'
                    )
                )
            );
            $this->sections[] = array(
                'icon' => 'el-icon-wrench-alt',
                'title' => esc_html__('Maintenance Page', 'ekko'),
                'fields' => array(
                    array(
                        'id' => 'tek-maintenance-mode',
                        'type' => 'switch',
                        'title' => esc_html__('Enable Maintenance Mode', 'ekko'),
                        'subtitle' => esc_html__('Activate to enable maintenance mode.', 'ekko'),
                        'default' => false
                    ),
                    array(
                        'id' => 'tek-maintenance-title',
                        'type' => 'text',
                        'title' => esc_html__('Page Title', 'ekko'),
                        'required' => array('tek-maintenance-mode','equals', true),
                        'default' => 'ekko is in the works!'
                    ),
                    array(
                        'id' => 'tek-maintenance-content',
                        'type' => 'editor',
                        'title' => esc_html__('Page Content', 'ekko'),
                        'required' => array('tek-maintenance-mode','equals', true),
                        'default' => '',
                            'args'   => array(
                          'teeny'  => true,
                          'textarea_rows' => 10,
                          'media_buttons' => false,
                              )
                    ),

                    array(
                        'id' => 'tek-maintenance-bg-image',
                        'type' => 'media',
                        'readonly' => false,
                        'url' => true,
                        'title' => esc_html__('Page Background Image', 'ekko'),
                        'subtitle' => esc_html__('Upload page background image.', 'ekko'),
                        'required' => array('tek-maintenance-mode','equals', true),
                        'default' => '',
                    ),

                    array(
                      'id' => 'tek-maintenance-text-color',
                      'type' => 'color',
                      'transparent' => false,
                      'title' => esc_html__('Text Color', 'ekko'),
                      'subtitle' => esc_html__('Overwrite text color. If none selected, the default theme color will be used.', 'ekko'),
                      'required' => array('tek-maintenance-mode','equals', true),
                      'default' => '',
                      'validate' => 'color'
                    ),

                    array(
                        'id' => 'tek-maintenance-countdown',
                        'type' => 'switch',
                        'title' => esc_html__('Enable Countdown', 'ekko'),
                        'subtitle' => esc_html__('Activate to enable the countdown timer.', 'ekko'),
                        'required' => array('tek-maintenance-mode','equals', true),
                        'default' => false
                    ),
                    array(
                        'id' => 'tek-maintenance-count-day',
                        'type' => 'text',
                        'title' => esc_html__('End Day', 'ekko'),
                        'subtitle' => esc_html__('Enter day value. Eg. 05', 'ekko'),
                        'required' => array('tek-maintenance-countdown','equals', true),
                        'default' => ''
                    ),
                    array(
                        'id' => 'tek-maintenance-count-month',
                        'type' => 'text',
                        'title' => esc_html__('End Month', 'ekko'),
                        'subtitle' => esc_html__('Enter month value. Eg. 09', 'ekko'),
                        'required' => array('tek-maintenance-countdown','equals', true),
                        'default' => ''
                    ),
                    array(
                        'id' => 'tek-maintenance-count-year',
                        'type' => 'text',
                        'title' => esc_html__('End Year', 'ekko'),
                        'subtitle' => esc_html__('Enter year value. Eg. 2020', 'ekko'),
                        'required' => array('tek-maintenance-countdown','equals', true),
                        'default' => ''
                    ),
                    array(
                        'id' => 'tek-maintenance-subscribe',
                        'type' => 'switch',
                        'title' => esc_html__('Enable Contact Form', 'ekko'),
                        'subtitle' => esc_html__('Activate to enable contact form on page.', 'ekko'),
                        'required' => array('tek-maintenance-mode','equals', true),
                        'default' => false
                    ),
                    array(
                        'id' => 'tek-maintenance-form-select',
                        'type' => 'select',
                        'title' => esc_html__('Contact Form Plugin', 'ekko'),
                        'required' => array('tek-maintenance-subscribe','equals',true),
                        'select2' => array('allowClear' => false, 'minimumResultsForSearch' => '-1'),
                        'options'  => array(
                            '1' => 'Contact Form 7',
                            '2' => 'Ninja Forms',
                            '3' => 'Gravity Forms',
                            '4' => 'WP Forms',
                        ),
                        'default' => '1'
                    ),
                    array(
                        'id' => 'tek-maintenance-contactf7-formid',
                        'type' => 'select',
                        'data' => 'posts',
                        'args' => array( 'post_type' => 'wpcf7_contact_form', 'posts_per_page' => -1, ),
                        'title' => esc_html__('Contact Form 7 Title', 'ekko'),
                        'required' => array('tek-maintenance-form-select','equals','1'),
                        'select2' => array('allowClear' => false, 'minimumResultsForSearch' => '-1'),
                        'default' => ''
                    ),
                    array(
                        'id' => 'tek-maintenance-ninja-formid',
                        'type' => 'text',
                        'title' => esc_html__('Ninja Form ID', 'ekko'),
                        'required' => array('tek-maintenance-form-select','equals','2'),
                        'default' => ''
                    ),
                    array(
                        'id' => 'tek-maintenance-gravity-formid',
                        'type' => 'text',
                        'title' => esc_html__('Gravity Form ID', 'ekko'),
                        'required' => array('tek-maintenance-form-select','equals','3'),
                        'default' => ''
                    ),
                    array(
                        'id' => 'tek-maintenance-wp-formid',
                        'type' => 'text',
                        'title' => esc_html__('WP Form ID', 'ekko'),
                        'required' => array('tek-maintenance-form-select','equals','4'),
                        'default' => ''
                    ),

                )
            );
            $this->sections[] = array(
                'icon' => 'el-icon-css',
                'title' => esc_html__('Custom CSS/JS', 'ekko'),
                'fields' => array(
                    array(
                        'id' => 'tek-css',
                        'type' => 'ace_editor',
                        'title' => esc_html__('CSS', 'ekko'),
                        'subtitle' => esc_html__('Enter your CSS code in the side field. Do not include any tags or HTML in the field. Custom CSS entered here will override the theme CSS.', 'ekko'),
                        'mode' => 'css',
                        'theme' => 'chrome',
                    ),
                    array(
                            'id' => 'tek-javascript',
                            'type' => 'ace_editor',
                            'title' => esc_html__( 'Javascript', 'ekko' ),
                            'subtitle' => esc_html__( 'Only accepts Javascript code.', 'ekko' ),
                            'mode' => 'html',
                            'theme' => 'chrome',
                        ),
                )
            );
        }
        /**
        * All the possible arguments for Redux.
        * For full documentation on arguments, please refer to: https://github.com/ReduxFramework/ReduxFramework/wiki/Arguments
        **/
        public function setArguments()
        {
            $theme                         = wp_get_theme(); // For use with some settings. Not necessary.
            $this->args                    = array(
                'opt_name' => 'redux_ThemeTek',
                'menu_type'            => 'submenu',

                'menu_title'           => esc_html__( 'Theme Options', 'ekko' ),
                'page_title'           => esc_html__( 'Theme Options', 'ekko' ),

                'async_typography'     => false,
                'admin_bar'            => false,
                'dev_mode'             => false,
                'show_options_object'  => false,
                'customizer'           => false,
                'show_import_export'   => true,

                'page_parent'          => 'ekko-dashboard',
                'page_permissions'     => 'manage_options',
                'page_slug'            => 'theme-options',
                'hints' => array(
                    'icon' => 'el-icon-question-sign',
                    'icon_position' => 'right',
                    'icon_size' => 'normal',
                    'tip_style' => array(
                        'color' => 'light'
                    ),
                    'tip_position' => array(
                        'my' => 'top left',
                        'at' => 'bottom right'
                    ),
                    'tip_effect' => array(
                        'show' => array(
                            'duration' => '500',
                            'event' => 'mouseover'
                        ),
                        'hide' => array(
                            'duration' => '500',
                            'event' => 'mouseleave unfocus'
                        )
                    )
                ),
                'output' => '1',
                'output_tag' => '1',
                'compiler' => '0',
                'page_icon' => 'icon-themes',
                'save_defaults' => '1',
                'transient_time' => '3600',
                'network_sites' => '1'
            );
            $theme                         = wp_get_theme(); // For use with some settings. Not necessary.
            $this->args["display_name"]    = $theme->get("Name");
            $this->args["display_version"] = $theme->get("Version");

        }
    }
    global $reduxConfig;
    $reduxConfig = new keydesign_Redux_Framework_config();
}
