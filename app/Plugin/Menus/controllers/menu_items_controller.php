<?php
class MenuItemsController extends MenusAppController {

	var $name = 'MenuItems';
	var $uses = array('Menus.MenuItem');
	
	function sort() {
		Configure::write('debug', 0);
		# get the menu_id for the root items (they should all have the same menu_id
		$menuItem = $this->MenuItem->find('first', array(
			'conditions' => array(
				'MenuItem.id' => $_REQUEST['order'][1]['item_id'],
				),
			));
		$i = 0;
		foreach ($_REQUEST['order'] as $item) {
			if ($item['item_id'] != 'root') {
				$this->request->data['MenuItem']['id'] = $item['item_id'];
				$this->request->data['MenuItem']['parent_id'] = $item['parent_id'] == 'root' ? $menuItem['MenuItem']['menu_id'] : $item['parent_id'];
				$this->request->data['MenuItem']['order'] = $i;
				$this->MenuItem->save($this->request->data);
			}
			$i++;
		}
		$this->render(false);
	}
	
	function index($menuId = null) {
		if (!empty($menuId)) {
			$this->paginate = array(
				'conditions' => array(
					'MenuItem.parent_id' => $menuId,
					),
				'contain' => array(
					'Menu',
					'ChildMenuItem' => array(
						'ChildMenuItem',
						),
					),
				);
			$this->set('menuItems', $this->paginate());
		} else {
			$this->Session->setFlash(__('Invalid menu', true));
			$this->redirect(array('controller' => 'menus', 'action' => 'index'));
		}
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid menu', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('menuItem', $this->MenuItem->find('first', array(
			'conditions' => array(
				'MenuItem.id' => $id,
				),
			'contain' => array(
				'Menu',
				'ChildMenuItem',
				),
			)));
	}

	/**
	 * Add a menu item
	 * 
	 * @param {int}		The id of the menu to add it to.
	 * @param {int}		The id of the parent item to make it a child of.
	 * @param {str}		The text to use for the link.
	 * @param {str}		The url to link to.
	 * @todo			Need to use the last three params.  admin_view does link here using the parentId param.
	 */
	function add($menuId = null, $linkText = null, $linkUrl = null) {
		# if these are set we have enough to create an item
		if (!empty($menuId) && !empty($linkText) && !empty($linkUrl)) {
			if($menu = $this->MenuItem->Menu->find('first', array('conditions' => array('Menu.id' => $menuId)))) {
				$this->request->data['MenuItem']['parent_id'] = $menu['Menu']['id'];
				$this->request->data['MenuItem']['menu_id'] = $menuId;
				$this->request->data['MenuItem']['item_text'] = $linkText;
				$this->request->data['MenuItem']['item_url'] = base64_decode($linkUrl);
			}
		}
		
		if (!empty($this->request->data)) {
			try {
				$this->MenuItem->add($this->request->data);
				$this->Session->setFlash(__d('menus', 'Menu item added.', true));
				$this->redirect(array('controller' => 'menus', 'action' => 'view', $this->request->data['MenuItem']['menu_id']));
			} catch (Exception $e) {
				$this->Session->setFlash($e->getMessage());
			}
		}
		
		if (!empty($menuId)) {
			$parents = $this->MenuItem->ParentMenuItem->generatetreelist(array('ParentMenuItem.menu_id' => $menuId));
			$menus = null;
		} else {
			$parents = null;
			$menus = $this->MenuItem->Menu->find('list', array('conditions' => array('Menu.menu_id' => null)));
		}
		$itemTargets = $this->MenuItem->itemTargets();
		$this->set(compact('menuId', 'menus', 'parents', 'itemTargets'));
		$this->request->data['MenuItem']['item_text'] = urldecode($linkText);
		$this->request->data['MenuItem']['item_url'] = base64_decode($linkUrl);
	}

	function edit($id = null) {
		if (!$id && empty($this->request->data)) {
			$this->Session->setFlash(__('Invalid menu', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->request->data)) {
			if ($this->MenuItem->save($this->request->data)) {
				$this->Session->setFlash(__('The menu has been saved', true));
				$this->redirect($this->referer());
			} else {
				$this->Session->setFlash(__('The menu could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->request->data)) {
			$this->request->data = $this->MenuItem->read(null, $id);
		}
		
		$menus = $this->MenuItem->Menu->find('list', array('conditions' => array('Menu.menu_id' => null)));
		$parents = $this->MenuItem->ParentMenuItem->generatetreelist(array(
			'ParentMenuItem.menu_id' => $this->request->data['MenuItem']['menu_id']));
		$itemTargets = $this->MenuItem->itemTargets();
		$this->set(compact('menus', 'parents', 'itemTargets'));
	}

	function delete($id = null) {
		if (!empty($this->request->data['MenuItem']['id'])) {
			$id = $this->request->data['MenuItem']['id'];
		}
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for menu item', true));
			$this->redirect($this->referer());
		}
		if ($this->MenuItem->delete($id)) {
			$this->Session->setFlash(__('Menu item deleted', true));
			$this->redirect($this->referer());
		}
		$this->Session->setFlash(__('Menu item was not deleted', true));
		$this->redirect($this->referer());
	}
	
}
?>