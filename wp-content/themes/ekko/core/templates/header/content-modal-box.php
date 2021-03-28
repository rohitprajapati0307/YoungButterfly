<?php
  $redux_ThemeTek = get_option( 'redux_ThemeTek' );

  $modal_wrapper_class = $modal_css_class = $modal_template_class = '';

  if (isset($redux_ThemeTek['tek-modal-css-class']) && $redux_ThemeTek['tek-modal-css-class'] != '' ) {
      $modal_css_class = $redux_ThemeTek['tek-modal-css-class'];
  }

  $modal_wrapper_class = implode(' ', array('modal', 'fade', 'popup-modal', $modal_css_class));
?>
  <div class="<?php echo esc_attr($modal_wrapper_class); ?>" id="popup-modal" role="dialog">
    <div class="modal-content">
        <div class="row">
          <div class="col-sm-6 modal-content-contact">
            <?php if (isset($redux_ThemeTek['tek-modal-title']) && $redux_ThemeTek['tek-modal-title'] != '' ) : ?>
                <h3><?php echo esc_html($redux_ThemeTek['tek-modal-title']); ?></h3>
            <?php endif; ?>
            <?php if (isset($redux_ThemeTek['tek-modal-subtitle']) && $redux_ThemeTek['tek-modal-subtitle'] != '' ) : ?>
                <p><?php echo wp_kses_post($redux_ThemeTek['tek-modal-subtitle']); ?></p>
            <?php endif; ?>
            <?php if (isset($redux_ThemeTek['tek-business-phone']) && $redux_ThemeTek['tek-business-phone'] != '' ) : ?>
                <div class="key-icon-box icon-default icon-left cont-left">
                    <i class="iconsmind-Phone fa"></i>
                    <h4 class="service-heading"><a href="tel:<?php echo esc_attr($redux_ThemeTek['tek-business-phone']); ?>"><?php echo esc_html($redux_ThemeTek['tek-business-phone']); ?></a></h4>
                </div>
            <?php endif; ?>
            <?php if (isset($redux_ThemeTek['tek-business-email']) && $redux_ThemeTek['tek-business-email'] != '' ) : ?>
                <div class="key-icon-box icon-default icon-left cont-left">
                    <i class="iconsmind-Mail fa"></i>
                    <h4 class="service-heading"><a href="mailto:<?php echo esc_attr($redux_ThemeTek['tek-business-email']); ?>"><?php echo esc_html($redux_ThemeTek['tek-business-email']); ?></a></h4>
                </div>
            <?php endif; ?>
            <?php if (isset($redux_ThemeTek['tek-modal-socials']) && $redux_ThemeTek['tek-modal-socials']) : ?>
              <div class="kd-modal-social-list">
                <?php echo do_shortcode('[social_profiles]'); ?>
              </div>
            <?php endif; ?>
          </div>
          <div class="col-sm-6 modal-content-inner" style="background-image: url('<?php if (isset($redux_ThemeTek['tek-modal-bg-image']) && $redux_ThemeTek['tek-modal-bg-image'] != '' ) { echo esc_url($redux_ThemeTek['tek-modal-bg-image']['url']); } ?>')">
              <?php if (isset($redux_ThemeTek['tek-modal-form-select']) && $redux_ThemeTek['tek-modal-form-select'] != '' ) : ?>
                   <?php if ($redux_ThemeTek['tek-modal-form-select'] == '1' && $redux_ThemeTek['tek-modal-contactf7-formid'] != '') : ?>
                        <?php echo do_shortcode('[contact-form-7 id="'. esc_attr($redux_ThemeTek['tek-modal-contactf7-formid']).'"]'); ?>
                   <?php elseif ($redux_ThemeTek['tek-modal-form-select'] == '2' && $redux_ThemeTek['tek-modal-ninja-formid'] != '') : ?>
                        <?php echo do_shortcode('[ninja_form id="'. esc_attr($redux_ThemeTek['tek-modal-ninja-formid']).'"]'); ?>
                   <?php elseif ($redux_ThemeTek['tek-modal-form-select'] == '3' && $redux_ThemeTek['tek-modal-gravity-formid'] != '') : ?>
                        <?php echo do_shortcode('[gravityform id="'. esc_attr($redux_ThemeTek['tek-modal-gravity-formid']).'"]'); ?>
                   <?php elseif ($redux_ThemeTek['tek-modal-form-select'] == '4' && $redux_ThemeTek['tek-modal-wp-formid'] != '') : ?>
                        <?php echo do_shortcode('[wpforms id="'. esc_attr($redux_ThemeTek['tek-modal-wp-formid']).'"]'); ?>
                   <?php endif; ?>
              <?php endif; ?>
          </div>
        </div>
      <button type="button" class="close" data-dismiss="modal">&times;</button>
  </div>
</div>
