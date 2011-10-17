<?php
class GalleriesController extends GalleriesAppController {

	var $name = 'Galleries';
	var $allowedActions = array('thumb');

/**
 * Index for gallery.
 * 
 */
	function index() {
		# see if this gallery 
		$this->settings['conditions'] = !empty($this->params['pass'][0]) && !empty($this->params['pass'][1]) ? 
			array('Gallery.model' => $this->params['pass'][0], 'Gallery.foreign_key' => $this->params['pass'][1]) : 
			null;
		# we need the main image for the gallery to show a thumbnail
		$this->settings['contain'] = array('GalleryImage');
		# paginate the results
		$this->paginate = $this->settings;
		debug($this->paginate);
		$this->set('galleries', $this->paginate());
		$this->set('displayName', 'name');
		$this->set('displayDescription', 'description');
		$this->set('showGallery', true);
		$this->set('galleryForeignKey', 'id');
	}


/**
 * View for gallery
 */
	function view($id = null) {
		if (!empty($id)) {
			$gallery = $this->Gallery->find('first', array(
				'conditions' => array(
					'Gallery.id' => $id
					),
				'contain' => array(
					'GalleryImage',
					),
				));
			# This is here, because we have an element doing a request action on it.
			if (isset($this->params['requested'])) {
	        	if (!empty($gallery)) {
					return $gallery;
				} else {
					return null;
				}
	        } 
			$this->set(compact('gallery'));
			$this->set('value', $this->Gallery->_galleryVars($gallery)); 
		} else {
			#This was causing an error with catalog items and other items which have galleries, but the galley didn't exist.
			#$this->Session->setFlash(__('Invalid Gallery.', true));
			#$this->redirect(array('action'=>'index'));
		}
	}


	function thumb($id = null) {
		if (!$id && !empty($this->params['named']['model']) && !empty($this->params['named']['foreignKey'])) {
			$conditions = array('Gallery.model' => $this->params['named']['model'], 'Gallery.foreign_key' => $this->params['named']['foreignKey']);
		} else {
			$conditions = array('Gallery.id' => $id);
		}
		
		$gallery = $this->Gallery->find('first', array(
			'conditions' => $conditions,
			'contain' => array(
				'GalleryThumb',
				),
			));		
		
		if (!empty($gallery)) {
			# This is here, because we have an element doing a request action on it.
			if (isset($this->params['requested'])) {
				return $gallery;
	        } else {
				$this->set('gallery', $gallery);
			}
		} 
	}

	function add($model = null, $foreignKey = null) {
		if (!empty($this->data)) {
			try {
				$this->Gallery->GalleryImage->add($this->data, 'filename');
				$this->Session->setFlash(__('The Gallery has been saved', true));
				$gallery = $this->Gallery->findbyId($this->Gallery->id);
				$this->redirect(array('action' => 'edit', $gallery['Gallery']['model'], $gallery['Gallery']['foreign_key']));			
			} catch (Exception $e) {
				$this->Session->setFlash($e->getMessage());
				$this->redirect($this->referer());
			}
		}
		$this->set('types', $this->Gallery->types()); 
		$model = !empty($model) ? $model : 'Gallery';
		$foreignKey = !empty($foreignKey) ? $foreignKey : null;
		$this->set('model', $model);
		$this->set('foreignKey', $foreignKey);
	}
	

	/**
	 * Edit a Gallery
	 * You must link to this with model and foreign_key to avoid confusion between edit/Id and edit/Model
	 *
	 * @todo		Convert galleries to slugs or aliases, for easier linking into edit and views.
	 */
	function edit($model = null, $foreignKey = null) {		
		if (!empty($this->data)) {				
			if ($this->Gallery->save($this->data)) {
				$this->Session->setFlash(__('The Gallery has been saved', true));
				$this->redirect(array('action'=>'edit', $this->data['Gallery']['model'], $this->data['Gallery']['foreign_key']));
			} else {
				$this->Session->setFlash(__('The Gallery could not be saved. Please, try again.', true));
				$this->redirect($this->referer());
			}
		} 
		
		if (!empty($model) && !empty($foreignKey)) {
			$id = $this->Gallery->field('id', array('Gallery.model' => $model,	'Gallery.foreign_key' => $foreignKey));
		} else {
			$this->Session->setFlash(__('Invalid Gallery', true));
			$this->redirect($this->referer());
		}
		
		
		if (empty($this->data)) {
			$gallery = $this->Gallery->find('first', array(
				'conditions' => array(
					'Gallery.model' => $model,
					'Gallery.foreign_key' => $foreignKey,
					),
				'contain' => array(
					'GalleryImage',
					),
				));
			$this->set(compact('gallery'));
			$this->set('value', $this->Gallery->_galleryVars($gallery)); 
		}
		
		$this->data['Gallery']['model'] = $model;
		$this->data['Gallery']['foreign_key'] = $foreignKey;
		$this->set('types', $this->Gallery->types());
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