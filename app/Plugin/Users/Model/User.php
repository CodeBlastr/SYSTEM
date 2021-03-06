<?php
App::uses('UsersAppModel', 'Users.Model');
/**
 *@property UserGroup UserGroup
 *@property Contact Contact
 *@property UserFollower UserFollower
 */
class AppUser extends UsersAppModel {

	public $name = 'User';

	public $displayField = 'full_name';

	public $actsAs = array(
		'Acl' => array('type' => 'requester'),
		'Users.Usable' => array('defaultRole' => 'friend'),
		'Galleries.Mediable',
		);

/**
 * Auto Login setting, used to skip session write in aftersave
 */
	public $autoLogin = true;

	public $validate = array(
		'password' => array(
			'notempty' => array(
				'rule' => 'notEmpty',
				'allowEmpty' => false,
				'message' => 'Please enter a value for password',
				'required' => 'create'
				),
			'comparePassword' => array(
				'rule' => array('_comparePassword'),
				'allowEmpty' => true,
				'message' => 'Password, and confirm password fields do not match.',
				),
        	'strongPassword' => array(
				'rule' => array('_strongPassword'),
				'allowEmpty' => true,
				'message' => 'Password should be six characters, contain numbers and capital and lowercase letters.',
				),
        	'newPassword' => array(
				'rule' => array('_newPassword'),
				'allowEmpty' => true,
				'message' => 'Your old password is incorrect.'
				),
			),
		'username' => array(
			'notempty' => array(
				'rule' => 'notEmpty',
				'allowEmpty' => false,
				'message' => 'Please enter a value for username/email',
				'required' => 'create' // field key User.username must be present during User::create
				),
			'isUnique' => array(
				'rule' => 'isUnique',
				'message' => 'This username belongs to someone else. Please try again.',
				'allowEmpty' => true
				),
			),
		'email' => array(
			'emailRequired' => array(
				'rule' => array('_emailRequired'),
				'message' => 'Email required for registration, Please try again.',
				'allowEmpty' => true
				),
			),
			'email' => array(
        		'rule'    => 'email',
        		'message' => 'Please supply a valid email address.',
				'allowEmpty' => true
    		),
		'user_role_id' => array(
			'isRegisterable' => array(
				'rule' => array('_isRegisterable'),
				'message' => 'Invalid user role. Public registration restricted.',
				'allowEmpty' => false,
				'required' => 'create',
				'on' => 'create'
				),
			),
		);

	public $belongsTo = array(
		'UserRole' => array(
			'className' => 'Users.UserRole',
			'foreignKey' => 'user_role_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
			),
		'Self' => array(
			'className' => 'Users.User',
			'foreignKey' => 'id',
			'conditions' => '',
			'fields' => array('id'),
			'order' => ''
			),
		'Parent' => array(
			'className' => 'Users.User',
			'foreignKey' => 'parent_id'
			)
		);

	public $hasMany = array(
		'Child' => array(
			'className'     => 'Users.User',
			'foreignKey'    => 'parent_id',
			'dependent'		=> false
			),
		'Gallery' => array(
			'className' => 'Galleries.Gallery',
			'foreignKey' => 'foreign_key',
			'dependent' => true
			),
		'UserStatus' => array(
			'className' => 'Users.UserStatus',
			'foreignKey' => 'user_id',
			'dependent' => true
			),
		'UserFollower' => array(
			'className' => 'Users.UserFollower',
			'foreignKey' => 'user_id',
			'dependent' => false
			),
		'UserFollowed' => array(
			'className' => 'Users.UserFollower',
			'foreignKey' => 'follower_id',
			'dependent' => false
			),
		'UserGroupWallPost' => array(
			'className' => 'Users.UserGroupWallPost',
			'foreignKey' => 'creator_id',
			'dependent' => false
			),
		'UsersUserGroup' => array(
			'className' => 'Users.UsersUserGroup',
			'foreignKey' => 'user_id',
			'dependent' => true
			)
		);

	public $hasOne = array(
		'UserWall' => array(
			'className' => 'Users.UserWall',
			'foreignKey' => 'user_id',
			'dependent' => true
			),
		'Contact' => array(
			'className' => 'Contacts.Contact',
			'foreignKey' => 'user_id',
			'dependent' => false
			),
		// I wonder if something like this will work so that
		// in the privileges section we can limit editing a profile
		// to the owner.  I worry about the foreignKey as
		// 'id' causing some loop that breaks everything. 12/8/2013 RK
		// 'Owner' => array(
			// 'className' => 'Users.User',
			// 'foreignKey' => 'id',
			// 'dependent' => false
			// )
		);

	public $hasAndBelongsToMany = array(
        'UserGroup' => array(
			'className' => 'Users.UserGroup',
			'joinTable' => 'users_user_groups',
			'foreignKey' => 'user_id',
			'associationForeignKey' => 'user_group_id',
			'dependent' => true,
			),
        'Follower' => array(
			'className' => 'Users.User',
			'joinTable' => 'user_followers',
			'foreignKey' => 'user_id',
			'associationForeignKey' => 'follower_id',
			'dependent' => true,
			),
        'Following' => array(
			'className' => 'Users.User',
			'joinTable' => 'user_followers',
			'foreignKey' => 'follower_id',
			'associationForeignKey' => 'user_id',
			'dependent' => true,
			),
		);

