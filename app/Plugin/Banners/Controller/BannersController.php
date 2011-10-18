<?php
class BannersController extends AppController {

	var $name = 'Banners';
	var $helpers = array('javascript');
	var $allowedActions = array('daily_deal_data', 'banner_index', 'daily_deal', 'selected_deal', 
				'all_daily_deals', 'redeemed', 'view_offer', 'home');
		 
	function index() {
		$this->settings['conditions']['Banner.customer_id'] = $this->Auth->user('id');
		$this->settings['order']['Banner.schedule_end_date'] = 'DESC';
		$this->paginate = $this->settings;
		$this->set('banners', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid banner', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('banner', $this->Banner->read(null, $id));
	}

	function add() {
		if (!empty($this->data)) {
			$this->Banner->create();
			if ($this->Banner->save($this->data)) {
				$this->Session->setFlash(__('The banner has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The banner could not be saved. Please, try again.', true));
			}
		}
		$bannerPositions = $this->Banner->BannerPosition->find('list');
		$customers = $this->Banner->Customer->find('list');
		$creators = $this->Banner->Creator->find('list');
		$modifiers = $this->Banner->Modifier->find('list');
		$this->set(compact('bannerPositions', 'customers', 'creators', 'modifiers'));
	}

	/*
	 *  function home() for home page
	 */
	function home() {
		
	}
	
	/*
	 * This function is for purchasing a add space
	 * and create a banner_ad
	 * 
	 * @todo		replace the locations variable with a system setting, that goes along with the splits
	 * @todo		when ever you use a constant, check if its defined first
	 * @todo		move this entire function to the model, so that if any other controller function wants to cause a buy action, it can be reused easily. 
	 * @todo		we don't know if the banner was actually purchased, and it will just sit there looking like its been purchased, as soon as this buy() function fires.  we need to make a new field called status, with options like, "reserved", "paid", "draft", "published", then we can delete unpaid if they haven't been purchased within a reasonable period of time.
	 * @todo		there might be a better way to handle the cart than emptying the cart before each checkout, once we use status in order to see if the banners are reserved, then we could add them all to cart or something like that
	 */
	function buy() {
		if (!empty($this->data)) {
			
			$bannerPrice = $this->Banner->getBannerPrice($this->data);
			
			$this->Banner->create();
			if ($this->Banner->save($this->data)) {
			
				// if location is given and settings defined for locations 
				if(isset($this->data['Banner']['location']) && defined('__ORDERS_LOCATIONS')) {
					$banner_locations = unserialize(__ORDERS_LOCATIONS);
					$loc_settings = array();
    	 			foreach($banner_locations[$this->data['Banner']['location']] as $k => $payOptions) {
        	 			$paySettings = explode(',' , $payOptions);
        	 		    $lsettings = array("receiverAmountArray.{$k}" => $paySettings[0],
        	 							"receiverEmailArray.{$k}" => $paySettings[1]);
    	 				$loc_settings = array_merge($loc_settings, $lsettings);
    	 			}
				}

				$name = array('Age Group' =>$this->data['Banner']['age_group'],
						 'Start Date' => $this->data['Banner']['schedule_start_date'], 
						 'End Date' => $this->data['Banner']['schedule_end_date'], 
						 'Gender' => $this->data['Banner']['gender'],
						 'Chained' => isset($loc_settings) ? $loc_settings : '' );

				$this->data['OrderItem']['name'] = serialize($name);
				$this->data['OrderItem']['price'] = $bannerPrice;
				$this->data['OrderItem']['quantity'] = 1;
				$this->data['OrderItem']['customer_id'] = $this->Auth->user("id");
				$this->data['OrderItem']['status'] = 'incart';
				$this->data['OrderItem']['foreign_key'] = $this->Banner->id;
				$this->data['OrderItem']['model'] = 'Banner'; 
				$this->data['OrderItem']['is_virtual'] = 1; 
				# remove old items from cart first, and delete reserved spots, you can only buy one banner at a time
				$currentCartItems = $this->Banner->OrderItem->prepareCartData($this->Auth->user('id'));
				if (!empty($currentCartItems)) { foreach ($currentCartItems as $currentItem) {
					$this->Banner->OrderItem->delete($currentItem['OrderItem']['id']);
				} }
			
				if ($this->Banner->OrderItem->save($this->data)) {
					$this->redirect(array('plugin' => 'orders', 'controller' => 'order_transactions' , 'action'=>'checkout'));
				} 
			} else {
				$this->Session->setFlash(__('The banner could not be saved. Please, try again.', true));
			}
		}
		
		$bannerPositionId = $this->Banner->get_banner_position_id($this->request->params['named']['bannerType']);
		$bannerPositionsPrice = $this->Banner->BannerPosition->find('list', array('fields' => array('id', 'price')));
		$age_group = unserialize(__ELEMENT_BANNER_AGEGROUP);
		
		//if locations defined then we will show select box
		if(defined('__ORDERS_LOCATIONS')) {
				$banner_locations = unserialize(__ORDERS_LOCATIONS);
				$locations = array_keys($banner_locations);
				$locations = array_combine($locations, $locations);
		}

		$this->set(compact('bannerPositionId', 'bannerPositionsPrice', 'age_group', 'locations'));
	}
	
	
	/*
	 * function get_avaialable_slots()
	 * gets the available slots for the given location,country, state.
	 *
	 * @todo 		Get rid of the json_encode() thing, you only need to put .json on the url
	 */
	function get_avaialable_slots() {
		Configure::write('debug', 0);
		$this->autoRender = false;
		$conditions = array('Banner.banner_position_id' => $this->data['Banner']['banner_position_id'],
							'Banner.location' => $this->data['Banner']['location'] ,
							//'Banner.schedule_start_date' => $this->data['Banner']['schedule_start_date'],
							//'Banner.schedule_end_date' => $this->data['Banner']['schedule_start_date']
							'OR' => array('Banner.schedule_start_date BETWEEN ? AND ?' => array(
											$this->data['Banner']['schedule_start_date'],
											$this->data['Banner']['schedule_end_date']),
										'Banner.schedule_end_date BETWEEN ? AND ?' => array(
											$this->data['Banner']['schedule_start_date'],
											$this->data['Banner']['schedule_end_date']))			
		);
		$reservedSlots = $this->Banner->find('list', array(
				'fields' => array('Banner.id', 'Banner.gender', 'Banner.age_group'),
												'conditions' => $conditions,
		));
		$age_group = unserialize(__ELEMENT_BANNER_AGEGROUP);
		$restricted_age = array_keys($reservedSlots);
		
			foreach($age_group  as $group => $gen) {
					$data[$group]['M']= '1';
					$data[$group]['F']= '1';
				
				if (in_array($group, $restricted_age)) {
					foreach($reservedSlots[$gen] as $gender) {
						$data[$group][$gender] = '0';
					}
					
				} 	
			}
		# YOU DON'T NEED THIS HERE, JUST PUT .json ON THE END OF THE URL
		echo json_encode($data);
	}
	
	/*
	 * function preview shows the preview of the given banner_id  
	 */
	function preview($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid banner', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('banner', $this->Banner->read(null, $id));
	}
	
	/*
	 * function is_published set the banner as published 
	 */
	function is_published($id = null) {
		if ($id) {
			$data['Banner']['id'] = $id;
			$data['Banner']['is_published'] = 1;
			$this->Banner->save($data);
			$this->redirect(array('action' => 'preview', $id));
		}
	}
	
	/*
	 * function reports get the parameter banner_id and 
	 * give the details of it how many views  the ad 
	 */
	function reports($id = null) {
		$banners = $this->Banner->BannerView->find('all', array('fields' => array('banner_id', 'gender', 'age_group', 
										'created', 'count(age_group) as count'),
							'conditions'=> array('banner_id' => $id, 'is_redeemed' => 0),
							'group' => array("gender","age_group"),
					));
		$banner = $this->Banner->find('first', array('fields' => array('price', 'discount_price'),
														'conditions' => $id));
		
		$redeem_count = $this->Banner->BannerView->find('first', array('fields' => array('count(is_redeemed) as count'),
							'conditions'=> array('banner_id' => $id, 'is_redeemed' => 1),
					));
		
		$ammountReport['amount_redeemed'] = (intval($banner['Banner']['discount_price']))
						 * intval($redeem_count['BannerView']['count']) ;
						 
		$ammountReport['amount_saved'] = (intval($banner['Banner']['price']) - intval($banner['Banner']['discount_price']))
						 * intval($redeem_count['BannerView']['count']) ; 
						 
		$this->set('redeem_count', $redeem_count['BannerView']['count']);
		$this->set(compact('banners', 'ammountReport'));
	}
	
	/*
	 * function report_clicks gets the clicks hourly for a given
	 * banner id
	 */
	function report_clicks($id = null){
		$this->autoRender = false;
		$banners = $this->Banner->BannerView->find('all', array('fields' => array('count(view_hourly) as clicks', 'view_hourly'),
							'conditions'=> array('banner_id' => $id),
							'group' => "view_hourly",
							'order' => array('BannerView.view_hourly ASC')
		));
		echo json_encode($banners);
	}
	
	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid banner', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if (!empty($this->data['Banner']['discount_price']) && !empty($this->data['Banner']['price'])) {
				$this->data['Banner']['discount_percentage'] = round((intval($this->data['Banner']['discount_price'])
																		/intval($this->data['Banner']['price'])) * 100); 
			}
			if ($this->Banner->save($this->data)) {
				if (!empty($this->data['Gallery']['id'])) {
					try {
						$this->Banner->Gallery->makeThumb($this->data);			
					} catch (Exception $e) {
						$this->Session->setFlash($e->getMessage());
					}
				} else {
					$this->data['Gallery']['model'] = 'Banner';
					$this->data['Gallery']['foreign_key'] = $this->Banner->id;
					$this->Banner->Gallery->GalleryImage->add($this->data, 'filename');
					# make the image the thumb (have to do this in case its an edit of a previous ad)
					$this->data['GalleryImage']['id'] = $this->Banner->Gallery->GalleryImage->id;
				}
				$this->Session->setFlash(__('Saved', true));
				$this->redirect(array('action' => 'preview', $this->Banner->id));
			} else {
				$this->Session->setFlash(__('Could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Banner->find('first', array(
				'conditions' => array(
					'Banner.id' => $id
					),
				'contain' => array(
					'Gallery' => array(
						'GalleryImage',
						),
					),
				));
		}
		
