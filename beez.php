<?php

/**
 * @link              https://github.com/Frenziecodes/Beez/
 * @since             1.0.0
 * @package           Business hours management
 *
 * @wordpress-plugin
 * Plugin Name:       Business hours management
 * Plugin URI:        https://github.com/Frenziecodes/Beez/
 * Description:       Effortlessly display and manage business hours on your website.
 * Version:           1.0.0
 * Author:            WpNizzle
 * Author URI:        https://github.com/Frenziecodes
 * License:           GPL-3.0+
 * License URI:       http://www.gnu.org/licenses/gpl-3.0.txt
 * Text Domain:       beez-management
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'ABSPATH' ) ) {
    die;
}

/**
 * Current plugin version.
 */
define( 'BUSINESS_HOURS_MANAGEMENT_VERSION', '1.0.0' );

// Enqueue CSS and JavaScript files.
function beez_management_enqueue_scripts() {
    wp_enqueue_style( 'beez-management-style', plugin_dir_url( __FILE__ ) . 'assets/css/beez.css', array(), '1.0.0' );
    wp_enqueue_script( 'beez-management-script', plugin_dir_url( __FILE__ ) . 'assets/js/beez.js', array( 'jquery' ), '1.0.0', true );
}
add_action( 'admin_enqueue_scripts', 'beez_management_enqueue_scripts' );

require plugin_dir_path( __FILE__ ) . 'includes/functions.php';
require plugin_dir_path( __FILE__ ) . 'includes/class-shortcode.php';
require plugin_dir_path( __FILE__ ) . 'admin/class-beez-settings.php';