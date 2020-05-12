<?php

namespace Yoast\AcfAnalysis\Tests\Dependencies;

use Brain\Monkey;

/**
 * Class ACF_Dependency_Test
 */
class ACF_Dependency_Test extends \PHPUnit_Framework_TestCase {

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
	 * Tests the situation where no ACF class exists.
	 *
	 * @return void
	 */
	public function testNoACFClassExists() {
		$testee = new \Yoast_ACF_Analysis_Dependency_ACF();

		$this->assertFalse( $testee->is_met() );
	}

	/**
	 * Tests the situation where the ACF class exists.
	 *
	 * @return void
	 */
	public function testACFClassExists() {
		$testee = new \Yoast_ACF_Analysis_Dependency_ACF();

		require_once __DIR__ . DIRECTORY_SEPARATOR . 'acf.php';

		$this->assertTrue( $testee->is_met() );
	}

	/**
	 * Tests the admin notice.
	 *
	 * @return void
	 */
	public function testAdminNotice() {
		$testee = new \Yoast_ACF_Analysis_Dependency_ACF();
		$testee->register_notifications();

		$this->assertTrue( has_action( 'admin_notices', array( $testee, 'message_plugin_not_activated' ) ) );
	}
}
