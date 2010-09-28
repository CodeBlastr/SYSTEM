<?php
class EnumerationEssentialsController extends AppController {
	function admin_search() {
		if(!empty($this->data)) {
			$this->data['EnumerationEssential']['query'] = str_replace('*','%',$this->data['EnumerationEssential']['query']);
			$this->data = $this->paginate('EnumerationEssential',array(
				'EnumerationEssential.type LIKE' => $this->data['EnumerationEssential']['query']
			));
			
		}
		$this->set('schema',$this->EnumerationEssential->_schema);
		$this->render('admin_index');
	}
	
	function admin_index() {
		$this->paginate = array(
			'order' => array(
				'EnumerationEssential.type' => 'ASC',
				'EnumerationEssential.weight' => 'DESC',
				'EnumerationEssential.name' => 'ASC',
			)
		);
		$conditions = array();
		if(isset($this->params['named']['filter'])) {
			$conditions['EnumerationEssential.type LIKE'] = $this->params['named']['filter'] . '%';
		}
		$this->data = $this->paginate('EnumerationEssential',$conditions);
	}
	
	function admin_changeOrder($id=null,$mode='increase') {
		$enumerationEssential = $this->EnumerationEssential->find('first',array(
			'conditions' => array(
				'EnumerationEssential.id' => $id
			)
		));
		if($mode == 'increase') {
			$enumerationEssential['EnumerationEssential']['weight']++;
		}
		else {
			$enumerationEssential['EnumerationEssential']['weight']--;
		}
		if(!$this->EnumerationEssential->save($enumerationEssential)) {
			$this->Session->setFlash('There was an error updating EnumerationEssential.');
		}
		$this->redirect($this->referer());
	}
	
	function index() {
		$conditions = array();
		if(isset($this->params['named']['type'])) {
			$conditions['EnumerationEssential.type'] = strtoupper($this->params['named']['type']);
		}
		$enumerationEssentials = $this->EnumerationEssential->find('all',array(
			'conditions' => $conditions
		));
		$this->set('enumerations',$enumerationEssentials);
	}
	
	function admin_add() {
		if(!empty($this->data)) {
			$this->data['EnumerationEssential']['type'] = strtoupper($this->data['EnumerationEssential']['type']);
			if($this->EnumerationEssential->save($this->data)) {
				$this->Session->setFlash('EnumerationEssential saved!');
				$this->redirect('/admin/EnumerationEssentials');
			}
			else {
				$this->Session->setFlash('Unable to save EnumerationEssential.');
			}
		}
		$enumerationEssentials = $this->EnumerationEssential->find('all',array(
			'group' => 'EnumerationEssential.type'
		));
		$enumerationEssentialTypes = array();
		foreach($enumerationEssentials as $enumerationEssential) {
			$enumerationEssentialTypes[$enumerationEssential['EnumerationEssential']['type']] = $enumerationEssential['EnumerationEssential']['type'];
		}
		$this->set(compact('enumerationEssentialTypes'));
	}
	
	function admin_edit($id=null) {
		if(!empty($this->data)) {
			$this->data['EnumerationEssential']['type'] = strtoupper($this->data['EnumerationEssential']['type']);
			if($this->EnumerationEssential->save($this->data)) {
				$this->Session->setFlash('EnumerationEssential saved!');
				$this->redirect('/admin/EnumerationEssentials');
			}
			else {
				$this->Session->setFlash('Unable to save EnumerationEssential.');
			}
		}
		$this->data = $this->EnumerationEssential->find('first',array(
			'conditions' => array(
				'EnumerationEssential.id' => $id
			)
		));
		$enumerationEssentials = $this->EnumerationEssential->find('all',array(
			'group' => 'EnumerationEssential.type'
		));
		$enumerationEssentialTypes = array();
		foreach($enumerationEssentials as $enumerationEssential) {
			$enumerationEssentialTypes[$enumerationEssential['EnumerationEssential']['type']] = $enumerationEssential['EnumerationEssential']['type'];
		}
		$this->set(compact('enumerationEssentialTypes'));
		$this->render('admin_add');
	}
	
	function admin_delete($id=null) {
		if($this->EnumerationEssential->delete($id)) {
			$this->Session->setFlash('EnumerationEssential deleted');
		} else {
			$this->Session->setFlash('Could not delete EnumerationEssential');
		}
		$this->redirect($this->referer());
	}
}
?>