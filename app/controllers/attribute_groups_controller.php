<?php
/**
 * Attribute Groups Controller
 *
 * For use in grouping attributes (database fields) for use. 
 * Attribute groups can literally mean a database table.  The database table where attributes
 * will be saved.  For example : if you had a "ticket" attribute group, you may set it up
 * so that it attributes (database fields) added to this group, are added to the database 
 * table named, "tickets".  
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
 */
class AttributeGroupsController extends AppController {

	var $name = 'AttributeGroups';
	

	function admin_index() {
		$this->AttributeGroup->recursive = 0;
		
		if (!empty($this->params['named']['system'])) {
			$isSystem = 1;
		} else {
			$isSystem = 0;
		}
			
		$this->paginate = array(
			'conditions' => array(
				'AttributeGroup.is_system' => $isSystem,
				),
			);	
		$this->set('attributeGroups', $this->paginate());
	}

	function admin_edit($id = null) {
		if (!empty($this->data)) {
			if ($this->AttributeGroup->save($this->data)) {
				$this->Session->setFlash(__('The AttributeGroup has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The AttributeGroup could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->AttributeGroup->read(null, $id);
			$enumerations = $this->AttributeGroup->Enumeration->find('all');
			$enumerations = Set::combine($enumerations,'{n}.Enumeration.id', '{n}.Enumeration.name', '{n}.Enumeration.type');
			$this->set('enumerations', $enumerations);
		}
	}

	function admin_delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for AttributeGroup', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->AttributeGroup->delete($id)) {
			$this->Session->setFlash(__('AttributeGroup deleted', true));
			$this->redirect(array('action'=>'index'));
		}
	}

}
?>