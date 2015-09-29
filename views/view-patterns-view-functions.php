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

class Patterns__View_Funcs {

  /**
   * Order Post Types
   *
   * @param array $posts
   */
  public function Patterns__Post_Sort( $posts ) {
    $posts_array = array();

    /**
     * Order Posts by Post Type
     */
    foreach($posts as $entry) {
      $type = $entry->post_type;
      $posts_array[$type][] = $entry;
    }

    /**
     * Sort pattern posts by taxonomy.
     *
     * Remove post from $post_array[patterns], and add post to
     * $post_array[patterns][taxonomy_key].
     *
     * If a taxonomy does not exist, sort it into a default key.
     */
    if($posts_array['patterns']) {
      foreach($posts_array['patterns'] as $key=>$pattern) {
        $types = get_the_terms( $pattern->ID, 'pattern_type' );

        if($types) {
          foreach($types as $type) {
            $type_name = $type->name;
            unset($posts_array['patterns'][$key]);
            $posts_array['patterns'][$type_name][] = $pattern;
          }
        } else {
          unset($posts_array['patterns'][$key]);
          $posts_array['patterns']['Basic Patterns'][] = $pattern;
        }
      }
    }

    return $posts_array;
  }


}