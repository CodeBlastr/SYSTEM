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
			'characterCheck' => array(
		    	'rule' => '/^[a-z0-9_]{3,50}$/i',  
		        'message' => 'Only lowercase letters, integers, underscores, and min 3 and 50 characters'
				),
			'firstCodeCheck' => array(
				'rule' => array('initialCodeCheck', 'is_duplicate'),
				'message' => 'This code exists already, Click submit again to try a duplication.',
				),
			'uniqueCodeCheck' => array(
				'rule' => array('doubleUniqueCheck', 'attribute_group_id'),
				'message' => 'A field with this code already exists for this group.',
				),
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
 * Does a unique check using two fields.  If a record exists in which both fields values match the entered field values, returns false.
 *
 * @param {field}			An array where the key is the field name, and the value of that key is the db value.
 * @param {compare_field}	The second field to be checked. It is only the field name, no value included.
 * @return {BOOL}			True if it doesn't exist, False if it does.
 * @todo 					Add the if(!empty) stuff, and "= null" thing if needed.
 */	
	function doubleUniqueCheck($field, $compare_field) {
		$compareFieldValue = $this->data[$this->name][$compare_field];
		$result = $this->find('first', array(
			'conditions' => array(
				key($field) => $field[key($field)],
				$compare_field => $compareFieldValue,
				),
			));
		if (empty($result)) {
			return true;
		} else {
			return false;
		}
	}
	

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
	
/**
 * Checks to see if a field (or column) already exists in the database
 *
 * @param {attribute}	The attribute to check for.  An array with at least values for 'attribute_group_id' and 'code'.
 * @return {BOOL}		1 it does, 0 it does not
 * @todo				Add some type of error check for whether those two required data points exist.
 * @todo				Generalize and move to app model if its needed in any other model.
 */
	function checkFieldExistence($attribute) {
		# get the model name from the attribute group
		$this->AttributeGroup->id = $attribute['attribute_group_id'];
		$modelName = $this->AttributeGroup->field('model');
		# repurpose it into an actual table name using conventions
		$tableName = Inflector::underscore(Inflector::pluralize($modelName));
		# this is the field name
		$fieldName = $attribute['code'];
		
		# this checks to see if a field name now exists in the table that matches input info
		$fieldSearch = $this->query('SHOW columns FROM '.$tableName.' LIKE "'.$fieldName.'"');
		
		if (!empty($fieldSearch[0]['COLUMNS']['Field'])) {
			return true;
		} else {
			return false;
		}
	}
	
	
/**
 * Checks to see the field name already exists in this table.  Because if it does we shouldn't add it to the table, but we should see if we need to duplicate for another attribute group, so that we can reuse the same fields across multiple record types.
 *
 * @param {code}		The attribute to check for.  An array with at least values for 'attribute_group_id' and 'code'.
 * @return {BOOL}		unless is_duplicate is set it checks to see if the field exists, if is_duplicate is set, then save.
 * @todo				Add some type of error check for whether those two required data points exist.
 * @todo				Generalize and move to app model if its needed in any other model.
 */
	function initialCodeCheck($code){
		if (!empty($this->data['Attribute']['is_duplicate'])) {
			return true;
		} else {
			# this checks to see if a field name now exists in the table that matches input info
			if($this->checkFieldExistence($this->data['Attribute'])) {
				return false;
			} else {
				return true;
			}
		}	
	}
	
}
?>