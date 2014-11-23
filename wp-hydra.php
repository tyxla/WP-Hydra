<?php
/**
 * Plugin Name: WP Hydra
 * Description: Allows one WordPress installation to be resolved and browsed at multiple domains.
 * Version: 1.0
 * Author: tyxla
 * Author URI: https://github.com/tyxla
 * License: GPL2
 */

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
		add_filter('option_blogname', array($this, 'setup_domain'), 1);
		add_filter('option_siteurl', array($this, 'setup_domain'), 1);
		add_filter('option_home', array($this, 'setup_domain'), 1);
		add_filter('stylesheet_uri', array($this, 'setup_domain'), 1);
		add_filter('stylesheet_directory_uri', array($this, 'setup_domain'), 1);
		add_filter('template_directory_uri', array($this, 'setup_domain'), 1);

		// replace occurences in content
		add_filter('the_content', array($this, 'setup_content'));

		// replace occurences in widget text
		add_filter('widget_text', array($this, 'setup_content'));

		// allow developers to support multiple domains in fields that contain only a site URL
		add_filter('wp_hydra_domain', array($this, 'setup_domain'));

		// allow developers to support URLs with multiple domains in their content
		add_filter('wp_hydra_content', array($this, 'setup_content'));
	}

	/**	
	 * Replaces original domain with current domain in simple fields.
	 *
	 * @access public
	 *
	 * @param string $url The current URL.
	 * @return string $url The URL with the (maybe) replaced domain.
	 */
	public function setup_domain($url) {
		// parse current URL
		$original_domain_parts = parse_url($url);

		// if unable to retrieve the host, skip
		if (empty($original_domain_parts['host'])) {
			return $url;
		}

		// get original and current domain
		$original_domain = $original_domain_parts['host'];
		$current_domain = $_SERVER['HTTP_HOST'];

		// if original and current domain match, skip
		if ($original_domain == $current_domain) {
			return $url;
		}

		// prepare original domain and current domain with the current protocol
		$protocol = (isset($_SERVER['HTTPS']) ? 'https' : 'http') . '://';
		$original_base = $protocol . $original_domain;
		$new_base = $protocol . $current_domain;

		// replace original domain with current domain
		return str_replace($original_base, $new_base, $url);
	}

	/**	
	 * Replaces original domain with current domain in content.
	 *
	 * @access public
	 *
	 * @param string $content The current content with the original domain.
	 * @return string $content The content with the new domain.
	 */
	public function setup_content($content) {
		// get original home URL
		remove_filter('option_home', array($this, 'setup_domain'), 1);
		$original_home = home_url('/');
		add_filter('option_home', array($this, 'setup_domain'), 1);

		// get current home URL
		$current_home = home_url('/');

		// replace occurences of original URL with current home URL
		$content = str_replace($original_home, $current_home, $content);

		return $content;	
	}

}

// initialize WP Hydra - Polycephaly FTW!
global $wp_hydra;
$wp_hydra = new WP_Hydra();