<?php

class Patterns__Meta_Boxes {

  public function __construct() {
    // Patterns
    add_action( 'add_meta_boxes', array( $this, 'Patterns_Main_Meta_Box' ) );
    add_action( 'save_post', array( $this, 'Patterns_Main_Meta_Box_Save' ) );

    // Colors
    add_action( 'add_meta_boxes', array( $this, 'Patterns_Colors_Meta_Box' ) );
    add_action( 'save_post', array( $this, 'Patterns_Colors_Meta_Box_Save' ) );

    // Typography
    add_action( 'add_meta_boxes', array( $this, 'Patterns_Typography_Meta_Box' ) );
    add_action( 'save_post', array( $this, 'Patterns_Typography_Meta_Box_Save' ) );
  }



  /**
   * PATTERNS MAIN
   */
  public function Patterns_Main_Meta_Box( $post_type ) {
    $post_types = array('patterns');     // limit meta box to certain post types
    if ( in_array( $post_type, $post_types )) {
      add_meta_box(
        'Patterns_CPT_MetaBox',
        'Patterns Code Input',
        array( $this, 'Patterns_Render_Meta_Box_Main' ),
        $post_type,
        'normal',
        'default'
      );
    }
  }


  /**
   * Save the meta when the post is saved.
   *
   * @param int $post_id The ID of the post being saved.
   */
  public function Patterns_Main_Meta_Box_Save( $post_id ) {

    /*
     * We need to verify this came from the our screen and with proper authorization,
     * because save_post can be triggered at other times.
     */

    // Check if our nonce is set.
    if ( ! isset( $_POST['patterns_main_inner_custom_box_nonce'] ) )
      return $post_id;

    $nonce = $_POST['patterns_main_inner_custom_box_nonce'];

    // Verify that the nonce is valid.
    if ( ! wp_verify_nonce( $nonce, 'patterns_main_inner_custom_box' ) )
      return $post_id;

    // If this is an autosave, our form has not been submitted,
                //     so we don't want to do anything.
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
      return $post_id;

    // Check the user's permissions.
    if ( !current_user_can( 'edit_post', $post_id ) )
      return $post_id;

    /* OK, its safe for us to save the data now. */

    // Sanitize the user input.
    $code_data  = esc_html( $_POST['patterns_code_content'] );
    $desc_data  = esc_textarea( $_POST['patterns_code_desc'] );
    $wrapper = isset( $_POST[ 'patterns_wrapper' ] ) ? 'use' : 'hide';

    // Update the meta field.
    update_post_meta( $post_id, '_Patterns__Main_code_value', $code_data );
    update_post_meta( $post_id, '_Patterns__Main_desc_value', $desc_data );
    update_post_meta( $post_id, '_Patterns__Main_wrapper', $wrapper );

  }


  /**
   * Render Meta Box content.
   *
   * @param WP_Post $post The post object.
   */
  public function Patterns_Render_Meta_Box_Main( $post ) {
    global $pagenow;

    // Add an nonce field so we can check for it later.
    wp_nonce_field( 'patterns_main_inner_custom_box', 'patterns_main_inner_custom_box_nonce' );

    // Use get_post_meta to retrieve an existing value from the database.
    $code_value = get_post_meta( $post->ID, '_Patterns__Main_code_value', true );
    $desc_value = get_post_meta( $post->ID, '_Patterns__Main_desc_value', true );
    $wrapper    = get_post_meta( $post->ID, '_Patterns__Main_wrapper', true );

    // Determine checked value
    if ( $wrapper )
      $checked = checked( $wrapper, 'use', false );

    // Set the default value to checked on new posts
    if ( 'post-new.php' == $pagenow )
      $checked = ' checked';

    // Display the form, using the current value.
    echo '<table class="form-table"><tbody>';
      echo '<tr>';
        echo '<th scope="row"><label for="patterns_wrapper">Use Container</label></th>';
        echo '<td>';
          echo '<input id="patterns_wrapper" type="checkbox" name="patterns_wrapper" value="1"' . $checked . ' />';
          echo '<p class="description">Code should only contain HTML, no php!</p>';
        echo '</td>';

      echo '</tr>';

      echo '<tr>';
        echo '<th scope="row"><label for="patterns_code_content">Raw Code</label></th>';
        echo '<td>';
          echo '<textarea id="patterns_code_content" class="large-text code" name="patterns_code_content"';
          echo ' rows="10">' . esc_html($code_value) . '</textarea>';
          echo '<p class="description">Code should only contain HTML, no php!</p>';
        echo '</td>';

      echo '</tr>';

      echo '<tr>';
        echo '<th scope="row">Description</th>';
        echo '<td>';
          echo '<textarea id="patterns_code_desc" class="large-text" name="patterns_code_desc"';
          echo ' rows="10">' . $desc_value . '</textarea>';
        echo '</td>';
    echo '</tbody></table>';
  }






  /**
   * COLORS
   */
  public function Patterns_Colors_Meta_Box( $post_type ) {
    $post_types = array('patterns_colors');     // limit meta box to certain post types
    if ( in_array( $post_type, $post_types )) {
      add_meta_box(
        'Patterns_Colors_CPT_Meta_Box',
        'Patterns Colors',
        array( $this, 'Patterns_Render_Meta_Box_Colors' ),
        $post_type,
        'normal',
        'default'
      );
    }
  }


