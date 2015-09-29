<?php
global $posts;
global $post;

if( have_posts() ) :

  // View Function Class
  require ( trailingslashit( dirname( __FILE__ ) ) . 'view-patterns-view-functions.php' );

  // Vars
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

        if(!in_array($type_name, $pattern_types)) {
          $pattern_types[] = $type_name;
        }

        // Sort
        unset($pattern_posts[$key]); // remove pattern from list
        $pattern_posts[$type_name][] = $pattern;

      }
    } else {
      unset($pattern_posts[$key]); // remove pattern from list
      $pattern_posts['Basic Patterns'][] = $pattern;
      if( !in_array('Basic Patterns', $pattern_types) ) {
        $pattern_types[] = 'Basic Patterns';
      }
    }

  }





  // Build the filter
  echo '<ul class="patterns-tab-bar">';
    if($color_posts) echo '<li><a href="#patterns-colors">Colors</a></li>';
    if($typography_posts) echo '<li><a href="#patterns-typography">Typeography</a></li>';
    if($pattern_types) {
      foreach($pattern_types as $pattern_type) {
        $type_id = urlencode($pattern_type);
        echo '<li><a href="#patterns-'. strtolower($type_id) . '">' . $pattern_type . '</a></li>';
      }
    }
  echo '</ul>';





  // Colors
  if($color_posts) {
    Patterns__View_Functions::Patterns_Archive_Part('Colors', $color_posts);
  }

  // Typeography
  if($typography_posts) {
    Patterns__View_Functions::Patterns_Archive_Part('Typography', $typography_posts);
  }


  // Pattern Types
  if($pattern_types) {

    // Print Some Stuff!!
    echo '<pre>'; print_r($pattern_types); echo '</pre>';

    foreach($pattern_types as $pattern_type) {
      $type_id = urlencode($pattern_type);
      echo '<section id="patterns-'. strtolower($type_id) . '" class="patterns-type-section">';
        echo '<h1>' . $pattern_type . '</h1>';

        foreach($pattern_posts[$pattern_type] as $post) {
          setup_postdata( $post );

          echo '<p>' . get_the_title() . '</p>';
        }
        wp_reset_postdata();

      echo '</section>';
    }
  }

endif;