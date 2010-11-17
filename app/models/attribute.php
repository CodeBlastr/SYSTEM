<?php
/**
 * Attribute Model
 *
 * Handles the return of information using the attributes model.  (think of attributes as form fields)
 *
 * PHP versions 5
 *
 * Zuha(tm) : Business Management Applications (http://zuha.com)
 * Copyright 2009-2010, Zuha Foundation Inc. (http://zuhafoundation.org)
 *
 * Licensed under GPL v3 License
 * Must retain the above copyright notice and release modifications publicly.
 *
 * @copyright     Copyright 2009-2010, Zuha Foundation Inc. (http://zuha.com)
 * @link          http://zuha.com Zuha™ Project
 * @package       zuha
 * @subpackage    zuha.app.models
 * @since         Zuha(tm) v 0.0.1
 * @license       GPL v3 License (http://www.gnu.org/licenses/gpl.html) and Future Versions
 */
class Attribute extends AppModel {

	var $name = 'Attribute';
	var $userField = array(); # Used to define the creator table field (typically creator_id)
	var $userLevel = false; # Used to define if this model requires record level user access control?
	
	var $validate = array(
		'attribute_group_id' => array('numeric'),
	    'code' => array(
	    	'rule' => '/^[a-z0-9_]{3,50}$/i',  
	        'message' => 'Only lowercase letters, integers, underscores, and min 3 and 50 characters'
	    ),
		'name' => array('notempty'),
		'input_type_id' => array('numeric'),
		'input_type_id' => array('numeric'),
		'is_unique' => array('numeric'),
		'is_required' => array('numeric'),
		'is_quicksearch' => array('numeric'),
		'is_advancedsearch' => array('numeric'),
		'is_comparable' => array('numeric'),
		'is_layered' => array('numeric'),
		'is_visible' => array('numeric'),
	); 
	
	//The Associations below have been created with all possible keys, those that are not needed can be removed
	var $belongsTo = array(
		'AttributeGroup' => array(
			'className' => 'AttributeGroup',
			'foreignKey' => 'attribute_group_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
	

/**
 * Finds all the attributes for the specified model and type.
 *
 * @param {model}		The model the attribute group belongsTo.
 * @param {typeId}		A limiter or predefined field which can be used to change the attributes that in the end get displayed. Refer to the enumerations table for id numbers.
 * @param {options] 	Additional directions for what attributes to find.
 * @return 				The optionally limited attributes for the specified model. 
 */
	function getAttributes($model, $typeId = null, $options = null) {
		$attributeGroup = $this->AttributeGroup->getAttributeGroup($model, $typeId);
		$attributes = $this->find('all', array(
			'conditions' => array(
				'Attribute.attribute_group_id' => $attributeGroup['AttributeGroup']['id'],
				$options['conditions'],
				),
			'order' => 'Attribute.order',
			));
		
		return $attributes;
	}

	
}
?>