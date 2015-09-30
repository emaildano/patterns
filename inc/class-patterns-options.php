<?php

/**
 * Plugin Options
 */


add_action( 'admin_menu', 'patterns_add_admin_menu' );
add_action( 'admin_init', 'patterns_settings_init' );

// Assign the options
function patterns_add_admin_menu() {
  add_submenu_page( 'edit.php?post_type=patterns', 'Settings', 'Settings', 'manage_options', 'patterns', 'patterns_options_page' );
}


// Initialize the Plugin Settings
function patterns_settings_init() {

  register_setting( 'patterns_plugin_page', 'patterns_settings' );

  // Basic Description Section
  add_settings_section(
    'patterns_patterns_plugin_page_section',
    __( 'Patterns Settings', 'wordpress' ),
    'patterns_settings_section_callback',
    'patterns_plugin_page'
  );

  // Slug Field
  add_settings_field(
    'patterns_cpt_slug',
    __( 'Patterns Slug', 'wordpress' ),
    'patterns_cpt_slug_render',
    'patterns_plugin_page',
    'patterns_patterns_plugin_page_section'
  );

  // Compiler Options
  add_settings_field(
    'patterns_compiler_type',
    __( 'CSS Compiler', 'wordpress' ),
    'patterns_css_compiler_render',
    'patterns_plugin_page',
    'patterns_patterns_plugin_page_section'
  );

  // Colors Display
  add_settings_field(
    'patterns_colors_display',
    __( 'Display Colors', 'wordpress' ),
    'patterns_colors_display_render',
    'patterns_plugin_page',
    'patterns_patterns_plugin_page_section'
  );

  // Typography Display
  add_settings_field(
    'patterns_typography_display',
    __( 'Display Typeography', 'wordpress' ),
    'patterns_typography_display_render',
    'patterns_plugin_page',
    'patterns_patterns_plugin_page_section'
  );

  // Wrapper Class
  add_settings_field(
    'patterns_wrapper_class',
    __( 'Wrapper Class', 'wordpress' ),
    'patterns_wrapper_class_render',
    'patterns_plugin_page',
    'patterns_patterns_plugin_page_section'
  );
}


// Description
function patterns_settings_section_callback() {
  // echo '<p>Basic Settings for Patterns</p>';
}

// Output the Slug Textfield
function patterns_cpt_slug_render() {
  $options = get_option( 'patterns_settings' );
  $slug = $options['patterns_cpt_slug'];
  if(!$slug) $slug = 'pattern-library';
  ?>
  <input type='text' name='patterns_settings[patterns_cpt_slug]' value='<?php echo $slug; ?>'>
  <?php
}



// Make it Clap
function patterns_options_page() {
  ?>
  <form action='options.php' method='post'>
    <?php
    settings_fields( 'patterns_plugin_page' );
    do_settings_sections( 'patterns_plugin_page' );
    submit_button();
    ?>
  </form>
  <?php
  // Flush them rules
  flush_rewrite_rules();
}