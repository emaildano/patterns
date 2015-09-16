<?php

/**
 * Create the Patterns Taxonomy
 */
add_action( 'init', 'patterns_taxonomy' );

function patterns_taxonomy() {

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
