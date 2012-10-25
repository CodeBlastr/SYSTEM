<?php
App::uses('EventsAppController', 'Events.Controller');
/**
 * EventVenues Controller
 *
 * @property EventVenue $EventVenue
 */
class EventVenuesController extends EventsAppController {

    	public $name = 'EventVenues';
	
	public $uses = array('Events.EventVenue');

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->EventVenue->recursive = 0;
		$this->set('eventVenues', $this->paginate());
	}

/**
 * view method
 *
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		$this->EventVenue->id = $id;
		if (!$this->EventVenue->exists()) {
			throw new NotFoundException(__('Invalid event venue'));
		}
		$this->set('eventVenue', $this->EventVenue->read(null, $id));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->EventVenue->create();
			if ($this->EventVenue->save($this->request->data)) {
				$this->Session->setFlash(__('The event venue has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The event venue could not be saved. Please, try again.'));
			}
		}
		$parentEventVenues = $this->EventVenue->ParentEventVenue->find('list');
		$events = $this->EventVenue->Event->find('list');
		$this->set(compact('parentEventVenues', 'events'));
	}

/**
 * edit method
 *
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		$this->EventVenue->id = $id;
		if (!$this->EventVenue->exists()) {
			throw new NotFoundException(__('Invalid event venue'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->EventVenue->save($this->request->data)) {
				$this->Session->setFlash(__('The event venue has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The event venue could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->EventVenue->read(null, $id);
		}
		$parentEventVenues = $this->EventVenue->ParentEventVenue->find('list');
		$events = $this->EventVenue->Event->find('list');
		$creators = $this->EventVenue->Creator->find('list');
		$modifiers = $this->EventVenue->Modifier->find('list');
		$this->set(compact('parentEventVenues', 'events', 'creators', 'modifiers'));
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
		$this->EventVenue->id = $id;
		if (!$this->EventVenue->exists()) {
			throw new NotFoundException(__('Invalid event venue'));
		}
		if ($this->EventVenue->delete()) {
			$this->Session->setFlash(__('Event venue deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Event venue was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}
