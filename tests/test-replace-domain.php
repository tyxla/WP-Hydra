<?php
/**
 * Contains tests for WP_Hydra::replace_domain()
 *
 * @package wp-hydra
 */

/**
 * Tests for WP_Hydra::replace_domain()
 */
class WpHydraReplaceDomainTest extends WP_UnitTestCase {
	/**
	 * Test setup
	 */
	public function setUp() {
		$this->wp_hydra = $this->getMockBuilder( 'WP_Hydra_Exposed_RD' )->setMethods( array( 'is_ssl' ) )->getMock();
	}

	/**
	 * Test teardown
	 */
	public function tearDown() {
		unset( $this->wp_hydra );
	}

	/**
	 * Test with HTTP URL and HTTPS off.
	 *
	 * @covers WP_Hydra::replace_domain
	 */
	public function testWithHttpUrlAndHttpsOff() {
		$this->wp_hydra->expects( $this->any() )
			->method( 'is_ssl' )
			->will( $this->returnValue( false ) );

		$url    = 'http://example.com/';
		$result = $this->wp_hydra->replace_domain_exposed( $url, 'example.com', 'example.com' );
		$this->assertSame( $url, $result );
	}

	/**
	 * Test with HTTP URL and HTTPS on.
	 *
	 * @covers WP_Hydra::replace_domain
	 */
	public function testWithHttpUrlAndHttpsOn() {
		$this->wp_hydra->expects( $this->any() )
			->method( 'is_ssl' )
			->will( $this->returnValue( true ) );

		$url      = 'http://example.com/';
		$expected = 'https://example.com/';
		$actual   = $this->wp_hydra->replace_domain_exposed( $url, 'example.com', 'example.com' );
		$this->assertSame( $expected, $actual );
	}

	/**
	 * Test with HTTPS URL and HTTPS off.
	 *
	 * @covers WP_Hydra::replace_domain
	 */
	public function testWithHttpsUrlAndHttpsOff() {
		$this->wp_hydra->expects( $this->any() )
			->method( 'is_ssl' )
			->will( $this->returnValue( false ) );

		$url      = 'https://example.com/';
		$expected = 'http://example.com/';
		$actual   = $this->wp_hydra->replace_domain_exposed( $url, 'example.com', 'example.com' );
		$this->assertSame( $expected, $actual );
	}

	/**
	 * Test with HTTPS URL and HTTPS on.
	 *
	 * @covers WP_Hydra::replace_domain
	 */
	public function testWithHttpsUrlAndHttpsOn() {
		$this->wp_hydra->expects( $this->any() )
			->method( 'is_ssl' )
			->will( $this->returnValue( true ) );

		$url    = 'https://example.com/';
		$actual = $this->wp_hydra->replace_domain_exposed( $url, 'example.com', 'example.com' );
		$this->assertSame( $url, $actual );
	}

	/**
	 * Test with HTTP URL and HTTPS off and different domain.
	 *
	 * @covers WP_Hydra::replace_domain
	 */
	public function testWithHttpUrlAndHttpsOffAndDifferentDomain() {
		$this->wp_hydra->expects( $this->any() )
			->method( 'is_ssl' )
			->will( $this->returnValue( false ) );

		$url      = 'http://example.com/';
		$expected = 'http://foobar.com/';
		$result   = $this->wp_hydra->replace_domain_exposed( $url, 'example.com', 'foobar.com' );
		$this->assertSame( $expected, $result );
	}

	/**
	 * Test with HTTP URL and HTTPS on and different domain.
	 *
	 * @covers WP_Hydra::replace_domain
	 */
	public function testWithHttpUrlAndHttpsOnAndDifferentDomain() {
		$this->wp_hydra->expects( $this->any() )
			->method( 'is_ssl' )
			->will( $this->returnValue( true ) );

		$url      = 'http://example.com/';
		$expected = 'https://foobar.com/';
		$actual   = $this->wp_hydra->replace_domain_exposed( $url, 'example.com', 'foobar.com' );
		$this->assertSame( $expected, $actual );
	}

	/**
	 * Test with HTTPS URL and HTTPS off and different domain.
	 *
	 * @covers WP_Hydra::replace_domain
	 */
	public function testWithHttpsUrlAndHttpsOffAndDifferentDomain() {
		$this->wp_hydra->expects( $this->any() )
			->method( 'is_ssl' )
			->will( $this->returnValue( false ) );

		$url      = 'https://example.com/';
		$expected = 'http://foobar.com/';
		$actual   = $this->wp_hydra->replace_domain_exposed( $url, 'example.com', 'foobar.com' );
		$this->assertSame( $expected, $actual );
	}

	/**
	 * Test with HTTPS URL and HTTPS on and different domain.
	 *
	 * @covers WP_Hydra::replace_domain
	 */
	public function testWithHttpsUrlAndHttpsOnAndDifferentDomain() {
		$this->wp_hydra->expects( $this->any() )
			->method( 'is_ssl' )
			->will( $this->returnValue( true ) );

		$url      = 'https://example.com/';
		$expected = 'https://foobar.com/';
		$actual   = $this->wp_hydra->replace_domain_exposed( $url, 'example.com', 'foobar.com' );
		$this->assertSame( $expected, $actual );
	}

}

/**
 * Class that exposes the private WP_Hydra::replace_domain() method.
 */
class WP_Hydra_Exposed_RD extends WP_Hydra {
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
