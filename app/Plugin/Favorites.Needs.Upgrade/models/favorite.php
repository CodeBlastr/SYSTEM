<?php
/**
 * Copyright 2009-2010, Cake Development Corporation (http://cakedc.com)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright 2009-2010, Cake Development Corporation (http://cakedc.com)
 * @license MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

/**
 * Favorite Model
 *
 * @package favorites
 * @subpackage favorites.models
 */
class Favorite extends AppModel {

/**
 * name
 *
 * @var string
 */
	public $name = 'Favorite';

/**
 * Categories for list options. Restricts types of favorites fetched when making lists.
 *
 * @var array
 */
	protected $_listCategories = array(
		'Wish',
		'Favorite',
		'Watch',
	);

/**
 * Additional Find types to be used with find($type);
 *
 * @var array
 */
	public $_findMethods = array(
		'wish' => true,
		'favorite' => true,
		'watch' => true,
	);

/**
 * Constructor
 *
 * @param mixed $id Model ID
 * @param string $table Table name
 * @param string $ds Datasource
 */
	public function __construct($id = false, $table = null, $ds = null) {
		parent::__construct($id, $table, $ds);
		$categories = Configure::read('Favorites.modelCategories');
		if (!empty($categories)) {
			$this->_listCategories = (array)$categories;
		}
	}

/**
 * Get favorite list for a logged in user.
 *
 * @param mixed $userId Id of the user you want to make lists for.
 * @param int $limit Number of list items to get in each category (defaults to 100).
 * @return void
 */
	public function getFavoriteLists($type, $userId, $limit = 100) {
		$listItems = $this->getFavorites($userId, array('type' => $type));
		$list = array();
		$categoryCounts = array();
		foreach ($listItems as $item) {
			$category = $item[$this->alias]['model'];
			if (!isset($list[$category])) {
				$list[$category] = array();
				$categoryCounts[$category] = 0;
			}
			if (!isset($this->{$category})) {
				continue;
			}
			if ($categoryCounts[$category] >= $limit) {
				continue;
			}
			$method = '__get' . $category . 'Item';
			if (method_exists($this, $method)) {
				$list[$category][] = $this->{$method}($item[$category]);
			} else {
				$idField = $this->{$category}->primaryKey;
				$titleField = $this->{$category}->displayField;
				$list[$category][] = array('id' => $item[$category][$idField], 'title' => $item[$category][$titleField]);
			}
			$categoryCounts[$category]++;
		}
		return $list;
	}

/**
 * Helper method for getByType and getFavoriteLists
 *
 * @return array
 */
	public function getFavorites($userId, $options) {
		$this->recursive = 1;
		$favorites = $this->find('all', array(
			'conditions' => array(
				$this->alias . '.user_id' => $userId,
				$this->alias . '.type' => $options['type'],
				# CakeDC Used This (Zuha Used Recursive Above)
				#$this->alias . '.model' => $this->_getSupported('types', $options)
			),
			'order' => $this->alias . '.position ASC',
			# CakeDC Used This (Zuha Used Recursive Above)
			#'contain' => $this->_getSupported('contain', $options)
		));
		return $favorites;
	}


/**
 * Returns the search data
 *
 * @param string
 * @param array
 * @param array
 * @return
 */
	protected function _findFavorite($state, $query, $results = array()) {
		if ($state == 'before') {
			$this->Behaviors->attach('Containable', array('autoFields' => false));
			$results = $query;
			$options = array();
			if (!empty($query['options'])) {
				$options = $query['options'];
			}
			if (!empty($query['favoriteType'])) {
				$options['type'] = $query['favoriteType'];
			}
			$userId = $query['userId'];
			$default = array(
				'conditions' => array(
					$this->alias . '.user_id' => $userId,
					$this->alias . '.type' => $options['type'],
					$this->alias . '.model' => $this->_getSupported('types', $options)
					),
				'order' => $this->alias . '.position ASC',
				'contain' => $this->_getSupported('contain', $options)
				);
			$results = Set::merge($default, $query);
			if (isset($query['operation']) && $query['operation'] == 'count') {
				$results['fields'] = array('count(*)');
			}
			return $results;
		} elseif ($state == 'after') {
			if (isset($query['operation']) && $query['operation'] == 'count') {
				if (isset($query['group']) && is_array($query['group']) && !empty($query['group'])) {
					return count($results);
				}
				return $results[0][0]['count(*)'];
			}
			return $results;
		}
	}

/**
 * Customized paginateCount method
 *
 * @param array
 * @param integer
 * @param array
 * @return
 */
	function paginateCount($conditions = array(), $recursive = 0, $extra = array()) {
		$parameters = compact('conditions');
		if ($recursive != $this->recursive) {
			$parameters['recursive'] = $recursive;
		}
		if (isset($extra['type']) && isset($this->_findMethods[$extra['type']])) {
			$extra['operation'] = 'count';
			return $this->find($extra['type'], array_merge($parameters, $extra));
		} else {
			return $this->find('count', array_merge($parameters, $extra));
		}
	}

/**
 * Get all the favorites for a user by type
 * Works similar to getFavoriteLists() but returns full associated model,
 * Making display more flexible.
 *
 * @param mixed $userId Id of user
 * @param array $options Options to use for getting favorites
 * @return array Array of favorites for the user keyed by type.
 */
	public function getByType($userId, $options = array()) {
		$_defaults = array('limit' => 16, 'type' => 'default');
		$options = array_merge($_defaults, $options);
		$limit = $options['limit'];

		$favorites = $this->getFavorites($userId, $options);
		$out = $categoryCounts = array();
		foreach ($favorites as $item) {
			#this seems to be an error from cakedc
			#$category = $item[$this->alias]['model'];
			$category = Inflector::classify($item[$this->alias]['type']);
			if (!isset($out[$category])) {
				$out[$category] = array();
				$categoryCounts[$category] = 0;
			}
			if ($categoryCounts[$category] >= $limit) {
				continue;
			}
			$out[$category][] = $item;
			$categoryCounts[$category]++;
		}
		return $out;
	}

/**
 * Get The total number of favorites per category for a User.
 *
 * @param uuid $userId of User
 * @param array $options Options to use for the method.
 * @return array Array of counts keyed by model type
 * @todo add types suport here
 */
	public function typeCounts($userId, $options = array()) {
		$options['types'] = $this->_getSupported('types', $options);
		$counts = $this->find('all', array(
			'conditions' => array(
				$this->alias . '.model' => $options['types'],
				$this->alias . '.user_id' => $userId,
			),
			'fields' => array('COUNT(*) AS count', $this->alias . '.model'),
			'group' => array($this->alias . '.model'),
			'recursive' => -1
		));

		$out = array_combine($options['types'], array_fill(0, count($options['types']), 0));
		foreach ($counts as $count) {
			$type = $count[$this->alias]['model'];
			$number = $count[0]['count'];
			$out[$type] = $number;
		}
		return $out;
	}

/**
 * Move a favorite in the direction indicated. Will update the position record for all other favorites
 *
 * @param mixed $id Id of favorite to move.
 * @param string $direction Direction to move 'up' or 'down'.
 * @return boolean Success
 */
	public function move($id, $direction = 'up') {
		$this->recursive = -1;
		$subject = $this->read(null, $id);
		if ($direction == 'up') {
			$modifier = '+1';
			$targetValue = $subject[$this->alias]['position'] - 1;
			$subject[$this->alias]['position'] -= 1;
		} elseif ($direction == 'down') {
			$modifier = '-1';
			$targetValue = $subject[$this->alias]['position'] + 1;
			$subject[$this->alias]['position'] += 1;
		}
		if (($subject[$this->alias]['position']) < 0) {
			$subject[$this->alias]['position'] = 0;
		}
		$this->updateAll(
			array($this->alias . '.position' => $this->alias . ".position {$modifier}",),
			array(
				$this->alias . '.position =' => $targetValue,
				$this->alias . '.user_id' => $subject[$this->alias]['user_id'],
				$this->alias . '.model' => $subject[$this->alias]['model']
			)
		);
		return $this->save($subject);
	}

/**
 * Check if the current item in on favorites
 *
 * @param $modelName Name of model that $foreignKey belongs to.
 * @param string $type favorite type
 * @param $foreignKey Id of the record to check.
 * @param $userId Id of the user you are looking.
 * @return boolean
 */
	public function isFavorited($modelName, $type, $foreignKey, $userId) {
		$result = $this->getFavoriteId($modelName, $type, $foreignKey, $userId);
		return ($result !== false);
	}

/**
 * Get the id of the object matching the current item in favorites.
 *
 * @param $modelName Name of model that $foreignKey belongs to.
 * @param string $type favorite type
 * @param $foreignKey Id of the record to check.
 * @param $userId Id of the user you are looking.
 * @return mixed The id if the element was favorited, false otherwise
 */
	public function getFavoriteId($modelName, $type, $foreignKey, $userId) {
		$favoriteId = false;
		
		$record = $this->find('first', array(
			'fields' => array($this->alias . '.' . $this->primaryKey),
			'conditions' => array(
				$this->alias . '.model' => $modelName,
				$this->alias . '.foreign_key' => $foreignKey,
				$this->alias . '.user_id' => $userId,
				$this->alias . '.type' => $type
			),
			'recursive' => -1
		));
		if (isset($record[$this->alias][$this->primaryKey])) {
			$favoriteId = $record[$this->alias][$this->primaryKey];
		}
		
		return $favoriteId;
	}

/**
 * Get Supported
 *
 *  - types - list of models associated
 *  - contain - list of models and association we may get
 *
 * @param $type
 * @param $options
 * @return unknown_type
 */
	protected function _getSupported($type, $options = array()) {
		$assocs = array_keys($this->belongsTo);
		$allTypes = $this->_listCategories;
		if (!empty($options['types'])) {
			$allTypes = array_merge($allTypes, $options['types']);
			$assocs = array_merge($assocs, $options['types']);
		}
		$types = array();
		$contain = array();
		foreach ($assocs as $assoc) {
			if (isset($allTypes[$assoc])) {
				$types[$assoc] = $allTypes[$assoc];
				$contain[$assoc] = $allTypes[$assoc];
			} elseif (in_array($assoc, $allTypes) && is_numeric(array_search($assoc, $allTypes))) {
				$types[$assoc] = $assoc;
				$contain[] = $assoc;
			}
		}
		if ($type == 'types') {
			return array_keys($types);
		} else {
			return $contain;
		}
	}

/**
 * Delete with calling model callbacks
 *
 * @param $type
 * @param $options
 * @return boolean
 */
	public function deleteRecord($id) {
		$record = $this->read(null, $id);
		if (empty($record)) {
			return true;
		}
		$record = $record[$this->alias];
		$model = $record['model'];
		$result = $this->delete($id);
		if ($result) {
			$Model = ClassRegistry::init($model);
			if (method_exists($Model, 'afterDeleteFavorite')) {
				$result = $Model->afterDeleteFavorite(array('id' => $record['foreign_key'], 'userId' => $record['user_id'], 'model' => $model, 'type' => $record['type']));
			}
			return $result;
		}
		return $result;
	}
	
}
