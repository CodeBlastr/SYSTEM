<?php
App::uses('UsersAppController', 'Users.Controller');
/**
 * User Roles Controller
 *
 * Used for grouping access requestors for the purpose of handling their access
 * to particular sections of the application. Mainly used in conjunction with the 
 * Permissions plugin (/admin/permissions/acores)
 *
 * PHP versions 5
 *
 * Zuha(tm) : Business Management Applications (http://zuha.com)
 * Copyright 2009-2012, Zuha Foundation Inc. (http://zuha.org)
 *
 * Licensed under GPL v3 License
 * Must retain the above copyright notice and release modifications publicly.
 *
 * @copyright     Copyright 2009-2012, Zuha Foundation Inc. (http://zuha.com)
 * @link          http://zuha.com Zuha� Project
 * @package       zuha
 * @subpackage    zuha.app.controllers
 * @since         Zuha(tm) v 0.0.1
 * @license       GPL v3 License (http://www.gnu.org/licenses/gpl.html) and Future Versions
 * @todo		  Consider moving user roles and users to a plugin, (maybe the permissions plugin) or replacing this with the users plugin available from CakeDC.
 */
class UserRolesController extends UsersAppController {

	public $name = 'UserRoles';
    
	public $uses = 'Users.UserRole';
	
/**
 * Before Render method
 * 
 */
	public function beforeRender() {
		$this->layout = 'default';
		return parent::beforeRender();
	}
	
/**
 * Index method
 * 
 */
	public function index() {		
		$this->UserRole->recursive = 0;
		$this->set('userRoles', $this->paginate());
	}

/**
 * View method
 * 
 * @param int $id
 */
	public function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid UserRole.', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->set('userRole', $this->UserRole->read(null, $id));
	}

/**
 * Add method
 * 
 * @param int $duplicateId (user role to duplicate permissions for)
 */
	public function add($duplicateId = null) {	
		if (!empty($this->request->data)) {
			$this->UserRole->create();
			if ($this->UserRole->save($this->request->data)) {
				$this->Session->setFlash(__('The UserRole has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The UserRole could not be saved. Please, try again.', true));
			}
		}
		$this->request->data['UserRole']['duplicate'] = $duplicateId;
		$this->set('viewPrefixes', $this->UserRole->viewPrefixes);
		$this->set('title_for_layout', $titleForLayout = !empty($duplicateId) ? __('Add New User Role <small>(Duplicating user role "%s")</small>', $this->UserRole->field('name', array('UserRole.id' => $duplicateId))) : __('Add User Role'));
		$this->set('page_title_for_layout', $titleForLayout);
	}

/**
 * Edit method
 * 
 * @param int $id
 */
	public function edit($id = null) {
		if (!$id && empty($this->request->data)) {
			$this->Session->setFlash(__('Invalid UserRole', true));
			$this->redirect(array('action'=>'index'));
		}
		if (!empty($this->request->data)) {
			if ($this->UserRole->save($this->request->data)) {
				$this->Session->setFlash(__('The UserRole has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The UserRole could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->request->data)) {
			$this->request->data = $this->UserRole->read(null, $id);
		}
		$this->set('viewPrefixes', $this->UserRole->viewPrefixes);
	}

/**
 * Delete method
 * 
 * @param int $id
 */
	public function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for UserRole', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->UserRole->delete($id)) {
			$this->Session->setFlash(__('UserRole deleted', true));
			$this->redirect(array('action'=>'index'));
		}
	}

}