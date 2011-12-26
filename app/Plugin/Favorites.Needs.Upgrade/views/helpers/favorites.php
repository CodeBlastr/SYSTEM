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
 * Favorites Helper
 *
 * @package favorites
 * @subpackage favorites.views.helpers
 */
class FavoritesHelper extends AppHelper {

/**
 * Controller action to use as favorite endpoint (CakePHP url)
 * 
 * @var array
 */
	public $favoriteLinkBase = array('admin' => false, 'plugin' => 'favorites', 'controller' => 'favorites');
	
/**
 * Helpers
 * 
 * @var array
 */	
	public $helpers = array('Html', 'Session', 'Js' => 'Jquery', 'Time');
	
/**
 * User favorites - initialized in beforeRender
 * Contains the "userFavorites" variable transmitted to views by the controller
 * Format: array(type => array(favorite-id => item-id))  
 * 
 * @var array
 */
	protected $_userFavorites = array();
	
/**
 * Before render callback
 * Initializes the Helper
 * 
 * @return void
 */
	public function beforeRender() {
		if (ClassRegistry::isKeySet('view')) {
			$View = ClassRegistry::getObject('view');
			$this->_userFavorites = $View->getVar('userFavorites');
		}
	}


/**
 * Displays a correct link to add / remove an item from a given favorite list
 * 
 * If the current user already added the item to the list, the generated link will allow him to
 * remove it from the list otherwise it will generate an add link
 * 
 * @param string $type Favorite type
 * @param string $id Item id
 * @param string $addText Text to use for "add" type links
 * @param string $removeText Text to use for "remove" type links
 * @param array $options Options for the Html->link method
 * @return string Correct Html link
 */
	public function toggleFavorite($type, $id, $addText = null, $removeText = null, $options = array()) {
		$_defaultTexts = Configure::read('Favorites.defaultTexts');
		$link = '';
		$type = strtolower($type);
		
		if (!array_key_exists($type, $_defaultTexts)) {
			trigger_error(sprintf(__d('favorites', 'Incorrect favorite type "%s".', true), $type), E_USER_WARNING);
		} else {
			foreach (array('addText', 'removeText') as $textVarName) {
				if (is_null($$textVarName)) {
					$$textVarName = $_defaultTexts[$type];
				}
			}
			if (empty($options['class'])) {
				$options['class'] = '';
			}
			$options['class'] = $type . ' ' . $options['class'];
			
			$remove = !empty($this->_userFavorites) ? array_key_exists($type, $this->_userFavorites) && in_array($id, $this->_userFavorites[$type]) : null;
			if ($remove) {
				$url = array_merge($this->favoriteLinkBase, array(
					'action' => 'delete',
					array_search($id, $this->_userFavorites[$type])));
				$linkText = $removeText;
				$options['class'] = 'remove-favorite ' . $options['class'];
			} else {
				$url = array_merge($this->favoriteLinkBase, array('action' => 'add', $type, $id));
				$linkText = $addText;
				$options['class'] = 'add-favorite ' . $options['class'];
			}
			$options['class'] = trim($options['class']);
			
			$link = $this->Html->link($linkText, $url, $options);
		}
		
		return $link;
	}
}
