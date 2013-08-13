<?php
App::uses('AppController', 'Controller');
/**
 * Classifieds Controller
 *
 * @property Classified $Classified
 */
class ClassifiedsController extends ClassifiedsAppController {


/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->Classified->recursive = 0;
		$this->set('classifieds', $this->paginate());
	}

/**
 * view method
 *
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		$this->Classified->id = $id;
		if (!$this->Classified->exists()) {
			throw new NotFoundException(__('Invalid classified'));
		}
		$this->set('classified', $this->Classified->read(null, $id));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Classified->create();
			if ($this->Classified->save($this->request->data)) {
				$this->Session->setFlash(__('The classified has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The classified could not be saved. Please, try again.'));
			}
		}
		$creators = $this->Classified->Creator->find('list');
		$this->set(compact('creators'));
	}

/**
 * edit method
 *
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		$this->Classified->id = $id;
		if (!$this->Classified->exists()) {
			throw new NotFoundException(__('Invalid classified'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Classified->save($this->request->data)) {
				$this->Session->setFlash(__('The classified has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The classified could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->Classified->read(null, $id);
		}
		$creators = $this->Classified->Creator->find('list');
		$this->set(compact('creators'));
	}

/**
 * delete method
 *
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		if (!$this->request->is('post')) {
			throw new MethodNotAllowedException();
		}
		$this->Classified->id = $id;
		if (!$this->Classified->exists()) {
			throw new NotFoundException(__('Invalid classified'));
		}
		if ($this->Classified->delete()) {
			$this->Session->setFlash(__('Classified deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Classified was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}
