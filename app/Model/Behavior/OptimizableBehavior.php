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
                    'conditions' => '',
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
 	public function afterFind(Model $Model, $results, $primary) {
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
		return $results;
 	}

/**
 * beforeValidate callback
 *
 * @param object $Model
 */
	public function beforeValidate(Model $Model) {
		if (!empty($Model->data['Alias']['name'])) {
            $this->data['Alias'] = $Model->data['Alias'];
            $this->makeUniqueSlug($Model);
            //unset($Model->data['Alias']); // commented out 11/28/2012 RK remove if webpage adding / editing still works
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
		$newAlias = $Model->data['Alias']['name'];
		
		$this->trigger = isset($options['atomic']) ? false : true; // test for whether this is a saveAll() or save()
		
		//Added check for the alias won't save if they match
		if($oldAlias['Alias']['name'] == $newAlias) {
			$this->trigger = false;
		}
		
		if (!empty($Model->data['Alias']['name'])) {
            $this->data['Alias'] = $Model->data['Alias'];
            $this->data[$Model->alias]['alias'] = $Model->data['Alias']['name'];
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
    public function afterSave(Model $Model, $created) {
        if (!empty($this->data['Alias']['name']) && $this->trigger) {
            $settings = $this->settings[$Model->alias];
            $this->Alias = ClassRegistry::init('Alias');
            $this->data['Alias']['value'] = $Model->data[$Model->alias][$settings['foreignKey']];
            $this->data['Alias']['name'] = $this->aliasName;
			$this->data['Alias']['plugin'] = $settings['plugin'];
			$this->data['Alias']['controller'] = $settings['controller'];
			$this->data['Alias']['action'] = $settings['action'];
            if ($this->Alias->save($this->data)) {
                // nothing just continue through
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
    public function makeUniqueSlug(Model $Model) {
		$this->Alias = ClassRegistry::init('Alias');
        $names[] = $Model->data['Alias']['name'];
        for($i = 0; $i < 10; $i++){
            $names[] = $Model->data['Alias']['name'] . $i;
        }
		
        $count = $this->Alias->find('count', array('conditions' => array('Alias.name' => $names), 'fields' => 'Alias.id'));
        
        return !empty($count) ? $this->aliasName = $Model->data['Alias']['name'] . $count : $this->aliasName = $Model->data['Alias']['name'];
    }
    
}
