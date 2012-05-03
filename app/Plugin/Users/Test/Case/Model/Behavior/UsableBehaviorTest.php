<?php
App::uses('UsableBehavior', 'Users.Model/Behavior');

if (!class_exists('Article')) {
	class Article extends CakeTestModel {
	/**
	 *
	 */
		public $callbackData = array();

	/**
	 *
	 */
		public $actsAs = array(
			'Users.Usable' => array(
				'defaultRole' => 'author',
				),
			);
	/**
	 *
	 */
		public $useTable = 'articles';
	
	/**
	 * Fixtures
	 *
	 * @var array
	 */
		public $fixtures = array(
			'core.article',
			);

	/**
	 *
	 */
		public $name = 'Article';
	}
}

/**
 * UsableBehavior Test Case
 *
 */
class UsableBehaviorTestCase extends CakeTestCase {
/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.Users.used',
		'core.article',
		);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Usable = new UsableBehavior();
		$this->Model = Classregistry::init('Article'); // not tied to an actual model file
		$this->Used = ClassRegistry::init('Users.Used'); // not tied to an actual model file
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Usable);

		parent::tearDown();
	}

/**
 * testFindUsedObjects method
 *
 * @return void
 */
	public function testFindUsedObjects() {

	}
/**
 * testFindUsedUsers method
 *
 * @return void
 */
	public function testFindUsedUsers() {

	}
	
/**
 * testAddUsedUser method
 *
 * @return void
 */
	public function testAddUsedUser() {
		$data['Used']['user_id'] = 6;
		$data['Used']['model'] = 'Article';
		$data['Used']['foreign_key'] = '4f8c626b-8g8c-4c77-8bc1-1010124e0d46';
		try {
			$this->Model->addUsedUser($data);
		} catch (Exception $e) {
			$result = $e->getMessage(); 
		}
		$this->assertEqual('User is already involved', $result); // we should get an exception because we're trying to add a record which already has a Used record.
		
		$data['Used']['user_id'] = 789;
		$data['Used']['model'] = 'Article';
		$data['Used']['foreign_key'] = '4f8c626b-8g8c-4c77-8bc1-1010124e0d46';
		$result = $this->Model->addUsedUser($data);
		$this->assertTrue($result); // with a brand new user id we should have no problem adding a user to an existing article.
	}
	
/**
 * testAfterFind method
 *
 * @return void
 */
	public function testAfterFind() {
		$article = array(
			'Article' => array(
				'title' => 'Lorem ipsum',
				'body' => 'Lorem ipsum',
				'published' => 1,
				),
			'User' => array(
				array(
					'id' => 838239,
					),
				array(
					'id' => 38989128,
					),
				),
			);
		
		$this->Model->save($article);
		$articleId = $this->Model->id;
		
		CakeSession::write('Auth.User.id', 7); // set user id
		$result = $this->Model->find('all', array(
			'conditions' => array(
				'Article.id' => $articleId,
				),
			));
		$this->assertTrue(empty($result)); // test that result is empty because our user id is not 838239, or 38989128
		
		
		CakeSession::write('Auth.User.id', 838239); // set user id
		$result = $this->Model->find('all', array(
			'conditions' => array(
				'Article.id' => $articleId,
				),
			));
		$this->assertTrue(!empty($result)); // should now be filled because the user id is now set
		$this->assertTrue(!empty($result[0]['Article']['__used'])); // test that the __used field exists and is filled
		
		
		CakeSession::write('Auth.User.id', 38989128); // set user id
		$result = $this->Model->find('first', array(
			'conditions' => array(
				'Article.id' => $articleId,
				),
			));
		$this->assertGreaterThan(1, $result['Article']['__used']); // test that it works with single records as well
		
		CakeSession::destroy();
	}
	
	
/**
 * testRemoveUsedUser method
 *
 * @return void
 */
	public function testRemoveUsedUser() {

	}
	
/**
 * testGetChildContacts method
 *
 * @return void
 */
	public function testGetChildContacts() {

	}
	
/**
 * testPrivatize method
 *
 * @return void
 */
	public function testPrivatize() {
		$result = $this->Used->find('all', array(
			'conditions' => array(
				'Used.foreign_key' => '2345678903242323',
				'Used.model' => 'Article', 
				),
			));
		$this->assertTrue(empty($result)); // there should be no records for this id now, it is current public
		
		$data['Used']['user_id'] = 1;
		$data['Used']['foreign_key'] = '2345678903242323';
		$this->Model->privatize($data);
		
		$result = $this->Used->find('all', array(
			'conditions' => array(
				'Used.foreign_key' => '2345678903242323',
				'Used.model' => 'Article', 
				),
			));
		$this->assertTrue(!empty($result)); // there should now be a record for the above id in the used table
	}
	
/**
 * testPublicize method
 *
 * @return void
 */
	public function testPublicize() {
		$result = $this->Used->find('all', array(
			'conditions' => array(
				'Used.foreign_key' => '4f278d38-8224-46e5-a9b2-0c79124e0d46',
				'Used.model' => 'Project', 
				),
			));
		$this->assertGreaterThan(1, count($result)); // there should be at least two used records for this id
		
		$data['Used']['foreign_key'] = '4f278d38-8224-46e5-a9b2-0c79124e0d46';
		$this->Model->publicize($data);
		
		$result = $this->Used->find('all', array(
			'conditions' => array(
				'Used.foreign_key' => '4f278d38-8224-46e5-a9b2-0c79124e0d46',
				'Used.model' => 'Project', 
				),
			));
		
		$this->assertTrue(empty($result)); // there should be no records for this id now, it has been made public

	}
}
