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


  /**
   * Returns
   */
  public function Patterns__Post_Main($post) {
    $post_content = array();

    $meta   = get_post_meta($post->ID);
    $post_content['code']         = null;
    $post_content['code_display'] = null;
    $post_content['code_html']    = null;
    $post_content['desc']         = null;
    $post_content['desc_content'] = null;

    if( array_key_exists( '_Patterns__Main_code_value', $meta ) ) {
      $code = $meta['_Patterns__Main_code_value'][0];
      if( !empty($code) ) $post_content['code'] = true;
      $post_content['code_display'] = html_entity_decode($code);
      $post_content['code_raw'] = $code;
    }


    if( array_key_exists( '_Patterns__Main_desc_value', $meta ) ) {
      $desc = $meta['_Patterns__Main_desc_value'][0];
      if( !empty($desc) ) $post_content['desc'] = true;
      $post_content['desc_content'] = nl2br($desc);
    }


    return $post_content;
  }


}