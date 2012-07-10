<?php
class WebpageMenuItemsController extends WebpagesAppController {

	public $name = 'WebpageMenuItems';
	public $uses = array('Webpages.WebpageMenuItem');
	
	public function sort() {
		Configure::write('debug', 0);
		# get the menu_id for the root items (they should all have the same menu_id
		$menuItem = $this->WebpageMenuItem->find('first', array(
			'conditions' => array(
				'WebpageMenuItem.id' => $_REQUEST['order'][1]['item_id'],
				),
			));
		$i = 0;
		foreach ($_REQUEST['order'] as $item) {
			if ($item['item_id'] != 'root') {
				$this->request->data['WebpageMenuItem']['id'] = $item['item_id'];
				$this->request->data['WebpageMenuItem']['parent_id'] = $item['parent_id'] == 'root' ? $menuItem['WebpageMenuItem']['menu_id'] : $item['parent_id'];
				$this->request->data['WebpageMenuItem']['order'] = $i;
				$this->WebpageMenuItem->save($this->request->data);
			}
			$i++;
		}
		$this->render(false);
	}
	
	public function index($menuId = null) {
		if (!empty($menuId)) {
			$this->paginate = array(
				'conditions' => array(
					'WebpageMenuItem.parent_id' => $menuId,
					),
				'contain' => array(
					'WebpageMenu',
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

	public function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid menu', true));
			$this->redirect(array('action' => 'index'));
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
 * @param {int}		The id of the menu to add it to.
 * @param {int}		The id of the parent item to make it a child of.
 * @param {str}		The text to use for the link.
 * @param {str}		The url to link to.
 * @todo			Need to use the last three params.  admin_view does link here using the parentId param.
 */
	public function add($menuId = null, $linkText = null, $linkUrl = null) {
		# if these are set we have enough to create an item
		if (!empty($menuId) && !empty($linkText) && !empty($linkUrl)) {
			if($menu = $this->WebpageMenuItem->WebpageMenu->find('first', array('conditions' => array('WebpageMenu.id' => $menuId)))) {
				$this->request->data['WebpageMenuItem']['parent_id'] = $menu['Menu']['id'];
				$this->request->data['WebpageMenuItem']['menu_id'] = $menuId;
				$this->request->data['WebpageMenuItem']['item_text'] = $linkText;
				$this->request->data['WebpageMenuItem']['item_url'] = base64_decode($linkUrl);
			}
		}
		
		if (!empty($this->request->data)) {
			try {
				$this->WebpageMenuItem->add($this->request->data);
				$this->Session->setFlash(__d('menus', 'Menu item added.', true));
				$this->redirect(array('controller' => 'webpage_menus', 'action' => 'view', $this->request->data['WebpageMenuItem']['menu_id']));
			} catch (Exception $e) {
				$this->Session->setFlash($e->getMessage());
			}
		}
		
		if (!empty($menuId)) {
			$parents = $this->WebpageMenuItem->ParentMenuItem->generateTreeList(array('ParentMenuItem.menu_id' => $menuId));
			$menus = null;
		} else {
			$parents = null;
			$menus = $this->WebpageMenuItem->WebpageMenu->find('list', array('conditions' => array('WebpageMenu.menu_id' => null)));
		}
		$itemTargets = $this->WebpageMenuItem->itemTargets();
		$this->set(compact('menuId', 'menus', 'parents', 'itemTargets'));
		$this->request->data['WebpageMenuItem']['item_text'] = urldecode($linkText);
		$this->request->data['WebpageMenuItem']['item_url'] = base64_decode($linkUrl);
	}

	public function edit($id = null) {
		if (!$id && empty($this->request->data)) {
			$this->Session->setFlash(__('Invalid menu', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->request->data)) {
			if ($this->WebpageMenuItem->save($this->request->data)) {
				$this->Session->setFlash(__('The menu has been saved', true));
				$this->redirect($this->referer());
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
		if (!empty($this->request->data['WebpageMenuItem']['id'])) {
			$id = $this->request->data['WebpageMenuItem']['id'];
		}
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for menu item', true));
			$this->redirect($this->referer());
		}
		if ($this->WebpageMenuItem->delete($id)) {
			$this->Session->setFlash(__('Menu item deleted', true));
			$this->redirect($this->referer());
		}
		$this->Session->setFlash(__('Menu item was not deleted', true));
		$this->redirect($this->referer());
	}
	
}