<div class="well well-large pull-right last span3">
	<span class="label label-info">
        <?php echo !empty($contact['Contact']['contact_rating']) ? Inflector::humanize($contact['Contact']['contact_rating']) : 'Unrated'; ?> 
        <?php echo !empty($contact['Contact']['contact_type']) ? $contact['Contact']['contact_type'] : 'Uncategorized'; ?></span>
	<span class="label label-info"><?php echo !empty($contact['Contact']['contact_industry']) ? $contact['Contact']['contact_industry'] : 'Uncategorized'; ?></span>
	<span class="label label-info"><?php echo !empty($contact['Contact']['contact_source']) ? $contact['Contact']['contact_source'] : 'Unsourced'; ?></span>
	<span class="label label-info"><?php echo !empty($contact['Contact']['created']) ? ZuhaInflector::datify($contact['Contact']['created']) : 'Undated'; ?></span>
    <?php
    echo '<h4>Contact Details</h4>';
	if (!empty($contact['ContactDetail'])) { 
		for ($i = 0; $i < count($contact['ContactDetail']); ++$i) {
			echo __('<p><span class="label label-info">%s</span> %s </p>', $contact['ContactDetail'][$i]['contact_detail_type'], $contact['ContactDetail'][$i]['value']);
		}
	} else {
		echo __('<p>No contact details provided.</p>');
	} ?>
</div>


<div class="contact estimate form">
	<?php
	echo $this->Form->create(); ?>
	<fieldset>
		<?php 
		echo $this->Form->input('Activity.model', array('type' => 'hidden', 'value' => 'Contact')); 
		echo $this->Form->input('Activity.foreign_key', array('type' => 'hidden', 'value' => $contact['Contact']['id'])); 
	 	echo $this->Form->input('Activity.action_description', array('type' => 'hidden', 'value' => 'contact activity')); 
	 	echo $this->Form->input('Activity.name', array('label' => 'Subject <em>(eg. Sent an email)</em>')); 
	 	//echo $this->Form->input('Activity.created', array('label' => 'Date of Activity', 'type' => 'date', 'value' => date('Y-m-d'))); 
	 	echo $this->Form->input('Activity.description', array('type' => 'richtext')); ?>
	</fieldset>
  	<?php echo $this->Form->end('Submit');?>
</div>

<?php 
// set the contextual menu items
$this->set('context_menu', array('menus' => array(
	array(
		'heading' => 'Contacts',
		'items' => array(
			$this->Html->link(__('View %s', $contact['Contact']['name']), array('action' => 'view', $contact['Contact']['id'])),
			)
		),
	))); ?>