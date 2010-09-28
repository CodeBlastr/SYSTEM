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
		$conditionTriggers = $Condition->find('all', array('conditions' => array('Condition.plugin' => $plugin, 'Condition.controller' => $controller, 'Condition.action' => $this->params['action'])));
		#first condition was a match, see if there is an additional condition
		if(!empty($conditionTriggers)) {
			$this->__saveOrCheckExtraConditions($conditionTriggers);
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
	
	function findMy($type, $options=array())
	{
	   if($this->hasField($this->userField) && !empty($_SESSION['Auth']['User']['id'])){
	      $options['conditions'][$this->alias.'.'.$this->userField] = $_SESSION['Auth']['User']['id'];
	      return parent::find($type, $options);
	   }
	   else{
	      return parent::find($type, $options);
	   }
	}
	
	function deleteMy($id = null, $cascade = true)
	{
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
	 * 
	 */
	
	function beforeDelete(){
		
	}
	
	
	/*
	 * Checks if the recor belongs to some one or not .  
	 */
	
	function does_belongs($user){
		if($this->id){
			$dat = $this->find('first' , array(
					'contain'=>array(),
					'conditions'=>array(
						 'id'=>$this->id,
						 $this->userField=>$_SESSION['Auth']['User']['id']
					)
			));		
		}else{
			return true;
		}
		
	}

}

?>