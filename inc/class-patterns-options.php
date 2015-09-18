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
    __( 'Pattern Library Slug', 'wordpress' ),
    'patterns_cpt_slug_render',
    'patterns_plugin_page',
    'patterns_patterns_plugin_page_section'
  );

  // Pattern Types
  add_settings_field(
    'patterns_types',
    __( 'Pattern Types', 'wordpress' ),
    'patterns_types_render',
    'patterns_plugin_page',
    'patterns_patterns_plugin_page_section'
  );


}


// Description
function patterns_settings_section_callback() {
  echo __( 'Basic Settings for Patterns', 'wordpress' );
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










function repeat_text_option_type( $option_name, $option, $values ){

    $counter = 0;

    $output = '<div class="of-repeat-loop">';

    if( is_array( $values ) ) foreach ( (array)$values as $value ){

        $output .= '<div class="of-repeat-group">';
        $output .= '<input class="of-input" name="' . esc_attr( $option_name . '[' . $option['id'] . ']['.$counter.']' ) . '" type="text" value="' . esc_attr( $value ) . '" />';
        $output .= '<button class="dodelete button icon delete">'. __('Remove') .'</button>';

        $output .= '</div><!–.of-repeat-group–>';

        $counter++;
    }

    $output .= '<div class="of-repeat-group to-copy">';
    $output .= '<input class="of-input" data-rel="' . esc_attr( $option_name . '[' . $option['id'] . ']' ) . '" type="text" value="' . esc_attr( $option['std'] ) . '" />';
    $output .= '<button class="dodelete button icon delete">'. __('Remove') .'</button>';
    $output .= '</div><!–.of-repeat-group–>';

    $output .= '<button class="docopy button icon add">Add</button>';

    $output .= '</div><!–.of-repeat-loop–>';

    return $output;


}






// Output the Types Textfields
function patterns_types_render() {


  ?>

  <input type='text' name='patterns_settings[patterns_types]' value='<?php echo $slug; ?>'>

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