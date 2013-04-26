<?php
App::uses('UsersAppModel', 'Users.Model');

class User extends UsersAppModel {

	public $name = 'User';
	public $displayField = 'full_name';
	public $actsAs = array(
		'Acl' => array('type' => 'requester'),
		'Users.Usable' => array('defaultRole' => 'friend')
		);
	public $order = array('last_name', 'full_name', 'first_name');


	public $validate = array(
		'password' => array(
			'notempty' => array(
				'rule' => 'notEmpty',
				'allowEmpty' => false,
				'message' => 'Please enter a value for password',
				'required' => true
				),
			'comparePassword' => array(
				'rule' => array('_comparePassword'),
				'allowEmpty' => false,
				'message' => 'Password, and confirm password fields do not match.',
				'required' => true
				),
        	'strongPassword' => array(
				'rule' => array('_strongPassword'),
				'allowEmpty' => false,
				'message' => 'Password should be six characters, contain numbers and capital and lowercase letters.',
				'required' => true
				),
			),
		'username' => array(
			'notempty' => array(
				'rule' => 'notEmpty',
				'message' => 'Please enter a value for username',
				'required' => true
				),
			'isUnique' => array(
				'rule' => 'isUnique',
				'message' => 'This username belongs to someone else. Please try again.'
				),
			),
		'email' => array(
			'emailRequired' => array(
				'rule' => array('_emailRequired'),
				'message' => 'Email required for registration, Please try again.'
				),
			),
		);

	// this seems to break things because of nesting if I put Users.UserRole for the className
	public $belongsTo = array(
		'UserRole' => array(
			'className' => 'Users.UserRole',
			'foreignKey' => 'user_role_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
			)
		);

	public $hasMany = array(
		'Gallery' => array(
			'className' => 'Galleries.Gallery',
			'foreignKey' => 'foreign_key',
			'dependent' => true,
			),
		'UserStatus' => array(
			'className' => 'Users.UserStatus',
			'foreignKey' => 'user_id',
			'dependent' => true,
			),
		'UserFollower' => array(
			'className' => 'Users.UserFollower',
			'foreignKey' => 'user_id',
			'dependent' => false,
			),
		'UserFollowed' => array(
			'className' => 'Users.UserFollower',
			'foreignKey' => 'follower_id',
			'dependent' => false,
			),
		'UserGroupWallPost'=>array(
			'className' => 'Users.UserGroupWallPost',
			'foreignKey' => 'creator_id',
			'dependent' => false,
			), 
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
		);

	public $hasAndBelongsToMany = array(
        'UserGroup' => array(
			'className' => 'Users.UserGroup',
			'joinTable' => 'users_user_groups',
			'foreignKey' => 'user_id',
			'associationForeignKey' => 'user_group_id',
			'dependent' => true,
			),
		);

