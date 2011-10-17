<?php
class Banner extends AppModel {
	var $name = 'Banner';
	var $displayField = 'name';
	
	var $validate = array(
		'discount_price' => array(
			'comparePrice' => array(
				'rule' => array('_comparePrice'),
				'allowEmpty' => true,
				'message' => 'Sale price should be at least 40% off.'
				),
			),
		'name' => array(
			'notempty' => array(
				'rule' => 'notEmpty',
				'message' => 'Please Enter a value.'
				),
			),
		);

	var $hasOne = array(
		'OrderItem' => array(
			'className' => 'Orders.OrderItem',
			'foreignKey' => 'foreign_key',
			'conditions' => array('OrderItem.model' => 'Banner'),
			'fields' => '',
			'order' => ''
		),
		'BannerView' => array(
			'className' => 'BannerView',
			'foreignKey' => 'banner_id',
		),
		'Gallery' => array(
			'className' => 'Galleries.Gallery',
			'foreignKey' => 'foreign_key',
			'dependent' => false,
			'conditions' => array('Gallery.model' => 'Banner'),
		)
	);

	var $belongsTo = array(
		'BannerPosition' => array(
			'className' => 'BannerPosition',
			'foreignKey' => 'banner_position_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Customer' => array(
			'className' => 'Users.User',
			'foreignKey' => 'customer_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Creator' => array(
			'className' => 'Users.User',
			'foreignKey' => 'creator_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Modifier' => array(
			'className' => 'Users.User',
			'foreignKey' => 'modifier_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
	);
	
	function _comparePrice() {
		# fyi, confirm password is hashed in the beforeValidate method
		if (!empty($this->data['Banner']['discount_price']) && 
				(40 > (($this->data['Banner']['price'] - $this->data['Banner']['discount_price']) / $this->data['Banner']['price'] * 100))) {
			return false;
		} else {
			return true;
		}
	}
	
	/*
	 * Function used to get banner_position_id 
	 * @param = bannerType   
	 */
	function get_banner_position_id($bannerType = null) {
		if (!empty($bannerType)) {
			$positionId = enum('BANNER_TYPE', $bannerType);
			if (!empty($positionId)) {
				$banner_position_id = $this->BannerPosition->find('first', array('fields' => 'id',
							'conditions' => array('BannerPosition.banner_type_id' => $positionId)));
			}
			return $banner_position_id['BannerPosition']['id'] ;
		}
	}
	
	
	
	
	/**
	 * Get the price of the banner position being purchased
	 *
	 * @todo 		Make this so that it comes from a db table or a settings constant. (temporarily hard coded prices to get this done.
	 */
	function getBannerPrice($data) {
		if (!empty($data['Banner']['schedule_start_date']) && !empty($data['Banner']['schedule_end_date'])) {
			# decide the time period... daily, weekly, monthly
			$startDate = $data['Banner']['schedule_start_date'];
			$endDate = $data['Banner']['schedule_end_date']; 
			if ((round(strtotime($endDate) - strtotime($startDate)) / 86400) > 27) {
				$schedule = 'monthly';
			} else if ((round(strtotime($endDate) - strtotime($startDate)) / 86400) > 4) {
				$schedule = 'weekly';
			} else {
				$schedule = 'daily';
			}
		}
		
		if ($schedule == 'monthly') {
			return 2000;
		} else if ($schedule == 'weekly') {
			return 500;
		} else {
			$bannerPosition = $this->BannerPosition->find('first', array('fields' => 'price',
							'conditions' => array('BannerPosition.id' => $data['Banner']['banner_position_id'])));
		 	return $bannerPosition['BannerPosition']['price'];
		}	
	}
	
}
?>