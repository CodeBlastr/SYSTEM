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

}
