<?php
class FacebookController extends FacebookAppController {

	var $name = 'Facebook';
	var $allowedActions = array('register');
	var $uses = array('Users.User');
	
	function register() {
	# destroy a session and force login or registration
			if(isset($_SESSION['FB']['uid'])) {
					$user = $this->User->findByFacebookId($_SESSION['FB']['uid']);
			}
			if(!empty($user)) {
				$this->Auth->login($user);
				$this->redirect(array('plugin' => 'users', 'controller' => 'users', 'action' => 'view', $user['User']['id']));
			} else {
						// parse registration info from facebook
				if(isset($_REQUEST['signed_request'])) {
					$response = $this->User->parse_signed_request($_REQUEST['signed_request'], Configure::read('Facebook.secret'));

					$this->data['User']['full_name'] = $response['registration']['name'];
					$this->data['User']['first_name'] = $response['registration']['first_name'];
					$this->data['User']['last_name'] = $response['registration']['last_name'];
					$this->data['User']['username'] = $response['registration']['username'];
					$this->data['User']['password'] = $this->Auth->password($response['registration']['password']);
					$this->data['User']['confirm_password'] = $response['registration']['password'];
					$this->data['User']['email'] = $this->data['User']['confirm_email'] = $response['registration']['email'];
					$this->data['User']['facebook_id'] = $_SESSION['FB']['uid'];
					
				}
				if(!empty($this->data)) {
					try {
						$result = $this->User->add($this->data);
						if ($result === true) {
							$this->Session->setFlash(__d('users', 'Successful Registration', true));
							$this->Auth->login($this->data);
							$this->redirect($this->_defaultLoginRedirect());				
						} else {
							$this->data = $result;
						}
					} catch (Exception $e) {
						# if registration verification is required the model will return this code
						if ($e->getCode() == 834726476) {
							if ($this->_welcome($this->User->id)) {
								$this->Session->setFlash($e->getMessage());
								$this->Auth->logout();
							} else {
								$this->Session->setFlash(__('User saved, but a problem sending verification. Use forgot password, to resend.', true));
								$this->Auth->logout();
							}
						} else {
							$this->Session->setFlash($e->getMessage());
							$this->Auth->logout();
						}
					}
				}
			}
	}
}
?>
