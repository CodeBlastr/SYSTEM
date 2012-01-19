<?php
class ContactsController extends ContactsAppController {

	public $name = 'Contacts';
	public $uses = 'Contacts.Contact';
	
	
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
	
	
	public function index() {
		$this->paginate = array(
			'conditions' => array(
				'Contact.is_company' => 1,
				),
			'fields' => array(
				'id',
				'name',
				'contact_type_id',
				'contact_source_id',
				'contact_industry_id',
				'contact_rating_id',
				),
			'contain' => array(
				'ContactType' => array(
					'fields' => array(
						'name',
						),
					),
				'ContactSource' => array(
					'fields' => array(
						'name',
						),
					),
				'ContactIndustry' => array(
					'fields' => array(
						'name',
						),
					),
				'ContactRating' => array(
					'fields' => array(
						'name',
						),
					),
				),
			'order' => array(
				'Contact.name'
				),
			'limit' => 25,
			);
		$this->set('contacts', $this->paginate());
		$this->set('displayName', 'name');
		$this->set('displayDescription', ''); 
		$associations =  array('ContactType' => array('displayField' => 'name'), 'ContactSource' => array('displayField' => 'name'), 'ContactIndustry' => array('displayField' => 'name'), 'ContactRating' => array('displayField' => 'name'));
		$this->set('associations', $associations);
	}
	
	
	public function people() {
		$this->paginate = array(
			'conditions' => array(
				'Contact.is_company' => 0,
				),
			'fields' => array(
				'id',
				'name',
				'contact_type_id',
				'contact_source_id',
				'contact_industry_id',
				'contact_rating_id',
				),
			'contain' => array(
				'ContactType' => array(
					'fields' => array(
						'name',
						),
					),
				'ContactSource' => array(
					'fields' => array(
						'name',
						),
					),
				'ContactIndustry' => array(
					'fields' => array(
						'name',
						),
					),
				'ContactRating' => array(
					'fields' => array(
						'name',
						),
					),
				),
			'order' => array(
				'Contact.name'
				),
			'limit' => 25,
			);
		$this->set('contacts', $this->paginate());
		$this->set('displayName', 'name');
		$this->set('displayDescription', ''); 
		$associations =  array('ContactType' => array('displayField' => 'name'), 'ContactSource' => array('displayField' => 'name'), 'ContactIndustry' => array('displayField' => 'name'), 'ContactRating' => array('displayField' => 'name'));
		$this->set('associations', $associations);
	}

	public function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid Contact.', true));
			$this->redirect(array('action'=>'index'));
		}
		
		$contact = $this->Contact->find('first', array(
			'conditions' => array(
				'Contact.id' => $id,
				),
			'contain' => array(
				'ContactType',
				'ContactSource',
				'ContactIndustry',
				'ContactRating',
				'ContactDetail' => array(
					'ContactDetailType',
					),
				'ContactAddress' => array(
					'ContactAddressType',
					),
				'Employer',
				),
			));
		$contactDetailTypes = Zuha::enum('CONTACTDETAIL');
		$contactAddressTypes = Zuha::enum('CONTACTADDRESS');
		$this->set(compact('contact', 'contactDetailTypes', 'contactAddressTypes', 'contactActivityTypes'));
		
		# get paginated related contacts
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
		$employees = !empty($contact['Contact']['is_company']) ? $this->paginate('Contact', array('Contact.id')) : null;
		$this->set('employees', $employees);
		$this->set('modelName', 'Contact');
		$this->set('displayName', 'name');
		$this->set('displayDescription', '');
		$this->set('tabsElement', '/contacts');
		$this->set('page_title_for_layout', $contact['Contact']['name']);
		$this->set('title_for_layout',  $contact['Contact']['name']);
	}

