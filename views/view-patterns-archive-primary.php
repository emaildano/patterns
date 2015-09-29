<?php
global $posts;
global $post;

if( have_posts() ) :

  // View Function Class
  require ( trailingslashit( dirname( __FILE__ ) ) . 'view-patterns-view-functions.php' );

  $view = new Patterns__View_Funcs;
  $posts_ordered = $view->Patterns__Post_Sort( $posts );

  /**
   * Break apart the ordered post to make life easier
   * @var null  if key exists, @var is array
   */
  $color_posts      = null;
  $typography_posts = null;
  $pattern_posts    = null;

  if( $posts_ordered['patterns_colors'] )
    $color_posts = $posts_ordered['patterns_colors'];
  if( $posts_ordered['patterns_typography'] )
    $typography_posts = $posts_ordered['patterns_typography'];
  if( $posts_ordered['patterns'] )
    $pattern_posts = $posts_ordered['patterns'];


  /**
   * Build the navigation
   */
  echo '<nav class="patterns--nav">';
    if($color_posts)
      echo '<a href="#patterns-colors">Colors</a>';

    if($typography_posts)
      echo '<a href="#patterns-typography">Typography</a>';

    /**
     * Build Patterns nav based on patterns array keys.
     */
    if($pattern_posts) {
      $pattern_els = '';

      foreach($pattern_posts as $pattern_name=>$obj) {
        $type_id = urlencode($pattern_name);
        $nav_el = '<a href="#patterns-'. strtolower($type_id) . '">' . $pattern_name . '</a>';

        // If Basic Patterns exist, move to the top of the heap.
        if($pattern_name === 'Basic Patterns') {
          $pattern_els = $nav_el . $pattern_els;
        } else {
          $pattern_els .= $nav_el;
        }
      }

      echo $pattern_els;
    }
  echo '</nav>';


  /*


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
  */

endif;