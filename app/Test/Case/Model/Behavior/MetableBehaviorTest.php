<?php
/* Metable Test cases generated on: 2012-04-13 19:19:39 : 1334344779*/
App::uses('MetableBehavior', 'Model/Behavior');


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
		public $actsAs = array('Metable');
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
 * MetableBehaviorTestCase Test Case
 *
 */
class MetableBehaviorTestCase extends CakeTestCase {
/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.Meta',
		'app.Article',
		);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Metable = new MetableBehavior();
		$this->Article = Classregistry::init('Article');
		$this->Meta = Classregistry::init('Meta');
	}
	
	

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Metable);
		unset($this->Article);
		unset($this->Meta);
		ClassRegistry::flush();

		parent::tearDown();
	}
	

/**
 * Test behavior instance
 *
 * @return void
 */
	public function testBehaviorInstance() {
		$this->assertTrue(is_a($this->Article->Behaviors->Metable, 'MetableBehavior'));
	}
	
/**
 * Test saving records and updating results
 */ 
	public function testAdd() {
		
		$data = array('Article' => array(
			'title' => 'Lorem 222',
			'!location' => 'Syracuse',
			'!food' => 'turkey',
			'!fireproof' => 'no',
			'!rent' => 535,
			'!state' => 'NY',
		));
		$this->Article->saveAll($data);
		$result = $this->Article->find('first', array('conditions' => array('Article.id' => $this->Article->id)));
		// tests that an article was saved, and that the meta info submitted was also saved (and of course returned in proper format)
		$this->assertEqual(!empty($result['Article']['!location']), true);
	}
	
	
	public function testEdit() {
		$data = array('Article' => array(
			'title' => 'Lorem 111',
			'content' => 'asdf aasdfsdfaasd',
			'!location' => 'Syracuse',
			'!food' => 'turkey',
			'!fireproof' => 'no',
			'!rent' => 535,
			'!state' => 'NY',
		));
		
		$this->Article->saveAll($data);
		$testId = $this->Article->id;
		$result = Set::combine($this->Article->find('all'), '{n}.Article.id', '{n}.Article.!rent');
		// asserts that the first save is complete
		$this->assertEqual($result[$testId], $data['Article']['!rent']);
		
		$data = array('Article' => array(
			'id' => $this->Article->id,
			'title' => 'Lorem 222',
			'content' => 'asdf aasdfsdfaasd',
			'!location' => 'loc',
			'!food' => 'turkdaey',
			'!fireproof' => 'no',
			'!rent' => 111,
			'!state' => 'CA',
		));
		
		$result = $this->Article->saveAll($data);
		$result = Set::combine($this->Article->find('all'), '{n}.Article.id', '{n}.Article.!rent');
		// asserts that the same ID from the first save has an updated rent value from the second save
		$this->assertEqual($result[$testId], $data['Article']['!rent']);
	}
	
	
	public function testMetaSearchOnlyTypeFirst() {
		
		$data = array(
			array('Article' => array(
				'title' => 'Lorem 333',
				'content' => 'abcdefg',
				'!location' => 'Geneva',
				'!food' => 'turkey',
				'!fireproof' => 'no',
				'!rent' => 535,
				'!state' => 'NY',
				)),
			array('Article' => array(
				'title' => 'Lorem',
				'content' => 'asdf aasdfsdfaasd',
				'!location' => 'Syracuse',
				'!food' => 'turkey',
				'!fireproof' => 'no',
				'!rent' => 535,
				'!state' => 'NY',
				)),
			array('Article' => array(
				'title' => 'Lorem 333',
				'content' => 'bcdefg',
				'!location' => 'Austin',
				'!food' => 'turkey',
				'!fireproof' => 'no',
				'!rent' => 535,
				'!state' => 'NY',
				)),
			);
		
		$this->Article->saveAll($data);
		
		$result = $this->Article->find('first', array(
			'conditions' => array(
				'Article.!location' => 'Syracuse'
			),
		));
		// we insert a few records, then run a search based on a meta field only
		$this->assertEqual($result['Article']['!location'], $data[1]['Article']['!location']);
		
	}
	
	
	public function testNonMetaSearchTypeFirst() {
		
		$data = array(
			array('Article' => array(
				'title' => 'Lorem 333',
				'content' => 'abcdefg',
				'!location' => 'Geneva',
				'!food' => 'turkey',
				'!fireproof' => 'no',
				'!rent' => 535,
				'!state' => 'NY',
				)),
			array('Article' => array(
				'title' => 'Lorem',
				'content' => 'asdf aasdfsdfaasd',
				'!location' => 'Syracuse',
				'!food' => 'turkey',
				'!fireproof' => 'no',
				'!rent' => 535,
				'!state' => 'NY',
				)),
			array('Article' => array(
				'title' => 'Lorem 333',
				'content' => 'bcdefg',
				'!location' => 'Austin',
				'!food' => 'turkey',
				'!fireproof' => 'no',
				'!rent' => 535,
				'!state' => 'NY',
				)),
			);
		
		$this->Article->saveAll($data);
		
		$result = $this->Article->find('first', array(
			'conditions' => array(
				'Article.title' => 'Lorem 333',
			),
			'order' => array(
				'Article.content' => 'DESC'
			)
		));
		// we insert a few records, then run a search based on a meta field only
		$this->assertEqual($result['Article']['!location'], $data[2]['Article']['!location']);
	}
    
/**
 * Test deleting records
 */ 
    public function testDelete() {
		
		$data = array('Article' => array(
			'title' => 'Lorem 222',
			'!location' => 'Syracuse',
			'!food' => 'turkey',
			'!fireproof' => 'no',
			'!rent' => 535,
			'!state' => 'NY',
		));
		$this->Article->saveAll($data);
        $id = $this->Article->id;
        $result = $this->Meta->find('first', array('conditions' => array('Meta.foreign_key' => $id)));
        $metaLookup = array('Meta.foreign_key' => $result['Meta']['foreign_key'], 'Meta.model' => $result['Meta']['model']);
        $this->assertTrue(!empty($result)); // make sure meta data was created
        
        $this->Article->delete($id);
    	$article = $this->Article->findById($id);
        $this->assertTrue(empty($article)); // make sure article is gone
        $result = $this->Meta->find('first', array('conditions' => $metaLookup));
        $this->assertTrue(empty($result));
	}

}
