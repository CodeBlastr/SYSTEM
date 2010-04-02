<?php
class ContactCompaniesController extends AppController {

	var $name = 'ContactCompanies';
	var $paginate = array('limit' => 10, 'order' => array('ContactCompany.created' => 'desc'));

	function admin_index() {
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

	function admin_view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid ContactCompany.', true));
			$this->redirect(array('action'=>'index'));
		}
		
		// TO DO Add ,'Contact.ContactMedium.Medium', but only after you are storing file names instead of the actual files into the media table, then it will out put the file name instead.
		$this->ContactCompany->contain('Contact', 'Contact.ContactType','Contact.ContactSource','Contact.ContactIndustry','Contact.ContactRating','Contact.ContactDetail','Contact.ContactDetail.ContactDetailType','Contact.ContactAddress','Contact.ContactAddress.ContactAddressType','Contact.ContactAddress.State','Contact.ContactAddress.Country','Contact.ContactActivity','Contact.ContactActivity.ContactActivityType','Contact.Tag','Contact.ContactTask','Contact.ContactTask.ContactTaskType','Contact.Order','Contact.Project.ProjectIssue','Contact.Quote','Contact.Ticket', 'Contact.RelatedContact.ContactRelationshipType', 'Contact.RelatedContact.Relator.ContactCompany', 'Contact.RelatedContact.Relator.ContactPerson', 'Contact.Watcher.Project');
		$this->set('contactCompany', $this->ContactCompany->find('first', array('conditions' => array('ContactCompany.id' => $id))));
		
		// ajax select boxes
		$models = array('ContactType' => array('up' => 'Contact'), 'ContactSource' => array('up' => 'Contact'), 'ContactIndustry' => array('up' => 'Contact'), 'ContactRating' => array('up' => 'Contact'), 'ContactRelationshipType' => array('upper' => 'Contact', 'up' => 'RelatedContact'), 'State' => array('up' => 'ContactAddress', 'upper' => 'Contact'), 'Country' => array('up' => 'ContactAddress', 'upper' => 'Contact'));
		$this->__ajax_list('ContactCompany', $models);
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
			$this->loadModel('Contact');
			if ($this->Contact->save($this->data)) {
				$insert_id = $this->Contact->id;
				$this->data['ContactCompany']['contact_id'] = $insert_id;
				if ($this->ContactCompany->save($this->data)) {
					$insert_id = $this->ContactCompany->id;
					$this->Session->setFlash(__('Saved', true));
					$this->redirect(array('action'=>'view', $insert_id));
				}
			} else {
				$this->Session->setFlash(__('Could not be saved. Please, try again.', true));
			}
		}
		$contacts = $this->ContactCompany->Contact->find('list');
		$this->set(compact('contacts'));
	}

	function admin_edit($id = null) {
		if (!empty($this->data)) {
			if ($this->ContactCompany->saveAll($this->data)) {
				$this->Session->setFlash(__('Saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('Could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->ContactCompany->read(null, $id);
			$contacts = $this->ContactCompany->Contact->find('list');
			$this->set(compact('contacts'));
			// load the contact fields properly
			$this->loadModel('Contact');
			$contactTypes = $this->Contact->ContactType->find('list');
			$this->set(compact('contactTypes'));
			$contactSources = $this->Contact->ContactSource->find('list');
			$this->set(compact('contactSources'));
			$contactIndustries = $this->Contact->ContactIndustry->find('list');
			$this->set(compact('contactIndustries'));
			$contactRatings = $this->Contact->ContactRating->find('list');
			$this->set(compact('contactRatings'));
			#$assignees = $this->Contact->Assignee->find('list');
			#$this->set('assignees', $assignees);
		}
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
	
	function admin_delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for ContactCompany', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->ContactCompany->del($id)) {
			$this->Session->setFlash(__('ContactCompany deleted', true));
			$this->redirect(array('action'=>'index'));
		}
	}
	
	function admin_ajax_delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id', true));
			$this->redirect(array('action'=>'index'));
		}
		$model = $this->modelClass;
		# specific to this controller (and the contact_companies_controller)
		$contact_id = $this->$model->find('first', array('fields' => 'contact_id', 'conditions' => array('id' => $id)));
		App::import('Model', 'Contact');
		$Contact = new Contact;
		$Contact->del($contact_id['ContactCompany']['contact_id']);
		$this->$model->del($id);
		$this->viewPath = 'pages';
		$this->render('ajax_delete');
	}

}
?>