<?php
class AttributeGroupsController extends AppController {

	var $name = 'AttributeGroups';
	

	function admin_index() {
		$this->AttributeGroup->recursive = 0;
		$this->set('attributeGroups', $this->paginate());
	}

	function admin_edit($id = null) {
		if (!empty($this->data)) {
			if ($this->AttributeGroup->save($this->data)) {
				$this->Session->setFlash(__('The AttributeGroup has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The AttributeGroup could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->AttributeGroup->read(null, $id);
			$enumerations = $this->AttributeGroup->Enumeration->find('all');
			$enumerations = Set::combine($enumerations,'{n}.Enumeration.id', '{n}.Enumeration.name', '{n}.Enumeration.type');
			$this->set('enumerations', $enumerations);
		}
	}

	function admin_delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for AttributeGroup', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->AttributeGroup->delete($id)) {
			$this->Session->setFlash(__('AttributeGroup deleted', true));
			$this->redirect(array('action'=>'index'));
		}
	}

}
?>