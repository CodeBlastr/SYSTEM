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
	
	// always checks if a table has the creator_id and/or modifier_id and writes the current user id to the record.
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

}

?>