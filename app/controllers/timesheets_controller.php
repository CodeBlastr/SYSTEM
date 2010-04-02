<?php
class TimesheetsController extends AppController {

	var $name = 'Timesheets';
	var $helpers = array('Html', 'Form');

	function index() {
		$this->Timesheet->recursive = 0;
		$this->set('timesheets', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid Timesheetsss.', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->set('timesheet', $this->Timesheet->read(null, $id));
	}

	function add() {
		if (!empty($this->data)) {
			$this->Timesheet->create();
			if ($this->Timesheet->save($this->data)) {
				$this->Session->setFlash(__('The Timesheet has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The Timesheet could not be saved. Please, try again.', true));
			}
		}
		$creators = $this->Timesheet->Creator->find('list');
		$modifiers = $this->Timesheet->Modifier->find('list');
		$this->set(compact('creators', 'modifiers'));
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid Timesheet', true));
			$this->redirect(array('action'=>'index'));
		}
		if (!empty($this->data)) {
			if ($this->Timesheet->save($this->data)) {
				$this->Session->setFlash(__('The Timesheet has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The Timesheet could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Timesheet->read(null, $id);
		}
		$creators = $this->Timesheet->Creator->find('list');
		$modifiers = $this->Timesheet->Modifier->find('list');
		$this->set(compact('creators','modifiers'));
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for Timesheet', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Timesheet->del($id)) {
			$this->Session->setFlash(__('Timesheet deleted', true));
			$this->redirect(array('action'=>'index'));
		}
	}


	function admin_index() {
		$model = $this->modelClass;
		$this->$model->recursive = 0;
		$this->set('model', $model);
		$this->set('ctrl_vars', $this->paginate());
		$this->set('viewFields', array('name', 'created', 'actions'));
	}

	function admin_view($id = null) {
		if (!$id) {
			$this->flash(__('Invalid Timesheet', true), array('action'=>'index'));
		}
		$this->Timesheet->contain('TimesheetTime.Project', 'TimesheetTime.ProjectIssue');
		$this->set('timesheet', $this->Timesheet->read(null, $id));
		/* ajax select boxes
		$models = array('');
		$this->__ajax_list('Timesheet', $models);*/
	}
	
	 function __ajax_list($base, $models){ 
	 	foreach ($models as $modelkey => $model):
			if (isset($model['upper'])):
				if (isset($model['conditions'])) : 
					$types[$modelkey] = $this->$base->$model['upper']->$model['up']->$modelkey->find('list', array('conditions' => $model['conditions']));
				else :
					$types[$modelkey] = $this->$base->$model['upper']->$model['up']->$modelkey->find('list');
				endif;
			elseif (isset($model['up'])): 
				if (isset($model['conditions'])) : 
					$types[$modelkey] = $this->$base->$model['up']->$modelkey->find('list', array('conditions' => $model['conditions']));
				else :
					$types[$modelkey] = $this->$base->$model['up']->$modelkey->find('list');
				endif;
			else: 
				if (isset($model['conditions'])) : 
					$types[$modelkey] = $this->$base->$modelkey->find('list', array('conditions' => $model['conditions']));	
				else :
					$types[$modelkey] = $this->$base->$modelkey->find('list');
				endif;
			endif;
	        foreach ($types[$modelkey] as $typekey => $value): 
	            $type[$modelkey][] = array($typekey,$value);
	        endforeach;
		endforeach;
	    $this->set('ajaxTypeList', $type); 
	 }

	function admin_add() {
		if (!empty($this->data)) {
			$this->Timesheet->create();
			if ($this->Timesheet->save($this->data)) {
				$this->Session->setFlash(__('The Timesheet has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The Timesheet could not be saved. Please, try again.', true));
			}
		}
		$projects = $this->Timesheet->TimesheetTime->Project->find('list');
		$timesheetTimes = $this->Timesheet->TimesheetTime->find('list');
		$creators = $this->Timesheet->TimesheetTime->Creator->find('list');
		$contacts = $this->Timesheet->TimesheetTime->Project->Contact->query("SELECT concat(Contact.first_name, ' ', Contact.last_name) AS name, Contact.contact_id FROM contact_people AS Contact WHERE Contact.contact_id IN (SELECT contact_id FROM projects) UNION SELECT Contact.name AS name, Contact.contact_id FROM contact_companies AS Contact WHERE Contact.contact_id IN (SELECT contact_id FROM projects) ORDER BY contact_id");
		$contacts = Set::combine($contacts,'{n}.0.contact_id',array('{0}','{n}.0.name')); 
		$this->set(compact('timesheetTimes', 'projects', 'contacts','creators'));
	}

	function admin_edit($id = null) {
		if (isset($this->data['save'])) {
			if ($this->Timesheet->save($this->data)) {
				$this->Session->setFlash(__('The Timesheet has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The Timesheet could not be saved. Please, try again.', true));
			}
		}
		/* search timesheet_times using the url conditions, we put up two if statements to handle multiple values, in the case that you want to find times for multiple projects, contacts, creators, and project_issues, alot of error checking could be added here ::: for instance, three dates, or first date after second date, etc. */
		if (isset($this->data['Timesheet'])) :
			foreach ($this->data['Timesheet'] as $key => $value) : 
				if($key == 'contact_id' && !empty($value)) :
					$conditions[] = array('TimesheetTime.project_id' => $this->Timesheet->TimesheetTime->Project->find('list', array('fields' => 'id', 'conditions' => array('contact_id' => $value))));
				# if two started_on dates are given, then find that occur between 
				elseif ($key == 'started_on' && !empty($value)) : 
					$conditions[] = array('TimesheetTime.started_on >' => $value);
				elseif ($key == 'ended_on' && !empty($value)) : 
					$conditions[] = array('TimesheetTime.started_on <' => $value);
				elseif (!empty($value)) : 
					$conditions[] = array('TimesheetTime.'.$key => $value);
				endif;
			endforeach;
			$timesheetTimes = $this->Timesheet->TimesheetTime->find('all', array('conditions' => $conditions, 'contain' => array('Project', 'Creator')));
			$timesheetTimes = Set::combine(
		        $timesheetTimes,
	            '{n}.TimesheetTime.id',
        	       array(
        	         '{0}hr(s) ----- {2} -----  {3} -----  {1}',
	                 '{n}.TimesheetTime.hours',
					 '{n}.Project.name',
	                 '{n}.TimesheetTime.started_on',
					 '{n}.Creator.username'
	               )
    	    ); 
			$this->set(compact('timesheetTimes'));
		endif;
	}

	function admin_delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for Timesheet', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Timesheet->del($id)) {
			$this->Session->setFlash(__('Timesheet deleted', true));
			$this->redirect(array('action'=>'index'));
		}
	}

}
?>