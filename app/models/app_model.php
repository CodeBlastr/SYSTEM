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
 * Copyright 2009-2010, Zuha Foundation Inc. (http://zuha.org)
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
		if (!empty($this->data['RecordLevelAccess']['UserRole'])) {
			# There may be a potential problem with this.
			# It saves an ArosAco record for every record being created.
			# For example, when creating a webpage, it also creates an Aco for the Alias
			# Left it in as is, because we may want this.  (ie. when a contact is record level, 
			# we probably want the user to have access to the Contact and Contact Person
			# if a project issue is created, we probably want the user to have access to the project too.
			$this->Behaviors->attach('Acl', array('type' => 'controlled'));
			$this->Behaviors->attach('AclExtra', $this->data);
		} else if (defined('__APP_RECORD_LEVEL_ACCESS_ENTITIES')){
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
		$this->Condition = ClassRegistry::init('Condition');
		#get the id that was just inserted so you can call back on it.
		$this->data[$this->name]['id'] = $this->id;	
		
		if ($created === true) {
			$this->Condition->checkAndFire('is_create', array('model' => $this->name), $this->data);
		} else {
			$this->Condition->checkAndFire('is_update', array('model' => $this->name), $this->data);
			#$this->conditionCheck('is_read'); // this needs to be put into the beforeFilter or beforeRender (beforeRender, would allow error pages to work too) of the 
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
 * Used to see whether the record being saved is a record which is subject to record level access control.  Executed in the beforeSave callback function of app_model.  If it is a record which is subject to record level access control, then beforeSave triggers the record level Aco and ArosAco creation.  Using the Acl behavior which make the Aco, and the AclExtra behavior which makes the AroAco using the user field which is supposed to get access as the Aro.  To set the Aros that should have access, make a setting called RECORD_LEVEL_ACCESS_ENTITY in the "settings" table of the database.
 *
 * @param {recordEntities}		An array of entities which should be subject to record level access control.
 * @return {array}				An array of user ids that should have access to the record.  (ie. assignee_id, user_id)
 * @todo						We could easily add UserRole to this array, and control group record level access for groups per save as well.  We would need to just add a model = key into the aro lookup in acl_extra as well.
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

	/*
	 * __uid
	 * returns a 40 digit random key and adds the prefix if provided.
	 * $table : array(Model => action)  if uniqueness is required across any table and column
	 */
    function __uid($prefix = null, $table = null) {
        // creates a 6 digit key
        $uid = substr(md5(uniqid(rand(), true)), 0, 40);
        if ($prefix)
        	$uid = $prefix . $uid; 
        //checkto make sure its not a duplcate
        if ($table) {
	        foreach($table as $model => $col) {
	        	$data = ClassRegistry::init($model)->find('first', array('conditions' => array($col => $uid)));
		        if (!empty($data)) {
		            //if founds re-run the function
		            $this->__uid($prefix, $table);
		        } else {
		            return $uid;
		        }
	        }
    	} else {
			return $uid;
		}
    }
}

?>