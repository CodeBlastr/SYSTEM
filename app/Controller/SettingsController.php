<?php
/**
 * Settings Controller
 *
 * Used to set global constants that can be used throughout the entire app.
 * All data in this table is loaded on app start up (and hopefully cached).
 * The purpose is to have a central database driven place where you can customize
 * the application.
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
 * @todo      Make sure that settings are cached for a very long time, because they are not needed to be refreshed often at all.
 */
class SettingsController extends AppController {

	public $name = 'Settings';
	public $uses = array('Setting');
	public $allowedActions = array('install');

	public function update_defaults() {
		if ($this->Setting->writeDefaultsIniData()) {
			$this->Session->setFlash(__('Defaults update successful.', true), 'flash_success');
			$this->redirect($this->referer());
		} else {
			$this->Session->setFlash(__('Defaults update failed. Please, try again.'), 'flash_warning');
		}
	}

	public function update_settings() {
		if ($this->Setting->writeSettingsIniData()) {
			$this->Session->setFlash(__('Settings update successful.'), 'flash_success');
			$this->redirect($this->referer());
		} else {
			$this->Session->setFlash(__('Settings update failed. Please, try again.'), 'flash_warning');
		}
	}

/**
 * Index method
 * 
 * @return void
 */
	public function index() {
		$this->redirect('admin');
		$this->paginate['limit'] = 20;
		$this->paginate['order'] = array('Setting.type' => 'asc', 'Setting.name' => 'asc');
		$this->set('settings', $settings = $this->paginate());
		$this->set('page_title_for_layout', __('%s Configuration', __SYSTEM_SITE_NAME));
		$this->set('title_for_layout', __('%s Configuration', __SYSTEM_SITE_NAME));
		return $settings;
	}

/**
 * View method
 * 
 * @return void
 */
	public function view($id = null) {
		$this->redirect('admin');
        $this->Setting->id = $id;
        if (!$this->Setting->exists()) {
            throw new NotFoundException();
        }
		$this->set('setting', $setting = $this->Setting->read(null, $id));
		return $setting;
	}

/**
 * Add method
 * 
 */
	public function add() {
		$this->redirect('admin');
		if ($this->request->is('post')) {
			if ($this->Setting->add($this->request->data)) {
				$this->Session->setFlash(__('The Setting has been saved', true), 'flash_success');
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The Setting could not be saved. Please, try again.', true), 'flash_warning');
			}
		}
		$types = $this->Setting->types();
		$this->set(compact('types'));
		$this->set('page_title_for_layout', __('%s Configuration', __SYSTEM_SITE_NAME));
		$this->set('title_for_layout', __('%s Configuration', __SYSTEM_SITE_NAME));
	}

/**
 * Names method
 * Used by settings/add to get info about a particular setting type
 * 
 * @param string $typeName
 */
	public function names($typeName = null) {
		$settings = $this->Setting->getNames($typeName);
		$this->set(compact('settings'));
	}

/**
 * Edit method
 * 
 * @param uuid $id
 */
	public function edit($id = null) {
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Setting->add($this->request->data)) {
				$this->Session->setFlash(__('The Setting has been saved', true), 'flash_success');
				$this->redirect($this->referer());
			} else {
				$this->Session->setFlash(__('The Setting could not be saved. Please, try again.', true), 'flash_warning');
			}
		}
		if (!$id && empty($this->request->data) && empty($this->request->params['named'])) {
			$this->Session->setFlash(__('Invalid Setting', true), 'flash_danger');
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->request->params['named'])) {
			$this->request->data = $this->Setting->find('first', array('conditions' => array('type_id' => Zuha::enum(null, $this->request->params['named']['type']), 'name' => $this->request->params['named']['name'], ), ));
			$this->set('typeId', Zuha::enum(null, $this->request->params['named']['type']));
			$this->request->data['Setting']['name'] = $this->request->params['named']['name'];
			$this->request->data['Setting']['description'] = $this->Setting->getDescription($this->request->params['named']['type'], $this->request->params['named']['name']);
		}
		if (empty($this->request->data)) {
			$this->request->data = $this->Setting->read(null, $id);
		}
		$types = $this->Setting->types();
		$this->set(compact('types'));
		$this->layout = 'default';
	}

/**
 * Delete method
 * 
 * @param uuid $id
 */
	public function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for Setting', true), 'flash_danger');
			$this->redirect(array('action' => 'index'));
		}
		if ($this->Setting->delete($id)) {
			if ($this->Setting->writeSettingsIniData()) {
				$this->Session->setFlash(__('Setting deleted', true), 'flash_success');
				$this->redirect(array('action' => 'index'));
			}
		}
	}

/**
 * Form method
 */
	public function form($type = null, $name = null) {

		$type = !empty($type) ? array('Setting.type' => $type) : array();
		$name = !empty($name) ? array('Setting.name' => $name) : array();
		$conditions = array_merge($type, $name);

		//@ note if you use 'all', then we'll need to update the
		$settings = $this->Setting->getFormSettings('all', array('conditions' => $conditions, ));
		return $settings;
	}

/**
 * Install method
 *
 * write the settings.ini file
 */
	public function install() {
		try {
			$this->Setting->writeSettingsIniData();
			$this->Session->setFlash(__('Success! Your site is ready to go. Please login using the email and password entered on the previous screen.'), 'flash_success');
		} catch (Exception $e) {
			$this->Session->setFlash($e->getMessage(), 'flash_warning');
		}
		$this->redirect(array('plugin' => false, 'controller' => 'install', 'action' => 'login'));
	}

/**
 * Test email method
 * 
 * Test the send mail function to see if a site email works. 
 */
	public function test() {
		//debug($this->request->is('push'));exit;
		if ($this->request->is('post') || $this->request->is('push')) {
			$to = $this->request->data['Setting']['to'];
			$subject = $this->request->data['Setting']['subject'];
			$message = $this->request->data['Setting']['message'];
			try {
				$this->Setting->__sendMail($to, $subject, $message);
				$this->Session->setFlash(__('Message sent'), 'flash_success');
			} catch (Exception $e) {
				$this->Session->setFlash($e->getMessage(), 'flash_warning');
			}
		}
		
		$this->set('title_for_layout', 'Test Email Settings');
		$this->set('page_title_for_layout', 'Test Email Settings');
	}

}
