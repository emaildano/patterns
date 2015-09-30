<?php
get_header();

global $posts;
global $post;

if( have_posts() ) :
  echo '<div class="patterns--wrapper">';

  // View Function Class
  require ( trailingslashit( dirname( __FILE__ ) ) . 'class-patterns-view-functions.php' );

  $view = new Patterns__View_Funcs;
  $posts_ordered = $view->Patterns__Post_Sort( $posts );

  /**
   * Break apart the ordered post to make life easier
   * @var null  if key exists, @var is array
   */
  $color_posts      = null;
  $typography_posts = null;
  $pattern_posts    = null;

  if( array_key_exists('patterns_colors', $posts_ordered ) )
    $color_posts = $posts_ordered['patterns_colors'];
  if( array_key_exists('patterns_typography', $posts_ordered ) )
    $typography_posts = $posts_ordered['patterns_typography'];
  if( $posts_ordered['patterns'] )
    $pattern_posts = $posts_ordered['patterns'];



  /**
   * Build the navigation
   */
  echo '<nav class="patterns--nav">';
    $active = true;
    $class = 'patterns--nav-link';

    if($color_posts) {
      if($active === true) {
        $class .= ' patterns--active';
      }
      echo '<a href="#patterns-colors" class="' . $class . '">Colors</a>';

      $active = false;
      $class = 'patterns--nav-link';
    }

    if($typography_posts) {
      if($active === true) {
        $class .= ' patterns--active';
      }
      echo '<a href="#patterns-typography" class="' . $class . '">Typography</a>';

      $active = false;
      $class = 'patterns--nav-link';
    }

    /**
     * Build Patterns nav based on patterns array keys.
     */
    if($pattern_posts) {
      $pattern_els = '';

      foreach($pattern_posts as $pattern_name=>$obj) {
        if($active === true) {
          $class .= ' patterns--active';
        }
        $active = false;
        $type_id = str_replace(' ', '-', $pattern_name);
        preg_match('/^[a-z0-9 .\-]+$/i', $type_id);
        $nav_el = '<a href="#patterns-'. strtolower($type_id) . '" class="' . $class . '">' . $pattern_name . '</a>';

        $active = false;
        $class = 'patterns--nav-link';

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


  echo '<div class="patterns--section-wrapper">';
    // Colors
    if($color_posts) {
      echo '<section id="patterns-colors" class="patterns--type-section">';
        include_once( trailingslashit( dirname( __FILE__ ) ) . 'view-patterns-colors.php' );
        wp_reset_postdata();
      echo '</section>';
    }






    // Typography
    if($typography_posts) {
      echo '<section id="patterns-typography" class="patterns--type-section">';
        include_once( trailingslashit( dirname( __FILE__ ) ) . 'view-patterns-typography.php' );
        wp_reset_postdata();
      echo '</section>';
    }




    // Pattern Types
    if($pattern_posts) {
      $count = 1;

      foreach($pattern_posts as $key=>$patterns) {
        $type_id = str_replace(' ', '-', $key);
        preg_match('/^[a-z0-9 .\-]+$/i', $type_id);
        echo '<section id="patterns-'. strtolower($type_id) . '" class="patterns--type-section">';

          foreach($patterns as $post) {
            setup_postdata( $post );

            $pattern = $view->Patterns__Post_Main( $post );
            $code   = $pattern['code'];
            $desc   = $pattern['desc'];

            ?>

            <section class="patterns--entry">
              <h2 class="patterns--entry-title"><?= get_the_title() ?></h2>

              <?php if($code) : ?>

                <!-- Start Code Output -->
                <div class="patterns--pattern-display">
                  <?= $pattern['code_display'] ?>
                </div>
                <!-- End Code Output -->

                <div class="patterns--toggle-wrapper">
                  <a class="patterns--js-code-toggle" data-target="#patterns--code-info-<?= $count ?>" href="#">View Code</a>
                </div>

                <!-- Start Code Info -->
                <div id="patterns--code-info-<?= $count ?>" class="patterns--code-info">

                  <?php
                    $class = 'patterns--code-info--code';
                    if(!$desc) $class .= ' patterns--no-desc';
                  ?>

                  <div class="<?= $class ?>">
                    <pre><code class="language-markup"><?= $pattern['code_raw'] ?></code></pre>
                  </div>

                  <?php if($desc) : ?>
                    <div class="patterns--code-info--desc">
                      <h4>Description</h4>
                      <p><?= $pattern['desc_content'] ?></p>
                    </div>
                  <?php endif; ?>

                </div>
                <!-- End Code Info -->

              <?php endif; ?>

            </section>

            <?php
            $count++;
          }
          wp_reset_postdata();

        echo '</section>';
      }
    }
  echo '</div>'; // Entry Wrapper

  echo '</div>'; // Patterns Wrapper
endif;

get_footer();