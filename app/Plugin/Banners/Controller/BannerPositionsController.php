<?php
class BannerPositionsController extends AppController {

	var $name = 'BannerPositions';

	function admin_index() {
		$this->BannerPosition->recursive = 0;
		$this->set('bannerPositions', $this->paginate());
	}

	function admin_view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid banner position', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('bannerPosition', $this->BannerPosition->read(null, $id));
	}

	function admin_add() {
		if (!empty($this->data)) {
			$this->BannerPosition->create();
			if ($this->BannerPosition->save($this->data)) {
				$this->Session->setFlash(__('The banner position has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The banner position could not be saved. Please, try again.', true));
			}
		}
		$creators = $this->BannerPosition->Creator->find('list');
		$modifiers = $this->BannerPosition->Modifier->find('list');
		$bannerTypes = enum('BANNER_TYPE');
		$this->set(compact('creators', 'modifiers', 'bannerTypes'));
	}

	function admin_edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid banner position', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->BannerPosition->save($this->data)) {
				$this->Session->setFlash(__('The banner position has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The banner position could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->BannerPosition->read(null, $id);
		}
		$creators = $this->BannerPosition->Creator->find('list');
		$modifiers = $this->BannerPosition->Modifier->find('list');
		$bannerTypes = enum('BANNER_TYPE');
		$this->set(compact('creators', 'modifiers', 'bannerTypes'));
	}

	function admin_delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for banner position', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->BannerPosition->delete($id)) {
			$this->Session->setFlash(__('Banner position deleted', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Banner position was not deleted', true));
		$this->redirect(array('action' => 'index'));
	}
}
?>