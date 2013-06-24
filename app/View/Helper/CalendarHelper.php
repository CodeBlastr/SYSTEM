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

	/**
	 * 
	 * @param array $params
	 *	$params['sources']	= array of event feeds to combine and display
	 *	$params['data']		= raw JSON event objects
	 *	$params['header']	= array of calendar header options, or false for no header. @see http://arshaw.com/fullcalendar/docs/display/header/
	 * @return string HTML and JavaScript to display the calendar
	 */
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
		
		// handle header settings
		if ( !isset($params['header']) ) {
			$params['header'] = array('left' => 'title', 'center' => 'today prev next', 'right' => 'month agendaWeek agendaDay');
		}
		
		// the container for the calendar
		$output = '<div id="calendar"></div>';
		
		// JavaScript to initialize/configure the calendar
		$output .= $this->Html->scriptBlock(
'$(document).ready(function() {
	$("#calendar").fullCalendar({
		header: '.json_encode($params['header']).',
		events: '.$events.'
	})
});'
		);
		
		return $output;
	}

}