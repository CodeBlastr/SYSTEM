<?php
App::uses('DbAcl', 'Controller/Component/Acl');

class ZuhaAcl extends DbAcl {
	
	public $aroPath = array();
	
	public $acoPath = array();
	
	public $permission = array();

/**
 * Check method
 * Taken almost directly from DbAcl (changed the return true pieces & made aroPath & acoPath a higher scope variable
 */
	public function check($aro, $aco, $action = "*") {
		// a very special case of aro aco settings
		if (!empty($aro['permission']) && $aro['permission'] === true) {
			return $this->permission($aco); // $aco actually equals a data array if permission is true
		}
		
		if ($aro == null || $aco == null) {
			return false;
		}

		$permKeys = $this->_getAcoKeys($this->Aro->Permission->schema());
		unset($permKeys[4]); // zuha update
		$aroPath = $this->aroPath = $this->Aro->node($aro); // zuha update
		$acoPath = $this->acoPath = $this->Aco->node($aco); // zuha update

		if (empty($aroPath) || empty($acoPath)) {
			trigger_error(__d('cake_dev', "DbAcl::check() - Failed ARO/ACO node lookup in permissions check.  Node references:\nAro: ") . print_r($aro, true) . "\nAco: " . print_r($aco, true), E_USER_WARNING);
			return false;
		}

		if ($acoPath == null || $acoPath == array()) {
			trigger_error(__d('cake_dev', "DbAcl::check() - Failed ACO node lookup in permissions check.  Node references:\nAro: ") . print_r($aro, true) . "\nAco: " . print_r($aco, true), E_USER_WARNING);
			return false;
		}

		if ($action != '*' && !in_array('_' . $action, $permKeys)) {
			trigger_error(__d('cake_dev', "ACO permissions key %s does not exist in DbAcl::check()", $action), E_USER_NOTICE);
			return false;
		}

		$inherited = array();
		$acoIDs = Set::extract($acoPath, '{n}.' . $this->Aco->alias . '.id');

		$count = count($aroPath);
		for ($i = 0; $i < $count; $i++) {
			$permAlias = $this->Aro->Permission->alias;

			$perms = $this->Aro->Permission->find('all', array(
				'conditions' => array(
					"{$permAlias}.aro_id" => $aroPath[$i][$this->Aro->alias]['id'],
					"{$permAlias}.aco_id" => $acoIDs
				),
				'order' => array($this->Aco->alias . '.lft' => 'desc'),
				'recursive' => 0
			));

			if (empty($perms)) {
				continue;
			} else {
				$perms = Set::extract($perms, '{n}.' . $this->Aro->Permission->alias);
				foreach ($perms as $perm) {
					
					$permission = $perm; // zuha update
					unset($perm['user_fields']); // zuha update
					
					if ($action == '*') {

						foreach ($permKeys as $key) {
							if (!empty($perm)) {
								if ($perm[$key] == -1) {
									return false;
								} elseif ($perm[$key] == 1) {
									$inherited[$key] = 1;
								}
							}
						}
						if (count($inherited) === count($permKeys)) {
							$this->permission = $permission;
							return true;
						}
					} else {
						switch ($perm['_' . $action]) {
							case -1:
								return false;
							case 0:
								continue;
								#break;
							case 1:
								$this->permission = $permission; // zuha update;
								return true;
								#break;
						}
					}
				}
			}
		}
		return false;
	}

/**
 * Permission method
 * 
 * Does a final permission check on the user field.
 * eg. if (owner_id = CakeSession::read('Auth.User.id'))
 * 
 * @param array $data
 */
	public function permission($data = array()) {
		if ( ! empty($data)) {
			// This is a permission check for record level permissions.
			// userfields are ACO records from the controller
			if (isset($this->permission['user_fields']) && !empty($this->permission['user_fields']) && CakeSession::read('Auth.User.id') !== 1) {
				$userFields = explode(',', $this->permission['user_fields']);
				// we are only checking individual records so only the data from find(first) or read() can be used
				foreach ($userFields as $user) {
					if ($data[0][$user] !== null && $data[0][$user] == CakeSession::read('Auth.User.id')) {
						$isRightUser = true;
					}
				}
				// What we do with users that don't have record level user access
			  	if ( ! isset($isRightUser)) {
				  	SessionComponent::setFlash(__('Only the %s has access.', str_replace('_id', '', $this->permission['user_fields'])), 'flash_warning');
				  	header('Location: /users/users/restricted');
				  	exit;
			  	}
			}
		}
		// nothing to check
		return true;
	}

}
