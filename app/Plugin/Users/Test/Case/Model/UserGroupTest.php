<?php
App::uses('UserGroup', 'Users.Model');

/**
 * UserGroup Test Case
 *
 */
class UserGroupTestCase extends CakeTestCase {
/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.Aro',
		'plugin.Users.User',
		'plugin.Users.UserGroup',
		'plugin.Users.UsersUserGroup',
		'plugin.Users.Used',
		'plugin.Contacts.Contact',
		);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->UserGroup = ClassRegistry::init('Users.UserGroup');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->UserGroup);
		parent::tearDown();
	}
	
	public function testSave() {
		$count = $this->UserGroup->find('count');
		$this->UserGroup->save(array('UserGroup' => array('title' => 'Test User Group')));
		$newCount = $this->UserGroup->find('count');
		$this->assertTrue($count < $newCount);
	}
    
	public function testUser() {
		$userGroupId = '3091823';
		$this->UserGroup->save(array('UserGroup' => array('id' => $userGroupId, 'title' => 'Test User Group')));
		//debug($this->UserGroup->User->find('all'));
		$data = array(
			'UserGroup' => array(
				'UserGroup' => array(
					(int) 0 => $userGroupId
					)
				),
			'User' => array(
				'first_name' => 'Joe',
				'last_name' => 'Montana',
				'username' => 'joe-montana@example.com',
				)
			);
		$this->UserGroup->user($data); // add user
		$result = $this->UserGroup->User->find('first', array('conditions' => array('User.id' => $this->UserGroup->User->id), 'contain' => array('UserGroup')));
		$this->assertEqual($result['UserGroup'][0]['id'], $userGroupId);
	}
	
}
