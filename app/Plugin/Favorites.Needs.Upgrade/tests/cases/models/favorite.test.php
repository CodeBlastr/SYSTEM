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
 * Favorite Model Test Case
 *
 * @package favorites
 * @subpackage favorites.tests.cases.models
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
 * @subpackage favorites.tests.cases.models
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
 * FavoriteTestCase
 *
 * @package favorites
 * @subpackage favorites.tests.cases.models
 */
class FavoriteTestCase extends CakeTestCase {

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
 * test that setup() binds all the models that are needed.
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
	}

/**
 * Test moving favorites.
 *
 * @return void
 */
	public function testMove() {
		$this->Article->saveFavorite(1, 'FavoriteArticle', 'default', 1);
		$this->Article->saveFavorite(1, 'FavoriteArticle', 'default', 2);
		$this->Article->saveFavorite(1, 'FavoriteArticle', 'default', 3);
		$this->Article->saveFavorite(1, 'FavoriteArticle', 'default', 4);

		$this->FavoriteModel->cacheQueries = false;
		$current = $this->FavoriteModel->findByForeignKey(4);

		$this->Article->Favorite->move($current['Favorite']['id'], 'up');
		$new = $this->FavoriteModel->findByForeignKey(4);
		$this->assertEqual($new['Favorite']['position'], $current['Favorite']['position'] - 1);

		$this->Article->Favorite->move($current['Favorite']['id'], 'down');
		$new = $this->FavoriteModel->findByForeignKey(4);
		$this->assertEqual($new['Favorite']['position'], $current['Favorite']['position']);

		$current = $this->FavoriteModel->findByForeignKey(1);
		$this->Article->Favorite->move($current['Favorite']['id'], 'up');
		$new = $this->FavoriteModel->findByForeignKey(1);
		$this->assertEqual($new['Favorite']['position'], $current['Favorite']['position']);

		$current = $this->FavoriteModel->findByForeignKey(1);
		$this->Article->Favorite->move($current['Favorite']['id'], 'down');
		$new = $this->FavoriteModel->findByForeignKey(1);
		$this->assertEqual($new['Favorite']['position'], $current['Favorite']['position'] + 1);

		$new = $this->FavoriteModel->findByForeignKey(2);
		$this->assertEqual($new['Favorite']['position'], 0);

		$all = $this->FavoriteModel->find('all', array(
			'order' => 'Favorite.position ASC',
			'conditions' => array('Favorite.user_id' => 1)
		));
		$positions = Set::extract('/Favorite/position', $all);
		$this->assertEqual($positions, array(0,1,2,3));
	}

/**
 * test get favorites on Favorite model
 *
 * @return void
 */
	public function testGetFavorites() {
		$this->Article->saveFavorite(1, 'FavoriteArticle', 'default', 1);
		$this->Article->saveFavorite(1, 'FavoriteArticle', 'default', 2);
		$this->Article->saveFavorite(1, 'FavoriteArticle', 'default', 3);

		$result = $this->FavoriteModel->getFavorites(1, array('types' => array('FavoriteArticle'), 'type' => 'default'));
		$this->assertEqual(count($result), 3);
		$this->assertTrue(isset($result[0]['FavoriteArticle']['id']));
		$this->assertTrue(isset($result[1]['FavoriteArticle']['id']));
		$this->assertTrue(isset($result[2]['FavoriteArticle']['id']));
	}

/**
 * test get favorites with extra types (models and associations)
 *
 * @return void
 */
	public function testGetFavoritesWithExtraTypes() {
		$this->FavoriteModel->Behaviors->attach('Containable');
		$this->Article->saveFavorite(1, 'FavoriteArticle', 'default', 1);
		$this->Article->saveFavorite(1, 'FavoriteArticle', 'default', 2);
		$this->Article->saveFavorite(1, 'FavoriteArticle', 'default', 3);

		$result = $this->FavoriteModel->getFavorites(1, array('types' => array('FavoriteArticle'), 'type' => 'default'));
		$this->assertEqual(count($result), 3);
		$this->assertTrue(isset($result[0]['FavoriteArticle']['id']));
		$this->assertFalse(isset($result[0]['FavoriteArticle']['FavoriteUser']));
		$this->assertTrue(isset($result[1]['FavoriteArticle']['id']));
		$this->assertFalse(isset($result[1]['FavoriteArticle']['FavoriteUser']));
		$this->assertTrue(isset($result[2]['FavoriteArticle']['id']));
		$this->assertFalse(isset($result[2]['FavoriteArticle']['FavoriteUser']));

		$result = $this->FavoriteModel->getFavorites(1, array(
			'types' => array('FavoriteArticle' => 'FavoriteUser'),
			'type' => 'default'));
		$this->assertEqual(count($result), 3);
		$this->assertTrue(isset($result[0]['FavoriteArticle']['id']));
		$this->assertTrue(isset($result[0]['FavoriteArticle']['FavoriteUser']));
		$this->assertTrue(isset($result[1]['FavoriteArticle']['id']));
		$this->assertTrue(isset($result[1]['FavoriteArticle']['FavoriteUser']));
		$this->assertTrue(isset($result[2]['FavoriteArticle']['id']));
		$this->assertTrue(isset($result[2]['FavoriteArticle']['FavoriteUser']));
	}

