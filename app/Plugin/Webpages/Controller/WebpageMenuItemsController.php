<?php
class WebpageMenuItemsController extends WebpagesAppController {

	public $name = 'WebpageMenuItems';
    
	public $uses = array('Webpages.WebpageMenuItem');
	
	public function sort() {
		// Configure::write('debug', 0);
		// get the menu_id for the root items (they should all have the same menu_id        
		$menu = $this->WebpageMenuItem->find('first', array(
			'conditions' => array(
				'WebpageMenuItem.id' => $this->request->data['order'][1]['item_id'],
				),
			));
		$i = 0;
		foreach ($this->request->data['order'] as $item) {
			if ($item['depth'] != 0) {
				$data['WebpageMenuItem']['id'] = $item['item_id'];
				$data['WebpageMenuItem']['parent_id'] = $item['parent_id'] == 'root' ? $menu['WebpageMenuItem']['menu_id'] : $item['parent_id'];
				$data['WebpageMenuItem']['order'] = $i;
				if ($this->WebpageMenuItem->save($data, array('validate' => false))) {
    			    $output[] = $data;   
				} else {
                    $output['brokeOn'] = $data;
    			    break;
				}
			}
			$i++;
		}
        $this->WebpageMenuItem->reorder(array('id' => $menu['WebpageMenuItem']['menu_id'], 'field' => 'order'));
        $this->set(compact('output'));
		$this->render(false);
	}
	
	public function index($menuId = null) {
		if (!empty($menuId)) {
			$this->paginate['conditions']['WebpageMenuItem.parent_id'] = $menuId;
            $this->paginate['contain'] = array('WebpageMenu', 'WebpageMenuItem' => array('WebpageMenuItem'));
			$this->set('menuItems', $this->paginate());
		} else {
			$this->Session->setFlash(__('Invalid menu', true));
			$this->redirect(array('controller' => 'menus', 'action' => 'index'));
		}
	}

	public function view($id = null) {
    	$this->WebpageMenuItem->id = $id;
		if (!$this->WebpageMenuItem->exists()) {
			throw new NotFoundException(__('Link not found'));
		}
		$this->set('menuItem', $this->WebpageMenuItem->find('first', array(
			'conditions' => array(
				'WebpageMenuItem.id' => $id,
				),
			'contain' => array(
				'WebpageMenu',
				'ChildMenuItem',
				),
			)));
	}

/**
 * Add a menu item
 * 
 */
	public function add($menuId = null) {
		if (!empty($this->request->data)) {
			try {
				$this->WebpageMenuItem->add($this->request->data);
				$this->Session->setFlash(__d('menus', 'Menu item added.', true));
				$this->redirect(array('controller' => 'webpage_menus', 'action' => 'edit', $this->request->data['WebpageMenuItem']['menu_id']));
			} catch (Exception $e) {
				$this->Session->setFlash($e->getMessage());
			}
		}
        
		$menus = $this->WebpageMenuItem->WebpageMenu->find('list', array('conditions' => array('WebpageMenu.menu_id' => null)));
		$parents = $this->WebpageMenuItem->ParentMenuItem->generateTreeList(array('ParentMenuItem.menu_id' => $menuId));
		
		$itemTargets = $this->WebpageMenuItem->itemTargets();
		$this->set(compact('menuId', 'menus', 'parents', 'itemTargets'));
		$this->request->data['WebpageMenuItem']['item_text'] = urldecode($linkText);
		$this->request->data['WebpageMenuItem']['item_url'] = base64_decode($linkUrl);
	}

	public function edit($id = null) {
		if (!empty($this->request->data)) {
			if ($this->WebpageMenuItem->save($this->request->data)) {
				$this->Session->setFlash(__('Link has been saved', true));
				$this->redirect(array('plugin' => 'webpages', 'controller' => 'webpage_menus', 'action' => 'edit', $this->request->data['WebpageMenuItem']['menu_id']));
			} else {
				$this->Session->setFlash(__('The menu could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->request->data)) {
			$this->request->data = $this->WebpageMenuItem->read(null, $id);
		}
		
		$menus = $this->WebpageMenuItem->WebpageMenu->find('list', array('conditions' => array('WebpageMenu.menu_id' => null)));
		$parents = $this->WebpageMenuItem->ParentMenuItem->generateTreeList(array(
			'ParentMenuItem.menu_id' => $this->request->data['WebpageMenuItem']['menu_id']));
		$itemTargets = $this->WebpageMenuItem->itemTargets();
		$this->set(compact('menus', 'parents', 'itemTargets'));
	}

	public function delete($id = null) {
        $this->WebpageMenuItem->id = $id;
		if (!$this->WebpageMenuItem->exists()) {
			throw new NotFoundException(__('Link not found'));
		}
		if ($this->WebpageMenuItem->delete($id)) {
			$this->Session->setFlash(__('Link deleted', true));
			$this->redirect($this->referer());
		}
		$this->Session->setFlash(__('Link was not deleted', true));
		$this->redirect($this->referer());
	}
	
}