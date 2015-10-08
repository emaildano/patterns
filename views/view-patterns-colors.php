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

  $html = '<div class="patterns--colors-wrapper patterns--colors-' . $color_info[$value] . '">';
    $html .= '<div class="pattern-color-title">';
      $html .= '<p>' . $value . '</p>';
    $html .= '</div>';
  $html .= '</div>';

  echo $html;

}



