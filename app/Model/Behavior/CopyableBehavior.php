<?php
/**
 * Copyable Behavior class file.
 *
 * Adds ability to copy a model record, including all hasMany and hasAndBelongsToMany
 * associations. Relies on Containable behavior, which this behavior will attach
 * on the fly as needed.
 * 
 * HABTM relationships are just duplicated in the join table, while hasMany and hasOne
 * records are recursively copied as well.
 *
 * Usage is straightforward:
 * From model: $this->copy($id); // id = the id of the record to be copied
 * From container: $this->MyModel->copy($id);
 *
 * @filesource
 * @author			Jamie Nay
 * @copyright       Jamie Nay
 * @license			http://www.opensource.org/licenses/mit-license.php The MIT License
 * @link            http://github.com/jamienay/copyable_behavior
 */
class CopyableBehavior extends ModelBehavior {

/**
 * Behavior settings
 * 
 * @access public
 * @var array
 */
	public $settings = array();

/**
 * Array of contained models.
 *
 * @access public
 * @var array
 */
	public $contain = array();

/**
 * The full results of Model::find() that are modified and saved
 * as a new copy.
 *
 * @access public
 * @var array
 */
	public $record = array();

/**
 * Default values for settings.
 *
 * - recursive: whether to copy hasMany and hasOne records
 * - habtm: whether to copy hasAndBelongsToMany associations
 * - stripFields: fields to strip during copy process
 * - ignore: aliases of any associations that should be ignored, using dot (.) notation.
 * will look in the $this->contain array.
 *
 * @access private
 * @var array
 */
    private $defaults = array(
    	'recursive' => true,
    	'habtm' => true,
    	'stripFields' => array('id', 'created', 'modified', 'lft', 'rght'),
    	'ignore' => array()
    );

/**
 * Configuration method.
 *
 * @param object $Model Model object
 * @param array $config Config array
 * @access public
 * @return boolean
 */
    public function setup(Model $Model, $config = array()) {
    	$this->settings[$Model->alias] = array_merge($this->defaults, $config);
    	return true;
	}

/**
 * Copy method.
 *
 * @param object $Model model object
 * @param mixed $id String or integer model ID
 * @access public
 * @return boolean
 */
	public function copy(Model $Model, $id) {
		$this->generateContain($Model);

		$this->record = $Model->find('first', array(
			'conditions' => array($Model->alias.'.id' => $id),
			'contain' => $this->contain
		));

		if (empty($this->record)) {
			return false;
		}

		if (!$this->__convertData($Model)) {
			return false;
		}

		return $this->__copyRecord($Model);
	}

/**
 * Wrapper method that combines the results of __recursiveChildContain()
 * with the models' HABTM associations.
 *
 * @param object $Model Model object
 * @access public
 * @return array
 */
	public function generateContain(Model $Model) {
		if (!$this->__verifyContainable($Model)) {
			return false;
		}

		$this->contain = array_merge($this->__recursiveChildContain($Model), array_keys($Model->hasAndBelongsToMany));
		$this->__removeIgnored($Model);
		return $this->contain;
	}

/**
 * Removes any ignored associations, as defined in the model settings, from 
 * the $this->contain array.
 *
 * @param object $Model Model object
 * @access public
 * @return boolean
 */
	private function __removeIgnored(Model $Model) {
		if (!$this->settings[$Model->alias]['ignore']) {
			return true;
		}
		$ignore = array_unique($this->settings[$Model->alias]['ignore']);
		foreach ($ignore as $path) {
			if (Set::check($this->contain, $path)) {
				$this->contain = Set::remove($this->contain, $path);
			}
		}
		return true;
	}

/**
 * Strips primary keys and other unwanted fields
 * from hasOne and hasMany records.
 *
 * @param object $Model model object
 * @param array $record
 * @access private
 * @return array $record
 */
	private function __convertChildren(Model $Model, $record) {
		$children = array_merge($Model->hasMany, $Model->hasOne);
		foreach ($children as $key => $val) {
			if (!isset($record[$key])) {
				continue;
			}

			if (empty($record[$key])) {
				unset($record[$key]);
				continue;
			}

			if (isset($record[$key][0])) {
				foreach ($record[$key] as $innerKey => $innerVal) {
					$record[$key][$innerKey] = $this->__stripFields($Model, $innerVal);
					if (array_key_exists($val['foreignKey'], $innerVal)) {
						unset($record[$key][$innerKey][$val['foreignKey']]);
					}

					$record[$key][$innerKey] = $this->__convertChildren($Model->{$key}, $record[$key][$innerKey]);
				}
			} else {
				$record[$key] = $this->__stripFields($Model, $record[$key]);

				if (isset($record[$key][$val['foreignKey']])) {
					unset($record[$key][$val['foreignKey']]);
				}

				$record[$key] = $this->__convertChildren($Model->{$key}, $record[$key]);
			}
		}

		return $record;
	}

/**
 * Strips primary and parent foreign keys (where applicable)
 * from $this->record in preparation for saving.
 *
 * @param object $Model Model object
 * @access private
 * @return array $this->record
 */
	private function __convertData(Model $Model) {
		$this->record[$Model->alias] = $this->__stripFields($Model, $this->record[$Model->alias]);
		$this->record = $this->__convertHabtm($Model, $this->record);
		$this->record = $this->__convertChildren($Model, $this->record);
		return $this->record;
	}

/**
 * Loops through any HABTM results in $this->record and plucks out
 * the join table info, stripping out the join table primary
 * key and the primary key of $Model. This is done instead of
 * a simple collection of IDs of the associated records, since
 * HABTM join tables may contain extra information (sorting
 * order, etc).
 *
 * @param object $Model	Model object
 * @access public
 * @return array modified $record
 */
	private function __convertHabtm(Model $Model, $record) {
		if (!$this->settings[$Model->alias]['habtm']) {
			return $record;
		}
		foreach ($Model->hasAndBelongsToMany as $key => $val) {
			if (!isset($record[$val['className']]) || empty($record[$val['className']])) {
				continue;
			}

			$joinInfo = Set::extract($record[$val['className']], '{n}.'.$val['with']);
			if (empty($joinInfo)) {
				continue;
			}

			foreach ($joinInfo as $joinKey => $joinVal) {
				$joinInfo[$joinKey] = $this->__stripFields($Model, $joinVal);

				if (array_key_exists($val['foreignKey'], $joinVal)) {
					unset($joinInfo[$joinKey][$val['foreignKey']]);
				}	
			}

			$record[$val['className']] = $joinInfo;
		}

		return $record;
	}

/**
 * Performs the actual creation and save.
 *
 * @param object $Model Model object
 * @access private
 * @return mixed
 */
	private function __copyRecord(Model $Model) {
		$Model->create();
		$Model->set($this->record);
		return $Model->saveAll(null, array('validate' => false));
	}

/**
 * Generates a contain array for Containable behavior by
 * recursively looping through $Model->hasMany and
 * $Model->hasOne associations.
 *
 * @param object $Model Model object
 * @access private
 * @return array
 */
	private function __recursiveChildContain(Model $Model) {
		$contain = array();
		if (!$this->settings[$Model->alias]['recursive']) {
			return $contain;
		}

		$children = array_merge(array_keys($Model->hasMany), array_keys($Model->hasOne));
  		foreach ($children as $child) {
  			if ($Model->alias == $child) {
  				continue;
  			}
  			$contain[$child] = $this->__recursiveChildContain($Model->{$child});
  		}

  		return $contain;
	}

/**
 * Strips unwanted fields from $record, taken from
 * the 'stripFields' setting.
 *
 * @param object $Model Model object
 * @param array $record
 * @access private
 * @return array
 */
	private function __stripFields(Model $Model, $record) {
		foreach ($this->settings[$Model->alias]['stripFields'] as $field) {
			if (array_key_exists($field, $record)) {
				unset($record[$field]);
			}
		}

		return $record;
	}

/**
 * Attaches Containable if it's not already attached.
 *
 * @param object $Model Model object
 * @access private
 * @return boolean
 */
	private function __verifyContainable(Model $Model) {
		if (!$Model->Behaviors->attached('Containable')) {
			return $Model->Behaviors->attach('Containable');
		}

		return true;
	}

}