/**
 * Test that getByType behaves as expected
 *
 * @return void
 */
	public function testGetByType() {
		$this->Article->saveFavorite(1, 'FavoriteArticle', 'default', 1);
		$this->Article->saveFavorite(1, 'FavoriteArticle', 'default', 2);
		$this->Article->saveFavorite(1, 'FavoriteArticle', 'default', 3);

		$result = $this->FavoriteModel->getByType(1, array('types' => array('FavoriteArticle'), 'type' => 'default'));
		$this->assertTrue(isset($result['FavoriteArticle']));
		$this->assertEqual(count($result['FavoriteArticle']), 3);
	}

/**
 * undocumented function
 *
 * @return void
 */
	public function testTypeCounts() {
		$this->Article->saveFavorite(1, 'FavoriteArticle', 'default', 1);
		$this->Article->saveFavorite(1, 'FavoriteOther', 'default', 2);
		$this->Article->saveFavorite(1, 'FavoriteOther', 'default', 3);
		$this->Article->saveFavorite(1, 'FavoriteArticle', 'default', 3);

		$this->FavoriteModel->bindModel(array(
			'hasMany' => array(
				'FavoriteOther' => array('className' => 'FavoriteArticle'),
				'OtherModel' => array('className' => 'FavoriteArticle')
			)
		), false);
		$results = $this->FavoriteModel->typeCounts(1, array('types' => array('FavoriteArticle', 'FavoriteOther')));

		$this->assertEqual($results['FavoriteArticle'], 2);
		$this->assertEqual($results['FavoriteOther'], 2);
		
		$results = $this->FavoriteModel->typeCounts(1, array('types' => array('OtherModel', 'FavoriteArticle', 'FavoriteOther')));

		$this->assertEqual($results['FavoriteArticle'], 2);
		$this->assertEqual($results['FavoriteOther'], 2);
		$this->assertEqual($results['OtherModel'], 0);
	}

/**
 * test checking if a user has favorited something.
 *
 * @return void
 */
	public function testIsFavorited() {
		$this->assertTrue($this->Article->saveFavorite(1, 'FavoriteArticle', 'default', 1));
		$result = $this->FavoriteModel->isFavorited('FavoriteArticle', 'default', 1, 1);
		$this->assertTrue($result, 'Return is wrong, should be true. %s');

		$result = $this->FavoriteModel->isFavorited('FavoriteArticle', 'default', 1, 2);
		$this->assertFalse($result, 'User with no favorites, is being shown as having one. %s');
	}
	
/**
 * Test getFavoriteId method
 *
 * @return void
 */
	public function testGetFavoriteId() {
		$this->assertTrue($this->Article->saveFavorite(1, 'FavoriteArticle', 'default', 1));
		$result = $this->FavoriteModel->getFavoriteId('FavoriteArticle', 'default', 1, 1);
		$this->assertFalse(empty($result));
		
		$result = $this->FavoriteModel->getFavoriteId('FavoriteArticle', 'default', 1, 2);
		$this->assertFalse($result, 'User with no favorites, is being shown as having one. %s');
	}
	
/**
 * testGetFavoriteLists
 *
 * @return void
 */
	public function testGetFavoriteLists() {
		$this->Article->saveFavorite(1, 'FavoriteArticle', 'default', 1);
		$this->Article->saveFavorite(1, 'FavoriteArticle', 'default', 2);
		$this->Article->saveFavorite(1, 'FavoriteArticle', 'default', 3);
		$result = $this->FavoriteModel->getFavoriteLists('default', 1);		
		$expected = array(
			'FavoriteArticle' => array(
		        array('id' => '1', 'title' => 'First Article'),
		        array('id' => '2', 'title' => 'Second Article'),
		        array('id' => '3', 'title' => 'Third Article')));		
		$this->assertEqual($result, $expected);
	}
}
