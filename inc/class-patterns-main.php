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


if ( ! class_exists( 'Patterns__Main' ) ) {
  class Patterns__Main {

    private $_patterns_plugin_path;
    private $_patterns_views_path;
    public static $_patterns_post_types;

    public function __constuct() {
      $this->_patterns_plugin_path  = trailingslashit( dirname( __FILE__ ) );
      $this->_patterns_views_dir    = 'views';
      $this->_patterns_post_types   = array('patterns', 'patterns_colors', 'patterns_typography');
    }


    /**
     * This function initiates everything
     */
    public function Patterns_Init() {
      $this->Patterns_Require();
      $this->Patterns_Loader();
    }

    /**
     * Get all files needed for initialization
     */
    private function Patterns_Require() {
      // Initiate CPTs, Tax, and Options
      require $this->_patterns_plugin_path . 'class-patterns-base.php';
      require $this->_patterns_plugin_path . 'class-patterns-views.php';
    }

    /**
     * Create CPTs and Taxonomy
     */
    private function Patterns_Loader() {

      /**
       * Create Custom Post Types
       */
      new Patterns__Base;

      /**
       * Display Templates
       */
      new Patterns__Views_Init;
    }


  }

}

