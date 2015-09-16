<?php

/**
 * Fired during plugin activation
 *
 * @link       https://github.com/iamhexcoder
 * @since      1.0.0
 *
 * @package    Patterns
 * @subpackage Patterns/includes
 * @author     Shaun Baer <shaun.baer@gmail.com>
 */

/**
 * Creates the Patterns Custom Post Type and Taxonomy
 */

function patterns_slug() {
  $patterns_options     = get_option( 'patterns_settings' );
  $patterns_option_slug = $patterns_options['patterns_cpt_slug'];
  $patterns_slug        = $patterns_option_slug ? $patterns_option_slug : 'pattern-library';

  return $patterns_slug;
}

/**
 * Create the Main Patterns Custom Post Type
 */

add_action( 'init', 'patterns_primary_cpt' );

function patterns_primary_cpt() {
  $slug = patterns_slug();

  $args = array(
    'label'               => 'Pattern',
    'labels'              => array(
      'name'              => 'Patterns',
      'singular_name'     => 'Pattern'
    ),
    'supports'            => array( 'title' ),
    'taxonomies'          => array( 'pattern_type' ),
    'hierarchical'        => true,
    'public'              => true,
    'menu_position'       => 100,
    'menu_icon'           => 'dashicons-layout',
    'has_archive'         => true,
    'exclude_from_search' => true,
    'rewrite'             => array(
      'slug'              => $slug
    ),
    'capability_type'     => 'page',
  );

  register_post_type( 'patterns', $args );

}

/**
 *  Type Styles
 */

add_action( 'init', 'patterns_colors_cpt' );

function patterns_colors_cpt() {
  $slug = patterns_slug();

  $args = array(
    'label'               => 'Colors',
    'labels'              => array(
      'name'              => 'Colors',
      'singular_name'     => 'Color'
    ),
    'supports'            => array( 'title' ),
    'hierarchical'        => true,
    'public'              => true,
    'has_archive'         => true,
    'exclude_from_search' => true,
    'rewrite'             => array(
      'slug'              => $slug . '-colors'
    ),
    'capability_type'     => 'page',
    'show_in_menu'        => 'edit.php?post_type=patterns'
  );

  register_post_type( 'patterns_colors', $args );

}


/**
 *  Typography
 */
add_action( 'init', 'patterns_typography' );

function patterns_typography() {
  $slug = patterns_slug();

  $args = array(
    'label'               => 'Typography Styles',
    'labels'              => array(
      'name'              => 'Typography Styles',
      'singular_name'     => 'Typography Style'
    ),
    'supports'            => array( 'title' ),
    'hierarchical'        => true,
    'public'              => true,
    'has_archive'         => true,
    'exclude_from_search' => true,
    'rewrite'             => array(
      'slug'              => $slug . '-type-styles'
    ),
    'capability_type'     => 'page',
    'show_in_menu'        => 'edit.php?post_type=patterns'
  );

  register_post_type( 'patterns_typography', $args );

}


// add_action( 'init', 'patterns_type' );

// function patterns_type() {
//   $slug = patterns_slug();

//   $args = array(
//     'label'               => 'Pattern Types',
//     'labels'              => array(
//       'name'              => 'Pattern Types',
//       'singular_name'     => 'Pattern Type'
//     ),
//     'description'         => 'Classifications of Menu Types.'
//     'supports'            => array( 'title' ),
//     'hierarchical'        => true,
//     'public'              => true,
//     'has_archive'         => true,
//     'exclude_from_search' => true,
//     'rewrite'             => array(
//       'slug'              => $slug . '-types'
//     ),
//     'capability_type'     => 'page',
//     'show_in_menu'        => 'edit.php?post_type=patterns'
//   );

//   register_post_type( 'patterns_types', $args );

// }


// Hide 'Add New' for Patterns CPT
function patterns_hide_add_new() {
    global $submenu;
    unset($submenu['edit.php?post_type=patterns'][10]);
}
add_action('admin_menu', 'patterns_hide_add_new');


