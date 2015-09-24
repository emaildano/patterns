<?php
global $posts;

if( have_posts() ) :


  $pattern_posts    = array();
  $color_posts      = array();
  $typography_posts = array();
  $pattern_types    = array();

  // Sort by Post Type
  foreach($posts as $entry) {
    $type = $entry->post_type;

    if( $entry->post_type === 'patterns_colors' ) {
      $color_posts[] = $entry;
    } elseif( $entry->post_type === 'patterns_typography' ) {
      $typography_posts[] = $entry;
    } else {
      $pattern_posts[] = $entry;
    }
  }

  // Sort Patterns by Type
  foreach($pattern_posts as $key=>$pattern) {
    // $obj = $pattern;
    $types = get_the_terms( $pattern->ID, 'pattern_type' );

    if($types) {
      foreach($types as $type) {
        $type_name = $type->name;
        unset($pattern_posts[$key]); // remove pattern from list
        $pattern_posts[$type_name][] = $pattern;
      }
    } else {
      unset($pattern_posts[$key]); // remove pattern from list
      $pattern_posts['Patterns'][] = $pattern;
    }

  // Print Some Stuff!!
  echo '<pre>'; print_r($pattern_posts); echo '</pre>';


  while( have_posts() ) : the_post();

    echo '<p><a href="' . get_permalink() . '">' . get_the_title() . '</a></p>';

  endwhile;
endif;