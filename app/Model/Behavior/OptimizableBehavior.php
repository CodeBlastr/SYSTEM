<?php
/**
 * Optimizable Behavior
 *
 * @package model
 * @subpackage model.behaviors
 */
class OptimizableBehavior extends ModelBehavior {

/**
 * Settings to configure the behavior
 *
 * @var array
 */
	public $settings = array();

/**
 * Trigger
 * 
 * @var bool
 */
	public $trigger = false;

/**
 * Default settings
 *
 * foreignKey	- The relationship field
 *
 * @var array
 */
	protected $_defaults = array(
        'plugin' => '', // updateed in setup
        'controller' => '', // updated in setup
		'action' => 'view',
        'foreignKey' => 'id' // field to put in the Alias.value column
        );
	

/**
 * Initiate behaviour
 *
 * @param object $Model
 * @param array $settings
 */
	public function setup(Model $Model, $settings = array()) {
		$ZuhaInflector = new ZuhaInflector();
        $this->_defaults['plugin'] = Inflector::tableize($ZuhaInflector->pluginize($Model->name));
        $this->_defaults['controller'] = Inflector::tableize($Model->name);
		$this->settings[$Model->alias] = array_merge($this->_defaults, $settings);
	}

/**
 * beforeFind callback
 * 
 * @param object $Model
 * @param array $query
 */
    public function beforeFind(Model $Model, $query) {
        $Model->bindModel(array(
            'hasOne' => array(
                'Alias' => array(
                    'className' => 'Alias',
                    'foreignKey' => 'value',
                    'dependent' => true,
                    'conditions' => array('Alias.controller' => Inflector::tableize($Model->name)),
                    'fields' => '',
                    'order' => 'Alias.modified DESC'
                    )
                )
            ), false);
        $query['contain'][] = 'Alias';
		$query['group'] = !empty($query['group']) ? $query['group'] : array($Model->alias => 'id');
        return parent::beforeFind($Model, $query);
    }
	
/**
 * afterFind callback
 * 
 * if beforeFind doesn't get the alias, then we need to get it here and add it in
 * 
 * @param object $Model
 * @param mixed $results
 */
 	public function afterFind(Model $Model, $results, $primary = false) {
 		// look up the alias if it isn't set already
 		if (!empty($results[0][$Model->alias]) && !isset($results[0]['Alias'])) {
 			for($i = 0, $count = count($results); $i < $count; ++$i) {
 				$alias = $Model->Alias->find('first', array('conditions' => array(
 					'Alias.value' => $results[$i][$Model->name]['id'],
					'Alias.controller' => Inflector::tableize($Model->name),
					)));
				if (!empty($alias)) {
					$results[$i]['Alias'] = $alias['Alias'];
				}
			}
 		}
		// map the alias to a virtual field
		for($i = 0, $count = count($results); $i < $count; ++$i) {
			if (!empty($results[$i]['Alias'])) {
				$results[$i][$Model->alias]['_alias'] = '/' . $results[$i]['Alias']['name']; // not dead set on adding the slash
			} else {
				$results[$i][$Model->alias]['_alias'] = '/' . strtolower(ZuhaInflector::pluginize($Model->name)) . '/' . Inflector::tableize($Model->name) . '/view/' . $results[$i][$Model->alias]['id']; 
			}
		}
		return $results;
 	}

/**
 * beforeValidate callback
 * 
 * @param Model $Model
 * @param type $options
 * @return boolean
 */
	public function beforeValidate(Model $Model, $options = array()) {
		if (!empty($Model->data['Alias']['name'])) {
            $this->data['Alias'] = $Model->data['Alias'];
            $this->aliasName = $this->makeUniqueSlug($Model, $Model->data['Alias']['name']);
        }
		return true;
	}

/**
 * beforeSave callback
 *
 * @param object $Model
 * @todo bind the model here if not bound already
 */
	public function beforeSave(Model $Model, $options = array()) {
		$this->Alias = ClassRegistry::init('Alias');	
		$oldAlias = $this->Alias->find('first', array('conditions' => array('id' => $this->data['Alias']['id'])));
		$newAlias = !empty($Model->data['Alias']['name']) ? $Model->data['Alias']['name'] : $Model->data[$Model->alias]['alias'];
		
		// this keeps us from trying to save an alias twice (we tried removing it, and it throws an error)
		$this->trigger = isset($options['atomic']) ? false : true; // test for whether this is a saveAll() or save()
		
		//Added check for the alias won't save if they match
		if($oldAlias['Alias']['name'] == $newAlias) {
			$this->trigger = false;
		}

		$this->data['Alias'] = $Model->data['Alias'];
        !empty($newAlias) ? $this->data['Alias']['name'] = $newAlias : null;
        $this->data[$Model->alias]['alias'] = $newAlias;
		
		// Check for SEO Meta values
		if (!empty($this->data['Alias']['title']) || !empty($this->data['Alias']['keywords']) || !empty($this->data['Alias']['description'])) {
			$this->meta = true;
		}
		return parent::beforeSave($Model, $options);
	}

/**
 * afterSave callback
 * 
 * Only fires an alias save if the save function was save() ... not saveAll() 
 * Because saveAll() would mean that the alias was already saved. 
 * 
 * @param Model $Model
 * @param bool $created
 */
    public function afterSave(Model $Model, $created, $options = array()) {
        $settings = $this->settings[$Model->alias];
    	// check for existing and set the id for overwrite in case this is an edit
    	if (!empty($this->trigger) || !empty($this->meta)) {
            $Alias = ClassRegistry::init('Alias');
            $existingId = $Alias->field('id', array('value' => $Model->data[$Model->alias][$settings['foreignKey']]));
			!empty($existingId) ? $data['Alias']['id'] = $existingId : null;
			$data['Alias']['plugin'] = $settings['plugin'];
			$data['Alias']['controller'] = $settings['controller'];
			$data['Alias']['action'] = $settings['action'];
    	}
    	// setup the alias data
        if (!empty($this->data['Alias']['name']) && $this->trigger) {
            $data['Alias']['value'] = $Model->data[$Model->alias][$settings['foreignKey']];
            $data['Alias']['name'] = $this->makeUniqueSlug($Model, $this->data['Alias']['name']);
        }
		// setup meta data
        if (!empty($this->meta)) {
            $data['Alias']['value'] = $Model->data[$Model->alias][$settings['foreignKey']];
            $data['Alias']['title'] = $this->data['Alias']['title'];
			$data['Alias']['keywords'] = $this->data['Alias']['keywords'];
			$data['Alias']['description'] = $this->data['Alias']['description'];
        }
		if (!empty($data['Alias'])) {
			$Alias->create();
            if ($Alias->save($data)) {
                return true;
            } else {
                throw new Exception(__('Alias save failed after %s was saved.', $Model->alias));
            }
		}
        parent::afterSave($Model, $created);
    }

/**
 * Make Unique Slug
 * 
 * @param Model $Model
 * @return int
 */
    public function makeUniqueSlug(Model $Model, $name) {
		$this->Alias = ClassRegistry::init('Alias');
        $names[] = $name;
        for ($i = 0; $i < 10; $i++){
            $names[] = $name . $i;
        }
		
        $count = $this->Alias->find('count', array('conditions' => array('Alias.name' => $names), 'fields' => 'Alias.id'));
        
        return !empty($count) ? $name . $count : $name;
    }
    
}
