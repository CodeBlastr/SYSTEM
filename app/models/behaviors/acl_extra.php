<?php
class AclExtraBehavior extends ModelBehavior {

/**
 * Creates the aros_acos record for record level access by a particular user.
 *
 * @var array
 * @access protected
 */
	var $__typeMaps = array('both' => 'ArosAco');

/**
 * Sets up the configuation for the model, and loads ACL models if they haven't been already
 *
 * @param mixed $config
 * @return void
 * @access public
 */
	function setup(&$model, $config = array()) {
		if (is_string($config)) {
			$config = array('type' => $config);
		}
		$this->settings[$model->name] = array_merge(array('type' => 'requester'), (array)$config);

		$type = $this->__typeMaps[$this->settings[$model->name]['type']];
		if (!class_exists('AclNode')) {
			require LIBS . 'model' . DS . 'db_acl.php';
		}
		if (PHP5) {
			$model->Aro = ClassRegistry::init('Aro');
			$model->Aco = ClassRegistry::init('Aco');
			$model->{$type} = ClassRegistry::init($type);
		} else {
			$model->Aro =& ClassRegistry::init('Aro');
			$model->Aco =& ClassRegistry::init('Aco');
			$model->{$type} =& ClassRegistry::init($type);
		}
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
		if ($model != 'User') {
			$type = $this->__typeMaps[strtolower($this->settings[$model->alias]['type'])];
			$parent = $model->parentNode();
			if (!empty($parent)) {
				$parent = $this->node($model, $parent);
			}
			$data = array(
				'aro_id' => $model->Aro->id,
				'aco_id' => $model->Aco->id,
				'_create' => 1,
				'_read' => 1,
				'_update' => 1,
				'_delete' => 1,
			);
			# not sure if this is needed or working for saves of the non-creation type
			if (!$created) {
				$node = $this->node($model);
				$data['id'] = isset($node[0][$type]['id']) ? $node[0][$type]['id'] : null;
			}
			$model->{$type}->create();
			if($model->{$type}->save($data));
		}
	}

/**
 * Destroys the ARO/ACO node bound to the deleted record
 *
 * @return void
 * @access public
 */
	function afterDelete(&$model) {
		# nothing has been done here
		$type = $this->__typeMaps[strtolower($this->settings[$model->name]['type'])];
		$node = Set::extract($this->node($model), "0.{$type}.id");
		if (!empty($node)) {
			$model->{$type}->delete($node);
		}
	}
}
