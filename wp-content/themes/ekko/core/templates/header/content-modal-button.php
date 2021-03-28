<?php
  $redux_ThemeTek = get_option( 'redux_ThemeTek' );

  /* Button style and color scheme */
  $btn_wrapper_class = $button_style_class = $button_color_class = $button_hover_class = '';
  if (isset($redux_ThemeTek['tek-header-button-style'])) {
    if ($redux_ThemeTek['tek-header-button-style'] == 'solid-button') {
      $button_style_class .= 'tt_primary_button';
    } elseif ($redux_ThemeTek['tek-header-button-style'] == 'outline-button') {
      $button_style_class .= 'tt_secondary_button';
    } else {
      $button_style_class .= 'tt_primary_button';
    }
  }

  if (isset($redux_ThemeTek['tek-header-button-color'])) {
    if ($redux_ThemeTek['tek-header-button-color'] == 'primary-color') {
      $button_color_class .= 'btn_primary_color';
    } elseif ($redux_ThemeTek['tek-header-button-color'] == 'secondary-color') {
      $button_color_class .= 'btn_secondary_color';
    } else {
      $button_color_class .= 'btn_primary_color';
    }
  }

  if (isset($redux_ThemeTek['tek-header-button-hover-style'])) {
      $button_hover_class .= $redux_ThemeTek['tek-header-button-hover-style'];
  }

  $btn_wrapper_class = implode(' ', array('modal-menu-item', 'tt_button', $button_style_class, $button_color_class, $button_hover_class));
?>

<?php if ($redux_ThemeTek['tek-modal-button'] && ($redux_ThemeTek['tek-header-button-action'] == '1')) : ?>
   <a class="<?php echo esc_attr($btn_wrapper_class); ?>" data-toggle="modal" data-target="#popup-modal"><?php echo esc_html($redux_ThemeTek['tek-header-button-text']);?></a>
<?php elseif ($redux_ThemeTek['tek-modal-button'] && ($redux_ThemeTek['tek-header-button-action'] == '2')) : ?>
  <?php if (isset($redux_ThemeTek['tek-scroll-id']) && $redux_ThemeTek['tek-scroll-id'] != '' ) : ?>
     <a class="<?php echo esc_attr($btn_wrapper_class); ?> scroll-section" href="<?php if( is_page('Home')) { echo esc_attr($redux_ThemeTek['tek-scroll-id']); } else { echo esc_url(site_url()) . esc_attr($redux_ThemeTek['tek-scroll-id']);} ?>"><?php echo esc_html($redux_ThemeTek['tek-header-button-text']);?></a>
  <?php endif; ?>
<?php elseif ($redux_ThemeTek['tek-modal-button'] && ($redux_ThemeTek['tek-header-button-action'] == '3')) : ?>
<?php if (isset($redux_ThemeTek['tek-button-new-page']) && $redux_ThemeTek['tek-button-new-page'] != '' ) : ?>
 <a class="<?php echo esc_attr($btn_wrapper_class); ?>" <?php echo (isset($redux_ThemeTek['tek-button-target']) &&  $redux_ThemeTek['tek-button-target'] == 'new-page') ? 'target="_blank"' : 'target="_self"'; ?> href="<?php echo esc_url($redux_ThemeTek['tek-button-new-page']); ?>"><?php echo esc_html($redux_ThemeTek['tek-header-button-text']);?></a>
<?php endif; ?>
<?php endif; ?>
