<?php
App::uses('UsersAppController', 'Users.Controller');
/**
 * Class AppUserFollowersController
 * @property UserFollower UserFollower
 */
class AppUserFollowersController extends UsersAppController {

	public $name = 'UserFollowers';

	public $uses = 'Users.UserFollower';

	public function index($userId = null) {
		$this->UserFollower->recursive = 0;
		!empty($userId) ? $this->paginate['conditions']['UserFollower.user_id'] = $userId : null;
		$this->set('userFollowers', $this->request->data = $this->paginate());
		$this->set('user', $user = $this->UserFollower->User->find('first', array('conditions' => array('User.id' => $userId))));
		return $this->request->data;
	}

	public function my() {
		$this->UserFollower->recursive = 0;
		$this->paginate['conditions']['UserFollower.user_id'] = $this->Session->read('Auth.User.id');
		$this->set('userFollowers', $this->request->data = $this->paginate('UserFollower'));
		return $this->request->data;
	}

	public function view($user = null) {
		$dat = $this->UserFollower->find('all', array(
			'conditions'=>array(
				'UserFollower.user_id' => $user
			),
			'contain' => array('User')
		));
		$this->set('dat', $dat);
	}
	
/*
 * 
 * Follow a user 
 * @param {int} uid => The id of the user
 */
	public function add($userId) {
		if ($this->request->is('post')) {
			$this->request->data['UserFollower']['user_id'] = $userId;
			$this->request->data['UserFollower']['follower_id'] = $this->Auth->user('id');	
			if($this->UserFollower->find('first', array('conditions' => array('user_id' => $userId, 'follower_id' => $this->Auth->user('id'))))) {
				$this->Session->setFlash('You are already following this user', 'flash_info');
				$this->redirect(array('plugin' => 'users', 'controller' => 'users', 'action' => 'view', $userId));
			} else {
				$this->UserFollower->create();
				if ( $this->UserFollower->save($this->request->data) ) {
					$this->Session->setFlash('Request sent', 'flash_success');
					$this->redirect(array('plugin' => 'users', 'controller' => 'users', 'action' => 'view', $userId));
				}
			}
		}
	}
	
/*
 * 
 * Follow a user 
 * @param {int} uid => The id of the user
 */
	public function approve($id = null, $mutual = null) {
		// $id = $this->UserFollower->find('first', array('UserFollower.id' => $id));
		// $id = $id['UserFollower']['follower_id']; 
		if ($mutual) {
			$follower = $this->UserFollower->find('first', array('conditions' => array('UserFollower.id' => $id)));
			if (!empty($follower)) {
				if ($this->UserFollower->followEachOther($follower['UserFollower']['user_id'], $follower['UserFollower']['follower_id'])) {
					$this->Session->setFlash('Approved', 'flash_success');
				} else {
					$this->Session->setFlash('Failed, please try again.', 'flash_warning');
				}
			} else {
				$this->Session->setFlash('Invalid request id', 'flash_danger');
			}
		} elseif ($this->UserFollower->approve($id, $this->Session->read('Auth.User.id'))) { 
			$this->Session->setFlash('Approved', 'flash_success');
		} else {
			$this->Session->setFlash('Failed, please try again.', 'flash_warning');
		}
		$this->redirect($this->referer()); 
	}

/**
 * Edit method
 * 
 * @param string
 */
	public function edit($id = null) {
		if ( !$id && empty($this->request->data) ) {
			$this->flash(sprintf(__('Invalid user follower', true)), 'flash_danger');
		}
		if ( !empty($this->request->data) ) {
			if ( $this->UserFollower->save($this->request->data) ) {
				$this->flash(__('The user follower has been saved.', true),  'flash_success');
			} else {
			}
		}
		if ( empty($this->request->data) ) {
			$this->request->data = $this->UserFollower->read(null, $id);
		}
		$users = $this->UserFollower->User->find('list');
		$this->set(compact('users'));
	}

	public function delete($id = null) {
		if ( !$id ) {
			$this->flash(sprintf(__('Invalid user follower', true), 'flash_danger'), array('action' => 'index'));
		}
		if ( $this->UserFollower->deleteAll(array('user_id' => $id, 'follower_id' => $this->Auth->user('id'))) ) {
			$this->Session->setFlash(__('Deleted'), 'flash_success');
			$this->redirect($this->referer()); 
		} else {
			$this->Session->setFlash(__('Error Deleting', true), 'flash_warning');
			$this->redirect($this->referer()); 
		}
	}
    
    public function destroy($id = null) {
        $userId = $this->Auth->user('id');
        if ( !$id ) {
            $this->Session->setFlash('Invalid User');
            $this->redirect(array('plugin' => 'users', 'controller' => 'users', 'action' => 'view', $userId));
        }

        try {
            $this->UserFollower->deleteAll(array('user_id'=>$id, 'follower_id'=> $userId));
            $this->UserFollower->deleteAll(array('user_id'=>$userId, 'follower_id'=> $id));
            $this->Session->setFlash('Relationship Deleted', 'flash_success');
        }catch (Exception $e) {
            $this->Session->setFlash('User Not Deleted', 'flash_warning');
            $this->redirect(array('plugin' => 'users', 'controller' => 'users', 'action' => 'view', $userId));
        }       
        //$this->redirect(array('action' => 'index'));
        $this->redirect(array('plugin' => 'users', 'controller' => 'users', 'action' => 'view', $userId));
    }
	
	public function revoke($id = null) {
		if ( !$id ) {
			$this->flash(sprintf(__('Invalid user follower', true), 'flash_danger'), array('action' => 'index'));
		}
		if ( $this->UserFollower->deleteAll(array('user_id' => $this->Auth->user('id'), 'follower_id' => $id)) ) {
			$this->flash(__('Follower deleted', 'flash_success'), array('action' => 'index'));
		} else {
			exit;
			$this->flash(__('Follower was not deleted', 'flash_warning'), array('action' => 'index'));
		}
		//$this->redirect(array('action' => 'index'));
		$this->redirect(array('plugin' => 'users', 'controller' => 'users', 'action' => 'view', $this->Auth->user('id')));
	}

}


if (!isset($refuseInit)) {
	class UserFollowersController extends AppUserFollowersController {}
}
