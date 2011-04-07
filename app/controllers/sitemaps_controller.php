<?php
class SitemapsController extends AppController{
 
	var $name = 'Sitemaps';
	var $uses = array('Users.User');
	//var $helpers = array('Time');
	var $helpers = array('Text');
	var $components = array('RequestHandler');
 
	/*function index (){	
		//pr(ucfirst(strtolower($this->params['pass'][0])));
		//pr($this->params);
		//$this->loadModel();
		//prevent xml validation errors caused by sql log
	    Configure::write('debug', 0);
		$this->User->recursive = -1;
		$this->set('users', $this->User->find('all'));
	}*/
	
	
			// Modify the Posts Controller action that corresponds to
		// the action which deliver the rss feed, which is the
		// index action in our example
		
		public function index(){
		    if( $this->RequestHandler->isRss() ){
		        $users = $this->User->find('all', array('limit' => 20, 'order' => 'User.created DESC'));
		        //pr($users);
		        //return $this->set('users', $users);
		        return $this->set(compact('users'));
		    }
			
		    // this is not an Rss request, so deliver
		    // data used by website's interface
		    //$this->paginate['User'] = array('order' => 'User.created DESC', 'limit' => 10);
		    $users = $this->User->find('all', array('limit' => 20, 'order' => 'User.created DESC'));
		    //$users = $this->paginate();
		    $this->set(compact('users'));
		}
			
	
}
?>