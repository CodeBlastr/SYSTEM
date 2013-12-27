<?php
App::uses('AppController', 'Controller');
class AppErrorController extends AppController {

/**
 * Controller name
 *
 * @var string
 */
	public $name = 'AppError';

/**
 * Uses Property
 *
 * @var array
 */
	public $uses = array();

/**
 * __construct
 *
 * @param CakeRequest $request
 * @param CakeResponse $response
 */
	public function __construct($request = null, $response = null) {
		parent::__construct($request, $response);
		$this->constructClasses();
		$this->Components->trigger('initialize', array(&$this));
		$this->_set(array(
			'cacheAction' => false,
			'viewPath' => 'Errors'
		));
	}

/**
 * Handle Missing Plugin
 * 
 * Let's show a custom page when a plugin is missing to direct the user to
 * install the plugin.
 * 
 * @param object
 * @param mixed
 */
	public function handleMissingPlugin($request, $exception) {
		$this->set('title_for_layout', 'Missing Plugin Error Occurred');
		$this->set('page_title_for_layout', 'Missing Plugin Error Occurred');
		$this->set('errorMessage', $exception->getMessage());
		$this->layout = 'error';
	}

/**
 * Handle Alias method
 * 
 * Before showing an error we check to see if the alias exists and redirect to
 * that first.
 *
 * @param object
 * @return mixed
 */
	public function handleAlias($request, $exception) {
		if ($request->here == '/') {
			$request->here = 'home';
		} else {
			// seems it was getting over sanitized because dashes were being replaced.  Just
			// converting them back.
			$request->here = str_replace('&#45;', '-', $request->here);
		}
		if (strpos($request->here, '/') === 0) {
			$request->here = substr($request->here, 1);
		}
		$this->_db();
		// we can get here with no db connection, so check db before looking up an alias
		$this->_alias($request);
		// check for an alias throws not found otherwise
	}

/**
 * Handle not found method
 *
 * over written so that custom error pages can be handled from the database
 *
 * @todo Was gettting "Controller class Controller not found" .. found that the $error parameter here had the real exception. ^JB
 * 
 * @param object
 * @param object
 * @param array
 * @param object
 * @return void
 */
	public function handleNotFound($request, $response, $error, $originalException) {
		//debug($error);
		$message = sprintf("[%s] %s\n%s", get_class($originalException), $originalException->getMessage(), $originalException->getTraceAsString());
		CakeLog::write(LOG_ERR, $message);
		$eName = get_class($originalException);
		if (Configure::read('debug') == 2 && $eName != 'MissingControllerException') {
			throw new $eName($originalException->getMessage());
		} else {
			$this->_getTemplate();
			// from AppController
			$Alias = ClassRegistry::init('Alias');
			$alias = $Alias->find('first', array('conditions' => array('Alias.name' => 'error')));
			if (!empty($alias['Alias']['value'])) {
				$Webpage = ClassRegistry::init('Webpages.Webpage');
				$content = $Webpage->find('first', array('conditions' => array('Webpage.id' => $alias['Alias']['value'])));
				$this->set('content', $content['Webpage']['content']);
			}
		}
	}

/**
 * alias method
 *
 * checks for an alias/slug and returns sends a new dispatch if found
 * otherwise throws the not found exception like it would have anyway
 *
 * @return void
 */
	protected function _alias($request) {
		try {
			$Alias = ClassRegistry::init('Alias');
			$alias = $Alias->find('first', array('conditions' => array('Alias.name' => trim(urldecode($request->here), "/"))));
		} catch (Exception $e) {
			debug($e->getMessage());
			// in some rare cases this is a hard to find error
			debug(Debugger::trace());
			break;
		}
		if (!empty($alias)) {
			$request->params['controller'] = $alias['Alias']['controller'];
			$request->params['plugin'] = $alias['Alias']['plugin'];
			$request->params['action'] = $alias['Alias']['action'];
			$request->params['pass'][] = $alias['Alias']['value'];
			$request->params['alias'] = $alias['Alias']['name'];
			$request->url = '/';
			(!empty($alias['Alias']['plugin']) ? $request->url = $request->url . $alias['Alias']['plugin'] . '/' : '');
			(!empty($alias['Alias']['controller']) ? $request->url = $request->url . $alias['Alias']['controller'] . '/' : '');
			(!empty($alias['Alias']['action']) ? $request->url = $request->url . $alias['Alias']['action'] . '/' : '');
			(!empty($alias['Alias']['value']) ? $request->url = $request->url . $alias['Alias']['value'] . '/' : '');
			// this
			$request->query['url'] = $request->url;
			$request->here = $request->url;
			// was this (changed after Cake2.4 because the login redirect wasn't playing nice)
			// $request->query['url'] = substr($request->url, 1, -1);
			// $request->here = substr($request->url, 1, -1);
			$dispatcher = new Dispatcher();
			$dispatcher->dispatch($request, new CakeResponse());
		} else {
			throw new NotFoundException('Page not found.');
		}
		exit ;
	}

/**
 * Check if there is a database connection before doing an alias check
 *
 */
	protected function _db() {
		try {
			ConnectionManager::getDataSource('default');
			return true;
		} catch(Exception $e) {
			debug($e->getMessage());
		}
	}

}
