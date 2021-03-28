<?php
/**
 * The template used for displaying navigation for single Blog posts
 */
 ?>

 <div class="navigation pagination">
   <?php previous_post_link('%link', esc_html__('Previous', 'ekko')); ?>
   <?php next_post_link('%link', esc_html__('Next', 'ekko')); ?>
 </div>