  /**
   * Save the meta when the post is saved.
   *
   * @param int $post_id The ID of the post being saved.
   */
  public function Patterns_Colors_Meta_Box_Save( $post_id ) {

    /*
     * We need to verify this came from the our screen and with proper authorization,
     * because save_post can be triggered at other times.
     */

    // Check if our nonce is set.
    if ( ! isset( $_POST['patterns_colors_inner_custom_box_nonce'] ) )
      return $post_id;

    $nonce = $_POST['patterns_colors_inner_custom_box_nonce'];

    // Verify that the nonce is valid.
    if ( ! wp_verify_nonce( $nonce, 'patterns_colors_inner_custom_box' ) )
      return $post_id;

    // If this is an autosave, our form has not been submitted,
                //     so we don't want to do anything.
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
      return $post_id;

    // Check the user's permissions.
    if ( !current_user_can( 'edit_post', $post_id ) )
      return $post_id;

    /* OK, its safe for us to save the data now. */

    // Sanitize the user input.
    $color_value  = sanitize_text_field( $_POST['patterns_color_value'] );

    // Update the meta field.
    update_post_meta( $post_id, 'patterns_color_value', $color_value );
  }


  /**
   * Render Meta Box content.
   *
   * @param WP_Post $post The post object.
   */
  public function Patterns_Render_Meta_Box_Colors( $post ) {

    // Add an nonce field so we can check for it later.
    wp_nonce_field( 'patterns_colors_inner_custom_box', 'patterns_colors_inner_custom_box_nonce' );

    // Use get_post_meta to retrieve an existing value from the database.
    $color_value = get_post_meta( $post->ID, 'patterns_color_value', true );

    // Display the form, using the current value.
    echo '<label for="patterns_color_value">Pattern Color Value</label> ';
    echo '<input id="patterns_color_value" value="' . esc_attr($color_value) . '" name="patterns_color_value" />';
  }




  /**
   * TYPOGRAPHY
   */
  public function Patterns_Typography_Meta_Box( $post_type ) {
    $post_types = array('patterns_typography');     // limit meta box to certain post types
    if ( in_array( $post_type, $post_types )) {
      add_meta_box(
        'Patterns_Typography_CPT_Meta_Box',
        'Patterns Type Styles',
        array( $this, 'Patterns_Render_Meta_Box_Typography' ),
        $post_type,
        'normal',
        'default'
      );
    }
  }


  /**
   * Save the meta when the post is saved.
   *
   * @param int $post_id The ID of the post being saved.
   */
  public function Patterns_Typography_Meta_Box_Save( $post_id ) {

    /*
     * We need to verify this came from the our screen and with proper authorization,
     * because save_post can be triggered at other times.
     */

    // Check if our nonce is set.
    if ( ! isset( $_POST['patterns_typography_inner_custom_box_nonce'] ) )
      return $post_id;

    $nonce = $_POST['patterns_typography_inner_custom_box_nonce'];

    // Verify that the nonce is valid.
    if ( ! wp_verify_nonce( $nonce, 'patterns_typography_inner_custom_box' ) )
      return $post_id;

    // If this is an autosave, our form has not been submitted,
                //     so we don't want to do anything.
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
      return $post_id;

    // Check the user's permissions.
    if ( !current_user_can( 'edit_post', $post_id ) )
      return $post_id;

    /* OK, its safe for us to save the data now. */

    // Sanitize the user input.
    $type_class = sanitize_text_field( $_POST['patterns_typography_class_value'] );
    $type_tag   = sanitize_key( $_POST['patterns_typography_tag_value'] );

    // Update the meta field.
    update_post_meta( $post_id, '_Patterns__Typography_class', $type_class );
    update_post_meta( $post_id, '_Patterns__Typography_tag', $type_tag );
  }


  /**
   * Render Meta Box content.
   *
   * @param WP_Post $post The post object.
   */
  public function Patterns_Render_Meta_Box_Typography( $post ) {

    // Add an nonce field so we can check for it later.
    wp_nonce_field( 'patterns_typography_inner_custom_box', 'patterns_typography_inner_custom_box_nonce' );

    // Use get_post_meta to retrieve an existing value from the database.
    $class_value = get_post_meta( $post->ID, '_Patterns__Typography_class', true );
    $tag_value = get_post_meta( $post->ID, '_Patterns__Typography_tag', true );
    $patterns_tag_options = array( 'p', 'h1', 'h2', 'h3', 'h4', 'h5', 'h6', 'span' );

    echo '<table class="form-table"><tbody>';
      echo '<tr>';
        echo '<th scope="row"><label for="patterns_typography_class_value">Typographic Class</label></th>';
        echo '<td>';
          echo '<input id="patterns_typography_class_value" value="' . esc_attr($class_value) . '" name="patterns_typography_class_value" class="all-options"/>';
        echo '</td>';
      echo '</tr>';

      echo '<tr>';
        echo '<th scope="row"><label for="patterns_typography_tag_value">Entity Tag</label></th>';
        echo '<td>';
          echo '<select name="patterns_typography_tag_value" id="patterns_typography_tag_value">';

            foreach($patterns_tag_options as $option) {
              echo '<option value="' . $option . '"';
              if ( isset ( $tag_value ) ) selected( $tag_value, $option );
              echo '>' . $option . '</option>';
            }
          echo '</select>';

        echo '</td>';
      echo '</tr>';
    echo '</tbody></table>';
  }

}