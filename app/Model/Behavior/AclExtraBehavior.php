<?php
/**
 * Database driven, record level access control. 
 *
 * This behavior when attached checks this->data and the settings table to see if the data being saved is subject to record level access control.  If it is, then this behavior creates the aros_acos record which grants that access.  To use set a variable within the settings table under the APP key named RECORD_LEVEL_ACCESS_ENTITIES.  The value for that setting should be in the Model.field format.  Example : key = APP, value = RECORD_LEVEL_ACCESS_ENTITIES:Ticket.assignee_id,Project.assignee_id,Profile.user_id;
 *
 *
 * PHP versions 5
 *
 * Zuha(tm) : Business Management Applications (http://zuha.com)
 * Copyright 2009-2012, Zuha Foundation Inc. (http://zuha.org)
 *
 * Licensed under GPL v3 License
 * Must retain the above copyright notice and release modifications publicly.
 *
 * @copyright     Copyright 2009-2012, Zuha Foundation Inc. (http://zuha.com)
 * @link          http://zuha.com Zuha™ Project
 * @package       zuha
 * @subpackage    zuha.app.models.behaviors
 * @since         Zuha(tm) v 0.0.1
 * @license       GPL v3 License (http://www.gnu.org/licenses/gpl.html) and Future Versions
 * @todo		  AclExtraBehavior class should work with groups as well as users, so that we make better use of repeat code.  Right now webpages controller has its own user role code and that could be removed, and it could be implemented better using this behavior attachment.
 * @todo		  AclExtraBehavior needs delete functionality implemented. 
 */
class AclExtraBehavior extends ModelBehavior {

/**
 * Get the settings for saving ArosAco records related to the Aco that was last created
 *
 * @param mixed $config
 * @return void
 * @access public
 */
    public function setup($Model, $config = array()) {
		$this->Aro = ClassRegistry::init('Aro');
		$this->Aco = ClassRegistry::init('Aco');
		$this->ArosAco = ClassRegistry::init('ArosAco');
		
//		if (!method_exists($model, 'parentNode')) {
//			trigger_error(sprintf(__('Callback parentNode() not defined in %s', true), $model->alias), E_USER_WARNING);
//		}
	}

/**
 * Creates mutliple new ArosAco nodes as needed for access to the Aco entity created.
 *
 * @param boolean $created True if this is a new record
 * @return void
 * @access public
 */
	public function afterSave($Model, $created) {
		debug($Model->data);
		break;
		
		if (!empty($Model->data['RecordLevelAccess']['User'])) {
			$aroModel = 'User';
			$aroUsers = $data['RecordLevelAccess']['User'];
		} else if (!empty($data['RecordLevelAccess']['UserRole'])) {
			$aroModel = 'UserRole';
			$aroUsers = $data['RecordLevelAccess']['UserRole'];
		} else {
			return false;
		}
		$this->Model = $aroModel;
		$this->Users = $aroUsers;
		
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
			
			// not sure if this is needed or working for saves of the non-creation type
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
