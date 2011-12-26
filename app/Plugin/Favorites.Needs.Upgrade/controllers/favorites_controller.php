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
 * Favorites Controller
 *
 * @package favorites
 * @subpackage favorites.controllers
 */
class FavoritesController extends FavoritesAppController {

/**
 * Controller name
 *
 * @var string
 */
	public $name = 'Favorites';

	public $uses = array('Favorites.Favorite');

/**
 * Allowed Types of things to be favorited
 * Maps types to models so you don't have to expose model names if you don't want to.
 *
 * @var array
 */
	public $favoriteTypes = array(
		'wish' => array('CatalogItem', 'Category', 'Gallery', 'GalleryImage'),
		'favorite' => array('CatalogItem', 'Category', 'Gallery', 'GalleryImage'),
		'watch' => 'Watch',
	);

/**
 * beforeFilter callback
 *
 * @return void
 */
	public function beforeFilter() {
		parent::beforeFilter();
		$this->Auth->deny($this->Auth->allowedActions);
		$types = Configure::read('Favorites.types');
		if (!empty($types)) {
			$this->favoriteTypes = array();
			// Keep only key / values (type / model)
			foreach ((array) $types as $key => $type) {
				if (is_string($type)) {
					$this->favoriteTypes[$key] = $type;
				} elseif (is_array($type) && array_key_exists('model', $type)) {
					$this->favoriteTypes[$key] = $type['model'];
				}
			}
		}
		$this->set('authMessage', __d('favorites', 'Authentication required', true));
	}

/**
 * Create a new favorite for the specific type.
 *
 * @param string $type
 * @param string $foreignKey
 * @return void
 */
	public function add($type = null, $foreignKey = null) {
		$status = 'error';
		if (!isset($this->favoriteTypes[$type])) {
			$message = __d('favorites', 'Invalid object type.', true);
		} else {
			$Subject = ClassRegistry::init($this->favoriteTypes[$type]);
			$Subject->id = $foreignKey;
			# A Zuha Added Fix to Make Favorites Easier to Add to New Sections
			$this->Favorite->model = $this->favoriteTypes[$type];
			//$this->Favorite->model = $type;
			# End Zuha Added Fix
			//if (!$Subject->exists()) {
			//	$message = __d('favorites', 'Invalid identifier', true);
			//} else {
			# End Zuha Added Fix
				try {
					$result = $Subject->saveFavorite($this->Auth->user('id'), $Subject->name, $type, $foreignKey);
					if ($result) {
						$status = 'success';
						$message = __d('favorites', 'Record was successfully added', true);
					} else {
						$message = __d('favorites', 'Record was not added.', true);
					}			
				} catch (Exception $e) {
					$message = __d('favorites', 'Record was not added. ', true) . $e->getMessage();
				}
			//}
		}
		$this->set(compact('status', 'message', 'type', 'foreignKey'));
		if (!empty($this->request->params['isJson'])) {
			return $this->render();
		} else {
			return $this->redirect($this->referer());
		}
	}

/**
 * Delete a favorite by Id
 *
 * @param mixed $id Id of favorite to delete.
 * @return void
 */
	public function delete($id = null) {
		$status = 'error';
		if (($message = $this->_isOwner($id)) !== true) {
			// Message defined
		} else if ($this->Favorite->deleteRecord($id)) {
			$status = 'success';
			$message = __d('favorites', 'Record removed from list', true);
		} else {
			$message = __d('favorites', 'Unable to delete favorite, please try again', true);
		}

		$this->set(compact('status', 'message'));
		return $this->redirect($this->referer(), -999);
	}

/**
 * Get a list of favorites for a User by type.
 *
 * @param string $type
 * @return void
 */
	public function short_list($type = null) {
		$type = Inflector::underscore($type);
		if (!isset($this->favoriteTypes[$type])) {
			$this->Session->setFlash(__d('favorites', 'Invalid object type.', true));
			return;
		}
		$userId = $this->Auth->user('id');
		$favorites = $this->Favorite->getByType($userId);
		$this->set(compact('favorites', 'type'));
		#$this->render('list');
	}

/**
 * Get all favorites for a specific user and $type
 *
 * @param string $type Type of favorites to get
 * @return void
 */
	public function list_all($type = null) {
		$type = strtolower($type);
		if (!isset($this->favoriteTypes[$type])) {
			$this->Session->setFlash(__d('favorites', 'Invalid object type.', true));
			return;
		}
		$userId = $this->Auth->user('id');
		$favorites = $this->Favorite->getByType($userId, array('limit' => 100, 'type' => $type));
		$this->set(compact('favorites', 'type'));
		#$this->render('list');
	}

/**
 * Move a favorite up or down a position.
 *
 * @param mixed $id Id of favorite to move.
 * @param string $direction direction to move (only up and down are accepted)
 * @return void
 */
	public function move($id = null, $direction = 'up') {
		$status = 'error';
		$direction = strtolower($direction);
		if (($message = $this->_isOwner($id)) !== true) {
			// Message defined
		} else if ($direction !== 'up' && $direction !== 'down') {
			$message = __d('favorites', 'Invalid direction', true);
		} else if ($this->Favorite->move($id, $direction)) {
			$status = 'success';
			$message = __d('favorites', 'Favorite positions updated.', true);
		} else {
			$message = __d('favorites', 'Unable to change favorite position, please try again', true);
		}

		$this->set(compact('status', 'message'));
		return $this->redirect($this->referer());
	}

/**
 * Overload Redirect.  Many actions are invoked via Xhr, most of these
 * require a list of current favorites to be returned.
 *
 * @param string $url
 * @param unknown $code
 * @param boolean $exit
 * @return void
 */
	public function redirect($url, $code = null, $exit = true) {
		if ($code == -999) {
			parent::redirect($url, null, $exit);
		}
		if (!empty($this->viewVars['authMessage']) && !empty($this->request->params['isJson'])) {
			$this->RequestHandler->renderAs($this, 'json');
			$this->set('message', $this->viewVars['authMessage']);
			$this->set('status', 'error');
			echo $this->render('add');
			$this->_stop();
		}
		if (!empty($this->request->params['isAjax']) || !empty($this->request->params['isJson'])) {
			return $this->setAction('short_list', $this->Favorite->model);
		} else if (isset($this->viewVars['status']) && isset($this->viewVars['message'])) {
			$this->Session->setFlash($this->viewVars['message'], 'default', array(), $this->viewVars['status']);
		} elseif (!empty($this->viewVars['authMessage'])) {
			$this->Session->setFlash($this->viewVars['authMessage']);
		}

		parent::redirect($url, $code, $exit);
	}

/**
 * Checks that the favorite exists and that it belongs to the current user.
 *
 * @param mixed $id Id of Favorite to check up on.
 * @return boolean true if the current user owns this favorite.
 */
	protected function _isOwner($id) {
		$this->Favorite->id = $id;
		$favorite = $this->Favorite->read();
		$this->Favorite->model = $favorite['Favorite']['model'];
		if (empty($favorite)) {
			return __d('favorites', 'That record does not exist.', true);
		}
		if ($favorite['Favorite']['user_id'] != $this->Auth->user('id')) {
			return __d('favorites', 'That record does not belong to you.', true);
		}
		return true;
	}
}
