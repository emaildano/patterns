<?php

  $typography_types = array();

  foreach($typography_posts as $post) {
    setup_postdata( $post );
    $meta = get_post_meta($post->ID);

    if( !empty($meta['_Patterns__Typography_tag'][0]) )
      $type = $meta['_Patterns__Typography_tag'][0];

    if($type) {
      if(!in_array($type, $typography_types))
        $typography_types[] = $type;
    }

    // Print Some Stuff!!
    echo '<pre>'; print_r($meta); echo '</pre>';
  }

  echo '<pre>'; print_r($typography_types); echo '</pre>';

