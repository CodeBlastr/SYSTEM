<?php
class GalleryImagesController extends GalleriesAppController {

	public $name = 'GalleryImages';
	public $uses = 'Galleries.GalleryImage';

	function edit($id = null) {
		if (!empty($this->request->data)) {
			if ($this->GalleryImage->add($this->request->data, 'filename')) {
				$this->Session->setFlash(__('The image has been saved', true));
				$this->redirect($this->referer());
			} else {
				$this->Session->setFlash(__('The image could not be saved. Please, try again.', true));
				$this->redirect($this->referer());
			}
		}
		if (empty($this->request->data)) {
			$this->request->data = $this->GalleryImage->read(null, $id);
		}
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid GalleryImage.', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->set('galleryImage', $this->GalleryImage->read(null, $id));
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for Image', true));
			$this->redirect($this->referer());
		}
		if ($this->GalleryImage->delete($id)) {
			$this->Session->setFlash(__('Image deleted', true));
			$this->redirect($this->referer());
		}
	}
	
	function admin_index() {
		$this->GalleryImage->recursive = 0;
		$this->set('galleryImages', $this->paginate());
	}

	function admin_view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid GalleryImage.', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->set('galleryImage', $this->GalleryImage->read(null, $id));
	}

	function admin_edit($id = null) {
		if (!empty($this->request->data)) {
			if ($this->GalleryImage->add($this->request->data)) {
				$this->Session->setFlash(__('The image has been saved', true));
				$this->redirect($this->referer());
			} else {
				$this->Session->setFlash(__('The image could not be saved. Please, try again.', true));
				$this->redirect($this->referer());
			}
		}
		if (empty($this->request->data)) {
			$this->request->data = $this->GalleryImage->read(null, $id);
		}
	}

	function admin_delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for GalleryImage', true));
			$this->redirect($this->referer());
		}
		if ($this->GalleryImage->delete($id)) {
			$this->Session->setFlash(__('GalleryImage deleted', true));
			$this->redirect($this->referer());
		}
	}

}
?>