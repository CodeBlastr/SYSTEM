<?php
App::uses('ModelBehavior', 'Model');
/**
 * MetableBehavior
 * 
 * Allows unlimited customization of model data from the view file. 
 * By simply using a form input with the ! prefix on the field name
 * you will create a meta field and save that meta field into the metas
 * table. 
 * 
 * We then use some magic to make that meta data appear as part of the 
 * actual database queries to the model behaving this way. 
 * 
 */
class MetableBehavior extends ModelBehavior {

	public $settings = array();
	
/**
 * Setup 
 * 
 * If a model uses this behavior, we bind the Meta model
 * automatically and force a contain onto all SELECTS. 
 * 
 * @param Model $Model
 * @param type $settings
 */
	public function setup($Model, $settings = array()) {
        return true;
	}

/**
 * After save callback
 * 
 * Used to save meta data that was included in a data array.
 * Important Note!  You must send all meta data at once.  You
 * can NOT send a single meta field and save it.  All meta fields
 * must come at the same time. 
 * 
 * @param Model $Model
 * @param type $created
 */
	public function afterSave(Model $Model, $created) {
		foreach ($Model->data[$Model->alias] as $field => $value) {
			if (strpos($field, '!') === 0) {
				$metadata[$field] = $value;
				unset($Model->data[$Model->alias][$field]);
			}
		}
		if (!empty($metadata)) {
			$metadata = serialize($metadata);
            $Meta = ClassRegistry::init('Meta');
			$Meta->query("
				INSERT INTO `metas` (model, foreign_key, value)
				VALUES ('{$Model->name}', '{$Model->id}', '{$metadata}')
					ON DUPLICATE KEY UPDATE	value = '{$metadata}';
				");
		}
		parent::afterSave($Model, $created);
	}
	
/**
 * Before find callback
 * 
 * Remove and save metaConditions for use in the afterFind
 * 
 * @param Model $Model
 * @param array $query
 * @return array
 * @todo optimize by flattening and searching for Alias.
 */
	public function beforeFind(Model $Model, array $query) {
        $Model->bindModel(array(
        	'hasOne' => array(
				'Meta' => array(
					'className' => 'Meta',
					'foreignKey' => 'foreign_key',
                    'conditions' => array('Meta.model' => $Model->name),
                    //'dependent' => false, // we'll manually handle deletes in afterDelete()
                    //'fields' => array('Meta.model', 'Meta.foreign_key', 'Meta.value')
					)
				)
			), false);
        $query['contain'][] = 'Meta'; //$Model->contain('Meta');
        
//        // kept in case we need to manually join again
//		$query['joins'][] = array(
//			'table' => 'metas',
//			'alias' => 'Meta',
//			'type' => 'LEFT',
//			'conditions' => array(
//				"{$Model->alias}.id = Meta.foreign_key",
//				"Meta.model = '{$Model->alias}'"
//			)
//		);

		//$query = $this->_queryFields($Model, $query);  // read comment by function
		$query = $this->_queryConditions($Model, $query);  
       	return $query;
	}

/**
 * After find callback
 * 
 * @param Model $Model
 * @param type $results
 * @param type $primary
 * @return type
 */
    public function afterFind(Model $Model, $results, $primary) {
		//debug($results);
		$results = $this->mergeSerializedMeta($Model, $results); 
		$results = $this->filterByMetaConditions($Model, $results);  
		return $results;
	}
    
    public function beforeDelete(Model $Model, $cascade = true) {
        unset($Model->Meta);
        $Model->unbindModel(array('hasOne' => array('Meta')));
        return true;
    }
    
    public function afterDelete(Model $Model) {
        $Meta = ClassRegistry::init('Meta');
        if ($Meta->deleteAll(array('Meta.foreign_key' => $Model->id, 'Meta.model' => $Model->name), false, false)) {
            return true;
        } else {
            throw new Exception(__('Meta After Delete Failed'));
        }
    }
    
    
#    public function beforeDelete(Model $Model, $cascade = array()) {
#        // manual join needed
#    	$query['joins'][] = array(
#			'table' => 'metas',
#			'alias' => 'Meta',
#			'type' => 'LEFT',
#			'conditions' => array(
#				"{$Model->alias}.id = Meta.foreign_key",
#				"Meta.model = '{$Model->alias}'"
#			)
#		);
#        return parent::beforeDelete($Model, $cascade);
#    }


/**
 * Merge Serialized Meta
 * 
 * Take the meta data and merge it into the results as if 
 * it were part of the data array to begin with.
 * 
 * @param object $Model
 * @param array $results
 * @return array
 */
    public function mergeSerializedMeta($Model, $results = array()) {
		foreach($results as &$result) {
			if(isset($result['Meta']['foreign_key'])) {
				// merges the unserialized Meta values into the Model array
				$result[$Model->alias] = Set::merge($result[$Model->alias], unserialize($result['Meta']['value']));
			}
			unset($result['Meta']);
		} 
		return $results;
	}

/**
 * Filter by Meta Conditions
 * 
 * We can use conditions for meta fields just like we could 
 * for real database fields.  Here we have to rewrite sql 
 * conditions into array filter conditions. 
 * 
 * @param object $Model
 * @param array $results
 * @return array
 */
	public function filterByMetaConditions($Model, $results = array()) {
		if ($Model->metaConditions) {
			foreach ($Model->metaConditions as $key => $value) {
				$i = 0;
				$query = explode('.', $key);
//				debug($query);
//				debug($value);
//				debug($results);
				// check for operators in the field query
				if(strpos($query[1], ' ')) {
					$operator = explode(' ', $query[1]);
					// set $query[1] to the field without the operator (as it is expected to be, below)
					$query[1] = $operator[0];
					// set a variable to the operator
					$operator = $operator[1];
				} else {
					$operator = false;
				}
//				debug($operator);
				foreach ($results as $result) {
					if (isset($result[$query[0]][$query[1]])) {
						if ($operator === false && $result[$query[0]][$query[1]] == $value) {
							// leave this result in the $results
						} elseif ($operator == '>=' && $result[$query[0]][$query[1]] >= $value) {
							// leave this result in the $results
						} elseif ($operator == '>' && $result[$query[0]][$query[1]] > $value) {
							// leave this result in the $results
						} elseif ($operator == '<=' && $result[$query[0]][$query[1]] <= $value) {
							// leave this result in the $results
						} elseif ($operator == '<' && $result[$query[0]][$query[1]] < $value) {
							// leave this result in the $results
						} elseif ($operator == 'LIKE' && strpos($result[$query[0]][$query[1]], str_replace ('%', '', $value)) !== false) {
							// leave this result in the $results
						} else {
							// does not compute, remove this result from the $results
							unset($results[$i]);
						}
					} else {
						unset($results[$i]);
					}
					++$i;
				}
			}

			$results = array_values($results);
		}
		return $this->_checkOriginalSearchType($Model, $results);
	}
    
/**
 * Query fields
 * 
 * If fields is set, then we need to add Meta.fields as well.
 * 
 * @param Model $Model
 * @param array $query
 * @return array
 * 
 * @todo This might be able to be deleted.  Removing it seems to have no ill effects so far
 * and if we need them, they might be better in the hasOne['fields'] area
 */
	protected function _queryFields(Model $Model, $query) {
		if(!empty($query['fields']) && is_array($query['fields'])) {
			$query['fields'][] = 'Meta.model';
			$query['fields'][] = 'Meta.foreign_key';
			$query['fields'][] = 'Meta.value';
		}
		return $query;
	}
 
	
/**
 * Query conditions
 * 
 * Remove and save metaConditions for use in the afterFind
 * 
 * @param Model $Model
 * @param array $query
 * @return array
 */
	protected function _queryConditions(Model $Model, $query) {
        
		if(!empty($query['conditions']) && is_array($query['conditions'])) {
			foreach($query['conditions'] as $condition => $value) {
				if(strstr($condition, $Model->alias.'.!')) {
					$Model->metaConditions[$condition] = $value;
					unset($query['conditions'][$condition]);
				}
			}
		}
		return $query;
	}
	
/**
 * Check Original Search Type
 * 
 * In the AppModel we find out if the search type is 'first',
 * and if it is we change it to all.  So we need to change the 
 * data format back to a first type search format array before 
 * giving it to the requestor.
 * 
 * @param type $Model
 * @param type $results
 * @return type
 */
	protected function _checkOriginalSearchType($Model, $results) {
		if ($Model->metaType == 'first' && !empty($results[0])) {
			$results = $results[0];
		}
		return $results;
	}
		
		
}