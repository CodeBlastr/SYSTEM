<?php
class ProjectIssuesController extends AppController {

	var $name = 'ProjectIssues';

	function index() {
		$this->ProjectIssue->recursive = 0;
		$this->set('projectIssues', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid ProjectIssue.', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->set('projectIssue', $this->ProjectIssue->read(null, $id));
	}

	function add() {
		if (!empty($this->data)) {
			$this->ProjectIssue->create();
			if ($this->ProjectIssue->save($this->data)) {
				$this->Session->setFlash(__('The ProjectIssue has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The ProjectIssue could not be saved. Please, try again.', true));
			}
		}
		//$projectIssueParents = $this->ProjectIssue->ProjectIssueParent->find('list');
		$projectStatusIssueTypes = $this->ProjectIssue->ProjectIssueStatusType->find('list');
		$creators = $this->ProjectIssue->Creator->find('list');
		//$modifiers = $this->ProjectIssue->Modifier->find('list');
		//$contacts = $this->ProjectIssue->Project->find('list');
		//$this->set(compact('projectIssueParents', 'projectIssueTypes', 'creators', 'modifiers', 'contacts'));
		$this->set(compact('projectIssueTypes', 'contacts'));
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid ProjectIssue', true));
			$this->redirect(array('action'=>'index'));
		}
		if (!empty($this->data)) {
			if ($this->ProjectIssue->save($this->data)) {
				$this->Session->setFlash(__('The ProjectIssue has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The ProjectIssue could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->ProjectIssue->read(null, $id);
		}
		$projectIssueParents = $this->ProjectIssue->ProjectIssueParent->find('list');
		$projectIssueTypes = $this->ProjectIssue->ProjectIssueStatusType->find('list');
		$this->set(compact('projectIssueParents','projectIssueTypes','creators','contacts'));
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for ProjectIssue', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->ProjectIssue->del($id)) {
			$this->Session->setFlash(__('ProjectIssue deleted', true));
			$this->redirect(array('action'=>'index'));
		}
	}




	function admin_index() {
		$model = $this->modelClass;
		$this->$model->recursive = 0;
		$this->set('model', $model);
		$this->paginate = array('conditions' => array($model.'.parent_id' => null)); 
		$this->set('ctrl_vars', $this->paginate());
		$this->set('viewFields', array('name', 'done_ratio', 'start_date', 'due_date', 'project_id', 'contact_id', 'assignee_id', 'actions'));
		
	}


	function admin_view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid ProjectIssue.', true));
			$this->flash(__('Invalid ProjectIssue', true), array('action'=>'index'));
		}
		$this->ProjectIssue->contain('Project.Member', 'ProjectTrackerType', 'ProjectIssueStatusType', 'ProjectIssuePriorityType');
		$projectIssue = $this->ProjectIssue->read(null, $id);
		$this->set('projectIssue', $projectIssue);
		$assignees = Set::combine($projectIssue, 'Project.Member.{n}.id', 'Project.Member.{n}.username');
		$this->set(compact('assignees'));
  		#$aIssue = $this->ProjectIssue->find('first', array('conditions' => array('parent_id' => $id))); 
  		$someIssues = $this->ProjectIssue->find('threaded', array('conditions' => array('ProjectIssue.lft >=' => $projectIssue['ProjectIssue']['lft'], 'ProjectIssue.rght <=' => $projectIssue['ProjectIssue']['rght']), 'order' => 'created ASC'));
		$this->set('projectTree', $someIssues);
		$models = array('ProjectTrackerType' => array(), 'ProjectIssuePriorityType' => array(), 'ProjectIssueStatusType' => array());
		$this->__ajax_list('ProjectIssue', $models);
	}


	function admin_add() {
		if (!empty($this->data)) {
			$this->ProjectIssue->create();
			if ($this->ProjectIssue->save($this->data)) {
				# send notification to
				$this->__send_mail(array('user' => array($this->data['ProjectIssue']['assignee_id'])));
				$this->Session->setFlash(__('The ProjectIssue has been saved', true));
				$this->redirect(Controller::referer());
			} else {
				$this->Session->setFlash(__('The ProjectIssue could not be saved. Please, try again.', true));
			}
		}
		$projectIssueParents = $this->ProjectIssue->ProjectIssueParent->find('list');
		$projectIssueTypes = $this->ProjectIssue->ProjectIssueStatusType->find('list');
		$creators = $this->ProjectIssue->Creator->find('list');
		$contacts = $this->ProjectIssue->Project->find('list');
		$this->set(compact('projectIssueParents', 'projectIssueTypes', 'creators', 'contacts'));
	}

