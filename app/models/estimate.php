<?php
class Estimate extends AppModel {
	var $name = 'Estimate';
	var $displayField = 'name';
	var $validate = array(
		'name' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'is_accepted' => array(
			'boolean' => array(
				'rule' => array('boolean'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'is_archived' => array(
			'boolean' => array(
				'rule' => array('boolean'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
	);
	//The Associations below have been created with all possible keys, those that are not needed can be removed

	var $belongsTo = array(
		'EstimateType' => array(
			'className' => 'Enumeration',
			'foreignKey' => false,
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'EstimateStatus' => array(
			'className' => 'Enumeration',
			'foreignKey' => 'estimate_status_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Recipient' => array(
			'className' => 'Users.User',
			'foreignKey' => 'recipient_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Creator' => array(
			'className' => 'Users.User',
			'foreignKey' => 'creator_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Modifier' => array(
			'className' => 'Users.User',
			'foreignKey' => 'modifier_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

	var $hasMany = array(
		'EstimateItem' => array(
			'className' => 'EstimateItem',
			'foreignKey' => 'estimate_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'Estimated' => array(
			'className' => 'Estimated',
			'foreignKey' => 'estimate_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		)
	);
	
	
	function beforeSave() {
		# give the estimate a name for easy drop down fields in other parts
		if (!empty($this->data['Estimate']['id'])) {
			if (!empty($this->data['Estimate']['estimate_number'])) {
				$this->data['Estimate']['name'] = __('Estimate: ', true).$this->data['Estimate']['estimate_number'];
			} else {
				$this->data['Estimate']['name'] = __('Estimate: ', true).$this->data['Estimate']['id'];
			}
		}
		return true;
	}

}
?>