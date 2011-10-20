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

					$this->request->data['User']['full_name'] = $response['registration']['name'];
					$this->request->data['User']['first_name'] = $response['registration']['first_name'];
					$this->request->data['User']['last_name'] = $response['registration']['last_name'];
					$this->request->data['User']['username'] = $response['registration']['username'];
					$this->request->data['User']['password'] = $this->Auth->password($response['registration']['password']);
					$this->request->data['User']['confirm_password'] = $response['registration']['password'];
					$this->request->data['User']['email'] = $this->request->data['User']['confirm_email'] = $response['registration']['email'];
					$this->request->data['User']['facebook_id'] = $_SESSION['FB']['uid'];
					
				}
				if(!empty($this->request->data)) {
					try {
						$result = $this->User->add($this->request->data);
						if ($result === true) {
							$this->Session->setFlash(__d('users', 'Successful Registration', true));
							$this->Auth->login($this->request->data);
							$this->redirect($this->_defaultLoginRedirect());				
						} else {
							$this->request->data = $result;
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
