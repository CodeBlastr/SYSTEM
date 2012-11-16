<?php
App::uses('AppModel', 'Model');

class Alias extends AppModel {

	public $name = 'Alias';
	
	public $validate = array(
		'name' => array(
			'notemptyRule' => array(
			   'rule' =>'notempty',
			   'message' => 'must have a value'
			),
			'uniqueRule' => array(
			   'rule' =>'isUnique',
			   'message' => 'must be unique'
			),
			'alphaNumericDashUnderscore' => array(
			   'rule' => '|^[0-9a-zA-Z\._/-]*$|',
			   'message' => 'can only be letters, numbers, underscores, slashes, or periods'
			)
		),
	);
	
	public function beforeValidate($options = array()) {
		$this->data = $this->cleanInputData($this->data);
		return parent::beforeValidate($options);
	}
	
/**
 * Clean Input Data
 * Before saving we need to check the data for consistency.
 *
 * @param array
 * @return array
 * @todo Clean out alias data for templates and elements.
 */
	public function cleanInputData($data) {
		if (empty($data['Alias']['name'])) {
			// remove the alias if the name is blank
			unset($data['Alias']);
		}
		
		return $data;
	}

}