/**
 * Handles the saving of new contacts, and gets the variables to use for the contact add form.
 *
 * @todo			Most of the list variables below need to have a find function put into those models, which finds the right enumeration type by default.  Its really ugly to have multiple instances of the "type" spelled out all over the place.
 */	 
	public function add($contactType = 'company', $contactId = null) {
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
		$contacts = Zuha::enum('CONTACTTYPE');
		$contactTypes = Zuha::enum('CONTACTTYPE');
		$contactSources = Zuha::enum('CONTACTSOURCE');
		$contactIndustries = Zuha::enum('CONTACTINDUSTRY');
		$contactRatings = Zuha::enum('CONTACTRATING');
		$contactDetailTypes = Zuha::enum('CONTACTDETAIL');
			
		$this->set(compact('employers', 'people', 'contactDetailTypes', 'contactTypes', 'contactSources', 'contactIndustries', 'contactRatings'));
		$this->set('page_title_for_layout', 'Add a '.$contactType);
		$this->set('title_for_layout',  'Add a '.$contactType);
		$this->render('add_'.$contactType);
	}

	public function edit($id = null) {
		if (!$id && empty($this->request->data)) {
			$this->Session->setFlash(__('Invalid contact', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->request->data)) {
			if ($this->Contact->save($this->request->data)) {
				$this->Session->setFlash(__('The contact has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The contact could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->request->data)) {
			$this->request->data = $this->Contact->read(null, $id);
		}
		$contactTypes = $this->Contact->ContactType->find('list');
		$contactSources = $this->Contact->ContactSource->find('list');
		$contactIndustries = $this->Contact->ContactIndustry->find('list');
		$contactRatings = $this->Contact->ContactRating->find('list');
		$users = $this->Contact->User->find('list');
		$contacts = $this->Contact->Contact->find('list');
		$this->set(compact('contactTypes', 'contactSources', 'contactIndustries', 'contactRatings', 'users', 'contacts'));
	}

	public function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for contact', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Contact->delete($id)) {
			$this->Session->setFlash(__('Contact deleted', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Contact was not deleted', true));
		$this->redirect(array('action' => 'index'));
	}
	
	public function ajax_edit(){
		$this->__ajax_edit();
	} 
	
/**
 * Show the tasks related to this contact
 * @todo 	Make this so that it renders using an element from the tasks plugin
 */
	public function tasks($contactId = null) {
		$this->paginate = array(
			'conditions' => array(
				'Task.model' => 'Contact',
				'Task.foreign_key' => $contactId,
				'Task.parent_id' => null,
				),
			'fields' => array(
				'id',
				'name',
				'is_completed',
				'created',
				'description',
				),
			'contain' => array(
				'Assignee' => array(
					'fields' => array(
						'full_name',
						),
					),
				),
			'order' => array(
				'Task.created DESC'
				),
			'limit' => 10,
			);
		$contact = $this->Contact->find('first', array(
			'conditions' => array('Contact.id' =>  $contactId)));
		$this->set('contact', $contact); 
		$this->set('foreignKey', $contactId);
		$this->set('tasks', $this->paginate('Contact.Task'));
		$this->set('modelName', 'Task');
		$this->set('pluginName', 'tasks');
		$this->set('link', array('pluginName' => 'contacts', 'controllerName' => 'contacts', 'actionName' => 'task'));
		$this->set('displayName', 'name');
		$this->set('displayDescription', 'description'); 
		$this->set('page_title_for_layout', $contact['Contact']['name']);
		$this->set('tabsElement', '/contacts');
	}
	
	
/**
 * Show the tasks related to this contact.
 * @todo 	Make this so that it renders using an element from the tasks plugin
 */
	public function task($taskId = null) {				
		$task = $this->Contact->Task->find('first', array(
			'conditions' => array(
				'Task.id' => $taskId,
				),
			));
		
		$this->set('task', $task);
		$this->paginate = array(
			'conditions' => array(
				'Task.parent_id' => $task['Task']['id'],
				'Task.is_completed' => 0,
				),
			'contain' => array(
				'Assignee' => array(
					'fields' => array(
						'id',
						'full_name',
						),
					),
				),
			'fields' => array(
				'id',
				'due_date',
				'assignee_id',
				'name',
				),
			'order' => array(
				'Task.order',
				'Task.due_date',
				),
			);
		$contact = $this->Contact->find('first', array(
			'conditions' => array('Contact.id' => $task['Task']['foreign_key'])));
		$this->set('contact', $contact); 
		$associations =  array('Assignee' => array('displayField' => $this->Contact->Task->Assignee->displayField), 'Creator' => array('displayField' => 'full_name'));
		$this->set('associations', $associations);
		$this->set('childTasks', $this->paginate('Task'));
		$this->paginate['conditions']['Task.is_completed'] = 1;
		$this->paginate['fields'] = array('id', 'due_date', 'completed_date', 'assignee_id', 'name');
		$this->set('finishedChildTasks', $this->paginate('Task'));
		$this->set('parentId', $task['Task']['id']);
		$this->set('model', $task['Task']['model']);
		$this->set('foreignKey', $task['Task']['foreign_key']);
		$this->set('assignees', $this->Contact->User->find('list'));
		$this->set('modelName', 'Task');
		$this->set('pluginName', 'tasks');
		$this->set('displayName', 'name');
		$this->set('displayDescription', ''); 
		$this->set('showGallery', true);
		$this->set('galleryModel', array('name' => 'User', 'alias' => 'Assignee'));
		$this->set('galleryForeignKey', 'id');
		$this->set('page_title_for_layout', $contact['Contact']['name']);
		$this->set('tabsElement', '/contacts');
	}
	
	public function dashboard() {
	}
}
?>