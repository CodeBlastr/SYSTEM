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
		$i = 0;
		foreach ($this->request->data['Privilege'] as $ids => $value) {
			$id = explode('_' , $ids);
			$this->Privilege->deleteAll(array('Privilege.aco_id' => $id[0], 'Privilege.aro_id' => $id[1]));
 			if ($value == 1) {
				$data[$i]['Privilege']['aco_id'] = $id[0];
				$data[$i]['Privilege']['aro_id'] = $id[1];
				$data[$i]['Privilege']['user_fields'] = is_array($this->request->data['ArosAco'][$ids]) ? implode(',', array_keys($this->request->data['ArosAco'][$ids], 1)) : null;
 				$data[$i]['Privilege']['_create'] = 1;
 				$data[$i]['Privilege']['_read'] = 1;
 				$data[$i]['Privilege']['_update'] = 1;
 				$data[$i]['Privilege']['_delete'] = 1;
			}
			$i++;
		}
		if (!empty($data) && $this->Privilege->saveAll($data)) {
			$this->Session->setFlash(__('Privileges Updated'), 'flash_success');
	 		$this->redirect($this->referer());
		} else {
			$this->Session->setFlash(__('Privlege update failed, please try again.'), 'flash_warning');
	 		$this->redirect($this->referer());
		}
		
		/* Delete (left for reference in case something is broken) 7/22/2013 RK
		//First we save the Aco record with the userfields for record level access.
		//This cleans up the sent data and gives us an array with the keyed by aco id
		if(isset($this->request->data['ArosAco'])) {
			$userfields = $this->_cleanAcoArray($this->request->data['ArosAco']);
			// delete $aco = new Aco; //Creates a new aco object just for simplicity	
			
			// delete //Need to update the Aco Record with the userfields
			// delete foreach($userfields as $acoid => $userfield) {
			// delete 	$aco->id = $acoid;	
				
			// delete 	//save userfield to acorecord throw a message if doesn't work
			// delete 	if(!$aco->saveField('user_fields', implode(',', $userfield))) {
			// delete 		$message = __('Privlege update failed, please try again.', true);
	        // delete         break;
			// delete 	} 
			// delete }
			debug($userfields);
		}

 		$dat = $this->request->data['Privilege'];
		
 		for($i = 0; $i < count($dat); $i++){
 			//set the variables 
 			$k = key($dat);
 			$v = current($dat);
 			$split = explode('_' , $k);
 			// split 
 			$data['Privilege']['aco_id'] = $split[0];
 			$data['Privilege']['aro_id'] = $split[1];
			
			
 			if($v == 'on' || $v == 1) {
 				$data['Privilege']['_create'] = 1;
 				$data['Privilege']['_read'] = 1;
 				$data['Privilege']['_update'] = 1;
 				$data['Privilege']['_delete'] = 1;	
 			} else {
 				$data['Privilege']['_create'] = -1;
 				$data['Privilege']['_read'] = -1;
 				$data['Privilege']['_update'] = -1;
 				$data['Privilege']['_delete'] = -1;
 			}
 			
 			if (!$this->Privilege->checkSection($split[1] , $split[0])) {
                if($data['Privilege']['_create'] != -1) {
                    $this->Privilege->create();
					 debug('Not sure if this save is used, was not tested during user fields update');
		             debug($data);
					 break;
                    if ($this->Privilege->save($this->request->data)) {
                        $message = __('Privileges Updated');
                    } else {
                        $message = __('Privlege update failed, please try again.');
                        break;
                    }
                }
            } else {
                $this->Privilege->id = $this->Privilege->checkSection($split[1] , $split[0]);
             debug($data);
			 break;
                if ($this->Privilege->save($this->request->data)) {
                    $message = __('Privileges Updated');
                } else {
                    $message = __('Privlege update failed, please try again.');
                    break;
                }
            }
 			next($dat);
 		}
		
		if ($this->Privilege->deleteAll(array('Privilege._create' => '-1'))) {
			$this->Session->setFlash($message);
	 		$this->redirect($this->referer());
        }*/
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
				$ids = explode('_', $key);	//Grab the Aco id 
				$acoId = $ids[0];	
				$aroId = $ids[1];
				//if(!isset($acoReturnArr[$acoId])) {
				//	$acoReturnArr[$acoId] = array();
				//}	
				
				//check the aro record, then populates the array with the user fields
				
				if($this->request->data['Privilege'][$key] == 1) {
					$i = 0;
					foreach($acoRes as $k => $v) {
						//if(!in_array($k, $acoReturnArr[$acoId])) {
							if($v == 1){
								//$acoReturnArr[$acoId][] = $k;
								$acoReturnArr[$i]['Privilege']['aco_id'] = $acoId;
								$acoReturnArr[$i]['Privilege']['aro_id'] = $aroId;
								$acoReturnArr[$i]['Privilege']['user_fields'] = $k;
							}
						//}
						$i++;
					}
				}
				
			}
		} else {
			debug('Should not be here, if it is then we need unit test for it, please.');
			debug($this->request->data);
			exit;
		}
		return $acoReturnArr;
	}

}
