<?php
class User extends AppModel {

	var $name = 'User';
	var $displayField = 'full_name';
	var $actsAs = array('Affiliates.Referrable', 'Acl' => array('type' => 'both'));
	var $order = array('last_name', 'full_name', 'first_name');

	
	var $validate = array(
		'password' => array(
			'notempty' => array(
				'rule' => 'notEmpty',
				'allowEmpty' => false,
				'message' => 'Please Enter a value for Password',
				'required' => true
			),
			'comparePassword' => array(
				'rule' => array('_comparePassword'),
				'allowEmpty' => false,
				'message' => 'Password, and Confirm Password Should Match.',
				'required' => true
			),
		),
		'username' => array(
			'notempty' => array(
				'rule' => 'notEmpty',
				'message' => 'Please Enter a value for Username',
				'required' => true
			),
			'isUnique' => array(
				'rule' => 'isUnique',
				'message' => 'This Username belongs to someone else. Please try again.'
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
	var $belongsTo = array(
		'UserRole' => array(
			'className' => 'UserRole',
			'foreignKey' => 'user_role_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

	var $hasMany = array(
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
		'OrderPayment' => array(
			'className' => 'Orders.OrderPayment',
			'foreign_key' => 'user_id'
			),
		'OrderShipment' => array(
			'className' => 'Orders.OrderShipment',
			'foreign_key' => 'user_id'
			),
		'CatalogItemBrand'=>array(
			'className' => 'Catalogs.CatalogItemBrand',
			'foreignKey' => 'owner_id',
			'dependent' => false,
			),
		);
	
	var $hasOne = array(
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
	
	var $hasAndBelongsToMany = array(
       # 'Users.UserGroup' =>
       #     array(
       #         'className'              => 'Users.UserGroup',
       #         'joinTable'              => 'users_user_groups',
       #         'foreignKey'             => 'user_group_id',
       #         'associationForeignKey'  => 'user_id'
       #     ),
  	  );
	
	function _comparePassword() {
		# fyi, confirm password is hashed in the beforeValidate method
		if (isset($this->data['User']['confirm_password']) && 
				($this->data['User']['password'] == $this->data['User']['confirm_password'])) {
			return true;
		} else {
			return false;
		}
	}
	
	function _emailRequired() {
		if (defined('__APP_REGISTRATION_EMAIL_VERIFICATION') && empty($this->request->data['User']['email'])) {
			return false;
		} else {
			return true;
		}
	}
	
/** 
 * With Cakephp 2.0 you can do ACL better (with acts as both) and this function is one of the functions now available from the Acl Behavior.
 */
    function parentNode() {
        if (!$this->id && empty($this->data)) {
            return null;
        }
        if (isset($this->data['User']['user_role_id'])) {
        	$roleId = $this->data['User']['user_role_id'];
        } else {
            $roleId = $this->field('user_role_id');
        }
        if (!$roleId) {
       		return null;
        } else {
            return array('UserRole' => array('id' => $roleId));
        }
    }
		
	/*  Doesn't seem to be necessary now, with the cakephp 2.0 upgrade, because password hashing is not automatic anymore
	 DELETE SOON : 10/29/2011 RK
	function beforeValidate() {
		if (!empty($this->data['User']['id'])) : 
			$user = $this->find('first', array('conditions' => array('User.id' => $this->data['User']['id'])));
			$this->data = Set::merge($user, $this->data);
		endif;
		# hash the confirm password for testing against the password
		if (!empty($this->data['User']['confirm_password'])) {
			$this->data['User']['confirm_password'] = Security::hash($this->data['User']['confirm_password'],'', true);
		}
		# if confirm password is not set at all, that means they weren't editing the user from a form with the passwords on it
		if (!isset($this->data['User']['confirm_password']) && isset($this->data['User']['password'])) : 
			$this->data['User']['confirm_password'] = $this->data['User']['password'];
		endif;
		debug($this->data);
		break;
	} 
	
	function beforeSave($options = array()) {
		debug($this->data);
		if (!empty($this->data['User']['password'])) : 
      		# make a password for form auth.
	        $this->data['User']['password'] = FormAuthenticate::password(
	        	$this->data['User']['username'], $this->data['User']['password'], env('SERVER_NAME')
	        );
		endif;
		debug($this->data);
		break;
        return true;
    }*/

	/** 
	 * After save callback
	 * Update aros_acos so that this user has access to their own profile and no one else does. 
	 * @access public
	 * @return void
	 */	  
	function afterSave($created) {
        if ($created) {
			$Aro = ClassRegistry::init('Aro');
			$Aco = ClassRegistry::init('Aco');
			$ArosAco = ClassRegistry::init('ArosAco');
			$userId = $this->id;
			$aroId = $Aro->id;
			$acoId = $Aco->id;		
			
			$data = array(
				'aro_id' => $aroId,
				'aco_id' => $acoId,
				'_create' => 1,
				'_read' => 1,
				'_update' => 1,
				'_delete' => 1,
			);
            if ($ArosAco->save($data)) {
			} else {
				echo 'Uncaught Exception: 9108710923801928347';
				break;
			}
			
			parent::afterSave($created);
		}
			
			
			/*
			
			$acoData = array(
				'model' => 'User',
				'foreign_key' => $userId,
				);
            if ($this->Aco->save($acoData)) {
			} else {
				echo 'Uncaught Exception: 917293871928791823';
				break;
			}
			$aroParent = $this->Aro->node(array(
				'model' => 'UserRole', 'foreign_key' => $this->request->data['User']['user_role_id']));
			$aroData = array(
				'parent_id' => $aroParent[0]['Aro']['id'],
				'model' => 'User',
				'foreign_key' => $userId,
				);
            if ($this->Aro->save($aroData)) {
			} else {
				echo 'Uncaught Exception: 823094820394810298120';
				break;
			}
			
			$aroId = $this->Aro->id;
			$acoId = $this->Aco->id;
			$data = array(
				'aro_id' => $aroId,
				'aco_id' => $acoId,
				'_create' => 1,
				'_read' => 1,
				'_update' => 1,
				'_delete' => 1,
			);
            if ($this->ArosAco->save($data)) {
			} else {
				echo 'Uncaught Exception: 9108710923801928347';
				break;
			}
        } else {
			if (!empty($this->request->data['User']['id']) && !empty($this->request->data['User']['user_role_id'])) {
				$this->Aro = ClassRegistry::init('Aro');
				$aro = $this->Aro->node(array('model' => 'User', 'foreign_key' => $this->request->data['User']['id']));
				$aroParent = $this->Aro->node(array('model' => 'UserRole', 'foreign_key' => $this->request->data['User']['user_role_id']));
				$aroData = array(
					'id' => $aro[0]['Aro']['id'],
					'parent_id' => $aroParent[0]['Aro']['id'],
					#'model' => 'User',
					#'foreign_key' => $this->request->data['User']['id'],
					);
	            if($this->Aro->save($aroData)) {
				} else {
					echo 'Uncaught Exception: 0019239291919929292929';
					break;
				}
			}
		}
		*/
	}
	

	/** 
	 * Before delete callback
	 * Attach acl behavior to delete the aro and aros_acos nodes associated with this user.
	 * @access public
	 * @return true
	  
	function beforeDelete() {
		$this->Aro = ClassRegistry::init('Aro');
		$this->ArosAco = ClassRegistry::init('ArosAco');
		$this->Behaviors->attach('Acl', array('type' => 'requester'));
		return true;
	}*/
	
	/**
	 * After delete callback
	 * Need to manually delete the aco, because acl cannot act as requester and controlled at the same time.
	 * @access public
	 * @return void
	 
	function afterDelete() {
		$this->Aco = ClassRegistry::init('Aco');
		$acoNode = $this->Aco->node(array('model' => 'User', 'foreign_key' => $this->request->data['User']['id'])); 
		$this->Aco->delete($acoNode[0]['Aco']['id']);
		parent::afterDelete();
	}*/
	
	/**
	 * Handles the data of adding of a user
	 *
	 * @param {array}		An array in the array(model => array(field)) format
	 * @todo		 		Not sure the rollback for user_id works in all cases (Line 66)
	 */
	function add($data) {
		$data = $this->_cleanAddData($data);
		
		if ($data = $this->_userContact($data)) {
			# setup a verification key
			$data['User']['forgot_key'] = defined('__APP_REGISTRATION_EMAIL_VERIFICATION') ? $this->__uid('W', array('User' => 'forgot_key')) : null; 
			$data['User']['forgot_key_created'] = date('Y-m-d h:i:s');
			
			$data['User']['parent_id'] = !empty($data['User']['referal_code']) ? 
						$this->getParentId($data['User']['referal_code']) : ''; 
			$data['User']['reference_code'] = $this->generateRandomCode();
			# the contact model calls back to the User model when using save all
			# and saves the recursive data of contact person / contact company this way.
			if ($this->Contact->add($data)) {
				
				//Update Referral User Credits on a new registration
				if(defined('__USERS_NEW_REGISTRATION_CREDITS') && !empty($data['User']['parent_id'])) {
					$this->updateUserCredits(__USERS_NEW_REGISTRATION_CREDITS, $data['User']['parent_id']);
				}	
				# setup and save data for a related order shipment record for prefilled checkout 
				$data['OrderShipment']['first_name'] = !empty($data['User']['first_name']) ? $data['User']['first_name'] : ''; 
				$data['OrderShipment']['last_name'] =  !empty($data['User']['last_name']) ? $data['User']['last_name'] : '';
				$data['OrderPayment']['user_id'] = $this->id;
				$data['OrderShipment']['user_id'] = $this->id;
				$this->OrderPayment->save($data);
				$this->OrderShipment->save($data);
				# create a gallery for this user.
				if (!empty($data['User']['avatar']['name'])) {
					$data['Gallery']['model'] = 'User';
					$data['Gallery']['foreign_key'] = $this->id;
					$data['GalleryImage']['filename'] = $data['User']['avatar'];
					if ($this->Gallery->GalleryImage->add($data, 'filename')) {
						#return true;
					} else if (!empty($data['GalleryImage']['filename'])) {
						#return true;
						# gallery image wasn't saved but I'll leave this error message as a todo,
						# because I don't have a decision on whether we should roll back the user 
						# if that happens, or just create the user anyway. 
					}
				}
				if (defined('__APP_REGISTRATION_EMAIL_VERIFICATION')) {
					throw new Exception(__d('users', 'Check your email to verify account.', true), 834726476);
				} else {
					return true;
				}
			} else {
				throw new Exception(__d('users', 'Error, user could not be saved, Please try again.', true));
			}
		} else {
			throw new Exception(__d('users', 'Invalid user data.', true));
		}
	}


	/**
	 * Add contact data to the $data var if it exists, if it doesn't setup contact data for save.
	 *
	 * @todo	Finish the contact adding in the case where the data field exists.
	 * @todo	We need to have be able to specify default contact details, like status, industry settings.
	 */
	function _userContact($data) {
		if (!empty($data['Contact']['id'])) {
			$contact = $this->Contact->findById($data['Contact']['id']);
			$data['Contact'] = $contact['Contact'];
		} else if (!empty($data['User']['id'])) {
			$contact = $this->Contact->findByUserId($data['User']['id']);
			if (!empty($contact)) : 
				$data['Contact'] = $contact['Contact'];
				$data['User']['full_name'] = !empty($data['User']['full_name']) ? $data['User']['full_name'] : $contact['Contact']['name'];
			else : 
				$data['User']['full_name'] = !empty($data['User']['full_name']) ? $data['User']['full_name'] : 'N/A';
			endif;
		} else if (!empty($data['Contact']['user_id'])) {
			debug($this->Contact->findByUserId($data['Contact']['user_id']));
			break;
		} else {
			$data['Contact']['name'] = !empty($data['User']['full_name']) ? $data['User']['full_name'] : 'Not Provided';
		}
		return $data;
	}
	
	/** 
	 * Function to change the role of the user submitted
	 */
	function changeRole($data = null) {
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
	 */
	function _getUserId($user) {
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
	 */
	function _getUserRoleId($user) {
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
				'conditions' => array(
					'User.username' => $data['User']['username'],
					),
				'contain' => array(
					'UserRole',
					),
				));
			if (!empty($user)) {
				$data['User']['id'] = $user['User']['id'];
				$data['User']['last_login'] = date('Y-m-d h:i:s');
				$data['User']['view_prefix'] = $user['UserRole']['view_prefix'];
				if (empty($user['User']['forgot_key']) || $user['User']['forgot_key'][0] != 'W') {
					unset($data['User']['password']);
					if($this->save($data, array('validate' => false))) {
						return $user;
					} else {
						# we should log errors like this
						# an error which shouldn't stop functionality, but nevertheless is an error
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

	/*
	 * verifies the key passed and if valid key, remove it from DB and return user else 
	 * returns null. 
	 */
	function verify_key($key = null) {
		$user = null;
      	# lets see if the key exists and which user its for.
		if(!empty($key))	{
			$user = $this->find('first', array(
				'conditions' => array(
					'User.forgot_key' => $key,
					'User.forgot_key_created <=' => date('Y:m:d h:i:s', strtotime("+3 days")),
					),
				));
			# if the user does exist, then reset user record forgot info, login and redirect to users/edit
			if (!empty($user)) {
				$this->id = $user['User']['id'];
				$this->set('forgot_key', null);
				$this->set('forgot_key_created', null);
				if (!$this->save()) {
					$user = null; 
				}
			} 
		}
		return $user;
	}

	/**
	 * The username could be an email or a username, so we just do a quick check of both fields to
	 * be doubly sure the user doesn't exist.
	 */
	function findbyUsername($username) {
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
	
	/** facebook registration functions ... 
     * 
	 * @todo 		Document why you put these in here and what they do!
	 */
	function parse_signed_request($signed_request, $secret) {
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
	
	function base64_url_decode($input) {
		return base64_decode(strtr($input, '-_', '+/'));
	}
	

	function _cleanAddData($data) {
		if (isset($data['User']['username']) && strpos($data['User']['username'], '@')) :
			$data['User']['email'] = $data['User']['username'];
		endif;
		
		if(!isset($data['User']['user_role_id'])) {
			$data['User']['user_role_id'] = (defined('__APP_DEFAULT_USER_REGISTRATION_ROLE_ID')) ? __APP_DEFAULT_USER_REGISTRATION_ROLE_ID : 3 ;
		}
					
		if(!isset($data['User']['contact_type'])) {
			$data['User']['contact_type'] = (defined('__APP_DEFAULT_USER_REGISTRATION_CONTACT_TYPE')) ? __APP_DEFAULT_USER_REGISTRATION_CONTACT_TYPE : 'person' ;
		}
					
		# update name into first and last name
		if (!empty($data['User']['full_name']) && empty($data['User']['first_name'])) {
			$data['User']['first_name'] = trim(preg_replace('/[ ](.*)/i', '', $data['User']['full_name']));
			$data['User']['last_name'] = trim(preg_replace('/(.*)[ ]/i', '', $data['User']['full_name']));
		}
		
		return $data;
	}
	
	/* Generate Referal Code
	 * Generate Referal Code and makes a new entry to database to Users Table 
	 * @param array data
	 * return boolean
	 */
	function generateReferalCode($user = null){
		
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
				if($this->save($data)){
					return $code;
				} else {
					return false;
				}
			}	
		} else {
			return $data['User']['reference_code'];
		}
		
	}
	
	/* checkCodeExists
	 * Check whether code with same string exists
	 * @param code
	 * return boolean
	 */
	function ifCodeExists($code = null){
		$code = $this->find('first', array(
								'conditions' => array('reference_code' => $code)
							));
		if(!empty($code)){
			return true;
		} else {
			return false;
		}
	}
	
	/* generateRandomCode
	 * Generates a random Code of length 5
	 * return code
	 */
	function generateRandomCode() {
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
	
	/* Get Parent Id 
	 * @params referal_code
	 * return User.Id
	 */
	function getParentId($referal_code = null){
		$parent = $this->find('first', array(
					'conditions' => array('reference_code' => $referal_code)
				));
		return $parent['User']['id']; 
	}
	
	/*	Update User Credits
	 *  @param User.Id, Credits
	 *  return boolean
	 */
	function updateUserCredits($credits = null, $userId){
		$user = $this->find('first' , array(
						'conditions' => 
							array('User.id' => $userId)
						)) ;
		$user['User']['credit_total'] += $credits; 
		if(!($this->save($user))){
			throw new Exception(__d('Credits not Saved', true));
		}
	}
}
?>