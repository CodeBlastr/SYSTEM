<?php
App::uses('ModelBehavior', 'Model');
App::uses('Gallery', 'Galleries.Model');

/**
 * Mediable Behavior class file.
 *
 * Adds ability to add media related to any model. 
 * 
 * Usage is :
 * Attach behavior to a model, and add the necessary form inputs and then when you save, this behavior will handle the rest.
 *
 * @filesource
 * @author			Richard Kersey
 * @copyright       RazorIT LLC
 * @license			http://www.opensource.org/licenses/mit-license.php The MIT License
 * @link            https://github.com/zuha/Drafts-Zuha-Cakephp-Plugin
 */
class MediableBehavior extends ModelBehavior {

/**
 * Default values for settings.
 *
 * - recursive: whether to copy hasMany and hasOne records
 * - habtm: whether to copy hasAndBelongsToMany associations
 * - stripFields: fields to strip during copy process
 * - ignore: aliases of any associations that should be ignored, using dot (.) notation.
 * will look in the $this->contain array.
 *
 * @access private
 * @var array
 */
    protected $defaults = array(
		'modelAlias' => null, 
		'foreignKeyName' => null,
		);


/**
 * Configuration method.
 *
 * @param object $Model Model object
 * @param array $config Config array
 * @access public
 * @return boolean
 */
    public function setup($Model, $config = array()) {        
    	$this->settings = array_merge($this->defaults, $config);
		$this->modelName = !empty($this->settings['modelAlias']) ? $this->settings['modelAlias'] : $Model->alias;
		$this->foreignKey =  !empty($this->settings['foreignKeyName']) ? $this->settings['foreignKeyName'] : $Model->primaryKey;
        $this->Gallery = ClassRegistry::init('Galleries.Gallery');		
    	return true;
	}
        
	

/**
 * After save method.
 *
 * To use just have a Form->input('GalleryImage.filename');
 * To update an existing gallery make sure the Form->input('Gallery.id') is filled.
 *
 * @param object $Model model object
 * @param mixed $id String or integer model ID
 * @access public
 * @return boolean
 */
	public function afterSave($Model, $created) {
        if (isset($Model->data['GalleryImage'])){
            $data = $Model->data;
			$data[$this->modelName]['id'] = $Model->id;
			$data['Gallery']['model'] = $this->modelName;
			$data['Gallery']['foreign_key'] = $Model->id;
            if ($data['GalleryImage']['filename']['error'] == 0 && $this->Gallery->GalleryImage->add($data, 'filename')) {
                return true;
            } else {
                throw new Exception(__('Gallery Image save failed'));
            }
        }
        return true;
	}
}