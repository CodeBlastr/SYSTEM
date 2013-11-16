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
		    ),
		// site install fails with this set and we aren't using it so it's commented out 
		// fyi, the fail has something to do with the schema after event
		// 'Webpage' => array(
			// 'className' => 'Webpages.Webpage',
			// 'foreignKey' => 'webpage_id',
			// 'conditions' => '',
			// 'fields' => '',
			// 'order' => ''
		    // )
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
 * Save all override
 */
    public function saveAll($data = null, $options = array()) {
		$data = $this->_cleanData($data);
		$this->create();
        if (parent::saveAll($data, $options)) {
            return true;
        } else {
            throw new Exception(ZuhaInflector::invalidate($this->invalidFields()));
        }
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
		
		// put data in, to create a check data for whether to create page or not() 
		// it is in the cleanData function because we add some data to the save depending on creation of a page
		// make sure this gets fired last after all other $data updates
		
		if (!empty($data['WebpageMenuItem']['item_url']) && strpos($data['WebpageMenuItem']['item_url'], 'http') !== 0) {
			// if link_url starts with http do nothing
		} elseif ($data['WebpageMenuItem']['page_type'] == 'content' || $data['WebpageMenuItem']['page_type'] == 'section' || $data['WebpageMenuItem']['page_type'] == 'plugin') {
			// NOTE : don't change this if above, if you do installing a new site fails
			App::uses('Alias', 'Model');
			$Alias = new Alias;
			// else see if the page already exists
			$url = strpos($data['WebpageMenuItem']['item_url'], '/') === 0 ? substr($data['WebpageMenuItem']['item_url'], 1) : $data['WebpageMenuItem']['item_url'];
			$urlAlias = $Alias->getAlias($url);
			$textAlias = $Alias->getAlias($data['WebpageMenuItem']['item_text']);
			if (!empty($urlAlias['old']) || !empty($textAlias['old'])) {
				// if it does we don't need create a page, just move on ignoring the rest
				$data['WebpageMenuItem']['item_url'] = !empty($data['WebpageMenuItem']['item_url']) ? $data['WebpageMenuItem']['item_url'] : '/' . $textAlias['old'];
			} elseif ($data['WebpageMenuItem']['page_type'] == 'content' || $data['WebpageMenuItem']['page_type'] == 'section') {
				// if not then create page (depending on page type)
				$this->set($data);
				if ($this->validates()) {
					// map menu data to webpage data
			  		$webpage['Alias']['name'] = empty($data['WebpageMenuItem']['item_url']) ? $Alias->getNewAlias($data['WebpageMenuItem']['item_text']) : null;// if link_url is blank, set the link_url from the name (asciifyy)
			  		$webpage['Webpage']['name'] = $data['WebpageMenuItem']['item_text'];
			  		$webpage['Webpage']['title'] = $data['WebpageMenuItem']['item_text'];
					App::uses('Webpage', 'Webpages.Model');
					$Webpage = new Webpage;
					$webpage = $Webpage->placeholder($webpage, array('create' => true, 'type' => $data['WebpageMenuItem']['page_type']));
					unset($webpage['Webpage']); // don't want returned data to save again
					unset($webpage['Child']); // don't want returned data to save again
					unset($webpage['Alias']); // don't want returned data to save again
					$data = Set::merge($data, $webpage);
				} else {
					// it isn't going to save anyway, it didn't validate so do nothing, data should be resubmitted
				}
			} elseif ($data['WebpageMenuItem']['page_type'] == 'plugin') {
				$plugin = ZuhaInflector::pluginize($data['WebpageMenuItem']['item_text']);
				App::uses($plugin.'AppModel', $plugin.'.Model'); $className = $plugin.'AppModel';
				$Model = new $className;
				if (method_exists($Model, 'menuInit')) {
					// see if the plugin model has a function to generate starting links (note : handle test data in the schema)
					$data = $Model->menuInit($data);
				} else {
					throw new Exception('Create the menuInit() method in the ' . $plugin. 'AppModel file.');				
				}
			}
		}
        return $data;    
    }
	


}