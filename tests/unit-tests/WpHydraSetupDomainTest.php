<?php

class WpHydraSetupDomainTest extends WP_UnitTestCase {

	public function setUp() {
		$this->wp_hydra = $this->getMock('WP_Hydra', null);
	}

	public function tearDown() {
		unset( $this->wp_hydra );
	}

	/**
	 * @covers WP_Hydra::setup_domain
	 */
	public function testWithWrongURL() {
		$url = 'foo/com';

		$result = $this->wp_hydra->setup_domain( $url );

		$this->assertSame( $url, $result );
	}

	/**
	 * @covers WP_Hydra::setup_domain
	 */
	public function testWithTheSameDomain() {
		$_SERVER['HTTP_HOST'] = 'example.com';
		$url = 'http://example.com/lorem-ipsum/';

		$result = $this->wp_hydra->setup_domain( $url );

		$this->assertSame( $url, $result );
	}

	/**
	 * @covers WP_Hydra::setup_domain
	 */
	public function testWithDifferentDomain() {
		$current_domain = $_SERVER['HTTP_HOST'] = 'foobar.com';
		$original_domain = 'example.com';
		$url = 'http://example.com/lorem-ipsum/';
		$exposed_instance = $this->getMock('WP_Hydra_Exposed', null);

		$expected = $exposed_instance->replace_domain_exposed( $url, $original_domain, $current_domain );
		$actual = $this->wp_hydra->setup_domain( $url );

		$this->assertSame( $expected, $actual );
	}

}

class WP_Hydra_Exposed extends WP_Hydra {
	public function replace_domain_exposed( $url, $original_domain, $current_domain ) {
		return $this->replace_domain( $url, $original_domain, $current_domain );
	}
}