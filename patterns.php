<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://github.com/iamhexcoder
 * @since             1.0.0
 * @package           Patterns
 *
 * @wordpress-plugin
 * Plugin Name:       Patterns
 * Plugin URI:        https://github.com/iamhexcoder/patterns
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
 * Version:           1.0.0
 * Author:            Shaun Baer
 * Author URI:        https://github.com/iamhexcoder
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       patterns
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Activation
 */
function activate_plugin_name() {
  require_once plugin_dir_path( __FILE__ ) . 'includes/patterns-activate.php';
}

require plugin_dir_path( __FILE__ ) . 'admin/patterns-post-type.php';
require plugin_dir_path( __FILE__ ) . 'admin/patterns-options.php';
