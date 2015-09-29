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

class Patterns__Base {

  public $_patterns_options;
  public $_patterns_option_slug;
  public $_patterns_slug;

  public function __construct() {
    $this->_patterns_slug = $this->Patterns_Slug();

    // CPTs
    add_action( 'init', array( $this, 'Patterns_Primary_CPT' ) );
    add_action( 'init', array( $this, 'Patterns_Colors_CPT' ) );
    add_action( 'init', array( $this, 'Patterns_Typography_CPT' ) );
    add_action( 'init', array( $this, 'Patterns_Taxonomy' ) );

    // Settings Page
    add_action( 'admin_init', array( $this, 'Patterns_Settings_Init' ) );

    // Admin Menu
    add_action( 'admin_menu', array( $this, 'Patterns_Add_Admin_Menu' ) );
    add_action('admin_menu', array( $this, 'Patterns_Hide_Add_New') );
  }


  public function Patterns_Slug() {
    $this->_patterns_options     = get_option( 'patterns_settings' );
    $this->_patterns_option_slug = $this->_patterns_options['patterns_cpt_slug'];
    $this->_patterns_slug = $this->_patterns_option_slug ? $this->_patterns_option_slug : 'pattern-library';

    return $this->_patterns_slug;
  }

  /**
   * Create the Main Patterns Custom Post Type
   */

  public function Patterns_Primary_CPT() {

    $args = array(
      'label'               => 'Pattern',
      'labels'              => array(
        'name'              => 'Patterns',
        'singular_name'     => 'Pattern'
      ),
      'supports'            => array( 'title' ),
      'taxonomies'          => array( 'pattern_type' ),
      'menu_position'       => 100,
      'menu_icon'           => 'dashicons-layout',
      'rewrite'             => array(
        'slug'              => $this->_patterns_slug
      ),
      'capability_type'     => 'page',
      'hierarchical'        => true,
      'public'              => true,
      'has_archive'         => true,
      'exclude_from_search' => true,
    );

    register_post_type( 'patterns', $args );

  }

  /**
   *  Colors CPT
   */

  public function Patterns_Colors_CPT() {

    $args = array(
      'label'               => 'Colors',
      'labels'              => array(
        'name'              => 'Colors',
        'singular_name'     => 'Color'
      ),
      'supports'            => array( 'title' ),
      'hierarchical'        => true,
      'public'              => true,
      'has_archive'         => true,
      'exclude_from_search' => true,
      'rewrite'             => array(
        'slug'              => $this->_patterns_slug . '-colors'
      ),
      'capability_type'     => 'page',
      'show_in_menu'        => 'edit.php?post_type=patterns'
    );

    register_post_type( 'patterns_colors', $args );

  }


  /**
   *  Typography CPT
   */

  public function Patterns_Typography_CPT() {

    $args = array(
      'label'               => 'Typography Styles',
      'labels'              => array(
        'name'              => 'Typography Styles',
        'singular_name'     => 'Typography Style'
      ),
      'supports'            => array( 'title' ),
      'hierarchical'        => true,
      'public'              => true,
      'has_archive'         => true,
      'exclude_from_search' => true,
      'rewrite'             => array(
        'slug'              => $this->_patterns_slug . '-type-styles'
      ),
      'capability_type'     => 'page',
      'show_in_menu'        => 'edit.php?post_type=patterns'
    );

    register_post_type( 'patterns_typography', $args );

  }


  /**
   * Pattern Type Taxonomy
   */
  public function Patterns_Taxonomy() {

    $args = array(
      'labels'                     => array(
        'name'                       => 'Pattern Types',
        'singular_name'              => 'Pattern Type'
      ),
      'hierarchical'               => true,
      'show_tagcloud'              => false,
    );

    register_taxonomy( 'pattern_type', array( 'patterns' ), $args );

  }


  /**
   * Hide 'Add New' for Patterns CPT
   */
  public function Patterns_Hide_Add_New() {
      global $submenu;
      unset($submenu['edit.php?post_type=patterns'][10]);
  }



  /**
   * SETTINGS PAGE
   */

  /**
   * Add Settings page to Patterns CPT menu item
   */
  public function Patterns_Add_Admin_Menu() {
    add_submenu_page( 'edit.php?post_type=patterns', 'Settings', 'Settings', 'manage_options', 'patterns', array( $this, 'patterns_options_page') );
  }


  /**
   * Plugin Settings Page
   */
  public function Patterns_Settings_Init() {

    register_setting( 'patterns_plugin_page', 'patterns_settings' );

    // Basic Description Section
    add_settings_section(
      'patterns_patterns_plugin_page_section',
      __( 'Patterns Settings', 'wordpress' ),
      array($this, 'patterns_settings_section_callback' ),
      'patterns_plugin_page'
    );

    // Slug Field
    add_settings_field(
      'patterns_cpt_slug',
      __( 'Pattern Library Slug', 'wordpress' ),
      array($this, 'patterns_cpt_slug_render'),
      'patterns_plugin_page',
      'patterns_patterns_plugin_page_section'
    );

  }


  /**
   * Description of Settings Page
   */
  public function patterns_settings_section_callback() {
    echo __( 'Basic Settings for Patterns', 'wordpress' );
  }


  /**
   * Create Textfield for Slug
   */
  public function patterns_cpt_slug_render() {
    $slug = $this->_patterns_slug;
    if(!$slug) $slug = 'pattern-library';
    echo '<input type="text" name="patterns_settings[patterns_cpt_slug]" value="' .  $slug . '">';
  }


  /**
   * Build the options page
   */
  public function patterns_options_page() {
    echo '<form action="options.php" method="post">';
      settings_fields( 'patterns_plugin_page' );
      do_settings_sections( 'patterns_plugin_page' );
      submit_button();
    echo '</form>';

    // Flush them rules
    flush_rewrite_rules();
  }
}



