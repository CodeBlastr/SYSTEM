<?php
/**
 * States Controller
 *
 * A convenience controller for managing app wide states that are available
 * to the forms which need state information. 
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
 * @link          http://zuha.com Zuha™ Project
 * @package       zuha
 * @subpackage    zuha.app.controllers
 * @since         Zuha(tm) v 0.0.1
 * @license       GPL v3 License (http://www.gnu.org/licenses/gpl.html) and Future Versions
 * @todo		  Examine whether this rarely used table is even necessary. It might be better as an enumeration.
 */
class StatesController extends AppController {

	var $name = 'States';

	function admin_index() {
		$this->State->recursive = 0;
		$this->set('states', $this->paginate());
	}

	function admin_view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid State.', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->set('state', $this->State->read(null, $id));
	}

	function admin_add() {
		if (!empty($this->data)) {
			$this->State->create();
			if ($this->State->save($this->data)) {
				$this->Session->setFlash(__('The State has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The State could not be saved. Please, try again.', true));
			}
		}
		$countries = $this->State->Country->find('list');
		$this->set(compact('countries'));
	}

	function admin_edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid State', true));
			$this->redirect(array('action'=>'index'));
		}
		if (!empty($this->data)) {
			if ($this->State->save($this->data)) {
				$this->Session->setFlash(__('The State has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The State could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->State->read(null, $id);
		}
		$countries = $this->State->Country->find('list');
		$this->set(compact('countries'));
	}

	function admin_delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for State', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->State->delete($id)) {
			$this->Session->setFlash(__('State deleted', true));
			$this->redirect(array('action'=>'index'));
		}
	}

}
?>