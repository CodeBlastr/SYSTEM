<?php
App::uses('GalleriesAppModel', 'Galleries.Model');

class Gallery extends GalleriesAppModel {

	public $name = 'Gallery';
	// set up hard coded defaults, which get used if no data or site settings exist
	public $galleryType = 'colorbox';
	public $displayField = 'name';

	//The Associations below have been created with all possible keys, those that are not needed can be removed
	public $belongsTo = array(
		'GalleryThumb' => array(
			'className' => 'Galleries.GalleryImage',
			'foreignKey' => 'gallery_thumb_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Creator' => array(
			'className' => 'Users.User',
			'foreignKey' => 'creator_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Modifier' => array(
			'className' => 'Users.User',
			'foreignKey' => 'modifier_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

	public $hasOne = array(
		'Alias' => array(
			'className' => 'Alias',
			'foreignKey' => 'value',
			'dependent' => true,
			'conditions' => array('controller' => 'galleries'),
			'fields' => '',
			'order' => ''
		),
	);

	public $hasMany = array(
		'GalleryImage' => array(
			'className' => 'Galleries.GalleryImage',
			'foreignKey' => 'gallery_id',
			'dependent' => true,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		)
	);


	public function afterSave($created) {
		$gallery = $this->find('first', array('Gallery.id' => $this->id));
		if (!empty($gallery) && empty($gallery['Gallery']['model']) && empty($gallery['Gallery']['foreign_key'])) {
			$gallery['Gallery']['model'] = 'Gallery';
			$gallery['Gallery']['foreign_key'] = $gallery['Gallery']['id'];
			if ($this->save($gallery)) {
				return true;
			} else {
				return false;
			}
		}
	}


	public function afterFind($results) {
		if (!empty($results[0]['Gallery'])) {
			# handle hasMany results
			$i=0; foreach ($results as $result) {
				$results[$i] = Set::merge(array('GallerySettings' => $this->gallerySettings($result)), $result);
				$i++;
			}
		}

		if (!empty($results['id'])) {
			$results = Set::merge(array('GallerySettings' => $this->gallerySettings($results)), $results);
		}

		return $results;
	}

/**
 * Adds a gallery, and uploads the image using the GalleryImage model.  The image that is uploaded during Gallery creation is also used as the default thumbnail image for the gallery.
 *
 * @param {data}		An array of data to be saved.
 * @return {bool}		True if saved completely, false otherwise.
 * @todo				As part of the roll back methods, we could also delete the images that were uploaded.
 */
	public function add($data, $fileName) {
		// Making it so that you only need GalleryImage->add in a controller to make all the work happen.
		// Take special note of the "rollback" features.  I really like rolling back whenever possible on failures.
		// It keeps the database clean.
		$data['Gallery']['name'] = !empty($data['Gallery']['name']) ? $data['Gallery']['name'] : $data['Gallery']['model'];
		# set any Gallery model fields not filled in data with app or system defaults.
		$data = $this->GalleryImage->galleryImageDefaults($data);
		# create the gallery as the first step
		if ($this->save($data)) {
			# now if an image exists in data, save the image as the default thumbnail as well
			if (!empty($data['GalleryImage'])) {
				$galleryId = $this->id;
				$data['GalleryImage']['gallery_id'] = $galleryId;
				if ($this->GalleryImage->add($data, $fileName)) {
					# RESAVE the Gallery with this image that was just uploaded as the default thumb.
					$galleryImageId = $this->GalleryImage->id;
					$newData['Gallery']['id'] = $galleryId;
					$newData['GalleryImage']['id'] = $galleryImageId;
					$newData['Gallery']['foreign_key'] = empty($data['Gallery']['foreign_key']) ? $data['GalleryImage']['gallery_id'] : $data['Gallery']['foreign_key'];
					if ($this->makeThumb($newData)) {
						return true;
					} else {

						# roll back everything the resave failed.
						$this->GalleryImage->delete($galleryImageId);
						$this->delete($galleryId);
						throw new Exception(__d('galleries', 'ERROR : Making of gallery thumb failed.', true));
					}
				} else {
					# roll back by deleting the gallery if the image didn't save correctly.
					$this->delete($galleryId);
					throw new Exception(__d('galleries', 'ERROR : Gallery image update from gallery model.', true));
				}
			} else {
				return true; // no image was included? Probably not a good idea, but I'm sure its possible.
			}
		} else {
			throw new Exception(__d('galleries', 'ERROR : Gallery save update failed.', true));
		}
	}

	public function makeThumb($data) {
		if (!empty($data['Gallery']['id']) && !empty($data['GalleryImage']['id'])) {
			# if the image id is there just set it quick
			$data['Gallery']['gallery_thumb_id'] = $data['GalleryImage']['id'];
			if ($this->save($data)) {
				return true;
			} else {
				throw new Exception(__d('galleries', 'Gallery thumbnail update failed.', true));
			}
		} else if (!empty($data['Gallery']['id']) && !empty($data['GalleryImage'])) {
			#if its a new image then upload and make the thumb
			$data['GalleryImage']['gallery_id'] = $data['Gallery']['id'];
			if ($this->GalleryImage->add($data, 'filename')) {
				$galleryImageId = $this->GalleryImage->id;
				$data['Gallery']['gallery_thumb_id'] = $galleryImageId;
				$data['GalleryImage']['id'] = $galleryImageId;
				if ($this->makeThumb($data)) {
					return true;
				} else {
					throw new Exception(__d('galleries', 'ERROR : Gallery thumbnail update after image add failed.', true));
				}
			} else {
				throw new Exception(__d('galleries', 'ERROR : Gallery image add failed.', true));
			}
		} else {
			throw new Exception(__d('galleries', 'ERROR : Gallery id, and Gallery Image id must be provided', true));
		}
	}

	public function types() {
		return array(
			'colorbox' => 'Colorbox',
			'fancybox' => 'Fancybox',
			'gallerific' => 'Gallerific',
			'zoomable' => 'Zoomable',
			);
	}

}