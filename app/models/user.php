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
					'notempty'=>array(
							'rule'=>'notEmpty',
							'message'=>'Please Enter a value for your Username'
					),
					'isUnique'=>array(
							'rule'=>'isUnique',
							'message'=>'This Username belongs to someone else. Please pick another one.'
					)
		),
		'password' => array('notempty'),
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
	/* commented out after contacts, projects, blogs, and profiles were moved to plugins
		should be deleted eventually
		
	var $hasMany = array(
		'ProjectCreator' => array(
			'className' => 'Projects.Project',
			'foreignKey' => 'creator_id',
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
		'ProjectModifier' => array(
			'className' => 'Projects.Project',
			'foreignKey' => 'modifier_id',
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
		'BlogPost' => array(
			'className' => 'Blogs.BlogPost',
			'foreignKey' => 'creatir_id',
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
	
	var $hasOne = array(
		'UserProfile' => array(
			'className' => 'UserProfile',
			'foreignKey' => 'user_id',
			'dependent' => true,
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Contact' => array(
			'className' => 'Contacts.Contact',
			'foreignKey' => 'user_id',
			'dependent' => true,
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
	); */

}
?>