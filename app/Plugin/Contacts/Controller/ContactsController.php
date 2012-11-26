<?php
class ContactsController extends ContactsAppController {

	public $name = 'Contacts';
	public $uses = 'Contacts.Contact';
	public $allowedActions = array();
	
	
	public function __construct($request = null, $response = null) {
		parent::__construct($request, $response);
		if (in_array('Comments', CakePlugin::loaded())) {
			$this->components['Comments.Comments'] = array(
				'userModelClass' => 'Users.User', 
				'actionNames' => array('task'),
				);
		}
	}
	
	
	public function beforeFilter() {
		parent::beforeFilter();
		$this->passedArgs['comment_view_type'] = 'threaded';
	}
	
	
	public function import($type) {
		// http://www2.razorit.com/contacts/contacts/import/google
		if ($type == 'google') {
			$googleAccessToken = $this->Session->read('Google.accessToken'); // set in UserConnectsController
			if (!empty($googleAccessToken)) {
								
				App::uses('UserConnect', 'Users.Model');
				$UserConnect = new UserConnect();
				debug($UserConnect->listGoogleContacts($googleAccessToken));
				break;
				
				// post($accessTokenKey, $accessTokenSecret, $url, array $postData = array()) 
				$response = $this->Client->post($params['code'], $params['client_secret'], 'https://accounts.google.com/o/oauth2/token', $params);
				debug($googleAccessToken);
				break;
			} else {
				$this->redirect('/users/user_connects/google/contacts%2Fcontacts%2Fimport%2Fgoogle');
			}
		}
	}
	
	
	
