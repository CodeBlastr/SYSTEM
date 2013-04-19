<?php
App::uses('GalleryImage', 'Galleries.Model');

/**
 * GalleryImage Test Case
 *
 */
class GalleryImageTestCase extends CakeTestCase {
/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.Galleries.gallery',
		);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->GalleryImage = ClassRegistry::init('Galleries.GalleryImage');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->GalleryImage);

		parent::tearDown();
	}

/**
 * testAdd method
 *
 * @return void
 */
	public function testAdd() {

	}
/**
 * testGalleryImageDefaults method
 *
 * @return void
 */
	public function testGalleryImageDefaults() {

	}
}
