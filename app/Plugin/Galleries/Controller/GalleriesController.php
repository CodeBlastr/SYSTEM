<?php
class GalleriesController extends GalleriesAppController {

	public $name = 'Galleries';
	public $uses = 'Galleries.Gallery';
	public $allowedActions = array('thumb');

/**
 * Index for gallery.
 * 
 */
	function index() { 
		# see if this gallery 
		$params['conditions'] = !empty($this->request->params['pass'][0]) && !empty($this->request->params['pass'][1]) ? 
			array('Gallery.model' => $this->request->params['pass'][0], 'Gallery.foreign_key' => $this->request->params['pass'][1]) : 
			null;
		# we need the main image for the gallery to show a thumbnail
		$params['contain'] = array('GalleryImage');
		# paginate the results
		$this->paginate = $params;
		$this->set('galleries', $this->paginate());
		$this->set('displayName', 'name');
		$this->set('displayDescription', 'description');
		$this->set('showGallery', true);
		$this->set('galleryForeignKey', 'id');
	}


/**
 * View for gallery
 */
	function view($model = null, $foreignKey = null) {
		if (!empty($model) && !empty($foreignKey)) {
			$gallery = $this->Gallery->find('first', array(
				'conditions' => array(
					'Gallery.model' => $model,
					'Gallery.foreign_key' => $foreignKey,
					),
				'contain' => array(
					'GalleryImage',
					),
				));
			# This is here, because we have an element doing a request action on it.
			if (isset($this->request->params['requested'])) {
	        	if (!empty($gallery)) {
					return $gallery;
				} else {
					return null;
				}
	        } 
			$this->set(compact('gallery'));
		} else {
			return false;
		}
	}


	function thumb($model = null, $foreignKey = null) {
		if (!empty($model) && !empty($foreignKey)) {
			$gallery = $this->Gallery->find('first', array(
				'conditions' => array(
					'Gallery.model' => $model, 
					'Gallery.foreign_key' => $foreignKey,
					),
				'contain' => array(
					'GalleryThumb',
					),
				));	
		}
		
		if (!empty($gallery)) {
			# This is here, because we have an element doing a request action on it.
			if (isset($this->request->params['requested'])) {
				return $gallery;
	        } else {
				$this->set('gallery', $gallery);
			}
		} else {
			return false;
		}
	}



	function add($model = null, $foreignKey = null) {
		if (!empty($this->request->data)) {
			try {
				$this->Gallery->GalleryImage->add($this->request->data, 'filename');
				$this->Session->setFlash(__('The Gallery has been saved'));
				$gallery = $this->Gallery->findbyId($this->Gallery->id);
				$this->redirect(array('action' => 'edit', $gallery['Gallery']['model'], $gallery['Gallery']['foreign_key']));			
			} catch (Exception $e) {
				$this->Session->setFlash($e->getMessage());
				$this->redirect($this->referer());
			}
		}
		$types = $this->Gallery->types(); 
		$model = !empty($model) ? $model : 'Gallery';
		$foreignKey = !empty($foreignKey) ? $foreignKey : null;
		$this->set(compact('model', 'foreignKey', 'types'));
	}
	

/**
 * Edit a Gallery
 * You must link to this with model and foreign_key to avoid confusion between edit/Id and edit/Model
 *
 * @todo		Convert galleries to slugs or aliases, for easier linking into edit and views.
 */
	public function edit($model = null, $foreignKey = null) {
		if (!empty($this->request->data)) {			
			if ($this->Gallery->GalleryImage->add($this->request->data, 'filename')) {
				$this->Session->setFlash(__('The Gallery has been saved'));
				$this->redirect(array('action' => 'edit', $this->request->data['Gallery']['model'], $this->request->data['Gallery']['foreign_key']));
			} else {
				$this->Session->setFlash(__('The Gallery could not be saved. Please, try again.', true));
			}
		} 
		
		if (!empty($model) && !empty($foreignKey)) {
			$this->request->data = $this->Gallery->find('first', array(
				'conditions' => array(
					'Gallery.model' => $model,
					'Gallery.foreign_key' => $foreignKey,
					),
				));
		} else {
			$this->Session->setFlash(__('Invalid Gallery', true));
			$this->redirect($this->referer());
		}
		
		$types = $this->Gallery->types();
		$conversionTypes = $this->Gallery->conversionTypes();
		$this->set(compact('model', 'foreignKey', 'gallery', 'types', 'conversionTypes'));
	}
	
	
/**
 * Changes the thumbnail image used for a particular gallery.
 * @param {int} 
 * @param {int}
 */
	function make_thumb($galleryId = null, $galleryImageId = null) {
		try {
			$data['Gallery']['id'] = $galleryId;
			$data['GalleryImage']['id'] = $galleryImageId;
			$this->Gallery->makeThumb($data);
			$this->Session->setFlash(__d('galleries', 'Successful Gallery Thumb Update.', true));
			$this->redirect($this->referer());				
		} catch (Exception $e) {
			$this->Session->setFlash($e->getMessage());
			$this->redirect($this->referer());
		}
	}

}
?>