	public function __construct($id = false, $table = null, $ds = null) {

		if (in_array('Transactions', CakePlugin::loaded())) {
			$this->hasMany['TransactionAddress'] = array(
				'className' => 'Transactions.TransactionAddress',
				'foreign_key' => 'user_id'
				);
		}
		if (in_array('Products', CakePlugin::loaded())) {
			$this->hasMany['ProductBrand'] = array(
				'className' => 'Products.ProductBrand',
				'foreignKey' => 'owner_id',
				'dependent' => false,
				);
		}
		if (in_array('Connections', CakePlugin::loaded())) {
			$this->hasMany['Connection'] = array(
				'className' => 'Connections.Connection',
				'foreignKey' => 'user_id',
				'dependent' => true,
				);
		}
		
		parent::__construct($id, $table, $ds);
	}

/**
 * Compare Password
 * 
 * Matching password test.
 * @return bool
 */
	protected function _comparePassword() {
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
    protected function _strongPassword() {
        return preg_match('/^((?=.*[^a-zA-Z])(?=.*[a-z])(?=.*[A-Z])(?!.*\s).{6,})$/', $this->data['User']['password']);
    }

/**
 * Email Required
 * 
 * Check if email is required
 * @return bool
 */
	protected function _emailRequired() {
		if (defined('__APP_REGISTRATION_EMAIL_VERIFICATION') && empty($this->data['User']['email'])) {
			return false;
		} else {
			return true;
		}
	}

/**
 * For relating the user to the correct parent user role in the aros table.
 */
	function parentNode() {
   		if (!$this->id && empty($this->data)) {
	        return null;
	    }
	    $data = $this->data;
	    if (empty($this->data[$this->alias]['user_role_id'])) {
	        $user = $this->read();
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
 * before save callback
 * 
 * @todo move all of the items in beforeSave() into _cleanData() and put $this->data = $this->_cleanData($this->data) here. Then we can get rid of the add() function all together.
 */
	public function beforeSave($options = array()) {
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
 * Handles the data of adding of a user
 *
 * @param {array}		An array in the array(model => array(field)) format
 * @todo		 		Not sure the rollback for user_id works in all cases (Line 66)
 */
	public function add($data) {
		$data = $this->_cleanAddData($data);
		if ($data = $this->_userContact($data)) {
			// setup a verification key
			$data[$this->alias]['forgot_key'] = defined('__APP_REGISTRATION_EMAIL_VERIFICATION') ? $this->__uuid('W', array('User' => 'forgot_key')) : null;
			$data[$this->alias]['forgot_key_created'] = date('Y-m-d h:i:s');

			$data[$this->alias]['parent_id'] = !empty($data[$this->alias]['referal_code']) ? $this->getParentId($data[$this->alias]['referal_code']) : '';
			$data[$this->alias]['reference_code'] = $this->generateRandomCode();
			// the contact model calls back to the User model when using save all
			// and saves the recursive data of contact person / contact company this way.
			if ($this->Contact->add($data)) {

				// add the user to a group if the data for the group exists
				if (!empty($data['UserGroup']['UserGroup']['id'])) {
					$this->UserGroup->UsersUserGroup->add($data);
				}

				// create a gallery for this user.
				if (!empty($data[$this->alias]['avatar']['name'])) {
					$data['Gallery']['model'] = 'User';
					$data['Gallery']['foreign_key'] = $this->id;
					$data['GalleryImage']['filename'] = $data[$this->alias]['avatar'];
					if ($this->Gallery->GalleryImage->add($data, 'filename')) {
						//return true;
					} else if (!empty($data['GalleryImage']['filename'])) {
						//return true;
						// gallery image wasn't saved but I'll leave this error message as a todo,
						// because I don't have a decision on whether we should roll back the user
						// if that happens, or just create the user anyway.
					}
				}
				if (defined('__APP_REGISTRATION_EMAIL_VERIFICATION')) {
					if ($this->welcome($data[$this->alias]['username'])) {
						throw new Exception(__d('users', 'Thank you, please check your email to verify your account.'), 834726476);
					} else {
					}
//				} elseif (defined('__APP_REGISTRATION_EMAIL_WELCOME')) {
//                    $user = $this->find('first', array('conditions' => array('User.username' => $data['User']['username'])));
//                    $this->__sendMail($user['User']['email'], '$subject', '$message', 'userAdd', '$from');
				} else {
					return true;
				}
			} else {
				throw new Exception(__d('users', 'Error, user could not be saved, Please try again.'));
			}
		} else {
			throw new Exception(__d('users', 'Invalid user data.'));
		}
	}


/**
 * Handles a user update
 *
 * @param {array}		An array in the array(model => array(field)) format
 * @todo		 		Not sure the rollback for user_id works in all cases (Line 66)
 */
	public function update($data) {
		$data = $this->_cleanAddData($data);

		if ($this->saveAll($data)) {
			return true;
		} else {
			throw new Exception(__d('users', 'Invalid user data.' . implode(', ', $this->invalidFields)));
		}
	}


/**
 * Add contact data to the $data var if it exists, if it doesn't setup contact data for save.
 *
 * @todo	Finish the contact adding in the case where the data field exists.
 * @todo	We need to have be able to specify default contact details, like status, industry settings.
 */
	protected function _userContact($data) {
		if (!empty($data['Contact']['id'])) {
			$contact = $this->Contact->findById($data['Contact']['id']);
			$data['Contact'] = $contact['Contact'];
		} else if (!empty($data[$this->alias]['id'])) {
			$contact = $this->Contact->findByUserId($data[$this->alias]['id']);
			if (!empty($contact)) {
				$data['Contact'] = $contact['Contact'];
				$data[$this->alias]['full_name'] = !empty($data[$this->alias]['full_name']) ? $data[$this->alias]['full_name'] : $contact['Contact']['name'];
			} else {
				$data[$this->alias]['full_name'] = !empty($data[$this->alias]['full_name']) ? $data[$this->alias]['full_name'] : 'N/A';
//				// create a Contact
//				$contact = $this->Contact->create(array(
//					'name' => $data['User']['full_name']
//				));
//				$data['Contact'] = set::merge($data['Contact'], $contact['Contact']);
			}
		} else if (!empty($data['Contact']['user_id'])) {
			debug($this->Contact->findByUserId($data['Contact']['user_id']));
			break;
		} else {
			$data['Contact']['name'] = !empty($data[$this->alias]['full_name']) ? $data[$this->alias]['full_name'] : 'Not Provided';
		}
		return $data;
	}

/**
 * Function to change the role of the user submitted
 * @todo Clean this up to what is neccessary ^JB
 */
	public function changeRole($data = null) {
		# check whether user is a data array or the actual user.
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
		if (!empty($data) && !empty($data['User']['username'])) {
			$user = $this->find('first', array(
				'conditions' => array('OR' => array(
					'User.username' => $data['User']['username'],
					'User.email' => $data['User']['username'],
					)),
				'contain' => array(
					'UserRole',
					),
				));
			if (!empty($user)) {			
				$data['User']['id'] = $user['User']['id'];
				$data['User']['last_login'] = date('Y-m-d h:i:s');
				$data['User']['view_prefix'] = $user['UserRole']['view_prefix'];
				$data['User']['user_role_id'] = $user['UserRole']['id'];
				if (empty($user['User']['forgot_key']) || $user['User']['forgot_key'][0] != 'W') {
					unset($data['User']['password']);
					if($this->save($data, array('validate' => false))) {
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
 * Set the default redirect variables, using the settings table constant.
 */
	public function loginRedirectUrl($redirect) {
		# this handles redirects where a url was called that redirected you to the login page

		if ($redirect == '/') {
			# default login location
			$redirect = array('plugin' => 'users','controller' => 'users','action' => 'my');

			if (defined('__APP_DEFAULT_LOGIN_REDIRECT_URL')) {
				# this setting name is deprecated, will be deleted (got rid of the DEFAULT in the setting name.)
				if ($urlParams = @unserialize(__APP_DEFAULT_LOGIN_REDIRECT_URL)) {
					$redirect = $urlParams;
				}
				$redirect = __APP_DEFAULT_LOGIN_REDIRECT_URL;
			}

			if (defined('__APP_LOGIN_REDIRECT_URL')) {
				$urlParams = @unserialize(__APP_LOGIN_REDIRECT_URL);
				if (!empty($urlParams) && is_numeric(key($urlParams)) && $this->Session->read('Auth.User.user_role_id')) {
					# if the keys are numbers we're looking for a user role
					if (!empty($urlParams[$this->Session->read('Auth.User.user_role_id')])) {
						# if the user role is the index key then we have a special login redirect just for them
						#debug($urlParams[$this->Session->read('Auth.User.user_role_id')]); break;
						return $urlParams[$this->Session->read('Auth.User.user_role_id')];
					} else {
						# need a return here, to stop processing of the $redirect var
						#debug($redirect); break;
						return $redirect;
					}
				}
				if (!empty($urlParams) && is_string(key($urlParams))) {
					# if the keys are strings we've just formatted the settings by plugin, controller, action, instead of a text url
					$redirect = $urlParams;
				}
				# its not an array because it couldn't be unserialized
				$redirect = __APP_LOGIN_REDIRECT_URL;
			}
		}
		#debug($redirect); break;
		return $redirect;
	}

/**
 * Set the default redirect variables, using the settings table constant.
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
 * verifies the key passed and if valid key, remove it from DB and return user else
 *
 * @return {mixed}			user data array, or null.
 */
	public function verify_key($key = null) {
		$user = null;
      	// lets see if the key exists and which user its for.
		if(!empty($key))	{
			$user = $this->find('first', array(
				'conditions' => array(
					'User.forgot_key' => $key,
					'User.forgot_key_created <=' => date('Y:m:d h:i:s', strtotime("+3 days")),
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
				'User.username' => $username
				)
			));
		if (!empty($user)) {
			return $user;
		} else {
			$user = $this->find('first', array(
				'conditions' => array(
					'User.email' => $username
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
		if (isset($data[$this->alias]['username']) && strpos($data[$this->alias]['username'], '@')) {
			$data[$this->alias]['email'] = $data[$this->alias]['username'];
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

		// update first name and last name into full_name
		if (!empty($data[$this->alias]['first_name']) && !empty($data[$this->alias]['last_name']) && empty($data[$this->alias]['full_name'])) {
			$data[$this->alias]['full_name'] = $data[$this->alias]['first_name'] . ' ' . $data[$this->alias]['last_name'];
		}

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
				if($this->save($data, false)){
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
				'User.id' => $userId,
				),
			));
		$user['User']['credit_total'] += $credits;
		if(!($this->save($user, false))){
			throw new Exception(__('Credits not Saved'));
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
				array('User.id' => $data['OrderItem']['customer_id'])
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
 * Used same column `forgot_key` for storing key. It starts with W for activation, F for forget
 *
 * @todo 	change the column name from forgot_key to something better, like maybe just "key"
 */
	public function checkEmailVerification($data) {
		if(!empty($data['User']['username'])) {
			$user = $this->find('first', array(
				'conditions' => array(
					'User.username' => $data['User']['username'],
					),
				'fields' => array(
					'User.forgot_key',
					),
				));
			# W at the start of the key tells us the account needs to be verified still.
			if ($user['User']['forgot_key'][0] != 'W') {
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
		$user = $this->find('first', array('conditions' => array('User.username' => $username)));
		if (!empty($user)) {
			$this->set('name', $user['User']['full_name']);
			$this->set('key', $user['User']['forgot_key']);
			// todo: temp change for error in swift mailer
			$url =   Router::url(array('plugin' => 'users', 'controller' => 'users', 'action' => 'verify', $user['User']['forgot_key']), true);
			$message ="Dear {$user['User']['full_name']}, <br></br>
Congratulations! You have created an account with us.<br><br>
To complete the registration please activate your account by following the link below or by copying it to your browser:</br>			{$url}<br></br>
If you have received this message in error please ignore, the link will be unusable in three days.<br></br>
Thank you for registering with us and welcome to the community.";
			if ($this->__sendMail($user['User']['email'], 'Welcome', $message)) {
				return true;
			} else {
				throw new Exception(__('Verification email failed to send.'));
			}
		} else {
			throw new Exception(__('Unverified user not found.'));
		}
	}


/**
 *
 * @param type $userid
 * @return boolean
 */
	public function resetPassword($userid) {
		$user = $this->find('first', array('conditions' => array('id' => $userid)));
		unset($this->request->data['User']['username']);
		$this->request->data['User']['id'] = $userid;
		$this->request->data['User']['forgot_key'] = $this->__uuid('F');
		$this->request->data['User']['forgot_key_created'] = date('Y-m-d h:i:s');
		$this->request->data['User']['forgot_tries'] = $user['User']['forgot_tries'] + 1;
		$this->request->data['User']['user_role_id'] = $user['User']['user_role_id'];
		$this->Behaviors->detach('Translate');
		if ($this->save($this->request->data, array('validate' => false))) {
			return $this->request->data['User']['forgot_key'];
		} else {
			return false;
		}
	}
}