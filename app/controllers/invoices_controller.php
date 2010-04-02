<?php
class InvoicesController extends AppController {

	var $name = 'Invoices';
	var $paginate = array('limit' => 10, 'order' => array('Invoice.created' => 'desc'));

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
			$this->flash(__('Invalid Invoice', true), array('action'=>'index'));
		}
		$this->set('invoice', $this->Invoice->read(null, $id));
	}

	function add() {
		if (!empty($this->data)) {
			$this->Invoice->create();
			if ($this->Invoice->save($this->data)) {
				$this->flash(__('Invoice saved.', true), array('action'=>'index'));
			} else {
			}
		}
		$projectParents = $this->Invoice->InvoiceParent->find('list');
		$projectStatusTypes = $this->Invoice->InvoiceStatusType->find('list');
		$creators = $this->Invoice->Creator->find('list');
		$contacts = $this->Invoice->Contact->find('list');
		$managers = $this->Invoice->Manager->find('list');
		$this->set(compact('projectParents', 'projectStatusTypes', 'creators', 'contacts', 'managers'));
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->flash(__('Invalid Invoice', true), array('action'=>'index'));
		}
		if (!empty($this->data)) {
			if ($this->Invoice->save($this->data)) {
				$this->flash(__('The Invoice has been saved.', true), array('action'=>'index'));
			} else {
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Invoice->read(null, $id);
		}
		$projectParents = $this->Invoice->InvoiceParent->find('list');
		$projectStatusTypes = $this->Invoice->InvoiceStatusType->find('list');
		$creators = $this->Invoice->Creator->find('list');
		$contacts = $this->Invoice->Contact->find('list');
		$managers = $this->Invoice->Manager->find('list');
		$this->set(compact('projectParents','projectStatusTypes','creators','contacts','managers'));
	}

	function delete($id = null) {
		if (!$id) {
			$this->flash(__('Invalid Invoice', true), array('action'=>'index'));
		}
		if ($this->Invoice->del($id)) {
			$this->flash(__('Invoice deleted', true), array('action'=>'index'));
		}
	}

	function admin_index() {
		$model = $this->modelClass;
		$this->$model->recursive = 0;
		$this->set('model', $model);
		$this->set('ctrl_vars', $this->paginate());
		$this->set('viewFields', array('name', 'created', 'actions'));
		# use the site wide admin index template
		$this->viewPath = 'pages';
		$this->render('admin_index');
		
	}


	function admin_view($id = null) {
		if (!$id) {
			$this->flash(__('Invalid Invoice', true), array('action'=>'index'));
		}
		#this puts all contacts into one drop down, who are already project members
		$this->Invoice->contain('Contact.ContactPerson', 'Contact.ContactCompany', 'InvoiceCatalogItem.CatalogItem',  'InvoiceTimesheetTime.TimesheetTime.ProjectIssue.Project', 'InvoiceTimesheetTime.TimesheetTime.TimesheetRate');
		$this->set('invoice', $this->Invoice->read(null, $id));
		// ajax select boxes
		$models = array('Contact' => array());
		$this->__ajax_list('Invoice', $models);
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
			$this->Invoice->create();
			if ($this->Invoice->save($this->data)) {
				$this->flash(__('Invoice saved.', true), array('action'=>'index'));
			} else {
			}
		}
	}
	 
	 
	function admin_edit($id = null) {
		if (!empty($this->data)) {
			if ($this->Invoice->save($this->data)) {
				$this->flash(__('The Invoice has been saved.', true), array('action'=>'index'));
			} else {
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Invoice->read(null, $id);
		}
		$contacts = $this->Invoice->Contact->find('list');
		$this->set('fields', array('name', 'introduction', 'conclusion', 'sendto', 'due_date', 'contact_id'));	
		$this->set(compact('contacts'));	
		
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
		$contacts = $this->Invoice->Contact->find('list');
		$this->set('fields', array('name', 'introduction', 'conclusion', 'sendto', 'due_date', 'contact_id'));	
		$this->set(compact('contacts'));
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