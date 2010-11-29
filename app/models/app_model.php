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
	


	function beforeSave() {
		# Start Record Level Access Save #
		// If the model needs UserLevel Access add an Aco
		if(isset($this->userLevel) && $this->userLevel == true){
			$this->Behaviors->attach('Acl', array('type' => 'controlled'));
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
 * What the hell is this for?  Why is there no comment about it?
 */ 
	function findMy($type, $options=array()) {
	   if($this->hasField($this->userField) && !empty($_SESSION['Auth']['User']['id'])){
	      $options['conditions'][$this->alias.'.'.$this->userField] = $_SESSION['Auth']['User']['id'];
	      return parent::find($type, $options);
	   }
	   else{
	      return parent::find($type, $options);
	   }
	}
	
	
	
/**
 * What the hell is this for?  Why is there no comment about it?
 */ 
	function deleteMy($id = null, $cascade = true) {
	   if (!empty($id)) {
	      $this->id = $id;
	   }
	   $id = $this->id;
	
	   if($this->hasField($this->userField) && !empty($_SESSION['Auth']['User']['id'])){
	      $opt = array(
	         'conditions' => array(
	            $this->alias.'.'.$this->userField => $_SESSION['Auth']['User']['id'],
	            $this->alias.'.id' => $id,
	            ),
	         );
	      if($this->find('count', $opt) > 0){
	         return parent::delete($id, $cascade);
	      }
	      else{
	         return false;
	      }
	   }
	   else
	      return parent::delete($id, $cascade);
	}
	
	
/*
 * Checks if the record belongs to some one or not.  This is used when doing a record level check on a user.  For example, if you want to restrict edit access to a page to the creator only.  This does the extra check needed to see if they get access, using one of the user fields (like creator_id, modifier_id, assignee_id, etc).
 *
 * @param {int} 		user -> $this->Auth->user('id') from app_controller
 * @param {array} 		params -> $this->params from app_controller
 * @return {bool}
 */
	function checkUserFields($user, $params){
		if(isset($params['pass'][0])){
			# set the conditions 
			$conditions = array(
				'id' => $params['pass'][0]
			);
			# loop through user fields to set the conditions (ie. creator_id = 2 (current user id))
			# the fields we check are pulled from belongsTo variables of models, where the className = 'User'
			$userFields = $this->_userFields();
			for($i = 0 ; $i < count($userFields) ; $i++){
				$conditions['OR'][$userFields[$i]] = $user;
			}
			# check the fields to see if any of them have the current user as the value
			$modelDat = $this->find('count' , array(
				'contain' => array(),
				'conditions' => $conditions
			));	
			if($modelDat != 0){
				return true;
			} else {
				return false;
			}	
		}		
	}


/** 
 * This pulls the user fields from the model using the belongsTo variable, and the className User
 *
 * @return {array}			Returns an array of user fields (ie. creator_id, modifier_id, assignee_id, etc.)
 * @todo					Create a new table called acos_userfields, and make it so that the creators grouop, (change the name of the creators group to something better too), allows you to choose the user fields which are allowed in a multi-select.  I'm envisioning a multi-select field that you see after setting a checkbox for a group we call, "user_ids" or something, and by default all user id field types are selected, but you can limit them this way. 
 * @todo					Allow the use of the var $userField var to over ride access, but if its blank use the belongsTo version.
 */
	function _userFields() {
		if (property_exists($this->name, 'userField')) {
			return $this->userField;
		} else {
			foreach ($this->belongsTo as $model) {
				# gets user fields from the model for any belongsTo records which have a className of User
				if ($model['className'] == 'User') {
					$userFields[] = $model['foreignKey'];
				} 
			}
		}
		return $userFields;
	}
	
	
/**
 * Don't know what this is for, I'd like to see a comment placed.
 */
	function parentNode() {
		$this->name;
	}

}

?>