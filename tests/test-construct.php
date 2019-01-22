<?php
/**
 * Contains tests for WP_Hydra::_construct()
 *
 * @package wp-hydra
 */

/**
 * Tests for WP_Hydra::_construct()
 */
class WpHydraConstructTest extends WP_UnitTestCase {

	/**
	 * Test setup.
	 */
	public function setUp() {
		$this->wp_hydra = $this->getMockBuilder( 'WP_Hydra' )->getMock();
	}

	/**
	 * Test teardown.
	 */
	public function tearDown() {
		unset( $this->wp_hydra );
	}

	/**
	 * Tests whether filters are properly registered.
	 *
	 * @covers WP_Hydra::__construct
	 */
	public function testHooksRegistered() {
		$this->wp_hydra->__construct();

		$this->assertSame( 1, has_filter( 'option_blogname', array( $this->wp_hydra, 'setup_domain' ) ) );
		$this->assertSame( 1, has_filter( 'option_siteurl', array( $this->wp_hydra, 'setup_domain' ) ) );
		$this->assertSame( 1, has_filter( 'option_home', array( $this->wp_hydra, 'setup_domain' ) ) );
		$this->assertSame( 1, has_filter( 'stylesheet_uri', array( $this->wp_hydra, 'setup_domain' ) ) );
		$this->assertSame( 1, has_filter( 'stylesheet_directory_uri', array( $this->wp_hydra, 'setup_domain' ) ) );
		$this->assertSame( 1, has_filter( 'template_directory_uri', array( $this->wp_hydra, 'setup_domain' ) ) );

		$this->assertSame( 10, has_filter( 'the_content', array( $this->wp_hydra, 'setup_content' ) ) );

		$this->assertSame( 10, has_filter( 'widget_text', array( $this->wp_hydra, 'setup_content' ) ) );

		$this->assertSame( 10, has_filter( 'upload_dir', array( $this->wp_hydra, 'setup_upload_dir' ) ) );

		$this->assertSame( 10, has_filter( 'wp_hydra_domain', array( $this->wp_hydra, 'setup_domain' ) ) );

		$this->assertSame( 10, has_filter( 'wp_hydra_content', array( $this->wp_hydra, 'setup_content' ) ) );
	}

}
