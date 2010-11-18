<?php
/**
 * Attributes Controller
 *
 * Attributes are literally database fields. The goal of this controller is 
 * to allow end user editing of the fields in the database for the main purpose
 * of being able to generate custom forms and extend the data that core methods collect.
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
 * @subpackage    zuha.app.controllers
 * @since         Zuha(tm) v 0.0.1
 * @license       GPL v3 License (http://www.gnu.org/licenses/gpl.html) and Future Versions
 * @todo		  Match up the fields, and field options with the full run of cakephp form input options. 
 */
class AttributesController extends AppController {

	var $name = 'Attributes';


/**
 * Gives us filtered and paginated results for all attributes. 
 * 
 */
	function admin_index() {
		$this->Attribute->recursive = 0;
		
		if (!empty($this->params['named']['group'])) {
			$groupCondition = array('Attribute.attribute_group_id' => $this->params['named']['group']);
		} else {
			$groupCondition = null;
		}
		
		if (!empty($this->params['named']['system'])) {
			$systemCondition = array('Attribute.is_system' => 1);
		} else {
			$systemCondition = array('Attribute.is_system' => 0);
		}
		
		$this->paginate = array(
			'conditions' => array(
				$systemCondition,
				$groupCondition,
				),
			);
		$attributes = $this->paginate();
		
		$this->set(compact('attributes'));
	}


/**
 * This function is for adding attribute fields.
 * 
 * @param {id}		The id of the attribute to edit
 * @todo 			attributes need all the form options that cakephp has, so that you can easily make a database driven form
 * @todo			Move the second part of this save to the model, so that it is simply part of the save operation, and can be reused.
 */
	function admin_add() {
		if (!empty($this->data)) {
			# create the attribute
			if($this->Attribute->save($this->data)) {
				# update the database table
				$this->Attribute->query($this->_buildQuery($this->data, $this->Attribute->id));
				if ($this->Attribute->checkFieldExistence($this->data['Attribute'])) {
					$this->Session->setFlash(__('Attribute Successfully Added!', true));
					$this->redirect(array('action'=>'index'));
				} else {
					$this->Session->setFlash(__('Database table was not updated. Please try again.', true));
				}
			} else {
				$this->set('duplicate', true);
			}
		}
		
		$attributeGroups = $this->Attribute->AttributeGroup->find('list');
		$this->set(compact('attributeGroups'));		
	}

/**
 * This function is for editing attribute fields.
 * 
 * @param {id}		The id of the attribute to edit
 * @todo 			attributes need all the form options that cakephp has, so that you can easily make a database driven form
 * @todo			Changing a field type is NOT working
 * @todo			Overall this function is just too "fat" it needs to be trimmed down, and make the model fat instead.
 * @todo			Move the second part of this save to the model, so that it is simply part of the save operation, and can be reused.
 */
	function admin_edit($id) {
		if (!empty($this->data)) {
			# create the attribute
			if($this->Attribute->save($this->data)) {
				# update the database table
				$this->Attribute->query($this->_buildQuery($this->data, $this->Attribute->id));
				if ($this->Attribute->checkFieldExistence($this->data['Attribute'])) {
					$this->Session->setFlash(__('Attribute Successfully Added!', true));
					$this->redirect(array('action'=>'index'));
				} else {
					$this->Session->setFlash(__('Database table was not updated. Please try again.', true));
				}
			} else {
				$this->set('duplicate', true);
			}
		} else {
			$this->data = $this->Attribute->read(null, $id);
			if (!empty($this->data)) {
				$attributeGroups = $this->Attribute->AttributeGroup->find('list');
				$this->set(compact('attributeGroups'));
			} else {
				$this->Session->setFlash(__('Invalid Attribute', true));
				$this->redirect(array('action'=>'index'));
			}
		}
	}

	function admin_delete($id = null) {
		
		# To do, when you delete an attribute we need to delete the field from the database
		
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for Attribute', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Attribute->delete($id)) {
			$this->Session->setFlash(__('Attribute deleted', true));
			$this->redirect(array('action'=>'index'));
		}
	}
	
