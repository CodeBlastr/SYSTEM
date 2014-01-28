<?php
App::uses('UsersAppModel', 'Users.Model');

class UserFollower extends UsersAppModel {
	public $name = 'UserFollower';
	//The Associations below have been created with all possible keys, those that are not needed can be removed
    
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


	public function approve($requestId,$userId){
		$row = $this->read(array('approved','user_id'),$requestId);
		if(!empty($row) && $row['UserFollower']['user_id'] == $userId){
			$data = array(
				'UserFollower'=>array(
					'approved'=> 1,
					'id'	=>$requestId
				),
			);
			return $this->save($data);
		}
		return false;
	}


/**
 * @param $uid | user id
 * @param $followerId | user id
 * @return int $returnValue  | 1 -- friends(approved)
 *							 | 0 -- request sent, waiting for approve
 *                           | -1 -- not follow(no request sent, not followed, no relationship)
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
			$returnValue = $isSentMeRequest['UserFollower']['approved'] === true ? true :$isSentMeRequest['UserFollower']['id'];
		} else {
			$isSentRequest = $this->find('first',array(
				'conditions'=>array(
					'user_id' =>$uid,
					'follower_id' => $followerId
				)
			));
			if(!empty($isSentRequest)){
				$returnValue = $isSentRequest['UserFollower']['approved'] === true ? true : 0;
			}
		}
		return $returnValue;
	}

	public	function getPendingRequetCount($userId){
		return count($this->find('list',array('conditions'=>array(
			'approved' => null,
			'user_id'	=>$userId,
		))));
	}
	
	public function followEachOther($creatorUserId = null, $userId = null) {
		if (!empty($creatorUserId) && !empty($userId)) {
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
			if ($this->saveAll($data)) {
				return true;
			} else {
				debug($data);
				debug($this->invalidFields());
				exit;
				throw new Exception($this->invalidFields());
			}
		} else {
			throw new Exception(__('Two users are required to follow each other.'));
		}
	}

}
