<?php
class BannerViewsController extends AppController {

	public $name = 'BannerViews';
	public $uses = 'Banners.BannerView';

	function index() {
		$this->BannerView->recursive = 0;
		$this->set('bannerViews', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid banner view', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('bannerView', $this->BannerView->read(null, $id));
	}

	function add() {
		if (!empty($this->request->data)) {
			$this->BannerView->create();
			if ($this->BannerView->save($this->request->data)) {
				$this->Session->setFlash(__('The banner view has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The banner view could not be saved. Please, try again.', true));
			}
		}
		$banners = $this->BannerView->Banner->find('list');
		$this->set(compact('banners'));
	}

	function edit($id = null) {
		if (!$id && empty($this->request->data)) {
			$this->Session->setFlash(__('Invalid banner view', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->request->data)) {
			if ($this->BannerView->save($this->request->data)) {
				$this->Session->setFlash(__('The banner view has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The banner view could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->request->data)) {
			$this->request->data = $this->BannerView->read(null, $id);
		}
		$banners = $this->BannerView->Banner->find('list');
		$this->set(compact('banners'));
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for banner view', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->BannerView->delete($id)) {
			$this->Session->setFlash(__('Banner view deleted', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Banner view was not deleted', true));
		$this->redirect(array('action' => 'index'));
	}
	function admin_index() {
		$this->BannerView->recursive = 0;
		$this->set('bannerViews', $this->paginate());
	}

	function admin_view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid banner view', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('bannerView', $this->BannerView->read(null, $id));
	}

	function admin_add() {
		if (!empty($this->request->data)) {
			$this->BannerView->create();
			if ($this->BannerView->save($this->request->data)) {
				$this->Session->setFlash(__('The banner view has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The banner view could not be saved. Please, try again.', true));
			}
		}
		$banners = $this->BannerView->Banner->find('list');
		$this->set(compact('banners'));
	}

	function admin_edit($id = null) {
		if (!$id && empty($this->request->data)) {
			$this->Session->setFlash(__('Invalid banner view', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->request->data)) {
			if ($this->BannerView->save($this->request->data)) {
				$this->Session->setFlash(__('The banner view has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The banner view could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->request->data)) {
			$this->request->data = $this->BannerView->read(null, $id);
		}
		$banners = $this->BannerView->Banner->find('list');
		$this->set(compact('banners'));
	}

	function admin_delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for banner view', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->BannerView->delete($id)) {
			$this->Session->setFlash(__('Banner view deleted', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Banner view was not deleted', true));
		$this->redirect(array('action' => 'index'));
	}
}
?>