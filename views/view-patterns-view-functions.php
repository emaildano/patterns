<?php

/**
 * Creates the Patterns Custom Post Type and Taxonomy
 *
 * @link       https://github.com/iamhexcoder
 * @since      1.0.0
 *
 * @package    Patterns
 * @subpackage Patterns/includes
 * @author     Shaun Baer <shaun.baer@gmail.com>
 */

class Patterns__View_Functions {

  public static function Patterns_Archive_Part($name, $post_array) {
    $section_id = strtolower($name);
    $section_id = str_replace(' ', '-', $section_id);

    $html = '<section id="patterns-' . $section_id . '" class="patterns-type-section">';

      $html .= '<h1>' . $name . '</h1>';
      foreach($post_array as $post) {
        setup_postdata( $post );

        $html .= '<p>' . get_the_title() . '</p>';
      }
      wp_reset_postdata();


    $html .= '</section>';

    echo $html;
  }

}