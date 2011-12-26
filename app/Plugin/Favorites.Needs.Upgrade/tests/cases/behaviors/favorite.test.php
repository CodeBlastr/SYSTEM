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
 * FavoriteBehavior Test Case
 *
 * @package favorites
 * @subpackage favorites.tests.cases.behaviors
 */
class FavoriteArticle extends CakeTestModel {

/**
 * useTable
 *
 * @var string
 */
	public $useTable = 'articles';

/**
 * actsAs
 *
 * @var array
 */
	public $actsAs = array('Favorites.Favorite');

/**
 * belongsTo
 *
 * @var array
 */
	public $belongsTo = array(
		'FavoriteUser' => array(
			'className' => 'FavoriteUser',
			'foreignKey' => 'user_id'
		)
	);
}

/**
 * FavoriteUser
 *
 * @package favorites
 * @subpackage favorites.tests.cases.behaviors
 */
class FavoriteUser extends CakeTestModel {

/**
 * useTable
 *
 * @var string
 */
	public $useTable = 'users';
}

/**
 * FavoriteBehaviorTestCase
 *
 * @package favorites
 * @subpackage favorites.tests.cases.behaviors
 */
class FavoriteBehaviorTestCase extends CakeTestCase {

/**
 * fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.favorites.favorite', 'core.article', 'core.user');

/**
 * startTest
 *
 * @return void
 */
	public function startTest() {
		Configure::write('Favorites.types', array('like' => 'FavoriteArticle', 'dislike' => 'FavoriteArticle'));
		Configure::write('Favorites.modelCategories', array('FavoriteArticle'));
		
		$this->Article = ClassRegistry::init('FavoriteArticle');
		$this->FavoriteModel = ClassRegistry::init('Favorites.Favorite');
		$this->Article->Favorite->delete('1');
	}

/**
 * endTest
 *
 * @return void
 */
	public function endTest() {
		unset($this->Article);
		ClassRegistry::flush();
	}

/**
 * test that setup() binds all the models that are needed, and initializes the favoriteTypes attribute correctly
 *
 * @return void
 */
	public function testSetup() {
		$this->assertTrue(isset($this->Article->Favorite));
		$this->assertTrue(isset($this->Article->Favorite->FavoriteArticle));

		$assoc = $this->Article->hasMany['Favorite'];
		$this->assertEqual($assoc['className'], 'Favorite');
		$this->assertEqual($assoc['conditions'], array('Favorite.model' => 'FavoriteArticle'));

		$assoc = $this->Article->Favorite->belongsTo['FavoriteArticle'];
		$this->assertEqual($assoc['counterCache'], 'favorite_count');
		$this->assertEqual($assoc['conditions'], '');
		
		$expected = array(
			'like' => array('limit' => null, 'model' => 'FavoriteArticle'),
			'dislike' => array('limit' => null, 'model' => 'FavoriteArticle'));
		$this->assertEqual($this->Article->Behaviors->Favorite->favoriteTypes, $expected);
	}

/**
 * Test saving of favorites
 *
 * @return void
 */
	public function testSaveFavorite() {
		$result = $this->Article->saveFavorite(1, 'FavoriteArticle', 'default', 1);
		$this->assertTrue($result);

		$result = $this->FavoriteModel->read();
		$this->assertEqual($result['Favorite']['user_id'], 1);
		$this->assertEqual($result['Favorite']['model'], 'FavoriteArticle');
		$this->assertEqual($result['Favorite']['foreign_key'], 1);
		$oldId = $result['Favorite']['id'];

		//save twice will fail
		try {
			$result = $this->Article->saveFavorite(1, 'FavoriteArticle', 'default', 1);
			$this->fail('No Exception');
		} catch (Exception $e) {
			$error = $e->getMessage();
			$this->assertEqual($error, 'Already added.');
		}

		$result = $this->FavoriteModel->read();
		$this->assertEqual($result['Favorite']['user_id'], 1);
		$this->assertEqual($result['Favorite']['model'], 'FavoriteArticle');
		$this->assertEqual($result['Favorite']['foreign_key'], 1);
		$this->assertEqual($oldId, $result['Favorite']['id']);
	}
	
/**
 * Test saving of favorites with a limit of favorites per user
 *
 * @return void
 */
	public function testSaveFavoriteWithLimit() {
		$this->Article->Behaviors->Favorite->favoriteTypes = array(
			'like' => array('limit' => 2, 'model' => 'FavoriteArticle'),
			'dislike' => array('limit' => null, 'model' => 'FavoriteArticle'));
		
		$result = $this->Article->saveFavorite(1, 'FavoriteArticle', 'like', 1);
		$this->assertTrue($result);
		$result = $this->Article->saveFavorite(1, 'FavoriteArticle', 'like', 2);
		$this->assertTrue($result);
		
		try {
			$this->Article->saveFavorite(1, 'FavoriteArticle', 'like', 3);
			$this->fail('No exception thrown when saving too many favorites');		
		} catch (Exception $e) {
			$this->assertEqual($e->getMessage(), 'You cannot add more than 2 items to this list');
		}
		$result = $this->Article->saveFavorite(2, 'FavoriteArticle', 'like', 3);
		$this->assertTrue($result);
	}
	
/**
 * test that as favorites are added they appended to the end of the stack
 *
 * @return void
 */
	public function testIncrementingFavorites() {
		$this->Article->saveFavorite(1, 'FavoriteArticle', 'default', 1);
		$result = $this->FavoriteModel->read();
		$this->assertEqual($result['Favorite']['position'], 0);

		$this->Article->saveFavorite(1, 'FavoriteArticle', 'default', 2);
		$result = $this->FavoriteModel->read();
		$this->assertEqual($result['Favorite']['position'], 1);

		$this->Article->saveFavorite(1, 'FavoriteArticle', 'default', 12334);
		$result = $this->FavoriteModel->read();
		$this->assertEqual($result['Favorite']['position'], 2);

		$this->Article->saveFavorite(22222, 'FavoriteArticle', 'default', 12334);
		$result = $this->FavoriteModel->read();
		$this->assertEqual($result['Favorite']['position'], 0);
	}
}
