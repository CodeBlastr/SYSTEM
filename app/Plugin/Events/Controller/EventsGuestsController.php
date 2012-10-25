<?php
App::uses('EventsAppController', 'Events.Controller');
/**
 * EventsGuests Controller
 *
 * @property EventsGuest $EventsGuest
 */
class EventsGuestsController extends EventsAppController {


/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->EventsGuest->recursive = 0;
		$this->set('eventsGuests', $this->paginate());
	}

/**
 * view method
 *
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		$this->EventsGuest->id = $id;
		if (!$this->EventsGuest->exists()) {
			throw new NotFoundException(__('Invalid events guest'));
		}
		$this->set('eventsGuest', $this->EventsGuest->read(null, $id));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->EventsGuest->create();
			if ($this->EventsGuest->save($this->request->data)) {
				$this->Session->setFlash(__('The events guest has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The events guest could not be saved. Please, try again.'));
			}
		}
		$events = $this->EventsGuest->Event->find('list');
		$users = $this->EventsGuest->User->find('list');
		$eventVenues = $this->EventsGuest->EventVenue->find('list');
		$eventSeats = $this->EventsGuest->EventSeat->find('list');
		$creators = $this->EventsGuest->Creator->find('list');
		$modifiers = $this->EventsGuest->Modifier->find('list');
		$this->set(compact('events', 'users', 'eventVenues', 'eventSeats', 'creators', 'modifiers'));
	}

/**
 * edit method
 *
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		$this->EventsGuest->id = $id;
		if (!$this->EventsGuest->exists()) {
			throw new NotFoundException(__('Invalid events guest'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->EventsGuest->save($this->request->data)) {
				$this->Session->setFlash(__('The events guest has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The events guest could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->EventsGuest->read(null, $id);
		}
		$events = $this->EventsGuest->Event->find('list');
		$users = $this->EventsGuest->User->find('list');
		$eventVenues = $this->EventsGuest->EventVenue->find('list');
		$eventSeats = $this->EventsGuest->EventSeat->find('list');
		$creators = $this->EventsGuest->Creator->find('list');
		$modifiers = $this->EventsGuest->Modifier->find('list');
		$this->set(compact('events', 'users', 'eventVenues', 'eventSeats', 'creators', 'modifiers'));
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
		$this->EventsGuest->id = $id;
		if (!$this->EventsGuest->exists()) {
			throw new NotFoundException(__('Invalid events guest'));
		}
		if ($this->EventsGuest->delete()) {
			$this->Session->setFlash(__('Events guest deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Events guest was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}
