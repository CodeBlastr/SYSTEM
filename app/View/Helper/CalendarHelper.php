<?php
/**
 * @link <http://arshaw.com/fullcalendar/docs/usage/>
 */
class CalendarHelper extends AppHelper {
	
	private $options = array();
	
	public function init($options = array()) {
		if (!empty($options)) {
			$this->options = am($this->options, $options);
		}
		$view =& ClassRegistry::getObject('view'); 
        if (is_object($view)) { 
            $view->addScript($this->Javascript->link('fullcalendar/fullcalendar')); 
            $view->Html->css('fullcalendar/fullcalendar', null, array('inline' => false));
            return true;
        } else {
        	return $this->Javascript->link('fullcalendar/fullcalendar');
        }
	}
	
	public function renderCalendar($params = array()) {
		
	}
	
}