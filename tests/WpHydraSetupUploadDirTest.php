<?php

class WpHydraSetupUploadDirTest extends WP_UnitTestCase {

	public function setUp() {
		$this->wp_hydra = $this->getMockBuilder('WP_Hydra')->disableOriginalConstructor()->setMethods(null)->getMock();

		add_filter( 'wp_hydra_domain', array( $this, 'wp_hydra_domain' ) );
	}

	public function tearDown() {
		remove_filter( 'wp_hydra_domain', array( $this, 'wp_hydra_domain' ) );

		unset( $this->wp_hydra );
	}

	/**
	 * @covers WP_Hydra::setup_upload_dir
	 */
	public function testFilterOnUrls() {
		$upload_dir = array(
			'url' => 'example.com',
			'baseurl' => 'example.com',
		);
		$expected = array(
			'url' => 'foobar.com',
			'baseurl' => 'foobar.com',
		);
		$actual = $this->wp_hydra->setup_upload_dir( $upload_dir );
		$this->assertSame( $expected, $actual );
	}

	/**
	 * @covers WP_Hydra::setup_upload_dir
	 */
	public function testFilterOnSomethingElse() {
		$upload_dir = $expected = array(
			'url' => 'foobar.com',
			'baseurl' => 'foobar.com',
			'foobar' => 'example.com',
		);
		$actual = $this->wp_hydra->setup_upload_dir( $upload_dir );
		$this->assertSame( $expected, $actual );
	}

	public function wp_hydra_domain( $domain ) {
		return 'foobar.com';
	}

}