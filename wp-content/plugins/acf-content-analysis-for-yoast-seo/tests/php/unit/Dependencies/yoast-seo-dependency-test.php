<?php

namespace Yoast\AcfAnalysis\Tests\Dependencies;

use Brain\Monkey;

/**
 * Class Yoast_SEO_Dependency_Test*
 */
class Yoast_SEO_Dependency_Test extends \PHPUnit_Framework_TestCase {

	/**
	 * Whether or not to preserve the global state.
	 *
	 * @var bool
	 */
	protected $preserveGlobalState = false;

	/**
	 * Whether or not to run each test in a separate process.
	 *
	 * @var bool
	 */
	protected $runTestInSeparateProcess = true;

	/**
	 * Sets up test fixtures.
	 *
	 * @return void
	 */
	protected function setUp() {
		parent::setUp();
		Monkey\setUp();
	}

	/**
	 * Tears down test fixtures previously setup.
	 *
	 * @return void
	 */
	protected function tearDown() {
		Monkey\tearDown();
		parent::tearDown();
	}

	/**
	 * Tests that requirements are not met when Yoast SEO can't be found.
	 *
	 * @return void
	 */
	public function testFail() {
		$testee = new \Yoast_ACF_Analysis_Dependency_Yoast_SEO();

		$this->assertFalse( $testee->is_met() );
	}

	/**
	 * Tests that requirements are met when Yoast SEO can be found, based on the existence of a version number.
	 *
	 * @return void
	 */
	public function testPass() {
		define( 'WPSEO_VERSION', '4.0.0' );

		$testee = new \Yoast_ACF_Analysis_Dependency_Yoast_SEO();
		$this->assertTrue( $testee->is_met() );
	}

	/**
	 * Tests that requirements are not met when an old and incompatible version Yoast SEO is installed.
	 *
	 * @return void
	 */
	public function testOldVersion() {
		define( 'WPSEO_VERSION', '2.0.0' );

		$testee = new \Yoast_ACF_Analysis_Dependency_Yoast_SEO();
		$this->assertFalse( $testee->is_met() );
	}

	/**
	 * Tests the appearance of the admin notice when requirements are not met.
	 *
	 * @return void
	 */
	public function testAdminNotice() {
		$testee = new \Yoast_ACF_Analysis_Dependency_Yoast_SEO();
		$testee->register_notifications();

		$this->assertTrue( has_action( 'admin_notices', array( $testee, 'message_plugin_not_activated' ) ) );
	}

	/**
	 * Tests the appearance of the admin notice when minimum version requirements are not met.
	 *
	 * @return void
	 */
	public function testAdminNoticeMinimumVersion() {
		define( 'WPSEO_VERSION', '2.0.0' );

		$testee = new \Yoast_ACF_Analysis_Dependency_Yoast_SEO();
		$testee->register_notifications();

		$this->assertTrue( has_action( 'admin_notices', array( $testee, 'message_minimum_version' ) ) );
	}
}
