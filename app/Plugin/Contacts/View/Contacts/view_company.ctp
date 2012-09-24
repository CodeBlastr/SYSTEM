<div class="contacts view">
	
	<h1><?php echo $contact['Contact']['name']; ?></h1>
	<ul data-role="listview" data-inset="true">
		<?php
		if (!empty($employees)) { ?>
			<li data-role="list-divider">Employees</li>
			<?php
			foreach ($employees as $employee) { ?>
          		<li><?php echo $this->Html->link($employee['Contact']['name'], array('controller' => 'contacts', 'action' => 'view', $employee['Contact']['id'])); ?></li>
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
// set the contextual menu items
$this->set('context_menu', array('menus' => array(
	array(
		'heading' => 'Contacts',
		'items' => array(
			$this->Html->link(__('All Contacts'), array('plugin' => 'contacts', 'controller'=> 'contacts', 'action' => 'index')),
			$this->Html->link(__('Edit'), array('plugin' => 'contacts', 'controller'=> 'contacts', 'action' => 'edit', $contact['Contact']['id'])),
			$this->Html->link(__('Add Employee'), array('plugin' => 'contacts', 'controller'=> 'contacts', 'action' => 'add', 'person', $contact['Contact']['id'])),
			),
		),
	))); ?>
