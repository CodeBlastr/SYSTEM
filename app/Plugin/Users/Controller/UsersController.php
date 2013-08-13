<?php
App::uses('UsersAppController', 'Users.Controller');
/**
 * Users Controller
 *
 * Handles variables supplied from the Model, to be sent to the view for users.
 *
 * PHP versions 5
 *
 * Zuha(tm) : Business Management Applications (http://zuha.com)
 * Copyright 2009-2012, Zuha Foundation Inc. (http://zuha.org)
 *
 * Licensed under GPL v3 License
 * Must retain the above copyright notice and release modifications publicly.
 *
 * @copyright     Copyright 2009-2012, Zuha Foundation Inc. (http://zuha.com)
 * @link          http://zuha.com Zuha� Project
 * @package       zuha
 * @subpackage    zuha.app.models
 * @since         Zuha(tm) v 0.0.1
 * @license       GPL v3 License (http://www.gnu.org/licenses/gpl.html) and Future Versions
 * @todo		  The "view" method needs a requestAction fix so that requestAction works for all requestAction type calls, without the if params['requested'] thing being necessary everyhwere we want to do that.
 */
class _UsersController extends UsersAppController {

	public $name = 'Users';
	public $uses = 'Users.User';
	public $uid;
	public $components = array('Email', 'Ssl');
	public $allowedActions = array(
		'login',
		'desktop_login',
		'logout',
		'forgot_password',
		'change_password',
		'verify',
		'my',
		'register',
		'checkLogin',
		'restricted',
		'reverify',
		);


