<?php

/**
 * Options Page for plugin
 */


add_action( 'admin_menu', 'patterns_add_admin_menu' );
add_action( 'admin_init', 'patterns_settings_init' );

// Assign the options
function patterns_add_admin_menu(  ) {
  add_submenu_page( 'tools.php', 'Patterns', 'Patterns', 'manage_options', 'patterns', 'patterns_options_page' );
}


function patterns_settings_init(  ) {

  register_setting( 'pluginPage', 'patterns_settings' );

  add_settings_section(
    'patterns_pluginPage_section',
    __( 'Patterns Settings', 'wordpress' ),
    'patterns_settings_section_callback',
    'pluginPage'
  );

  add_settings_field(
    'patterns_cpt_slug',
    __( 'Pattern Library Slug', 'wordpress' ),
    'patterns_cpt_slug_render',
    'pluginPage',
    'patterns_pluginPage_section'
  );
}

function patterns_cpt_slug_render(  ) {
  $options = get_option( 'patterns_settings' );
  $slug = $options['patterns_cpt_slug'];
  if(!$slug) $slug = 'pattern-library';
  ?>
  <input type='text' name='patterns_settings[patterns_cpt_slug]' value='<?php echo $slug; ?>'>
  <?php
}



function patterns_settings_section_callback(  ) {
  echo __( 'Basic Settings for Patterns', 'wordpress' );
}

function patterns_options_page(  ) {
  ?>
  <form action='options.php' method='post'>
    <?php
    settings_fields( 'pluginPage' );
    do_settings_sections( 'pluginPage' );
    submit_button();
    ?>
  </form>
  <?php
}