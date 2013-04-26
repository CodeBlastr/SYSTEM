<?php
App::uses('Gallery', 'Galleries.Model');

/**
 * Gallery Test Case
 *
 */
class GalleryTestCase extends CakeTestCase {
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
		$this->Gallery = ClassRegistry::init('Galleries.Gallery');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Gallery);

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
 * testMakeThumb method
 *
 * @return void
 */
	public function testMakeThumb() {

        $firstResult = $this->Gallery->find('first', array('Conditions' => array('Gallery.id' => 1)));
        $this->assertTrue(!empty($firstResult['Gallery']['gallery_thumb_id'])); // test that gallery exists to edit

        $data['Gallery']['id'] = 1;
        $data['GalleryImage']['id'] = 23113;

        $secondResult = $this->Gallery->makeThumb($data);
        $this->assertEqual(true, $secondResult); // test that save occured

        $thirdResult = $this->Gallery->find('first', array('Conditions' => array('Gallery.gallery_thumb_id' => $data['GalleryImage']['id'])));
        $this->assertTrue(!empty($thirdResult)); // did the gallery_thumnb_id get updated?

        $this->assertNotEqual($firstResult['Gallery']['gallery_thumb_id'], $thirdResult['Gallery']['gallery_thumb_id']); //test that gallery thumbs are changed

	}

/**
 * testTypes method
 *
 * @return void
 */
	public function testTypes() {

	}
}
