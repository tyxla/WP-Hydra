<?php

class WpHydraGlobalVarTest extends WP_UnitTestCase {
	public function setUp() {
		self::$ignore_files = true;

		parent::setUp();
	}

	public function testGlobalVarDefined() {
		global $wp_hydra;

		$this->assertNotEmpty($wp_hydra);
		$this->assertInstanceOf('WP_Hydra', $wp_hydra);
	}
}