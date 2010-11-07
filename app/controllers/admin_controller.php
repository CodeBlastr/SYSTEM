<?php
/**
 * Admin Dashboard Controller
 *
 * This controller will output variables used for the Admin dashboard.
 * Primarily conceived as the hub for managing the rest of the app.
 *
 * PHP versions 5
 *
 * Zuha(tm) : Business Management Applications (http://zuha.com)
 * Copyright 2009-2010, Zuha Foundation Inc. (http://zuhafoundation.org)
 *
 * Licensed under GPL v3 License
 * Must retain the above copyright notice and release modifications publicly.
 *
 * @copyright     Copyright 2009-2010, Zuha Foundation Inc. (http://zuha.com)
 * @link          http://zuha.com Zuha™ Project
 * @package       zuha
 * @subpackage    zuha.app.controllers
 * @since         Zuha(tm) v 0.0.1
 * @license       GPL v3 License (http://www.gnu.org/licenses/gpl.html) and Future Versions
 */
class AdminController extends AppController {

	var $name = 'Admin';
    var $uses = array();
/**
 * Loads variables from section reporting to send to the view for display. 
 *
 * Example: $this->set('topPosts', ClassRegistry::init('Post')->getTop());
 *
 * @link http://book.zuha.com/zuha-app-controllers/AdminController.html
 */
    function index () {
		$this->set('myVar', 'something'); 
        # $this->set('topPosts', ClassRegistry::init('Post')->getTop());
        # $this->set('recentNews', ClassRegistry::init('News')->getRecent());
        # $this->set('topEmployees', ClassRegistry::init('Employee')->getTopPerformers());
        # $this->set('topSellingProducts', ClassRegistry::init('Product')->getTopSellers());
		$this->layout = 'admin';
	}
}
?>