	public function __construct($request = null, $response = null) {
		parent::__construct($request, $response);
		if (in_array('Invite', CakePlugin::loaded())) {
			$this->components[] = 'Invite.InviteHandler';
		}
		if (in_array('Recaptcha', CakePlugin::loaded())) {
			$this->helpers[] = 'Recaptcha.Recaptcha';
		}
		if (in_array('Facebook', CakePlugin::loaded())) {
			$this->helpers[] = 'Facebook.Facebook';
			$this->uses[] = 'Facebook.Facebook';
		}
	}

/**
 * index method
 */
	public function index() {
		$this->paginate['fields'] = array(
			'User.id',
			'User.first_name',
			);
		$this->paginate['conditions'] = array(
			'not' => array(
				'User.id' => '1'
			)
		);
		$this->set('users', $this->paginate());
		$this->set('displayName', 'first_name');
		$this->set('displayDescription', '');
		$this->set('indexClass', '');
		$this->set('showGallery', true);
		$this->set('galleryForeignKey', 'id');
		$this->set('pageActions', array(
			array(
				'linkText' => 'Create',
				'linkUrl' => array(
					'action' => 'add',
					),
				),
			array(
				'linkText' => 'Archived',
				'linkUrl' => array(
					'action' => 'index',
					'archived' => 1,
					),
				),
			));
	}

/**
 * view method
 */
	public function view($id) {
		$user = $this->User->find('first', array(
			'conditions' => array(
				'User.id' => $id
				),
			'contain' => array(
				'UserGroup',
				),
			));

		// This is here, because we have an element doing a request action on it.
		if (isset($this->request->params['requested'])) {
        	if (!empty($user)) {
				return $user;
			}
        }

		// check if user exists
		if(!isset($user['User'])) {
			//	$this->Session->setFlash('You do not have a user, please create one.');
			//	$this->redirect(array('plugin' => 'users', 'controller' => 'users', 'action' => 'register', 'user' => $this->Auth->user('id')));
		}

		$followedUsers = $this->User->UserFollower->find('all', array(
			'conditions' => array(
				'UserFollower.follower_id' => $user['User']['id'],
				),
			));

		// Setup the user ids which we'll find the statuses of
		foreach ($followedUsers as $followedUser) {
			//$followedUserIds[] = $followedUser['User']['id'];
			$statusUserIds[] = $followedUser['UserFollower']['user_id'];
		}
		$statusUserIds[] = $user['User']['id'];

		// get the statuses for display
		$statuses = $this->User->UserStatus->find('all' , array(
			'conditions'=>array(
				'UserStatus.user_id' => $statusUserIds,
				),
			'contain'=>array(
				'User',
				),
			'order' => array(
				'UserStatus.created DESC'
				),
			));


		// get the wall of the user
		$walls = $this->User->UserWall->find('all' , array(
			'conditions'=>array(
				'UserWall.creator_id' => $user['User']['id'],
			),
			'contain'=>array(
				'Creator' , 'Owner'
			),
			'order'=>array('UserWall.creator_id')
		));

		// Get the users followers
		$followers = $this->User->UserFollower->find('all' , array(
			'conditions'=>array(
				'UserFollower.user_id' => $user['User']['id'],
			),
			'contain'=>array(
				'User'
			)
		));

		// does the logged in user follow
		$does_follow = $this->User->UserFollower->find('count', array(
			'conditions'=>array(
				'UserFollower.user_id' => $user['User']['id'],
				'UserFollower.follower_id' => $this->Auth->user('id'),
			),
			'contain'=>array()
		));
		
		$friends = array_intersect($followedUsers, $followers);

		$is_self = ($user['User']['id'] == $this->Auth->user('id') ? true : false);
		$this->set('is_self', $is_self );
		$this->set('uid' , $user['User']['id']);
		$this->set('walls' , $walls);
		$this->set('followedUsers', $followedUsers);
		$this->set('followers' , $followers);
		$this->set('statuses' , $statuses);
		$this->set('does_follow' , $does_follow);
		$this->set('user', $user);
		$this->set('friends', $friends);
	}

/**
 * edit method
 */
	public function edit($id = null, $forcePw = null) {
		if ($forcePw > 0) {
			$this->view = 'edit_pwd';
		}
		// looking for an existing user to edit
		if (!empty($this->request->params['named']['user_id'])) {
			$conditions = array('User.id' => $this->request->params['named']['user_id']);
		} else if (!empty($id)) {
			$conditions = array('User.id' => $id);
		} else {
			$conditions = array('User.id' => $this->Session->read('Auth.User.id'));
		}
		if (empty($this->request->data) && (!empty($this->request->params['named']['user_id']) || !empty($id))) {
			$user = $this->User->find('first',array(
				'conditions' => $conditions,
				));
			if(isset($user['User'])) {
				$this->request->data = $user;
			} else {
				$this->request->data = $this->User->read(null, $id);
			}
		// saving a user which was edited
		} else if(!empty($this->request->data)) {
			$this->request->data['User']['user_id'] = $this->Auth->user('id');
			//getting password issue when saving ; so unsetting in this case
			if(!isset($this->request->data['User']['password']))	{
				unset($this->User->validate['password']);
			}
			if(!empty($this->request->data['User']['avatar'])) {
				// upload image if it was set
				$this->request->data['User']['avatar_url'] = $this->Upload->image($this->request->data['User']['avatar'], 'users', $this->Session->read('Auth.User.id'));
			}
			debug($this->request->data);
			break;
			try {
				$this->User->save($this->request->data);
				$this->Session->setFlash('User Updated!');
				$this->redirect(array('plugin' => 'users', 'controller' => 'users', 'action' => 'view', $this->User->id), true);
			} catch(Exception $e){
				$this->Session->setFlash('There was an error updating user' . $e);
			}
		} else {
			$this->Session->setFlash('Invalid user');
		}
		$this->set('userRoles',  $this->User->UserRole->find('list'));
	}


/**
 * Register method
 */
	public function register() {
		// force ssl for PCI compliance during regristration and login
		if (defined('__TRANSACTIONS_SSL') && !strpos($_SERVER['HTTP_HOST'], 'localhost')) : $this->Ssl->force(); endif;

		if (!empty($this->request->data)) {
			if ($this->User->saveAll($this->request->data)) {
				if (defined('__APP_REGISTRATION_EMAIL_VERIFICATION')) {
					$this->Session->setFlash(__('Success, please check your email'));
					$this->Auth->logout();
				} else {
					$this->Session->setFlash(__('Successful Registration'));
					$this->_login();
				}
			} else {
				$this->Session->setFlash(ZuhaInflector::flatten($this->User->validationErrors));
				$this->Auth->logout();
			}


		}
		// view vars
		$userRoles = $this->User->UserRole->find('list');
		unset($userRoles[1]); // remove the administrators group by default - too insecure
		$userRoleId = defined('__APP_DEFAULT_USER_REGISTRATION_ROLE_ID') ? __APP_DEFAULT_USER_REGISTRATION_ROLE_ID : 3;
		$this->request->data['Contact']['id'] = !empty($this->request->params['named']['contact']) ? $this->request->params['named']['contact'] : null;

		$this->set(compact('userRoleId', 'userRoles'));
		$this->set('contactTypes', array('person' => 'person', 'company' => 'company'));
	}

/**
 * Delete method
 */
	public function delete($id) {
		$this->__delete('User', $id);
	}

/**
 * Dashboard method
 */
	public function dashboard() {
	}

/**
 * Settings method
 * 
 * @todo this is site specific (apca), it is left in the core app so that we can easily refer to it
 * @todo if we choose to expand on and use this idea. Just make sure to copy the funciton and view file, as is, to the site first.
 */
 	public function settings() {
 		$methods = array(
 			'racApply' => 'racApply',
 			'articleSubmissionForm' => 'articleSubmissionForm',
			'awardNominationForm' => 'awardNominationForm',
			'showcaseApplication' => 'showcaseApplication',
			'conferenceRegistration' => 'conferenceRegistration',
			'buyerEventRegistration' => 'buyerEventRegistration',
			'militaryConferenceRegistration' => 'militaryConferenceRegistration',
			);
		$this->set(compact('methods'));
 		// data gets submitted to /settings/add
 		if (defined('__USERS_EMAILS')) {
			$emails = json_decode(stripcslashes(json_encode(unserialize(__USERS_EMAILS))), true);
 			$this->request->data['Setting']['value'] = $emails;
 		}
 	}

/**
 * Restricted method
 *
 * A page to stop infinite redirect loops when there are errors.
 */
	public function restricted() {
	}

/**
 * My method
 * 
 * Redirects to the users/view function for the logged in user.
 */
	public function my() {
		$userId = $this->Session->read('Auth.User.id');
		if($userId == null || $userId == __SYSTEM_GUESTS_USER_ROLE_ID) {
			$this->redirect(array('plugin' => 'users', 'controller' => 'users', 'action' => 'login'));
		}
		if (!empty($userId)) {
			$this->redirect(array('plugin' => 'users', 'controller' => 'users', 'action' => 'view', $userId));
		} else {
			$this->Session->setFlash('Please Login');
			$this->redirect($this->User->loginRedirectUrl($this->Auth->redirect()));
		}
	}


/**
 * Login method
 * 
 * Public login function to verify access to restricted areas.
 */
	public function login() {
		// force ssl for PCI compliance during regristration and login
		if (defined('__TRANSACTIONS_SSL') && !strpos($_SERVER['HTTP_HOST'], 'localhost')) : $this->Ssl->force(); endif;

		if (!empty($this->request->data)) {
			$this->_login();
		}
		$userRoles = $this->User->UserRole->find('list');
		unset($userRoles[1]); // remove the administrators group by default - too insecure
		$userRoleId = defined('__APP_DEFAULT_USER_REGISTRATION_ROLE_ID') ? __APP_DEFAULT_USER_REGISTRATION_ROLE_ID : null;
		$this->set(compact('userRoleId', 'userRoles'));
		if (empty($this->templateId)) {
			 $this->layout = 'login'; 
		}
	}

/**
 * Protected Login method
 * 
 * @param array $user
 * @param bool $forceUrl forces login redirect url
 */
	protected function _login($user = null, $forceUrl = false) {		
		// log user in
		if ($this->Auth->login($user)) {
			try {
				$cookieData = $this->request->data;
				// make sure you don't need to verify your email first
				$this->User->checkEmailVerification($this->request->data);
				// save the login meta data
				$this->User->loginMeta($this->request->data);
				
				if (in_array('Connections', CakePlugin::loaded())) {
					$this->User->Connection->afterLogin($user['User']['id']);
				}
				// Create a remember me login cookie for two weeks if checked
				if ($this->request->data['User']['rememberMe'] == 1) {
			        // After what time frame should the cookie expire
			        $cookieTime = '2 weeks'; // You can do e.g: 1 week, 17 weeks, 14 days
				 
				    // remove "remember me checkbox"
				    unset($this->request->data['User']['rememberMe']);
				                 
				    // hash the user's password
				    $cookieData['User']['password'] = $this->Auth->password($cookieData['User']['password']);
				                 
				    // write the cookie
				    $this->Cookie->write('rememberMe', $cookieData['User'], true, $cookieTime);
				}
				if($forceUrl) {
					$this->redirect($this->User->loginRedirectUrl('/'));
				}else {
					$this->redirect($this->User->loginRedirectUrl($this->Auth->redirect()));
				}
			} catch (Exception $e) {
				$this->Auth->logout();
				$this->Session->setFlash($e->getMessage());
		        $this->redirect($this->User->logoutRedirectUrl());
			}
	    } else {
	        $this->Session->setFlash(__('Username or password is incorrect'), 'default', array(), 'auth');
	    }
	}

/**
 * Logout method
 */
    public function logout() {
		if ($this->Auth->logout() || $this->Session->delete('Auth')) {
			$this->Session->destroy();
			$this->Cookie->destroy('rememberMe');
			$this->Session->setFlash('Successful Logout');
			$this->redirect($this->User->logoutRedirectUrl());
		} else {
			$this->Session->setFlash('Logout Failed');
			$this->redirect($this->User->loginRedirectUrl());
		}
    }


/**
 * Check login method
 *
 * Used in the ajax-login element to return whether the user is logged in.
 */
	public function checkLogin() {
		$this->layout = false;
		$this->autoRender = false;
        $user = $this->User->find('first', array('conditions' => array('User.username' => $this->request->data['User']['username'], 'User.password' => AuthComponent::password($this->request->data['User']['password']))));
     	if($user){
     		$data['login'] = 1;
		} else {
		    $data['login'] = 0;
		}
		echo json_encode($data);
    }


/**
 * Desktop Login method
 * 
 * Login method used for desktop app integration.
 *
 * @todo 		This should be updated to some kind of API login (maybe REST) so that any apps can authenticate.
 */
	public function desktop_login() {
        $user = $this->User->find('first', array('conditions' => array('username' => $this->request->data['User']['username'],'password' => AuthComponent::password($this->request->data['User']['password']))));
        if(!empty($user)){
        	$this->set('data', $user['User']['id']);
			$this->layout = false;
			//$this->render(false);
		} else {
        	$this->set('data', "Fail");
			$this->layout = false;
			//$this->render(false);
		}
    }


/**
 * Resend verification method
 *
 * @return void
 */
 	public function reverify() {
		if(!empty($this->request->data)) {
			try {
				$this->User->welcome($this->request->data['User']['username']);
				$this->Session->setFlash('Verification email resent.');
			} catch (Exception $e) {
				$this->Session->setFlash($e->getMessage());
			}
		}
	}



/**
 * Verify method
 * 
 * Used same column `forgot_key` for storing key. It starts with W for activation, F for forget
 *
 * @todo 	change the column name from forgot_key to something better, like maybe just "key"
 */
	public function verify($key = null) {
		$user = $this->User->verify_key($key);
		if ($user) {
			if ($key[0] == 'W') {
				$this->Session->setFlash('Welcome, successful account verification. Please login.');
				$this->redirect(array('action'=>'login'));
			} else {
				$this->Session->setFlash('Successful account verification, change your password.');
				$this->redirect(array('action' => 'change_password', $user['User']['password'], $user['User']['id']));
			}
		} else {
			$this->Session->setFlash('Reset code invalid, expired or already used, please try again.');
			$this->redirect(array('action' => 'forgot_password'));
		}
	}

/**
 * Change password method
 *
 * @todo For time's sake used the password instead of a key.  This should be changed, but the key gets deleted from the verify() function so that needs to be rewritten too.
 */
	public function change_password($userPassword = null, $userId = null) {
		if (!empty($this->request->data)) {
			$this->User->id = $this->request->data['User']['id'];
			if (!$this->User->exists()) {
				throw new NotFoundException(__('Invalid user'));
			}
			if ($this->User->save($this->request->data)) {
				$this->Session->setFlash('Password changed.');
				$this->_login();
			} else {
				$this->Session->setFlash('Password could not be changed.');
				$this->redirect(array('action' => 'forgot_password'));
			}
		}

		$user = $this->User->find('first', array('conditions' => array('User.password' => $userPassword, 'User.id' => $userId)));
		if (!empty($user)) {
			$this->request->data = $user;
		} else {
			$this->Session->setFlash('Invalid User Key');
			$this->redirect(array('action' => 'forgot_password'));
		}
	}


/**
 * Forgot Password method
 * Used to send a password reset key to the user's email address on file.
 *
 * @todo			This message needs to be configurable.
 */
	public function forgot_password() {
		if(!empty($this->request->data)) {
			// we need to check the username field and the email field
		  	$user = $this->User->findbyUsername(trim($this->request->data['User']['username']));
			if (!empty($user['User']['id']) && !empty($user['User']['email'])) {
				// the user details exist
				// so first lets update the user record with a temporary uid key to use for resetting password
				$forgotKey = $this->User->resetPassword($user['User']['id']);
				if (!empty($forgotKey)) {
					// then lets email the user a link to the reset password page
					$this->set('name', $user['User']['full_name']);
					$this->set('key', $forgotKey);
					$url = Router::url(array('plugin' => 'users', 'controller' => 'users', 'action' => 'verify', $forgotKey), true);
					$mail =
		"Dear {$user['User']['full_name']},
<br></br><br></br>
    A reset of your password was requested.
<br></br><br></br>
    To complete the reset please follow the link below or copy it to your browser address bar:
<br></br><br></br>
{$url}<br></br>
If you have received this message in error please ignore, the link will be unusable in three days.";
					if ($this->__sendMail($user['User']['email'] , 'Password reset', $mail, 'password_reset')) {
						$this->Session->setFlash('Password reset email sent to email ending with ******'. substr($user['User']['email'], -9));
					} else {
						$this->Session->setFlash('Reset email could not be sent. Please try again.');
					}
				} else {
					$this->Session->setFlash('Password could not be reset, please try again.');
				}
			} else if (!empty($user['User']['id']) && empty($user['User']['email'])) {
				$this->Session->setFlash('Email does not exist for this user.');
			} else {
				$this->Session->setFlash('Invalid user.');
			}
		}
	}
}

if (!isset($refuseInit)) {
	class UsersController extends _UsersController {}
}