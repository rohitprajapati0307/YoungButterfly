<?php
  $redux_ThemeTek = get_option( 'redux_ThemeTek' );

  $panel_wrapper_class = $button_hover_class = $panel_css_class =  '';

  if (isset($redux_ThemeTek['tek-panel-css-class']) && $redux_ThemeTek['tek-panel-css-class'] != '' ) {
      $panel_css_class = $redux_ThemeTek['tek-panel-css-class'];
  }

  if (isset($redux_ThemeTek['tek-btn-effect']) && $redux_ThemeTek['tek-btn-effect'] != '' ) {
    $button_hover_class = $redux_ThemeTek['tek-btn-effect'];
  }

  $panel_wrapper_class = implode(' ', array('kd-side-panel', $button_hover_class, $panel_css_class));
?>
  <div class="panel-screen-overlay"></div>
  <div class="<?php echo esc_attr($panel_wrapper_class); ?>">
    <div class="kd-panel-wrapper">
      <div class="kd-panel-header">
        <?php if (isset($redux_ThemeTek['tek-panel-title']) && $redux_ThemeTek['tek-panel-title'] != '' ) : ?>
            <h3 class="kd-panel-title"><?php echo esc_html($redux_ThemeTek['tek-panel-title']); ?></h3>
        <?php endif; ?>
        <?php if (isset($redux_ThemeTek['tek-panel-subtitle']) && $redux_ThemeTek['tek-panel-subtitle'] != '' ) : ?>
            <div class="kd-panel-subtitle">
              <?php echo wp_kses_post($redux_ThemeTek['tek-panel-subtitle']); ?>
            </div>
        <?php endif; ?>
        <div class="kd-panel-phone-email">
        <?php if (isset($redux_ThemeTek['tek-business-phone']) && $redux_ThemeTek['tek-business-phone'] != '' ) : ?>
            <div class="kd-panel-phone">
                <i class="fa fa-phone"></i>
                <a href="tel:<?php echo esc_attr($redux_ThemeTek['tek-business-phone']); ?>"><?php echo esc_html($redux_ThemeTek['tek-business-phone']); ?></a>
            </div>
        <?php endif; ?>
        <?php if (isset($redux_ThemeTek['tek-business-email']) && $redux_ThemeTek['tek-business-email'] != '' ) : ?>
            <div class="kd-panel-email">
                <i class="fa fa-envelope"></i>
                <a href="mailto:<?php echo esc_attr($redux_ThemeTek['tek-business-email']); ?>"><?php echo esc_html($redux_ThemeTek['tek-business-email']); ?></a>
            </div>
        <?php endif; ?>
        </div>
        <div class="kd-panel-contact">
          <?php if (isset($redux_ThemeTek['tek-panel-form-select']) && $redux_ThemeTek['tek-panel-form-select'] != '' ) : ?>
               <?php if ($redux_ThemeTek['tek-panel-form-select'] == '1' && $redux_ThemeTek['tek-panel-contactf7-formid'] != '') : ?>
                    <?php echo do_shortcode('[contact-form-7 id="'. esc_attr($redux_ThemeTek['tek-panel-contactf7-formid']).'"]'); ?>
               <?php elseif ($redux_ThemeTek['tek-panel-form-select'] == '2' && $redux_ThemeTek['tek-panel-ninja-formid'] != '') : ?>
                    <?php echo do_shortcode('[ninja_form id="'. esc_attr($redux_ThemeTek['tek-panel-ninja-formid']).'"]'); ?>
               <?php elseif ($redux_ThemeTek['tek-panel-form-select'] == '3' && $redux_ThemeTek['tek-panel-gravity-formid'] != '') : ?>
                    <?php echo do_shortcode('[gravityform id="'. esc_attr($redux_ThemeTek['tek-panel-gravity-formid']).'"]'); ?>
               <?php elseif ($redux_ThemeTek['tek-panel-form-select'] == '4' && $redux_ThemeTek['tek-panel-wp-formid'] != '') : ?>
                    <?php echo do_shortcode('[wpforms id="'. esc_attr($redux_ThemeTek['tek-panel-wp-formid']).'"]'); ?>
               <?php endif; ?>
          <?php endif; ?>
      </div>
      </div>
      <?php if (isset($redux_ThemeTek['tek-panel-socials']) && $redux_ThemeTek['tek-panel-socials']) : ?>
        <div class="kd-panel-social-list">
          <?php echo do_shortcode('[social_profiles]'); ?>
        </div>
      <?php endif; ?>
      <button type="button" class="panel-close" data-dismiss="side-panel">&times;</button>
  </div>
</div>
