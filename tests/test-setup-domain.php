<?php
/**
 * Contains tests for WP_Hydra::setup_domain()
 *
 * @package wp-hydra
 */

/**
 * Tests for WP_Hydra::setup_domain()
 */
class WpHydraSetupDomainTest extends WP_UnitTestCase {
	/**
	 * Test setup
	 */
	public function setUp() {
		$this->wp_hydra = $this->getMockBuilder( 'WP_Hydra' )->setMethods( null )->getMock();
	}

	/**
	 * Test teardown
	 */
	public function tearDown() {
		unset( $this->wp_hydra );
	}

	/**
	 * Test with a wrong URL.
	 *
	 * @covers WP_Hydra::setup_domain
	 */
	public function testWithWrongURL() {
		$url = 'foo/com';

		$result = $this->wp_hydra->setup_domain( $url );

		$this->assertSame( $url, $result );
	}

	/**
	 * Test with a no host specified.
	 *
	 * @covers WP_Hydra::setup_domain
	 */
	public function testWithNoHost() {
		$original_host = $_SERVER['HTTP_HOST'];
		unset( $_SERVER['HTTP_HOST'] );

		$url = 'http://example.xyz/lorem-ipsum/';

		$result = $this->wp_hydra->setup_domain( $url );

		$this->assertSame( $url, $result );

		$_SERVER['HTTP_HOST'] = $original_host;
	}

	/**
	 * Test with the same domain.
	 *
	 * @covers WP_Hydra::setup_domain
	 */
	public function testWithTheSameDomain() {
		$original_host = $_SERVER['HTTP_HOST'];

		$_SERVER['HTTP_HOST'] = 'example.com';
		$url                  = 'http://example.com/lorem-ipsum/';

		$result = $this->wp_hydra->setup_domain( $url );

		$this->assertSame( $url, $result );

		$_SERVER['HTTP_HOST'] = $original_host;
	}

	/**
	 * Test with a different domain.
	 *
	 * @covers WP_Hydra::setup_domain
	 */
	public function testWithDifferentDomain() {
		$original_host        = $_SERVER['HTTP_HOST'];
		$current_domain       = 'foobar.com';
		$_SERVER['HTTP_HOST'] = 'foobar.com';
		$original_domain      = 'example.com';
		$url                  = 'http://example.com/lorem-ipsum/';
		$exposed_instance     = $this->getMockBuilder( 'WP_Hydra_Exposed' )->setMethods( null )->getMock();

		$expected = $exposed_instance->replace_domain_exposed( $url, $original_domain, $current_domain );
		$actual   = $this->wp_hydra->setup_domain( $url );

		$this->assertSame( $expected, $actual );

		$_SERVER['HTTP_HOST'] = $original_host;
	}

}

/**
 * Class that exposes the private WP_Hydra::replace_domain() method
 */
class WP_Hydra_Exposed extends WP_Hydra {
	/**
	 * Exposes the private WP_Hydra::replace_domain() method.
	 *
	 * @param string $url The domain.
	 * @param string $original_domain The original domain.
	 * @param string $current_domain The current domain.
	 * @return string String with domain replaced.
	 */
	public function replace_domain_exposed( $url, $original_domain, $current_domain ) {
		return $this->replace_domain( $url, $original_domain, $current_domain );
	}
}
