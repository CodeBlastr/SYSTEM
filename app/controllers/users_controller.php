<?php
class UsersController extends AppController {

	var $name = 'Users';
	var $uid;
	var $components = array('Email');
	
	function beforeFilter() {
	    parent::beforeFilter(); 
	    $this->Auth->allowedActions = array('add', 'login', 'desktop_login', 'admin_login', 'forgot_password', 'reset_password');
	}
	
	// this checks to see if you're logged in
    function checkSession() {
        // If the session info hasn't been set...
        if (!$this->Session->check('User')) {
            // Force the user to login
            $this->redirect(array('plugin' => null, 'controller' => 'users', 'action' => 'login'));
            exit();
        }
    }
	
	# front end login
	function login() { 	
		$this->User->read(null, 1);
		$this->User->set('last_login', date('Y-m-d h:i:s'));
		$this->User->save();
    }
	
	# desktop login
	function desktop_login() { 	
        $user = $this->User->find('first', array('conditions' => array('username' => $this->data['User']['username'],'password' => $this->data['User']['password'])));	
        if($user!= null ){	    
	        echo $user['User']['id']; 
			$this->render(false);	    
		} else{
		    echo "Fail";
			$this->render(false);
		}	
    }

    function logout() {
        $this->redirect($this->Auth->logout());
    }
	# back end login
	function admin_login() {
    }
	
	function index() {
		$this->Session->setFlash(__('This page does not exist', true));
		$this->redirect('/admin/users');
	}
	
