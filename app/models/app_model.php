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
	
	
	# This has been saved so that we can use it when we finish of the extra condition checking in the condition model
	# If it exists there, then delete this function, but NOT until then.
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
 * With this function our total_count now appears with the rest of the fields in the resulting data array.
 * http://nuts-and-bolts-of-cakephp.com/2008/09/29/dealing-with-calculated-fields-in-cakephps-find/
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
 * This function uses the functions which follow because we've found them to be less time intensive. 
 * They may change in the future, but the queries were spelled out, because it was just easier to read,
 * and probably a tad less memory used because of it as well.
 * @param {aro} 		array containing the Aro node
 * @param {aco}			array containing the Aco controller and action OR model and foreign key
 * @todo				Check whether this is properly escaped in the event of an error (like !empty() or something)
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
 * This finds every single Aco that this group or user has access to.
 *
 * @param {model}			The Aco model.
 * @param {foreign_key}		The Aco foreign_key
 * @todo					We need to review this and make sure it does NOT return negatives.  (looks like it might)
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
 * This finds the id of the aco when using the action type of aco lookup.  Used for action level access control.
 *
 * @param {controller}		The controller alias.
 * @param {action}			The action alias.
 * @return {int}			The Aco node id.
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
 * This finds the aco id of when using the record lookup type. Used for record level access control.<br />
 *
 * @param {model}			The model alias.
 * @param {foreignKey}		The id of the model being reviewed.
 * @return {int}			The Aco node id.
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
	
	
/**
 * Used to see whether the record being saved is a record which is subject to record level access control.  Executed in the beforeSave callback function of app_model.  If it is a record which is subject to record level access control, then beforeSave triggers the record level Aco and ArosAco creation.  Using the Acl behavior which make the Aco, and the AclExtra behavior which makes the AroAco using the user field which is supposed to get access as the Aro.  To set the Aros that should have access, make a setting called RECORD_LEVEL_ACCESS_ENTITY in the "settings" table of the database.
 *
 * @param {recordEntities}		An array of entities which should be subject to record level access control.
 * @return {array}				An array of user ids that should have access to the record.  (ie. assignee_id, user_id)
 * @todo						We could easily add UserGroup to this array, and control group record level access for groups per save as well.  We would need to just add a model = key into the aro lookup in acl_extra as well.
 */
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
			# 
			return array('User' => $userIds);
		} else {
			return false;
		}
	}

}

?>