/**
 * Builds the query for updating the database table with new attributes. (AttributeGroup = table, Attribute = field)
 *
 * @param {thisData}		Info from the save operation.
 * @param {attriId}			The id of the attribute being saved
 * @todo					Possibly move this to the model. Otherwise decide not to and remove this todo.
 * @todo					Simplify and break up the multiple actions going on within this function.
 */
	function _buildQuery($thisData = null, $attrId = null) {
		# this is where you do all the magic
		$this->Attribute->AttributeGroup->id = $thisData['Attribute']['attribute_group_id'];
		$groupModel = $this->Attribute->AttributeGroup->field('model');
		$tableName = Inflector::underscore(Inflector::pluralize($groupModel));
		$fieldName = $thisData['Attribute']['code'];			
		$inputType = $thisData['Attribute']['input_type_id']; 
		# $fieldOptions = array('a', 'b', 'c');
		# un supported right now
		$fieldOptions = ''; 
				
		# set up the NULL value for the database field based on if its required or not
		if ($thisData['Attribute']['is_required'] == 1) {
			$nullStatus = ' NOT NULL ';
		} else {
			$nullStatus = ' NULL ';
		}
		
		# input the DEFAULT value if it exists
		if ($thisData['Attribute']['default_value'] == null) {
			$defaultStatus = ' ';
		} else {
			$defaultStatus = ' DEFAULT \''.$thisData['Attribute']['default_value'].'\' ';
		}
		
		
		# set up the UNIQUE index if it is a unique field
		if ($thisData['Attribute']['is_unique'] == 1) {
			$uniqueStatus = ' ADD UNIQUE (`'.$fieldName.'`) ';
		} else {
			$uniqueStatus = ' ';
		}
		
		
		/*
		$this->data['Attribute']['input_type_id'] values
		0 = 'Text Field'
		1 = 'Text Area'
		2 = 'Date'
		3 = 'Yes/No'
		4 = 'Multiple Select'
		5 = 'Dropdown'
		6 = 'Media/Image/File'
		*/
		if ($inputType == 0) {
			$fieldQuery = 'VARCHAR(255) '.$nullStatus.$defaultStatus.$uniqueStatus;
		} else if ($inputType == 1) {
			$fieldQuery = 'TEXT '.$nullStatus.$defaultStatus.$uniqueStatus;
		} else if ($inputType == 2) {
			$fieldQuery = 'DATETIME '.$nullStatus.$defaultStatus.$uniqueStatus;
		} else if ($inputType == 3) {
			$fieldQuery = 'TINYINT(1) '.$nullStatus.$defaultStatus.$uniqueStatus;
		} else if ($inputType == 4) {
			# this is multiple select and I'm not sure how to do this just yet
			$fieldQuery = 'TEXT '.$nullStatus.$defaultStatus.$uniqueStatus;
		} else if ($inputType == 5) {
			$fieldQuery = 'ENUM("'.implode('", "',$fieldOptions).'") '.$nullStatus.$defaultStatus.$uniqueStatus;
		} else if ($inputType == 6) {
			$fieldQuery = 'VARCHAR(255) '.$nullStatus.$defaultStatus.$uniqueStatus;
		} else {
			# break because its invalid
			$fieldQuery = false;
		}
		return $this->_query($tableName, $fieldName, $fieldQuery, $attrId);
	}
			

/**
 * Finalizes the query details from build query
 *
 * @param {tableName}		The table to modify
 * @param {fieldName}		The field to update or add
 * @param {fieldQuery}		The sub query from buildQuery
 * @todo					Possibly move this to the model. Otherwise decide not to and remove this todo.
 * @todo					Simplify and break up the multiple actions going on within this function.
 */
	function _query($tableName = null, $fieldName = null, $fieldQuery = null) {
		#this will be a separate function
		$table = $this->Attribute->query('SHOW tables LIKE "'.$tableName.'"');
		if (!empty($table)) {
			# add to the existing table
			$query = 'ALTER TABLE `'.$tableName.'`';
			# finally add the field
			$query .= 'ADD `'.$fieldName.'` ' . $fieldQuery;
		} else {
			# add a new table	
			$query = 'CREATE TABLE `'.$tableName.'` ( `id` INT( 11 ) NOT NULL AUTO_INCREMENT PRIMARY KEY , ';
			# finally add the field
			$query .= '`'.$fieldName.'` ' .$fieldQuery. ');';
		}
		return $query;
	}

}
?>