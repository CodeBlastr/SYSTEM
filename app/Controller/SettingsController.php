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
		if ($this -> Setting -> writeDefaultsIniData()) {
			$this -> Session -> setFlash(__('Defaults update successful.', true));
			$this -> redirect($this -> referer());
		} else {
			$this -> Session -> setFlash(__('Defaults update failed. Please, try again.'));
		}
	}

	public function update_settings() {
		if ($this -> Setting -> writeSettingsIniData()) {
			$this -> Session -> setFlash(__('Settings update successful.'));
			$this -> redirect($this -> referer());
		} else {
			$this -> Session -> setFlash(__('Settings update failed. Please, try again.'));
		}
	}

	public function index() {
		$this -> paginate['fields'] = array('id', 'displayName', 'description');
		$this -> paginate['order'] = array('Setting.type' => 'asc', 'Setting.name' => 'asc');
		$this -> set('settings', $this -> paginate());
		$this -> set('displayName', 'displayName');
		$this -> set('displayDescription', 'description');
		$this -> layout = 'default';
	}

	public function view($id = null) {
		if (!$id) {
			$this -> Session -> setFlash(__('Invalid Setting.', true));
			$this -> redirect(array('action' => 'index'));
		}
		$this -> set('setting', $this -> Setting -> read(null, $id));
		$this -> layout = 'default';
	}

/**
 * Add method
 */
	public function add() {
		if ($this -> request -> is('post')) {
			if ($this -> Setting -> add($this -> request -> data)) {
				$this -> Session -> setFlash(__('The Setting has been saved', true));
				$this -> redirect(array('action' => 'index'));
			} else {
				$this -> Session -> setFlash(__('The Setting could not be saved. Please, try again.', true));
			}
		}
		$types = $this -> Setting -> types();
		$this -> set(compact('types'));
		$this -> layout = 'default';
	}

/**
 * Names method
 *
 * @param string $typeName
 */
	public function names($typeName = null) {
		$settings = $this -> Setting -> getNames($typeName);
		$this -> set(compact('settings'));
	}

	public function edit($id = null) {
		if (!$id && empty($this -> request -> data) && empty($this -> request -> params['named'])) {
			$this -> Session -> setFlash(__('Invalid Setting', true));
			$this -> redirect(array('action' => 'index'));
		}
		if (!empty($this -> request -> data)) {
			if ($this -> Setting -> add($this -> request -> data)) {
				$this -> Session -> setFlash(__('The Setting has been saved', true));
				$this -> redirect($this -> referer());
			} else {
				$this -> Session -> setFlash(__('The Setting could not be saved. Please, try again.', true));
			}
		}
		if (!empty($this -> request -> params['named'])) {
			$this -> request -> data = $this -> Setting -> find('first', array('conditions' => array('type_id' => Zuha::enum(null, $this -> request -> params['named']['type']), 'name' => $this -> request -> params['named']['name'], ), ));
			$this -> set('typeId', Zuha::enum(null, $this -> request -> params['named']['type']));
			$this -> request -> data['Setting']['name'] = $this -> request -> params['named']['name'];
			$this -> request -> data['Setting']['description'] = $this -> Setting -> getDescription($this -> request -> params['named']['type'], $this -> request -> params['named']['name']);
		}
		if (empty($this -> request -> data)) {
			$this -> request -> data = $this -> Setting -> read(null, $id);
		}
		$types = $this -> Setting -> types();
		$this -> set(compact('types'));
		$this -> layout = 'default';
	}

	public function delete($id = null) {
		if (!$id) {
			$this -> Session -> setFlash(__('Invalid id for Setting', true));
			$this -> redirect(array('action' => 'index'));
		}
		if ($this -> Setting -> delete($id)) {
			if ($this -> Setting -> writeSettingsIniData()) {
				$this -> Session -> setFlash(__('Setting deleted', true));
				$this -> redirect(array('action' => 'index'));
			}
		}
	}

	public function form($type = null, $name = null) {

		$type = !empty($type) ? array('Setting.type' => $type) : array();
		$name = !empty($name) ? array('Setting.name' => $name) : array();
		$conditions = array_merge($type, $name);

		//@ note if you use 'all', then we'll need to update the
		$settings = $this -> Setting -> getFormSettings('all', array('conditions' => $conditions, ));
		return $settings;
	}

/**
 * Install method
 *
 * write the settings.ini file
 */
	public function install() {
		try {
			$this -> Setting -> writeSettingsIniData();
			$this -> Session -> setFlash(__('Success! Your site is ready to go.'));
		} catch (Exception $e) {
			$this -> Session -> setFlash($e -> getMessage());
		}
		$this -> redirect(array('plugin' => 'users', 'controller' => 'users', 'action' => 'login'));
	}
	
	public function test() {
		if ($this->request->is('post') || $this->request->is('push')) {
			$to = $this->request->data['Setting']['to'];
			$subject = $this->request->data['Setting']['subject'];
			$message = $this->request->data['Setting']['message'];
			try {
				$this->Setting->__sendMail($to, $subject, $message);
				$this->Session->setFlash(__('Message sent'));
			} catch (Exception $e) {
				debug($e->getMessage());
				break;
			}
		}
		$this->set('title_for_layout', 'Test Email Settings');
		$this->set('page_title_for_layout', 'Test Email Settings');
	}

}
