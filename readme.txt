=== WP Hydra ===
Contributors: tyxla
Tags: wp, hydra, multiple, domains, installation, resolved
Requires at least: 4.0
Tested up to: 5.1
Stable tag: 1.2
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Allows one WordPress installation to be resolved and browsed at multiple domains.

== Description ==

WP Hydra has a quite straightforward purpose. Say you have a WordPress site, hosted on example.com. You've also purchased example.net and example.org, and you want them to also use the same website (the same installation), but to persist with that particular domain to have a consistent user experience. In other terms, you want your WordPress installation to be resolved and browsed at multiple domains. WP Hydra can help you with this.

Pointing multiple URLs to the same website is a good way to direct traffic to your site from several different domain names. You can accomplish this in two ways: either redirect one of the URLs to your primary domain, or park the domains, which point these domains towards your primary domain.

A redirect occurs when typing a web address in the address bar sends a visitor to another website (or URL), different from the one typed in. If this is your preferred case, then WP Hydra will not be of any need to you.

Parking a domain does the same thing as a redirect, except that the website name shown on the address bar does not change. You can park several domains to the same page. They have to be registered with a valid domain registrar before you can park them. Also, you’ll need to make sure the nameservers are the same as your primary domain (the domain that you are pointing towards).

Once your multiple domains point to the same website, you have to activate the plugin. No additional configuration or setup is required. This will make sure that the css, js, images and links that are leading to the original domain are now leading to the domain that you're currently viewing. This will assure that the users remain on the site that they've originally visited, providing consistent experience.

== Installation ==

1. Install WP Hydra either via the WordPress.org plugin directory, or by uploading the files to your server.
1. Activate the plugin.
1. That's it. You're ready to go!

== Configuration ==

You only need to make sure that your multiple domains point to the same hosting, and to the same physical location on your hosting account.

Once this is done, simply install and activate the plugin - no additional configuration is needed. 

== Further customization - filters ==

If you have some custom content and you want the URLs within it to support multiple domains, you can use the `wp_hydra_content` filter, like this:

`// we assume that you have some content in $content
$content = apply_filters( 'wp_hydra_content', $content );
`

If you have some custom URLs somewhere and you want them multiple domains, you can use the `wp_hydra_domain` filter, like this:

`// we assume that you have some content in $content
$url = apply_filters('wp_hydra_domain', $url);
`

== Further customization for developers ==

Since the `$wp_hydra` object is global, you can easily unhook any of the default functionality by simply calling `remove_action()` or `remove_filter` on it. The following example will remove the WP Hydra behavior of the content, but only for `the_content()` calls on the archive page:

`add_action( 'wp_loaded', 'some_example_here' );
function some_example_here() {
	global $wp_hydra;
	if( is_archive() ) {
		remove_filter( 'the_content', array( $wp_hydra, 'setup_content' ) );
	}
}
`

== Changelog ==

= 1.2 =
* Tested with WordPress 5.0 and 5.1.
* Improved Travis CI config.
* Improved Scrutinizer CI config.
* Made plugin fully compatible with WordPress Coding Standards.
* Fixed tests framework.
* Improved tests.
* Implemented Codecov.

= 1.1 =
* Tested with WordPress 4.5.
* Implemented Scrutinizer CI
* Made plugin compatible with WordPress Coding Standards
* Added composer.json
* Various code improvements
* Implemented a unit test suite and a complete set of tests
* Implemented Travis CI

= 1.0.4 =
* Tested with WordPress 4.4.

= 1.0.3 =
* Tested with WordPress 4.3.

= 1.0.2 =
* Fixing IIS compatibility issues.

= 1.0.1 =
* Support both http and https together.

= 1.0 =
* Initial version.