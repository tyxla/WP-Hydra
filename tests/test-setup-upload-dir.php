<?php
/**
 * Contains tests for WP_Hydra::setup_upload_dir()
 *
 * @package wp-hydra
 */

/**
 * Tests for WP_Hydra::setup_upload_dir()
 */
class WpHydraSetupUploadDirTest extends WP_UnitTestCase {
	/**
	 * Test setup
	 */
	public function setUp() {
		$this->wp_hydra = $this->getMockBuilder( 'WP_Hydra' )->disableOriginalConstructor()->setMethods( null )->getMock();

		add_filter( 'wp_hydra_domain', array( $this, 'wp_hydra_domain' ) );
	}

	/**
	 * Test teardown
	 */
	public function tearDown() {
		remove_filter( 'wp_hydra_domain', array( $this, 'wp_hydra_domain' ) );

		unset( $this->wp_hydra );
	}

	/**
	 * Test the filter on URLs.
	 *
	 * @covers WP_Hydra::setup_upload_dir
	 */
	public function testFilterOnUrls() {
		$upload_dir = array(
			'url'     => 'example.com',
			'baseurl' => 'example.com',
		);
		$expected   = array(
			'url'     => 'foobar.com',
			'baseurl' => 'foobar.com',
		);
		$actual     = $this->wp_hydra->setup_upload_dir( $upload_dir );
		$this->assertSame( $expected, $actual );
	}

	/**
	 * Test the filter on another field.
	 *
	 * @covers WP_Hydra::setup_upload_dir
	 */
	public function testFilterOnSomethingElse() {
		$upload_dir = array(
			'url'     => 'foobar.com',
			'baseurl' => 'foobar.com',
			'foobar'  => 'example.com',
		);
		$expected   = $upload_dir;
		$actual     = $this->wp_hydra->setup_upload_dir( $upload_dir );
		$this->assertSame( $expected, $actual );
	}

	/**
	 * Used for hooking on the wp_hydra_domain filter.
	 *
	 * @param string $domain The domain.
	 * @return string A different domain domain.
	 */
	public function wp_hydra_domain( $domain ) {
		return 'foobar.com';
	}

}
