<?php
class SslComponent extends Component {
    
    public $components = array('RequestHandler');
    
    public $Controller = null;
    
    public function initialize(Controller $Controller) {
        $this->Controller = $Controller;
    }
	
    public function startup(Controller $Controller) { }
    public function beforeRender(Controller $Controller) { }
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