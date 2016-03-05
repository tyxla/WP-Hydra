<?php

class WpHydraReplaceDomainTest extends WP_UnitTestCase {

	public function setUp() {
		$this->wp_hydra = $this->getMock('WP_Hydra_Exposed_RD', array('is_ssl'));
	}

	public function tearDown() {
		unset( $this->wp_hydra );
	}

	/**
	 * @covers WP_Hydra::replace_domain
	 */
	public function testWithHttpUrlAndHttpsOff() {
		$this->wp_hydra->expects($this->any())
			->method('is_ssl')
			->will($this->returnValue(false));

		$url = 'http://example.com/';
		$result = $this->wp_hydra->replace_domain_exposed( $url, 'example.com', 'example.com' );
		$this->assertSame( $url, $result );
	}

	/**
	 * @covers WP_Hydra::replace_domain
	 */
	public function testWithHttpUrlAndHttpsOn() {
		$this->wp_hydra->expects($this->any())
			->method('is_ssl')
			->will($this->returnValue(true));

		$url = 'http://example.com/';
		$expected = 'https://example.com/';
		$actual = $this->wp_hydra->replace_domain_exposed( $url, 'example.com', 'example.com' );
		$this->assertSame( $expected, $actual );
	}

}

class WP_Hydra_Exposed_RD extends WP_Hydra {
	public function replace_domain_exposed( $url, $original_domain, $current_domain ) {
		return $this->replace_domain( $url, $original_domain, $current_domain );
	}
}