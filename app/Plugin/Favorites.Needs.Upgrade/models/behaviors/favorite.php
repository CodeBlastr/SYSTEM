<?php
/**
 * Favorite Behavior
 *
 * Attach to a Model to create hasMany relationship with Favorite model and
 * include counterCache, also provides some utility methods for favorites, like reordering,
 *
 * PHP versions 4 and 5
 *
 * Copyright 2007-2008, Cake Development Corporation
 * 							1785 E. Sahara Avenue, Suite 490-423
 * 							Las Vegas, Nevada 89104
 *
 * You may obtain a copy of the License at:
 * License page: http://projects.cakedc.com/licenses/TBD  TBD
 * Copyright page: http://converge.cakedc.com/copyright/
 *
 * @filesource
 * @copyright     Copyright 2007-2008, Cake Development Corporation
 * @link
 * @package       favorites
 * @subpackage    favorites.models.behaviors
 */

/**
 * Favorite behavior
 *
 * @package favorites
 * @subpackage favorites.models.behaviors
 */
class FavoriteBehavior extends ModelBehavior {

/**
 * Settings array
 *
 * @var array
 */
	public $settings = array();

/**
 * Allowed Types of things to be favorited
 * Maps types to models so you don't have to expose model names if you don't want to.
 * 
 *
 * @var array Types with the following format:
 * <code>
 * 	array(
 * 		'type1' => array('limit' => null, 'model' => 'Model'),
 * 		'type2' => array('limit' => 10, 'model' => 'OtherModel'));
 * </code>
 */
	public $favoriteTypes = array();

/**
 * Default settings
 *
 * favoriteClass			- class name of the table storing the favorites
 * field					- the fieldname that contains the raw tags as string
 * foreignKey				- foreignKey used in the hasMany association
 * counterCache				- name of the field to hold the counterCache
 *
 * @var array
 */
	protected $_defaults = array(
		'favoriteClass' => 'Favorites.Favorite',
		'favoriteAlias' => 'Favorite',
		'foreignKey' => 'foreign_key',
		'counterCache' => 'favorite_count',
	);

/**
 * Setup the behavior
 *
 * @param Model $Model
 * @param array $settings
 * @return void
 */
	public function setup(Model $Model, $settings = array()) {
		
		if (!Configure::read('Favorites')) {
			if (defined('__FAVORITES_CONFIG_PATH')) {
				#@todo  Need to get this working with /sites/DOMAIN/config/favorites/[FILENAME]
				#$settingsPath = APP_DIR.__FAVORITES_CONFIG_PATH;
			} else {
				Configure::load('favorites.default');
			}
		}
		
		if (!isset($this->settings[$Model->alias])) {
			$this->settings[$Model->alias] = $this->_defaults;
		}
		$this->settings[$Model->alias] = am($this->settings[$Model->alias], is_array($settings) ? $settings : array());
		$favoriteClass = $this->settings[$Model->alias]['favoriteClass'];
		$favoriteAlias = $this->settings[$Model->alias]['favoriteAlias'];

		$Model->bindModel(array('hasMany' => array(
			'Favorite' => array(
				'className' => $favoriteClass,
				'foreignKey' => $this->settings[$Model->alias]['foreignKey'],
				'conditions' => array($favoriteAlias . '.model' => $Model->name),
				'fields' => '',
				'dependent' => true,
		))), false);

		$Model->{$favoriteAlias}->bindModel(array('belongsTo' => array(
			$Model->alias => array(
				'className' => $Model->name,
				'foreignKey' => $this->settings[$Model->alias]['foreignKey'],
				'fields' => '',
				'counterCache' => $this->settings[$Model->alias]['counterCache']
			),
		)), false);
		
		$types = Configure::read('Favorites.types');
		$this->favoriteTypes = array();
		if (!empty($types)) {
			foreach ((array) $types as $key => $type) {
				$this->favoriteTypes[$key] = is_array($type) ? $type : array('model' => $type);
				if (empty($this->favoriteTypes[$key]['limit'])) {
					$this->favoriteTypes[$key]['limit'] = null;
				}
			}
		}
	}

/**
 * Save a favorite for a user - Checks for existing identical favorite first
 *
 * @throws Exception When it is impossible to save the favorite
 * @param mixed $userId Id of the user.
 * @param string $modelName Name of model
 * @param string $type favorite type
 * @param mixed $foreignKey foreignKey
 * @return boolean success of save Returns true if the favorite record already exists.
 */
	public function saveFavorite(Model $Model, $userId, $modelName, $type, $foreignKey) {
		if (method_exists($Model, 'beforeSaveFavorite')) {
			$result = $Model->beforeSaveFavorite(array('id' => $foreignKey, 'userId' => $userId, 'model' => $modelName, 'type' => $type));
			if (!$result) {
				throw new Exception(__d('favorites', 'Operation is not allowed', true));
			}
		}
	
		$existing = $Model->Favorite->find('count', array(
			'conditions' => array(
				'Favorite.user_id' => $userId,
				'Favorite.model' => $modelName,
				'Favorite.type' => $type,
				'Favorite.foreign_key' => $foreignKey)));
		if ($existing > 0) {
			throw new Exception(__d('favorites', 'Already added.', true));
		}
		
		if (array_key_exists($type, $this->favoriteTypes) && !is_null($this->favoriteTypes[$type]['limit'])) {
			$currentCount = $Model->Favorite->find('count', array(
				'conditions' => array(
					'Favorite.user_id' => $userId,
					'Favorite.type' => $type)));
			if ($currentCount >= $this->favoriteTypes[$type]['limit']) {
				throw new Exception(sprintf(
					__d('favorites', 'You cannot add more than %s items to this list', true),
					$this->favoriteTypes[$type]['limit']));
			}
		}
		
		$data = array(
			'user_id' => $userId,
			'model' => $modelName,
			'foreign_key' => $foreignKey,
			'type' => $type,
			'position' => $this->_getNextPosition($Model, $userId, $modelName, $type));
		$Model->Favorite->create($data);
		$result = $Model->Favorite->save();
		if ($result && method_exists($Model, 'afterSaveFavorite')) {
			$result = $Model->afterSaveFavorite(array('id' => $foreignKey, 'userId' => $userId, 'model' => $modelName, 'type' => $type, 'data' => $result));
		}
		return $result;
	}

/**
 * Get the next value for the order field based on the user and model
 *
 * @param AppModel $Model
 * @param mixed $userId
 * @param string $modelName
 * @param string $type favorite type
 * @return int
 */
	protected function _getNextPosition($Model, $userId, $modelName, $type) {
		$position = 0;
		$max = $Model->Favorite->find('first', array(
			'fields' => array('MAX(Favorite.position) AS max_position'),
			'conditions' => array(
				'Favorite.user_id' => $userId,
				'Favorite.model' => $modelName,
				'Favorite.type' => $type)));
		if (isset($max[0]['max_position'])) {
			$position = $max[0]['max_position'] + 1;
		}
		return $position;
	}
}
