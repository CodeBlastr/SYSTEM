<?php
App::uses('EventsAppController', 'Events.Controller');
/**
 * Events Controller
 *
 * @property Event $Event
 */
class EventsController extends EventsAppController {

	public $name = 'Events';
	
	public $uses = array('Events.Event');
	
	//public $helpers = array('Time');
	
/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->Event->recursive = 0;
		$this->paginate = array(
		    'conditions' => array('Event.start > NOW()'),
		    'order' => array('Event.start' => 'asc')
		    );
		$this->set('events', $this->paginate());
	}
	public function myEvents($userId) {
		$this->Event->recursive = 0;
		$myEvents = $this->Event->find('all', array(
		    'conditions' => array(
			'Event.start > NOW()',
			'Event.creator_id' => $userId
		    ),
		    'order' => array('Event.start' => 'asc')
		    ));
		return $myEvents;
	}

/**
 * view method
 *
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		$this->Event->id = $id;
		if (!$this->Event->exists()) {
			throw new NotFoundException(__('Invalid event'));
		}
		$this->set('event', $this->Event->read(null, $id));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Event->create();
			if ($this->Event->save($this->request->data)) {
				$this->Session->setFlash(__('The event has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The event could not be saved. Please, try again.'));
			}
		}
		$eventSchedules = $this->Event->EventSchedule->find('list');
		$guests = $this->Event->Guest->find('list');
		$this->set(compact('eventSchedules', 'guests'));
	}

/**
 * edit method
 *
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		$this->Event->id = $id;
		if (!$this->Event->exists()) {
			throw new NotFoundException(__('Invalid event'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Event->save($this->request->data)) {
				$this->Session->setFlash(__('The event has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The event could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->Event->read(null, $id);
		}
		$eventSchedules = $this->Event->EventSchedule->find('list');
		$guests = $this->Event->Guest->find('list');
		$this->set(compact('eventSchedules', 'guests'));
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
		$this->Event->id = $id;
		if (!$this->Event->exists()) {
			throw new NotFoundException(__('Invalid event'));
		}
		if ($this->Event->delete()) {
			$this->Session->setFlash(__('Event deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Event was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}
