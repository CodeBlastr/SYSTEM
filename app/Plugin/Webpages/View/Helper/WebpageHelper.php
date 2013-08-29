<?php

App::uses('AppHelper', 'View/Helper');
App::uses('Webpages.Webpage', 'Webpages.Model');
class WebpageHelper extends AppHelper {
	
	public $options = array(
		'wrapperClass' => null,
	);
	
	public function content($id, $options = array()) {
		$this->options = array_merge($this->options, $options);
		$WebPage = new Webpage;
		$webpage = $WebPage->findById($id);
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