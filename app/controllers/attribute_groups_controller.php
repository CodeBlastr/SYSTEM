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
	
	function beforeFilter() {
	    parent::beforeFilter(); 
	    $this->Auth->allowedActions = array('display');
	}

/**
 * Used when elements need to build forms 
 *
 * @param {plugin}		Plugin could be the plugin, if it is in the plugins list. If not then it is the model, and other params get pushed up. 
 * @param {limiter} 	We can set a limiter so that we can create a particular kind of form using the enumerations table.
 * @param {type}		add, edit or view form type?  Default to add for now, because that is the first one being worked on.
 * @return {attributes}	Form elements within the requested attribute groups.
 * @todo 				We may need to rethink how limiter works.  Because we may not really need it, and instead need a group (or parent_id) within the attribute groups -- oh maybe we could use sub?  Or something like that. 
 * @todo 				It is possible that a url like domain.com//model/add/59 would work (where there first value is null when it shows double slashes.  We might not even need this variable switching thing that we do. 
 */
	function display($plugin, $model = null, $type = 'add', $limiter = null) {
		# check if it is a plugin, and move variables derived from the url up a step if it isn't.
		$plugins = Configure::listObjects('plugin');
		if (!array_search($plugin, $plugins)) {
			$options['model'] = $plugin;
			$options['type'] = (!empty($model) ? $model : null);
			$options['limiter'] = (!empty($type) ? $type : null);
		} else {
			$options = array('plugin' => $plugin);
			$options['model'] = (!empty($model) ? $model : null);
			$options['type'] = (!empty($type) ? $type : null);
			$options['limiter'] = (!empty($limiter) ? $limiter : null);
		}
		
		$attributes = $this->AttributeGroup->getForm($options); 
		
		if (isset($this->params['requested'])) {
        	return $attributes;
        }
	}
	

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