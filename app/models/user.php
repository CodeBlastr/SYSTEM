<?php
class User extends AppModel {

	var $name = 'User';
	var $displayField = 'username';
	var $actsAs = array('Acl' => 'requester');
	var $userField = array(); # Used to define the creator table field (typically creator_id)
	var $userLevel = false; # Used to define if this model requires record level user access control?
	
	var $validate = array(
		'password' => array(
			'notempty' => array(
				'rule' => 'notEmpty',
				'allowEmpty' => false,
				'message' => 'Please Enter a value for Password'
			),
			'comparePassword' => array(
				'rule' => array('__comparePassword'),
				'allowEmpty' => false,
				'message' => 'Password, and Password Confirmation did not match.'
			),
		),
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
	);
	
	function parentNode() {
   		if (!$this->id && empty($this->data)) {
	        return null;
	    }
	    $data = $this->data;
	    if (empty($this->data)) {
	        $data = $this->read();
	    }
	    if (empty($data['User']['user_group_id'])) {
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
		if (!empty($this->data['User']['confirm_password'])) {
			$this->data['User']['confirm_password'] = Security::hash($this->data['User']['confirm_password'],'', true);
		}
	}
	
	function __comparePassword() {
		# fyi, confirm password is hashed in the beforeValidate method
		if ((!empty($this->data['User']['confirm_password']) && $this->data['User']['password'] == $this->data['User']['confirm_password'])) {
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
	/* 
	@ todo You can't have relations from core to plugin for it to really be a plugin
	
	var $hasMany = array(
		'ProfileFollower' => array(
			'className' => 'Profiles.ProfileFollower',
			'foreignKey' => 'user_id',
			'dependent' => false,
		),
		'ProfileGroupWallPost'=>array(
			'className' => 'Profiles.ProfileGroupWallPost',
			'foreignKey' => 'creator_id',
			'dependent' => false,
		)
	);
	
	var $hasAndBelongsToMany = array(
        'Profiles.ProfileGroup' =>
            array(
                'className'              => 'Profiles.ProfileGroup',
                'joinTable'              => 'users_profile_groups',
                'foreignKey'             => 'profile_group_id',
                'associationForeignKey'  => 'user_id'
            )
    );
	*/
	
	function checkAccess($aroModel='UserGroup', $aroForeignKey, $aco = array()) {
		$acos = $this->_getAllAcos($aroModel, $aroForeignKey);
		if (!empty($aco['controller']) && !empty($aco['action'])) {
			$acoId = $this->_getAcoIdAction($aco['controller'], $aco['action']);
		} else if (!empty($aco['model']) && !empty($aco['foreign_key'])) {
			$acoId = $this->_getAcoRecordLevel($aco['controller'], $aco['action']);
		}
		#pr($acoId);
		#pr($acos);
		if ($this->_searchAcos($acoId, $acos)) {
			return true;
		} else {
			return false;
		}
	}
	
	
	function _searchAcos($needle, $haystacks) {
		foreach ($haystacks as $stack) {
			if($stack['Aco']['AcoId'] == $needle) {
				return true;
				break;
			}
		}
		return false;
	}
	
	
	function _getAllAcos($model, $foreignKey) {
		$allAcos = $this->query("
			SELECT
			    Aro.model AS AroModel,
			    Aro.foreign_key AS AroId,
			    Aro.alias AS AroAlias,
			    Aco.id AS AcoId,
			    Aco.alias AS AcoAlias,
			    Aco.model AS AcoModel,
			    Aco.foreign_key AS AcoForeignKey
			FROM
			    acos AS Aco
			INNER JOIN
			    acos AS AcoRule ON ( AcoRule.lft <= Aco.lft AND AcoRule.rght >= Aco.rght )
			INNER JOIN
			    aros_acos AS aros_acos ON ( aros_acos.aco_id = AcoRule.id )
			INNER JOIN
			    aros AS AroRule ON ( aros_acos.aro_id = AroRule.id )
			INNER JOIN
			    aros AS Aro ON ( Aro.lft >= AroRule.lft AND Aro.rght <= AroRule.rght )
			WHERE
			    Aro.model = '".$model."' AND
			    Aro.foreign_key = ".$foreignKey." AND
			    aros_acos._create = 1 
			");
		if (!empty($allAcos)) {
			return $allAcos;
		} else {
			return null;
		}
	}
	
	
	function _getAcoIdAction($controller, $action) {
		# important note, this will not work if there are name collisions between controllers, plugin controllers
		$acos = $this->query("
    	  	SELECT 
				`Aco`.`id`, 
			    `Aco`.`parent_id`, 
			    `Aco`.`model`, 
			    `Aco`.`foreign_key`, 
			    `Aco`.`alias` 
		    FROM 
			    `acos` AS `Aco` 
		    LEFT JOIN `acos` AS `Aco0` ON (
		    	`Aco0`.`alias` = '".$controller."') 
		    LEFT JOIN `acos` AS `Aco1` ON (
		    	`Aco1`.`lft` > `Aco0`.`lft` AND
		        `Aco1`.`rght` < `Aco0`.`rght` AND
		        `Aco1`.`alias` = '".$action."' AND
        		`Aco0`.`id` = `Aco1`.`parent_id`) 
   			WHERE ("/*(
		    	`Aco`.`lft` <= `Aco0`.`lft` AND
        		`Aco`.`rght` >= `Aco0`.`rght`) OR */ // removing that decreased the time by nearly a full second
		        ."(`Aco`.`lft` <= `Aco1`.`lft` AND `Aco`.`rght` >= `Aco1`.`rght`)) 
           ORDER BY 
		   		`Aco`.`lft` DESC 
			");
		if (!empty($acos[0]['Aco']['id'])) {
			return $acos[0]['Aco']['id'];	
		} else {
			return null;
		}
	}
	
	function _getAcoRecordLevel($model, $foreignKey) {
		$acos = $this->query("
    		SELECT
		         `Aco`.`id`,
		         `Aco`.`parent_id`, 
		         `Aco`.`model`, 
		         `Aco`.`foreign_key`, `
		          Aco`.`alias` 
			FROM
        		`acos` 
	        AS 
	        	`Aco` 
	        LEFT JOIN 
	        	`acos` AS `Aco0` 
	        ON (
	        	`Aco`.`lft` <= `Aco0`.`lft` AND 
	            `Aco`.`rght` >= `Aco0`.`rght`) 
	        WHERE 
	        	`Aco0`.`model` = 'Webpage' AND 
	            `Aco0`.`foreign_key` = 3 
	        ORDER BY 
	            `Aco`.`lft` DESC 
			");
		if (!empty($acos)) {
			return $acos;
		} else {
			return null;
		}
	}
}
?>
