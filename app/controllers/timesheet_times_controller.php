<?php
class TimesheetTimesController extends AppController {

	var $name = 'TimesheetTimes';
	var $helpers = array('Html', 'Form');

	function index() {
		$this->TimesheetTime->recursive = 0;
		$this->set('timesheetTimes', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid TimesheetTime.', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->set('timesheetTime', $this->TimesheetTime->read(null, $id));
	}

	function add() {
		if (!empty($this->data)) {
			$this->TimesheetTime->create();
			if ($this->TimesheetTime->save($this->data)) {
				$this->Session->setFlash(__('The TimesheetTime has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The TimesheetTime could not be saved. Please, try again.', true));
			}
		}
		$users = $this->TimesheetTime->User->find('list');
		$timesheets = $this->TimesheetTime->Timesheet->find('list');
		$timesheetRates = $this->TimesheetTime->TimesheetRate->find('list');
		$projects = $this->TimesheetTime->Project->find('list');
		$projectIssues = $this->TimesheetTime->ProjectIssue->find('list');
		$this->set(compact('users', 'timesheets', 'timesheetRates', 'projects', 'projectIssues'));
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid TimesheetTime', true));
			$this->redirect(array('action'=>'index'));
		}
		if (!empty($this->data)) {
			if ($this->TimesheetTime->save($this->data)) {
				$this->Session->setFlash(__('The TimesheetTime has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The TimesheetTime could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->TimesheetTime->read(null, $id);
		}
		$users = $this->TimesheetTime->User->find('list');
		$timesheets = $this->TimesheetTime->Timesheet->find('list');
		$timesheetRates = $this->TimesheetTime->TimesheetRate->find('list');
		$projects = $this->TimesheetTime->Project->find('list');
		$projectIssues = $this->TimesheetTime->ProjectIssue->find('list');
		$this->set(compact('users','timesheets','timesheetRates','projects','projectIssues'));
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for TimesheetTime', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->TimesheetTime->del($id)) {
			$this->Session->setFlash(__('TimesheetTime deleted', true));
			$this->redirect(array('action'=>'index'));
		}
	}


	function admin_index() {
		$this->TimesheetTime->recursive = 0;
		$this->set('timesheetTimes', $this->paginate());
	}

	function admin_view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid TimesheetTime.', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->set('timesheetTime', $this->TimesheetTime->read(null, $id));
	}

	function admin_add() {
		if (!empty($this->data)) {
			$this->TimesheetTime->create();
			if ($this->TimesheetTime->save($this->data)) {
				$this->Session->setFlash(__('The TimesheetTime has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The TimesheetTime could not be saved. Please, try again.', true));
			}
		}
		$users = $this->TimesheetTime->User->find('list');
		$timesheets = $this->TimesheetTime->Timesheet->find('list');
		$timesheetRates = $this->TimesheetTime->TimesheetRate->find('list');
		$projects = $this->TimesheetTime->Project->find('list');
		$projectIssues = $this->TimesheetTime->ProjectIssue->find('list');
		$this->set(compact('users', 'timesheets', 'timesheetRates', 'projects', 'projectIssues'));
	}

	function admin_edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid TimesheetTime', true));
			$this->redirect(array('action'=>'index'));
		}
		if (!empty($this->data)) {
			if ($this->TimesheetTime->save($this->data)) {
				$this->Session->setFlash(__('The TimesheetTime has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The TimesheetTime could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->TimesheetTime->read(null, $id);
		}
		$users = $this->TimesheetTime->User->find('list');
		$timesheets = $this->TimesheetTime->Timesheet->find('list');
		$timesheetRates = $this->TimesheetTime->TimesheetRate->find('list');
		$projects = $this->TimesheetTime->Project->find('list');
		$projectIssues = $this->TimesheetTime->ProjectIssue->find('list');
		$this->set(compact('users','timesheets','timesheetRates','projects','projectIssues'));
	}

	function admin_ajax_edit($id = null) {
		$model = $this->modelClass;
		$controller = $this->name;
		if (!empty($this->data)) {
			if ($this->$model->save($this->data)) {
				$this->Session->setFlash(__($model.' saved', true));
			} else {
				$this->Session->setFlash(__('Could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->$model->read(null, $id);
		}
		## define the fields for the form and put them in the order you want them displayed;
		## Edit these per controller
		## $contactActivityParents = $this->ContactActivity->ContactActivityParent->find('list');
		$timesheets = $this->TimesheetTime->Timesheet->find('list');
		$this->set(compact('timesheets'));
		App::import('Model', 'Project', 'ProjectIssue');
		$Project = new Project;
		$ProjectIssue = new ProjectIssue;
		$projects = $this->TimesheetTime->Project->find('list');
		if (isset($this->params['named']['project_id'])) :
			$projectIssues = $this->TimesheetTime->ProjectIssue->find('list', array('conditions' => array('ProjectIssue.project_id' => $this->params['named']['project_id'], 'ProjectIssue.parent_id' => NULL)));
		else :
			$projectIssues = $this->TimesheetTime->ProjectIssue->find('list', array('conditions' => array('ProjectIssue.parent_id' => NULL)));
		endif;
		$this->set(compact('projects', 'projectIssues'));
		$this->set('fields', array('project_id', 'project_issue_id', 'comments', 'hours', 'started_on'));
		## End edit per controller
		$this->set('model', $model);
		$this->set('controller', $controller);
		$this->viewPath = 'pages';
		$this->render('ajax_edit');
	}

	function admin_delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for TimesheetTime', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->TimesheetTime->del($id)) {
			$this->Session->setFlash(__('TimesheetTime deleted', true));
			$this->redirect(array('action'=>'index'));
		}
	}

	function admin_ajax_delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id', true));
			$this->redirect(array('action'=>'index'));
		}
		$model = $this->modelClass;
		if ($this->$model->del($id)) {
			$this->redirect('/ajax_delete');
	        $this->layout = 'ajax';
		}
	}

}
?>