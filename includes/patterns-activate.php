<?php

// Add default terms
add_action( 'init', 'patterns_default_terms' );

function patterns_default_terms() {
  $taxonomy = 'pattern_type';
  $terms = array (
      '0' => array (
          'name'          => 'Modules',
          'slug'          => 'modules',
          'description'   => 'Module patterns',
      ),
      '1' => array (
          'name'          => 'Elements',
          'slug'          => 'elements',
          'description'   => 'Elemental Patterns such as forms, tables, etc.',
      ),
  );

  foreach ( $terms as $key=>$term) {
    wp_insert_term(
        $term['name'],
        $taxonomy,
        array(
            'description'   => $term['description'],
            'slug'          => $term['slug'],
        )
    );
    unset( $term );
  }
}

add_action('init', 'patterns_flush_rewrite');
function patterns_flush_rewrite() {
    flush_rewrite_rules();
}