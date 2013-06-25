<?php
class CalendarsController extends AppController {
	public $name = 'Calendars';

/**
 * It basically retrieves and combines the json feeds that you give it.
 *
 * You give this action an http_build_query "array" of base64 encoded URL's
 * that point to the json feeds you want to include in your calendar.
 *  
 * @param $sources	string 	An http query of base64 encoded local JSON URL's to retreive and combine
 * @param $format	string	Format of something	
 */
	public function feed ($sources, $format = 'json') {
		
		parse_str($sources, $urls);
		
		foreach ( $urls as $url ) {
			// debug(base64_decode($url));
			//$data[] = $this->requestAction( base64_decode($url) );
			$output = array_merge( json_decode($this->requestAction( base64_decode($url) )), $output );
		}

		header("Content-type: application/json");
		echo $output;
		exit;
	}
}
	