<?php
App::uses('User', 'Users.Model');

/**
 * UserRole Test Case
 *
 */
class UserTestCase extends CakeTestCase {
/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.Aro',
		'plugin.Users.User',
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
		$this->User = ClassRegistry::init('Users.User');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->User);

		parent::tearDown();
	}
    
	public function testAdd() {
		$data = array(
			'User' => array(
				'password' => 'asdDDFEF234424fasdf',
				'username' => 'byrnes.joel@gmail.com',
				'email' => 'byrnes.joel@gmail.com',
				'facebook_id' => '1102252405',
				'first_name' => 'Joel',
				'last_name' => 'Byrnes',
				'full_name' => 'Joel Byrnes',
				'user_role_id' => '3',
				'contact_type' => 'person',
				'forgot_key' => null,
				'forgot_key_created' => '2013-04-26 01:32:16',
				'parent_id' => '',
				'reference_code' => '2quif40p'
			),
			'Contact' => array(
				'name' => 'Joel Byrnes',
//				'contact_type' => 'person',
			)
		);
		
		try {
			$this->User->add($data);
			
		} catch (Exception $exc) {
			echo $exc->getTraceAsString();
		}

		
		
		$users = $this->User->find('all');
		$contacts = $this->User->Contact->find('first', array('conditions' => array('Contact.name' => $data['User']['full_name']) ));
		
		debug($users);
		debug($contacts);
		break;
	}


}
