<?php 
/* SVN FILE: $Id$ */
/* CatalogBrandUserGroupsController Test cases generated on: 2009-12-13 23:32:13 : 1260765133*/
App::import('Controller', 'CatalogBrandUserGroups');

class TestCatalogBrandUserGroups extends CatalogBrandUserGroupsController {
	var $autoRender = false;
}

class CatalogBrandUserGroupsControllerTest extends CakeTestCase {
	var $CatalogBrandUserGroups = null;

	function startTest() {
		$this->CatalogBrandUserGroups = new TestCatalogBrandUserGroups();
		$this->CatalogBrandUserGroups->constructClasses();
	}

	function testCatalogBrandUserGroupsControllerInstance() {
		$this->assertTrue(is_a($this->CatalogBrandUserGroups, 'CatalogBrandUserGroupsController'));
	}

	function endTest() {
		unset($this->CatalogBrandUserGroups);
	}
}
?>