	public function __construct($id = false, $table = null, $ds = null) {
		$this->order = array($this->alias.'.last_name', $this->alias.'.full_name', $this->alias.'.first_name');

		if(CakePlugin::loaded('Media')) {
			$this->actsAs[] = 'Media.MediaAttachable';
		}
		if(CakePlugin::loaded('Subscribers')) {
			$this->actsAs[] = 'Subscribers.Subscribable';
		}
		if (CakePlugin::loaded('Transactions')) {
			$this->hasMany['TransactionAddress'] = array(
				'className' => 'Transactions.TransactionAddress',
				'foreign_key' => 'user_id'
				);
		}
		if (CakePlugin::loaded('Connections')) {
			$this->hasMany['Connection'] = array(
				'className' => 'Connections.Connection',
				'foreignKey' => 'user_id',
				'dependent' => true
				);
		}
		if (CakePlugin::loaded('Categories')) {
			$this->actsAs[] = 'Categories.Categorizable';
		}
		parent::__construct($id, $table, $ds);
		
		// default ordering
		$this->order = array($this->alias . '.last_name', $this->alias . '.full_name', $this->alias . '.first_name');
	}

/**
 * Is Registerable User Role
 *
 * Checks to make sure user role is allowed to be registered.
 * @return bool
 * @todo It would be cool if we looked up who can bypass this function by
 * seeing if the current user has access to the UsersController::procreate()
 * method.
 */
	public function _isRegisterable() {
		$userRoleId = CakeSession::read('Auth.User.user_role_id');
		if ($userRoleId == 1) {
			return true; // admin user over ride
		}
		$userRole = $this->UserRole->find('count', array('conditions' => array('UserRole.id' => $this->data['User']['user_role_id'], 'UserRole.is_registerable' => 1)));
		if (!empty($userRole)) {
			return true;
		}
		return false;
	}

/**
 * Compare Password
 *
 * Matching password test.
 * @return bool
 */
	public function _comparePassword() {
		// fyi, confirm password is hashed in the beforeValidate method
		if (isset($this->data['User']['confirm_password']) &&
				($this->data['User']['password'] == $this->data['User']['confirm_password'])) {
			return true;
		} else if (!isset($this->data['User']['confirm_password'])) {
			// if confirm_password isn't in the form fields then we aren't updating passwords
			return true;
		} else {
			return false;
		}
	}

/**
 * Strong Password
 *
 * Password strength test
 * @return bool
 */
    public function _strongPassword() {
        return preg_match('/^((?=.*[^a-zA-Z])(?=.*[a-z])(?=.*[A-Z])(?!.*\s).{6,})$/', $this->data['User']['password']);
    }

/**
 * New Password
 *
 * Confirm old password before allowing a password change
 * @return bool
 */
    public function _newPassword() {
		if (!empty($this->data[$this->alias]['current_password'])) {
			$user = $this->find('count', array('callbacks' => false, 'conditions' => array('User.id' => $this->_getUserId($this->data['User']), 'User.password' => AuthComponent::password($this->data[$this->alias]['current_password']))));
			return $user === 1 ? true : false;
		}
		return true;
    }

/**
 * Email Required
 *
 * Check if email is required
 * @return bool
 */
	public function _emailRequired() {
		if (defined('__APP_REGISTRATION_EMAIL_VERIFICATION') && empty($this->data['User']['email'])) {
			return false;
		} else {
			return true;
		}
	}

/**
 * Parent Node method
 *
 * For relating the user to the correct parent user role in the aros table.
 */
	public function parentNode() {
   		if (!$this->id && empty($this->data)) {
	        return null;
	    }
	    $data = $this->data;
	    if (empty($this->data[$this->alias]['user_role_id'])) {
			// was $user = $this->read();  // changed because the tags behavior was not finding the array('User' => array('tags' => 'sometag')) field (nor if the model was Tag in that array)
			// this was tested on procial 9/21/15 rk (was very hard to find)
	        $user = $this->find('first', array('conditions' => array($this->alias . '.id' => $data[$this->alias]['id']), 'callbacks' => false));
			$data[$this->alias]['user_role_id'] = $user['User']['user_role_id'];
	    }
	    if (empty($data[$this->alias]['user_role_id'])) {
	        return null;
	    } else {
	        $this->UserRole->id = $data[$this->alias]['user_role_id'];
	        $roleNode = $this->UserRole->node();
	        return array('UserRole' => array('id' => $roleNode[0]['Aro']['foreign_key']));
	    }
	}

/**
 * After find
 * 
 */
 	public function afterFind($results = array(), $primary = false) {
		if (!empty($results[$i][$this->alias]['first_name'])) {
			for ($i=0; $i < count($results); $i++) {
				$results[$i][$this->alias]['full_name'] = $results[$i][$this->alias]['first_name'] . ' ' . $results[$i][$this->alias]['last_name'];
			}
		}
		if (!empty($results['first_name'])) {
			$results['full_name'] = $results['first_name'] . ' ' . $results['last_name'];
		}
		return parent::afterFind($results, $primary);
 	}

/**
 * before save callback
 *
 * @todo move all of the items in beforeSave() into _cleanData() and put $this->data = $this->_cleanData($this->data) here. Then we can get rid of the add() function all together.
 */
	public function beforeSave($options = array()) {
		// I don't know why __cleanAddData was moved so that it doesn't actually "Clean Add Data", but this is necessary!
		
		if (isset($this->data[$this->alias]['username']) && strpos($this->data[$this->alias]['username'], '@') && empty($this->data[$this->alias]['email'])) {
			$this->data[$this->alias]['email'] = $this->data[$this->alias]['username'];
		}
		if (!empty($this->data[$this->alias]['password'])) {
			App::uses('AuthComponent', 'Controller/Component');
	        $this->data[$this->alias]['password'] = AuthComponent::password($this->data[$this->alias]['password']);
		}
    	if (!empty($this->data[$this->alias]['first_name']) && !empty($this->data[$this->alias]['last_name']) && empty($this->data[$this->alias]['full_name'])) {
			$this->data[$this->alias]['full_name'] = __('%s %s', $this->data[$this->alias]['first_name'], $this->data[$this->alias]['last_name']);
		}
		return true;
    }

/**
 * After save method
 *
 * @param bool $created
 */
	public function afterSave($created, $options = array()) {
		// add the user to a group if the data for the group exists (can't use saveAll() because of extra fields)
		if (!empty($this->data['UserGroup']['UserGroup']['id'])) {
			$this->UserGroup->UsersUserGroup->add($this->data);
		}
		if ($created) {
			$this->data = $this->__afterCreation($this->data);
			$welcomeData = $this->data; // need this for the welcome email (gets rewritten after the second save below)
		}
		unset($this->data[$this->alias]['password']);
		unset($this->data[$this->alias]['current_password']);
		unset($this->data[$this->alias]['confirm_password']);
		$this->save($data[$this->alias], array('callbacks' => false));
		
		if ($created) {
			// Send a Welcome Email (moved to after the second save because the forgot_key is if we don't)
			if (defined('__APP_REGISTRATION_EMAIL_VERIFICATION')) {
				$this->welcome($welcomeData[$this->alias]['username']);
			}
			// after creation callback (to use, )
			$this->_afterCreationCallback();
		}
		if($this->autoLogin && CakeSession::read('Auth.User.id') == $this->data[$this->alias]['id']) {
			CakeSession::write('Auth', Set::merge(CakeSession::read('Auth'), $this->data));
		}
		return parent::afterSave($created, $options);
	}

/**
 * After creation method
 * 
 * To use, send a non-registered user to a controller method
 * that sets the session vars "afterUserCreated.model" & "afterUserCreated.method"
 * then redirects the user to the registration page
 * 
 * @example Go to the InvitesController::accept() method to see an example. 
 */
 	protected function _afterCreationCallback() {
		if (CakeSession::read('afterUserCreated')) {
			$model = CakeSession::read('afterUserCreated.model');
			$method = CakeSession::read('afterUserCreated.method');
			$data = CakeSession::read('afterUserCreated.data');
			if (!empty($model) && !empty($method)) {
				$Model = ClassRegistry::init($model);
		 		if(method_exists($Model, $method) && is_callable(array($Model, $method))) {
		 			$Model->$method($data, $this->id); // sends variables in the data session var, and the created user's id
				}
			}
		}
	}

/**
 * After login method
 * 
 * To use, send a user to a controller method
 * that sets the session vars "afterUserCreated.model" & "afterUserCreated.method"
 * then redirects the user to the login page
 * 
 * @example Go to the InvitesController::accept() method to see an example. 
 */
 	protected function _afterLoginCallback() {
		if (CakeSession::read('afterUserLogin')) {
			$model = CakeSession::read('afterUserLogin.model');
			$method = CakeSession::read('afterUserLogin.method');
			$data = CakeSession::read('afterUserLogin.data');
			if (!empty($model) && !empty($method)) {
				$Model = ClassRegistry::init($model);
		 		if(method_exists($Model, $method) && is_callable(array($Model, $method))) {
		 			$Model->$method($data, $this->id); // sends variables in the data session var, and the created user's id
				}
			}
		}
	}

/**
 * After find method
 */


/**
 * Functions to be ran after a User has been created on the site, during User::afterSave()
 * @param array $data
 * @return array $data
 */
	private function __afterCreation($data) {
		// Send admin an email
		if (defined('__USERS_NEW_REGISTRATION') && $notify = unserialize(__USERS_NEW_REGISTRATION)) {
			$this->notifyAdmins($notify['notify']);
		}

		// Initialize some fields
		$data = $this->_cleanAddData($data);

		if (defined('__APP_REGISTRATION_HELLO')) {
			$this->sendHelloEmail();
		}

		return $data;
	}

/**
 * Moves ContactAddress's up to the root so that we can easily add/edit them from User::edit()
 * @todo Should this be in the afterFind? ^JB 
 *
 * @param string $type
 * @param array $query
 * @return mixed
 */
	public function find($type = 'first', $query = array()) {
		$user = parent::find($type, $query);
		if (isset($user['Contact']['ContactAddress'][0])) {
			$user['ContactAddress'] = $user['Contact']['ContactAddress'];
		}
		return $user;
	}

/**
 * Function to change the role of the user submitted
 * @todo Clean this up to what is neccessary ^JB
 */
	public function changeRole($data = null) {
		// check whether user is a data array or the actual user.
		if (is_array($data)) {
			# check whether its numeric or a name for both users and user role
			$newRole['User']['id'] = $userId = $this->_getUserId($data['User']);
			$newRole['User']['user_role_id'] = $this->_getUserRoleId($data['User']);
			if ($this->save($newRole, false)) {
				return true;
			} else {
				return false;
			}
		} else {
			return false;
		}
	}

/**
 * a function which goes through the different ways to get to a user id
 * @todo Clean this up to what is neccessary ^JB
 */
	protected function _getUserId($user) {
		if (is_array($user)) {
			if (!empty($user['user_id'])) {
				return $user['user_id'];
			} elseif (!empty($user['id'])) {
				return $user['id'];
			} elseif (!empty($user['username'])) {
				# put a return which looks up the id here
			}
		}
	}


/**
 * a function which goes through the different ways to get to a user role id
 * @todo Clean this up to what is neccessary ^JB
 */
	protected function _getUserRoleId($user) {
		if (is_array($user)) {
			if (!empty($user['user_role'])) {
				if (is_string($user['user_role'])) {
					$userRole = $this->UserRole->findByName($user['user_role']);
					return $userRole['UserRole']['id'];
				} else {
					return $user['user_role'];
				}
			} elseif (!empty($user['role'])) {
				if (is_string($user['role'])) {
					$userRole = $this->UserRole->findByName($user['role']);
					return $userRole['UserRole']['id'];
				} else {
					return $user['role'];
				}
			}
		}
	}


/**
 * Saves meta data when login occurrs.  For example it updates the last_login field.
 *
 * @param {array}		An array of user data
 * @return {array}		User data array.
 * @todo				Implement Error Logging for non essential errors (mentioned below)
 */
	public function loginMeta($data) {
		$this->_afterLoginCallback();
		if (!empty($data) && !empty($data[$this->alias]['username'])) {
			$user = $this->find('first', array(
				'conditions' => array('OR' => array(
					$this->alias.'.username' => $data[$this->alias]['username'],
					$this->alias.'.email' => $data[$this->alias]['username'],
					)),
				'contain' => array(
					'UserRole',
					),
				));
			if (!empty($user)) {
				$data['User']['id'] = $user['User']['id'];
				$data['User']['last_login'] = date('Y-m-d H:i:s');
				$data['User']['last_ip'] = $_SERVER["REMOTE_ADDR"];
				$data['User']['view_prefix'] = $user['UserRole']['view_prefix'];
				$data['User']['user_role_id'] = $user['UserRole']['id'];
				if (empty($user[$this->alias]['forgot_key']) || $user[$this->alias]['forgot_key'][0] != 'W') {
					unset($data[$this->alias]['password']);
					unset($data[$this->alias]['username']);
					// have to have this!!!! so that passwords don't et rehashed (because $this->data could still be set)
					// 
					// Calling create() re-initialized this->data, so any database defaults are being set here.. and overwriting current values (like User.locale)
					// Unsetting the password before save() is enough to prevent password hashing. ^JB
					//$this->create();
					if ($this->save($data, array('validate' => false))) {
						return $user;
					} else {
						// we should log errors like this
						// an error which shouldn't stop functionality, but nevertheless is an error
						return $user;
					}
				} else {
					throw new Exception(__d('users', 'Please check your email to verify your account.'));
				}
			} else {
				throw new Exception(__d('users', 'User was not found.'));
			}
		} else {
			throw new Exception(__d('users', 'Login failed.'));
		}
	}

/**
 * Login Redirect Url method
 * Sets the default redirect variables, using the settings table constant.
 *
 * @param mixed $redirect
 */
	public function loginRedirectUrl($redirect) {
		// this handles redirects where a url was called that redirected you to the login page
		if ($redirect == '/') {
			// default login location
			$redirect = array('plugin' => 'users', 'controller' => 'users', 'action' => 'my');

			if (defined('__APP_DEFAULT_LOGIN_REDIRECT_URL')) {
				// this setting name is deprecated, will be deleted (got rid of the DEFAULT in the setting name.)
				if ($urlParams = @unserialize(__APP_DEFAULT_LOGIN_REDIRECT_URL)) {
					$redirect = $urlParams;
				}
				$redirect = __APP_DEFAULT_LOGIN_REDIRECT_URL;
			}

			if (defined('__APP_LOGIN_REDIRECT_URL')) {
				$urlParams = @unserialize(__APP_LOGIN_REDIRECT_URL);
				if (!empty($urlParams) && is_numeric(key($urlParams)) && $this->Session->read('Auth.User.user_role_id')) {
					// if the keys are numbers we're looking for a user role
					if (!empty($urlParams[$this->Session->read('Auth.User.user_role_id')])) {
						// if the user role is the index key then we have a special login redirect just for them
						return $urlParams[$this->Session->read('Auth.User.user_role_id')];
					} else {
						// need a return here, to stop processing of the $redirect var
						return $redirect;
					}
				}
				if (!empty($urlParams) && is_string(key($urlParams))) {
					// if the keys are strings we've just formatted the settings by plugin, controller, action, instead of a text url
					$redirect = $urlParams;
				}
				// its not an array because it couldn't be unserialized
				$redirect = __APP_LOGIN_REDIRECT_URL;
			}
		} //else {
			// $redirect = strpos($redirect, '/') === 0 ? $redirect : '/' . $redirect;  // wasn't working with out this since cake 2.4
		// }
		return $redirect;
	}

/**
 * Logout Redirect Url method
 *
 * Sets the default redirect variables, using the settings table constant.
 *
 */
	public function logoutRedirectUrl() {
		if (defined('__APP_LOGOUT_REDIRECT_URL')) {
			if ($urlParams = @unserialize(__APP_LOGOUT_REDIRECT_URL)) {
				if (is_numeric(key($urlParams))) {
					return $urlParams[$this->Session->read('Auth.User.user_role_id')];
				} else {
					return $urlParams;
				}
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

/**
 * Verify Key method
 * Verifies the key passed and if valid key, remove it from DB and return user else
 *
 * @return {mixed}			user data array, or null.
 */
	public function verify_key($key = null) {
		$user = null;
      	// lets see if the key exists and which user its for.
		if(!empty($key))	{
			$user = $this->find('first', array(
				'conditions' => array(
					$this->alias.'.forgot_key' => $key,
					$this->alias.'.forgot_key_created <=' => date('Y:m:d H:i:s', strtotime("+3 days")),
					),
				));
			// if the user does exist, then reset user record forgot info, login and redirect to users/edit
			if (!empty($user)) {
				$this->id = $user['User']['id'];
				$this->set('forgot_key', null);
				$this->set('forgot_key_created', null);
				$this->validate = null;
				if ($this->save()) {
					//$user = null;
				} else {
					throw new Exception(__('Verfication key failed to update.'));
				}
			} else {
				throw new Exception(__('Verification key already used, invalid, or expired.  Try again, or login.'));
			}
		}
		return $user;
	}


/**
 * The username could be an email or a username, so we just do a quick check of both fields to
 * be doubly sure the user doesn't exist.
 */
	public function findbyUsername($username) {
		$user = $this->find('first', array(
			'conditions' => array(
				$this->alias.'.username' => $username
				)
			));
		if (!empty($user)) {
			return $user;
		} else {
			$user = $this->find('first', array(
				'conditions' => array(
					$this->alias.'.email' => $username
					)
				));
			if (!empty($user)) {
				return $user;
			} else {
				return null;
			}
		}
	}


/**
 * facebook registration functions ...
 *
 * @todo 		Document why you put these in here and what they do! (12/9/2011)
 */
	public function parse_signed_request($signed_request, $secret) {
		list($encoded_sig, $payload) = explode('.', $signed_request, 2);
		// decode the data
		$sig = $this->base64_url_decode($encoded_sig);
		$data = json_decode($this->base64_url_decode($payload), true);
		if (strtoupper($data['algorithm']) !== 'HMAC-SHA256') {
			error_log('Unknown algorithm. Expected HMAC-SHA256');
			return null;
		}
		// check sig
		$expected_sig = hash_hmac('sha256', $payload, $secret, $raw = true);
		if ($sig !== $expected_sig) {
			error_log('Bad Signed JSON signature!');
			return null;
		}
		return $data;
	  }


/**
 *
 * @todo Where is this used, and why would it be a User model specific function?  (12/9/2011)
 */
	public function base64_url_decode($input) {
		return base64_decode(strtr($input, '-_', '+/'));
	}


/**
 * Updates data for user to prepare it for saving.
 *
 * @param {array} 		A form input data array.
 * @return {array}		Parsed form input data.
 */
	protected function _cleanAddData($data) {
		if (!isset($data[$this->alias])) {
			return $data;
		}
		
		if (isset($data[$this->alias]['username']) && strpos($data[$this->alias]['username'], '@') && empty($data[$this->alias]['email'])) {
			$data[$this->alias]['email'] = $data[$this->alias]['username'];
		}
		
		if (isset($data[$this->alias]['email']) && strpos($data[$this->alias]['email'], '@') && empty($data[$this->alias]['username'])) {
			$data[$this->alias]['username'] = $data[$this->alias]['email'];
		}

		if(!isset($data[$this->alias]['user_role_id'])) {
			$data[$this->alias]['user_role_id'] = (defined('__APP_DEFAULT_USER_REGISTRATION_ROLE_ID')) ? __APP_DEFAULT_USER_REGISTRATION_ROLE_ID : 3 ;
		}

		if(!isset($data[$this->alias]['contact_type'])) {
			$data[$this->alias]['contact_type'] = (defined('__APP_DEFAULT_USER_REGISTRATION_CONTACT_TYPE')) ? __APP_DEFAULT_USER_REGISTRATION_CONTACT_TYPE : 'person' ;
		}

		// update name into first and last name
		if (!empty($data[$this->alias]['full_name']) && empty($data[$this->alias]['first_name'])) {
			$data[$this->alias]['first_name'] = trim(preg_replace('/[ ](.*)/i', '', $data[$this->alias]['full_name']));
			$data[$this->alias]['last_name'] = trim(preg_replace('/(.*)[ ]/i', '', $data[$this->alias]['full_name']));
		}

		// Getting rid of this, and making this a virtual field on output
		// if (!empty($data[$this->alias]['first_name']) && !empty($data[$this->alias]['last_name']) && empty($data[$this->alias]['full_name'])) {
			// $data[$this->alias]['full_name'] = $data[$this->alias]['first_name'] . ' ' . $data[$this->alias]['last_name'];
		// }

		// setup a verification key
		if (empty($data[$this->alias]['forgot_key']) && defined('__APP_REGISTRATION_EMAIL_VERIFICATION')) {
			$data[$this->alias]['forgot_key'] = $this->__uuid('W', array('User' => 'forgot_key'));
			$data[$this->alias]['forgot_key_created'] = date('Y-m-d H:i:s');
		}

		if(isset($data[$this->alias]['referal_code'])) {
			$data[$this->alias]['parent_id'] = !empty($data[$this->alias]['referal_code']) ? $this->getParentId($data[$this->alias]['referal_code']) : '';
		}

		if (isset($data[$this->alias]['parent_id']) && empty($data[$this->alias]['parent_id'])) {
			unset($data[$this->alias]['parent_id']);
		}

		// this is deprecated and will be changed to an affiliates plugin
		// this cannot be done like this, because it would change the code on every save
		// and it should be in an affiliates plugin
		$data[$this->alias]['reference_code'] = $this->generateRandomCode();
		
		return $data;
	}


/**
 * Generate Referal Code
 * Generate Referal Code and makes a new entry to database to Users Table
 * @param {array}	    	array data
 * @return {mixed}			a reference code string, or boolean
 */
	public function generateReferalCode($user = null){

		$data = array();
		if(is_numeric($user)) {
			$this->recursive = -1;
			$data = $this->read(null, $user);
		} else {
			$data = $user;
		}

		if(empty($data['User']['reference_code'])) {
			$code =  $this->generateRandomCode();
			// Checks if user with same code already exists
			if($this->ifCodeExists($code)){
				$this->generateReferalCode($data);
			} else {
				$data['User']['reference_code'] = $code;
				if ($this->save($data, false)) {
					return $code;
				} else {
					return false;
				}
			}
		} else {
			return $data['User']['reference_code'];
		}

	}

/**
 * checkCodeExists
 * Check whether code with same string exists

 * @param code
 * @return boolean
 */
	public function ifCodeExists($code = null){
		$code = $this->find('first', array(
			'conditions' => array('reference_code' => $code)
			));
		if(!empty($code)){
			return true;
		} else {
			return false;
		}
	}


/**
 * generateRandomCode
 * Generates a random Code of length 5
 * @return code
 */
	public function generateRandomCode() {
	    $length = 8;
	    $characters = "0123456789abcdefghijklmnopqrstuvwxyz";
	    $code = "";
		for ($i = 0; $i < $length; $i++) {
	        $code .= $characters[mt_rand(0, strlen($characters)-1)];
	    }

	    if(!$this->ifCodeExists($code)) {
	    	return $code;
	    } else {
			return $this->generateRandomCode();
		}
	}


/**
 * Get Parent Id
 * @params referal_code
 * @return User.Id
 */
	public function getParentId($referral_code = null){
		$parent = $this->find('first', array(
			'conditions' => array('reference_code' => $referral_code)
			));
		return $parent['User']['id'];
	}


/**
 * Update User Credits
 * @param User.Id, Credits
 * @return boolean
 */
	public function updateUserCredits($credits = null, $userId){
		$user = $this->find('first' , array(
			'fields' => array('id', 'credit_total'),
			'conditions' => array(
				$this->alias.'.id' => $userId,
				),
			));
		$user[$this->alias]['credit_total'] += $credits;
		if(!($this->save($user, false))){
			throw new Exception(__('Credits not Saved'));
		}
	}

/**
 * Procreate method
 * Used when you are creating a user for someone else.
 *
 * @param array $data
 * @return boolean
 */
	public function procreate($data = array(), $options = array()) {
		// change this to merge of some kind for default options
		$options['dryrun'] = !empty($options['dryrun']) ? $options['dryrun'] : false;

 		// setup data
		$data = $this->_cleanAddData($data);
		$randompassword = substr(str_shuffle('abcdefghijklmnopqrstuvwxyz'),0,3);
		$randompassword .= substr(str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZ'),0,3);
		$randompassword .= substr(str_shuffle('0123456789'),0,3);
		$randompassword = substr(str_shuffle($randompassword),0,8);
		$data['User']['password'] = $randompassword;
		$data['User']['confirm_password'] = $randompassword;
		$data['User']['forgot_key'] = $this->__uuid('F');
		$data['User']['forgot_key_created'] = date('Y-m-d H:i:s');


		//Remove the user role validation so other users can create users
		$this->validator()->remove('user_role_id');		
					
		// save the setup data
		$this->create();
		$saveAll = $this->saveAll($data);
		if ($saveAll) {
			if ((!empty($data['User']['username']) || !empty($data['User']['email'])) && $options['dryrun'] == false) {
				$email = !empty($data['User']['email']) ? $data['User']['email'] : $data['User']['username'];
				$site = defined('SITE_NAME') ? SITE_NAME : 'New';
				$url = Router::url(array('admin' => false, 'plugin' => 'users', 'controller' => 'users', 'action' => 'verify', $data['User']['forgot_key']), true);
				$message = __('You have a new user account. <br /><br /> username : %s <br /><br />Please <a href="%s">login</a> and change your password immediately.  <br /><br /> If the link above is not usable please copy and paste the following into your browser address bar : %s', $data['User']['username'], $url, $url);
				if (!empty($data[$this->alias]['notify'])) {
					// send procreate-notification template (or falback if it doesn't exist)
					if ($this->__sendMail($email, array('message' => 'Webpages.procreate-notification', 'data' => $data, 'subjectFallback' => __('%s User Account Created', $site), 'messageFallback' => $message))) {
						// do nothing it's been sent
					} else {
						throw new Exception(__('Failed to notify new user'));
					}
				}
			}
			return true;
		} else {
			return false;
		}
	}


/*
 * Credits Update
 * it will update user credits according to the price paid for credits
 * price * __USERS_CREDITS_PER_PRICE_UNIT
 */
	public function creditsUpdate($data = null){
		$user = $this->find('first' , array(
			'fields' => array('id', 'credit_total'),
			'conditions' =>
				array($this->alias.'.id' => $data['OrderItem']['customer_id'])
			));

		if(defined('__USERS_CREDITS_PER_PRICE_UNIT')) :
			$user['User']['credit_total'] += ($data['OrderItem']['price'] * $data['OrderItem']['quantity']) * __USERS_CREDITS_PER_PRICE_UNIT ;
		else :
			$user['User']['credit_total'] += $data['OrderItem']['price'] * $data['OrderItem']['quantity'] ;
		endif;

		$this->Behaviors->detach('Acl');
		if(!($this->save($user, false))){
			throw new Exception(__('Credits not Saved'));
		}
	}

/**
 * Check email verification method
 * Used same column `forgot_key` for storing key. It starts with W for activation, F for forget
 *
 * @todo 	change the column name from forgot_key to something better, like maybe just "key"
 */
	public function checkEmailVerification($data) {
		if(!empty($data['User']['username'])) {
			$key = $this->field('User.forgot_key', array('User.username' => $data['User']['username']));
			// W at the start of the key tells us the account needs to be verified still.
			if (strpos($key, 'W') !== 0) {
				return $user;
			} else {
				throw new Exception(__('Account must be verified. %s', '<a href="/users/users/reverify">Resend Verification?</a>'));
			}
		} else {
			throw new Exception(__('Invalid login request'));
		}
	}


/**
 * __welcome()
 * User can now register and then wait for an email confirmation to activate his account.
 * If he doesn't activate his account, he cant access the system. The key expires in 3 days.
 * @todo		temp change for error in swift mailer
 * @todo		This message needs to be configurable.
 * @todo		This needs to have the ability to resend in case the user didn't get it the first time or something.
 */
	public function welcome($username) {
		$user = $this->find('first', array('conditions' => array($this->alias.'.username' => $username)));
		if (!empty($user)) {
			$url =   Router::url(array('admin' => false, 'plugin' => 'users', 'controller' => 'users', 'action' => 'verify', $user[$this->alias]['forgot_key']), true);
			$message ='Dear ' . $user[$this->alias]['full_name'] . ', <br></br>
Congratulations! You have created an account with us.<br><br>
To complete the registration please activate your account by following the link below or by copying it to your browser:  <br>' . $url . '<br><br>
If you have received this message in error please ignore, the link will be unusable in three days.<br></br>
Thank you for registering with us and welcome to the community.';
			if ($this->__sendMail($user[$this->alias]['email'], array('message' => 'Webpages.user-account-activation', 'data' => $user, 'subjectFallback' => 'Welcome', 'messageFallback' => $message))) {
				return true;
			} else {
				throw new Exception(__('Verification email failed to send.'));
			}
		} else {
			throw new Exception(__('Unverified user not found.'));
		}
	}


/**
 * Sends an email to the specified address(es) when a user registers
 *
 * @param string $adminEmails A CSV of email addresses
 * @return boolean
 * @throws Exception
 */
	public function notifyAdmins($adminEmails) {
		if (!empty($adminEmails)) {
			$message = 'A new user has been created.'
					. '<br /><br />'
					. 'You can view the user here: http://' . $_SERVER['HTTP_HOST'] . '/users/users/view/' . $this->id
					. '<br /><br />'
					. 'and edit the user here: http://' . $_SERVER['HTTP_HOST'] . '/admin/users/users/edit/' . $this->id;

			if ($this->__sendMail($adminEmails, 'New User Registration', $message)) {
				// do nothing just notifying the admin
				return true;
			} else {
				throw new Exception(__('Registration error, please notify a site admin.'));
			}
		}
	}


/**
 * Sends a "Thanks for Registering"
 * Requires you to create a webpage named, "hello-new-user"
 *
 * @return boolean
 * @throws Exception
 */
	public function sendHelloEmail() {
		if (!empty($this->data['User']['email'])) {
			if ($this->__sendMail($this->data['User']['email'], 'Webpages.hello-new-user', $this->data)) {
				return true;
			} else {
				throw new Exception(__('Verification email failed to send.'));
			}
		}
	}

/**
 *
 * @param type $userid
 * @return boolean
 */
	public function resetPassword($userid) {
		$user = $this->find('first', array('conditions' => array('id' => $userid)));
		unset($user['User']['username']);
		$data['User']['id'] = $userid;
		$data['User']['forgot_key'] = $this->__uuid('F');
		$data['User']['forgot_key_created'] = date('Y-m-d H:i:s');
		$data['User']['forgot_tries'] = $user['User']['forgot_tries'] + 1;
		$data['User']['user_role_id'] = $user['User']['user_role_id'];
		$this->Behaviors->detach('Translate');
		$this->autoLogin = false;
		if ($this->save($data, array('validate' => false))) {
			return $data['User']['forgot_key'];
		} else {
			return false;
		}
	}


/**
 * Rate
 */
	 public function rate($data){
		 App::uses('Rating', 'Ratings.Model'); // load Ratings Model
		 $Rating = new Rating; //create Object $Rating
		 return $Rating->save($data); //return data and save
	}

	/**
	 * Generate a Random Password
	 * @return string
	 */
	function randomPassword() {
		$alphabet = "abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ0123456789";
		$pass = array(); //remember to declare $pass as an array
		$alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
		for ($i = 0; $i < 8; $i++) {
			$n = rand(0, $alphaLength);
			$pass[] = $alphabet[$n];
		}
		return implode($pass); //turn the array into a string
	}

/**
 * Import
 * 
 * Note: To avoid having to tweak the contents of $csvData,
 * you should use your db field names as the heading names.
 * eg: User.id, User.title, User.description
 * 
 * @param array $data
 * @return type
 * @todo Make sure fopen can't be hacked, it's the main point of entry for the base64 attack.
 */
	function importFromCsv($data = array(), $options = array()) {
		$options = array_merge(array($this->alias => array('notify' => true)), $options);
				
		$this->caller = 'import';
		if ( $data['Import']['csv']['error'] !== UPLOAD_ERR_OK ) {
			return array('errors' => 'We did not receive your file. Please try again.');
		}
		// open the file
		$handle = fopen($data['Import']['csv']['tmp_name'], "r");
		// read the 1st row as headings
		$header = fgetcsv($handle);
		// create a message container
		$return = array(
			'messages' => array(),
			'errors' => array(),
		);

		// read each data row in the file
		while ( ($row = fgetcsv($handle)) !== FALSE ) {
			$i++;
			$csvData['User'] = $data['User'];		
			
			// for each header field 
			foreach ($header as $k => $head) {
				// get the data field from Model.field
				if (strpos($head, '.') !== false) {
					$h = explode('.', $head);
					$csvData[$h[0]][$h[1]] = (isset($row[$k])) ? $row[$k] : '';
				}
				// get the data field from field
				else {
					$csvData[$this->alias][$head] = (isset($row[$k])) ? $row[$k] : '';
				}
			}
			// see if we have an id             
			$id = isset($csvData[$this->alias]['id']) ? $csvData[$this->alias]['id'] : 0;
			// we have an id, so we update
			if ($id) {
				// there is 2 options here, 
				// option 1:
				// load the current row, and merge it with the new data
				//$this->recursive = -1;
				//$event = $this->read(null,$id);
				//$csvData['Event'] = array_merge($event['Event'],$csvData['Event']);
				// option 2:
				// set the model id
				$this->id = $id;
			} else {
				// or create a new record
				$this->create();
			}

			// save the row
			if ( $this->procreate($csvData) ) {
				// success message!
				$return['messages'][] = __('User for Row %d was saved.', $i);
			} else {
				$return['errors'][] = ZuhaInflector::flatten($this->validationErrors);
				$return['messages'][] = __('User for Row %d failed to save.', $i);
			}
		}

		// close the file
		fclose($handle);

		// return the messages
		return $return;
	}

/**
 * Clean Data method
 *
 * @param array
	public function _cleanData($data) {
		if (!empty($data[$this->alias]['data'])) {
			$data[$this->alias]['data'] = serialize($data[$this->alias]['data']);
		}
		return $data;
	}
 */

}

if (!isset($refuseInit)) {
	class User extends AppUser {}
}