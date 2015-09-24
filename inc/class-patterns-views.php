<?php

/**
 * Creates the Patterns Views
 *
 * @link       https://github.com/iamhexcoder
 * @since      1.0.0
 *
 * @package    Patterns
 * @subpackage Patterns/includes
 * @author     Shaun Baer <shaun.baer@gmail.com>
 */

class Patterns__Views_Init {

  public function __construct() {
    add_filter( 'archive_template', array( $this, 'Patterns_View_Templates' ) ) ;
    add_action( 'template_redirect', array( $this, 'Patterns_Single_Redirect' ) );
    add_action( 'pre_get_posts', array( $this, 'Patterns_Archive_Query' ) );
  }

  /**
   * Point to plugin template for archives
   */
  public function Patterns_View_Templates( $archive_template ) {
     global $post;

     if ( is_post_type_archive ( 'patterns' ) ) {
      $archive_template = dirname( __DIR__ ) . '/views/view-patterns-archive-primary.php';
     }

     return $archive_template;
  }

  /**
   * Redirect single pages back to archive page
   */
  public function Patterns_Single_Redirect() {

    if ( is_singular( Patterns__Main::$_patterns_post_types ) ) {
      wp_redirect( get_post_type_archive_link( 'patterns' ), 301 );
      exit;
    }
  }

  // Change Posts Per Page and Order for Post Types
  public function Patterns_Archive_Query( $query ) {
    if ( is_admin() || is_search() )
      return;

    if ( is_post_type_archive( 'patterns' ) ) {
      // Return all posts
      $query->set( 'post_type', array('patterns', 'patterns_colors', 'patterns_typography') );
      $query->set( 'posts_per_page', -1 );
      $query->set( 'order', 'ASC' );
      $query->set( 'orderby', 'menu_order' );
      return;
    }
  }


}