<?php

namespace Yoast\AcfAnalysis\Tests\Assets;

use Brain\Monkey;
use Brain\Monkey\Functions;

/**
 * Class Assets_Test
 */
class Assets_Test extends \PHPUnit_Framework_TestCase {

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
	 * Test the init hook and determines whether the proper assets are loaded.
	 *
	 * @return void
	 */
	public function testInitHook() {
		define( 'AC_SEO_ACF_ANALYSIS_PLUGIN_FILE', '/directory/file' );
		Functions\expect( 'get_plugin_data' )
			->once()
			->with( AC_SEO_ACF_ANALYSIS_PLUGIN_FILE )
			->andReturn(
				array(
					'Version' => '2.0.0',
				)
			);

		$testee = new \Yoast_ACF_Analysis_Assets();
		$testee->init();

		$this->assertTrue( has_filter( 'admin_enqueue_scripts', array( $testee, 'enqueue_scripts' ) ) );
	}
}
