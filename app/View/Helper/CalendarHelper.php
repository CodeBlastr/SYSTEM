<?php

/**
 * @link <http://arshaw.com/fullcalendar/docs/usage/>
 */
class CalendarHelper extends AppHelper {
	
	
	public $helpers = array('Html', 'Js'); 
	
	private $options = array();

	
	public function __construct(View $view, $settings = array()) {
        parent::__construct($view, $settings);
		if ( !empty($options) ) {
			$this->options = am($this->options, $options);
		}
		
		$this->Html->script('fullcalendar/fullcalendar', array('inline' => false));
		$this->Html->css('fullcalendar/fullcalendar', null, array('inline' => false));
		return true;
	}

	public function renderCalendar($params = array()) {
		
		if ( !empty($params['eventsUrl']) ) {
			$events = "'{$params['eventsUrl']}'";
		}
		
		if ( !empty($params['data']) ) {
			$events = $params['data'];
		}
		
		$output = '<div id="calendar"></div>';
		$output .= $this->Html->scriptBlock(
'$(document).ready(function() {
	$("#calendar").fullCalendar({
		header: {
			left: "title",
			center: "today prev next",
			right: "month agendaWeek agendaDay"
		},
		events: '.$events.'
	})
});'
		);
		
		return $output;
	}

}