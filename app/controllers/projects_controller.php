<?php
class ProjectsController extends AppController {

	var $name = 'Projects';
	var $helpers = array('Wikiparser');
	var $paginate = array('limit' => 10, 'order' => array('Project.created' => 'desc'));

	function index() {
		$model = $this->modelClass;
		$this->$model->recursive = 0;
		#Contact Person :: echo Inflector::humanize(Inflector::underscore($model));
		#ContactPerson :: echo Inflector::camelize($model);
		#contact_people :: echo Inflector::pluralize(Inflector::underscore($model));
		#contact_person :: echo Inflector::singularize(Inflector::underscore($model));
		#contactPeople :: echo Inflector::variable(Inflector::pluralize($model));
		$this->set('model', $model);
		$this->set('ctrl_vars', $this->paginate());
		$this->set('viewFields', array('name', 'created', 'actions'));
		# use the site wide admin index template
		$this->viewPath = 'pages';
		$this->render('admin_index');
		
	}

	function view($id = null) {
		if (!$id) {
			$this->flash(__('Invalid Project', true), array('action'=>'index'));
		}
		$this->set('project', $this->Project->read(null, $id));
	}

	function add() {
		if (!empty($this->data)) {
			$this->Project->create();
			if ($this->Project->save($this->data)) {
				$this->flash(__('Project saved.', true), array('action'=>'index'));
			} else {
			}
		}
		$projectParents = $this->Project->ProjectParent->find('list');
		$projectStatusTypes = $this->Project->ProjectStatusType->find('list');
		$creators = $this->Project->Creator->find('list');
		$contacts = $this->Project->Contact->find('list');
		$managers = $this->Project->Manager->find('list');
		$this->set(compact('projectParents', 'projectStatusTypes', 'creators', 'contacts', 'managers'));
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->flash(__('Invalid Project', true), array('action'=>'index'));
		}
		if (!empty($this->data)) {
			if ($this->Project->save($this->data)) {
				$this->flash(__('The Project has been saved.', true), array('action'=>'index'));
			} else {
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Project->read(null, $id);
		}
		$projectParents = $this->Project->ProjectParent->find('list');
		$projectStatusTypes = $this->Project->ProjectStatusType->find('list');
		$creators = $this->Project->Creator->find('list');
		$contacts = $this->Project->Contact->find('list');
		$managers = $this->Project->Manager->find('list');
		$this->set(compact('projectParents','projectStatusTypes','creators','contacts','managers'));
	}

	function delete($id = null) {
		if (!$id) {
			$this->flash(__('Invalid Project', true), array('action'=>'index'));
		}
		if ($this->Project->del($id)) {
			$this->flash(__('Project deleted', true), array('action'=>'index'));
		}
	}

	function admin_index() {
		//$this->Project->contain('Contact','Contact.ContactCompany');
		$this->paginate = array('contain' => array('Contact.ContactPerson', 'Contact.ContactCompany'));
		$this->set('projects', $this->paginate());
	}


	function admin_view($id = null) {
		if (!$id) {
			$this->flash(__('Invalid Project', true), array('action'=>'index'));
		}
		$this->Project->contain('ProjectIssue','Member','Watcher','Watcher.ContactPerson','Watcher.ContactCompany','ProjectStatusType','ProjectsWiki','Contact.ContactPerson','Contact.ContactCompany', 'TimesheetTime.Timesheet', 'TimesheetTime.ProjectIssue', 'Wiki.WikiStartPage.WikiContent');		
		$this->set('project', $this->Project->read(null, $id));
		// ajax select boxes
		$models = array('ProjectStatusType' => array(), 'ProjectIssue' => array('conditions' =>  array('parent_id' => NULL)));
		$this->__ajax_list('Project', $models);
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
			$this->Project->create();
			if ($this->Project->save($this->data)) {
				$this->flash(__('Project saved.', true), array('action'=>'index'));
			} else {
			}
		}
		$projectParents = $this->Project->ProjectParent->find('list');
		$projectStatusTypes = $this->Project->ProjectStatusType->find('list');
		$creators = $this->Project->Creator->find('list');
		$contacts = $this->Project->Contact->find('list');
		$managers = $this->Project->Manager->find('list');
		$this->set(compact('projectParents', 'projectStatusTypes', 'creators', 'contacts', 'managers'));
	}
	 
	 
	function admin_edit($id = null) {
		if (!empty($this->data)) {
			if ($this->Project->save($this->data)) {
				$this->flash(__('The Project has been saved.', true), array('action'=>'index'));
			} else {
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Project->read(null, $id);
		}
		$projectParents = $this->Project->ProjectParent->find('list');
		$projectStatusTypes = $this->Project->ProjectStatusType->find('list');
		$creators = $this->Project->Creator->find('list');
		
		$combines = $this->Project->Contact->query("SELECT concat(Contact.first_name, ' ', Contact.last_name) AS name, Contact.contact_id FROM contact_people AS Contact UNION SELECT Contact.name AS name, Contact.contact_id FROM contact_companies AS Contact ORDER BY contact_id");		
		$contacts = array();
		
		foreach ($combines as $combine) :
			$contacts += array($combine[0]['contact_id'] => $combine[0]['name']); 
		endforeach;	
		
		$managers = $this->Project->Manager->find('list');
		$this->set('fields', array('project_status_type_id', 'name', 'description', 'contact_id', 'manager_id'));
		$this->set(compact('projectParents','projectStatusTypes','creators','contacts','managers'));	
		
		$model = $this->modelClass;
		$this->set('model', $model);
		$controller = $this->name;
		$this->set('controller', $controller);
		
		# use the site wide admin index template
		$this->viewPath = 'pages';
		$this->render('ajax_edit');		
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
		$projectParents = $this->Project->ProjectParent->find('list');
		$projectStatusTypes = $this->Project->ProjectStatusType->find('list');
		$creators = $this->Project->Creator->find('list');
		$contacts = $this->Project->Contact->find('list');
		$managers = $this->Project->Manager->find('list');
		$this->set('fields', array('project_status_type_id', 'name', 'description', 'contact_id', 'manager_id'));
		$this->set(compact('projectParents','projectStatusTypes','creators','contacts','managers'));	
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