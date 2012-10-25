<?php
App::uses('EventsAppController', 'Events.Controller');
/**
 * EventSchedules Controller
 *
 * @property EventSchedule $EventSchedule
 */
class EventSchedulesController extends EventsAppController {


/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->EventSchedule->recursive = 0;
		$this->set('eventSchedules', $this->paginate());
	}

/**
 * view method
 *
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		$this->EventSchedule->id = $id;
		if (!$this->EventSchedule->exists()) {
			throw new NotFoundException(__('Invalid event schedule'));
		}
		$this->set('eventSchedule', $this->EventSchedule->read(null, $id));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->EventSchedule->create();
			if ($this->EventSchedule->save($this->request->data)) {
				$this->Session->setFlash(__('The event schedule has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The event schedule could not be saved. Please, try again.'));
			}
		}
		$types = $this->EventSchedule->Type->find('list');
		$creators = $this->EventSchedule->Creator->find('list');
		$modifiers = $this->EventSchedule->Modifier->find('list');
		$this->set(compact('types', 'creators', 'modifiers'));
	}

/**
 * edit method
 *
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		$this->EventSchedule->id = $id;
		if (!$this->EventSchedule->exists()) {
			throw new NotFoundException(__('Invalid event schedule'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->EventSchedule->save($this->request->data)) {
				$this->Session->setFlash(__('The event schedule has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The event schedule could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->EventSchedule->read(null, $id);
		}
		$types = $this->EventSchedule->Type->find('list');
		$creators = $this->EventSchedule->Creator->find('list');
		$modifiers = $this->EventSchedule->Modifier->find('list');
		$this->set(compact('types', 'creators', 'modifiers'));
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
		$this->EventSchedule->id = $id;
		if (!$this->EventSchedule->exists()) {
			throw new NotFoundException(__('Invalid event schedule'));
		}
		if ($this->EventSchedule->delete()) {
			$this->Session->setFlash(__('Event schedule deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Event schedule was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}
