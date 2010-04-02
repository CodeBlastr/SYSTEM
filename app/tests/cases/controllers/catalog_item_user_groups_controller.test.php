<?php 
/* SVN FILE: $Id$ */
/* CatalogItemUserGroupsController Test cases generated on: 2009-12-13 23:33:13 : 1260765193*/
App::import('Controller', 'CatalogItemUserGroups');

class TestCatalogItemUserGroups extends CatalogItemUserGroupsController {
	var $autoRender = false;
}

class CatalogItemUserGroupsControllerTest extends CakeTestCase {
	var $CatalogItemUserGroups = null;

	function startTest() {
		$this->CatalogItemUserGroups = new TestCatalogItemUserGroups();
		$this->CatalogItemUserGroups->constructClasses();
	}

	function testCatalogItemUserGroupsControllerInstance() {
		$this->assertTrue(is_a($this->CatalogItemUserGroups, 'CatalogItemUserGroupsController'));
	}

	function endTest() {
		unset($this->CatalogItemUserGroups);
	}
}
?>