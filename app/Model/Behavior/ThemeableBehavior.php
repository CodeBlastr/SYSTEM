<?php
App::uses('ModelBehavior', 'Model'); 
 
/**
 * ThemeableBehavior
 * 
 * Allows you to attach a layout to any primary record. 
 * 
 * Settings
 * elements[] = "config 0"
 * elements[] = "config 1"
 * elements[] = "config 2"
 * actions[] = 'view'
 * actions[] = 'edit'
 * 
 */
class ThemeableBehavior extends ModelBehavior {

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
        return true;
	}
    
/**
 * After save callback
 * 
 * Used to save meta data that was included in a data array.
 * 
 * @param Model $Model
 * @param boolean $created The value of $created will be true if a new record was created (rather than an update).
 */
	public function afterSave(Model $Model, $created, $options = array()) {
		if (!empty($Model->data['Template']['layout'])) {
			$data['Template']['layout'] = $Model->data['Template']['layout'];
			$data['Template']['model'] = $Model->name;
			$data['Template']['foreign_key'] = $Model->id;
			$Template = ClassRegistry::init('Template');
			$Template->save($data);
		}
		return true; // not really needed, but what the hey
	}
    
  
/**
 * Before find callback
 * 
 * Remove and save metaConditions for use in the afterFind
 * 
 * @param Model $Model
 * @param array $query
 * @return array

	public function beforeFind(Model $Model, $query) {
		return parent::beforeFind($Model, $query);
	} */

/**
 * After find callback
 * 
 * @param Model $Model
 * @param array $results
 * @param boolean $primary
 * @return array
 * @todo Can we somehow use this to get rid of or improve the current theming system? Could we say... if we have a hit on the theme settings then fill the model foreign_key with that value? 
 */
    public function afterFind(Model $Model, $results, $primary = false) {
    	if (!empty($Model->name) && !empty($Model->id)) {
			$Template = ClassRegistry::init('Template');
			$template = $Template->find('first', array(
				'conditions' => array('Template.model' => $Model->name, 'Template.foreign_key' => $Model->id)
			));
			if (!empty($template)) {
				for ($i = 0; $i < count($results); ++$i) {
					if (key($results[$i]) == $template['Template']['model'] && $results[$i][$Model->alias]['id'] == $template['Template']['foreign_key']) {
						$Model->theme[$Model->alias]['_layout'] = $template['Template']['layout'];
						$Model->theme[$Model->alias]['_layoutSettings'] = $template['Template']['settings'];
						$results[$i]['Template']['layout'] = $template['Template']['layout'];
					}
				}
			}
    	}
		return $results;
	}

}