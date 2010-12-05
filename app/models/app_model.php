<?php
/**
 * App Wide Shared Model Functions
 *
 * Handles app wide model functions, model settings and convenience functions 
 * all sub models use this model as the parent model
 *
 * PHP versions 5
 *
 * Zuha(tm) : Business Management Applications (http://zuha.com)
 * Copyright 2009-2010, Zuha Foundation Inc. (http://zuhafoundation.org)
 *
 * Licensed under GPL v3 License
 * Must retain the above copyright notice and release modifications publicly.
 *
 * @copyright     Copyright 2009-2010, Zuha Foundation Inc. (http://zuha.com)
 * @link          http://zuha.com Zuha™ Project
 * @package       zuha
 * @subpackage    zuha.app.models
 * @since         Zuha(tm) v 0.0.1
 * @license       GPL v3 License (http://www.gnu.org/licenses/gpl.html) and Future Versions
 */
class AppModel extends Model {	
	var $actsAs = array('Containable');
	var $recursive = -1;
	


	function beforeSave(&$model) {
		# Start Record Level Access Save #
		// If the model needs Record Level Access add an Aco
		if(defined('__APP_RECORD_LEVEL_ACCESS_ENTITIES')){
			if ($this->data['RecordLevelAccess'] = $this->_isRecordLevelRecord(__APP_RECORD_LEVEL_ACCESS_ENTITIES)) {
				$this->Behaviors->attach('Acl', array('type' => 'controlled'));
				$this->Behaviors->attach('AclExtra', $this->data);
			}
		} 
			/* Not sure what's under here is even necessary, because moving it to beforeSave (instead of afterSave might have fixed it.
			$aco = ClassRegistry::init('Permissions.Acore');
			$this->Behaviors->attach('Acl', array('type' => 'controlled'));
			// foreign_key
			$last_one = $this->getLastInsertID();
			$aco_dat["Acore"]["foreign_key"] = $last_one;
			//set the alias
			if($this->params["plugin"] != ''){
				//set the aco dat 
				$aco_dat["Acore"]["alias"] = $this->params['plugin'] . '/' . $this->params['controller'] . '/' . $this->params['action'] . '/' . $last_one;
			} else {
				//set the aco dat
				$aco_dat["Acore"]["alias"] = $this->params['controller'] . '/' . $this->params['action'] . '/' . $last_one;
			}
			
			$aco_dat['Acore']['parent_id'] = $this->getAco($this->params);
			
			$aco_dat["Acore"]["model"] = $this->name;
			$aco_dat["Acore"]["type"] = 'record';
			$aco->create();
			$aco->save($aco_dat); 
		}	*/
		# End Record Level Access Save #
	
		# Start Auto Creator & Modifier Id Saving # 
		$exists = $this->exists();
		App::import('Component', 'Session');
		$Session = new SessionComponent();
		$user = $Session->read('Auth.User');
		
		if ( !$exists && $this->hasField('creator_id') && empty($this->data[$this->alias]['creator_id']) ) {
			$this->data[$this->alias]['creator_id'] = $user['id'];
		}
		if ( $this->hasField('modifier_id') && empty($this->data[$this->alias]['modifier_id']) ) {
			$this->data[$this->alias]['modifier_id'] = $user['id'];
		}
		# End Auto Creator & Modifier Id Saving # 
		
		# you have to return true to make the save continue.
		return true;
	}
		
	
/**
 * Condition Check, checks to see if any conditions from the conditions table were met.
 */
    function afterSave($created) {
		# Start Condition Check #
		App::Import('Model', 'Condition');
		$this->Condition = new Condition;
		#get the id that was just inserted so you can call back on it.
		$this->data[$this->name]['id'] = $this->id;	
		
		if ($created == true) {
			$this->Condition->checkAndFire('is_create', array('model' => $this->name), $this->data);
		} else {
			$this->Condition->checkAndFire('is_update', array('model' => $this->name), $this->data);
			#$this->conditionCheck('is_read'); // this needs to be put into the before Filter of the 
		}
		# End Condition Check #
    }
	
/**
 * Condition Check, checks to see if any conditions from the conditions table were met.
 */
    function afterDelete() {
		# Start Condition Check #
		App::Import('Model', 'Condition');
		$this->Condition = new Condition;
		#get the id that was just inserted so you can call back on it.
		$this->data[$this->name]['id'] = $this->id;	
		$this->Condition->checkAndFire('is_delete', array('model' => $this->name), $this->data); 
		# End Condition Check #
	}
	
	
/**
 * Gets the aco node
 * @param {array} params -> $this->params having problems reaching it from model
 * @param {bool} main -> Do you want the aco of the record or the action
 * @return int
 * @todo I'm relatively positive that this could be whittled down, and probably moved to the permissions plugin or something. 
 */
	function getAco($params , $main = false){
		$acor = ClassRegistry::init('Permissions.Acore');
		if($params['plugin'] == ''){
			$alias = 0;
			if(isset($params['pass'][0])){
				$alias = $params['pass'][0];
			}
			$plugin = false ;
		} else {
			$alias = 0;
			if(isset($params['pass'][0])){
				$alias = $params['pass'][0];
			}
			$plugin = true;
		}
		if($plugin){
			//get the aco data to be able to determine the parent_id field
			$ret_aco = $acor->find('first' , array(
				'conditions'=>array(
					// not sure what effects changing this might have on other parts of the system so I'm leaving reference
					//'type' => 'plugin',
					'type' => 'pcontroller',
					'alias' => Inflector::camelize($params['controller'])
				),
				'contain' => array(),
				'fields' => array('id'),
				'callbacks' => false
			));
			// get clidren
			$child = $acor->children($ret_aco["Acore"]["id"]);
			if(count($ret_aco) != 0){
				// the current id of the aco node.
				$curr_parent = $ret_aco["Acore"]["id"];
				// get the controller id 
				foreach($child as $c){
					if($c["Acore"]["alias"] == ucwords($params["controller"])){
						$curr_parent = $c["Acore"]["id"];
					}
				}
				// get the action id 
				foreach($child as $c){
					if($c["Acore"]["alias"] == $params["action"] && $c["Acore"]["parent_id"] == $curr_parent){
						$curr_parent = $c["Acore"]["id"];
					}
				}					
				// get the node id if set 
				// to get the records aco id. Has to check with main. 
				if($alias != 0 && !$main){
					foreach($child as $c){
						$record_num = explode('/' , $c["Acore"]["alias"]);
						if(count($record_num) != 1){
							if($record_num[3] == $alias)
								$curr_parent = $c["Acore"]["id"];
							}
						}
					}
					// set the parent_id
				return $curr_parent;
			}
					
		} else {
			//not in a plugin and getting aco dat
			$ret_aco = $acor->find('first', array(
				'conditions'=>array(
					'type' => 'controller',
					'alias' => ucwords($params['controller'])
				),
				'contain' => array(),
				'fields' => array('id'),
				'callbacks' => false
			));
			// get the action
			if(count($ret_aco) != 0){
				$child = $acor->children($ret_aco["Acore"]["id"]);
				$curr_parent = $ret_aco["Acore"]["id"];
				foreach($child as $c){
					if($c["Acore"]["alias"] == $params["action"]){
						$curr_parent = $c["Acore"]["id"];
					}
				}
			// to get the records aco id. Has to check with main. 
			if($alias != 0 && !$main){
				foreach($child as $c){
					$record_num = explode('/' , $c["Acore"]["alias"]);
					if(count($record_num) != 1){
						if($record_num[2] == $alias)
							$curr_parent = $c["Acore"]["id"];
						}
					}
				}
			// set the parent_id
			return $curr_parent;
			}
		}
	}
	
	
	# this has been saved so that we can use it when we finish of the extra condition checking in the condition model
	# if it exists there, then delete this function
	function __checkExtraCondition($conditionTrigger) {
		$conditionsArray = explode(',',$conditionTrigger['Condition']['condition']);
		foreach ($conditionsArray as $conditionsArr) {
			$conditions[] = explode('.',$conditionsArr);
		}
		foreach ($conditions as $condition) {
			# check for the operator 
			if ($condition[3] == 'null' && $condition[2] == '=') {
				if (empty($this->data[$condition[0]][$condition[1]])) {
				} else {
					$positive = false;
				}
			} else if ($condition[3] == 'null' && $condition[2] == '!=') {
				if (!empty($this->data[$condition[0]][$condition[1]])) {
				} else {
					$positive = false;
				}
			} else if ($condition[2] == '=') {
				if ($this->data[$condition[0]][$condition[1]] == $condition[3]) {
				} else {
					$positive = false;
				}
			} else if ($condition[2] == '!=') {
				if ($this->data[$condition[0]][$condition[1]] != $condition[3]) {
				} else {
					$positive = false;
				}			
			} else if ($condition[2] == '<=') {
				if ($this->data[$condition[0]][$condition[1]] <= $condition[3]) {
				} else {
					$positive = false;
				}			
			} else if ($condition[2] == '>=') {
				if ($this->data[$condition[0]][$condition[1]] >= $condition[3]) {
				} else {
					$positive = false;
				}			
			} else if ($condition[2] == '<') {
				if ($this->data[$condition[0]][$condition[1]] < $condition[3]) {
				} else {
					$positive = false;
				}			
			} else if ($condition[2] == '>') {
				if ($this->data[$condition[0]][$condition[1]] > $condition[3]) {
				} else {
					$positive = false;
				}				
			}
		}
		
		if (!isset($positive)) {
			$positive = true;
		} 
		return $positive;
	}
	
	
/**
 * What the hell is this for?  Why is there no comment about it?
 */ 
	function afterFind($results, $primary = false) {
    	if($primary == true) {
    	   if(Set::check($results, '0.0')) {
    	      $fieldName = key($results[0][0]);
    	       foreach($results as $key=>$value) {
    	          $results[$key][$this->alias][$fieldName] = $value[0][$fieldName];
    	          unset($results[$key][0]);
    	       }
    	    }
    	}    
    	return $results;
	}
	
		
	
/**
 * Don't know what this is for, I'd like to see a comment placed.
 */
	function parentNode() {
		$this->name;
	}
	
	
/** 
 * Used by App Controller to check access to the requested page. 
 */
	function checkAccess($aro = array(), $aco = array()) {
		# this finds every single aco that this aro has access to 
		$acos = $this->_getAllAcos($aro['model'], $aro['foreign_key']);
		if (!empty($aco['controller']) && !empty($aco['action'])) {
			$acoId = $this->_getAcoIdAction($aco['controller'], $aco['action']);
		} else if (!empty($aco['model']) && !empty($aco['foreign_key'])) {
			$acoId = $this->_getAcoRecordLevel($aco['model'], $aco['foreign_key']);
		}
		#pr($acoId);
		#pr($acos);
		if ($this->_searchAcos($acoId, $acos)) {
			return true;
		} else {
			return false;
		}
	}
	
	
/**
 * searches the aco array to see if the aro exists
 */
	function _searchAcos($needle, $haystacks) {
		foreach ($haystacks as $stack) {
			if($stack['Aco']['AcoId'] == $needle) {
				return true;
				break;
			}
		}
		return false;
	}
	

/**
 * This finds every single aco that this group or user has access to.
 */
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
	
	
/**
 * This finds the id of the aco when using the action type of aco lookup 
 */
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
   			WHERE ((
		    	`Aco`.`lft` <= `Aco0`.`lft` AND
        		`Aco`.`rght` >= `Aco0`.`rght`) OR
				(`Aco`.`lft` <= `Aco1`.`lft` AND `Aco`.`rght` >= `Aco1`.`rght`)) 
           ORDER BY 
		   		`Aco`.`lft` DESC 
			");
		if (!empty($acos[0]['Aco']['id'])) {
			return $acos[0]['Aco']['id'];	
		} else {
			return null;
		}
	}
	