		$bannerPositions = $this->Banner->BannerPosition->find('list');
		$customers = $this->Banner->Customer->find('list');
		$creators = $this->Banner->Creator->find('list');
		$modifiers = $this->Banner->Modifier->find('list');
		$this->set(compact('bannerPositions', 'customers', 'creators', 'modifiers'));
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for banner', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Banner->delete($id)) {
			$this->Session->setFlash(__('Banner deleted', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Banner was not deleted', true));
		$this->redirect(array('action' => 'index'));
	}
	function admin_index() {
		$this->Banner->recursive = 0;
		$this->set('banners', $this->paginate());
	}

	function admin_view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid banner', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('banner', $this->Banner->read(null, $id));
	}

	function admin_add() {
		if (!empty($this->data)) {
			$this->Banner->create();
			if ($this->Banner->save($this->data)) {
				$this->Session->setFlash(__('The banner has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The banner could not be saved. Please, try again.', true));
			}
		}
		$bannerPositions = $this->Banner->BannerPosition->find('list');
		$customers = $this->Banner->Customer->find('list');
		$creators = $this->Banner->Creator->find('list');
		$modifiers = $this->Banner->Modifier->find('list');
		$this->set(compact('bannerPositions', 'customers', 'creators', 'modifiers'));
	}

	function admin_edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid banner', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->Banner->save($this->data)) {
				$this->Session->setFlash(__('The banner has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The banner could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Banner->read(null, $id);
		}
		$bannerPositions = $this->Banner->BannerPosition->find('list');
		$customers = $this->Banner->Customer->find('list');
		$creators = $this->Banner->Creator->find('list');
		$modifiers = $this->Banner->Modifier->find('list');
		$this->set(compact('bannerPositions', 'customers', 'creators', 'modifiers'));
	}

