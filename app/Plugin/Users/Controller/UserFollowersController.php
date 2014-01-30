<?php
App::uses('UsersAppController', 'Users.Controller');
/**
 * Class AppUserFollowersController
 * @property UserFollower UserFollower
 */
class AppUserFollowersController extends UsersAppController {

	public $name = 'UserFollowers';
	public $uses = 'Users.UserFollower';

	function index() {
		$this->UserFollower->recursive = 0;
		$this->set('userfollowers', $this->paginate());
	}

	function view($user = null) {
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
	function add($uid) {
		$this->request->data['UserFollower']['user_id'] = $uid;
		$this->request->data['UserFollower']['follower_id'] = $this->Auth->user('id');	
		if($this->UserFollower->find('first', array('conditions' => array('user_id' => $uid, 'follower_id' => $this->Auth->user('id'))))) {
			$this->Session->setFlash('You are already following this user');
			$this->redirect(array('plugin'=>'users', 'controller'=>'users', 'action'=>'view', $uid));
		} else {
			$this->UserFollower->create();
			if ( $this->UserFollower->save($this->request->data) ) {
				$this->Session->setFlash('You are already following this user');
				$this->redirect(array('plugin'=>'users', 'controller'=>'users', 'action'=>'view', $uid));
			}
		}
		
	}

	function edit($id = null) {
		if ( !$id && empty($this->request->data) ) {
			$this->flash(sprintf(__('Invalid user follower', true)), array('action' => 'index'));
		}
		if ( !empty($this->request->data) ) {
			if ( $this->UserFollower->save($this->request->data) ) {
				$this->flash(__('The user follower has been saved.', true), array('action' => 'index'));
			} else {
			}
		}
		if ( empty($this->request->data) ) {
			$this->request->data = $this->UserFollower->read(null, $id);
		}
		$users = $this->UserFollower->User->find('list');
		$this->set(compact('users'));
	}

	function delete($id = null) {
		if ( !$id ) {
			$this->flash(sprintf(__('Invalid user follower', true)), array('action' => 'index'));
		}
		if ( $this->UserFollower->deleteAll(array('user_id'=>$id, 'follower_id'=> $this->Auth->user('id'))) ) {
			$this->flash(__('User follower deleted', true), array('action' => 'index'));
		} else {
			exit;
			$this->flash(__('User follower was not deleted', true), array('action' => 'index'));
		}
		//$this->redirect(array('action' => 'index'));
		$this->redirect(array('plugin'=>'users', 'controller'=>'users', 'action'=>'view', $id));
	}
    
    function destroy($id = null) {
        $uid = $this->Auth->user('id');
        if ( !$id ) {
            $this->Session->setFlash('Invalid User');
            $this->redirect(array('plugin'=>'users', 'controller'=>'users', 'action'=>'view', $uid));
        }

        try {
            $this->UserFollower->deleteAll(array('user_id'=>$id, 'follower_id'=> $uid));
            $this->UserFollower->deleteAll(array('user_id'=>$uid, 'follower_id'=> $id));
            $this->Session->setFlash('Relationship Deleted');
        }catch (Exception $e) {
            $this->Session->setFlash('User Not Deleted');
            $this->redirect(array('plugin'=>'users', 'controller'=>'users', 'action'=>'view', $uid));
        }       
        //$this->redirect(array('action' => 'index'));
        $this->redirect(array('plugin'=>'users', 'controller'=>'users', 'action'=>'view', $uid));
    }
	
	function revoke($id = null) {
		if ( !$id ) {
			$this->flash(sprintf(__('Invalid user follower', true)), array('action' => 'index'));
		}
		if ( $this->UserFollower->deleteAll(array('user_id' => $this->Auth->user('id'), 'follower_id' => $id)) ) {
			$this->flash(__('Follower deleted', true), array('action' => 'index'));
		} else {
			exit;
			$this->flash(__('Follower was not deleted', true), array('action' => 'index'));
		}
		//$this->redirect(array('action' => 'index'));
		$this->redirect(array('plugin'=>'users', 'controller'=>'users', 'action'=>'view', $this->Auth->user('id')));
	}

}


if (!isset($refuseInit)) {
	class UserFollowersController extends AppUserFollowersController {}
}
