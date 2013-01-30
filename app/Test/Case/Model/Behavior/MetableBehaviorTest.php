<?php
/* Metable Test cases generated on: 2012-04-13 19:19:39 : 1334344779*/
App::uses('MetableBehavior', 'Model/Behavior');


if (!class_exists('MetaArticle')) {
	App::uses('AppModel', 'Model');
	class MetaArticle extends AppModel {
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
		$this->Article = Classregistry::init('MetaArticle');
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
			'Meta' => array(
					'location' => 'Syracuse',
					'food' => 'turkey',
					'fireproof' => 'no',
					'rent' => 535,
					'state' => 'NY'
					)
		));
		$this->Article->saveAll($data);
		$result = $this->Article->find('first', array('conditions' => array('Article.id' => $this->Article->id)));
		// tests that an article was saved, and that the meta info submitted was also saved (and of course returned in proper format)
		$this->assertEqual(!empty($result['Article']['!location']), true);
	}
	
	
	public function testEdit() {
		$dataOne = array('Article' => array(
			'title' => 'Lorem 111',
			'content' => 'asdf aasdfsdfaasd',
			'Meta' => array(
					'location' => 'Syracuse',
					'food' => 'turkey',
					'fireproof' => 'no',
					'rent' => 535,
					'state' => 'NY'
					)
		));
		
		$this->Article->saveAll($dataOne);
		$resultOne = Set::combine($this->Article->find('all'), '{n}.Article.id', '{n}.Article.!rent');
		// asserts that the first save is complete
		$this->assertEqual($resultOne[$this->Article->id], $dataOne['Article']['!rent']);
		
		$dataTwo = array('Article' => array(
			'id' => $this->Article->id,
			'title' => 'Lorem 222',
			'content' => 'asdf aasdfsdfaasd',
			'Meta' => array(
					'rent' => 111,
					)
		));
		
		$resultTwo = $this->Article->saveAll($dataTwo);
		$resultTwo = Set::combine($this->Article->find('all'), '{n}.Article.id', '{n}.Article.!rent');

		// asserts that the same ID from the first save has an updated rent value from the second save
		//$this->assertNotEqual($resultOne[$testId], $data2['Article']['!rent']);
		$this->assertNotEqual($resultOne[$this->Article->id], $resultTwo[$this->Article->id]);
	}
	
	
	public function testMetaSearchOnlyTypeFirst() {
		
		$data = array(
			array('Article' => array(
				'title' => 'Lorem 333',
				'content' => 'abcdefg',
				'Meta' => array(
					'location' => 'Geneva',
					'food' => 'turkey',
					'fireproof' => 'no',
					'rent' => 535,
					'state' => 'NY'
					)
				)),
			array('Article' => array(
				'title' => 'Lorem',
				'content' => 'asdf aasdfsdfaasd',
				'Meta' => array(
					'location' => 'Syracuse',
					'food' => 'turkey',
					'fireproof' => 'no',
					'rent' => 535,
					'state' => 'NY'
					)
				)),
			array('Article' => array(
				'title' => 'Lorem 333',
				'content' => 'bcdefg',
				'Meta' => array(
					'location' => 'Austin',
					'food' => 'turkey',
					'fireproof' => 'no',
					'rent' => 535,
					'state' => 'NY'
					)
				))
			);
//		debug($data);
		$this->Article->saveAll($data);
		
		$result = $this->Article->find('first', array(
			'conditions' => array(
				'Article.Meta.location' => 'Syracuse'
			),
		));
//		debug($result);
//		break;
		// we insert a few records, then run a search based on a meta field only
		$this->assertEqual(
				$result['Article']['Meta']['location'],
				$data[1]['Article']['Meta']['location']
				);
		
	}
	
	
	public function testNonMetaSearchTypeFirst() {
		
		$data = array(
			array('Article' => array(
				'title' => 'Lorem 333',
				'content' => 'abcdefg',
				'Meta' => array(
					'location' => 'Geneva',
					'food' => 'turkey',
					'fireproof' => 'no',
					'rent' => 535,
					'state' => 'NY'
					)
				)),
			array('Article' => array(
				'title' => 'Lorem',
				'content' => 'asdf aasdfsdfaasd',
				'Meta' => array(
					'location' => 'Syracuse',
					'food' => 'turkey',
					'fireproof' => 'no',
					'rent' => 535,
					'state' => 'NY'
					)
				)),
			array('Article' => array(
				'title' => 'Lorem 333',
				'content' => 'bcdefg',
				'Meta' => array(
					'location' => 'Austin',
					'food' => 'turkey',
					'fireproof' => 'no',
					'rent' => 535,
					'state' => 'NY'
					)
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
			'Meta' => array(
					'location' => 'Syracuse',
					'food' => 'turkey',
					'fireproof' => 'no',
					'rent' => 535,
					'state' => 'NY'
					)
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
        $this->assertTrue(empty($result)); // make sure meta is gone
	}

}
