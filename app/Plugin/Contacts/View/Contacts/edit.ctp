<div class="contacts form">
	<?php echo $this->Form->create('Contact');?>
	<div class="row">
		<div class="col-md-8">
			<h3><?php echo $page_title_for_layout; ?></h3>
			<fieldset>
			<?php echo $this->Form->input('Contact.id'); ?>
			<?php echo $this->Form->input('Contact.name'); ?>
			<?php echo $this->Form->input('Contact.assignee_id', array('empty' => '-- Select --', 'label' => 'Assigned to')); ?>
			<?php echo $this->Form->input('Contact.contact_type', array('empty' => '-- Select --', 'label' => 'Type')); ?>
			<?php echo $this->Form->input('Contact.contact_rating', array('empty' => '-- Select --', 'label' => 'Rating')); ?>
			<?php echo $this->Form->input('Contact.contact_source', array('empty' => '-- Select --', 'label' => 'Source')); ?>
			<?php echo $this->Form->input('Contact.contact_industry', array('empty' => '-- Select --', 'label' => 'Industry')); ?>
			<?php echo $this->Form->input('Contact.user_id', array('empty' => '-- Select User --')); ?>
			<?php echo $this->Form->input('Contact.is_company'); ?>
			</fieldset>
		</div>
		<div class="col-md-4">
			<?php if (!empty($this->request->data['ContactDetail'])) : ?>
				<h3>Contact Details</h3>
				<ul class="list-group" data-role="listview" data-inset="true">
				<?php for ($i = 0; $i < count($this->request->data['ContactDetail']); ++$i) : ?>
					<li class="list-group-item clearfix">
						<div class="row">
							<div class="col-xs-7 ellipsis">
								<span class="label label-default"><?php echo Inflector::humanize($this->request->data['ContactDetail'][$i]['contact_detail_type']); ?></span>
								<?php echo $this->request->data['ContactDetail'][$i]['value']; ?> alskdjf laksjd flaksjd flakjsd f
							</div>
							<div class="col-xs-5 text-right">
								<?php echo $this->Html->link('Edit', array('plugin' => 'contacts', 'controller' => 'contact_details', 'action' => 'edit', $this->request->data['ContactDetail'][$i]['id']), array('class' => 'btn btn-primary btn-xs')); ?>
								<?php echo $this->Html->link('Delete', array('plugin' => 'contacts', 'controller' => 'contact_details', 'action' => 'delete', $this->request->data['ContactDetail'][$i]['id']), array('class' => 'btn btn-danger btn-xs', 'data-icon' => 'delete')); ?>
							</div>
						</div>
					</li>
				<?php endfor; ?>
				</ul>
			<?php endif; ?>
		</div>
	</div>
	<?php echo $this->Form->end(__('Submit'));?>
</div>

<?php
// set the contextual breadcrumb items
$this->set('context_crumbs', array('crumbs' => array(
	$this->Html->link(__('Dashboard'), array('action' => 'dashboard')),
	$this->Html->link(__('View %s', $this->request->data['Contact']['name']), array('action' => 'view', $this->request->data['Contact']['id'])),
	__('Edit %s', $this->request->data['Contact']['name']),
)));

// set the contextual menu items
$this->set('context_menu', array('menus' => array(
	array(
		'heading' => 'Contacts',
		'items' => array(
			$this->Html->link(__('Dashboard'), array('plugin' => 'contacts', 'controller' => 'contacts', 'action' => 'dashboard')),
			),
		),
	array(
		'heading' => 'Contacts',
		'items' => array(
			$this->Html->link(__('Opportunity'), array('plugin' => 'contacts', 'controller' => 'contacts', 'action' => 'estimate', $this->Form->value('Contact.id')), array('escape' => false)),
			$this->Html->link(__('Activity'), array('plugin' => 'contacts', 'controller' => 'contacts', 'action' => 'activity', $this->Form->value('Contact.id')), array('escape' => false)),
			$this->Html->link(__('Reminder'), array('plugin' => 'contacts', 'controller' => 'contacts', 'action' => 'task', $this->Form->value('Contact.id')), array('escape' => false)),
			),
		),
	array(
		'heading' => 'Contacts',
		'items' => array(
			$this->Html->link(__('View'), array('action' => 'view', $this->request->data['Contact']['id'])),
			$this->Html->link(__('Delete'), array('action' => 'delete', $this->request->data['Contact']['id']), array(), __('Are you sure you want to delete %s?', $this->request->data['Contact']['name'])),
			),
		),
	)));