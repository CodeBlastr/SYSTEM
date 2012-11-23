<?php

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
	public function setup(Model $Model, $settings = array()) {
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
		$Model->bindModel(array(
			'hasOne' => array(
				'Meta' => array(
					'className' => 'Meta',
					'foreignKey' => 'foreign_key',
					)
				)
			), false);
		$Model->contain(array('Meta'));

		foreach ($Model->data[$Model->alias] as $field => $value) {
			if (strpos($field, '!') === 0) {
				$metadata[$field] = $value;
				unset($Model->data[$Model->alias][$field]);
			}
		}

		$metadata = serialize($metadata);
		$Model->Meta->query("
			INSERT INTO `metas` (model, foreign_key, value)
			VALUES ('{$Model->name}', '{$Model->id}', '{$metadata}')
				ON DUPLICATE KEY UPDATE	value = '{$metadata}';
			");

		parent::afterSave($Model, $created);
	}
	
/**
 * Before find callback
 * 
 * Remove and sour metaConditions for use in the afterFind
 * 
 * @param Model $Model
 * @param array $query
 * @return array
 */
	public function beforeFind(Model $Model, array $query) {
		$Model->bindModel(array(
			'hasOne' => array(
				'Meta' => array(
					'className' => 'Meta',
					'foreignKey' => 'foreign_key',
					)
				)
			), false);
		$Model->contain(array('Meta'));
		// remove the !metafields from the conditions that are passed to the Model
		/** @todo optimize by flattening and searching for Alias.! **/
		if(!empty($query['conditions'])) {
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
 * After find callback
 * 
 * @param Model $Model
 * @param type $results
 * @param type $primary
 * @return type
 */
	public function afterFind(Model $Model, $results, $primary) {
		$results = $this->mergeSerializedMeta($Model, $results);
		$results = $this->filterByMetaConditions($Model, $results);
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
				$query = explode('.', $key);
				$i = 0;
				foreach ($results as $result) {
					if (isset($result[$query[0]][$query[1]])) {
						if ($result[$query[0]][$query[1]] == $value) {
							// do nothing
						} else {
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