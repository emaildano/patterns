<?php

/**
 * Colors Section Template Part
 * Displays on main Patterns Archive Page
 *
 *
 * @link       https://github.com/iamhexcoder
 * @since      1.0.0
 *
 * @package    Patterns
 * @subpackage Patterns/includes
 * @author     Shaun Baer <shaun.baer@gmail.com>
 */



foreach($color_posts as $post) {
  setup_postdata( $post );

  $color_info = $view->Patterns__Colors_Class($post);
  $value = key($color_info);

  // Print Some Stuff!!
  echo '<pre>'; print_r($color_info); echo '</pre>';


  echo '<div class="patterns--colors-wrapper patterns--colors-' . $color_info[$value] . '">';
    echo '<div class="pattern-color-title">';
      echo '<p>' . $value . '</p>';
    echo '</div>';
  echo '</div>';

}



