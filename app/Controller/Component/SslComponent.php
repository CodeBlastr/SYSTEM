<?php 
class SslComponent extends Component {
    
    public $components = array('RequestHandler');
    
    public $Controller = null;
    
    public function initialize(&$Controller) {
        $this->Controller = $Controller;
    }
	
	public function startup() { }
	public function beforeRender() { }
	public function shutdown() { }
    
    public function force() {
        if(!$this->RequestHandler->isSSL()) {
            $this->Controller->redirect('https://'.$this->__url());
        }
    }
    
    protected function __url() {
        $port = env('SERVER_PORT') == 80 ? '' : ':'.env('SERVER_PORT');

        return env('SERVER_NAME').$port.env('REQUEST_URI');
    }
}