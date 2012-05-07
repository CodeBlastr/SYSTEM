<?php
/**
 * Enumerations Controller
 *
 * One of the more difficult items to explain. It should be thought of as the central
 * storage house for "types".  The main purpose is to allow easy updating of labels
 * and data which is mainly used in drop down select boxes in numerous different forms.
 * The secondary purpose is to save the need for having massive numbers of "enum" 
 * database field types OR from having massive numbers of database tables with very 
 * little information.  An example would be the use of "Industries" for a contact. 
 * We would like the end user to be able to easily update the industries available in 
 * the form drop down where you assign a contact to an industry. 
 *
 * PHP versions 5
 *
 * Zuha(tm) : Business Management Applications (http://zuha.com)
 * Copyright 2009-2012, Zuha Foundation Inc. (http://zuha.org)
 *
 * Licensed under GPL v3 License
 * Must retain the above copyright notice and release modifications publicly.
 *
 * @copyright     Copyright 2009-2012, Zuha Foundation Inc. (http://zuha.com)
 * @link          http://zuha.com Zuha™ Project
 * @package       zuha
 * @subpackage    zuha.app.controllers
 * @since         Zuha(tm) v 0.0.1
 * @license       GPL v3 License (http://www.gnu.org/licenses/gpl.html) and Future Versions
 */
class EnumerationsController extends AppController {
	
    public $uses = array('Enumeration');
	
	public function search() {
		if(!empty($this->request->data)) {
			$this->request->data['Enumeration']['query'] = str_replace('*','%',$this->request->data['Enumeration']['query']);
			$this->request->data = $this->paginate('Enumeration',array(
				'Enumeration.type LIKE' => $this->request->data['Enumeration']['query']
			));
			
		}
		$this->set('schema',$this->Enumeration->_schema);
		$this->render('admin_index');
	}
	
	public function index() {
		$this->paginate['order'] = array(
				'Enumeration.type' => 'ASC',
				'Enumeration.weight' => 'ASC',
				'Enumeration.name' => 'ASC',
			);
		$this->request->data = $this->paginate();
	}
	
	public function changeOrder($id=null,$mode='increase') {
		$enumeration = $this->Enumeration->find('first',array(
			'conditions' => array(
				'Enumeration.id' => $id
			)
		));
		if($mode == 'increase') {
			$enumeration['Enumeration']['weight']++;
		}
		else {
			$enumeration['Enumeration']['weight']--;
		}
		if(!$this->Enumeration->save($enumeration)) {
			$this->Session->setFlash('There was an error updating Enumeration.');
		}
		$this->redirect($this->referer());
	}
	
	public function add($type = null) {
		if(!empty($this->request->data)) {
			$this->request->data['Enumeration']['type'] = strtoupper($this->request->data['Enumeration']['type']);
			if($this->Enumeration->save($this->request->data)) {
				$this->Session->setFlash('Enumeration saved!');
				$this->redirect(array('action' => 'index'));
			}
			else {
				$this->Session->setFlash('Unable to save Enumeration.');
			}
		}
		$enumerations = $this->Enumeration->find('all',array(
			'group' => 'Enumeration.type'
		));
		$enumerationTypes = array();
		foreach($enumerations as $enumeration) {
			$enumerationTypes[$enumeration['Enumeration']['type']] = $enumeration['Enumeration']['type'];
		}
		$this->set('enumerationTypes',$enumerationTypes);
	}
	
	public function edit($id=null) {
		if(!empty($this->request->data)) {
			$this->request->data['Enumeration']['type'] = strtoupper($this->request->data['Enumeration']['type']);
			if($this->Enumeration->save($this->request->data)) {
				$this->Session->setFlash('Enumeration saved!');
				$this->redirect('/admin/Enumerations');
			}
			else {
				$this->Session->setFlash('Unable to save Enumeration.');
			}
		}
		$this->request->data = $this->Enumeration->find('first',array(
			'conditions' => array(
				'Enumeration.id' => $id
			)
		));
		$enumerations = $this->Enumeration->find('all',array(
			'group' => 'Enumeration.type'
		));
		$enumerationTypes = array();
		foreach($enumerations as $enumeration) {
			$enumerationTypes[$enumeration['Enumeration']['type']] = $enumeration['Enumeration']['type'];
		}
		$this->set('enumerationTypes',$enumerationTypes);
	}
	
	public function delete($id=null) {
		if($this->Enumeration->delete($id)) {
			$this->Session->setFlash('Enumeration deleted');
		} else {
			$this->Session->setFlash('Could not delete Enumeration');
		}
		$this->redirect($this->referer());
	}
}
?>