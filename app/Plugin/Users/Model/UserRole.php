<?php
App::uses('UsersAppModel', 'Users.Model');

class UserRole extends UsersAppModel {

	var $name = 'UserRole';	
	var $actsAs = array('Acl' => array('requester'), 'Tree');
	var $viewPrefixes = array('admin' => 'admin');
	

	//The Associations below have been created with all possible keys, those that are not needed can be removed
	var $hasMany = array(
		'User' => array(
			'className' => 'Users.User',
			'foreignKey' => 'user_role_id',
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
	
	/**
	 * Parent Node is now null according to this http://book.cakephp.org/2.0/en/tutorials-and-examples/simple-acl-controlled-application/simple-acl-controlled-application.html?highlight=acl%20both
	 *
	 * This is function is used in conjunction with the Acl behavior included in the actsAs variable.
	 * It works transparently in the models afterSave() but requires that requires this method to be defined.
	 * http://book.cakephp.org/view/545/Using-the-AclBehavior
	 *
	 * Right now it appears to be working so that sub user roles create sub Aros
	 
	function parentNode() {
   		if (!$this->id && empty($this->request->data)) {
	        return null;
	    }
	    $data = $this->request->data;
	    if (empty($this->request->data)) {
	        $data = $this->read();
	    }
	    if (empty($data['UserRole']['parent_id'])) {
	        return null;
	    } else {
			$aro = array(
				'UserRole' => array(
					'id' => $data['UserRole']['parent_id'],
					),
				);
	        return $aro;
	    }
	}*/
	 
	
	function parentNode() {
        return null;
    }
	
	/**
	 * 
	 */
	function afterSave($created) {
		/* 
		#So far I have not seen a use for this (11/27/2010).  So who ever put it here should comment about its use, or it will be deleted.
		Commented out 10/19/2011 RK
        if (!$created) :
			
            $parent = $this->parentNode();
            $parent = $this->node($parent);
            $node = $this->node();
            $aro = $node[0];
            $aro['Aro']['parent_id'] = $parent[0]['Aro']['id'];			
            $this->Aro->save($aro);			
        endif;
		*/
		
		# updates users view_prefix if its been changed
		if (!empty($this->request->data['UserRole']['id'])) :
			$this->User->updateAll(
				array('User.view_prefix' => "'".$this->request->data['UserRole']['view_prefix']."'"),
				array('User.user_role_id' => $this->request->data['UserRole']['id'])
				);
		endif;
	}
	
	
	function viewPrefixes() {
		return array(
			'admin' => 'admin',
			);
	}

}
?>