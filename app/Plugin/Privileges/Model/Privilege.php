<?php
class Privilege extends PrivilegesAppModel {

	var $name = 'Privilege'; 
	var $useTable = 'aros_acos';
	
	var $belongsTo = array(
		'Section' => array(
	    	'className' => 'Privileges.Section',
	        'foreignKey' => 'aco_id'
	        ),
		'Requestor'=>array(
	      	'className' => 'Privileges.Requestor',
	       	'foreignKey' => 'aro_id'
	        )
		);
	
	
	function prepare(){
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
	
	/*
	 * Checks if record exists 
	 * @param {int} aro_id
	 * @param {int} aco_id
	 * @return {mixed}
	 */

	function checkSection($requestor_id , $aco_id){
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
		}else{
			return $cnt["Privilege"]["id"];
		}
		
	}
	
}
?>
