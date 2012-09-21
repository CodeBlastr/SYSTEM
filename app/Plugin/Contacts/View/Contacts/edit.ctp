<div class="contacts form">
<?php echo $this->Form->create('Contact');?>
	<h2><?php echo __('Edit %s', $this->request->data['Contact']['name']); ?></h2>
	<fieldset>
 		<legend></legend>
		<?php
		echo $this->Form->input('Contact.id');
		echo $this->Form->input('Contact.name');
		if (!empty($this->request->data['ContactDetail'])) {
			echo '<ul data-role="listview" data-inset="true">';
			for ($i = 0; $i < count($this->request->data['ContactDetail']); ++$i) {
				echo __('<li>%s %s</li>', $this->Html->link(__('%s : %s', $this->request->data['ContactDetail'][$i]['contact_detail_type'], $this->request->data['ContactDetail'][$i]['value']), array('plugin' => 'contacts', 'controller' => 'contact_details', 'action' => 'edit', $this->request->data['ContactDetail'][$i]['id'])), $this->Html->link('Delete', array('plugin' => 'contacts', 'controller' => 'contact_details', 'action' => 'delete', $this->request->data['ContactDetail'][$i]['id']), array('data-icon' => 'delete')));
				//echo $this->Form->input('ContactDetail.' . $i . '.contact_detail_type', array('type' => 'hidden'));
				//echo $this->Form->input('ContactDetail.' . $i . '.value', array('label' => $this->request->data['ContactDetail'][$i]['contact_detail_type']));
			}
			echo '</ul>';
		}
		echo $this->Form->input('Contact.contact_type', array('empty' => '-- Select --', 'label' => 'Type'));
		echo $this->Form->input('Contact.contact_source_id', array('empty' => '-- Select --', 'label' => 'Source'));
		echo $this->Form->input('Contact.contact_industry_id', array('empty' => '-- Select --', 'label' => 'Industry'));
		echo $this->Form->input('Contact.contact_rating_id', array('empty' => '-- Select --', 'label' => 'Rating'));
		echo !empty($this->request->data['Contact']['user_id']) ? $this->Form->input('Contact.user_id', array('empty' => '-- Select User --')) : null;
		echo $this->Form->input('Contact.is_company'); ?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<?php 
// set the contextual menu items
$this->set('context_menu', array('menus' => array(
	array(
		'heading' => 'Projects',
		'items' => array(
			$this->Html->link(__('List Contacts'), array('action' => 'index'), array('class' => 'index')),
			$this->Html->link(__('Delete'), array('action' => 'delete', $this->Form->value('Contact.id')), array('class' => 'delete'), sprintf(__('Are you sure you want to delete # %s?', true), $this->Form->value('Contact.id'))),
			)
		),
	))); ?>