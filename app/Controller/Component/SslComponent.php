<?php
class SslComponent extends Component {
    
    public $components = array('RequestHandler');
    
    public $Controller = null;
    
    public function initialize(Controller $Controller) {
    	//The initialize method is called before the controller’s beforeFilter method.
        $this->Controller = $Controller;
    }
	
    public function startup(Controller $Controller) {
    	//The startup method is called after the controller’s beforeFilter method but before the controller executes the current action handler.
    }
    public function beforeRender(Controller $Controller) {
		// The beforeRender method is called after the controller executes the requested action’s logic but before the controller’s renders views and layout.
    }
	
    public function shutdown(Controller $Controller) { }
    
    public function force() {
        if(!$this->RequestHandler->isSSL() && !strpos($_SERVER['HTTP_HOST'], 'localhost')) {
            $this->Controller->redirect('https://'.$this->__url());
        }
    }
    
    protected function __url() {
        $port = env('SERVER_PORT') == 80 ? '' : ':'.env('SERVER_PORT');

        return env('SERVER_NAME').$port.env('REQUEST_URI');
    }
}