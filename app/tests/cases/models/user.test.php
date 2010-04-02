<?php 
/* SVN FILE: $Id$ */
/* User Test cases generated on: 2010-01-03 20:40:53 : 1262569253*/
App::import('Model', 'User');

class UserTestCase extends CakeTestCase {
	var $User = null;
	var $fixtures = array('app.user', 'app.user_group', 'app.contact');

	function startTest() {
		$this->User =& ClassRegistry::init('User');
	}

	function testUserInstance() {
		$this->assertTrue(is_a($this->User, 'User'));
	}

	function testUserFind() {
		$this->User->recursive = -1;
		$results = $this->User->find('first');
		$this->assertTrue(!empty($results));

		$expected = array('User' => array(
			'id'  => 1,
			'username'  => 'Lorem ipsum dolor sit amet',
			'password'  => 'Lorem ipsum dolor sit amet',
			'last_login'  => '2010-01-03 20:40:52',
			'user_group_id'  => 1,
			'contact_id'  => 1,
			'created'  => '2010-01-03 20:40:52',
			'modified'  => '2010-01-03 20:40:52'
		));
		$this->assertEqual($results, $expected);
	}
}
?>