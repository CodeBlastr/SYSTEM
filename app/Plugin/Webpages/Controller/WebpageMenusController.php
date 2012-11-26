<?php
class WebpageMenusController extends WebpagesAppController {

	public $name = 'WebpageMenus';
    
	public $uses = 'Webpages.WebpageMenu';
    
	public $allowedActions = array('element');
    
    public $helpers = array('Utils.Tree');
	
/**
 * Element method
 * Finds the menu by id or code field
 * 
 * @param mixed $id
 * @return array $data
 */
	public function element($id = null) {
        $field =  Zuha::is_uuid($id) || is_numeric($id) ? 'id' : 'code';
        $read = $this->WebpageMenu->find('first', array('conditions' => array('WebpageMenu.' . $field => $id), 'fields' => array('WebpageMenu.lft', 'WebpageMenu.rght')));
        $menu = $this->WebpageMenu->find('threaded', array('conditions' => array('WebpageMenu.lft >=' => $read['WebpageMenu']['lft'], 'WebpageMenu.rght <=' => $read['WebpageMenu']['rght'])));
        $menu = $menu[0]; // we can only edit one menu at a time.
        $menu['WebpageMenu']['children'] = $this->WebpageMenu->find('count', array('conditions' => array('WebpageMenu.lft >' => $read['WebpageMenu']['lft'], 'WebpageMenu.rght <' => $read['WebpageMenu']['rght'])));
	
		if (!empty($menu['WebpageMenu']['children'])) {
			return $menu;
		} else {
			return null;
		}
	}
	
/**
 * Index method
 */
	public function index() {
        $this->paginate['fields'] = array('WebpageMenu.id', 'WebpageMenu.name', 'WebpageMenu.code', 'WebpageMenu.type');
		$this->paginate['conditions']['OR']['WebpageMenu.menu_id'] = array(null, '');
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
        $this->WebpageMenu->id = $id;
		if (!$this->WebpageMenu->exists()) {
			throw new NotFoundException(__('Menu not found'));
		}
		if (!empty($this->request->data)) {
			if ($this->WebpageMenu->save($this->request->data)) {
				$this->Session->setFlash(__('The menu has been saved', true));
				$this->redirect(array('controller' => 'webpage_menus', 'action' => 'index'));
			} else {
				$this->Session->setFlash(__('The menu could not be saved. Please, try again.', true));
			}
		}
        
		$menu = $this->WebpageMenu->read(null, $id);
        $this->request->data = $this->WebpageMenu->find('threaded', array('conditions' => array('WebpageMenu.lft >=' => $menu['WebpageMenu']['lft'], 'WebpageMenu.rght <=' => $menu['WebpageMenu']['rght'])));
	    $this->request->data = $this->request->data[0]; // we can only edit one menu at a time.
        $this->request->data['WebpageMenu']['children'] = $this->WebpageMenu->find('count', array('conditions' => array('WebpageMenu.lft >' => $menu['WebpageMenu']['lft'], 'WebpageMenu.rght <' => $menu['WebpageMenu']['rght'])));
		$types = $this->WebpageMenu->types();
		$this->set(compact('types'));
	}

	public function delete($id = null) {
        $this->WebpageMenu->id = $id;
    	if (!$this->WebpageMenu->exists()) {
			throw new NotFoundException(__('Menu not found'));
		}
		if ($this->WebpageMenu->delete($id)) {
			$this->Session->setFlash(__('Menu deleted', true));
			$this->redirect(array('controller' => 'webpage_menus', 'action'=>'index'));
		} else {
		    $this->Session->setFlash(__('Menu not deleted', true));
		}
	}
}