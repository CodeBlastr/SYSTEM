<?php
App::uses('AppModel', 'Model');


class Region extends AppModel {

	public $name = 'Region';
    
                           
    public function findCountries() {
       return $this->find('all', array('conditions'=> array('parent_id' => 0)));  
    }
    
    public function findStates($countryID) {
       return $this->find('all', array('conditions'=> array('parent_id' => $countryID)));  
    }
    
    public function findZipcodes($cityID) {
       return $this->find('all', array('conditions'=> array('id' => $cityID)));  
    }
    
    public function getName($ID) {   
        $get_name = $this->findById($ID); 
        return $get_name['Region']['name'];
    }
	
}