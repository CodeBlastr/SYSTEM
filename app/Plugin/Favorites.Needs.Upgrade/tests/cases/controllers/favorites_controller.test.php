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

App::import('Controller', 'Favorites.Favorites');
App::import('Component', array('Auth'));
Mock::generate('AuthComponent', 'FavoritesControllerTestAuthComponent');

/**
 * FavoritesController Test Case
 *
 * @package favorites
 * @subpackage favorites.tests.cases.controllers
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
 * @subpackage favorites.tests.cases.controllers
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
 * TestFavoritesController
 *
 * @package favorites
 * @subpackage favorites.tests.cases.controllers
 */
class TestFavoritesController extends FavoritesController {

/**
 * Auto render
 *
 * @var boolean
 */
	public $autoRender = false;

/**
 * Redirect URL
 *
 * @var mixed
 */
	public $redirectUrl = null;

/**
 * Rendered view
 *
 * @var string
 */
	public $renderedView = null;
 
/**
 * Override controller method for testing
 * @todo find way to not rewrite code here
 *
 */
	public function redirect($url, $status = null, $exit = true) {
		if (!empty($this->request->params['isAjax'])) {
			return $this->setAction('short_list', $this->Favorite->model);
		} else if (isset($this->viewVars['status']) && isset($this->viewVars['message'])) {
			$this->Session->setFlash($this->viewVars['message'], 'default', array(), $this->viewVars['status']);
			$this->redirectUrl = $url;
		}
	}

/**
 * Override controller method for testing
 *
 * @param string $action 
 * @param string $layout 
 * @param string $file 
 * @return void
 */
	public function render($action = null, $layout = null, $file = null) {
		$this->renderedView = $action;
	} 
}

/**
 * FavoritesControllerTestCase
 *
 * @package favorites
 * @subpackage favorites.tests.cases.controllers
 */
