<?php
/**
 * Plugin Name: WP Hydra
 * Plugin URI: https://wordpress.org/plugins/wp-hydra/
 * Description: Allows one WordPress installation to be resolved and browsed at multiple domains.
 * Version: 1.1
 * Author: tyxla
 * Author URI: http://marinatanasov.com/
 * License: GPL2
 * Requires at least: 4.0
 * Tested up to: 5.1
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Main WP_Hydra class.
 *
 * Replaces the original domain with the current domain, where necessary.
 * All of the magic is hooked upon WP_Hydra object initialization.
 */
class WP_Hydra {

	/**
	 * Constructor.
	 *	
	 * Hooks all of the domain replacement functionality.
	 *
	 * @access public
	 */
	public function __construct() {
		// modify domain where necessary
		add_filter( 'option_blogname', array( $this, 'setup_domain' ), 1 );
		add_filter( 'option_siteurl', array( $this, 'setup_domain' ), 1 );
		add_filter( 'option_home', array( $this, 'setup_domain' ), 1 );
		add_filter( 'stylesheet_uri', array( $this, 'setup_domain' ), 1 );
		add_filter( 'stylesheet_directory_uri', array( $this, 'setup_domain' ), 1 );
		add_filter( 'template_directory_uri', array( $this, 'setup_domain' ), 1 );
		add_filter( 'plugins_url', array( $this, 'setup_domain' ), 1 );

		// replace various occurences
		add_filter( 'the_content', array( $this, 'setup_content' ) ); // content
		add_filter( 'widget_text', array( $this, 'setup_content' ) ); // widget text
		add_filter( 'upload_dir', array( $this, 'setup_upload_dir' ) ); // wp_upload_dir();

		// allow developers to support multiple domains in fields that contain only a site URL
		add_filter( 'wp_hydra_domain', array( $this, 'setup_domain' ) );

		// allow developers to support URLs with multiple domains in their content
		add_filter( 'wp_hydra_content', array( $this, 'setup_content' ) );
	}

	/**	
	 * Replaces original domain with current domain in simple fields.
	 *
	 * @access public
	 *
	 * @param string $url The current URL.
	 * @return string $url The URL with the (maybe) replaced domain.
	 */
	public function setup_domain( $url ) {
		// parse current URL
		$original_domain_parts = parse_url( $url );

		// if unable to retrieve the host, skip
		if ( empty( $original_domain_parts['host'] ) || ! isset( $_SERVER['HTTP_HOST'] ) ) {
			return $url;
		}

		// get original and current domain
		$original_domain = $original_domain_parts['host'];
		$current_domain = $_SERVER['HTTP_HOST'];

		// if original and current domain match, skip
		if ( $original_domain == $current_domain ) {
			return $url;
		}

		return $this->replace_domain( $url, $original_domain, $current_domain );
	}

	/**
	 * Replace the old domain with a new domain in a specific URL.
	 * 
	 * @access protected
	 *
	 * @param string $url The current URL.
	 * @param string $old_domain The old domain.
	 * @param string $new_domain The new domain.
	 * @return string $url The new URL.
	 */
	protected function replace_domain( $url, $old_domain, $new_domain ) {
		// prepare original domain and current domain with the current protocol
		$protocols = array( 'http://', 'https://' );
		$current_protocol = ( $this->is_ssl() ? 'https' : 'http' ) . '://';

		foreach ( $protocols as $protocol ) {
			$original_base = $protocol . $old_domain;
			$new_base = $current_protocol . $new_domain;

			// replace original domain with current domain
			$url = str_replace( $original_base, $new_base, $url );
		}

		return $url;
	}

	/**	
	 * Replaces original domain with current domain in content.
	 *
	 * @access public
	 *
	 * @param string $content The current content with the original domain.
	 * @return string $content The content with the new domain.
	 */
	public function setup_content( $content ) {
		// get original home URL
		remove_filter( 'option_home', array( $this, 'setup_domain' ), 1 );
		$original_home = home_url( '/' );
		add_filter( 'option_home', array( $this, 'setup_domain' ), 1 );

		// get current home URL
		$current_home = home_url( '/' );

		// replace occurences of original URL with current home URL
		$content = str_replace( $original_home, $current_home, $content );

		return $content;	
	}

	/**	
	 * Replaces original domain with current domain in wp_upload_dir().
	 *
	 * @access public
	 *
	 * @param array $upload_dir The current upload dir settings with the original domain.
	 * @return array $upload_dir The upload dir settings with the new domain.
	 */
	public function setup_upload_dir( $upload_dir ) {
		// keys of array element that we'll be updating
		$keys_to_update = array(
			'url',
			'baseurl',
		);

		// fix all targeted array elements
		foreach ( $keys_to_update as $key ) {
			$upload_dir[ $key ] = apply_filters( 'wp_hydra_domain', $upload_dir[ $key ] );
		}

		return $upload_dir;
	}

	/**
	 * Determine if SSL is used.
	 *
	 * @access public
	 *
	 * @return bool True if SSL, false if not used.
	 */
	public function is_ssl() {
		return is_ssl();
	}

}

// initialize WP Hydra - Polycephaly FTW!
global $wp_hydra;
$wp_hydra = new WP_Hydra();