<?php
/**
 * Contains tests for verifying the global vars are defined as expected.
 *
 * @package wp-hydra
 */

/**
 * Tests for WP_Hydra's global var definition
 */
class WpHydraGlobalVarTest extends WP_UnitTestCase {
	/**
	 * Test setup
	 */
	public function setUp() {
		self::$ignore_files = true;

		parent::setUp();
	}

	/**
	 * Covers the global var definition
	 */
	public function testGlobalVarDefined() {
		global $wp_hydra;

		$this->assertNotEmpty( $wp_hydra );
		$this->assertInstanceOf( 'WP_Hydra', $wp_hydra );
	}
}
