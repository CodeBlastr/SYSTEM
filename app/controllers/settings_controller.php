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
 * Copyright 2009-2010, Zuha Foundation Inc. (http://zuha.org)
 *
 * Licensed under GPL v3 License
 * Must retain the above copyright notice and release modifications publicly.
 *
 * @copyright     Copyright 2009-2010, Zuha Foundation Inc. (http://zuha.com)
 * @link          http://zuha.com Zuha� Project
 * @package       zuha
 * @subpackage    zuha.app.controllers
 * @since         Zuha(tm) v 0.0.1
 * @license       GPL v3 License (http://www.gnu.org/licenses/gpl.html) and Future Versions
 * @todo		  Make sure that settings are cached for a very long time, because they are not needed to be refreshed often at all. 
 */
class SettingsController extends AppController {

	var $name = 'Settings';
    var $uses = array('Setting', 'Template');

	function admin_index() {
		$this->Setting->recursive = 0;
		$this->set('settings', $this->paginate());
	}

	function admin_view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid Setting.', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->set('setting', $this->Setting->read(null, $id));
	}

	function admin_add() {
		if (!empty($this->data)) {
			if ($this->Setting->add($this->data)) {
				$this->Session->setFlash(__('The Setting has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The Setting could not be saved. Please, try again.', true));
			}
		}
		$types = $this->Setting->SettingType->find('list', array(
			'conditions' => array(
				'SettingType.type' => 'SETTING_TYPE'
				),
			));
		$this->set(compact('types')); 
	}
	
	function admin_names($typeId = null) {
		$settings = $this->Setting->getNames($typeId);
		$this->set(compact('settings'));
	}

	function admin_edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid Setting', true));
			$this->redirect(array('action'=>'index'));
		}
		if (!empty($this->data)) {
			if ($this->Setting->add($this->data)) {
				$this->Session->setFlash(__('The Setting has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The Setting could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Setting->read(null, $id);
		}
		$types = $this->Setting->SettingType->find('list', array(
			'conditions' => array(
				'SettingType.type' => 'SETTING_TYPE'
				),
			));
		$this->set(compact('types')); 
	}

	function admin_delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for Setting', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Setting->delete($id)) {
			if ($this->Setting->writeSettingsIniData()) {
				$this->Session->setFlash(__('Setting deleted', true));
				$this->redirect(array('action'=>'index'));
			}
		}
	}

}
?>