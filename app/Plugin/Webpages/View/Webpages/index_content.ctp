<div class="row">
    
    
<div class="span3 bs-docs-sidebar"><ul class="nav nav-list bs-docs-sidenav affix"><li class="dropdown"><a href="#enumeration"><i class="icon-chevron-right"></i> Enumerations</a></li><li class="dropdown"><a href="#setting"><i class="icon-chevron-right"></i> Settings</a></li><li class="dropdown"><a href="#contact"><i class="icon-chevron-right"></i> Contacts</a><ul class="dropdown-menu" style="display: none;"><li><a href="#contact_addresses">Contact Address</a></li><li><a href="#contact_details">Contact Detail</a></li><li><a href="#contacts">Contact</a></li></ul></li><li class="dropdown"><a href="#gallery"><i class="icon-chevron-right"></i> Galleries</a><ul class="dropdown-menu" style="display: none;"><li><a href="#galleries">Gallery</a></li><li><a href="#gallery_images">Gallery Image</a></li></ul></li><li class="dropdown"><a href="#user"><i class="icon-chevron-right"></i> Users</a><ul class="dropdown-menu" style="display: none;"><li><a href="#user_followers">User Follower</a></li><li><a href="#user_group_wall_posts">User Group Wall Post</a></li><li><a href="#user_groups">User Group</a></li><li><a href="#user_roles">User Role</a></li><li><a href="#user_statuses">User Status</a></li><li><a href="#user_walls">User Wall</a></li><li><a href="#users">User</a></li><li><a href="#users_user_groups">Users User Group</a></li></ul></li><li class="dropdown"><a href="#webpage"><i class="icon-chevron-right"></i> Webpages</a><ul class="dropdown-menu" style="display: none;"><li><a href="#webpage_csses">Webpage Css</a></li><li><a href="#webpage_jses">Webpage Jse</a></li><li><a href="#webpage_menu_items">Webpage Menu Item</a></li><li><a href="#webpage_menus">Webpage Menu</a></li><li><a href="#webpage_reports">Webpage Report</a></li><li><a href="#webpages">Webpage</a></li></ul></li></ul></div>
    
<div class="span9">
<?php
// set the contextual sorting items
echo $this->Element('context_sort', array(
    'context_sort' => array(
        'type' => 'select',
        'sorter' => array(array(
            'heading' => '',
            'items' => array(
                $this->Paginator->sort('name'),
                $this->Paginator->sort('created'),
                )
            )), 
        )
	)); 

echo $this->Element('forms/search', array(
	'url' => '/webpages/webpages/index/', 
	'inputs' => array(
		array(
			'name' => 'contains:name', 
			'options' => array(
				'label' => '', 
				'placeholder' => 'Type Your Search and Hit Enter',
				'value' => !empty($this->request->params['named']['contains']) ? substr($this->request->params['named']['contains'], strpos($this->request->params['named']['contains'], ':') + 1) : null,
				)
			),
		/*array(
			'name' => 'filter:contact_type', 
			'options' => array(
				'type' => 'select',
				'empty' => '-- All --',
				'options' => array(
					'lead' => 'Lead',
					'customer' => 'Customer',
					),
				'label' => '', 
				'placeholder' => 'Type Your Search and Hit Enter'
				)
			)*/
		)
	));

echo $this->Element('scaffolds/index', array('data' => $webpages)); ?>
</div>
</div>

<?php
// set the contextual menu items
$this->set('context_menu', array('menus' => array(
	array(
		'heading' => 'Webpages',
		'items' => array(
			$this->Html->link(__('Add'), array('controller' => 'webpages', 'action' => 'add')),
			)
		),
	)));