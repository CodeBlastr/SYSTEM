<?php
class WebpageMenuItem extends WebpagesAppModel {
    
	public $name = 'WebpageMenuItem';
    
	public $displayField = 'item_text';
    
	public $useTable = 'webpage_menus';
    
	public $actsAs = array('Tree');
    
	public $validate = array(
		'item_text' => array(
			'numeric' => array(
				'rule' => array('notempty'),
				'message' => 'Link text required',
				'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			    ),
		    ),
		'menu_id' => array(
    		'notempty' => array(
				'rule' => 'notempty',
				'message' => 'Menu required',
				),
    		),
	    );
        
	//The Associations below have been created with all possible keys, those that are not needed can be removed

	public $belongsTo = array(
		// this would not work with the className as 'Menus.Menu'
		'WebpageMenu' => array(
			'className' => 'Webpages.WebpageMenu',
			'foreignKey' => 'menu_id',
			'conditions' => '',
			'fields' => '',
			'order' => 'WebpageMenu.order'
		    ),
		'ParentMenuItem' => array(
			'className' => 'Webpages.WebpageMenuItem',
			'foreignKey' => 'parent_id',
			'conditions' => '',
			'fields' => '',
			'order' => 'ParentMenuItem.order'
		    )
	    );
	
	public $hasMany = array(
		'ChildMenuItem' => array(
			'className' => 'Webpages.WebpageMenuItem',
			'foreignKey' => 'parent_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => 'ChildMenuItem.order',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		    )
	    );
		
/**
 * Save override
 */
	public function save($data = null, $validate = true, $fieldList = array()) {
		$data = $this->_cleanData($data);
		return parent::save($data, $validate, $fieldList);
	}
	
/**
 * Item targets method
 * 
 * @return array 	list of target types for the href tags
 */
	public function itemTargets() {
		return array('_blank' => '_blank', '_self' => '_self', '_parent' => '_parent', '_top' => '_top');
	}
    
/**
 * Clean data method
 * 
 * @param array $data
 * @return array $data 
 */
    protected function _cleanData($data) {
    	// handle beforeSave() type data
        if (empty($data['WebpageMenuItem']['parent_id']) && !empty($data['WebpageMenuItem']['menu_id'])) {
            $data['WebpageMenuItem']['parent_id'] = $data['WebpageMenuItem']['menu_id'];
        }
		// handle save() type data
        if (empty($data['parent_id']) && !empty($data['menu_id'])) {
            $data['parent_id'] = $data['menu_id'];
        }

    	// handle beforeSave() type data
        if (empty($data['WebpageMenuItem']['name']) && !empty($data['WebpageMenuItem']['item_text'])) {
            $data['WebpageMenuItem']['name'] = $data['WebpageMenuItem']['item_text'];
        }
		// handle save() type data
        if (empty($data['name']) && !empty($data['item_text'])) {
            $data['name'] = $data['item_text'];
        }
        return $data;    
    }

}