	public function index() {
		//$this->paginate['conditions'] = array('Contact.is_company' => 1, 'Contact.contact_type IS NOT NULL');
		$this->paginate['fields'] = array(
			'id',
			'name',
			'contact_type',
			'contact_source',
			'contact_industry',
			'contact_rating',
			'is_company',
            'created'
			);
		$this->paginate['order'] = array(
			'Contact.name'
			);
		$this->set('contacts', $this->paginate());
		$this->set('displayName', 'name');
		$this->set('displayDescription', '');
		$this->set('contactTypes', $this->Contact->types());
		//$associations =  array('ContactType' => array('displayField' => 'name'), 'ContactSource' => array('displayField' => 'name'), 'ContactIndustry' => array('displayField' => 'name'), 'ContactRating' => array('displayField' => 'name'));
		$this->set('associations', $associations);
		$this->allowedActions[] = 'list';
	}
	
	
	public function people() {
		$this->paginate = array(
			'conditions' => array(
				'Contact.is_company' => 0,
				),
			'fields' => array(
				'id',
				'name',
				'contact_type',
				'contact_source',
				'contact_industry',
				'contact_rating',
				),
			'order' => array(
				'Contact.name'
				),
			);
		$this->set('contacts', $this->paginate());
		$this->set('displayName', 'name');
		$this->set('displayDescription', ''); 
	}


/**
 * View method
 * 
 * @param type $id
 * @throws NotFoundException
 */
	public function view($id = null) {
		$this->Contact->id = $id;
		if (!$this->Contact->exists()) {
			throw new NotFoundException(__('Contact not found'));
		}
		
		$contact = $this->Contact->find('first', array(
			'conditions' => array(
				'Contact.id' => $id,
				),
			'contain' => array(
				'ContactDetail',
				'ContactAddress' => array(
					'ContactAddressType',
					),
				'Employer',
				),
			));
		$contactDetailTypes = $this->Contact->ContactDetail->types();
		$this->set(compact('contact', 'contactDetailTypes', 'contactActivityTypes'));
		
		// get paginated related contacts
		$this->paginate = array('Contact' => array(
			'joins' => array(array(
				'table' => 'contacts_contacts',
				'alias' => 'Employee',
				'type' => 'INNER',
				'conditions' => array(
					'Employee.parent_contact_id' => $contact['Contact']['id'],
					'Employee.child_contact_id = Contact.id',
					),
				)),
			'fields' => array(
				'id',
				'name',
				),
			));
			
		// vars for employees
		$employees = !empty($contact['Contact']['is_company']) ? $this->paginate('Contact', array('Contact.id')) : null;
		$this->set('employees', $employees);
		
		// vars for opportunities
		$this->set('estimates', in_array('Estimates', CakePlugin::loaded()) ? $this->paginate('Contact.Estimate', array('Estimate.foreign_key' => $id, 'Estimate.model' => 'Contact')) : null);
		
		// vars for activities
		unset($this->paginate);
		$this->paginate = array('fields' => array('Activity.id', 'Activity.name', 'Activity.creator_id', 'Activity.created', 'Creator.id', 'Creator.full_name'), 'contain' => array('Creator'));
		$this->set('activities', in_array('Activities', CakePlugin::loaded()) ? $this->paginate('Contact.Activity', array('Activity.foreign_key' => $id, 'Activity.model' => 'Contact', 'Activity.action_description !=' => 'lead created')) : null);
		
		// vars for reminders
		unset($this->paginate);
		$this->paginate = array('fields' => array('id', 'name', 'due_date'));
		$this->set('tasks', in_array('Tasks', CakePlugin::loaded()) ? $this->paginate('Contact.Task', array('Task.foreign_key' => $id, 'Task.model' => 'Contact', 'Task.is_completed' => 0)) : null);
		
		// view vars
		$this->set('people', $this->Contact->Employer->findPeople('list'));
		$this->set('modelName', 'Contact');
		$this->set('displayName', 'name');
		$this->set('displayDescription', '');
		$this->set('page_title_for_layout', $contact['Contact']['name']);
		$this->set('title_for_layout',  $contact['Contact']['name']);
		$this->set('loggedActivities', $this->Contact->activities($id));
		$this->set('loggedEstimates', $this->Contact->estimates($id));
		
		// which view file to use
		!empty($contact['Contact']['is_company']) ? $this->render('view_company') : $this->render('view_person');
	}

/**
 * Handles the saving of new contacts, and gets the variables to use for the contact add form.
 *
 * @todo			Most of the list variables below need to have a find function put into those models, which finds the right enumeration type by default.  Its really ugly to have multiple instances of the "type" spelled out all over the place.
 */	 
	public function add($contactType = 'company', $contactId = null) {
		if (!empty($contactId)) {
			$this->Contact->id = $contactId;
			if (!$this->Contact->exists()) {
				throw new NotFoundException(__('Contact not found'));
			}
		}

		if (!empty($this->request->data)) {
			try {
				$message = $this->Contact->add($this->request->data);
				$this->Session->setFlash($message);
				$this->redirect(array('action' => 'view', $this->Contact->id));
			} catch (Exception $e) {
				$message = $e->getMessage();
				$this->Session->setFlash($message);			
			}
		}
		
		// load the contact drop down fields variables
		$employers = $this->Contact->Employer->findCompanies('list');
		$people = $this->Contact->Employer->findPeople('list');
		$this->request->data['Employer']['Employer'] = !empty($contactId) ? $contactId : null;
		
		$contactTypes = $this->Contact->types();
		$contactSources = $this->Contact->sources();
		$contactIndustries = $this->Contact->industries();
		$contactRatings = $this->Contact->ratings();
		$contactDetailTypes = $this->Contact->ContactDetail->types();
		$assignees = $this->Contact->Assignee->find('list');
			
		$this->set(compact('employers', 'people', 'contactDetailTypes', 'contactTypes', 'contactSources', 'contactIndustries', 'contactRatings', 'assignees'));
		$this->set('page_title_for_layout', 'Add '.$contactType);
		$this->set('title_for_layout',  'Add '.$contactType);
		$this->render('add_'.$contactType);
	}

/**
 *  Edit method
 */
	public function edit($id = null) {
		$this->Contact->id = $id;
		if (!$this->Contact->exists()) {
			throw new NotFoundException(__('Contact not found'));
		}
		
		if (!empty($this->request->data)) {
			if ($this->Contact->saveAll($this->request->data)) {
				$this->Session->setFlash(__('The contact has been saved'));
			} else {
				$this->Session->setFlash(__('The contact could not be saved. Please, try again.'));
			}
		}
		
		$this->Contact->contain('ContactDetail');
		$this->request->data = $this->Contact->read(null, $id);
		
		$contactTypes = $this->Contact->types();
		$contactSources = $this->Contact->sources();
		$contactIndustries = $this->Contact->industries();
		$contactRatings = $this->Contact->ratings();
		$users = $this->Contact->User->find('list');
		$assignees = $users; // save a db call
		
		$this->set('page_title_for_layout', __('Edit %s', $this->request->data['Contact']['name']));
		$this->set(compact('contactTypes', 'contactSources', 'contactIndustries', 'contactRatings', 'users', 'assignees'));
	}

