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

  public $_patterns_plugin_path;

  public function __construct() {
    $this->_patterns_plugin_path = plugin_dir_path( __DIR__ );

    // Archive Template
    add_filter( 'archive_template', array( $this, 'Patterns_View_Templates' ) ) ;

    // Redirect Single and Color/Type CPTs to Archive
    add_action( 'template_redirect', array( $this, 'Patterns_Single_Redirect' ) );

    // Change Archive Query
    add_action( 'pre_get_posts', array( $this, 'Patterns_Archive_Query' ) );

    // Enqueue Away
    add_action( 'wp_enqueue_scripts', array( $this, 'Patterns_Enqueue_Styles' ) );
    add_action( 'wp_enqueue_scripts', array( $this, 'Patterns_Enqueue_Scripts' ) );
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

  /**
   * Change the defualt query for the Patterns archive to include colors and typography posts
   * @param [type] $query [description]
   */
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


  /**
   * Enqueue Styles and Scripts
   */
  public function Patterns_Enqueue_Scripts() {
    if ( is_post_type_archive( 'patterns' ) ) {
      wp_enqueue_script( 'patterns-scripts', plugins_url( 'assets/js/patterns.js', __DIR__ ), array('jquery'), true );
    }
  }

  public function Patterns_Enqueue_Styles() {
    if ( is_post_type_archive( 'patterns' ) ) {
      wp_enqueue_style( 'patterns-css', plugins_url( 'assets/css/styles.css', __DIR__ ) );
    }
  }


}