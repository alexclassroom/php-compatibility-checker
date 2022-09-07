<?php

/**
 * Test the primary plugin file
 *
 * @package WPEngine_PHPCompat\PHP_Compatibility_Checker
 */

namespace WPEngine_PHPCompat;

use PHPUnit\Framework\TestCase;
use Brain\Monkey;

/**
 * Test the main plugin file
 */
class PluginFileTest extends TestCase {

	protected function tearDown(): void {

		Monkey\tearDown();
		parent::tearDown();

	}

	public function test_true()
	{
		$this->assertTrue(true);
	}
	/**
	 * Test loader function
	 */
	public function test_wpe_phpcompat_loader() {

		Monkey\Functions\expect( 'load_plugin_textdomain' )->once();

		wpe_phpcompat_loader();

		$this->assertTrue( defined( 'WPENGINE_PHP_COMPATIBILITY_VERSION' ) );

	}

	public function test_autoloader_registered() {
		$this->assertContains( 'WPEngine_PHPCompat\wpe_phpcompat_autoloader', spl_autoload_functions() );
	}

	public function test_autoloader() {

		$home = dirname( __DIR__ );
		$test_classes = array(
			'WPEngine_PHPCompat\Class_One' => $home. '/plugin/lib/class-class-one.php',
			'WPEngine_PHPCompat\Sub_Classes\Class_Two' => $home . '/plugin/lib/Sub_Classes/class-class-two.php',
			'Class_Three' => '',
		);

		foreach ( $test_classes as $test_class => $class_file ) {

			$file = wpe_phpcompat_get_class_file( $test_class );

			$this->assertEquals( $class_file, $file );

		}
	}
}
