<?php
class UsersController extends AppController {

	var $name = 'Users';
	var $helpers = array('Html', 'Form', 'Ajax', 'Javascript', 'Time');
	var $components = array('Auth','RequestHandler');   
	
	function beforeFilter() {
	    parent::beforeFilter(); 
	    $this->Auth->allowedActions = array('*');
	}
	
	// this checks to see if you're logged in
    function checkSession()
    {
        // If the session info hasn't been set...
        if (!$this->Session->check('User'))
        {
            // Force the user to login
            $this->redirect('/users/login');
            exit();
        }
    }
	
	// front end login
	function login() {
    }

    function logout() {
        $this->redirect($this->Auth->logout());
    }
	// back end login
	function admin_login() {
    }
	
	function index() {
		$this->Session->setFlash(__('This page does not exist', true));
		$this->redirect('/admin/users');
	}
	
    function admin_logout() {
        $this->redirect($this->Auth->logout());
    }
	// user can view TODO if logged in
	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid User.', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->set('user', $this->User->read(null, $id));
	}
	// users can register
	function add() {
		if (!empty($this->data)) {
			$this->User->create();
			if ($this->User->save($this->data)) {
				$this->Session->setFlash(__('The User has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The User could not be saved. Please, try again.', true));
			}
		}
	}
	// in the admin you can see all users
	function admin_index() {
		$this->User->recursive = 0;
		$this->set('users', $this->paginate());
	}
	// in the admin you can view 
	function admin_view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid User.', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->set('user', $this->User->read(null, $id));
	}
	// in the admin you can add
	function admin_add() {
		if (!empty($this->data)) {
			$this->User->create();
			if ($this->User->save($this->data)) {
				$this->Session->setFlash(__('The User has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The User could not be saved. Please, try again.', true));
			}
		}
		$userGroups = $this->User->UserGroup->find('list');
		$this->set(compact('userGroups'));
	}
	// 
	function admin_edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid User', true));
			$this->redirect(array('action'=>'index'));
		}
		if (!empty($this->data)) {
			if ($this->User->save($this->data)) {
				$this->Session->setFlash(__('The User has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The User could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->User->read(null, $id);
		}
	}

	function admin_delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for User', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->User->del($id)) {
			$this->Session->setFlash(__('User deleted', true));
			$this->redirect(array('action'=>'index'));
		}
	}

}
?>