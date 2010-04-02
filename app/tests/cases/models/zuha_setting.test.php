<?php 
/* SVN FILE: $Id$ */
/* ZuhaSetting Test cases generated on: 2009-12-14 10:13:58 : 1260803638*/
App::import('Model', 'ZuhaSetting');

class ZuhaSettingTestCase extends CakeTestCase {
	var $ZuhaSetting = null;
	var $fixtures = array('app.zuha_setting');

	function startTest() {
		$this->ZuhaSetting =& ClassRegistry::init('ZuhaSetting');
	}

	function testZuhaSettingInstance() {
		$this->assertTrue(is_a($this->ZuhaSetting, 'ZuhaSetting'));
	}

	function testZuhaSettingFind() {
		$this->ZuhaSetting->recursive = -1;
		$results = $this->ZuhaSetting->find('first');
		$this->assertTrue(!empty($results));

		$expected = array('ZuhaSetting' => array(
			'id'  => 1,
			'name'  => 'Lorem ipsum dolor sit amet',
			'value'  => 'Lorem ipsum dolor sit amet',
			'created'  => '2009-12-14 10:13:58',
			'modified'  => '2009-12-14 10:13:58'
		));
		$this->assertEqual($results, $expected);
	}
}
?>