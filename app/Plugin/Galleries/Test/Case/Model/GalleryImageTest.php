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
		'plugin.Galleries.Gallery',
        'plugin.Galleries.GalleryImage',
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
		$data = array('GalleryImage' => array('filename' => array('image.jpg')));
		try {
			$result = $this->GalleryImage->add($data, 'filename');
		} catch (Exception $e) {
			// Should throw an error with a message like "ERROR : invalid file type"
			$this->assertTrue(is_int(strpos($e->getMessage(), 'RROR')));
		}
	}
/**
 * testGalleryImageDefaults method
 *
 * @return void
 */
	public function testGalleryImageDefaults() {

	}
}
