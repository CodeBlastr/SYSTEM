<?php 

class LiterallyCanvasComponent extends Component {
	public function initialize(Controller $controller) {
		
	}	
	public function startup(Controller $controller) {
		if ( !empty($controller->request->data['Media']['canvasImageData']) ) {
			//$this->Media->save($this->request->data);
			debug($controller);
			break;
		}
	}
}
