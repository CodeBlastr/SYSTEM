<?php

/**
 * Admin Dashboard Controller
 *
 * This controller will output variables used for the Admin dashboard.
 * Primarily conceived as the hub for managing the rest of the app.
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
 */
class AdminController extends AppController {

	public $name = 'Admin';
	public $uses = array();
	public $components = array('SiteUpdate', 'SiteExport');

	public function index() {
		if (!empty($this->request->data['Admin']['icon'])) {
			$this->_saveFavicon();
		}
		if (!empty($this->request->data['Admin']['export'])) {
			$this->SiteExport->_exportSite($this->request->data['Admin']['export']);
		}
		if (!empty($this->request->data['Upgrade']['all'])) {
			$this->SiteUpdate->_runUpdates();
			$this->set('runUpdates', true);
		}
		if (!empty($this->request->data['Update']['index'])) {
			$this->view = 'index_upgrade';
		}
		if (!empty($this->request->data['Alias']['update'])) {
			App::uses('Alias', 'Model');
			$Alias = new Alias;
			$this->set('syncd', $Alias->sync());
			$this->view = 'index_upgrade';
		}
		$complete = $this->Session->read('Updates.complete');
		if (!empty($complete)) {
			$this->Session->delete('Updates');
			$this->Session->setFlash(__('Update check complete!!!'), 'flash_success');
		}
		$this->set('title_for_layout', 'Admin Dashboard');
		$this->set('page_title_for_layout', 'Admin Dashboard');
		$this->layout = 'default';

		// this is here so we can show "Add Post" links foreach Blog on the dashboard
		if (CakePlugin::loaded('Blogs')) {
			App::uses('Blog', 'Blogs.Model');
			$Blog = new Blog();
			$this->set('blogs', $Blog->find('all'));
		}
	}

	private function _saveFavicon() {
		$upload = ROOT . DS . SITE_DIR . DS . 'Locale' . DS . 'View' . DS . WEBROOT_DIR . DS . 'favicon.ico';
		if (move_uploaded_file($this->request->data['Admin']['icon']['tmp_name'], $upload)) {
			$this->Session->setFlash('Favicon Updated. NOTE ( You may need to clear browser history and refresh to see it. )', 'flash_success');
			!empty($this->request->data['Override']) ? $this->redirect('/admin') : null; // not needed, but we get here through /install/build so this is a quick and dirty fix
		}
	}

}
