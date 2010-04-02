<?php
class ContactActivitiesController extends AppController {

	var $name = 'ContactActivities';
	var $helpers = array('Html', 'Form');

	function index() {
		$this->ContactActivity->recursive = 0;
		$this->set('contactActivities', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid ContactActivity.', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->set('contactActivity', $this->ContactActivity->read(null, $id));
	}

	function add() {
		if (!empty($this->data)) {
			$this->ContactActivity->create();
			if ($this->ContactActivity->save($this->data)) {
				$this->Session->setFlash(__('The ContactActivity has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The ContactActivity could not be saved. Please, try again.', true));
			}
		}
		//$contactActivityParents = $this->ContactActivity->ContactActivityParent->find('list');
		$contactActivityTypes = $this->ContactActivity->ContactActivityType->find('list');
		$creators = $this->ContactActivity->Creator->find('list');
		//$modifiers = $this->ContactActivity->Modifier->find('list');
		//$contacts = $this->ContactActivity->Contact->find('list');
		//$this->set(compact('contactActivityParents', 'contactActivityTypes', 'creators', 'modifiers', 'contacts'));
		$this->set(compact('contactActivityTypes', 'contacts'));
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid ContactActivity', true));
			$this->redirect(array('action'=>'index'));
		}
		if (!empty($this->data)) {
			if ($this->ContactActivity->save($this->data)) {
				$this->Session->setFlash(__('The ContactActivity has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The ContactActivity could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->ContactActivity->read(null, $id);
		}
		$contactActivityParents = $this->ContactActivity->ContactActivityParent->find('list');
		$contactActivityTypes = $this->ContactActivity->ContactActivityType->find('list');
		$this->set(compact('contactActivityParents','contactActivityTypes','creators','contacts'));
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for ContactActivity', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->ContactActivity->del($id)) {
			$this->Session->setFlash(__('ContactActivity deleted', true));
			$this->redirect(array('action'=>'index'));
		}
	}


	function admin_index() {
		$this->ContactActivity->recursive = 0;
		$this->set('contactActivities', $this->paginate());
	}

	function admin_view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid ContactActivity.', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->set('contactActivity', $this->ContactActivity->read(null, $id));
	}

	function admin_add() {
		if (!empty($this->data)) {
			$this->ContactActivity->create();
			if ($this->ContactActivity->save($this->data)) {
				$this->Session->setFlash(__('The ContactActivity has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The ContactActivity could not be saved. Please, try again.', true));
			}
		}
		$contactActivityParents = $this->ContactActivity->ContactActivityParent->find('list');
		$contactActivityTypes = $this->ContactActivity->ContactActivityType->find('list');
		$creators = $this->ContactActivity->Creator->find('list');
		$contacts = $this->ContactActivity->Contact->find('list');
		$this->set(compact('contactActivityParents', 'contactActivityTypes', 'creators', 'contacts'));
	}

	function admin_edit($id = null) {
		if (!empty($this->data)) {
			if ($this->ContactActivity->save($this->data)) {
				$this->Session->setFlash(__('The ContactActivity has been saved', true));
				$this->redirect(array('action'=>'view'));
			} else {
				$this->Session->setFlash(__('The ContactActivity could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->ContactActivity->read(null, $id);
		}
		$contactActivityParents = $this->ContactActivity->ContactActivityParent->find('list');
		$contactActivityTypes = $this->ContactActivity->ContactActivityType->find('list');
		$creators = $this->ContactActivity->Creator->find('list');
		$contacts = $this->ContactActivity->Contact->find('list');
		$this->set(compact('contactActivityParents','contactActivityTypes','creators','contacts'));
	}

	
	function admin_ajax_edit($id = null) {
		$model = $this->modelClass;
		$controller = $this->name;
		if (!empty($this->data)) {
			if ($this->$model->save($this->data)) {
				$this->Session->setFlash(__($model.' saved', true));
			} else {
				$this->Session->setFlash(__('Could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->$model->read(null, $id);
		}
		## define the fields for the form and put them in the order you want them displayed;
		## Edit these per controller
		## $contactActivityParents = $this->ContactActivity->ContactActivityParent->find('list');
		$contactActivityTypes = $this->ContactActivity->ContactActivityType->find('list');
		$this->set(compact('contactActivityTypes'));
		$this->set('fields', array('contact_activity_type_id', 'name', 'description', 'contact_id'));
		## End edit per controller
		$this->set('model', $model);
		$this->set('controller', $controller);
		$this->viewPath = 'pages';
		$this->render('ajax_edit');
	}

	function admin_delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for ContactActivity', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->ContactActivity->del($id)) {
			$this->Session->setFlash(__('ContactActivity deleted', true));
			$this->redirect(array('action'=>'index'));
		}
	}

	function admin_ajax_delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id', true));
			$this->redirect(array('action'=>'index'));
		}
		$model = $this->modelClass;
		if ($this->$model->del($id)) {
			$this->redirect('/ajax_delete');
	        $this->layout = 'ajax';
		}
	}

}
?>