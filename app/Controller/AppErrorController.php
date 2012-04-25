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
		$this->_set(array('cacheAction' => false, 'viewPath' => 'Errors'));
	}

/**
 * Before showing an error we check to see if the alias exists and redirect to that first.
 *
 * @param object
 * @return mixed
 */
    public function handleAlias($request, $exception) {
		if ($request->here == '/') {
			$request->here = 'home';
		} else {
			# seems it was getting over sanitized because dashes were being replaced.  Just converting them back.
			$request->here = str_replace('&#45;', '-', $request->here);
		}
		if (strpos($request->here, '/') === 0) {
			$request->here = substr($request->here, 1);
		}
		$Alias = ClassRegistry::init('Alias');
		$alias = $Alias->find('first', array('conditions' => array('name' => trim(urldecode($request->here), "/"))));
		if(!empty($alias)) {
			$request->params['controller'] = $alias['Alias']['controller'];
			$request->params['plugin'] = $alias['Alias']['plugin'];
			$request->params['action'] = $alias['Alias']['action'];
			$request->params['pass'][] = $alias['Alias']['value'];
			$request->url = '/';
			(!empty($alias['Alias']['plugin']) ? $request->url = $request->url.$alias['Alias']['plugin'].'/' : '');
			(!empty($alias['Alias']['controller']) ? $request->url = $request->url.$alias['Alias']['controller'].'/' : '');
			(!empty($alias['Alias']['action']) ? $request->url = $request->url.$alias['Alias']['action'].'/' : '');
			(!empty($alias['Alias']['value']) ? $request->url = $request->url.$alias['Alias']['value'].'/' : '');
			$request->query['url'] = substr($request->url, 1, -1);
			$request->here = substr($request->url, 1, -1);
			$dispatcher = new Dispatcher();
			$result = $dispatcher->dispatch($request, new CakeResponse());
		} else {
			throw new NotFoundException('Page not found.');
		}
	    exit;
    }
	
    public function handleNotFound($request, $response, $error, $originalException) {
		$eName = get_class($originalException);
		//print_r('.'.$eName.'.'); break;
		if (Configure::read('debug') == 2 && $eName != 'MissingControllerException') {
			throw new $eName($originalException->getMessage());
		} else {
			$Alias = ClassRegistry::init('Alias');
			$alias = $Alias->find('first', array('conditions' => array('name' => 'error')));
			if (!empty($alias['Alias']['name'])) {
				$Controller = new AppController($request, $response);
				$Controller->redirect('/error/?referer=' . $request->url);
			}
		}
	}
	
}
