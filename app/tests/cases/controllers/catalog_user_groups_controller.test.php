<?php 
/* SVN FILE: $Id$ */
/* CatalogUserGroupsController Test cases generated on: 2009-12-13 23:33:29 : 1260765209*/
App::import('Controller', 'CatalogUserGroups');

class TestCatalogUserGroups extends CatalogUserGroupsController {
	var $autoRender = false;
}

class CatalogUserGroupsControllerTest extends CakeTestCase {
	var $CatalogUserGroups = null;

	function startTest() {
		$this->CatalogUserGroups = new TestCatalogUserGroups();
		$this->CatalogUserGroups->constructClasses();
	}

	function testCatalogUserGroupsControllerInstance() {
		$this->assertTrue(is_a($this->CatalogUserGroups, 'CatalogUserGroupsController'));
	}

	function endTest() {
		unset($this->CatalogUserGroups);
	}
}
?>