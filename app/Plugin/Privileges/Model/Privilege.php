<?php
App::uses('PrivilegesAppModel', 'Privileges.Model');

class Privilege extends PrivilegesAppModel {

	public $name = 'Privilege'; 
	
	public $useTable = 'aros_acos';
	
	public $belongsTo = array(
		'Section' => array(
	    	'className' => 'Privileges.Section',
	        'foreignKey' => 'aco_id'
	        ),
		'Requestor'=>array(
	      	'className' => 'Privileges.Requestor',
	       	'foreignKey' => 'aro_id'
	        )
		);
	
/**
 * After Save Callback
 */
	public function afterSave($created) {
		$this->_writeLinkPermissions();
		return parent::afterSave($created);
	}
	
/**
 * Prepare method
 */
	public function prepare(){
		$dat = $this->find('all', array(
			'contain' => array()
			));
		
		/*$acoDat = $this->Section->find('all' , array(
			'contain'=>array(),
			'order'=>array('lft')						
			));
		*/
		$requestorDat = $this->Requestor->find('all' , array(
			'conditions'=>array(
				'Requestor.model' => 'UserRole'
				),
			/*'contain'=>array(
				'UserRole'=>array(
					'fields'=>array(
						'name'
						)
					)	
				),*/
			'fields'=>array(
				'id',
				'foreign_key'
				)
			));
		
		$ret["Groups"] = $requestorDat;
		
		$j = 0;
		for($i = 0; $i < count($requestorDat); $i++){
			foreach($dat as $d){
				if($d["Privilege"]["aco_id"] == $requestorDat[$i]["Section"]["id"]){
					$requestorDat[$i]["Section"]['user_role'][$j]['id'] = $d["Privilege"]["aro_id"];
					$requestorDat[$i]["Section"]['user_role'][$j]['create'] = $d["Privilege"]["_create"];
					$requestorDat[$i]["Section"]['user_role'][$j]['read'] = $d["Privilege"]["_read"];
					$requestorDat[$i]["Section"]['user_role'][$j]['update'] = $d["Privilege"]["_update"];
					$requestorDat[$i]["Section"]['user_role'][$j]['delete'] = $d["Privilege"]["_delete"];
				}
				$j++;
			}
		}
		
		$j = 0;
		
		$ret["AcoDat"] = $requestorDat;	
		
		return $ret;
	}
	
/**
 * Checks if record exists 
 * @param {int} aro_id
 * @param {int} aco_id
 * @return {mixed}
 */
	public function checkSection($requestor_id , $aco_id){
		$cnt = $this->find('first' , array(
			'conditions'=>array(
				'Privilege.aro_id' => $requestor_id,
				'Privilege.aco_id' => $aco_id
				),
			'contain'=>array(
				)
			));
		
		if(!isset($cnt["Privilege"]["id"])){
			return false;
		} else {
			return $cnt["Privilege"]["id"];
		}
	}
	
/**
 * Write link permissions method
 * 
 */
	protected function _writeLinkPermissions() {
		$acos = array();
		$privileges = $this->find('all', array('conditions' => array('Privilege._create' => 1, 'Privilege._read' => 1, 'Privilege._update' => 1, 'Privilege._delete' => 1)));
		foreach ($privileges as $privilege) {
			if (!empty($acos[$privilege['Privilege']['aco_id']])) {
				$acos[$privilege['Privilege']['aco_id']] = $acos[$privilege['Privilege']['aco_id']] . ',' . $privilege['Privilege']['aro_id'];
			} else {
				$acos[$privilege['Privilege']['aco_id']] = $privilege['Privilege']['aro_id'];
			}
		}
		
		$settings = '';
		foreach ($acos as $aco => $aros) {
			$path = $this->Section->getPath($aco); // all of the acos parents
			if ($path === null) {
				// if path is null we need to delete the aros_acos that use that aco because it doesn't exist
				$this->deleteAll(array('Privilege.aco_id' => $aco));
			} else {
				$url = str_replace('controllers', '', Inflector::singularize(Inflector::tableize(ZuhaInflector::flatten(Set::extract('/Section/alias', $path), array('separator' => '/')))));
				$settings .= $url . ' = ' . $aros . PHP_EOL;
			}
		}		
		App::uses('Setting', 'Model');
		$Setting = new Setting;
		$data['Setting']['type'] = 'APP';
 		$data['Setting']['name'] = 'LINK_PERMISSIONS';
 		$data['Setting']['value'] = trim($settings);
		$Setting->add($data);
	}

/**
 * Duplicate Permissions method
 * 
 * Takes one requestors permissions and duplicates all of their permissions duplicating it to a second user role. 
 * 
 * @param string $ModelName
 * @param int $oldForeignKey
 * @param int $newForeignKey
 * @return bool
 */ 	
	public function duplicatePermissions($modelName, $oldForeignKey, $newForeignKey) {
		
 		$oldAroId = $this->Requestor->field('id', array('Requestor.model' => $modelName, 'Requestor.foreign_key' => $oldForeignKey));
		$newAroId = $this->Requestor->field('id', array('Requestor.model' => $modelName, 'Requestor.foreign_key' => $newForeignKey));

		if (!empty($oldAroId) && !empty($newAroId)) {
			// find the old permissions
			$permissions = $this->find('all', array('conditions' => array('Privilege.aro_id' => $oldAroId)));
			// get acos for checking that they don't already exist
			$acos = Set::extract('/Privilege/aco_id', $permissions);
			// find if any existing permissions exist for them
			$existingPermissions = $this->find('all', array('conditions' => array('Privilege.aro_id' => $newAroId, 'Privilege.aco_id' => $acos)));
			if (empty($existingPermissions)) {
				if (!empty($permissions)) {
					for($i = 0; $i < count($permissions); $i++) {
						unset($permissions[$i]['Privilege']['id']);
						$permissions[$i]['Privilege']['aro_id'] = $newAroId;
					}
				}
				if ($this->saveAll($permissions)) {
					return true;
				} else {
					//throw new Exception(__('No permissions to duplicate'));
					return false;
				}
			} else {
				//throw new Exception(__('Aro has existing permissions'));
				return false;
			}
		} else {
			throw new Exception(__('Missing aro. Old aro : %s, New aro : %s', $oldAroId, $newAroId));
		}
	}
	
}
