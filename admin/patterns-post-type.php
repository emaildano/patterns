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



/**
 * Create the Patterns Custom Post Type
 */

add_action( 'init', 'patterns_cpt' );

function patterns_cpt() {
  $options      = get_option( 'patterns_settings' );
  $option_slug  = $options['patterns_cpt_slug'];
  $slug = $option_slug ? $option_slug : 'pattern-library';


  $labels = array(
    'name'                => 'Patterns',
    'singular_name'       => 'Pattern',
    'menu_name'           => 'Patterns',
    'name_admin_bar'      => 'Patterns',
    'parent_item_colon'   => 'Parent Pattern:',
    'all_items'           => 'All Patterns',
    'add_new_item'        => 'Add New Pattern',
    'add_new'             => 'Add Pattern',
    'new_item'            => 'New Pattern',
    'edit_item'           => 'Edit Pattern',
    'update_item'         => 'Update Pattern',
    'view_item'           => 'View Pattern',
    'search_items'        => 'Search Pattern',
    'not_found'           => 'Not found',
    'not_found_in_trash'  => 'Not found in Trash',
  );

  $rewrite = array(
    'slug'                => $slug,
    'with_front'          => true,
    'pages'               => true,
    'feeds'               => true,
  );

  $args = array(
    'label'               => 'Pattern',
    'description'         => 'Patterns and Styles',
    'labels'              => $labels,
    'supports'            => array( ),
    'taxonomies'          => array( 'pattern_type' ),
    'hierarchical'        => true,
    'public'              => true,
    'show_ui'             => true,
    'show_in_menu'        => true,
    'menu_position'       => 5,
    'menu_icon'           => 'dashicons-layout',
    'show_in_admin_bar'   => true,
    'show_in_nav_menus'   => true,
    'can_export'          => true,
    'has_archive'         => true,
    'exclude_from_search' => true,
    'publicly_queryable'  => true,
    'rewrite'             => $rewrite,
    'capability_type'     => 'page',
    );
  register_post_type( 'patterns', $args );

}





/**
 * Create the Patterns Taxonomy
 */
add_action( 'init', 'patterns_taxonomy' );

function patterns_taxonomy() {

  $labels = array(
    'name'                       => 'Pattern Types',
    'singular_name'              => 'Pattern Type',
    'menu_name'                  => 'Pattern Types',
    'all_items'                  => 'All Pattern Types',
    'parent_item'                => 'Parent Pattern Types',
    'parent_item_colon'          => 'Parent Pattern Type:',
    'new_item_name'              => 'New Pattern Type',
    'add_new_item'               => 'Add New Pattern Type',
    'edit_item'                  => 'Edit Pattern Type',
    'update_item'                => 'Update Pattern Type',
    'view_item'                  => 'View Pattern Type',
    'separate_items_with_commas' => 'Separate Pattern Types with commas',
    'add_or_remove_items'        => 'Add or remove Pattern Types',
    'choose_from_most_used'      => 'Choose from the most used',
    'popular_items'              => 'Popular Pattern Types',
    'search_items'               => 'Search Pattern Types',
    'not_found'                  => 'Not Found',
    );
$args = array(
  'labels'                     => $labels,
  'hierarchical'               => true,
  'public'                     => true,
  'show_ui'                    => true,
  'show_admin_column'          => true,
  'show_in_nav_menus'          => false,
  'show_tagcloud'              => false,
  );
register_taxonomy( 'pattern_type', array( 'patterns' ), $args );

}



// Flush the rewrite rules to update if slug is set
add_action('admin-init', 'patterns_flush_rewrite');
function patterns_flush_rewrite() {
  $options      = get_option( 'patterns_settings' );
  $option_slug  = $options['patterns_cpt_slug'];
  if( isset($option_slug) )
    flush_rewrite_rules();
}