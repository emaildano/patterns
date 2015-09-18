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

class Patterns__Main {

  public function __constuct() {

  }

  public static function Patterns_Init() {
    self::Patterns_Setup();
  }

  /**
   * Create CPTs and Taxonomy
   */
  public static function Patterns_Setup() {
    // Initiate CPTs, Tax, and Options
    require plugin_dir_path( __FILE__ ) . 'class-patterns-base.php';
    new Patterns__Base;
  }


}

