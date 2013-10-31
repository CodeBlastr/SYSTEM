<?php 
class WebpagesSchema extends CakeSchema {

	public $renames = array();

	public function __construct($options = array()) {
		parent::__construct();
	}

	public function before($event = array()) {
	    $db = ConnectionManager::getDataSource('default');
	    $db->cacheSources = false;
		App::uses('UpdateSchema', 'Model'); 
		$this->UpdateSchema = new UpdateSchema;
		$before = $this->UpdateSchema->before($event);
		return $before;
	}

	public function after($event = array()) {
		$this->_installData($event);
		$this->UpdateSchema->rename($event, $this->renames);
		$this->UpdateSchema->after($event);
	}

	public $webpage_css = array(
		'id' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 36, 'key' => 'primary', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'webpage_id' => array('type' => 'integer', 'null' => true, 'default' => NULL),
		'type' => array('type' => 'string', 'null' => false, 'default' => 'all', 'length' => 100, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'name' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 50, 'key' => 'unique', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'content' => array('type' => 'text', 'null' => false, 'default' => NULL, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'order' => array('type' => 'integer', 'null' => true, 'default' => NULL),
		'is_requested' => array('type' => 'boolean', 'null' => false, 'default' => '0', 'comment' => 'if already loaded in template somewhere this should be true'),
		'creator_id' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 36, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'modifier_id' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 36, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => NULL),
		'modified' => array('type' => 'datetime', 'null' => false, 'default' => NULL),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1), 
			'name' => array('column' => 'name', 'unique' => 1)
			),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'MyISAM')
	);

	public $webpage_js = array(
		'id' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 36, 'key' => 'primary', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'webpage_id' => array('type' => 'integer', 'null' => true, 'default' => NULL),
		'name' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 50, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'content' => array('type' => 'text', 'null' => false, 'default' => NULL, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'order' => array('type' => 'integer', 'null' => true, 'default' => NULL),
		'is_requested' => array('type' => 'boolean', 'null' => false, 'default' => '0', 'comment' => 'if already loaded in template somewhere this should be true'),
		'creator_id' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 36, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'modifier_id' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 36, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => NULL),
		'modified' => array('type' => 'datetime', 'null' => false, 'default' => NULL),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'name' => array('column' => 'name', 'unique' => 1)
			),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'MyISAM')
	);

	public $webpage_menus = array(
		'id' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 36, 'key' => 'primary', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'parent_id' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 36, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'lft' => array('type' => 'integer', 'null' => true, 'default' => NULL),
		'rght' => array('type' => 'integer', 'null' => true, 'default' => NULL),
		'name' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 50, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'code' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 50, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
        'type' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 50, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'params' => array('type' => 'text', 'null' => true, 'default' => NULL, 'collate' => 'utf8_general_ci', 'comment' => 'comma separated list of menu options, corresponding to the type chosen', 'charset' => 'utf8'),
		'css_id' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 50, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'css_class' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 50, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'menu_id' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 36, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
        'item_url' => array('type' => 'string', 'null' => true, 'default' => NULL, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'item_text' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 100, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'item_before' => array('type' => 'text', 'null' => true, 'default' => NULL, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'item_after' => array('type' => 'text', 'null' => true, 'default' => NULL, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'item_css_class' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 50, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'item_css_id' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 50, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'item_target' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 100, 'collate' => 'utf8_general_ci', 'comment' => '_blank, _new, etc', 'charset' => 'utf8'),
		'item_title' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 50, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'item_attributes' => array('type' => 'text', 'null' => true, 'default' => NULL, 'collate' => 'utf8_general_ci', 'comment' => 'custom attributes to add (ie. name=, title=, style=, onclick, etc)', 'charset' => 'utf8'),
		'item_auto_authorize' => array('type' => 'boolean', 'null' => true, 'default' => NULL, 'comment' => 'if true check authorization for link display'),
		'order' => array('type' => 'integer', 'null' => true, 'default' => NULL, 'length' => 3, 'comment' => 'order to display in'),
		'user_role_id' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 36, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'webpage_id' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 36, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'notes' => array('type' => 'text', 'null' => true, 'default' => NULL, 'collate' => 'utf8_general_ci', 'comment' => 'notes about a page for project mgmt use', 'charset' => 'utf8'),
		'creator_id' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 36, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'modifier_id' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 36, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
			),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'MyISAM')
	);

	public $webpages = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'parent_id' => array('type' => 'integer', 'null' => true, 'default' => NULL),
		'name' => array('type' => 'string', 'null' => false, 'default' => NULL, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'lft' => array('type' => 'integer', 'null' => true, 'default' => NULL),
		'rght' => array('type' => 'integer', 'null' => true, 'default' => NULL),
		'title' => array('type' => 'string', 'null' => true, 'default' => NULL, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'content' => array('type' => 'text', 'null' => true, 'default' => NULL, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'start_date' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
		'end_date' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
		'published' => array('type' => 'boolean', 'null' => true, 'default' => NULL),
		'keywords' => array('type' => 'text', 'null' => true, 'default' => NULL, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'description' => array('type' => 'text', 'null' => true, 'default' => NULL, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'type' => array('type' => 'string', 'null' => true, 'default' => 'content', 'length' => 50, 'collate' => 'utf8_general_ci', 'comment' => '\'template\',\'element\',\'content\'', 'charset' => 'utf8'),
		'is_default' => array('type' => 'boolean', 'null' => true, 'default' => NULL, 'comment' => 'convenience field for template type webpages'),
		'template_urls' => array('type' => 'text', 'null' => true, 'default' => NULL, 'collate' => 'utf8_general_ci', 'comment' => 'convenience field for template type webpages', 'charset' => 'utf8'),
		'user_roles' => array('type' => 'string', 'null' => true, 'default' => NULL, 'collate' => 'utf8_general_ci', 'comment' => 'convenience field for template type webpages', 'charset' => 'utf8'),
		'alias' => array('type' => 'string', 'null' => true, 'default' => NULL, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'creator_id' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 36, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'modifier_id' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 36, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'name' => array('column' => 'name', 'unique' => 1)
			),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'MyISAM')
	);
	
/**
 * Install Data Method
 */
	protected function _installData($event) {
		if (isset($event['create'])) {
			switch ($event['create']) {
	            case 'webpages':
	                //App::uses('ClassRegistry', 'Utility');
	                $Model = ClassRegistry::init('Webpages.Webpage');
					$Model->create();
					$Model->saveAll(array(
						// home page
						array(
							'Webpage' => array(
								'name' => 'Homepage',
								'content' => '<h1>Congratulations!</h1><p>A brand new site, for a brand new day. What will you give the world today?</p>',
								'title' => 'My New Homepage',
								'keywords' => 'sample key word list here',
								'description' => 'Another buildrr site, setup in seconds, built in minutes'
								),
							'Alias' => array(
								'plugin' => 'webpages',
								'controller' => 'webpages',
								'action' => 'view',
								'name' => 'home'
								)
							),
						// about us page
						// array(
							// 'Webpage' => array(
								// 'name' => 'About Us',
								// 'content' => '<p>Your <strong>About Us</strong> page is vital because it&rsquo;s where users 
											  // go when first trying to determine a level of trust. It&rsquo;s a good idea to give 
											  // people a fair amount information about yourself and your business. Here are a few 
											  // things you should touch on:</p>\r\n\r\n<ul>\r\n    <li>Who you are</li>\r\n  
											  // <li>Why you do what you do</li>\r\n  <li>Where you are located</li>\r\n  
											  // <li>How long you have been in business</li>\r\n  <li>Who are the people on your 
											  // team</li>\r\n</ul>\r\n\r\n<p>To edit this information turn on edit mode from the 
											  // admin menu.</p>\r\n',
								// 'title' => 'About Us',
								// 'keywords' => 'about us',
								// 'description' => 'about us'
								// ),
							// 'Alias' => array(
								// 'plugin' => 'webpages',
								// 'controller' => 'webpages',
								// 'action' => 'view',
								// 'name' => 'about'
								// )
							// ),
						// error page
						array(
							'Webpage' => array(
								'name' => 'Error Page',
								'content' => '<h1>Page Not Found</h1>'
								),
							'Alias' => array(
								'plugin' => 'webpages',
								'controller' => 'webpages',
								'action' => 'view',
								'name' => 'error'
								)
							),
						// typography (lots of html tags) page
						// array(
							// 'Webpage' => array(
								// 'name' => 'Typography',
								// 'content' => '<p>This is the default homepage.  Complete with default html tags displayed 
											  // for easy theme styling.  Have fun!!</p><hr /><h1>Heading One <small>small 
											  // wrapper</small></h1><h2>Heading Two <small>small wrapper</small></h2><h3>Heading Three 
											  // <small>small wrapper</small></h3><h4>Heading Four <small>small wrapper</small></h4>
											  // <h5>Heading Five <small>small wrapper</small></h5><h6>Heading Six <small>small wrapper</small></h6>
											  // <p class=\"muted\">Fusce dapibus, tellus ac cursus commodo, tortor mauris nibh.</p>
											  // <p class=\"text-warning\">Etiam porta sem malesuada magna mollis euismod.</p>
											  // <p class=\"text-error\">Donec ullamcorper nulla non metus auctor fringilla.</p>
											  // <p class=\"text-info\">Aenean eu leo quam. Pellentesque ornare sem lacinia quam venenatis.</p>
											  // <p class=\"text-success\">Duis mollis, est non commodo luctus, nisi erat porttitor ligula.</p>
											  // <p>An abbreviation of the word attribute is <abbr title=\"attribute\">attr</abbr></p>
											  // <address><strong>Acme, Inc.</strong><br>9210 Jetsam Ave, Suite 400<br>San Francisco, CA 90210<br>
											  // <abbr title=\"Phone\">P:</abbr> (123) 456-7890</address><blockquote>  
											  // <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer posuere erat a ante.</p>  
											  // <small>Someone famous <cite title=\"Source Title\">Source Title</cite></small> </blockquote>
											  // <blockquote class=\"pull-right\">  <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. 
											  // Integer posuere erat a ante.</p>  <small>Someone famous <cite title=\"Source Title\">Source 
											  // Title</cite></small> </blockquote><div class=\"clearfix\"></div><dl class=\"dl-horizontal\">  
											  // <dt>Description lists</dt>  <dd>A description list is perfect for defining terms.</dd>  
											  // <dt>Euismod</dt>  <dd>Vestibulum id ligula porta felis euismod semper eget lacinia odio sem 
											  // nec elit.</dd>  <dd>Donec id elit non mi porta gravida at eget metus.</dd>  <dt>Malesuada 
											  // porta</dt>  <dd>Etiam porta sem malesuada magna mollis euismod.</dd>  <dt>Felis euismod 
											  // semper eget lacinia</dt>  <dd>Fusce dapibus, tellus ac cursus commodo, tortor mauris 
											  // condimentum nibh, ut fermentum massa justo sit amet risus.</dd></dl><h2>Various Default 
											  // Table Classes</h2><table class=\"table\"><thead><tr><th>#</th><th>First Name</th>
											  // <th>Last Name</th><th>Username</th></tr></thead><tbody><tr><td>1</td><td>Mark</td><td>Otto</td>
											  // <td>@mdo</td></tr><tr><td>2</td><td>Jacob</td><td>Thornton</td><td>@fat</td></tr><tr><td>3</td>
											  // <td>Larry</td><td>the Bird</td><td>@twitter</td></tr></tbody></table><table class=\"table table-striped\">
											  // <thead><tr><th>#</th><th>First Name</th><th>Last Name</th><th>Username</th></tr></thead>
											  // <tbody><tr><td>1</td><td>Mark</td><td>Otto</td><td>@mdo</td></tr><tr><td>2</td><td>Jacob</td>
											  // <td>Thornton</td><td>@fat</td></tr><tr><td>3</td><td>Larry</td><td>the Bird</td><td>@twitter</td>
											  // </tr></tbody></table><table class=\"table table-bordered\"><thead><tr><th>#</th><th>First Name</th>
											  // <th>Last Name</th><th>Username</th></tr></thead><tbody><tr><td rowspan=\"2\">1</td>
											  // <td>Mark</td><td>Otto</td><td>@mdo</td></tr><tr><td>Mark</td><td>Otto</td><td>@TwBootstrap</td>
											  // </tr><tr><td>2</td><td>Jacob</td><td>Thornton</td><td>@fat</td></tr><tr><td>3</td>
											  // <td colspan=\"2\">Larry the Bird</td><td>@twitter</td></tr></tbody></table>
											  // <table class=\"table table-hover\"><thead><tr><th>#</th><th>First Name</th><th>Last Name</th>
											  // <th>Username</th></tr></thead><tbody><tr><td>1</td><td>Mark</td><td>Otto</td><td>@mdo</td></tr>
											  // <tr><td>2</td><td>Jacob</td><td>Thornton</td><td>@fat</td></tr><tr><td>3</td>
											  // <td colspan=\"2\">Larry the Bird</td><td>@twitter</td></tr></tbody></table>
											  // <table class=\"table table-condensed\"><thead><tr><th>#</th><th>First Name</th><th>Last Name</th>
											  // <th>Username</th></tr></thead><tbody><tr><td>1</td><td>Mark</td><td>Otto</td><td>@mdo</td>
											  // </tr><tr><td>2</td><td>Jacob</td><td>Thornton</td><td>@fat</td></tr><tr><td>3</td>
											  // <td colspan=\"2\">Larry the Bird</td><td>@twitter</td></tr></tbody></table>
											  // <table class=\"table\"><thead><tr><th>#</th><th>Product</th><th>Payment Taken</th>
											  // <th>Status</th></tr></thead><tbody><tr class=\"success\"><td>1</td><td>TB - Monthly</td>
											  // <td>01/04/2012</td><td>Approved</td></tr><tr class=\"error\"><td>2</td><td>TB - Monthly</td>
											  // <td>02/04/2012</td><td>Declined</td></tr><tr class=\"warning\"><td>3</td><td>TB - Monthly</td>
											  // <td>03/04/2012</td><td>Pending</td></tr><tr class=\"info\"><td>4</td><td>TB - Monthly</td>
											  // <td>04/04/2012</td><td>Call in to confirm</td></tr></tbody></table><h2>Form Styles</h2>
											  // <form action=\"/webpages/webpages/view/1?url=webpages%2Fwebpages%2Fview%2F1\" id=\"WebpageViewForm\" 
											  // method=\"post\" accept-charset=\"utf-8\">  <div style=\"display:none;\"><input type=\"hidden\" 
											  // name=\"_method\" value=\"POST\"/></div><fieldset><legend>Some Legend</legend>
											  // <div class=\"input text\" data-role=\"fieldcontain\"><label for=\"WebpageLabelName\">Label Name</label>
											  // <input name=\"data[Webpage][labelName]\" placeholder=\"Type something...\" type=\"text\" 
											  // id=\"WebpageLabelName\"/><span class=\"help-block\">Some text in the after index</span></div>
											  // <div class=\"input checkbox\" data-role=\"fieldcontain\"><input type=\"hidden\" name=\"data[Webpage][singleCheckBox]\" 
											  // id=\"WebpageSingleCheckBox_\" value=\"0\"/><input type=\"checkbox\" name=\"data[Webpage][singleCheckBox]\" 
											  // value=\"1\" id=\"WebpageSingleCheckBox\"/><label for=\"WebpageSingleCheckBox\">Single Check Box</label></div>
											  // <div class=\"input radio\" data-role=\"fieldcontain\"><input type=\"hidden\" 
											  // name=\"data[Webpage][radio2Buttons]\" id=\"WebpageRadio2Buttons_\" value=\"\"/>
											  // <input type=\"radio\" name=\"data[Webpage][radio2Buttons]\" id=\"WebpageRadio2Buttons0\" value=\"0\" />
											  // <label for=\"WebpageRadio2Buttons0\">radio option one</label><input type=\"radio\" 
											  // name=\"data[Webpage][radio2Buttons]\" id=\"WebpageRadio2Buttons1\" value=\"1\" />
											  // <label for=\"WebpageRadio2Buttons1\">radio option two</label><input type=\"radio\" 
											  // name=\"data[Webpage][radio2Buttons]\" id=\"WebpageRadio2Buttons2\"  value=\"2\" />
											  // <label for=\"WebpageRadio2Buttons2\">radio option three</label></div><div class=\"input radio\" 
											  // data-role=\"fieldcontain\"><fieldset><legend>radio set with legend</legend><input type=\"hidden\" 
											  // name=\"data[Webpage][radioButtons]\" id=\"WebpageRadioButtons_\" value=\"\"/><input type=\"radio\" 
											  // name=\"data[Webpage][radioButtons]\" id=\"WebpageRadioButtons0\" value=\"0\" /><label 
											  // for=\"WebpageRadioButtons0\">option one</label><input type=\"radio\" name=\"data[Webpage][radioButtons]\" 
											  // id=\"WebpageRadioButtons1\"  value=\"1\" /><label for=\"WebpageRadioButtons1\">option two</label>
											  // <input type=\"radio\" name=\"data[Webpage][radioButtons]\" id=\"WebpageRadioButtons2\" value=\"2\" />
											  // <label for=\"WebpageRadioButtons2\">option three</label></fieldset></div><div class=\"input select\" data-role=\"fieldcontain\">
											  // <label for=\"WebpageSelectButtons\">Select One</label><select name=\"data[Webpage][selectButtons]\" 
											  // id=\"WebpageSelectButtons\"><option value=\"0\">option one</option><option value=\"1\">option two</option>
											  // <option value=\"2\">option three</option></select></div><div class=\"input select\" data-role=\"fieldcontain\">
											  // <label for=\"WebpageSelectButtons\">Select Multiple</label><input type=\"hidden\" name=\"data[Webpage][selectButtons]\" 
											  // value=\"\" id=\"WebpageSelectButtons_\"/><select name=\"data[Webpage][selectButtons][]\" 
											  // multiple=\"multiple\" id=\"WebpageSelectButtons\"><option value=\"0\">option one</option>
											  // <option value=\"1\">option two</option><option value=\"2\">option three</option></select></div>
											  // <div class=\"input select\" data-role=\"fieldcontain\"><label for=\"WebpageSelectButtons\">Select Multiple</label>
											  // <input type=\"hidden\" name=\"data[Webpage][selectButtons]\" value=\"\" id=\"WebpageSelectButtons\"/>
											  // <div class=\"checkbox\"><input type=\"checkbox\" name=\"data[Webpage][selectButtons][]\" value=\"0\" 
											  // id=\"WebpageSelectButtons0\" /><label for=\"WebpageSelectButtons0\">option one</label>
											  // </div><div class=\"checkbox\"><input type=\"checkbox\" name=\"data[Webpage][selectButtons][]\" 
											  // value=\"1\" id=\"WebpageSelectButtons1\" /><label for=\"WebpageSelectButtons1\">option two</label>
											  // </div><div class=\"checkbox\"><input type=\"checkbox\" name=\"data[Webpage][selectButtons][]\" 
											  // value=\"2\" id=\"WebpageSelectButtons2\" /><label for=\"WebpageSelectButtons2\">option three</label>
											  // </div></div><div class=\"input textarea\" data-role=\"fieldcontain\"><label for=\"WebpageTextArea\">Text Area</label>
											  // <textarea name=\"data[Webpage][textArea]\" cols=\"30\" rows=\"6\" id=\"WebpageTextArea\"></textarea></div>
											  // <div class=\"submit\"><input type=\"submit\" value=\"Submit\"/>  </div></form></fieldset><h2>Unordered List Styles</h2>
											  // <ul><li>List Item One</li><li>List Item Two<ul><li>Sub Item One<ul><li>Sub sub item one</li>
											  // </ul></li><li>Sub Item Two</li><li>Sub Item Three</li></ul></li><li>List Item Three</li></ul>
											  // <h2>Ordered List Styles</h2><ol><li>List Item One</li><li>List Item Two<ol><li>Sub Item One
											  // <ol><li>Sub sub item one</li></ol></li><li>Sub Item Two</li><li>Sub Item Three</li></ol></li>
											  // <li>List Item Three</li></ol><!-- Example row of columns --><div class=\"row\">
											  // <div class=\"span4\"><h2>Heading</h2><p class=\"lead\">Make a paragraph stand out by adding 
											  // class called .lead.</p><p>Donec id elit non mi porta <strong>strong bold <em>text</strong> 
											  // at eget metus. Fusce</em> dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, 
											  // ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. 
											  // Donec sed odio dui. </p>    <p><a class=\"btn\" href=\"#\">View details &raquo;</a></p></div>
											  // <div class=\"span4\"><h2>Heading</h2><p class=\"lead\">Make a paragraph stand out by adding 
											  // class called .lead.</p>    <p>Donec id elit non mi porta gravida at eget metus. Fusce dapibus, 
											  // tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet 
											  // risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui. </p>
											  // <p><a class=\"btn\" href=\"#\">View details &raquo;</a></p></div><div class=\"span4\">
											  // <h2>Heading</h2>    <p class=\"lead\">Make a paragraph stand out by adding class called .lead.</p>
											  // <p>Donec sed odio dui. Cras justo odio, dapibus ac facilisis in, egestas eget quam. Vestibulum 
											  // id ligula porta felis euismod semper. Fusce dapibus, tellus ac cursus commodo, tortor mauris 
											  // condimentum nibh, ut fermentum massa justo sit amet risus.</p>    <p>
											  // <a class=\"btn\" href=\"#\">View details &raquo;</a></p>  </div></div><hr />
											  // <h2>Live grid example</h2><p>The default grid system utilizes <strong>12 columns</strong>, 
											  // responsive columns become fluid and stack vertically.</p><div class=\"row\"> 
											  // <div class=\"span1\">.span1</div>  <div class=\"span1\">.span1</div>
											  // <div class=\"span1\">.span1</div>  <div class=\"span1\">.span1</div>
											  // <div class=\"span1\">.span1</div>  <div class=\"span1\">.span1</div>
											  // <div class=\"span1\">.span1</div>  <div class=\"span1\">.span1</div>
											  // <div class=\"span1\">.span1</div>  <div class=\"span1\">.span1</div>
											  // <div class=\"span1\">.span1</div>  <div class=\"span1\">.span1</div></div>
											  // <div class=\"row show-grid\">  <div class=\"span2\">.span2</div>
											  // <div class=\"span3\">.span3</div>  <div class=\"span4\">.span4</div>
											  // <div class=\"span2\">.span2</div>  <div class=\"span1\">.span1</div></div>
											  // <div class=\"row show-grid\">  <div class=\"span9\">.span9</div>
											  // <div class=\"span3\">.span3</div></div><hr /><h3>This is a pre tag with the class
											   // .prettyprint & .linenums</h3><pre class=\"prettyprint linenums\">
											   // <div class=\"row\"&gt;  <div class=\"span4\"&gt;...</div&gt; <div class=\"span8\"&gt;...
											   // </div&gt;</div&gt;</pre>',
								// 'title' => 'Typography'
								// )
							// ),
						));
						break;
				case 'webpage_menus' :
	                App::uses('ClassRegistry', 'Utility');
	                $Model = ClassRegistry::init('Webpages.WebpageMenu');
					$Model->create();
					$Model->saveAll(array(
						'WebpageMenu' => array(
							'name' => 'Home',
							'code' => 'main-menu'
							),
						'WebpageMenuItem' => array(
							array(
								'item_url' => '/',
								'item_text' => 'Home',
								'item_title' => 'Homepage',
								'order' => '1'
								),
							// array(
								// 'item_url' => '/products',
								// 'item_text' => 'Products',
								// 'item_title' => 'Our Store',
								// 'order' => '2'
								// ),
							// array(
								// 'item_url' => '/about',
								// 'item_text' => 'About Us',
								// 'item_title' => 'About Us',
								// 'order' => '2'
								// ),
							// array(
								// 'item_url' => '/blogs',
								// 'item_text' => 'Blog',
								// 'item_title' => 'Our Blog',
								// 'order' => '4'
								// ),
							)
						));
						break;
						
					/*
						// first tempmlate
						array(
							'Webpage' => array(
								'id' => 3,
								'type' => 'template',
								'name' => 'initial-template.ctp',
								'content' => '<!DOCTYPE html>\r\n<html lang=\"en\">\r\n<head>\r\n<meta http-equiv=\"Content-Type\" 
											  content=\"text/html; charset=utf-8\" />\r\n<meta http-equiv=\"X-UA-Compatible\" 
											  content=\"IE=edge,chrome=1\">\r\n<title></title>\r\n<meta name=\"viewport\" 
											  content=\"width=device-width, initial-scale=1.0\">\r\n<meta name=\"author\" 
											  content=\"\">\r\n<!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->\r\n
											  <!--[if lt IE 9]>\r\n<script src=\"http://html5shim.googlecode.com/svn/trunk/html5.js\">
											  </script>\r\n<![endif]-->\r\n{element: favicon}\r\n<link rel=\"stylesheet\" 
											  type=\"text/css\" href=\"/css/system.css\" />\r\n<link rel=\"stylesheet\"
											  type=\"text/css\" href=\"/css/twitter-bootstrap/bootstrap.min.css\" />\r\n<link 
											  rel=\"stylesheet\" type=\"text/css\" href=\"/css/twitter-bootstrap/bootstrap.custom.css\" />
											  \r\n{element: css}\r\n<script type=\"text/javascript\" src=\"http://code.jquery.com/jquery-latest.js\">
											  </script>\r\n<script type=\"text/javascript\" src=\"/js/twitter-bootstrap/bootstrap.min.js\"></script>
											  \r\n<script type=\"text/javascript\" src=\"/js/system.js\"></script>\r\n
											  <script type=\"text/javascript\" src=\"/js/plugins/modernizr-2.6.1-respond-1.1.0.min.js\"></script>
											  \r\n{element: javascript}\r\n{element: Webpages.analytics}\r\n</head>\r\n
											  <body {element: body_attributes}>\r\n<!--[if lt IE 7]>\r\n<p class=\"chromeframe\">You are using 
											  an outdated browser. <a href=\"http://browsehappy.com/\">Upgrade your browser today</a> or 
											  <a href=\"http://www.google.com/chromeframe/?redirect=true\">install Google Chrome Frame</a> to 
											  better experience this site.</p>\r\n<![endif]-->\r\n<div class=\"container\">\r\n
											  {element: twitter-bootstrap/page_title}\r\n{helper: flash_for_layout}\r\n
											  {helper: flash_auth_for_layout} \r\n{menu: test-menu} \r\n{page: 5}\r\n
											  {helper: content_for_layout}\r\n<footer>\r\n<hr />\r\n<p>&copy; Company 2012</p>\r\n</footer>
											  \r\n    {element: sql_dump}\r\n</div>\r\n\r\n</body>\r\n</html>\r\n',
								'is_default' => '1',
								'template_urls' => '',
								'user_roles' => array(
									'1',
									'5'
									)
								)
							),
						// footer right
						array(
							'Webpage' => array(
								'id' => '9',
								'type' => 'element',
								'name' => 'Footer-Right',
								'content' => '',
								)
							),
						);
					 */
			}
		}
	}
}