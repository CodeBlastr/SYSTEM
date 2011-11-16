<?php
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
		$this->handleError($request);
	}

		
    public function handleError($request) {
		
		$Alias = ClassRegistry::init('Alias');
		if ($request->here == '/') {
			$request->here = 'home';
		} else {
			# seems it was getting over sanitized because dashes were being replaced.  Just converting them back.
			$request->here = str_replace('&#45;', '-', $request->here);
		}
		if (strpos($request->here, '/') === 0) {
			$request->here = substr($request->here, 1);
		}
	
		$alias = $Alias->find("first", array("conditions" => array( "name" => str_replace('/', '', $request->here))));
		if(!empty($alias)) :
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
		else :
			if($this->addPageRedirect($request->url)) : 
				// error will be redirected if you're the admin
			else :
				throw new MissingControllerException('Page not found.');
			endif;
		endif;
        exit;
    }


	/** 
	 * Checks to see whether the user is logged in as an admin, and then redirects to the add page form 
	 * to see if they would like to create a page for that url.
	 *
	 * @return		a redirect action, or false
	 */
	function addPageRedirect($alias) {
		# lets see if the user would like to add a page if they are an admin
		$userRole = CakeSession::read('Auth.User.user_role_id');
		if($userRole == 1 /* Admin user role */) {
			App::uses('AppController', 'Controller');
			$AppController = new AppController($this->request, $this->response);
			#$Session->setFlash(__('No page exists at '.$alias.', would you like to create it?', true) );
			$AppController->redirect(array('plugin' => 'webpages', 'controller' => 'webpages', 'action'=>'add', 'alias' => $alias));
		} else {
			return false;
		}
	}
	
}
