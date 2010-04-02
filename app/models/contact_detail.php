<?php
class ContactDetail extends AppModel {

	var $name = 'ContactDetail';
	var $validate = array(
		'contact_detail_type_id' => array('numeric'),
		'value' => array('notempty')
	);

	//The Associations below have been created with all possible keys, those that are not needed can be removed
	var $belongsTo = array(
		'ContactDetailType' => array(
			'className' => 'ContactDetailType',
			'foreignKey' => 'contact_detail_type_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Contact' => array(
			'className' => 'Contact',
			'foreignKey' => 'contact_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Creator' => array(
			'className' => 'User',
			'foreignKey' => 'creator_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Modifier' => array(
			'className' => 'User',
			'foreignKey' => 'modifier_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

}
?>