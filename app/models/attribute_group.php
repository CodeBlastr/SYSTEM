<?php
/**
 * Attribute Group Model
 *
 * Handles the grouping of attributes (think of attributes as form fields).  Attribute Group is literally the model that these attributes belong to, and has a type so that one model can have multiple attributes for different types. 
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
class AttributeGroup extends AppModel {

	var $name = 'AttributeGroup';	
	var $validate = array(
		'name' => array('notempty'),
		'model' => array('notempty'),
	);
	
	var $userField = array(); # Used to define the creator table field (typically creator_id)
	var $userLevel = false; # Used to define if this model requires record level user access control?
	
	//The Associations below have been created with all possible keys, those that are not needed can be removed
	var $hasMany = array(
		'Attribute' => array(
			'className' => 'Attribute',
			'foreignKey' => 'attribute_group_id',
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
	
	//The Associations below have been created with all possible keys, those that are not needed can be removed
	var $belongsTo = array(
		'Enumeration' => array(
			'className' => 'Enumeration',
			'foreignKey' => 'enumeration_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
	

/**
 * Finds the attribute group.
 *
 * @param {model}		The model the attribute group belongsTo.
 * @param {typeId}		A limiter or predefined field which can be used to change the attributes that in the end get displayed. Refer to the enumerations table for id numbers.
 * @todo 				I'm assuming there will be a problem later with the additional of adding belongsTo models automatically, so we will probably need to set an on off switch for that method.
 */
	function getAttributeGroups($model, $typeId = null) {		
		App::Import('Model', 'Contacts.'.$model);
		$this->$model = new $model;
		$models = array_keys($this->$model->belongsTo);
		$models[] = $model;
		
		$attributeGroups = $this->find('all', array(
			'conditions' => array(
				array(
					'OR' => array(
						array('AttributeGroup.enumeration_id' => $typeId),
						array('AttributeGroup.enumeration_id' => null),
						),
					),
				'AND' => array(
					array(
						'AttributeGroup.model' => $models,
						),
					),
				),
			));		
		return $attributeGroups;
	}
	
	
	function getForm($options) {	
		$plugin = (!empty($options['plugin']) ? $options['plugin'].'.' : null);
		$model = (!empty($options['model']) ? $options['model'] : null);
		$type = (!empty($options['type']) ? $options['type'] : null);
		$limiter = (!empty($options['limiter']) ? $options['limiter'] : null);
		
		# get the models this model belongs to
		App::Import('Model', $plugin.$model);
		$this->$model = new $model;
		$models = array_keys($this->$model->belongsTo);
		$models[] = $model;
		
		$attributeGroups = $this->find('all', array(
			'conditions' => array(
				array(
					'OR' => array(
						array('AttributeGroup.enumeration_id' => $limiter),
						array('AttributeGroup.enumeration_id' => null),
						),
					),
				'AND' => array(
					array(
						'AttributeGroup.model' => $models,
						),
					),
				),
			'contain' => array(
				'Attribute',
				),
			));		
		return $attributeGroups;
	}
	
	
}
?>