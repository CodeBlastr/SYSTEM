<?php
class ConditionsController extends AppController {

	var $name = 'Conditions';

	function admin_index() {
		$this->Condition->recursive = 0;
		$this->set('conditions', $this->paginate());
	}

	function admin_view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid Condition.', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->set('condition', $this->Condition->read(null, $id));
	}

	function admin_edit($id = null) {
		if (!empty($this->data)) {
			if ($this->Condition->save($this->data)) {
				$this->Session->setFlash(__('The Condition has been saved', true));
				$this->redirect(array('plugin' => null, 'controller' => 'conditions', 'action'=>'view', $this->Condition->id));
			} else {
				$this->Session->setFlash(__('The Condition could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Condition->read(null, $id);
		}
	}

	function admin_delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for Condition', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Condition->delete($id)) {
			$this->Session->setFlash(__('Condition deleted', true));
			$this->redirect(array('action'=>'index'));
		}
	}

}
?>