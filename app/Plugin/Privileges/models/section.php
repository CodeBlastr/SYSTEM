<?php
class Section extends PrivilegesAppModel {

	var $name = 'Section'; 
	var $useTable = 'acos';
	var $displayField = 'alias';
	var $actsAs = array('Tree');
	
	var $hasAndBelongsToMany = array(
		'Requestor' => array(
			'className' => 'Privileges.Requestor',
			'joinTable' => 'aros_acos',
			'foreignKey' => 'aco_id',
			'associationForeignKey' => 'aro_id'
		)
	);
	
	/*
	 * Prepare the Aco data 
	 * @return {array}
	 */
	
	function prepare(){
		// set initial values 
		$this->recursive = 2 ;
		#get the root level parent id
		$root = $this->find('first', array(
			'conditions' => array(
				'Section.parent_id' => null,
				'Section.model' => null,
				'Section.foreign_key' => null,
				),
			'contain' => array(),
			'fields' => array(
				'id',
				),
			'order' => array(
				'Section.alias',
				),
			));
				
								  
		$data = $this->find('all' , array(
			'conditions' => array(
				'Section.type' => array(
					'plugin', 'controller'
					),
				'parent_id' => $root['Section']['id'],
				),
			'contain' => array(
				/*'Privilege' => array(
					'fields'=>array(
						'_create',
						'id'
						)
					), */
				'Requestor'
				),
			'order' => array(
				'Section.alias',
				'Section.lft',
			    'Section.type',
				),
			));
		
		for($i = 0; $i < count($data) ; $i++){
			if($data[$i]["Section"]["type"] == 'plugin'){
				$controllers = $this->find('all', array(
					'conditions'=>array(
						'Section.type'=>'pcontroller',
						'Section.parent_id'=> $data[$i]["Section"]["id"]
						),
					'contain'=>array()
					));
				
				foreach ($controllers as $c){
					$data[$i]["Controller"][] = $c;
				}
			}
		}
		return $data;
	}
	
	/*
	 * Prepares the data for a plugin
	 * @param {int} -> id of the plugin
	 * @return {array}
	 */
	
	function fetch_plugin($id){
		
	}

}
?>
