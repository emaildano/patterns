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
    if($typography_posts) echo '<li><a href="#patterns-typography">Typography</a></li>';
    if($pattern_types) {
      foreach($pattern_types as $pattern_type) {
        $type_id = urlencode($pattern_type);
        echo '<li><a href="#patterns-'. strtolower($type_id) . '">' . $pattern_type . '</a></li>';
      }
    }
  echo '</ul>';





  // Colors
  if($color_posts) {
    $html = '<section id="patterns-colors" class="patterns-type-section">';
      $html .= '<h1>Colors</h1>';

      foreach($color_posts as $post) {

        setup_postdata( $post );
        $meta = get_post_meta($post->ID);

        // Print Some Stuff!!
        echo '<pre>'; print_r($meta); echo '</pre>';

        $html .= '<p>' . get_the_title() . '</p>';
      }

    $html .= '</section>';

    wp_reset_postdata();

    echo $html;
  }






  // Typeography
  if($typography_posts) {
    $html = '<section id="patterns-typography" class="patterns-type-section">';
      $html .= '<h1>Typography</h1>';

      foreach($typography_posts as $post) {

        setup_postdata( $post );
        $meta = get_post_meta($post->ID);

        // Print Some Stuff!!
        echo '<pre>'; print_r($meta); echo '</pre>';

        $html .= '<p>' . get_the_title() . '</p>';
      }

    $html .= '</section>';

    wp_reset_postdata();

    echo $html;
  }




  // Pattern Types
  if($pattern_types) {

    foreach($pattern_types as $pattern_type) {
      $type_id = urlencode($pattern_type);
      echo '<section id="patterns-'. strtolower($type_id) . '" class="patterns-type-section">';
        echo '<h1>' . $pattern_type . '</h1>';

        foreach($pattern_posts[$pattern_type] as $post) {
          setup_postdata( $post );
          $meta   = get_post_meta($post->ID);
          $code   = null;
          $desc   = null;


          if( array_key_exists( '_Patterns__Main_code_value', $meta ) )
            $code = $meta['_Patterns__Main_code_value'][0];

          if( array_key_exists( '_Patterns__Main_desc_value', $meta ) )
            $desc = $meta['_Patterns__Main_desc_value'][0];

          ?>

          <section class="patterns--entry">
            <p><?= get_the_title() ?></p>

            <?php if($code) : ?>

              <!-- Start Code Output -->
              <div class="patterns--pattern-display">
                <?= html_entity_decode($code) ?>
              </div>
              <!-- End Code Output -->


              <!-- Start Code Info -->
              <div class="patterns--code-info">

                <div class="patterns--code-info--code">
                  <pre><code><?= $code ?></code></pre>
                </div>

                <?php if($desc) : ?>
                  <div class="patterns--code-info--desc">
                    <h4>Description</h4>
                    <p><?= nl2br($desc) ?></p>
                  </div>
                <?php endif; ?>

              </div>
              <!-- End Code Info -->

            <?php endif; ?>

          </section>



          <?php
        }
        wp_reset_postdata();

      echo '</section>';
    }
  }

endif;