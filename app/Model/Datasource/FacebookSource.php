<?php
/*
* Facebook Datasource
* Version 0.1
* Created: 03/19/2010
* Creator: Michael "MiDri" Riddle
*	
* Licensed under The MIT License
* Redistributions of files must retain the above copyright notice.
*/
App::import('Core',array('Xml','HttpSocket'));
class FacebookSource extends DataSource {
	public $description = 'Facebook API';
	
	// CakePHP HttpSocket object
	private $httpSocket = null;
	
	private $callCount = 0;
	
	private $batchMode = false;
	private $batchQueue = array();

	// Config info, don't edit his, pass new values from app/config/database.php
	public $config = array(
		'rest_server' => 'http://api.facebook.com/restserver.php',
		'api_version' => '1.0',
	);
	
	private $sessionKey = null;
	
	public function __construct($config=array()) {
		parent::__construct($config);
		$this->config = array_merge($this->config,$config);
		$this->httpSocket = new HttpSocket();
	}
	
	public function __calculateSignature($args) {
		$requestString = '';
		ksort($args);
		foreach($args as $key => $value) {
			$requestString .= $key . '=' . $value;
		}
		return md5($requestString . $this->config['api_secret']);
	}
	
	public function query($string) {
		return $this->sendRequest('fql.query',array(
			'query' => $string
		));
	}
	
	public function multiQuery($queries) {
		debug(json_encode($queries));
		return $this->sendRequest('fql.multiquery',array(
			'queries' => json_encode($queries)
		));
	}
	
	public function setSession($string) {
		$this->sessionKey = $string;
	}
	
	public function clearSession() {
		$this->sessionKey = null;
	}
	
	// Application
	public function application_getPublicInfo($app_id=null,$app_api_key=null,$app_canvas_name=null) {
		return $this->sendRequest('application.getPublicInfo',array(
			'application_id' => $app_id,
			'application_api_key' => $app_api_key,
			'application_canvas_name' => $app_canvas_name
		));
	}
	
	// Auth
	public function auth_createToken() {
		return $this->sendRequest('auth.createToken');
	}
	
	public function auth_getSession($auth_token,$generate_session_secret=false,$host_url=null) {
		return $this->sendRequest('auth.getSession',array(
			'auth_token' => $auth_token,
			'generate_session_secret' => $generate_session_secret,
			'host_url' => $host_url
		));
	}
	
	public function auth_revokeAuthorization($uid) {
		return $this->sendRequest('auth.revokeAuthorization',array(
			'uid' => $uid
		));
	}
	
	// Friends
	public function friends_get($uid=null) {
		$args = array();
		if($uid) {
			$args['uid'] = $uid;
		}
		$results =  $this->sendRequest('friends.get',$args);
		// Workaround weird for facebook invalid uid bug
		if(is_array($results)) {
			foreach($results as $key => $value) {
				if(!is_int($value)) {
					unset($results[$key]);
				}
			}
		}
		return $results;
	}
	
	// Users
	public function users_getInfo($uids,$fields) {
		if(!is_array($uids)) {
			$uids = array(
				$uids
			);
		}
		if(!is_array($fields)) {
			$fields = array(
				$fields
			);
		}
		return $this->sendRequest('users.getInfo',array(
			'uids' => implode(',',$uids),
			'fields' => implode(',',$fields)
		));
	}
	
	public function users_getLoggedInUser($string) {
		return $this->sendRequest('users.getLoggedInUser',array(
			'session_key' => $string
		));
	}
	
	// Stream
	public function stream_publish($message,$attachment=null,$actionLinks=null,$targetId=null,$uid=null) {
		$args = array(
			'message' => $message
		);
		if($attachment) {
			$args['attachment'] = json_encode($attachment);
		}
		if($actionLinks) {
			$args['action_links'] = json_encode($actionLinks);
		}
		if($targetId) {
			$args['target_id'] = $targetId;
		}
		if($uid) {
			$args['uid'] = $uid;
		}
		return $this->sendRequest('stream.publish',$args);
	}
	
	public function getCurrentUser() {
		if(isset($_COOKIE[$this->config['api_key']])) {
			$object = new stdClass;
			$object->uid = $_COOKIE[$this->config['api_key'] . '_user'];
			$object->ss = $_COOKIE[$this->config['api_key'] . '_ss'];
			$object->session_key = $_COOKIE[$this->config['api_key'] . '_session_key'];
			$object->expires = $_COOKIE[$this->config['api_key'] . '_expires'];
			return $object;
		}
		else {
			return null;
		}
	}
	
	public function getAPIKey() {
		return $this->config['api_key'];
	}
	
	public function getAPISecret() {
		return $this->config['api_secret'];
	}
	
	public function startBatch() {
		$this->batchMode = true;
		$this->batchQueue = array();
	}
	
	public function endBatch() {
		$this->batchMode = false;
		$results = array();
		foreach($this->batchQueue as $request) {
			$results[] = $this->sendRequest($request['method'],$request['args']);
		}
		return $results;
	}
	
	public function sendRequest($method,$newArgs=array()) {
		$args = array(
			'api_key' => $this->config['api_key'],
			'call_id' => $this->callCount,
			'v' => $this->config['api_version']
		);
		$args = array_merge($args,$newArgs);
		$args['format'] = 'json';
		$args['method'] = $method;
		if(isset($this->sessionKey) && !isset($config['session_key'])) {
			$args['session_key'] = $this->sessionKey;
		}
		foreach($args as $key => $value) {
			// Converts bool to strings
			if(is_bool($value)) {
				$args[$key] = ($value ? 'true' : 'false');
			}
			// Remove empty args, screws with signature creation
			elseif(!isset($value)) {
				unset($args[$key]);
			}
		}
		$args['sig'] = $this->__calculateSignature($args);
		if($this->batchMode) {
			$this->batchQueue[] = array(
				'method' => $method,
				'args' => $args
			);
			return null;
		}
		else {
			$results = $this->httpSocket->post($this->config['rest_server'],$args);
			return json_decode($results);
		}
	}
}
?>
