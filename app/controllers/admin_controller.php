<?php
    class AdminController extends AppController {

          var $name = 'Admin';
          var $uses = array();

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