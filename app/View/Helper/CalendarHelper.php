<?php

/**
 * @link <http://arshaw.com/fullcalendar/docs/usage/>
 */
class CalendarHelper extends AppHelper {
	
	
	public $helpers = array('Html', 'Js'); 
	
	private $options = array();

	
	public function __construct (View $view, $settings = array()) {
        parent::__construct($view, $settings);
		if ( !empty($options) ) {
			$this->options = am($this->options, $options);
		}
		
		return true;
	}

	public function renderCalendar ($params = array()) {
		
		// queue up the JavaScript and CSS
		$this->Html->script('fullcalendar/fullcalendar', array('inline' => false));
		$this->Html->css('fullcalendar/fullcalendar', null, array('inline' => false));
		
		// handle arrays of json feeds
		if ( !empty($params['sources']) ) {
			foreach ( $params['sources'] as $source ) {
				$array[] = base64_encode($source);
			}
			$params['sources'] = http_build_query($array);
			$events = "'/calendars/feed/{$params['sources']}'";
		}
		
		// handle in-line json objects. output them as-is.
		if ( !empty($params['data']) ) {
			$events = $params['data'];
		}
		
		// the container for the calendar
		$output = '<div id="calendar"></div>';
		
		// JavaScript to initialize/configure the calendar
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