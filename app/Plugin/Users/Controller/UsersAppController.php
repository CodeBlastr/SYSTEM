<?php
class UsersAppController extends AppController {
	
	// Idea for overwriting individual functions
	// The core/app UsersController extends this class which
	// then does a callback to the class extending it
	// so that sites --- UsersController can have access to 
	// over writing a single function instead of the whole class
	//public function index() {
	//	$controller = $this->request->controller; 
	//	App::uses($controller, 'Users.Controller');
	//	$Controller = new $controller;
	//	return $Controller->_index();
	//}
	
	// sites/somedomain.com/Locale/Plugin/Users/Controllers/UsersController::index() function example
	//public function index() {
	//	here i get to do whatever I want
	//}
	
}