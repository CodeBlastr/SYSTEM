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

App::import('Core', 'View');
App::import('Helper', array('Favorites.Favorites', 'Html'));

/**
 * Favorites Helper Test Case
 *
 * @package favorites
 * @subpackage favorites.tests.cases.helpers
 */
class FavoritesHelperTestCase extends CakeTestCase {

/**
 * startTest
 *
 * @return void
 */
	public function startTest() {
		$this->View = new View($controller = null);
		ClassRegistry::addObject('view', $this->View);
		Configure::write('Favorites', array(
			'types' => array(
				'favorite' => 'Article',
				'watch' => 'Article'
			),
			'defaultTexts' => array(
				'favorite' => 'Favorite it',
				'watch' => 'Watch it'
			),
			'modelCategories' => array('Article')
		));
		$this->Favorites = new FavoritesHelper;
		$this->Favorites->Html = new HtmlHelper;
	}

/**
 * endTest
 *
 * @return void
 */
	public function endTest() {
		ClassRegistry::flush();
	}

/**
 * tests that genereting a favorite link for a wrong type raises an error
 *
 * @return void
 */
	public function testToggleFavoriteWithWrongType() {
		$this->expectError('Incorrect favorite type "love".');
		$this->Favorites->toggleFavorite('love', 1);
	}

/**
 * tests the generation of a simple link to add a favorite
 *
 * @return void
 */
	public function testToggleFavorite() {
		$result = $this->Favorites->toggleFavorite('watch', 1);
		$this->assertEqual($result, '<a href="/favorites/favorites/add/watch/1" class="add-favorite watch">Watch it</a>');
	}

/**
 * tests the generation of a simple link to remove a favorite
 *
 * @return void
 */
	public function testToggleFavoriteWithRemove() {
		$this->View->viewVars['userFavorites'] = array('watch' => array('my-thing-id'));
		$this->Favorites->beforeRender();
		$result = $this->Favorites->toggleFavorite('watch', 'my-thing-id');
		$this->assertEqual($result, '<a href="/favorites/favorites/delete/0" class="remove-favorite watch">Watch it</a>');

		$result = $this->Favorites->toggleFavorite('watch', 'my-thing-id', null, 'Stop watching');
		$this->assertEqual($result, '<a href="/favorites/favorites/delete/0" class="remove-favorite watch">Stop watching</a>');
	}
}
