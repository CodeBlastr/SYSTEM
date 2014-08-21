<?php

App::uses('AppHelper', 'View/Helper');
App::uses('Webpage', 'Webpages.Model');
class WebpageHelper extends AppHelper {
	
	public $options = array(
		'wrapperClass' => null,
	);
	
	public function content($id, $options = array()) {
		$this->options = array_merge($this->options, $options);
		$WebPage = new Webpage;
		$webpage = $WebPage->findById($id);
		return $this->_parseOptions($webpage,$options);
	}


    public function getContentByName($name,$options = array()){
        $this->options = array_merge($this->options, $options);
        $WebPage = new Webpage;
        $webpage = $WebPage->findByName($name);
        return $this->_parseOptions($webpage,$options);
    }


    private function _parseOptions($webpage,$options = array()){
        $html = '';
        if($webpage != false) {
            if(!empty($options['wrapperClass'])) {
                $html = '<div class="'.$options['wrapperClass'].'">';
                $html .= $webpage['Webpage']['content'];
                $html .= '</div>';
            }else {
                $html = $webpage['Webpage']['content'];
            }
        }
        return $html;
    }

}