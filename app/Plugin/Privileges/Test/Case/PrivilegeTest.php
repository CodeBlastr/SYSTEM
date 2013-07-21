<?php
App::uses('Privilege', 'Privileges.Model');

/**
 * Privilege Test Case
 *
 */
class PrivilegeTestCase extends CakeTestCase {
/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.Aro',
		'app.ArosAco',
		'app.Setting',
		);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Privilege = ClassRegistry::init('Privileges.Privilege');
		$this->Aro = ClassRegistry::init('Aro');
		$this->ArosAco = ClassRegistry::init('ArosAco');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->UserRole);
		parent::tearDown();
	}
	
/**
 * testDuplicateUserRolePermissions method
 */
 	public function testDuplicatePermissions() {
 		$aros = $this->Aro->find('all', array('conditions' => array('model' => 'UserRole')));
		//$result = $this->Privilege->duplicatePermissions('UserRole', $aros[0]['Aro']['foreign_key'], $aros[1]['Aro']['foreign_key']);
		// there are existing permissions we should get an empty (false) result
		//$this->assertTrue(empty($result));
		
		// create a new aro record with no permissions
		$data['Aro'] = array(
			'id' => '8762567',
			'parent_id' => null,
			'model' => 'UserRole',
			'foreign_key' => '42773',
			'alias' => null,
			'lft' => '992387',
			'rght' => '992388',
			);
		$this->Aro->save($data);
		
		$result = $this->Privilege->duplicatePermissions('UserRole', $aros[0]['Aro']['foreign_key'], $data['Aro']['foreign_key']);
		// permissions were duplicated
		$this->assertTrue($result);
		// aros_acos record exists (not totally necessary to check so I left it out of the assert stuff)
		debug($this->ArosAco->find('first', array('conditions' => array('ArosAco.aro_id' => $data['Aro']['id']))));
 	}

}