	public function delete($id = null) {
		$this->Contact->id = $id;
		if (!$this->Contact->exists()) {
			throw new NotFoundException(__('Contact not found'));
		}
		
		if ($this->Contact->delete($id)) {
			$this->Session->setFlash(__('Contact deleted', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Contact was not deleted', true));
		$this->redirect(array('action' => 'index'));
	}
	
/**
 * Add an opportunity / estimate for a contact
 */
	public function estimate($contactId = null) {
		$this->Contact->id = $contactId;
		if (!$this->Contact->exists()) {
			throw new NotFoundException(__('Contact not found'));
		}
		if (!empty($this->request->data)) {
			try {
				$this->Contact->Estimate->save($this->request->data);
				$this->Session->setFlash('Opportunity Added');
				$this->redirect(array('action' => 'view', $contactId));
			} catch (Exception $e) {
				$this->Session->setFlash($e->getMessage());			
			}
		}
		$contact = $this->Contact->read(null, $contactId);
		$this->set(compact('contact')); 
		$this->set('page_title_for_layout', __('Create an opportunity for %s', $contact['Contact']['name']));
	}

/**
 * Activities method
 * 
 * @return array $activities
 */
	public function activities() {
		$this->paginate['fields'] = array('Activity.id', 'Activity.name', 'Activity.description', 'Activity.creator_id', 'Activity.created', 'Creator.id', 'Creator.full_name', 'Contact.name');
		$this->paginate['contain'] = array('Contact', 'Creator');
		
		$this->Contact->Activity->bindModel(array(
			'belongsTo' => array(
    	       	'Contact' => array(
        	       	'className' => 'Contacts.Contact',
					'foreignKey' => 'foreign_key',
					'conditions' => array('Activity.model' => 'Contact')
	        	    )
            	)));
					
		$activities = $this->paginate('Activity');
		for($i = 0, $size = count($activities); $i < $size; ++$i) {
			$activities[$i]['Activity']['name'] = __('%s <small>for %s</small>', $activities[$i]['Activity']['name'], $activities[$i]['Contact']['name']);
		}
		
		$associations =  array('Creator' => array('displayField' => 'full_name'));
		$this->set(compact('activities', 'associations'));
		$this->set('modelName', 'Activity');
		$this->set('displayName', 'displayName');
		$this->set('displayDescription', '');
		$this->set('page_title_for_layout', __('Contact Activities'));
		return $activities;
	}
	
/**
 * Add an activity for a contact
 * 
 * @param string
 */
	public function activity($contactId = null) {
		$this->Contact->id = $contactId;
		if (!$this->Contact->exists()) {
			throw new NotFoundException(__('Contact not found'));
		}
		if (!empty($this->request->data)) {
			try {
				$this->Contact->Activity->save($this->request->data);
				$this->Session->setFlash('Activity Logged');
				$this->redirect(array('action' => 'view', $contactId));
			} catch (Exception $e) {
				$this->Session->setFlash($e->getMessage());			
			}
		}
        $this->Contact->contain('ContactDetail');
		$contact = $this->Contact->read(null, $contactId);
		$this->set(compact('contact')); 
		$this->set('page_title_for_layout', __('Log an Activity for %s', $contact['Contact']['name']));
	}

/**
 * Tasks method
 * 
 * @return array $tasks
 */
	public function tasks() {
		$this->paginate['fields'] = array('Task.id', 'Task.name', 'Task.description', 'Task.assignee_id', 'Task.due_date', 'Assignee.id', 'Assignee.full_name', 'Contact.name');
		$this->paginate['contain'] = array('Contact', 'Assignee');
		
		$this->Contact->Task->bindModel(array(
			'belongsTo' => array(
    	       	'Contact' => array(
        	       	'className' => 'Tasks.Task',
					'foreignKey' => 'foreign_key',
					'conditions' => array('Task.model' => 'Contact')
	        	    )
            	)));
					
		$tasks = $this->paginate('Task');
		for($i = 0, $size = count($tasks); $i < $size; ++$i) {
			$tasks[$i]['Task']['name'] = __('%s <small>for %s</small>', $tasks[$i]['Task']['name'], $tasks[$i]['Contact']['name']);
		}
		
		$associations =  array('Assignee' => array('displayField' => 'full_name'));
		$this->set(compact('tasks', 'associations'));
		$this->set('modelName', 'Task');
		$this->set('displayName', 'displayName');
		$this->set('displayDescription', 'description');
		$this->set('page_title_for_layout', __('Contact Reminders'));
		return $tasks;
	}
	
	
/**
 * Add a reminder
 * 
 * @param string
 */
	public function task($contactId = null) {		
		$this->Contact->id = $contactId;
		if (!$this->Contact->exists()) {
			throw new NotFoundException(__('Contact not found'));
		}
		if (!empty($this->request->data)) {
			try {
				$this->Contact->Task->save($this->request->data);
				$this->Session->setFlash('Activity Logged');
				$this->redirect(array('action' => 'view', $contactId));
			} catch (Exception $e) {
				$this->Session->setFlash($e->getMessage());			
			}
		}
		$contact = $this->Contact->read(null, $contactId);
		$this->set(compact('contact')); 
		$this->set('assignees', $this->Contact->Assignee->find('list'));
		$this->set('page_title_for_layout', __('Create a Reminder for %s', $contact['Contact']['name']));
	}
	
	
/**
 *  Dashboard method
 * 
 */
	public function dashboard() {
		$this->Contact->fixTypes(); // a temporary fix for updating some database values;
		
		// the needs attention, new leads box
		$this->set('leads', $this->Contact->leads());
		
		// leads over time
		$this->set('leadActivities', $this->Contact->leadActivities());
		
		// upcoming follow ups
		$this->set('tasks', $this->Contact->myTasks());
		
		// list of pending opportunities
		$this->set('estimates', $this->Contact->estimates());
		
		// list of pending opportunities
		$this->set('estimateActivities', $this->Contact->estimateActivities());
		
		// list of activities
		$this->set('activities', $this->Contact->activities());
		
		// list of activities
		$this->set('myContacts', $this->Contact->find('all', array('conditions' => array('Contact.assignee_id' => $this->Session->read('Auth.User.id')), 'limit' => 5, 'order' => 'Contact.created DESC')));

		$this->set('page_title_for_layout', 'CRM Dashboard');
	}
}