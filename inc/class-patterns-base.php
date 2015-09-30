<?php

/**
 * Creates the Patterns Custom Post Type
 * Creates the Patterns 'Pattern Type' Taxonomy
 * Creates the Settings Page
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
    $this->_patterns_options  = get_option( 'patterns_settings' );
    $this->_patterns_option_slug = $this->_patterns_options['patterns_cpt_slug'];
    $this->_patterns_slug = $this->_patterns_option_slug ? $this->_patterns_option_slug : 'pattern-library';

    // CPTs
    add_action( 'init', array( $this, 'Patterns_Primary_CPT' ) );
    add_action( 'init', array( $this, 'Patterns_Colors_CPT' ) );
    add_action( 'init', array( $this, 'Patterns_Typography_CPT' ) );
    add_action( 'init', array( $this, 'Patterns_Taxonomy' ) );

    // Settings Page
    add_action( 'admin_init', array( $this, 'Patterns_Settings_Init' ) );

    // Admin Menu
    add_action( 'admin_menu', array( $this, 'Patterns_Add_Admin_Menu' ) );
    add_action( 'admin_menu', array( $this, 'Patterns_Hide_Add_New') );
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
    add_submenu_page( 'edit.php?post_type=patterns', 'Settings', 'Settings', 'manage_options', 'patterns', array( $this, 'Patterns_Settings') );
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
      array( $this, 'Patterns_Settings_Desc_Render'),
      'patterns_plugin_page'
    );

    // Slug Field
    add_settings_field(
      'patterns_cpt_slug',
      __( 'Patterns Slug', 'wordpress' ),
      array( $this, 'Patterns_CPT_Slug_Render'),
      'patterns_plugin_page',
      'patterns_patterns_plugin_page_section'
    );

    // Colors Display
    add_settings_field(
      'patterns_colors',
      __( 'Hide Colors', 'wordpress' ),
      array( $this, 'Patterns_Color_Display_Render'),
      'patterns_plugin_page',
      'patterns_patterns_plugin_page_section'
    );

    // Typography Display
    add_settings_field(
      'patterns_typography',
      __( 'Hide Typography', 'wordpress' ),
      array( $this, 'Patterns_Typeography_Option_Render'),
      'patterns_plugin_page',
      'patterns_patterns_plugin_page_section'
    );

    // Wrapper Class
    add_settings_field(
      'patterns_wrapper_class',
      __( 'Wrapper Class', 'wordpress' ),
      array( $this, 'Patterns_Wrapper_Class_Render'),
      'patterns_plugin_page',
      'patterns_patterns_plugin_page_section'
    );

    // Compiler Options
    add_settings_field(
      'patterns_compiler',
      __( 'CSS Compiler', 'wordpress' ),
      array( $this, 'Patterns_CSS_Compiler_Render'),
      'patterns_plugin_page',
      'patterns_patterns_plugin_page_section'
    );

  }


  /**
   * Description of Settings Page
   */
  public function Patterns_Settings_Desc_Render() {
    echo '<p>Settings for Patterns</p>';
  }


  /**
   * Create Textfield for Slug
   */
  public function Patterns_CPT_Slug_Render() {
    $slug = $this->_patterns_slug;
    if(!$slug) $slug = 'pattern-library';

    $html = '<input type="text" name="patterns_settings[patterns_cpt_slug]" value="' .  $slug . '">';
    $html .= '<p class="description">Base slug for Patterns archive.</p>';
    echo $html;
  }

  /**
   * Create Checkbox for Colors Display
   */
  public function Patterns_Color_Display_Render() {
    if ( ! isset( $this->_patterns_options['patterns_colors'] ) ) $this->_patterns_options['patterns_colors'] = 0;

    $html = '<input type="checkbox" name="patterns_settings[patterns_colors]" value="1"' . checked( 1, $this->_patterns_options['patterns_colors'], false ) . '/>';
    $html .= '<p class="description">Check if you wish not to display colors.</p>';
    echo $html;
  }

  /**
   * Create Checkbox for Typography Display
   */
  public function Patterns_Typeography_Option_Render() {
    if ( !isset( $this->_patterns_options['patterns_typography'] ) ) $this->_patterns_options['patterns_typography'] = 0;

    $html = '<input type="checkbox" name="patterns_settings[patterns_typography]" value="1"' . checked( 1, $this->_patterns_options['patterns_typography'], false ) . '/>';
    $html .= '<p class="description">Check if you wish not to display typography.</p>';
    echo $html;
  }

  /**
   * Create Textfield for Wrapper Class
   */
  public function Patterns_Wrapper_Class_Render() {
    if( !isset( $this->_patterns_options['patterns_wrapper_class'] ) ) {
      $wrapper = 'container';
    } else {
      $wrapper = $this->_patterns_options['patterns_wrapper_class'];
    }

    $html = '<input type="text" name="patterns_settings[patterns_wrapper_class]" value="' .  $wrapper . '">';
    $html .= '<p class="description">The class used to wrap main body content.</p>';
    echo $html;
  }


  /**
   * Create Select for CSS Compiler
   */
  public function Patterns_CSS_Compiler_Render() {
    $options = $this->_patterns_options;
    if( !isset( $options['patterns_compiler'] ) ) $options['patterns_compiler'] = 'css';



    $html = '<select name="patterns_settings[patterns_compiler]">';
      $html .= '<option value="sass"' . selected( $options['patterns_compiler'], 'sass', false) . '>sass</option>';
      $html .= '<option value="less"' . selected( $options['patterns_compiler'], 'less', false) . '>less</option>';
      $html .= '<option value="css"' . selected( $options['patterns_compiler'], 'css', false) . '>css</option>';
    $html .= '</select>';
    $html .= '<p class="description">Select a compiler for use in generating code for Colors.</p>';
    echo $html;
  }


  /**
   * Build the options page
   */
  public function Patterns_Settings() {
    $compiler_text = $this->Patterns_Style_Output();

    echo '<form action="options.php" method="post">';
      settings_fields( 'patterns_plugin_page' );
      do_settings_sections( 'patterns_plugin_page' );
      submit_button();
    echo '</form>';

    if($compiler_text) {
      echo $compiler_text;
    }

    // Flush them rules
    flush_rewrite_rules();
  }

  public function Patterns_Style_Output() {
    $values = array();
    $html = '';

    $args = array(
      'post_type' => 'patterns_colors',
      'posts_per_page' => -1,
      'orderby' => 'menu_order',
      'order' => 'ASC'
    );

    $colors = get_posts( $args );

    // Add Color Value to Values array
    if($colors) {
      $values = array();

      foreach($colors as $color) {
        $value = get_post_meta($color->ID, 'patterns_color_value', true);
        $class = str_replace('$', '', $value);  // sass vars
        $class = str_replace('@', '', $class);  // less vars
        $class = str_replace(' ', '-', $class); // make classy
        $values[$value] = $class;
      }

      $value_count = count($values);

      if( array_key_exists('patterns_compiler', $this->_patterns_options) ) {
        $compiler = $this->_patterns_options['patterns_compiler'];
      } else {
        $compiler = 'css';
      }

      // SASS
      if($compiler === 'sass') {
        $color_list = '';
        $vars_list = '';
        $sep = ', ';
        $step = 1;

        foreach($values as $value => $class) {
          if($step >= $value_count) $sep = '';
          $color_list .= '"' . $class . '"' . $sep;
          $vars_list .= '"' . $value . '"' . $sep;
          $step++;
        }

        $compiler_content = '$colors-list = ' . $color_list . ';' . "\n";
        $compiler_content .= '$vars-list = ' . $vars_list . ';' . "\n";
        $compiler_content .= "\n";
        $compiler_content .= '// Loop through lists to output classes with background color' . "\n";
        $compiler_content .= '@each $current-color in $colors-list {' . "\n";
        $compiler_content .= '  $i: index($colors-list, $current-color);' . "\n";
        $compiler_content .= '  .pattern-color-#{$current-color} {' . "\n";
        $compiler_content .= '    background: nth($vars-list, $i);' . "\n";
        $compiler_content .= '  }' . "\n";
        $compiler_content .= '}' . "\n";

      } else {
        $compiler_content = 'some stuff';
      }

      $html .= '<div class="wrap">';

        $html .= '<h4>Copy and Paste into your ' . $compiler . ' file</h4>';
        $html .= '<textarea rows="10" cols="30" class="large-text code">';
          $html .= $compiler_content;
        $html .= '</textarea>';

      $html .= '</div>';

    }

    return $html;
  }
}



