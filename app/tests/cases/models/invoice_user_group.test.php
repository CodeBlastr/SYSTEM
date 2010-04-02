<?php 
/* SVN FILE: $Id$ */
/* InvoiceUserGroup Test cases generated on: 2009-12-14 00:46:45 : 1260769605*/
App::import('Model', 'InvoiceUserGroup');

class InvoiceUserGroupTestCase extends CakeTestCase {
	var $InvoiceUserGroup = null;
	var $fixtures = array('app.invoice_user_group', 'app.user_group', 'app.invoice');

	function startTest() {
		$this->InvoiceUserGroup =& ClassRegistry::init('InvoiceUserGroup');
	}

	function testInvoiceUserGroupInstance() {
		$this->assertTrue(is_a($this->InvoiceUserGroup, 'InvoiceUserGroup'));
	}

	function testInvoiceUserGroupFind() {
		$this->InvoiceUserGroup->recursive = -1;
		$results = $this->InvoiceUserGroup->find('first');
		$this->assertTrue(!empty($results));

		$expected = array('InvoiceUserGroup' => array(
			'id'  => 1,
			'user_group_id'  => 1,
			'invoice_id'  => 1,
			'created'  => '2009-12-14 00:46:45',
			'modified'  => '2009-12-14 00:46:45'
		));
		$this->assertEqual($results, $expected);
	}
}
?>