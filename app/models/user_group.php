<?php
class UserGroup extends AppModel {

	var $name = 'UserGroup';	
	var $actsAs = array('Acl' => array('requester'), 'Tree');
 	var $userField = array(); # Used to define the creator table field (typically creator_id)
	var $userLevel = false; # Used to define if this model requires record level user access control? 	
	

	//The Associations below have been created with all possible keys, those that are not needed can be removed
	var $hasMany = array(
		'User' => array(
			'className' => 'User',
			'foreignKey' => 'user_group_id',
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
	//The Associations below have been created with all possible keys, those that are not needed can be removed
	var $belongsTo = array(
		'ParentUserGroup' => array(
			'className' => 'UserGroup',
			'foreignKey' => 'parent_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
	);
	
/**
 * This is function is used in conjunction with the Acl behavior included in the actsAs variable.
 * It works transparently in the models afterSave() but requires that requires this method to be defined.
 * http://book.cakephp.org/view/545/Using-the-AclBehavior
 *
 * Right now it appears to be working so that sub user groups create sub Aros
 */
	function parentNode() {
   		if (!$this->id && empty($this->data)) {
	        return null;
	    }
	    $data = $this->data;
	    if (empty($this->data)) {
	        $data = $this->read();
	    }
	    if (empty($data['UserGroup']['parent_id'])) {
	        return null;
	    } else {
			$aro = array(
				'UserGroup' => array(
					'id' => $data['UserGroup']['parent_id'],
					),
				);
	        return $aro;
	    }
	}
	
/**
 * So far I have not seen a use for this (11/27/2010).  So who ever put it here should comment about its use, or it will be deleted.
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

}
?>