	function admin_edit($id = null) {
		if (!empty($this->data)) {
			if ($this->ProjectIssue->save($this->data)) {
				$this->Session->setFlash(__('The ProjectIssue has been saved', true));
				$this->redirect(array('action'=>'view'));
			} else {
				$this->Session->setFlash(__('The ProjectIssue could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->ProjectIssue->read(null, $id);
		}
		$projectIssueParents = $this->ProjectIssue->ProjectIssueParent->find('list');
		$projectIssueTypes = $this->ProjectIssue->ProjectIssueStatusType->find('list');
		$creators = $this->ProjectIssue->Creator->find('list');
		$contacts = $this->ProjectIssue->Project->find('list');
		$this->set(compact('projectIssueParents','projectIssueTypes','creators','contacts'));
	}

	
	function admin_ajax_edit($id = null) {
		$model = $this->modelClass;
		$controller = $this->name;
		if (!empty($this->data)) {			
			if ($this->$model->save($this->data)) {
				# send notification to
				$userid = array('user' => array($this->data['ProjectIssue']['assignee_id']));
				$this->__send_mail($userid);
				$this->Session->setFlash(__($model.' saved', true));
				echo 'ajax_edit'.$userid;
				die;
			} else {
				$this->Session->setFlash(__('Could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->$model->read(null, $id);
		}
		## define the fields for the form and put them in the order you want them displayed;
		## Edit these per controller
		## $projectIssueParents = $this->ProjectIssue->ProjectIssueParent->find('list');
		$projects = $this->ProjectIssue->Project->find('list');
		$this->set(compact('projects'));
		$projectTrackerTypes = $this->ProjectIssue->ProjectTrackerType->find('list');
		$this->set(compact('projectTrackerTypes'));
		$projectIssueStatusTypes = $this->ProjectIssue->ProjectIssueStatusType->find('list');
		$this->set(compact('projectIssueStatusTypes'));
		$projectIssuePriorityTypes = $this->ProjectIssue->ProjectIssuePriorityType->find('list');
		$this->set(compact('projectIssuePriorityTypes'));
		$assignees = $this->ProjectIssue->Assignee->find('list');
		$this->set(compact('assignees'));
		$this->set('fields', array('project_tracker_type_id', 'project_issue_status_type_id', 'project_issue_priority_type_id', 'name', 'description', 'start_date', 'due_date', 'estimated_hours', 'contact_id', 'assignee_id', 'project_id', 'parent_id'));
		## End edit per controller
		$this->set('model', $model);
		$this->set('controller', $controller);
		$this->viewPath = 'pages';
		$this->render('ajax_edit');
	}
	
	 function admin_ajax_update($id,$sub,$model){ 
		$model = Inflector::camelize($model);
		App::import('Model', $model);
		$this->$model = new $model();
		//Update the value in the database
        $value = $this->params['form']['value'];
        $this->$model->id = $id; 
        if (!$this->$model->saveField($sub, $value,true)) { 
             $this->set('error', true); 
			 echo $error;
        } 
        $contact = $this->$model->read(array($sub), $id); 
		// Get the display value for the field if the field is a foreign key
        // See if field to be updated is a foreign key and set the display value
        if (substr($sub,-3) == '_id'){
            // Chop off the "_id"
            $new_sub = substr($sub,0,strlen($sub)-3); 
            // Camelize the result to get the Model name
            $model_name = Inflector::camelize($new_sub);
			App::import('Model', $model_name);
			$this->$model_name = new $model_name();
            // See if the model has a display name other than default "name"; 
		if (!empty($this->$model_name->displayField)){
                $display_field = $this->$model_name->displayField; 
            }else {
                $display_field = 'name';
            }
                        // Get the display value for the id
            $value = $this->$model_name->field($display_field,array('id' => $value));
        }

		// Set the view variable and render the view.
        $this->set('value',$value); 
		$this->viewPath = 'pages';
		$this->render('ajax_update');
    } 
		
	 function __ajax_list($base, $models){ 
	 	foreach ($models as $modelkey => $model):
			if (isset($model['upper'])):
				$types[$modelkey] = $this->$base->$model['upper']->$model['up']->$modelkey->find('list');
			elseif (isset($model['up'])): 
				$types[$modelkey] = $this->$base->$model['up']->$modelkey->find('list');
			else: 
				$types[$modelkey] = $this->$base->$modelkey->find('list');			
			endif;
	        foreach ($types[$modelkey] as $typekey => $value): 
	            $type[$modelkey][] = array($typekey,$value);
	        endforeach;
		endforeach;
	    $this->set('ajaxTypeList', $type); 
	 }

	function admin_delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for ProjectIssue', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->ProjectIssue->del($id)) {
			$this->Session->setFlash(__('ProjectIssue deleted', true));
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