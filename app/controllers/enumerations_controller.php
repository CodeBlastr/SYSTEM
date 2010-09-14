<?php
class EnumerationsController extends AppController {
	function admin_search() {
		if(!empty($this->data)) {
			$this->data['Enumeration']['query'] = str_replace('*','%',$this->data['Enumeration']['query']);
			$this->data = $this->paginate('Enumeration',array(
				'Enumeration.type LIKE' => $this->data['Enumeration']['query']
			));
			
		}
		$this->set('schema',$this->Enumeration->_schema);
		$this->render('admin_index');
	}
	
	function admin_index() {
		$this->paginate = array(
			'order' => array(
				'Enumeration.type' => 'ASC',
				'Enumeration.weight' => 'DESC',
				'Enumeration.name' => 'ASC',
			)
		);
		$conditions = array();
		if(isset($this->params['named']['filter'])) {
			$conditions['Enumeration.type LIKE'] = $this->params['named']['filter'] . '%';
		}
		$this->data = $this->paginate('Enumeration',$conditions);
	}
	
	function admin_changeOrder($id=null,$mode='increase') {
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
	
	function index() {
		$conditions = array();
		if(isset($this->params['named']['type'])) {
			$conditions['Enumeration.type'] = strtoupper($this->params['named']['type']);
		}
		$enumerations = $this->Enumeration->find('all',array(
			'conditions' => $conditions
		));
		$this->set('enumerations',$enumerations);
	}
	
	function admin_add() {
		if(!empty($this->data)) {
			$this->data['Enumeration']['type'] = strtoupper($this->data['Enumeration']['type']);
			if($this->Enumeration->save($this->data)) {
				$this->Session->setFlash('Enumeration saved!');
				$this->redirect('/admin/Enumerations');
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
	
	function admin_edit($id=null) {
		if(!empty($this->data)) {
			$this->data['Enumeration']['type'] = strtoupper($this->data['Enumeration']['type']);
			if($this->Enumeration->save($this->data)) {
				$this->Session->setFlash('Enumeration saved!');
				$this->redirect('/admin/Enumerations');
			}
			else {
				$this->Session->setFlash('Unable to save Enumeration.');
			}
		}
		$this->data = $this->Enumeration->find('first',array(
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
		$this->render('admin_add');
	}
	
	function admin_delete($id=null) {
		if($this->Enumeration->delete($id)) {
			$this->Session->setFlash('Enumeration deleted');
		} else {
			$this->Session->setFlash('Could not delete Enumeration');
		}
		$this->redirect($this->referer());
	}
}
?>