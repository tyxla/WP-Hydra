<?php
/**
 * Contains tests for WP_Hydra::is_ssl()
 *
 * @package wp-hydra
 */

/**
 * Tests for WP_Hydra::is_ssl()
 */
class WpHydraIsSslTest extends WP_UnitTestCase {
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
	 * Test when SSL is disabled.
	 *
	 * @covers WP_Hydra::is_ssl
	 */
	public function testWithSslDisabled() {
		$_SERVER['HTTPS'] = 0;
		$this->assertFalse( $this->wp_hydra->is_ssl() );

		$_SERVER['HTTPS'] = false;
		$this->assertFalse( $this->wp_hydra->is_ssl() );
	}

	/**
	 * Test when SSL is enabled.
	 *
	 * @covers WP_Hydra::is_ssl
	 */
	public function testWithSslEnabled() {
		$_SERVER['HTTPS'] = 1;
		$this->assertTrue( $this->wp_hydra->is_ssl() );

		$_SERVER['HTTPS'] = 'on';
		$this->assertTrue( $this->wp_hydra->is_ssl() );
	}

}
