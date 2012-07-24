<div class="filterable ui-grid-c">
	<div class="ui-block-a">
		<ul id="leadList" data-mini="false" data-role="listview" data-filter="true" data-inset="true">
	        <li data-role="list-divider">Leads</li>
			<?php 
	        foreach ($contacts as $contact) {
	        	if ($contact['Contact']['contact_type'] == 'Lead') {
	           		echo __('<li data-filtertext="%s zqx%s">%s</li>', $contact['Contact']['name'], $contact['Contact']['contact_type'], $this->Html->link(__('%s', $contact['Contact']['name']), array('action' => 'view', $contact['Contact']['id']), array('data-transition' => 'flip'))); 
	       		}
			} ?>
	    </ul>
	</div>
	<div class="ui-block-b">
	    <ul id="customerList" data-mini="false" data-role="listview" data-filter="true" data-inset="true">
	        <li data-role="list-divider">Customers</li>
			<?php 
	        foreach ($contacts as $contact) { 
	        	if ($contact['Contact']['contact_type'] == 'Customer') {
	           		echo __('<li data-filtertext="%s zqx%s">%s</li>', $contact['Contact']['name'], $contact['Contact']['contact_type'], $this->Html->link(__('%s', $contact['Contact']['name']), array('action' => 'view', $contact['Contact']['id']), array('data-transition' => 'flip'))); 
	       		}
			} ?>
	    </ul>
	</div>
	<div class="ui-block-c">
		<ul id="companyList" data-mini="false" data-role="listview" data-filter="true" data-inset="true">
	        <li data-role="list-divider">Companies</li>
			<?php 
	        foreach ($contacts as $contact) { 
	        	if ($contact['Contact']['is_company'] == 1) {
	           		echo __('<li data-filtertext="%s zqx%s">%s</li>', $contact['Contact']['name'], $contact['Contact']['contact_type'], $this->Html->link(__('%s', $contact['Contact']['name']), array('action' => 'view', $contact['Contact']['id']), array('data-transition' => 'flip'))); 
	       		}
			} ?>
	    </ul>
	</div>
	<div class="ui-block-d">
	    <ul id="peopleList" data-mini="false" data-role="listview" data-filter="true" data-inset="true">
	        <li data-role="list-divider">People</li>
			<?php 
	        foreach ($contacts as $contact) { 
	        	if ($contact['Contact']['is_company'] == 0) {
	           		echo __('<li data-filtertext="%s zqx%s">%s</li>', $contact['Contact']['name'], $contact['Contact']['contact_type'], $this->Html->link(__('%s', $contact['Contact']['name']), array('action' => 'view', $contact['Contact']['id']), array('data-transition' => 'flip'))); 
	       		}
			} ?>
	    </ul>
	</div>
</div>


<?php
// set the contextual menu items
$this->set('context_menu', array('menus' => array(
	array(
		'heading' => '',
		'items' => array(
			$this->Html->link(__('Leads'), array('plugin' => 'contacts', 'controller'=> 'contacts', 'action' => 'index', 'filter' => 'contactType:leads'), array('data-icon' => 'grid', 'class' => 'ui-btn-active', 'data-filter-list' => 'leadList')),
			$this->Html->link(__('Customers'), array('plugin' => 'contacts', 'controller'=> 'contacts', 'action' => 'index', 'filter' => 'type:customers'), array('data-icon' => 'grid', 'class' => 'ui-btn-active', 'data-filter-list' => 'customerList')),
			$this->Html->link(__('Companies'), array('plugin' => 'contacts', 'controller'=> 'contacts', 'action' => 'index', 'filter' => 'type:customers'), array('data-icon' => 'grid', 'data-filter-list' => 'companyList')),
			$this->Html->link(__('People'), array('plugin' => 'contacts', 'controller'=> 'contacts', 'action' => 'index', 'filter' => 'type:customers'), array('data-icon' => 'grid', 'data-filter-list' => 'peopleList')),
			),
		),
	array(
		'heading' => '',
		'items' => array(
			$this->Html->link(__('Add'), array('plugin' => 'contacts', 'controller'=> 'contacts', 'action' => 'add'), array('data-icon' => 'plus')),
			),
		),
	))); ?>