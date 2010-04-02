<?php
class ProjectsWatchersController extends AppController {

	var $name = 'ProjectsWatchers';

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
		## this might need to be fixed later, because I'm not 100% sure that 
		## we'll always need a type for the add / edit form
		## define the fields for the form and put them the order you want them displayed;
		## Edit these per controller
		
		#this puts all contacts into one drop down, who are already project members
		$combines = $this->$model->query("SELECT concat(Contact.first_name, ' ', Contact.last_name) AS name, Contact.contact_id FROM contact_people AS Contact WHERE Contact.contact_id IN (SELECT contact_id FROM users JOIN `projects_members` on projects_members.user_id = users.id WHERE project_id = ".$this->params['named']['project_id'].") UNION SELECT Contact.name AS name, Contact.contact_id FROM contact_companies AS Contact WHERE Contact.contact_id IN (SELECT contact_id FROM users JOIN `projects_members` on projects_members.user_id = users.id WHERE project_id = ".$this->params['named']['project_id'].") ORDER BY contact_id");
		foreach ($combines as $combine) :
			$contacts = am($contacts, array($combine[0]['contact_id'] => $combine[0]['name'])); 
		endforeach;		
		$this->set('contacts', $contacts);
		$this->set('fields', array('contact_id','project_id'));
		## End edit per controller
		$this->set('model', $model);
		$this->set('controller', $controller);
		$this->viewPath = 'pages';
		$this->render('ajax_edit');
	}
	
}
?>