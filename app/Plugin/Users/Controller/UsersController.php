<?php
/**
 * Users Controller
 *
 * Handles variables supplied from the Model, to be sent to the view for users.
 *
 * PHP versions 5
 *
 * Zuha(tm) : Business Management Applications (http://zuha.com)
 * Copyright 2009-2010, Zuha Foundation Inc. (http://zuha.org)
 *
 * Licensed under GPL v3 License
 * Must retain the above copyright notice and release modifications publicly.
 *
 * @copyright     Copyright 2009-2010, Zuha Foundation Inc. (http://zuha.com)
 * @link          http://zuha.com Zuha� Project
 * @package       zuha
 * @subpackage    zuha.app.models
 * @since         Zuha(tm) v 0.0.1
 * @license       GPL v3 License (http://www.gnu.org/licenses/gpl.html) and Future Versions
 * @todo		  The "view" method needs a requestAction fix so that requestAction works for all requestAction type calls, without the if params['requested'] thing being necessary everyhwere we want to do that. 
 */
class UsersController extends UsersAppController {
	
	var $name = 'Users';
	var $uid;
	var $components = array('Email','Invite.InviteHandler');
	var $allowedActions = array(
		'login', 
		'desktop_login', 
		'logout',
		'forgot_password', 
		'reset_password', 
		'my', 
		'register', 
		'checkLogin', 
		'restricted'
		);
	
	/**
	 * A page to stop infinite redirect loops when there are errors. 
	 */
	public function restricted() {
	}
	
	/**
	 * Public login function to verify access to restricted areas.
	 */
	public function login() {  
		if (!empty($this->request->data)) {
			if ($this->Auth->login()) {
				try {
					$this->User->loginMeta($this->request->data);
	        		return $this->redirect($this->Auth->redirect());
				} catch (Exception $e) {
					$this->Session->setFlash($e->getMessage());
					$this->Auth->logout();
				}
		    } else {
		        $this->Session->setFlash(__('Username or password is incorrect'), 'default', array(), 'auth');
		    }
		}
	}


    public function logout() {
		if ($this->Auth->logout() || $this->Session->delete('Auth')) : 
			$this->Session->setFlash('Successful Logout');
			$this->redirect($this->_logoutRedirect());
		else : 
			$this->Session->setFlash('Logout Failed');
			$this->redirect($this->_loginRedirect());
		endif;			
    }
	
	
	/**
	 * Set the default redirect variables, using the settings table constant.
	 */
	function _loginRedirect() {
		if (defined('__APP_DEFAULT_LOGIN_REDIRECT_URL')) {
			if ($urlParams = @unserialize(__APP_DEFAULT_LOGIN_REDIRECT_URL)) {
				return $urlParams;
			} else {
				return __APP_DEFAULT_LOGIN_REDIRECT_URL;
			}
		} else {
			return array(
				'plugin' => 'users',
				'controller' => 'users',
				'action' => 'my',
			);
		}
	}
	
	/**
	 * Set the default redirect variables, using the settings table constant.
	 */
	function _logoutRedirect() {
		if (defined('__APP_LOGOUT_REDIRECT_URL')) {
			if ($urlParams = @unserialize(__APP_LOGOUT_REDIRECT_URL)) {
				return $urlParams;
			} else {
				return __APP_LOGOUT_REDIRECT_URL;
			}
		} else {
			return array(
				'plugin' => 'users',
				'controller' => 'users',
				'action' => 'login',
			);
		}
	}
	
	
	function checkLogin() {
		$this->layout = false;
		$this->autoRender = false; 	
        $user = $this->User->find('first', array('conditions' => array('username' => $this->request->data['User']['username'],'password' => $this->request->data['User']['password'])));	
     	if($user){
     		$data['login'] = 1;
		} else {
		    $data['login'] = 0;
		}	
		echo json_encode($data);
    }
	
	/**
	 * Used for Zuha Desktop integration. 
	 * 
	 * @todo 		This should be updated to some kind of API login (maybe REST) so that any apps can authenticate.
	 */
	function desktop_login() { 	
        $user = $this->User->find('first', array('conditions' => array('username' => $this->request->data['User']['username'],'password' => $this->request->data['User']['password'])));	
        if($user!= null ){
	        echo $user['User']['id']; 
			$this->render(false);	    
		} else{
		    echo "Fail";
			$this->render(false);
		}	
    }
	
