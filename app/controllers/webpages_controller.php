<?php
class WebpagesController extends AppController {

	var $name = 'Webpages';
	var $helpers = array('Html', 'Form', 'Javascript', 'Wikiparser');
	var $paginate = array('limit' => 10, 'order' => array('Webpage.created' => 'desc'));

	function index() {
		$this->Webpage->recursive = 0;
		$this->set('webpages', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->flash(__('Invalid Webpage', true), array('action'=>'index'));
		}
		$webpage = $this->Webpage->read(null, $id);
		if(!empty($webpage) && is_array($webpage)) {
			$this->set('webpage', $webpage);
		} else {
			$this->Session->setFlash(__('Invalid Webpage', true));
			$this->redirect(array('action'=>'index'));
		}
	}

	function preview($alias = null) {
		if (!$alias) {
			$this->flash(__('Invalid Webpage', true), array('action'=>'index'));
		}
		$webpage = $this->Webpage->find("first", array("conditions" => array( "alias" => $alias ) ) );
		if(!empty($webpage) && is_array($webpage)) {
			$this->set('webpage', $webpage);
		} else {
			$this->Session->setFlash(__('Invalid Webpage', true));
			$this->redirect(array('action'=>'index'));
		}
	}

	function add() {
		if (!empty($this->data)) {
			$this->Webpage->create();
			if ($this->Webpage->save($this->data)) {
				$this->Session->setFlash(__('The Webpage has been saved successfully.', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The Webpage could not be saved. Please, try again.', true));
			}
		}
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid Webpage', true));
			$this->redirect(array('action'=>'index'));
		}
		if (!empty($this->data)) {
			$this->Webpage->id = $id;
			if ($this->Webpage->save($this->data)) {
				$this->Session->setFlash(__('The Webpage has been saved.', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The Webpage could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Webpage->read(null, $id);
			$this->set('webpage', $this->data);
		}
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid Webpage.', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Webpage->del($id)) {
			$this->Session->setFlash(__('Webpage deleted.', true));
			$this->redirect(array('action'=>'index'));
		} else {
			$this->Session->setFlash(__('Invalid Webpage.', true));
			$this->redirect(array('action'=>'index'));
		}
	}


	//////////////////////////////////////////////////////////////////
	//////////////////////////////////////////////////////////////////
	///////////////////							//////////////////////
	//////////////////	ADMIN SECTION FUNCTION	//////////////////////
	//////////////////							//////////////////////
	//////////////////////////////////////////////////////////////////
	//////////////////////////////////////////////////////////////////


	function admin_index() {
		$this->Webpage->recursive = 0;
		$this->set('webpages', $this->paginate());
	}

	function admin_preview() {
		$this->redirect(array('action'=>'index'));
	}

	function admin_view($id = null) {
		if (!$id) {
			$this->flash(__('Invalid Webpage', true));
			$this->redirect(array('action'=>'index'));
		}
		$webpage = $this->Webpage->read(null, $id);
		if(!empty($webpage) && is_array($webpage)) {
			$this->set('webpage', $webpage);
		} else {
			$this->Session->setFlash(__('Invalid Webpage', true));
			$this->redirect(array('action'=>'index'));
		}
	}

	function admin_add() {
		if (!empty($this->data)) {
			$this->data['Webpage']['published'] = 1;
			$this->Webpage->create();
			if ($this->Webpage->save($this->data)) {
				$this->Session->setFlash(__('The Webpage has been saved successfully.', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The Webpage could not be saved. Please, try again.', true));
			}
		}
	}

	function admin_edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid Webpage', true));
			$this->redirect(array('action'=>'index'));
		}
		if (!empty($this->data)) {
			$this->Webpage->id = $id;
			if ($this->Webpage->save($this->data)) {
				$this->Session->setFlash(__('The Webpage has been saved.', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The Webpage could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Webpage->read(null, $id);
			$this->set('webpage', $this->data);
		}
	}

	function admin_delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid Webpage.', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Webpage->del($id)) {
			$this->Session->setFlash(__('Webpage deleted.', true));
			$this->redirect(array('action'=>'index'));
		} else {
			$this->Session->setFlash(__('Invalid Webpage.', true));
			$this->redirect(array('action'=>'index'));
		}
	}
}
?>
