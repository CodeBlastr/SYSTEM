<?php
class CalendarsController extends AppController {
	public $name = 'Calendars';
	public $allowedActions = array('feed');
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
		$output = array();
		parse_str($sources, $urls);
		//debug($urls);
		foreach ( $urls as $url ) {
			//debug(_decode($url));
			//debug(  $this->requestAction( base64_decode($url))  );
			//debug(base64_decode($url));

			$newData = json_decode($this->requestAction( base64_decode($url) ), true);

			if ( !empty($newData) ) {
//				debug($newData);
//				$data[] = $newData;
				$output = array_merge( $newData, $output );
			}
			//debug($data);
			//$output = array_merge( json_decode($this->requestAction( base64_decode($url) )), $output );
			//$output = array_merge( $data, $output );
		}
//debug($output);
//break;
		header("Content-type: application/json");
		echo json_encode($output);
		exit;
	}
}
	