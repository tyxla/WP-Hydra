<?php
/**
 * Plugin Name: WP Hydra
 * Plugin URI: https://wordpress.org/plugins/wp-hydra/
 * Description: Allows one WordPress installation to be resolved and browsed at multiple domains.
 * Version: 1.2
 * Author: tyxla
 * Author URI: http://marinatanasov.com/
 * License: GPL2
 * Requires at least: 4.0
 * Tested up to: 5.1
 *
 * @package wp-hydra
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Load main class.
include_once( dirname( __FILE__ ) . DIRECTORY_SEPARATOR . 'class-wp-hydra.php' );

// initialize WP Hydra - Polycephaly FTW!
global $wp_hydra;
$wp_hydra = new WP_Hydra();
