<?php
class AclExtraBehavior extends ModelBehavior {

/**
 * Get the settings for saving ArosAco records related to the Aco that was last created
 *
 * @param mixed $config
 * @return void
 * @access public
 */
	function setup(&$model, $data = array()) {
		if (!empty($data['RecordLevelAccess'])) {
			$aroModel = key($data['RecordLevelAccess']);
			$aroUsers = $data['RecordLevelAccess']['User'];
		} else {
			return false;
		}
		
		$model->Aro = ClassRegistry::init('Aro');
		$model->Aco = ClassRegistry::init('Aco');
		$model->ArosAco = ClassRegistry::init('ArosAco');
		
		$this->model = $aroModel;
		$this->users = $aroUsers;
		
		if (!method_exists($model, 'parentNode')) {
			trigger_error(sprintf(__('Callback parentNode() not defined in %s', true), $model->alias), E_USER_WARNING);
		}
	}

/**
 * Creates a new AROSACO node bound to this record
 *
 * @param boolean $created True if this is a new record
 * @return void
 * @access public
 */
	function afterSave(&$model, $created) {
		$acoId = $model->Aco->id;
		foreach ($this->users as $user) {
			$aro = $model->Aro->node(array('model' => $this->model, 'foreign_key' => $user));
			$data = array(
				'aro_id' => $aro[0]['Aro']['id'],
				'aco_id' => $model->Aco->id,
				'_create' => 1,
				'_read' => 1,
				'_update' => 1,
				'_delete' => 1,
			);
			$model->ArosAco->create();
			if($model->ArosAco->save($data));
		}			
			
			# not sure if this is needed or working for saves of the non-creation type
			/*if (!$created) {
				$node = $this->node($model);
				$data['id'] = isset($node[0][$type]['id']) ? $node[0][$type]['id'] : null;
			}*/
	}

/**
 * NOT USED YET
 * Destroys the ARO/ACO node bound to the deleted record
 *
 * @return void
 * @access public
 * @todo Make this function work.
 */
	function afterDelete(&$model) {
		/*# nothing has been done here
		$type = $this->__typeMaps[strtolower($this->settings[$model->name]['type'])];
		$node = Set::extract($this->node($model), "0.{$type}.id");
		if (!empty($node)) {
			$model->{$type}->delete($node);
		}*/
	}
}
