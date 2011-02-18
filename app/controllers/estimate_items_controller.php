<?php
class EstimateItemsController extends AppController {

	var $name = 'EstimateItems';

	function index() {
		$this->EstimateItem->recursive = 0;
		$this->set('estimateItems', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid estimate item', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('estimateItem', $this->EstimateItem->read(null, $id));
	}

	function add() {
		if (!empty($this->data)) {
			$this->EstimateItem->create();
			if ($this->EstimateItem->save($this->data)) {
				$this->Session->setFlash(__('The estimate item has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The estimate item could not be saved. Please, try again.', true));
			}
		}
		$estimates = $this->EstimateItem->Estimate->find('list');
		$estimateItemTypes = $this->EstimateItem->EstimateItemType->find('list');
		$this->set(compact('estimates', 'estimateItemTypes'));
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid estimate item', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->EstimateItem->save($this->data)) {
				$this->Session->setFlash(__('The estimate item has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The estimate item could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->EstimateItem->read(null, $id);
		}
		$estimates = $this->EstimateItem->Estimate->find('list');
		$estimateItemTypes = $this->EstimateItem->EstimateItemType->find('list');
		$creators = $this->EstimateItem->Creator->find('list');
		$modifiers = $this->EstimateItem->Modifier->find('list');
		$this->set(compact('estimates', 'estimateItemTypes', 'creators', 'modifiers'));
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for estimate item', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->EstimateItem->delete($id)) {
			$this->Session->setFlash(__('Estimate item deleted', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Estimate item was not deleted', true));
		$this->redirect(array('action' => 'index'));
	}
	function admin_index() {
		$this->EstimateItem->recursive = 0;
		$this->set('estimateItems', $this->paginate());
	}

	function admin_view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid estimate item', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('estimateItem', $this->EstimateItem->read(null, $id));
	}

	function admin_add() {
		if (!empty($this->data)) {
			$this->EstimateItem->create();
			if ($this->EstimateItem->save($this->data)) {
				$this->Session->setFlash(__('The estimate item has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The estimate item could not be saved. Please, try again.', true));
			}
		}
		$estimates = $this->EstimateItem->Estimate->find('list');
		$estimateItemTypes = $this->EstimateItem->EstimateItemType->find('list');
		$creators = $this->EstimateItem->Creator->find('list');
		$modifiers = $this->EstimateItem->Modifier->find('list');
		$this->set(compact('estimates', 'estimateItemTypes', 'creators', 'modifiers'));
	}

	function admin_edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid estimate item', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->EstimateItem->save($this->data)) {
				$this->Session->setFlash(__('The estimate item has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The estimate item could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->EstimateItem->read(null, $id);
		}
		$estimates = $this->EstimateItem->Estimate->find('list');
		$estimateItemTypes = $this->EstimateItem->EstimateItemType->find('list');
		$creators = $this->EstimateItem->Creator->find('list');
		$modifiers = $this->EstimateItem->Modifier->find('list');
		$this->set(compact('estimates', 'estimateItemTypes', 'creators', 'modifiers'));
	}

	function admin_delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for estimate item', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->EstimateItem->delete($id)) {
			$this->Session->setFlash(__('Estimate item deleted', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Estimate item was not deleted', true));
		$this->redirect(array('action' => 'index'));
	}
}
?>