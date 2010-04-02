<?php 
/* SVN FILE: $Id$ */
/* ContactRelationshipType Test cases generated on: 2010-01-04 13:48:42 : 1262630922*/
App::import('Model', 'ContactRelationshipType');

class ContactRelationshipTypeTestCase extends CakeTestCase {
	var $ContactRelationshipType = null;
	var $fixtures = array('app.contact_relationship_type', 'app.contacts_relationship');

	function startTest() {
		$this->ContactRelationshipType =& ClassRegistry::init('ContactRelationshipType');
	}

	function testContactRelationshipTypeInstance() {
		$this->assertTrue(is_a($this->ContactRelationshipType, 'ContactRelationshipType'));
	}

	function testContactRelationshipTypeFind() {
		$this->ContactRelationshipType->recursive = -1;
		$results = $this->ContactRelationshipType->find('first');
		$this->assertTrue(!empty($results));

		$expected = array('ContactRelationshipType' => array(
			'id'  => 1,
			'name'  => 'Lorem ipsum dolor sit amet',
			'description'  => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida,phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam,vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit,feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
			'created'  => '2010-01-04 13:48:41',
			'modified'  => '2010-01-04 13:48:41'
		));
		$this->assertEqual($results, $expected);
	}
}
?>