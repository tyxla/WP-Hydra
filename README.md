WP Hydra [![Build Status](https://travis-ci.org/tyxla/WP-Hydra.svg?branch=master)](https://travis-ci.org/tyxla/WP-Hydra) [![codecov](https://codecov.io/gh/tyxla/WP-Hydra/branch/master/graph/badge.svg)](https://codecov.io/gh/tyxla/WP-Hydra) [![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/tyxla/WP-Hydra/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/tyxla/WP-Hydra/?branch=master) [![Code Coverage](https://scrutinizer-ci.com/g/tyxla/WP-Hydra/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/tyxla/WP-Hydra/?branch=master)
========

Allows one WordPress installation to be resolved and browsed at multiple domains.

-----

#### Purpose

WP Hydra has a quite straightforward purpose. Say you have a WordPress site, hosted on example.com. You've also purchased example.net and example.org, and you want them to also use the same website (the same installation), but to persist with that particular domain to have a consistent user experience. WP Hydra can help you with this.

#### Abstract

Pointing multiple URLs to the same website is a good way to direct traffic to your site from several different domain names. You can accomplish this in two ways: either redirect one of the URLs to your primary domain, or park the domains, which point these domains towards your primary domain.

A redirect occurs when typing a web address in the address bar sends a visitor to another website (or URL), different from the one typed in. If this is your preferred case, then WP Hydra will not be of any need to you.

Parking a domain does the same thing as a redirect, except that the website name shown on the address bar does not change. You can park several domains to the same page. They have to be registered with a valid domain registrar before you can park them. Also, you’ll need to make sure the nameservers are the same as your primary domain (the domain that you are pointing towards).

Once your multiple domains point to the same website, you have to activate the plugin. No additional configuration or setup is required. This will make sure that the css, js, images and links that are leading to the original domain are now leading to the domain that you're currently viewing. This will assure that the users remain on the site that they've originally visited, providing consistent experience.

-----

#### Installation

You only need to make sure that your multiple domains point to the same hosting, and to the same physical location on your hosting account.

Once this is done, simply install and activate the plugin - no additional configuration is needed. 

-----

#### Further customization - filters

If you have some custom content and you want the URLs within it to support multiple domains, you can use the `wp_hydra_content` filter, like this:

	// we assume that you have some content in $content
    $content = apply_filters( 'wp_hydra_content', $content );

If you have some custom URLs somewhere and you want them multiple domains, you can use the `wp_hydra_domain` filter, like this:

	// we assume that you have some content in $content
    $url = apply_filters( 'wp_hydra_domain', $url );

-----

#### Further customization for developers

Since the `$wp_hydra` object is global, you can easily unhook any of the default functionality by simply calling `remove_action()` or `remove_filter` on it. The following example will remove the WP Hydra behavior of the content, but only for `the_content()` calls on the archive page:

	add_action( 'wp_loaded', 'some_example_here' );
	function some_example_here() {
		global $wp_hydra;
		if( is_archive() ) {
			remove_filter( 'the_content', array( $wp_hydra, 'setup_content' ) );
		}
	}

-----

#### Testing

The plugin is fully covered by unit tests.

For more information on how to install and run them, refer to the [WP Hydra Unit Tests README](https://github.com/tyxla/WP-Hydra/blob/master/tests/README.md).
