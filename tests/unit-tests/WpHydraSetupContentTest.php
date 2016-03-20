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

	/**
	 * @covers WP_Hydra::setup_content
	 */
	public function testOccurencesInTheBeginning() {
		$content = 'http://example.org/ foo bar ';

		$expected = $this->domain . '/ foo bar ';
		$actual = $this->wp_hydra->setup_content( $content );

		$this->assertSame( $expected, $actual );
	}

	/**
	 * @covers WP_Hydra::setup_content
	 */
	public function testOccurencesInTheMiddle() {
		$content = 'helloWorld http://example.org/ foo bar ';

		$expected = 'helloWorld ' . $this->domain . '/ foo bar ';
		$actual = $this->wp_hydra->setup_content( $content );

		$this->assertSame( $expected, $actual );
	}

	/**
	 * @covers WP_Hydra::setup_content
	 */
	public function testOccurencesInTheEnd() {
		$content = 'helloWorld http://example.org/';

		$expected = 'helloWorld ' . $this->domain . '/';
		$actual = $this->wp_hydra->setup_content( $content );

		$this->assertSame( $expected, $actual );
	}

	/**
	 * @covers WP_Hydra::setup_content
	 */
	public function testMultipleOccurences() {
		$content = 'http://example.org/ helloWorld http://example.org/ foo bar http://example.org/';

		$expected = $this->domain . '/ helloWorld ' . $this->domain . '/ foo bar ' . $this->domain . '/';
		$actual = $this->wp_hydra->setup_content( $content );

		$this->assertSame( $expected, $actual );
	}

	/**
	 * @covers WP_Hydra::setup_content
	 */
	public function testOccurencesInAnImage() {
		$content = '<img src="http://example.org/wp-content/uploads/2012/12/test.jpg" width="640" height="480" alt="" />';

		$expected = '<img src="' . $this->domain . '/wp-content/uploads/2012/12/test.jpg" width="640" height="480" alt="" />';
		$actual = $this->wp_hydra->setup_content( $content );

		$this->assertSame( $expected, $actual );
	}

	/**
	 * @covers WP_Hydra::setup_content
	 */
	public function testOccurencesInALink() {
		$content = '<a href="http://example.org/foo/bar/">Test</a>';

		$expected = '<a href="' . $this->domain . '/foo/bar/">Test</a>';
		$actual = $this->wp_hydra->setup_content( $content );

		$this->assertSame( $expected, $actual );
	}

}