    function admin_logout() {
        $this->redirect($this->Auth->logout());
    }
	
	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid User.', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->set('user', $this->User->read(null, $id));
	}
	
	function add() {
		pr($this->data);
		echo 'asldkfjalsdkfjalsdkfjalsdfkj';
		break;
		if (!empty($this->data)) {
			$this->User->create();
			if ($this->User->save($this->data)) {
				$this->Session->setFlash(__('The User has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The User could not be saved. Please, try again.', true));
			}
		}
		$userGroups = $this->User->UserGroup->find('list');
		$this->set(compact('userGroups'));
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid User', true));
			$this->redirect(array('action'=>'index'));
		}
		if (!empty($this->data)) {
			if ($this->User->save($this->data)) {
				$this->Session->setFlash(__('The User has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The User could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->User->read(null, $id);
			$userGroups = $this->User->UserGroup->find('list');
			$this->set('userGroups', $userGroups);
		}
	}
	
	function admin_index() {
		$this->User->recursive = 0;
		$this->set('users', $this->paginate());
	}

	function admin_view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid User.', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->set('user', $this->User->read(null, $id));
	}

	function admin_add() {
		if (!empty($this->data)) {
			$this->User->create();
			if ($this->User->save($this->data)) {
				$this->Session->setFlash(__('The User has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The User could not be saved. Please, try again.', true));
			}
		}
		$userGroups = $this->User->UserGroup->find('list');
		$this->set(compact('userGroups'));
	}

	function admin_edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid User', true));
			$this->redirect(array('action'=>'index'));
		}
		if (!empty($this->data)) {
			if ($this->User->save($this->data)) {
				$this->Session->setFlash(__('The User has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The User could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->User->read(null, $id);
			$userGroups = $this->User->UserGroup->find('list');
			$this->set('userGroups', $userGroups);
		}
	}

	function admin_delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for User', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->User->del($id)) {
			$this->Session->setFlash(__('User deleted', true));
			$this->redirect(array('action'=>'index'));
		}
	}
	

    function __uid() {
        // creates a 6 digit key
        $uid = substr(md5(uniqid(rand(), true)), 0, 40);
        //checkto make sure its not a duplcate
        $user = $this->User->find('first', array('conditions' => array('forgot_key' => $uid)));
        if (!empty($user)) {
            //if founds re-run the function
            $this->__uid();
        } else {
            return $uid;
        }
    }
	
	function __resetPasswordKey($userid) {
		$user = $this->User->find('first', array('conditions' => array('id' => $userid))); 
		unset($this->data['User']['username']);
		$this->data['User']['id'] = $userid;
		$this->data['User']['forgot_key'] = $this->__uid(); 
		$this->data['User']['forgot_key_created'] = date('Y-m-d h:i:s');
		$this->data['User']['forgot_tries'] = $user['User']['forgot_tries'] + 1;
		$this->data['User']['user_group_id'] = $user['User']['user_group_id'];
		$this->User->Behaviors->detach('Translate');
		if ($this->User->save($this->data)) {
			return $this->data['User']['forgot_key'];
		} else {
			return false;
		}
	}
	

	function reset_password($key = null) {
      	# lets see if the key exists and which user its for.
		if(!empty($key))	{
			$user = $this->User->find('first', array(
				'conditions' => array(
					'User.forgot_key' => $key,
					'User.forgot_key_created <=' => date('Y:m:d h:i:s', strtotime("+3 days")),
					),
				));
			# if the user does exist, then reset user record forgot info, login and redirect to users/edit
			if (!empty($user)) {
				$this->data['User']['id'] = $user['User']['id'];
				$this->data['User']['user_group_id'] = $user['User']['user_group_id'];
				$this->data['User']['forgot_key'] = null;
				if ($this->User->save($this->data)) { 
					$this->Auth->login($user);
					$this->Session->setFlash('Successful account verification, change your password.');
					$this->redirect(array('action'=>'edit', $user['User']['id']));
				}
			} else {
				$this->Session->setFlash('Reset code invalid, expired or already used, please try again.');
				$this->redirect(array('action'=>'forgot_password'));
			}
		} else {
			$this->Session->setFlash('Reset password code invalid, please try again.');
			$this->redirect(array('action'=>'forgot_password'));
		}
	}
	

	function forgot_password() {
		if(!empty($this->data))	{
			# first look for to see if the user exists
		  	$userDetails = $this->__lookupUserDetails(trim($this->data['User']['username']));
			if (!empty($userDetails['userid']) && !empty($userDetails['email_address'])) {
				# the user details exist 
				# so first lets update the user record with a temporary uid key to use for resetting password
				$forgotKey = $this->__resetPasswordKey($userDetails['userid']);
				if (!empty($forgotKey)) {
					# then lets email the user a link to the reset password page
					if ($this->__sendMail($userDetails['email_address'], $forgotKey)) {
						$this->Session->setFlash('Password reset email sent to email ending with ******'. substr($userDetails['email_address'], -9));
					} else {
						$this->Session->setFlash('Reset email could not be sent. Please try again.');
					}
				} else {
					$this->Session->setFlash('Password could not be reset, please try again.');
				}
			} else {
				$this->Session->setFlash($userDetails['error']);
			}			
		}
	}
	
	function __sendMail($emailAddress, $key) {
		#$this->Email->template = 'default';
		$this->Email->delivery = 'debug';
		$this->Email->to = $emailAddress;
		$this->Email->subject = __('Password reset request', true);
		$this->Email->replyTo = '';
		$this->Email->from = 'Support Team <noreply@'.$_SERVER['HTTP_HOST'];
		$this->Email->sendAs = 'both';
		$message['html'] = 'Password reset requested <a href="http://'.$_SERVER['HTTP_HOST'].'/users/reset_password/'.$key.'">Click here to activate.</a><br><br>If you have received this message in error please ignore, the link will be unusable in three days.';
		$message['text'] = 'Password reset requested. Visit this url to activate : http://'.$_SERVER['HTTP_HOST'].'/users/reset_password/'.$key.'
		
		If you have received this message in error please ignore, the link will be unusable in three days.';
		$this->set(compact('message'));
		# $this->Email->template = 'password_reset_request';
		# pr($this->Session->read('Message.email'));
		if ($this->Email->send($message)) {
			return true;
		} else {
			return false;
		}
	}

	
	function __lookupUserDetails($username) {
		$user = $this->User->find('first', array(
			'fields' => array(
				'User.username',
				'User.id',
				),
			'conditions' => array(
				'User.username' => $username
				)
			));
		if (!empty($user['User']['username']) && strpos($user['User']['username'], '@')) {
			# the username is an email address
			return array('userid' => $user['User']['id'], 'email_address' => $user['User']['username']);
		} else if (!empty($user['User']['username'])) {
			# the username exists but it is not an email address lets see if we can look it up
			# first see if the contact with this user exists get the primary email
			# find the detail type for later use
			App::import('Model', 'Contacts.Contact');
			$this->Contact = new Contact;
			$enumeration = $this->Contact->ContactDetail->ContactDetailType->find('first', array(
				'conditions' => array(
					'constant' => 'PRIMARY_EMAIL'
					)
				));
			if (!empty($enumeration)) {
				$contact = $this->Contact->find('first', array(
					'conditions' => array(
						'user_id' => $user['User']['id'],
						),
					'contain' => array(
						'ContactDetail' => array(
							'conditions' => array(
								'contact_detail_type_id' => $enumeration['ContactDetailType']['id'],
								),
							),
						),
					));
				return array('userid' => $user['User']['id'], 'email_address' => $contact['ContactDetail'][0]['value']);
			} else {
				return array('error' => 'Site does not have a ContactDetail PRIMARY_EMAIL set.');
			}			
		} else if (strpos($username, '@')) {
			# the user does not exist but we can still see if the contact detail does because they entered an email
			App::import('Model', 'Contacts.Contact');
			$this->Contact = new Contact;
			$enumeration = $this->Contact->ContactDetail->ContactDetailType->find('first', array(
				'conditions' => array(
					'constant' => 'PRIMARY_EMAIL'
					)
				));
			if (!empty($enumeration)) {
				$contactDetail = $this->Contact->ContactDetail->find('first', array(
					'conditions' => array(
						'value' => $username,
						'contact_detail_type_id' => $enumeration['ContactDetailType']['id'],
						)
					));
				if (!empty($contactDetail)) {
					# a contact detail was found, lets get the user id
					$contact = $this->Contact->find('first', array(
						'conditions' => array(
							'id' => $contactDetail['ContactDetail']['contact_id'],
						)
					));
					if (!empty($contact['Contact']['user_id'])) {
						$user = $this->User->find('first', array(
							'conditions' => array(
								'id' => $contact['Contact']['user_id'],
								),
							));
						if (!empty($user['User']['id'])) {
							return array('userid' => $user['User']['id'], 'email_address' => $contactDetail['ContactDetail']['value']);
						} else {
							return array('error' => 'Contact detail exists, but user does not, please try again.');
						}
					} else {
						return array('error' => 'Contact detail exists, but contact user id does not, please try again.');
					}
				} else {
					return array('error' => 'Email for user does not exist, please try again.');						
				}
			} else {
				return array('error' => 'Site does not have a ContactDetail PRIMARY_EMAIL set.');
			}				
		} else {
			return array('error' => 'Invalid username or email address, please try again.');	
		}
	}

}
?>