/**
 * This finds the aco id of when using the record lookup type.
 */
	function _getAcoRecordLevel($model, $foreignKey) {
		$acos = $this->query("
    		SELECT
		         `Aco`.`id`,
		         `Aco`.`parent_id`, 
		         `Aco`.`model`, 
		         `Aco`.`foreign_key`, 
				 `Aco`.`alias` 
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
	        	`Aco0`.`model` = '".$model."' AND 
	            `Aco0`.`foreign_key` = ".$foreignKey." 
	        ORDER BY 
	            `Aco`.`lft` DESC 
			");
		if (!empty($acos[0]['Aco']['id'])) {
			return $acos[0]['Aco']['id'];
		} else {
			return null;
		}
	}
	
	

	function _isRecordLevelRecord($recordEntities) {
		# create the array
		$data = $this->data;
		$recordEntities = explode(',', $recordEntities);
		foreach ($recordEntities as $recordEntity) {
			$entities = explode('.', $recordEntity);
			foreach ($entities as $entity) {
				if (is_array($data) && array_key_exists($entity, $data)) {
					$value = $data[$entity];
					$data = $value;
					if (!is_array($value)) {
						$userIds[] = $value;
					}
				}
			}
		}
		
		if (!empty($userIds)) {
			# @todo We could easily add UserGroup to this array, and control group record level access per save as well.  We would need to just add a model = key into the aro lookup in acl_extra as well.
			return array('User' => $userIds);
		} else {
			return false;
		}
	}

}

?>