	function admin_delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for banner', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Banner->delete($id)) {
			$this->Session->setFlash(__('Banner deleted', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Banner was not deleted', true));
		$this->redirect(array('action' => 'index'));
	}
	
	//below functions are for mobile 
	/*
	 * function banner_index() set the demographic value in session variables
	 * this action is for mobile index page  
	 */
	function banner_index() {
		//save demographic data in session variables
		$this->Session->write("email", $this->data['Banner']['email']);
		$this->Session->write("gender", $this->data['Banner']['gender']);
		$this->Session->write("age_group", $this->data['Banner']['age_group']);
		$this->Session->write("location", $this->data['Banner']['location']);
		
		App::Import('Model', 'Location');
		$req_loc = new Location();
		$location = $req_loc->get_city();
		$age_group = unserialize(__ELEMENT_BANNER_AGEGROUP);
		$this->set(compact('age_group', 'location'));
	}	
	
	/*
	 * Function used to show daily deal 
	 * 
	 */
	function daily_deal() {
		
	}
	
	/*
	 * Function used to get banner 
	 * @param = bannerType   
	 */
	function daily_deal_data($bannerType = null) {
		$banner_position_id['BannerPosition']['id'] = $this->Banner->get_banner_position_id($bannerType);
		$options['conditions'] = array();
		if (isset($banner_position_id['BannerPosition']['id'])){
			$options['conditions']['Banner.banner_position_id'] = $banner_position_id['BannerPosition']['id'];
		}
		$options['conditions'] = array_merge($options['conditions'], array('Banner.schedule_end_date >=' => date('Y-m-d'),
											'Banner.schedule_start_date <=' => date('Y-m-d'),
											'Banner.gender' => $this->Session->read("gender"),
											'Banner.is_published' => 1,
											'Banner.age_group' => $this->Session->read("age_group"),
											'Banner.location' => $this->Session->read("location"))
		);
		$dealItem = $this->Banner->find('first', $options);
		if(empty($dealItem)) {
			$this->Session->setFlash(__('No Banner Is Live', true));
		} else {
			$data['BannerView']['banner_id'] = $dealItem['Banner']['id'];
			$data['BannerView']['email'] = $this->Session->read("email");
			$data['BannerView']['gender'] = $this->Session->read("gender");
			$data['BannerView']['age_group'] = $this->Session->read("age_group");
			$data['BannerView']['view_hourly'] = date('Y-m-d h:00');
			$this->Banner->BannerView->save($data);
			return $dealItem;
		}
	}
	/*
	 * function selected_deal get the deal data which is 
	 * selected from all deals 
	 */
	function selected_deal($id = null) {
		if (!empty($id)) {
			$dealItem = $this->Banner->find('first', array('conditions' => array(
						'Banner.id' => $id)));	
		}
		if(empty($dealItem)) {
			$this->Session->setFlash(__('No Banner Is Live', true));
		} else {
			$data['BannerView']['banner_id'] = $dealItem['Banner']['id'];
			$data['BannerView']['gender'] = $this->Session->read("gender");
			$data['BannerView']['age_group'] = $this->Session->read("age_group");
			$data['BannerView']['view_hourly'] = date('Y-m-d h:00');
			$this->Banner->BannerView->save($data);
			$this->set(compact('dealItem'));
		}
	}
	
	/*
	 *  function all_daily_deals() gets all the active deals for the day 
	 *  which are published 
	 */
	function all_daily_deals() {
		$options['conditions'] = array('Banner.schedule_end_date >=' => date('Y-m-d'),
									'Banner.schedule_start_date <=' => date('Y-m-d'),
									'Banner.is_published' => 1
		);
		$dailyDeals = $this->Banner->find('all', $options);
		if(empty($dailyDeals)) {
			$this->Session->setFlash(__('No Banner Is Live', true));
		} else {
			$this->set(compact('dailyDeals'));
		}
	}
	
	/*
	 * when a user redeemed a deal it will 
	 * create a record in banner_view with is_redeemed = 1
	 */
	function redeemed($banner_id) {
		$redeemDeal = $this->Banner->find('first', array('conditions' => array('Banner.id' => $banner_id)));
		if(!empty($redeemDeal)) {		
			$data['BannerView']['banner_id'] = $banner_id;
			$data['BannerView']['gender'] = $this->Session->read("gender");
			$data['BannerView']['age_group'] = $this->Session->read("age_group");
			$data['BannerView']['is_redeemed'] = 1;
			$this->Banner->BannerView->save($data);
			$this->set(compact('redeemDeal'));
		}
	}
	
	/*
	 * Function used to check the banner look at mobile 
	 * @params banner_id 
	 */
	function banner_preview($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid banner', true));
		}
		$this->set('banner', $this->Banner->read(null, $id));
	}
	
	/*
	 * function view_offer() uses to view Advertizer offer
	 */
	function view_offer() {

	}
}
?>