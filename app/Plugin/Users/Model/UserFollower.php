<?php
App::uses('UsersAppModel', 'Users.Model');

class AppUserFollower extends UsersAppModel {

	public $name = 'UserFollower';
    
	public $belongsTo = array(
		'User' => array(
			'className' => 'Users.User',
			'foreignKey' => 'user_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'UserRef' => array(
            'className' => 'Users.User',
            'foreignKey' => 'follower_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        )
	);

/**
 * Change status
 */
	private function _changeStatus($requestId, $userId, $status){
		$row = $this->read(array('approved','user_id'), $requestId);
		if(!empty($row) && $row['UserFollower']['user_id'] == $userId){
			$data = array(
				'UserFollower'=>array(
					'approved' => $status,
					'id' => $requestId
				),
			);
			return $this->save($data);
		}
		return false;
	}

/**
 * Approve method
 */
	public function approve($requestId, $userId){
		return $this->_changeStatus($requestId, $userId, 1);
	}

/**
 * Decline method
 */
	public function decline($requestId, $userId){
		return $this->_changeStatus($requestId, $userId, -1);
	}


/**
 * @param $uid | user id
 * @param $followerId | user id
 * @return int $returnValue  | 1 -- friends(approved)
 *							 | 0 -- request sent, waiting for approve
 *                           | -1 -- not follow(no request sent, not followed, no relationship, or be declined)
 * 							 | >1 -- waiting approve by me, return id in user_followers table
 */
	public function checkFollowStatus($uid, $followerId){
		$returnValue = -1;
		$isSentMeRequest = $this->find('first',array(
			'conditions'=>array(
				'user_id' =>$followerId,
				'follower_id' => $uid
			),
		));
		if(!empty($isSentMeRequest)){
			$returnValue = $isSentMeRequest['UserFollower']['approved'] == 1 ? true :$isSentMeRequest['UserFollower']['id'];
		} else {
			$isSentRequest = $this->find('first',array(
				'conditions'=>array(
					'user_id' =>$uid,
					'follower_id' => $followerId
				)
			));
			if(!empty($isSentRequest)){
				$returnValue = $isSentRequest['UserFollower']['approved'] == 1 ? true : 0;
			}
		}
		return $returnValue;
	}
	public function isMyRequest($requestId,$userId){
		return $this->find('count',array('conditions'=>array('id'=>$requestId,'user_id'=>$userId))) == 1;

	}
	public function getPendingRequetCount($userId){
		return $this->find('count',array('conditions'=>array(
			'approved' => array(null,-1,0),
			'user_id'	=>$userId,
		)));
	}

/**
 * Follow each other
 */
	public function followEachOther($creatorUserId = null, $userId = null) {
		if (!empty($creatorUserId) && !empty($userId)) {
			// delete any existing matches first
			$this->deleteAll(array('UserFollower.user_id' => $creatorUserId, 'UserFollower.follower_id' => $userId), false);
			$this->deleteAll(array('UserFollower.user_id' => $userId, 'UserFollower.follower_id' => $creatorUserId), false);
			// save a new record for each user
			$data = array(
				array(
					'UserFollower' => array(
						'user_id' => $creatorUserId,
						'follower_id' => $userId,
						'approved' => 1
					)
				),
				array(
					'UserFollower' => array(
						'user_id' => $userId,
						'follower_id' => $creatorUserId,
						'approved' => 1
					)
				)
			);
			$this->create();
			if ($this->saveAll($data)) {
				return true;
			} else {
				throw new Exception($this->invalidFields());
			}
		} else {
			throw new Exception(__('Two users are required to follow each other.'));
		}
	}

}

if (!isset($refuseInit)) {
	class UserFollower extends AppUserFollower {}
}
