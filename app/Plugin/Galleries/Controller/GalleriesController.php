<?php
class GalleriesController extends GalleriesAppController {

	public $name = 'Galleries';
	public $uses = 'Galleries.Gallery';
	public $allowedActions = array('thumb', 'mythumb');


/**
 * Index for gallery.
 * 
 */
	public function index() {
		// paginate the results
		$this->paginate['fields'] = array(
			'Gallery.name',
			'Gallery.description',
			'Gallery.model',
			'Gallery.foreign_key',
			'Gallery.type',
			'Gallery.created',
			);
		
		$this->set('galleries', $this->paginate());
		$this->set('displayName', 'name');
		$this->set('displayDescription', 'description');
		$this->set('showGallery', true);
		$this->set('galleryModel', array('name' => 'Gallery', 'alias' => 'Gallery', 'field' => 'model'));
		$this->set('galleryForeignKey', 'foreign_key');
		$this->set('link', array('pluginName' => 'galleries', 'controllerName' => 'galleries', 'actionName' => 'view', 'pass' => array('{model}', '{foreign_key}')));
	}


/**
 * View for gallery
 */
	public function view($model = null, $foreignKey = null) {
		if (!empty($model) && !empty($foreignKey)) {
			$conditions = array(
				'conditions' => array(
					'Gallery.model' => $model,
					'Gallery.foreign_key' => $foreignKey,
					),
				'contain' => array(
					'GalleryImage' => array(
						'order' => 'order'
						)
					),
				);
			// This is here, because we have an element doing a request action on this function.
			if (isset($this->request->params['requested'])) {
				$gallery = $this->Gallery->find('first', $conditions);
	        	if (!empty($gallery)) {
					return $gallery;
				} else {
					return null;
				}
	        } else {
				// Otherwise we just need the model and foreignKey
				$gallery = $this->Gallery->find('first', $conditions);
				$this->set(compact('gallery', 'model', 'foreignKey'));
			}
		} else {
			$this->Session->setFlash(__('Invalid gallery request.'));
			$gallery = null;
		}
	}


	public function thumb($model = null, $foreignKey = null) {
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



	public function add($model = null, $foreignKey = null) {
		if (!empty($this->request->data)) {
			try {
				$this->Gallery->GalleryImage->add($this->request->data, 'filename');
				$this->Session->setFlash(__('The Gallery has been saved. You can add more images now.'));
				$gallery = $this->Gallery->find('first', array('conditions' => array('Gallery.id' => $this->Gallery->id)));
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
				// if this comes back tell us why!  GalleryImage::add() should do Gallery::save() already. So what are you trying to save here.
				// $this->Gallery->save($this->request->data);
				$this->Session->setFlash(__('Saved'));
				$this->redirect($this->referer());
			} else {
				$this->Session->setFlash(__('Could not be saved. Please, try again.'));
			}
		} 
		
		if (!empty($model) && !empty($foreignKey)) {
			$this->request->data = $this->Gallery->find('first', array(
				'conditions' => array(
					'Gallery.model' => $model,
					'Gallery.foreign_key' => $foreignKey,
					),
				'contain' => array(
					'GalleryImage' => array(
						'order' => 'order'
						)
					)
				));
		} else {
			$this->Session->setFlash(__('Invalid Gallery', true));
			$this->redirect($this->referer());
		}
		
		$types = $this->Gallery->types();
		$conversionTypes = $this->Gallery->conversionTypes();
		$this->set(compact('model', 'foreignKey', 'gallery', 'types', 'conversionTypes'));
	}
	
	
	
	function delete($id = null) {
		$this->__delete('Gallery', $id);
	}	
    

/**
 * MyThumb method
 * 
 * Similiar to edit(), but only the creator can edit  
 *
 * @todo		Convert galleries to slugs or aliases, for easier linking into edit and views.
 */
	public function mythumb() {
		
		if (!empty($this->request->data['Gallery']['model']) && !empty($this->request->data['Gallery']['foreign_key'])) {	
            $continue = true;
            // check for gallery and if it exists 
            $gallery = $this->Gallery->find('first', array(
                'conditions' => array(
                    'Gallery.model' => $this->request->data['Gallery']['model'],
                    'Gallery.foreign_key' => $this->request->data['Gallery']['foreign_key']
                    )
                ));
            if (!empty($gallery) && $gallery['Gallery']['creator_id'] != $this->userId) {
                $this->request->data['Galery']['id'] = $gallery['Gallery']['id'];
                $continue = false;
            }
            
			if ($continue === true && $this->Gallery->GalleryImage->add($this->request->data, 'filename')) {
				$this->Session->setFlash(__('Saved'));
				$this->redirect($this->referer());
			} 
		} 
		$this->Session->setFlash(__('Could not be saved. Please, try again.'));
		$this->redirect($this->referer());
	}
	
	
/**
 * Changes the thumbnail image used for a particular gallery.
 * @param {int} 
 * @param {int}
 */
	public function make_thumb($galleryId = null, $galleryImageId = null) {
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
	
	
/**
 * Area to manage galleries and gallery settings.
 */
	public function dashboard() {
		$this->paginate['limit'] = 5;
		$this->index();
	}

}