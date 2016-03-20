<?php

class WpHydraSetupContentTest extends WP_UnitTestCase {

	public function setUp() {
		$this->wp_hydra = $this->getMock('WP_Hydra', array('setup_domain'), array(), '', false);

		$this->domain = 'http://foobar.com';

		$this->wp_hydra->expects($this->any())
			->method('setup_domain')
			->will($this->returnValue($this->domain));
	}

	public function tearDown() {
		unset( $this->wp_hydra );
		unset( $this->domain );
	}

}