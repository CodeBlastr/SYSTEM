<?php
class WebpageMenusController extends WebpagesAppController {

	public $name = 'WebpageMenus';
    
	public $uses = 'Webpages.WebpageMenu';
    
	public $allowedActions = array('element');
    
    public $helpers = array('Utils.Tree');
	
	public function element($id = null) {
		if (!empty($id)) {
			$menu = $this->WebpageMenu->find('first', array(
				'conditions' => array(
					'WebpageMenu.id' => $id,
					),
				));
			$menuItems = $this->WebpageMenu->WebpageMenuItem->find('threaded', array(
				'conditions' => array(
					'WebpageMenuItem.menu_id' => $id,
					),
				'order' => array(
					'WebpageMenuItem.order',
					),
				));
			return array('menu' => $menu, 'items' => $menuItems);
		} else {
			return null;
		}
	}
	
		
	public function index() {
		$this->WebpageMenu->recursive = 0;
        $this->paginate['fields'] = array('WebpageMenu.id', 'WebpageMenu.name', 'WebpageMenu.order');
		$this->paginate['conditions']['WebpageMenu.menu_id'] = null;
		$this->set('menus', $this->paginate());
	}
	

	public function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid menu', true));
			$this->redirect(array('controller' => 'webpage_menus', 'action' => 'index'));
		}	
		$menu = $this->WebpageMenu->find('first', array(
			'conditions' => array(
				'WebpageMenu.id' => $id,
				),
			));
		$menuItems = $this->WebpageMenu->WebpageMenuItem->find('threaded', array(
			'conditions' => array(
				'WebpageMenuItem.menu_id' => $id,
				),
			'order' => array(
				'WebpageMenuItem.order',
				),
			)); 
		$this->set(compact('menu', 'menuItems'));
	}

	public function add() {
		if (!empty($this->request->data)) {
			$this->WebpageMenu->create();
			if ($this->WebpageMenu->save($this->request->data)) {
				$this->Session->setFlash(__('The menu has been saved', true));
				$this->redirect(array('controller' => 'webpage_menu_items', 'action' => 'add', $this->WebpageMenu->id));
			} else {
				$this->Session->setFlash(__('The menu could not be saved. Please, try again.', true));
			}
		}
		$types = $this->WebpageMenu->types();
		$this->set(compact('types'));
	}

	public function edit($id = null) {
		if (!$id && empty($this->request->data)) {
			$this->Session->setFlash(__('Invalid menu', true));
			$this->redirect(array('controller' => 'webpage_menus', 'action' => 'index'));
		}
		if (!empty($this->request->data)) {
			if ($this->WebpageMenu->save($this->request->data)) {
				$this->Session->setFlash(__('The menu has been saved', true));
				$this->redirect(array('controller' => 'webpage_menus', 'action' => 'index'));
			} else {
				$this->Session->setFlash(__('The menu could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->request->data)) {
			$this->request->data = $this->WebpageMenu->read(null, $id);
		}
		$types = $this->WebpageMenu->types();
		$this->set(compact('types'));
	}

	public function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for menu', true));
			$this->redirect(array('controller' => 'webpage_menus', 'action'=>'index'));
		}
		if ($this->WebpageMenu->delete($id)) {
			$this->Session->setFlash(__('Menu deleted', true));
			$this->redirect(array('controller' => 'webpage_menus', 'action'=>'index'));
		}
		$this->Session->setFlash(__('Menu was not deleted', true));
		$this->redirect(array('controller' => 'webpage_menus', 'action' => 'index'));
	}
}