<?php
/**
 * GalleryImagesController Class
 */
class GalleryImagesController extends GalleriesAppController {

/**
 * var string
 */
	public $name = 'GalleryImages';

/**
 * var string
 */
	public $uses = 'Galleries.GalleryImage';


/**
 * View method
 * 
 * @param uuid/int
 */
	public function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid GalleryImage.', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->set('galleryImage', $this->GalleryImage->read(null, $id));
	}

/**
 * View method
 * 
 * @param uuid/int
 */
	public function edit($id = null) {
		if (!empty($this->request->data)) {
			if ($this->GalleryImage->add($this->request->data, 'filename')) {
				$this->Session->setFlash(__('The image has been saved'));
				$this->redirect($this->referer());
			} else {
				$this->Session->setFlash(__('The image could not be saved. Please, try again.'));
				$this->redirect($this->referer());
			}
		}
		if (empty($this->request->data)) {
			$this->request->data = $this->GalleryImage->read(null, $id);
		}
	}

/**
 * Delete method
 *
 * @param uuid/int
 */
	public function delete($id = null) {
		try {
			$this->GalleryImage->delete($id);
			$this->Session->setFlash(__('Image deleted'));
			$this->redirect($this->referer());
		} catch (Exception $e) {
			$this->Session->setFlash($e->getMessage());
			$this->redirect($this->referer());
		}
	}

}