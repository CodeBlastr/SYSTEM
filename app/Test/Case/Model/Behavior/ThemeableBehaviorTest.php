<?php
App::uses('ThemeableBehavior', 'Model/Behavior');


if (!class_exists('Article')) {
   App::uses('AppModel', 'Model');
	class Article extends AppModel {
	/**
	 *
	 */
		public $callbackData = array();

	/**
	 *
	 */
		public $actsAs = array('Themeable');
	/**
	 *
	 */
		public $useTable = 'articles';

	/**
	 *
	 */
		public $name = 'Article';
	/**
	 *
	 */
		public $alias = 'Article';
		
		
	}
}


/**
* ThemeableBehaviorTestCase Test Case
*
*/
class ThemeableBehaviorTestCase extends CakeTestCase {
/**
* Fixtures
*
* @var array
*/
	public $fixtures = array(
		'Article',
		'app.Template'
		);

/**
* setUp method
*
* @return void
*/
	public function setUp() {
		parent::setUp();
		//$this->Themeable = new MetableBehavior();
		$this->Article = Classregistry::init('Article');
		$this->Template = Classregistry::init('Template');
	}
	
	

/**
* tearDown method
*
* @return void
*/
	public function tearDown() {
		//unset($this->Metable);
		unset($this->Article);
		unset($this->Template);
		ClassRegistry::flush();

		parent::tearDown();
	}
	

/**
* Test behavior instance
*
* @return void
*/
	public function testBehaviorInstance() {
		$this->assertTrue(is_a($this->Article->Behaviors->Themeable, 'ThemeableBehavior'));
	}
	
/**
* Test saving records and updating results
*/ 
	public function testAdd() {
		$data = array(
			'Article' => array(
				'user_id' => '1',
				'title' => 'Mathematics 101',
				'body' => 'Mathematics 101 Body',
				'published' => 'Y',
			),
			'Template' => array(
				'layout' => 'twitter-bootstrap'
			)
		);
		
		// see if a templates record was created
		$this->Article->save($data);
		$this->assertEqual(1, $this->Template->find('count', array('conditions' => array('Template.layout' => $data['Template']['layout'], 'Template.model' => $this->Article->name, 'Template.foreign_key' => $this->Article->id))));
		
		// make sure the theme variable is set for the article model
		$this->Article->find('first', array('conditions' => array('Article.id' => $this->Article->id)));
		$this->assertEqual($data['Template']['layout'], $this->Article->theme['Article']['_layout']);
	}
	
	

}
