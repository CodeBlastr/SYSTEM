<?php
class AppModel extends Model {	
	var $actsAs = array('Containable');
	var $recursive = -1;
	
	/*
	function find($type, $options = array()) {
		$method = null;
		if(is_string($type)) {
			$method = sprintf('__find%s', Inflector::camelize($type));
		}
		if($method && method_exists($this, $method)) {
			return $this->{$method}($options);
		} else {
			$args = func_get_args();
			return call_user_func_array(array('parent', 'find'), $args);
		}
	}
	*/
	
	function setParams( $params = null ) {
		$this->params = $params;
	}
	

	
    function afterSave() {
		if (isset($this->params['action'])) {
			# Now lets check condtions 
			$modelName = $this->name;
			$controller = Inflector::underscore(Inflector::pluralize($modelName));
			$plugin = explode('_', $controller);
			$plugin = Inflector::pluralize($plugin[0]);	
			#get the id that was just inserted so you can call back on it.
			$this->data[$modelName]['id'] = $this->id;		
			
			App::import('Model', 'Condition');
			$Condition = new Condition();
			# check if a notification condition is met
			$conditionTriggers = $Condition->find('all', array(
				'conditions' => array(
					'Condition.plugin' => $plugin,
					'Condition.controller' => $controller,
					'Condition.action' => $this->params['action']
					)
				));
			#first condition was a match, see if there is an additional condition
			if(!empty($conditionTriggers)) {
				$this->__saveOrCheckExtraConditions($conditionTriggers);
			}
		}
		
		
		// If the model needs UserLevel Access add an Aco
		if(isset($this->userLevel) && $this->userLevel == true){
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
			
			$aco_dat['Acore']['parent_id'] = $this->get_aco($this->params);
			
			$aco_dat["Acore"]["model"] = $this->name;
			$aco_dat["Acore"]["type"] = 'record';
			$aco->create();
			$aco->save($aco_dat);
		}	
    }
	
	function __saveOrCheckExtraConditions($conditionTriggers) {	
		foreach ($conditionTriggers as $conditionTrigger) {
			if (!empty($conditionTrigger['Condition']['condition'])) {
				# if it does check $this->data to see if its still a match
				if ($this->__checkExtraCondition($conditionTrigger)) {
					$this->__saveNotification($conditionTrigger);
				}
			} else {
				# otherwise save it
				$this->__saveNotification($conditionTrigger);
			}
		}
	}
	
	/*
	 * Gets the aco node
	 * @param {array} params -> $this->params having problems reaching it from model
	 * @param {bool} main -> Do you want the aco of the record or the action
	 * @return int
	 */
	
	function get_aco($params , $main = false){
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
									'type'=>'plugin',
									'alias'=>ucwords($params['plugin'])
								),
								'contain'=>array(),
								'fields'=>array('id'),
								'callbacks'=>false
					));
					// get clidren
					$child = $acor->children($ret_aco["Acore"]["id"]);
					if(count($ret_aco) != 0){
					//the current id of the aco node.
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
											'type'=>'controller',
											'alias'=>ucwords($params['controller'])
										),
										'contain'=>array(),
										'fields'=>array('id'),
										'callbacks'=>false
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
						
						return $curr_parent;
					}
					
					// set the parent_id
					
				}
	}
	
	function __saveNotification($conditionTrigger) {		
		# import the model that originally saved the condition
		App::import('Model', $conditionTrigger['Condition']['lookup_model']);
		if (strpos($conditionTrigger['Condition']['lookup_model'], '.')) {
			$model = explode('.', $conditionTrigger['Condition']['lookup_model']);
			$model = $model[1];
		} else {
			$model = $conditionTrigger['Condition']['lookup_model'];
		}		
		$this->$model = new $model();
		
		# get the template that we're turning into a real action that was triggered by this condition
				
		# get it ready for saving by importing the save model
		App::import('Model', $conditionTrigger['Condition']['save_model']);
		# test if its a plugin you're doing the saving to
		if (strpos($conditionTrigger['Condition']['save_model'], '.')) {
			# it is a plugin
			$saveModel = explode('.', $conditionTrigger['Condition']['save_model']);
			$saveModel = $saveModel[1];
		} else {
			# it is not a plugin
			$saveModel = $conditionTrigger['Condition']['save_model'];
		}
		$this->$saveModel = new $saveModel();
		
		$saveData = $this->$model->read(null, $conditionTrigger['Condition']['lookup_model_record_id']);
		$saveDataFinal[$saveModel] = $saveData[$saveModel.'Template'];
		
		# save the previous actual record data being saved into a data array to help with actual data replacements
		$saveDataFinal[$saveModel]['data_array'] = print_r($this->data, true);
		# unset standard fields so that they can be specific to the actual data 
		$saveDataFinal[$saveModel]['id'] = null;
		$saveDataFinal[$saveModel]['creator_id'] = null;
		$saveDataFinal[$saveModel]['modifier_id'] = null;
		$saveDataFinal[$saveModel]['created'] = null;
		$saveDataFinal[$saveModel]['modified'] = null;
		
		# now change all of the template data to real data
		$this->$saveModel->set($saveDataFinal);
		
		# and do the save
		if ($this->$saveModel->save()) {
			# nothing here normal operation continues
			return true;
		} else {
			echo 'Action Trigger Error ::: Condition Trigger, failed to save.';
			return false;
		}
	}
	
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
	
	# always checks if a table has the creator_id and/or modifier_id and writes the current user id to the record.
	function beforeSave() {
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
		return true;
	}
	
	/* In your application models, if you need to override the beforeSave callback, make sure you call the parent function: example : 
	class Article extends AppModel {
		function beforeSave() {
			return parent::beforeSave();
		}

	*/
	function afterFind($results, $primary=false) {
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
	
	function findMy($type, $options=array()) {
	   if($this->hasField($this->userField) && !empty($_SESSION['Auth']['User']['id'])){
	      $options['conditions'][$this->alias.'.'.$this->userField] = $_SESSION['Auth']['User']['id'];
	      return parent::find($type, $options);
	   }
	   else{
	      return parent::find($type, $options);
	   }
	}
	
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
	 * Checks if the recor belongs to some one or not .  
	 * @param {int} user -> $this->Auth->user('id') from app_controller
	 * @param {array} params -> $this->params from app_controller
	 * @return {bool}
	 */
	
	function does_belongs($user , $params){
		if($params["pass"][0] != 0){
			// set the conditions 
			$conditions = array(
				'id'=> $params['pass'][0]
			);
			// loop through user fields to set the conditions
			$userFields = $this->userField;
			for($i = 0 ; $i < count($userFields) ; $i++){
				$conditions['OR'][$userFields[$i]] = $user;
			}
			$dat = $this->find('count' , array(
					'contain'=>array(),
					'conditions'=>$conditions
			));		
			if($dat != 0){
				return true;
			}else{
				return false;
			}
			
		}else{
			return true;
		}
		
	}
		
	function parentNode() {
	        $this->name;
	}

}

?>