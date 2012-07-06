<div class="contacts view">
  <div id="navigation">
    <div id="n1" class="info-block">
      <div class="viewRow">
        <ul class="metaData">
<?php 		if (!empty($contact['Employer'][0])) : 
		       foreach ($contact['Employer'] as $employer) : 
?>
          <li><span class="metaDataLabel"><?php echo __('Company : '); ?></span><span name="type" class="metaDataDetail"><?php echo $this->Html->link($employer['name'], array('controller' => 'contacts', 'action' => 'view', $employer['id'])); ?></span></li>
<?php 
        	    endforeach;
     	    endif;
?>
          <li><span class="metaDataLabel">
            <?php echo $this->Html->link(__('Type : ', true), array('plugin' => null, 'controller' => 'enumerations', 'action' => 'index', 'filter' => 'CONTACTTYPE', 'admin' => 1), array('class' => 'dialog', 'title' => 'Edit Type List')); ?>
            </span><span name="type" class="edit metaDataDetail" id="<?php echo $contact['Contact']['id']; ?>"><?php echo !empty($contact['ContactType']['name']) ? $contact['ContactType']['name'] : null; ?></span></li>
          <li><span class="metaDataLabel">
            <?php echo $this->Html->link(__('Source : ', true), array('plugin' => null, 'controller' => 'enumerations', 'action' => 'index', 'filter' => 'CONTACTSOURCE', 'admin' => 1), array('class' => 'dialog', 'title' => 'Edit Source List')); ?>
            </span><span name="source" class="edit metaDataDetail" id="<?php echo $contact['Contact']['id']; ?>"><?php echo !empty($contact['ContactSource']['name']) ? $contact['ContactSource']['name'] : null; ?></span></li>
          <li><span class="metaDataLabel">
            <?php echo $this->Html->link(__('Industry : ', true), array('plugin' => null, 'controller' => 'enumerations', 'action' => 'index', 'filter' => 'CONTACTINDUSTRY', 'admin' => 1), array('class' => 'dialog', 'title' => 'Edit Industry List')); ?>
            </span><span name="industry" class="edit metaDataDetail" id="<?php echo $contact['Contact']['id']; ?>"><?php echo !empty($contact['ContactIndustry']['name']) ? $contact['ContactIndustry']['name'] : null; ?></span></li>
          <li><span class="metaDataLabel">
            <?php echo $this->Html->link(__('Rating : ', true), array('plugin' => null, 'controller' => 'enumerations', 'action' => 'index', 'filter' => 'CONTACTRATING', 'admin' => 1), array('class' => 'dialog', 'title' => 'Edit Rating List')); ?>
            </span><span name="rating" class="edit metaDataDetail" id="<?php echo $contact['Contact']['id']; ?>"><?php echo !empty($contact['ContactRating']['name']) ? $contact['ContactRating']['name'] : null; ?></span></li>
<?php 		if (!empty($contact['ContactDetail'][0])) : 
		       foreach ($contact['ContactDetail'] as $detail) : 
?>
          <li><span class="metaDataLabel"><?php echo $detail['contact_detail_type'] . ' : '; ?></span><span name="type" class="metaDataDetail"><?php echo $detail['value']; ?></span></li>
<?php 
        	    endforeach;
     	    endif;
?>
        </ul>
        <div class="recordData">
          <?php if (!empty($employees)) : ?>
          <h3><?php echo __('Employees'); ?></h3>
          <div><?php echo $this->Element('scaffolds/index', array('data' => $employees)); ?></div>
          <?php endif; ?>
        </div>
      </div>      
    </div>
    <!-- /info-block end -->
  </div>
</div>

<?php
# see if the user is registered
if (empty($contact['Contact']['user_id'])) {
	$userLink =  $this->Html->link(__('Make '.$contact['Contact']['name'].' a Registered User', true), array('plugin' => 'users', 'controller' => 'users', 'action' => 'register', 'contact' => $contact['Contact']['id']));
} else {
	$userLink =  $this->Html->link(__('Edit User', true), array('plugin' => 'users', 'controller' => 'users', 'action' => 'edit', $contact['Contact']['user_id']));
}

// set the contextual menu items
$this->set('context_menu', array('menus' => array(
	array(
		'heading' => 'Contacts',
		'items' => array(
			$this->Html->link(__('Add Person to %s', $contact['Contact']['name']), array('plugin' => 'contacts', 'controller'=> 'contacts', 'action' => 'add', 'person', $contact['Contact']['id'])),
			),
		),
	array(
		'heading' => 'Users',
		'items' => array($userLink),
		),
	))); ?>
