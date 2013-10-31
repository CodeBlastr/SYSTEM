<?php
App::uses('AppHelper', 'View/Helper');

/**
 * Chart Helper
 * 
 * @todo move this and the elements to the core
 */
class ChartHelper extends AppHelper {
	
	public $helpers = array ('Html', 'Form', 'Url');
	
    public function __construct(View $View, $settings = array()) {
    	//$this->View = $View;
        parent::__construct($View, $settings);
    }
	
	
	public function time($data, $options) {
		return $this->_View->Element('Contacts.Charts/time', array_merge(array('data' => $data), $options));
	}
	
}