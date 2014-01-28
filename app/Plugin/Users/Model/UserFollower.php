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

	private function _changeStatus($requestId,$userId,$status){
		$row = $this->read(array('approved','user_id'),$requestId);


		if(!empty($row) && $row['UserFollower']['user_id'] == $userId){
			$data = array(
				'UserFollower'=>array(
					'approved'=> $status,
					'id'	=>$requestId
				),
			);
			return $this->save($data);
		}

		return false;
	}
	public function approve($requestId,$userId){
		$this->_changeStatus($requestId,$userId,1);

	}

	public function decline($requestId,$userId){
		$this->_changeStatus($requestId,$userId,-2);
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

		}else{
			$isSentRequest = $this->find('first',array(
				'conditions'=>array(
					'user_id' =>$uid,
					'follower_id' => $followerId
				),
			));
			if(!empty($isSentRequest)){
				$returnValue = $isSentRequest['UserFollower']['approved'] === true ? true : 0;
			}
		}

		return $returnValue;

	}

	public	function getPendingRequetCount($userId){

		return $this->find('count',array('conditions'=>array(
			'approved' => null,
			'user_id'	=>$userId,
		)));


	}

}
