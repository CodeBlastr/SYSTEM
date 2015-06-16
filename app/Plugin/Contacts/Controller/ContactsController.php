<?php
/**
 * Extension Code
 * $refuseInit = true; require_once(ROOT.DS.'app'.DS.'Plugin'.DS.'Contacts'.DS.'Controller'.DS.'ContactsController.php');
 */

App::uses('ContactsAppController', 'Contacts.Controller');
class AppContactsController extends ContactsAppController {

	public $name = 'Contacts';
	
	public $uses = 'Contacts.Contact';
	
	public $helpers = array('Contacts.Chart');
	
	public $allowedActions = array('proposal');
	
	
	public function __construct($request = null, $response = null) {
		parent::__construct($request, $response);
		if (CakePlugin::loaded('Comments')) {
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
		$this->paginate['order'] = array(
			'Contact.name'
			);
		$this->paginate['contain'] = array(
			'Assignee'
			);
		$this->set('contacts', $this->paginate());
		$this->set('displayName', 'name');
		$this->set('displayDescription', '');
		$this->set('contactTypes', $this->Contact->types());
		$this->set('associations',  array('Assignee' => array('displayField' => 'full_name')));
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
				'Assignee'
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
		unset($this->paginate);
		$this->paginate = array('fields' => array('Estimate.id', 'Estimate.name', 'Estimate.created', 'Estimate.total', 'Estimate.creator_id', 'Creator.id', 'Creator.full_name'), 'contain' => array('Creator'));
		$this->set('estimates', in_array('Estimates', CakePlugin::loaded()) ? $this->paginate('Contact.Estimate', array('Estimate.foreign_key' => $id, 'Estimate.model' => 'Contact')) : null);
		
		// vars for activities
		$this->set('activities', CakePlugin::loaded('Activities') ? $this->Contact->Activity->find('all', array('conditions' => array('Activity.foreign_key' => $id, 'Activity.model' => 'Contact', 'Activity.action_description !=' => 'lead created'), 'order' => array('Activity.created' => 'DESC'))) : null);
		
		// vars for reminders
		$this->set('tasks', CakePlugin::loaded('Tasks') ? $this->Contact->Task->find('all', array('conditions' => array('Task.foreign_key' => $id, 'Task.model' => 'Contact', 'Task.is_completed' => 0))) : null);
		
		// view vars
		$this->set('people', $this->Contact->Employer->findPeople('list'));
		$this->set('page_title_for_layout', $contact['Contact']['name']);
		$this->set('title_for_layout',  $contact['Contact']['name']);
		$this->set('loggedActivities', $this->Contact->activities(array('foreign_key' => $id, 'start_date' => $contact['Contact']['created'])));
		$this->set('loggedEstimates', $this->Contact->estimates($id));
		$this->set('contactDetailTypes', $contactDetailTypes = $this->Contact->ContactDetail->types());
		
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
			$this->Session->setFlash(__('Contact deleted'));
			$this->redirect(array('action'=>'dashboard'));
		}
		$this->Session->setFlash(__('Contact was not deleted'));
		$this->redirect(array('action' => 'view', $id));
	}
	
/**
 * Add an opportunity / estimate for a contact
 * 
 * @throws MissingPluginException
 * @throws NotFoundException
 */
	public function estimate($contactId = null, $estimateId = null) {
		if (CakePlugin::loaded('Tasks')) {
			$this->Contact->id = $contactId;
			if (!$this->Contact->exists()) {
				throw new NotFoundException(__('Contact not found'));
			}
			if ($this->request->is('post') || $this->request->is('put')) {
				if ($this->Contact->Estimate->saveAll($this->request->data)) {
					$this->Session->setFlash('Proposal Saved');
					
					// send will email and redirect to view
					//$send = strpos($this->request->data['Estimate']['submit'], 'Send') ? true : false;
					// continue brings you to edit estimate, else go to view the estimate
					//$redirect = strpos($this->request->data['Estimate']['submit'], 'Continue') ? array('actions' => 'estimate', $this->Contact->Estimate->id) : array('actions' => 'proposal', $this->Contact->Estimate->id); 
					
					$this->redirect(array('action' => 'estimate', $contactId, $this->Contact->Estimate->id));
				} else {
					$this->Session->setFlash('Error saving, please check required fields.');
				}
			}
			$this->Contact->contain('ContactDetail');
			$this->set('contact', $this->request->data = $this->Contact->read(null, $contactId));
			
			// get estimate data if available
			if (!empty($estimateId)) {
				$estimate = $this->Contact->Estimate->find('first', array('conditions' => array('Estimate.id' => $estimateId), 'contain' => array('EstimateKey')));
				$this->set('estimate', $this->request->data = array_merge($this->request->data, $estimate));
			}
			$this->set('page_title_for_layout', __('Build proposal for %s', $this->request->data['Contact']['name']));
		} else {
			throw new MissingPluginException('Estimates Plugin Not Installed');
		}
	} 

/**
 * Estimated method
 * The view method for contact estimates
 */
 	public function estimated($estimateId = null) {
 		// $estimateId could be an estimate Key as well
 		$this->set('estimate', $this->request->data = $this->Contact->Estimate->find('first', array('conditions' => array('Estimate.id' => $estimateId), 'contain' => array('Contact', 'EstimateKey'))));
 	}

/**
 * Propsal method
 * The view method for contact estimates
 */
 	public function proposal($key = null) {
 		// $estimateId could be an estimate Key as well
 		$this->set('estimate', $this->request->data = $this->Contact->Estimate->find('first', array('conditions' => array('Estimate.id' => $key), 'contain' => array('Contact'))));
 	}

/**
 * Estimates method
 * List all contact related estimates
 * 
 * @throws MissingPluginException
 */
	public function estimates() {
		if (CakePlugin::loaded('Estimates')) {
			debug('hello');
		} else {
			throw new MissingPluginException('Estimates Plugin Not Installed');
		}
	}

/**
 * Unestimate method
 * Delete the estimate
 */
	public function unestimate($estimateId = null, $contactId = null) {
		if (CakePlugin::loaded('Estimates')) {
			$this->Contact->Estimate->id = $estimateId;
			if (!$this->Contact->Estimate->exists()) {
				throw new NotFoundException(__('Contact not found'));
			}
			
			if ($this->Contact->Estimate->delete($id)) {
				$this->Session->setFlash(__('Proposal deleted'));
				!empty($contactId) ? $this->redirect(array('action' => 'view', $contactId)) : $this->redirect(array('action'=>'dashboard'));
			}
			$this->Session->setFlash(__('Proposal was not deleted'));
			$this->redirect(array('action' => 'estimate', $estimateId));
		} else {
			throw new MissingPluginException('Estimates Plugin Not Installed');
		}
	}
 	
 	

/**
 * Activities method
 * 
 * @return array $activities
 */
	public function activities() {
		if (CakePlugin::loaded('Activities')) {
			$this->paginate['fields'] = array('Activity.id', 'Activity.name', 'Activity.description', 'Activity.creator_id', 'Activity.created', 'Creator.id', 'Creator.full_name', 'Contact.name');
			$this->paginate['contain'] = array('Contact', 'Creator');
	        $this->paginate['conditions']['Activity.model'] = 'Contact';
			
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
			$this->set('displayName', 'name');
			$this->set('displayDescription', '');
			$this->set('page_title_for_layout', __('Contact Activities'));
			return $activities;
		} else {
			throw new MissingPluginException('Activities Plugin Not Installed');
		}
	}
	
/**
 * Add an activity for a contact
 * 
 * @param string
 */
	public function activity($contactId = null) {
		if (CakePlugin::loaded('Activities')) {
			$this->Contact->id = $contactId;
			if (!$this->Contact->exists()) {
				throw new NotFoundException(__('Contact not found'));
			}
			if ($this->request->is('post')) {
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
		} else {
			throw new MissingPluginException('Activities Plugin Not Installed');
		}
	}

/**
 * Tasks method
 * 
 * @return array $tasks
 */
	public function tasks() {
		if (CakePlugin::loaded('Tasks')) {
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
			$this->set(compact('tasks'));
			$this->set('page_title_for_layout', __('Contact Reminders'));
			return $tasks;
		} else {
			throw new MissingPluginException('Tasks Plugin Not Installed');
		}
	}

/**
 * Add a reminder
 * 
 * @param string
 */
	public function task($contactId = null) {	
		if (CakePlugin::loaded('Tasks')) {	
			$this->Contact->id = $contactId;
			if (!$this->Contact->exists()) {
				throw new NotFoundException(__('Contact not found'));
			}
			if ($this->request->is('post')) {
				try {
					$this->Contact->Task->save($this->request->data);
					$this->Session->setFlash('Reminder added');
					$this->redirect(array('action' => 'view', $contactId));
				} catch (Exception $e) {
					$this->Session->setFlash($e->getMessage());			
				}
			}
			$contact = $this->Contact->read(null, $contactId);
			$this->set(compact('contact')); 
			$this->set('assignees', $this->Contact->Assignee->find('list'));
			$this->set('page_title_for_layout', __('Create a Reminder for %s', $contact['Contact']['name']));
		} else {
			throw new MissingPluginException('Tasks Plugin Not Installed');
		}
	}

/**
 * Rate method
 * 
 * @param string
 */
	public function rate($id = null, $rating = 'hot') {	
		$this->Contact->id = $id;
		if (!$this->Contact->exists()) {
			$this->Session->setFlash(__('Contact not found'));
			$this->redirect($this->referer());
		}
		
		$data['Contact']['id'] = $id;
		$data['Contact']['contact_rating'] = $rating;
		if ($this->Contact->save($data)) {
			$this->Session->setFlash(__('Rating updated'));
		} else {
			$this->Session->setFlash(__('Rating could not be updated. Please, try again.'));
		}
		$this->redirect($this->referer());
	}
	
/**
 *  Dashboard method
 * 
 */
	public function dashboard() {
		
		// the needs attention, new leads box
		$this->set('leads', $leads = $this->Contact->leads());
		
		// leads over time
		$this->set('leadActivities', $leadActivities = $this->Contact->leadActivities());
		
		// upcoming follow ups
		$this->set('tasks', $this->Contact->myTasks());
		
		// list of pending opportunities
		$this->set('estimates', $this->Contact->estimates());
		
		// list of pending opportunities
		$this->set('estimateActivities', $this->Contact->estimateActivities());
		
		// list of activities
		$this->set('activities', $activities = $this->Contact->activities());
		
		// list of activities
		$this->set('myContacts', $this->Contact->find('all', array('conditions' => array('Contact.assignee_id' => $this->Session->read('Auth.User.id')), 'limit' => 5, 'order' => 'Contact.created DESC')));
		
		// list of my ratings
		$this->set('myRatings', $myRatings = $this->Contact->myRatings());

		$this->set('page_title_for_layout', __('%s Sales Dashboard', __SYSTEM_SITE_NAME));
		$this->set('title_for_layout', __('%s Sales Dashboard', __SYSTEM_SITE_NAME));
	}
}

if (!isset($refuseInit)) {
	class ContactsController extends AppContactsController {}
}