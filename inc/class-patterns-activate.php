<?php

class Patterns__Activate {

  public function __constuct() {
    // Add default terms
    add_action( 'init', array( $this, 'Pattners_Default_Terms' ) );
    add_action('init', array( $this, 'Patterns_Flush_Rewrite' ) );
  }


  /**
   * Create some default terms for the Patterns taxonomy.
   */
  public function Pattners_Default_Terms() {
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


  public function Patterns_Flush_Rewrite() {
      flush_rewrite_rules();
  }

}