class FavoritesControllerTestCase extends CakeTestCase {
	
/**
 * Fixtures
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
		$this->Favorites = new TestFavoritesController();
		$this->Favorites->constructClasses();
		$this->Favorites->Auth = new FavoritesControllerTestAuthComponent();
		$this->Favorites->params = array(
			'named' => array(),
			'pass' => array(),
			'url' => array());
	}

/**
 * endTest
 *
 * @return void
 */
	public function endTest() {
		unset($this->Favorites);
		ClassRegistry::flush();
	}

/**
 * assertFlash
 *
 * @param string $message 
 * @return void
 */
	public function assertFlash($message) {
		$flash = $this->Favorites->Session->read('Message.flash');
		$this->assertEqual($flash['message'], $message);
	}

/**
 * Test beforeFilter method
 * 
 * @return void
 */
	public function testBeforeFilter() {
		$expected = array('like' => 'FavoriteArticle', 'dislike' => 'FavoriteArticle');
		
		$this->Favorites->favoriteTypes = array();
		$this->Favorites->beforeFilter();
		$this->assertEqual($this->Favorites->favoriteTypes, $expected);
		
		Configure::write('Favorites.types', array(
			'like' => array('limit' => 10,'model' => 'FavoriteArticle'),
			'dislike' => 'FavoriteArticle'));
		$this->Favorites->favoriteTypes = array();
		$this->Favorites->beforeFilter();
		$this->assertEqual($this->Favorites->favoriteTypes, $expected);
	}

/**
 * testAdd
 *
 * @return void
 */
	public function testAdd() {
		$_SERVER['HTTP_REFERER'] = '/articles/index';
		$this->Favorites->Auth->setReturnValue('user', 1, array('id'));
		$this->Favorites->beforeFilter();
		$this->Favorites->add('like', 2);
		$this->assertEqual($this->Favorites->redirectUrl, '/articles/index');
	}

/**
 * testAddJson
 *
 * @return void
 */
	public function testAddJson() {
		$this->Favorites->Auth->setReturnValue('user', 1, array('id'));
		$this->Favorites->beforeFilter();
		$this->Favorites->params['isJson'] = true;
		$this->Favorites->add('like', 1);
		$this->assertEqual($this->Favorites->redirectUrl, null);
		$this->assertEqual($this->Favorites->viewVars['message'], 'Record was successfully added');
		$this->assertEqual($this->Favorites->viewVars['status'], 'success');
	}

/**
 * testAddTwiceFailJson
 *
 * @return void
 */
	public function testAddTwiceFailJson() {
		$this->Favorites->Auth->setReturnValue('user', 1, array('id'));
		$this->Favorites->beforeFilter();
		$this->Favorites->params['isJson'] = true;
		$this->Favorites->add('like', 2);
		$this->Favorites->add('like', 2);
		$this->assertEqual($this->Favorites->redirectUrl, null);
		$this->assertEqual($this->Favorites->viewVars['message'], 'Record was not added. Already added.');
		$this->assertEqual($this->Favorites->viewVars['status'], 'error');
	}

/**
 * testAddTwiceDifferentTypes
 *
 * @return void
 */
	public function testAddTwiceDifferentTypes() {
		$this->Favorites->Auth->setReturnValue('user', 1, array('id'));
		$this->Favorites->beforeFilter();
		$this->Favorites->params['isJson'] = true;
		$this->Favorites->add('like', 1);
		$this->Favorites->add('dislike', 1);
		$this->assertEqual($this->Favorites->redirectUrl, null);
		$this->assertEqual($this->Favorites->viewVars['message'], 'Record was successfully added');
		$this->assertEqual($this->Favorites->viewVars['status'], 'success');
	}

/**
 * testAddUnexists
 *
 * @return void
 */
	public function testAddUnexists() {
		$this->Favorites->Auth->setReturnValue('user', 1, array('id'));
		$this->Favorites->beforeFilter();
		$this->Favorites->params['isJson'] = true;
		$this->Favorites->add('like', 999);
		$this->assertEqual($this->Favorites->redirectUrl, null);
		$this->assertEqual($this->Favorites->viewVars['message'], 'Invalid identifier');
		$this->assertEqual($this->Favorites->viewVars['status'], 'error');
	}

/**
 * testAddWrongType
 *
 * @return void
 */
	public function testAddWrongType() {
		$this->Favorites->Auth->setReturnValue('user', 1, array('id'));
		$this->Favorites->beforeFilter();
		$this->Favorites->params['isJson'] = true;
		$this->Favorites->add('wrongtype', 999);
		$this->assertEqual($this->Favorites->redirectUrl, null);
		$this->assertEqual($this->Favorites->viewVars['message'], 'Invalid object type.');
		$this->assertEqual($this->Favorites->viewVars['status'], 'error');
	}
	
/**
 * testDelete
 *
 * @return void
 */
	public function testDelete() {
		$_SERVER['HTTP_REFERER'] = '/articles/index';
		$this->Favorites->Auth->setReturnValue('user', 1, array('id'));
		$this->Favorites->beforeFilter();
		$this->Favorites->add('like', 1);
		$this->Favorites->delete($this->Favorites->Favorite->id);
		$this->assertEqual($this->Favorites->viewVars['message'], 'Record removed from list');
		$this->assertEqual($this->Favorites->viewVars['status'], 'success');
		$this->assertEqual($this->Favorites->redirectUrl, '/articles/index');
	}

/**
 * testDeleteNotExists
 *
 * @return void
 */
	public function testDeleteNotExists() {
		$_SERVER['HTTP_REFERER'] = '/articles/index';
		$this->Favorites->Auth->setReturnValue('user', 1, array('id'));
		$this->Favorites->beforeFilter();
		$this->Favorites->add('like', 1);
		$this->Favorites->delete('999');
		$this->assertEqual($this->Favorites->viewVars['message'], 'That record does not exist.');
		$this->assertEqual($this->Favorites->viewVars['status'], 'error');
		$this->assertEqual($this->Favorites->redirectUrl, '/articles/index');
	}

/**
 * testDeleteOtherUsers
 *
 * @return void
 */
	public function testDeleteOtherUsers() {
		$_SERVER['HTTP_REFERER'] = '/articles/index';
		$this->Favorites->Auth->setReturnValueAt(0, 'user', 1, array('id'));
		$this->Favorites->Auth->setReturnValueAt(1, 'user', 2, array('id'));
		$this->Favorites->beforeFilter();
		$this->Favorites->add('like', 1);
		$this->Favorites->delete($this->Favorites->Favorite->id);
		$this->assertEqual($this->Favorites->viewVars['message'], 'That record does not belong to you.');
		$this->assertEqual($this->Favorites->viewVars['status'], 'error');
		$this->assertEqual($this->Favorites->redirectUrl, '/articles/index');
		// $this->assertEqual($this->Favorites->viewVars['message'], 'Unable to delete favorite, please try again');
	}

/**
 * testMove
 *
 * @return void
 */
	public function testMove() {
		$_SERVER['HTTP_REFERER'] = '/articles/index';
		$this->Favorites->Auth->setReturnValue('user', 1, array('id'));
		$this->Favorites->beforeFilter();
		$this->Favorites->add('like', 1);
		$fav1 = $this->Favorites->Favorite->id;
		$this->Favorites->add('like', 2);
		$fav2 = $this->Favorites->Favorite->id;
		$this->Favorites->move($fav2, 'up');
		$this->assertEqual($this->Favorites->viewVars['message'], 'Favorite positions updated.');
		$this->assertEqual($this->Favorites->viewVars['status'], 'success');
		$this->assertEqual($this->Favorites->redirectUrl, '/articles/index');
	}

/**
 * testMoveWrongDirection
 *
 * @return void
 */
	public function testMoveWrongDirection() {
		$_SERVER['HTTP_REFERER'] = '/articles/index';
		$this->Favorites->Auth->setReturnValue('user', 1, array('id'));
		$this->Favorites->beforeFilter();
		$this->Favorites->add('like', 1);
		$fav1 = $this->Favorites->Favorite->id;
		$this->Favorites->move($fav1, 'space');
		$this->assertEqual($this->Favorites->viewVars['message'], 'Invalid direction');
		$this->assertEqual($this->Favorites->viewVars['status'], 'error');
		$this->assertEqual($this->Favorites->redirectUrl, '/articles/index');
	}

/**
 * testMoveWrongDirection
 *
 * @return void
 */
	public function _testMoveWrongDirection2() {
		$_SERVER['HTTP_REFERER'] = '/articles/index';
		$this->Favorites->Auth->setReturnValue('user', 1, array('id'));
		$this->Favorites->beforeFilter();
		$this->Favorites->add('like', 1);
		$fav1 = $this->Favorites->Favorite->id;
		// $this->Favorites->add('like', 2);
		// $fav2 = $this->Favorites->Favorite->id;
		$this->Favorites->move($fav1, 'space');
		$this->assertEqual($this->Favorites->viewVars['message'], 'Unable to change favorite position, please try again');
		$this->assertEqual($this->Favorites->viewVars['message'], 'Invalid direction');
		$this->assertEqual($this->Favorites->viewVars['status'], 'error');
		$this->assertEqual($this->Favorites->redirectUrl, '/articles/index');
	}

/**
 * testDeleteAjax
 *
 * Short list test
 *
 * @return void
 */
	public function testDeleteAjax() {
		$_SERVER['HTTP_REFERER'] = '/articles/index';
		$this->Favorites->Auth->setReturnValue('user', 1, array('id'));
		$this->Favorites->beforeFilter();
		$this->Favorites->params['isAjax'] = true;
		$this->Favorites->add('like', 1);
		
		$this->Favorites->redirectUrl = null;
		
		$this->Favorites->delete($this->Favorites->Favorite->id);
		$this->assertEqual($this->Favorites->viewVars['message'], 'Record removed from list');
		$this->assertEqual($this->Favorites->viewVars['status'], 'success');
		$this->assertEqual($this->Favorites->redirectUrl, null);
	}

/**
 * testListAll
 *
 * Full list test
 *
 * @return void
 */
	public function testListAll() {
		$_SERVER['HTTP_REFERER'] = '/articles/index';
		$this->Favorites->Auth->setReturnValue('user', 1, array('id'));
		$this->Favorites->beforeFilter();
		$this->Favorites->add('like', 2);
		$this->Favorites->add('like', 1);
		
		$this->Favorites->viewVars = array();
		$this->Favorites->redirectUrl = null;
		
		$this->Favorites->list_all('like');
		$this->assertEqual(count($this->Favorites->viewVars['favorites']['FavoriteArticle']), 2);
		$this->assertEqual($this->Favorites->viewVars['type'], 'like');
	}

/**
 * testListAllDiferentType
 *
 * @return void
 */
	public function testListAllDiferentType() {
		$_SERVER['HTTP_REFERER'] = '/articles/index';
		$this->Favorites->Auth->setReturnValue('user', 1, array('id'));
		$this->Favorites->beforeFilter();
		$this->Favorites->add('like', 1);
		$this->Favorites->add('dislike', 1);

		$this->Favorites->viewVars = array();
		$this->Favorites->redirectUrl = null;
		
		$this->Favorites->list_all('like');
		$this->assertEqual(count($this->Favorites->viewVars['favorites']['FavoriteArticle']), 1);
		$this->assertEqual($this->Favorites->viewVars['type'], 'like');

		$this->Favorites->viewVars = array();
		$this->Favorites->redirectUrl = null;
		
		$this->Favorites->list_all('dislike');
		$this->assertEqual(count($this->Favorites->viewVars['favorites']['FavoriteArticle']), 1);
		$this->assertEqual($this->Favorites->viewVars['type'], 'dislike');
	}

/**
 * testListWrongType
 *
 * @return void
 */
	public function testListWrongType() {
		$_SERVER['HTTP_REFERER'] = '/articles/index';
		$this->Favorites->Auth->setReturnValue('user', 1, array('id'));
		$this->Favorites->beforeFilter();
		$this->Favorites->list_all('WRONGTYPE');
		$this->assertFlash('Invalid object type.');
	}
}