	function my() {
		$userId = $this->Session->read('Auth.User.id');
		if (!empty($userId)) {
			$this->redirect(array('plugin' => 'users', 'controller' => 'users', 'action' => 'view', $userId));
		} else {
			$this->Session->setFlash('No Session');
			$this->redirect('/');
		}
	}
			
	
	function view($id) {
		$user = $this->User->find('first', array('conditions' => array('User.id' => $id)));
		
		# This is here, because we have an element doing a request action on it.
		if (isset($this->request->params['requested'])) {
        	if (!empty($user)) {
				return $user;
			} 
        } 
		
		// check if user exists 
		if(!isset($user['User'])) {
		#	$this->Session->setFlash('You do not have a user, please create one.');
		#	$this->redirect(array('plugin' => 'users', 'controller' => 'users', 'action' => 'register', 'user' => $this->Auth->user('id')));
		}
		
		$followedUsers = $this->User->UserFollower->find('all', array(
			'conditions' => array(
				'UserFollower.follower_id' => $user['User']['id'],
				),
			));
		
		# Setup the user ids which we'll find the statuses of
		foreach ($followedUsers as $followedUser) {
			#$followedUserIds[] = $followedUser['User']['id'];
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
			'limit' => 10,
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
		
		
		$is_self = ($user['User']['id'] == $this->Auth->user('id') ? true : false);
		$this->set('is_self', $is_self );
		$this->set('uid' , $user['User']['id']);
		$this->set('walls' , $walls);
		$this->set('followedUsers', $followedUsers);
		$this->set('followers' , $followers);
		$this->set('statuses' , $statuses);
		$this->set('does_follow' , $does_follow);
		$this->set('user', $user);
	}

	function index() {
		$this->User->recursive = 0;
		$this->set('users', $this->paginate());
	}
	
	function edit($id = null) {
		# looking for an existing user to edit
		if (!empty($this->request->params['named']['user_id'])) {
			$conditions = array('User.user_id' => $this->request->params['named']['user_id']);
		} else if (!empty($id)) {
			$conditions = array('User.id' => $id);
		} else {
			$conditions = array('User.user_id' => $this->Session->read('Auth.User.id'));
		}
		if (empty($this->request->data) && (!empty($this->request->params['named']['user_id']) || !empty($id))) {
			$user = $this->User->find('first',array(
				'conditions' => $conditions,
			));
			
			$userShippingAddress = $this->User->OrderShipment->find('first',array(
				'conditions' => array('OrderShipment.user_id' => $id, 
							'OrderShipment.order_transaction_id is null')
				));
			$user['OrderShipment'] = $userShippingAddress['OrderShipment'];
			$userBillingAddress = $this->User->OrderPayment->find('first',array(
				'conditions' => array('OrderPayment.user_id' => $id, 
						'OrderPayment.order_transaction_id is null')
			)); 
			$user['OrderPayment'] = $userBillingAddress['OrderPayment'];
			
			if(isset($user['User'])) {
				$this->request->data = $user;
			} else {
				$this->request->data = $this->User->read(null, $id);
			}
		# saving a user which was edited
		} else if(!empty($this->request->data)) {
			$this->request->data['User']['user_id'] = $this->Auth->user('id');
			if(!empty($this->request->data['User']['avatar'])) {
				# upload image if it was set
				$this->request->data['User']['avatar_url'] = $this->Upload->image($this->request->data['User']['avatar'], 'users', $this->Session->read('Auth.User.id'));
			}
			if($this->User->save($this->request->data)) {
				$this->User->OrderPayment->save($this->request->data);
				$this->User->OrderShipment->save($this->request->data);	
				$this->Session->setFlash('User Updated!');
				$this->redirect(array('plugin' => 'users', 'controller' => 'users', 'action' => 'view', $this->User->id));
			}
			else {
				$this->Session->setFlash('There was an error updating user');
			}
		} else {
			$this->Session->setFlash('Invalid user');
		}
	}

	
	/**
	 * @todo	Not sure I like the use of contact in the url being possible.  My guess is that you could change the id and register as a different contact, and probably gain access to things you shouldn't.  Maybe switch to some kind of Security::cipher thing.  (on second thought, the database having a unique index on contact_id might keep this from happening)
	 */
	function register() {
		if (!empty($this->request->data)) {
			try {
				$result = $this->User->add($this->request->data);
				if ($result === true) {
					$this->Session->setFlash(__d('users', 'Successful Registration', true));
					$this->redirect(array('plugin' => 'users', 'controller' => 'users', 'action' => 'login'));				
				} else {
					$this->request->data = $result;
				}
			} catch (Exception $e) {
				# if registration verification is required the model will return this code
				if ($e->getCode() == 834726476) {
					if ($this->_welcome($this->User->id)) {
						$this->Session->setFlash($e->getMessage());
						$this->Auth->logout();
					} else {
						$this->Session->setFlash(__('User saved, but a problem sending verification. Use forgot password, to resend.', true));
						$this->Auth->logout();
					}
				} else {
					$this->Session->setFlash($e->getMessage());
					$this->Auth->logout();
				}
			}
		}		
		
		$userRoles = $this->User->UserRole->find('list');
		unset($userRoles[1]); // remove the administrators group by default - too insecure
		$userRoleId = defined('__APP_DEFAULT_USER_REGISTRATION_ROLE_ID') ? __APP_DEFAULT_USER_REGISTRATION_ROLE_ID : null;
		$this->set(compact('userRoleId', 'userRoles'));
		
		if (empty($userRoleId)) : 
			echo '__APP_DEFAULT_USER_REGISTRATION_ROLE_ID must be defined for public user registrations to work.';
			break;
		endif;
		
		$this->request->data['Contact']['id'] = !empty($this->request->params['named']['contact']) ? $this->request->params['named']['contact'] : null;
		$this->set('contactTypes', array('person' => 'person', 'company' => 'company'));
	}


	/*
	 * __welcome()
	 * User can now register and then wait for an email confirmation to activate his account. 
	 * If he doesn't activate his account, he cant access the system. The key expires in 3 days.
	 * @todo		temp change for error in swift mailer
	 * @todo		This message needs to be configurable.
	 * @todo		This needs to have the ability to resend in case the user didn't get it the first time or something.
	 */
	function _welcome($user_id) {
		$this->User->recursive = -1;
		$user = $this->User->read(null, $user_id);
		if (!$user)
			return false;
		
		$this->set('name', $user['User']['full_name']);
		$this->set('key', $user['User']['forgot_key']);
		// todo: temp change for error in swift mailer
		$url =   Router::url(array('controller'=>'users', 'action'=>'reset_password', $user['User']['forgot_key']), true);
		$mail = 
		"Dear {$user['User']['full_name']},
<br></br><br></br>
    Congratulations! You have created an account with us.
<br></br><br></br>
    To complete the registration please activate your account by following the link below or by copying it to your browser:
<br></br><br></br>
{$url}<br></br>
If you have received this message in error please ignore, the link will be unusable in three days.
<br></br><br></br>
    Thank you for registering with us and welcome to the community.";
		
		return $this->__sendMail($user['User']['email'] , 'Welcome', $mail, 'welcome');
	}
	
	
	function _admin_edit($id = null) {
		if (empty($this->request->data)) {
			$this->request->data = $this->User->read(null, $id);
			$userRoles = $this->User->UserRole->find('list');
			$this->set(compact('userRoles'));
		} else if(!empty($this->request->data)) {
			if($this->User->add($this->request->data)) {
				$this->Session->setFlash('User Updated!');
				$this->redirect(array('plugin' => 'users', 'controller' => 'users', 'action' => 'view', $this->User->id));
			} else {
				$this->Session->setFlash('There was an error updating user');
			}
		} else {
			$this->Session->setFlash('Invalid user');
		}
	}
	

	function __resetPasswordKey($userid) {
		$user = $this->User->find('first', array('conditions' => array('id' => $userid))); 
		unset($this->request->data['User']['username']);
		$this->request->data['User']['id'] = $userid;
		$this->request->data['User']['forgot_key'] = $this->User->__uid('F'); 
		$this->request->data['User']['forgot_key_created'] = date('Y-m-d h:i:s');
		$this->request->data['User']['forgot_tries'] = $user['User']['forgot_tries'] + 1;
		$this->request->data['User']['user_role_id'] = $user['User']['user_role_id'];
		$this->User->Behaviors->detach('Translate');
		if ($this->User->save($this->request->data, array('validate' => false))) {
			return $this->request->data['User']['forgot_key'];
		} else {
			return false;
		}
	}


	/*
	 * Used same column `forgot_key` for storing key. It starts with W for activation, F for forget
	 * @todo 	change the column name from forgot_key to something better, like maybe just "key"
	 */
	function reset_password($key = null) {
		$user = $this->User->verify_key($key);
		if ($user) {
			$this->Auth->login($user);
			$this->User->loginMeta($user);
			if ($key[0] == 'W') {
				$this->Session->setFlash('Successful account verification, Welcome.');
				$this->redirect(array('action'=>'login'));
			} else {
				$this->Session->setFlash('Successful account verification, change your password.');
				$this->redirect(array('action'=>'edit', $user['User']['id']));
			}
		}
		else {
			$this->Session->setFlash('Reset code invalid, expired or already used, please try again.');
			$this->redirect(array('action'=>'forgot_password'));
		}
	}
	
	
	/**
	 * Forgot Password
	 * Used to send a password reset key to the user's email address on file.
	 *
	 * @todo			This message needs to be configurable.
	 */
	function forgot_password() {
		if(!empty($this->request->data))	{
			# we need to check the username field and the email field
		  	$user = $this->User->findbyUsername(trim($this->request->data['User']['username']));
			if (!empty($user['User']['id']) && !empty($user['User']['email'])) {
				# the user details exist 
				# so first lets update the user record with a temporary uid key to use for resetting password
				$forgotKey = $this->__resetPasswordKey($user['User']['id']);
				if (!empty($forgotKey)) {
					# then lets email the user a link to the reset password page
					$this->set('name', $user['User']['full_name']);
					$this->set('key', $forgotKey);
					$url = Router::url(array('controller'=>'users', 'action'=>'reset_password', $forgotKey), true);		
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
	
	
	function delete($id) {
		$this->__delete('User', $id);
	}
	
	
}
?>