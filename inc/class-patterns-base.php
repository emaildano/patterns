<?php

/**
 * Generates Admin Menu Items
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
   * Section: Custom Post Types
   * --------------------------------------------------------------------------
   * Author: Shaun M Baer
   * Last updated: October 5, 2015
   *
   */




  /**
   * Build basic args for Submenu Custom Post Types
   *
   * @param string $name     label name of CPT
   * @param string $singular singlular label name of CPT
   * @param string $slug     slug (prepended with patterns main CPT slug)
   */
  public function Patterns_CPT_Args($name, $singular, $slug) {
    $args = array(
      'label'               => $name,
      'labels'              => array(
        'name'              => $name,
        'singular_name'     => $singular
      ),
      'supports'            => array( 'title' ),
      'hierarchical'        => true,
      'public'              => true,
      'has_archive'         => true,
      'exclude_from_search' => true,
      'rewrite'             => array(
        'slug'              => $this->_patterns_slug . $slug
      ),
      'capability_type'     => 'page',
      'show_in_menu'        => 'edit.php?post_type=patterns'
    );

    return $args;
  }


  /* Create the Main Patterns Custom Post Type */
  public function Patterns_Primary_CPT() {

    $args = array(
      'label'               => 'Pattern',
      'labels'              => array(
        'name'              => 'Patterns',
        'singular_name'     => 'Pattern'
      ),
      'supports'            => array( 'title', 'page-attributes' ),
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

  /* Colors CPT */
  public function Patterns_Colors_CPT() {
    $args = $this->Patterns_CPT_Args('Colors', 'Color', '-colors');
    register_post_type( 'patterns_colors', $args );
  }


  /* Typography CPT */
  public function Patterns_Typography_CPT() {
    $args = $this->Patterns_CPT_Args('Typography Styles', 'Typography Style', '-type-styles');
    register_post_type( 'patterns_typography', $args );
  }


  /* Pattern Type Taxonomy */
  public function Patterns_Taxonomy() {

    $args = array(
      'labels'          => array(
        'name'          => 'Pattern Types',
        'singular_name' => 'Pattern Type'
      ),
      'hierarchical'    => true,
      'show_tagcloud'   => false,
    );

    register_taxonomy( 'pattern_type', array( 'patterns' ), $args );

  }



  /**
   * Hide 'Add New' for Patterns CPT submenu
   *
   * Makes the menu a little slimmer.
   *
   */
  public function Patterns_Hide_Add_New() {
    global $submenu;
    unset($submenu['edit.php?post_type=patterns'][10]);
  }




  /**
   * Section: Settings Page
   * --------------------------------------------------------------------------
   * Author: Shaun M Baer
   * Last updated: October 5, 2015
   *
   */


  /* Add Settings page to Patterns CPT menu item */
  public function Patterns_Add_Admin_Menu() {
    add_submenu_page( 'edit.php?post_type=patterns', 'Settings', 'Settings', 'manage_options', 'patterns', array( $this, 'Patterns_Settings') );
  }


  /**
   * Register settings
   */
  public function Patterns_Settings_Init() {

    $page = 'patterns_plugin_page';
    $slug_section = 'patterns_slug_section';
    $display_section = 'patterns_display_section';
    $settings_section = 'patterns_class_section';

    register_setting( 'patterns_plugin_page', 'patterns_settings' );

    /**
     * Sections
     */

    // Basic Section
    add_settings_section(
      $settings_section, __( 'Basic Settings', 'wordpress' ), array( $this, 'Patterns_HR_Render'), $page
    );

    // Display Section
    add_settings_section(
      $display_section, __( 'Display Options', 'wordpress' ), array( $this, 'Patterns_HR_Render'), $page
    );



    /**
     * Settings
     */

    // Slug Field
    add_settings_field(
      'patterns_cpt_slug',
      __( 'Patterns Slug', 'wordpress' ),
      array( $this, 'Patterns_CPT_Slug_Render'),
      $page, $settings_section
    );

    // Patterns Style Option
    add_settings_field(
      'patterns_style',
      __( 'Disable Patterns Styles', 'wordpress' ),
      array( $this, 'Patterns_Style_Option_Render'),
      $page, $settings_section
    );

    // Wrapper Class
    add_settings_field(
      'patterns_wrapper_class',
      'Wrapper Class',
      array( $this, 'Patterns_Wrapper_Class_Render'),
      $page, $settings_section
    );

    // Typography Sentence
    add_settings_field(
      'patterns_typography_phrase',
      __( 'Typography Phrase', 'wordpress' ),
      array( $this, 'Patterns_Typography_Phrase_Render'),
      $page, $settings_section
    );



    /**
     * Display
     */

    // Colors Display
    add_settings_field(
      'patterns_colors',
      __( 'Hide Colors', 'wordpress' ),
      array( $this, 'Patterns_Color_Display_Render'),
      $page, $display_section
    );

    // Typography Display
    add_settings_field(
      'patterns_typography',
      __( 'Hide Typography', 'wordpress' ),
      array( $this, 'Patterns_Typography_Option_Render'),
      $page, $display_section
    );

    // Compiler Options
    add_settings_field(
      'patterns_compiler',
      __( 'CSS Compiler', 'wordpress' ),
      array( $this, 'Patterns_CSS_Compiler_Render'),
      $page, $display_section
    );

  }


  /**
   * Render Settings
   */


    /* Settings Section Output */
    public function Patterns_HR_Render() {
      echo '<hr>';
    }

    /* Create Textfield for Slug */
    public function Patterns_CPT_Slug_Render() {
      $slug = $this->_patterns_slug;
      if(!$slug) $slug = 'pattern-library';

      $html = '<input type="text" name="patterns_settings[patterns_cpt_slug]" value="' .  $slug . '">';
      $html .= '<p class="description"> Base slug for Patterns archive.</p>';

      echo $html;
    }

    /* Create Checkbox for Colors Display */
    public function Patterns_Color_Display_Render() {
      if ( ! isset( $this->_patterns_options['patterns_colors'] ) ) $this->_patterns_options['patterns_colors'] = 0;

      $html = '<input type="checkbox" name="patterns_settings[patterns_colors]" value="1"' . checked( 1, $this->_patterns_options['patterns_colors'], false ) . '/>';
      $html .= '<p class="description"> Check if you wish not to display colors.</p>';
      echo $html;
    }

    /* Create Checkbox for Typography Display */
    public function Patterns_Typography_Option_Render() {
      if ( !isset( $this->_patterns_options['patterns_typography'] ) ) $this->_patterns_options['patterns_typography'] = 0;

      $html = '<input type="checkbox" name="patterns_settings[patterns_typography]" value="1"' . checked( 1, $this->_patterns_options['patterns_typography'], false ) . '/>';
      $html .= '<p class="description"> Check if you wish not to display typography.</p>';
      echo $html;
    }

    /* Create Textfield for Typography Phrase */
    public function Patterns_Typography_Phrase_Render() {
      if( !isset( $this->_patterns_options['patterns_typography_phrase'] ) ) {
        $phrase = 'This is a {{ tag }} tag with the {{ class }} class.';
      } else {
        $phrase = $this->_patterns_options['patterns_typography_phrase'];
      }

      $html = '<input type="text" name="patterns_settings[patterns_typography_phrase]" value="' .  $phrase . '" class="large-text" />';
      $html .= '<p class="description">This sentence will appear for each Typography entry.</p>';
      $html .= '<p>To display the class, use <code>{{ class }}</code>. To display the tag, use <code>{{ tag }}</code>.</p>';
      echo $html;
    }

    /* Create Textfield for Wrapper Class */
    public function Patterns_Wrapper_Class_Render() {
      if( !isset( $this->_patterns_options['patterns_wrapper_class'] ) ) {
        $wrapper = 'container';
      } else {
        $wrapper = $this->_patterns_options['patterns_wrapper_class'];
      }

      $html = '<input type="text" name="patterns_settings[patterns_wrapper_class]" value="' .  $wrapper . '">';
      $html .= '<p class="description"> The class used to wrap main body content.</p>';
      echo $html;
    }

    /* Disable Default Patterns Styles */
    public function Patterns_Style_Option_Render() {
      if ( !isset( $this->_patterns_options['patterns_styles'] ) ) $this->_patterns_options['patterns_styles'] = 0;

      $html = '<input type="checkbox" name="patterns_settings[patterns_style]" value="1"' . checked( 1, isset( $this->_patterns_options['patterns_style'] ), false ) . '/>';
      $html .= '<p class="description">Check to disable default styles.</p>';
      echo $html;
    }


    /* Create Select for CSS Compiler */
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

    echo '<div class="wrap">';
      echo '<h1>Pattern Library and Style Guide Settings</h1>';
      echo '<form action="options.php" method="post">';

        settings_fields( 'patterns_plugin_page' );
        do_settings_sections( 'patterns_plugin_page' );
        submit_button();

      echo '</form>';

      $compiler_text = $this->Patterns_Style_Output();
      if($compiler_text) {
        echo $compiler_text;
      }

    echo '</div>';

    // Flush them rules
    flush_rewrite_rules();
  }


  /**
   * Determine and generate the Compiler Output
   */
  public function Patterns_Style_Output() {

    // Get View Function Class
    require ( trailingslashit( dirname( __DIR__ ) ) . 'views/class-patterns-view-functions.php' );

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
      $compiler_content = '';
      $color_list = '';
      $vars_list = '';
      $sep = ', ';
      $step = 1;

      foreach($colors as $color) {
        $view = new Patterns__View_Funcs;
        $color_info = $view->Patterns__Colors_Class($color);
        $value = key($color_info);
        $values[$value] = $color_info[$value];
      }

      $value_count = count($values);

      if( array_key_exists('patterns_compiler', $this->_patterns_options) ) {
        $compiler = $this->_patterns_options['patterns_compiler'];
      } else {
        $compiler = 'css';
      }

      // Create parsable content based on compiler type
      if($compiler === 'sass') {

        // SASS
        foreach($values as $value => $class) {
          if($step >= $value_count) $sep = '';
          $color_list .= '"' . $class . '"' . $sep;
          $vars_list .= $value . $sep;
          $step++;
        }

        $compiler_content .= '$patterns--colors-list: ' . $color_list . ';' . "\n";
        $compiler_content .= '$patterns--vars-list: ' . $vars_list . ';' . "\n";
        $compiler_content .= "\n";
        $compiler_content .= '// Loop through lists to output classes with background color' . "\n";
        $compiler_content .= '@each $patterns--current-color in $patterns--colors-list {' . "\n";
        $compiler_content .= '  $i: index($patterns--colors-list, $patterns--current-color);' . "\n";
        $compiler_content .= '  .patterns--colors-#{$patterns--current-color} {' . "\n";
        $compiler_content .= '    background-color: nth($patterns--vars-list, $i);' . "\n";
        $compiler_content .= '  }' . "\n";
        $compiler_content .= '}' . "\n";

      } elseif($compiler === 'less') {

        // LESS CSS
        foreach($values as $value => $class) {
          if($step >= $value_count) $sep = '';
          $color_list .= $class . $sep;
          $step++;
        }

        $compiler_content .= '@patterns--colors: ' . $color_list . ';' . "\n";
        $compiler_content .= "\n";
        $compiler_content .= '.-(@i: length(@patterns--colors)) when (@i > 0) {' . "\n";
        $compiler_content .= '  @name: extract(@patterns--colors, @i);' . "\n";
        $compiler_content .= '    &.patterns--colors-@{name} {' . "\n";
        $compiler_content .= '      background-color: @@name;' . "\n";
        $compiler_content .= '    }' . "\n";
        $compiler_content .= '  .-((@i - 1));' . "\n";
        $compiler_content .= '} .-;' . "\n";

      } else {

        // Basic CSS
        $sep = "\n";

        foreach($values as $value => $class) {
          if($step >= $value_count) $sep = '';
          $step++;

          $compiler_content .= '.patterns--colors-' . $class . ' {' . "\n";
          $compiler_content .= '  background-color: ' . $value . ';' . "\n";
          $compiler_content .= '}' . "\n";
          $compiler_content .= $sep;
        }
      }

      $html .= '<div class="wrap">';
        $html .= '<h2>Compiler Output for Colors</h2><hr>';
        $html .= '<p><strong>Copy and Paste into your ' . $compiler . ' file</strong></p>';
        $html .= '<textarea rows="10" cols="30" class="large-text code">';
          $html .= $compiler_content;
        $html .= '</textarea>';

      $html .= '</div>';

    }

    return $html;
  }
}



