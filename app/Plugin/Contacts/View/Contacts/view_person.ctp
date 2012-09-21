<div class="contacts view">
	
	<h1><?php echo $contact['Contact']['name']; ?></h1>
	<ul data-role="listview" data-inset="true">
		<?php
		if (!empty($contact['Employer'][0])) { ?>
			<li data-role="list-divider">Related Companies</li>
			<?php
			foreach ($contact['Employer'] as $employer) { ?>
          		<li><?php echo $this->Html->link($employer['name'], array('controller' => 'contacts', 'action' => 'view', $employer['id'])); ?></li>
			<?php
			}
		} 
		
		if (!empty($contact['ContactDetail'])) { ?>
			<li data-role="list-divider">Contact Details</li>
			<?php
			for ($i = 0; $i < count($contact['ContactDetail']); ++$i) {
				echo __('<li>%s %s</li>', $this->Html->link(__('%s : %s', $contact['ContactDetail'][$i]['contact_detail_type'], $contact['ContactDetail'][$i]['value']), array('plugin' => 'contacts', 'controller' => 'contact_details', 'action' => 'edit', $contact['ContactDetail'][$i]['id'])), $this->Html->link('Delete', array('plugin' => 'contacts', 'controller' => 'contact_details', 'action' => 'delete', $contact['ContactDetail'][$i]['id']), array('data-icon' => 'delete')));
			}
		} ?>
		
		<li data-role="list-divider">Meta Information</li>
		<li><?php echo __('<strong>Type</strong> : %s', $contact['Contact']['contact_type']); ?></li>
		<li><?php echo __('<strong>Source</strong> : %s', $contact['Contact']['contact_source']); ?></li>
		<li><?php echo __('<strong>Industry</strong> : %s', $contact['Contact']['contact_industry']); ?></li>
		<li><?php echo __('<strong>Rating</strong> : %s', $contact['Contact']['contact_rating']); ?></li>
	</ul>
	
</div>

<?php
# see if the user is registered
if (empty($contact['Contact']['user_id'])) {
	$userLink =  $this->Html->link(__('Make '.$contact['Contact']['name'].' a Registered User', true), array('plugin' => 'users', 'controller' => 'users', 'action' => 'register', 'contact' => $contact['Contact']['id']));
} else {
	$userLink =  $this->Html->link(__('View User', true), array('plugin' => 'users', 'controller' => 'users', 'action' => 'view', $contact['Contact']['user_id']));
}

// set the contextual menu items
$this->set('context_menu', array('menus' => array(
	array(
		'heading' => 'Contacts',
		'items' => array(
			$this->Html->link(__('All Contacts'), array('plugin' => 'contacts', 'controller'=> 'contacts', 'action' => 'index')),
			$this->Html->link(__('Edit'), array('plugin' => 'contacts', 'controller'=> 'contacts', 'action' => 'edit', $contact['Contact']['id'])),
			),
		),
	array(
		'heading' => 'Users',
		'items' => array($userLink),
		),
	))); ?>
