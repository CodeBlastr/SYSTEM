<?php
App::import('Vendor', 'OAuth/OAuthClient');
		
class UserConnectsController extends UsersAppController {

	public $name = 'UserConnects';
	public $uses = 'Users.UserConnect';
	
	public $googleSuccessUri = '/users/users/my';
	public $googleFailUri = '/users/users/my';
	

/**
 * Get API access for a user from Google
 * 
 * The scope of access depends on the link clicked for authorization.
 * For reusable access without getting verification every time, the authorization url to Google
 * must include &approval_prompt=force&access_type=offline
 */
	public function google() {
		
			
		$this->googleSuccessUri = !empty($response['state']) ? $response['state'] : $this->googleSuccessUri; // passed to google with the "state" param in the authorize link, and used here as a redirect
			
		
		// the one time use authorization code returned by google which lets you exchange it for a refresh token and access token
		if (!empty($this->request->query['code'])) {
			try {
				$this->UserConnect->google($this->request->query['code']);
				$this->Session->setFlash(__('Google Authorized'));
				// optionally passed to Google with the "state" param
				$this->googleSuccessUri = !empty($this->request->query['state']) ? $this->request->query['state'] : $this->googleSuccessUri; 
				$this->redirect($this->googleSuccessUri);
			} catch (Exception $e) {
				$this->Session->setFlash($e->getMessage());
				$this->redirect($this->googleFailUri);
			}
			
		}

	}
	
}