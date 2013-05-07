<?php
class PrivilegesController extends PrivilegesAppController {

	public $name = 'Privileges';
    
	public $uses = 'Privileges.Privilege';

	public function index() {
 		$this->redirect(array('plugin' => 'privileges', 'controller' => 'sections', 'action' => 'index'));
		//$dat = $this->Privilege->prepare();
		//$this->set('data' , $dat);
	}
	
/**
 * Manages the synchronization of privileges with the chosen checkboxes. 
 * 
 * @return void
 */
	public function add() {
		//First we save the Aco record with the userfields for record level access.
		//This cleans up the sent data and gives us an array with the keyed by aco id
		$userfields = $this->_cleanAcoArray($this->request->data['Aco']);
		$aco = new Aco; //Creates a new aco object just for simplicity	
		
		//Need to update the Aco Record with the userfields
		foreach($userfields as $acoid => $userfield) {
			$aco->id = $acoid;	
			
			//save userfield to acorecord throw a message if doesn't work
			if(!$aco->saveField('user_fields', implode(',', $userfield))) {
				$message = __('Privlege update failed, please try again.', true);
                break;
			} 
		}

 		$dat = $this->request->data['Privilege'];
		
 		for($i = 0; $i < count($dat); $i++){
 			//set the variables 
 			$k = key($dat);
 			$v = current($dat);
 			$split = explode('_' , $k);
 			// split 
 			$this->request->data['Privilege']['aco_id'] = $split[0];
 			$this->request->data['Privilege']['aro_id'] = $split[1];
			
			
 			if($v == 'on' || $v == 1){
 				$this->request->data['Privilege']['_create'] = 1;
 				$this->request->data['Privilege']['_read'] = 1;
 				$this->request->data['Privilege']['_update'] = 1;
 				$this->request->data['Privilege']['_delete'] = 1;	
 			} else {
 				$this->request->data['Privilege']['_create'] = -1;
 				$this->request->data['Privilege']['_read'] = -1;
 				$this->request->data['Privilege']['_update'] = -1;
 				$this->request->data['Privilege']['_delete'] = -1;
 			}
 			
 			if (!$this->Privilege->checkSection($split[1] , $split[0])) {
                if($this->request->data['Privilege']['_create'] != -1) {
                    	
                    $this->Privilege->create();
                    if ($this->Privilege->save($this->request->data)) {
                        $message = __('Privileges Updated', true);
                    } else {
                        $message = __('Privlege update failed, please try again.', true);
                        break;
                    }
                }
            } else {
                $this->Privilege->id = $this->Privilege->checkSection($split[1] , $split[0]);
             
                if ($this->Privilege->save($this->request->data)) {
                    $message = __('Privileges Updated', true);
                } else {
                    $message = __('Privlege update failed, please try again.', true);
                    break;
                }
            }
 			
 			next($dat);
 		}
		
		if ($this->Privilege->deleteAll(array('Privilege._create' => '-1'))) {
			$this->Session->setFlash($message);
	 		$this->redirect($this->referer());
        }
	}

/**
 * Cleans up the aco array returned by priviledges page
 * 
 * @return array
 */

	private function _cleanAcoArray($acoArr) {
		
		//Check the Aro record if 0 just skip
		$acoReturnArr = array();
		if (!empty($acoArr)) {
			foreach($acoArr as $key => $acoRes) {
				$acoId = explode('_', $key);	//Grab the Aco id 
				$acoId = $acoId[0];	
				if(!isset($acoReturnArr[$acoId])) {
					$acoReturnArr[$acoId] = array();
				}	
				
				//check the aro record, then populates the array with the user fields
				
				if($this->request->data['Privilege'][$key] == 1) {
					foreach($acoRes as $k => $v) {
						if(!in_array($k, $acoReturnArr[$acoId])) {
							if($v == 1){
								$acoReturnArr[$acoId][] = $k;
							}
						}
					}
				}
				
			}
		} else {
			debug('Should not be here, if it is then we need unit test for it, please.');
			debug($this->request->data);
			break;
		}
		
		return $acoReturnArr;
	}

}
