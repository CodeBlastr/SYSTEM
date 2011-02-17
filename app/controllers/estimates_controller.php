<?php
class EstimatesController extends AppController {

	var $name = 'Estimates';

	function index() {
		$this->Estimate->recursive = 0;
		$this->set('estimates', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid estimate', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('estimate', $this->Estimate->read(null, $id));
	}

	function add() {
		if (!empty($this->data)) {
			$this->Estimate->create();
			if ($this->Estimate->save($this->data)) {
				$this->Session->setFlash(__('The estimate has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The estimate could not be saved. Please, try again.', true));
			}
		}
		$estimateTypes = $this->Estimate->EstimateType->find('list');
		$estimateStatuses = $this->Estimate->EstimateStatus->find('list');
		$recipients = $this->Estimate->Recipient->find('list');
		$creators = $this->Estimate->Creator->find('list');
		$modifiers = $this->Estimate->Modifier->find('list');
		$this->set(compact('estimateTypes', 'estimateStatuses', 'recipients', 'creators', 'modifiers'));
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid estimate', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->Estimate->save($this->data)) {
				$this->Session->setFlash(__('The estimate has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The estimate could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Estimate->read(null, $id);
		}
		$estimateTypes = $this->Estimate->EstimateType->find('list');
		$estimateStatuses = $this->Estimate->EstimateStatus->find('list');
		$recipients = $this->Estimate->Recipient->find('list');
		$creators = $this->Estimate->Creator->find('list');
		$modifiers = $this->Estimate->Modifier->find('list');
		$this->set(compact('estimateTypes', 'estimateStatuses', 'recipients', 'creators', 'modifiers'));
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for estimate', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Estimate->delete($id)) {
			$this->Session->setFlash(__('Estimate deleted', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Estimate was not deleted', true));
		$this->redirect(array('action' => 'index'));
	}
	function admin_index() {
		$this->Estimate->recursive = 0;
		$this->set('estimates', $this->paginate());
	}

	function admin_view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid estimate', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('estimate', $this->Estimate->read(null, $id));
	}

	function admin_add() {
		if (!empty($this->data)) {
			$this->Estimate->create();
			if ($this->Estimate->save($this->data)) {
				$this->Session->setFlash(__('The estimate has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The estimate could not be saved. Please, try again.', true));
			}
		}
		$estimateTypes = $this->Estimate->EstimateType->find('list');
		$estimateStatuses = $this->Estimate->EstimateStatus->find('list');
		$recipients = $this->Estimate->Recipient->find('list');
		$creators = $this->Estimate->Creator->find('list');
		$modifiers = $this->Estimate->Modifier->find('list');
		$this->set(compact('estimateTypes', 'estimateStatuses', 'recipients', 'creators', 'modifiers'));
	}

	function admin_edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid estimate', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->Estimate->save($this->data)) {
				$this->Session->setFlash(__('The estimate has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The estimate could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Estimate->read(null, $id);
		}
		$estimateTypes = $this->Estimate->EstimateType->find('list');
		$estimateStatuses = $this->Estimate->EstimateStatus->find('list');
		$recipients = $this->Estimate->Recipient->find('list');
		$creators = $this->Estimate->Creator->find('list');
		$modifiers = $this->Estimate->Modifier->find('list');
		$this->set(compact('estimateTypes', 'estimateStatuses', 'recipients', 'creators', 'modifiers'));
	}

	function admin_delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for estimate', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Estimate->delete($id)) {
			$this->Session->setFlash(__('Estimate deleted', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Estimate was not deleted', true));
		$this->redirect(array('action' => 'index'));
	}
}
?>