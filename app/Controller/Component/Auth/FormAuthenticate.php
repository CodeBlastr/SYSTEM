<?php
/**
 *
 * PHP versions 5
 *
 * Zuha(tm) : Business Management Applications (http://zuha.com)
 * Copyright 2009-2013, Zuha Foundation Inc. (http://zuha.org)
 *
 * Licensed under GPL v3 License
 * Must retain the above copyright notice and release modifications publicly.
 *
 * @copyright     Copyright 2009-2013, Zuha Foundation Inc. (http://zuha.com)
 * @link          http://zuha.com Zuha Project
 * @package       zuha
 * @subpackage    zuha.app
 * @since         Zuha(tm) v 1.15.13
 * @license       GPL v3 License (http://www.gnu.org/licenses/gpl.html) and Future Versions
 */
App::uses('BaseAuthenticate', 'Controller/Component/Auth');

/**
 * An authentication adapter for AuthComponent.  Provides the ability to authenticate using POST
 * data.  Can be used by configuring AuthComponent to use it via the AuthComponent::$authenticate setting.
 *
 * {{{
 *	$this->Auth->authenticate = array(
 *		'Form' => array(
 *			'scope' => array('User.active' => 1)
 *		)
 *	)
 * }}}
 *
 * When configuring FormAuthenticate you can pass in settings to which fields, model and additional conditions
 * are used. See FormAuthenticate::$settings for more information.
 *
 * @package       Cake.Controller.Component.Auth
 * @since 2.0
 * @see AuthComponent::$authenticate
 */
class FormAuthenticate extends BaseAuthenticate {

/**
 * Authenticates the identity contained in a request.  Will use the `settings.userModel`, and `settings.fields`
 * to find POST data that is used to find a matching record in the `settings.userModel`.  Will return false if
 * there is no post data, either username or password is missing, of if the scope conditions have not been met.
 * 
 * @note We added the array check of $fields['username'] to support logging in with either email or username in Form.User.username
 * We also HARDCODED the form field that it looks for the username/email in, as 'username' ib  line 67
 * 1/15/2013
 *
 * @param CakeRequest $request The request that contains login information.
 * @param CakeResponse $response Unused response object.
 * @return mixed.  False on login failure.  An array of User data on success.
 */
	public function authenticate(CakeRequest $request, CakeResponse $response) {
		$userModel = $this->settings['userModel'];
		list($plugin, $model) = pluginSplit($userModel);

		$fields = $this->settings['fields'];
		if (empty($request->data[$model])) {
			return false;
		}

		if(is_array($fields['username'])) {
			$foundUser = false;
			foreach($fields['username'] as $field) {
				$this->settings['fields']['username'] = $field;
				$foundUser = $this->_findUser($request->data[$model]['username'], $request->data[$model][$fields['password']]);
				if($foundUser) {
					break;
				}
			}
			
			return $foundUser;
			
		} else {
			
			if (
				empty($request->data[$model][$fields['username']]) ||
				empty($request->data[$model][$fields['password']])
			) {
				return false;
			}
			
			return $this->_findUser(
				$request->data[$model][$fields['username']],
				$request->data[$model][$fields['password']]
			);
		}
	}

}