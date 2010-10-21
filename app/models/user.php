<?php

############### PERMISSIONS TUTORIAL ########################
# http://book.cakephp.org/view/647/An-Automated-tool-for-creating-ACOs
#############################################################


class User extends AppModel {

	var $name = 'User';
	var $userField = array();
	// Does this model requires user level access
	var $userLevel = false;
	var $validate = array(
		'username' => array(
			'notempty' => array(
				'rule' => 'notEmpty',
				'message' => 'Please Enter a value for Username'
			),
			'isUnique' => array(
				'rule' => 'isUnique',
				'message' => 'This Username belongs to someone else. Please try again.'
			),
		),
		'password' => array(
			'notempty' => array(
				'rule' => 'notEmpty',
				'message' => 'Please Enter a value for Password'
			),
			'comparePassword' => array(
				'rule' => array('__comparePassword'),
				'message' => 'Password, and Password Confirmation did not match.'
			),
		),
	);
	var $displayField = 'username';
	var $actsAs = array('Acl' => 'requester');
	
	function parentNode() {
   		if (!$this->id && empty($this->data)) {
	        return null;
	    }
	    $data = $this->data;
	    if (empty($this->data)) {
	        $data = $this->read();
	    }
	    if (!$data['User']['user_group_id']) {
	        return null;
	    } else {
	        return array('UserGroup' => array('id' => $data['User']['user_group_id']));
	    }
	}
	
	/**    
	 * After save callback
	 * Update the aro for the user.
	 * @access public
	 * @return void
	 */
	function afterSave($created) {
        if (!$created) {
            $parent = $this->parentNode();
            $parent = $this->node($parent);
            $node = $this->node();
            $aro = $node[0];
            $aro['Aro']['parent_id'] = $parent[0]['Aro']['id'];
            $this->Aro->save($aro);
        }
	}
	
	function beforeValidate() {
		if (isset($this->data['User']['confirm_password'])) {
			$this->data['User']['confirm_password'] = Security::hash($this->data['User']['confirm_password'],'', true);
		}
	}
	
	function __comparePassword() {
		# fyi, confirm password is hashed in the beforeValidate method
		if (!empty($this->data['User']['confirm_password']) && $this->data['User']['password'] == $this->data['User']['confirm_password']) {
			return true;
		} else {
			return false;
		}
	}

	//The Associations below have been created with all possible keys, those that are not needed can be removed
	var $belongsTo = array(
		'UserGroup' => array(
			'className' => 'UserGroup',
			'foreignKey' => 'user_group_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

}
?>