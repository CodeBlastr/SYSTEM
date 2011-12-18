<?php
class MenusController extends MenusAppController {

	public $name = 'Menus';
	public $uses = 'Menus.Menu';
	public $allowedActions = array('element');
	
	function element($id = null) {
		if (!empty($id)) {
			$menu = $this->Menu->find('first', array(
				'conditions' => array(
					'Menu.id' => $id,
					),
				));
			$menuItems = $this->Menu->MenuItem->find('threaded', array(
				'conditions' => array(
					'MenuItem.menu_id' => $id,
					),
				'order' => array(
					'MenuItem.order',
					),
				));
			return array('menu' => $menu, 'items' => $menuItems);
		} else {
			return null;
		}
	}
	
		
	function index() {
		$this->Menu->recursive = 0;
		$this->paginate = array(
			'conditions' => array(
				'Menu.menu_id' => null,
				),
			);
		$this->set('menus', $this->paginate());
	}
	

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid menu', true));
			$this->redirect(array('action' => 'index'));
		}	
		$menu = $this->Menu->find('first', array(
			'conditions' => array(
				'Menu.id' => $id,
				),
			));
		$menuItems = $this->Menu->MenuItem->find('threaded', array(
			'conditions' => array(
				'MenuItem.menu_id' => $id,
				),
			'order' => array(
				'MenuItem.order',
				),
			)); 
		$this->set(compact('menu', 'menuItems'));
	}

	function add() {
		if (!empty($this->request->data)) {
			$this->Menu->create();
			if ($this->Menu->save($this->request->data)) {
				$this->Session->setFlash(__('The menu has been saved', true));
				$this->redirect(array('controller' => 'menu_items', 'action' => 'add', $this->Menu->id));
			} else {
				$this->Session->setFlash(__('The menu could not be saved. Please, try again.', true));
			}
		}
		$types = $this->Menu->types();
		$this->set(compact('types'));
	}

	function edit($id = null) {
		if (!$id && empty($this->request->data)) {
			$this->Session->setFlash(__('Invalid menu', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->request->data)) {
			if ($this->Menu->save($this->request->data)) {
				$this->Session->setFlash(__('The menu has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The menu could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->request->data)) {
			$this->request->data = $this->Menu->read(null, $id);
		}
		$types = $this->Menu->types();
		$this->set(compact('types'));
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for menu', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Menu->delete($id)) {
			$this->Session->setFlash(__('Menu deleted', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Menu was not deleted', true));
		$this->redirect(array('action' => 'index'));
	}
}
?>