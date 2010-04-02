<?php 
/* SVN FILE: $Id$ */
/* ProjectIssuesController Test cases generated on: 2009-12-30 13:13:13 : 1262196793*/
App::import('Controller', 'ProjectIssues');

class TestProjectIssues extends ProjectIssuesController {
	var $autoRender = false;
}

class ProjectIssuesControllerTest extends CakeTestCase {
	var $ProjectIssues = null;

	function startTest() {
		$this->ProjectIssues = new TestProjectIssues();
		$this->ProjectIssues->constructClasses();
	}

	function testProjectIssuesControllerInstance() {
		$this->assertTrue(is_a($this->ProjectIssues, 'ProjectIssuesController'));
	}

	function endTest() {
		unset($this->ProjectIssues);
	}
}
?>