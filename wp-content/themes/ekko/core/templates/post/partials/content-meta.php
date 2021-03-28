<?php
/**
 * The template used for displaying meta information for single Blog posts
 */
 ?>

 <div class="entry-meta">
   <?php  if ( is_sticky() ) echo '<span class="fa fa-thumb-tack"></span> Sticky <span class="blog-separator">|</span>  '; ?>
   <span class="published"><span class="fa fa-clock-o"></span><?php the_time( get_option('date_format') ); ?></span>
   <span class="author"><span class="fa fa-keyboard-o"></span><?php the_author_posts_link(); ?></span>
   <span class="blog-label"><span class="fa fa-folder-open-o"></span><?php the_category(', '); ?></span>
 </div>
