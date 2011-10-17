<div class="contacts view">
  <div id="navigation">
    <div id="n1" class="info-block">
      <div class="viewRow">
        <ul class="metaData">
<?php 		if (!empty($contact['Employer'][0])) : 
		       foreach ($contact['Employer'] as $employer) : 
?>
          <li><span class="metaDataLabel"><?php __('Company : '); ?></span><span name="type" class="metaDataDetail"><?php echo $this->Html->link($employer['name'], array('controller' => 'contacts', 'action' => 'view', $employer['id'])); ?></span></li>
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
          <li><span class="metaDataLabel"><?php echo $detail['ContactDetailType']['name'] . ' : '; ?></span><span name="type" class="metaDataDetail"><?php echo $detail['value']; ?></span></li>
<?php 
        	    endforeach;
     	    endif;
?>
        </ul>
        <div class="recordData">
          <?php if (!empty($employees)) : ?>
          <h3><?php __('Employees'); ?></h3>
          <div><?php echo $this->Element('scaffolds/index', array('data' => $employees)); ?></div>
          <?php endif; ?>
        </div>
      </div>      
    </div>
    <!-- /info-block end -->
  </div>
</div>

<?php
# state which fields will be editable inline
$editFields = array(
	array(
	  'name' => 'type',
	  'tagId' => $contact['Contact']['id'],
	  'plugin' => 'contacts',
	  'controller' => 'contacts',
	  'fieldId' => 'data[Contact][id]',
	  'fieldName' => 'data[Contact][contact_type_id]',
	  'loadurl' => '/enumerations/index/type:CONTACTTYPE.json',
	  'type' => 'select'
	  ),
	array(
	  'name' => 'source',
	  'tagId' => $contact['Contact']['id'],
	  'plugin' => 'contacts',
	  'controller' => 'contacts',
	  'fieldId' => 'data[Contact][id]',
	  'fieldName' => 'data[Contact][contact_source_id]',
	  'loadurl' => '/enumerations/index/type:CONTACTSOURCE.json',
	  'type' => 'select'
	  ),
	array(
	  'name' => 'industry',
	  'tagId' => $contact['Contact']['id'],
	  'plugin' => 'contacts',
	  'controller' => 'contacts',
	  'fieldId' => 'data[Contact][id]',
	  'fieldName' => 'data[Contact][contact_industry_id]',
	  'loadurl' => '/enumerations/index/type:CONTACTINDUSTRY.json',
	  'type' => 'select'
	  ),
	array(
	  'name' => 'rating',
	  'tagId' => $contact['Contact']['id'],
	  'plugin' => 'contacts',
	  'controller' => 'contacts',
	  'fieldId' => 'data[Contact][id]',
	  'fieldName' => 'data[Contact][contact_rating_id]',
	  'loadurl' => '/enumerations/index/type:CONTACTRATING.json',
	  'type' => 'select'
	  ),
	);

echo $this->element('ajax_edit',  array('editFields' => $editFields));
?>

<?php
# see if the user is registered
if (empty($contact['Contact']['user_id'])) {
	$userLink =  $this->Html->link(__('Make '.$contact['Contact']['name'].' a Registered User', true), array('plugin' => 'users', 'controller' => 'users', 'action' => 'register', 'contact' => $contact['Contact']['id']));
} else {
	$userLink =  $this->Html->link(__('Edit User', true), array('plugin' => 'users', 'controller' => 'users', 'action' => 'edit', $contact['Contact']['user_id']));
}
?>
<div class="actions">
	<ul>
        <li>Contacts</li>
        <li><?php echo $this->Html->link(__('Add Person to '.$contact['Contact']['name'], true), array('plugin' => 'contacts', 'controller'=> 'contacts', 'action' => 'add', 'person', $contact['Contact']['id'])); ?></li>
        <li>User Mgmt</li>
    	<li><?php echo $userLink; ?></li>
     </ul>
</div>





<?php /*



<div class="contactCompanies view">
	<div class="contactname">
		<h2><span name="companyname" class="edit" id="<?php echo $contact['ContactCompany']['id']; ?>"><?php __($contact['ContactCompany']['name']);  ?></span></h2>
	</div>
	<div class="relationships data">
<?php
if ($contact['Contact']['RelateeContact']) : 
?>		<ul class="relationship datalist">
		<?php foreach ($contact['Contact']['RelateeContact'] as $relationship) : ?>
		<?php 
		if (isset($relationship['Relatee']['ContactPerson']['id'])) : 
			$relatorId = $relationship['Relatee']['ContactPerson']['id'];
			$relatorName = $relationship['Relatee']['ContactPerson']['first_name'].' '.$relationship['Relatee']['ContactPerson']['last_name'];  
			$relatorController = 'contact_people';
		elseif (isset($relationship['Relatee']['ContactCompany']['id'])) :  
			$relatorId = $relationship['Relatee']['ContactCompany']['id'];
			$relatorName = $relationship['Relatee']['ContactCompany']['name']; 
			$relatorController = 'contact_companies';
		else: 
			$relatorName = null;
		 endif;
		?>
			<li><span><?php __($relationship['ContactRelationshipType']['name']); ?></span> <?php echo $this->Html->link(__($relatorName, true), array('controller' => $relatorController, 'action' => 'view', $relatorId)) ?></li>
		<?php endforeach; ?>
		</ul>
<?php
endif;
?>		
	</div>
<div id="tabs">
    <ul>
        <li><a href="#tabs-1"><span><?php __('Details') ?></span></a></li>
        <li><a href="#tabs-2"><span><?php __('Activity') ?></span></a></li>
        <li><a href="#tabs-3"><span><?php __('Opportunity') ?></span></a></li>
        <li><a href="#tabs-4"><span><?php __('Projects') ?></span></a></li>
    </ul>
  <div id="tabs-1">
	<div class="details data">
		<ul class="detail datalist">
			<li>
				<span class="label"><?php echo $this->Html->link(__('Contact Type', true), array('plugin' => null, 'controller' => 'enumerations', 'action' => 'index', 'filter' => 'CONTACTTYPE', 'admin' => 1), array('class' => 'dialog', 'title' => 'Edit Type List')); ?></span><span name="contacttype" class="edit" id="<?php __($contact['Contact']['id']); ?>"><strong><?php echo $contact['Contact']['ContactType']['name']; ?></strong></span>
            </li>
            <li> 
				<span class="label"><?php echo $this->Html->link(__('Source', true), array('plugin' => null, 'controller' => 'enumerations', 'action' => 'index', 'filter' => 'CONTACTSOURCE', 'admin' => 1), array('class' => 'dialog', 'title' => 'Edit Source List')); ?></span><span name="source" class="edit" id="<?php __($contact['Contact']['id']); ?>"><strong><?php echo $contact['Contact']['ContactSource']['name']; ?></strong></span>
            </li>
            <li> 
				<span class="label"><?php echo $this->Html->link(__('Industry', true), array('plugin' => null, 'controller' => 'enumerations', 'action' => 'index', 'filter' => 'CONTACTINDUSTRY', 'admin' => 1), array('class' => 'dialog', 'title' => 'Edit Industry List')); ?></span><span name="industry" class="edit" id="<?php __($contact['Contact']['id']); ?>"><strong><?php echo $contact['Contact']['ContactIndustry']['name']; ?></strong></span>
            </li>
            <li> 
				<span class="label"><?php echo $this->Html->link(__('Rating', true), array('plugin' => null, 'controller' => 'enumerations', 'action' => 'index', 'filter' => 'CONTACTRATING', 'admin' => 1), array('class' => 'dialog', 'title' => 'Edit Rating List')); ?></span><span name="rating" class="edit" id="<?php __($contact['Contact']['id']); ?>"><strong><?php echo $contact['Contact']['ContactRating']['name']; ?></strong></span>
            </li>
		</ul>
	</div>

	<div class="contactinfos data">
		<h6><?php __('Details') ?></h6>
        <p class="action"><?php echo $this->Html->link(__('Add Detail', true), array('controller' => 'contact_details', 'action' => 'edit', 'contact_id' => $contact['Contact']['id']), array('class' => 'toggleClick', 'name' => 'adddetailform')); ?></p>
        <ul class="contactinfo datalist">
		  <li class="hide" id="adddetailform">
			<?php echo $this->Form->create('ContactDetail', array('url'=> array('action'=>'add')));?>
				<?php
					echo $this->Form->input('contact_id', array('type' => 'hidden', 'value' => $contact['Contact']['id'])); 
					echo $this->Form->input('contact_detail_type_id', array('label' => $this->Html->link(__('Detail Type', true), array('plugin' => null, 'controller' => 'enumerations', 'action' => 'index', 'filter' => 'CONTACTDETAIL', 'admin' => 1), array('class' => 'dialog', 'title' => 'Edit Detail List')))); 
					echo $this->Form->input('value');
				?>
			<?php echo $this->Form->end('Submit');?>
		  </li>	
<?php
if ($contact['Contact']['ContactDetail']) : 
?>		
			<?php foreach ($contact['Contact']['ContactDetail'] as $detail) : ?>
			<li><strong><?php __($detail['ContactDetailType']['name'].': '); ?></strong><span name="detail" class="edit" id="<?php __($detail['id']); ?>"><?php echo $detail['value']; ?></span>
			<p class="action"><?php echo $this->Html->link(__('Delete', true), array('plugin' => 'contacts', 'controller' => 'contact_details', 'action' => 'delete', $detail['id']), null, 'Are you sure you want to delete "'.$detail['value']); ?></p></li>
			<?php endforeach; ?>
		
<?php
endif;
?>		</ul>
	</div>

	<div class="addresses data">
        <p class="action"><?php echo $this->Html->link(__('Add Address', true), array('controller' => 'contact_addresses', 'action' => 'edit', 'contact_id' => $contact['Contact']['id']), array('class' => 'toggleClick', 'name' => 'addaddressform')); ?></p>	
        <ul class="address datalist">
		  <li class="hide" id="addaddressform">
			<?php echo $this->Form->create('ContactAddress', array('url'=> array('action'=>'add')));?>
				<?php
					echo $this->Form->input('contact_id', array('type' => 'hidden', 'value' => $contact['Contact']['id'])); 
					echo $this->Form->input('contact_address_type_id', array('label' => $this->Html->link(__('Address Type', true), array('plugin' => null, 'controller' => 'enumerations', 'action' => 'index', 'filter' => 'CONTACTADDRESS', 'admin' => 1), array('class' => 'dialog', 'title' => 'Edit Address List')))); 
					echo $this->Form->input('street1'); 
					echo $this->Form->input('street2');
					echo $this->Form->input('city');
					echo $this->Form->input('state_id', array('label' => $this->Html->link(__('State', true), array('plugin' => null, 'controller' => 'states', 'action' => 'index', 'admin' => 1), array('class' => 'dialog', 'title' => 'Edit State List'))));
					echo $this->Form->input('zip_postal');
					echo $this->Form->input('country_id', array('label' => $this->Html->link(__('Country', true), array('plugin' => null, 'controller' => 'countries', 'action' => 'index', 'admin' => 1), array('class' => 'dialog', 'title' => 'Edit Country List'))));
				?>
			<?php echo $this->Form->end('Submit');?>
		  </li>	
<?php if ($contact['Contact']['ContactAddress']) : ?>
			<?php foreach ($contact['Contact']['ContactAddress'] as $address) : ?>
			<li id="addresslist<?php echo $address['id']; ?>"><strong><?php echo $address['ContactAddressType']['name'].': '; ?></strong><p class="action"><?php echo $this->Html->link(__('Delete', true), array('plugin' => 'contacts', 'controller' => 'contact_addresses', 'action' => 'delete', $address['id']), null, 'Are you sure you want to delete'); ?></p>
				<ul>
					<li><strong><?php __('Address 1: '); ?></strong><span name="addressstreet1" class="edit" id="<?php echo $address['id']; ?>"><?php echo $address['street1']; ?></span></li>

					<li><strong><?php __('Address 2: '); ?></strong><span name="addressstreet2" class="edit" id="<?php echo $address['id']; ?>"><?php echo $address['street2']; ?></span></li>

					<li><strong><?php __('City: '); ?></strong><span name="addresscity" class="edit" id="<?php echo $address['id']; ?>"><?php echo $address['city']; ?></span></li>

					<li><strong><?php __('State: '); ?></strong><span name="addressstate" class="edit" id="<?php echo $address['id']; ?>"><?php echo $address['State']['name']; ?></span></li>

					<li><strong><?php __('Zip: '); ?></strong><span name="addresszip" class="edit" id="<?php echo $address['id']; ?>"><?php echo $address['zip_postal']; ?></span></li>

					<li><strong><?php __('Country: '); ?></strong><span name="addresscountry" class="edit" id="<?php echo $address['id']; ?>"><?php echo $address['Country']['name']; ?></span></li>
				</ul>
			</li>
			<?php endforeach; ?>
<?php endif; ?>		
		</ul>
	</div>


	
  </div> 
  <div id="tabs-2">
	<div class="activities data">
		<h6><?php __('Activities') ?></h6>
        <p class="action"><?php echo $this->Html->link(__('Add Activity', true), array('controller' => 'contact_activities', 'action' => 'edit', 'contact_id' => $contact['Contact']['id']), array('class' => 'toggleClick', 'name' => 'addactivityform')); ?></p>	
		<ul class="activity datalist">
		  <li class="hide" id="addactivityform">
			<?php echo $this->Form->create('ContactActivity', array('url'=> array('action'=>'add')));?>
				<?php
					echo $this->Form->input('contact_id', array('type' => 'hidden', 'value' => $contact['Contact']['id'])); 
					echo $this->Form->input('contact_activity_type_id', array('label' => $this->Html->link(__('Activity Type', true), array('plugin' => null, 'controller' => 'enumerations', 'action' => 'index', 'filter' => 'CONTACTACTIVITY', 'admin' => 1), array('class' => 'dialog', 'title' => 'Edit Activity List')))); 
					echo $this->Form->input('name', array('label' => 'Subject')); 
					echo $this->Form->input('description');
				?>
			<?php echo $this->Form->end('Submit');?>
<?php if ($contact['Contact']['ContactActivity']) :  ?>
			<?php foreach ($contact['Contact']['ContactActivity'] as $activity) : ?>
					<li><strong><?php __($activity['ContactActivityType']['name'].' Subject: '); echo $this->Html->link(__($activity['name'], true), array('controller'=> 'contact_activities', 'action' => 'edit', $activity['id'])); ?></strong><p class="action"><?php echo $this->Html->link(__('Delete', true), array('plugin' => 'contacts', 'controller' => 'contact_activities', 'action' => 'delete', $activity['id']), null, 'Are you sure you want to delete'); ?></p>
						<ul>
							<li><span class="description"><?php __(nl2br($activity['description'])); ?></span></li>
							<li><span class="created"><?php __($this->Time->nice($activity['created'])); ?></span></li>
						</ul>
					</li>
			<?php endforeach; ?>
<?php endif; ?>	
		</ul>
	</div>
  </div>
  
  <div id="tabs-3">
	<div class="opportunities data">
        <p class="action"><?php echo $this->Html->link(__('Add Opportunity', true), array('controller' => 'contact_opportunities', 'action' => 'edit', 'contact_id' => $contact['Contact']['id']), array('class' => 'toggleClick', 'name' => 'addopportunityform')); ?></p>	
        <div class="opportunity datalist">
		  <div class="hide" id="addopportunityform">
			<?php echo $this->Form->create('ContactOpportunity', array('action'=>'edit'));?>
				<?php
					echo $this->Form->input('ContactOpportunity.contact_id', array('type' => 'hidden', 'value' => $contact['Contact']['id']));
					echo $this->Form->input('ContactOpportunity.enumeration_id', array('label' => $this->Html->link(__('Opportunity Type', true), array('plugin' => null, 'controller' => 'enumerations', 'action' => 'index', 'filter' => 'CONTACTOPPORTUNITYTYPE', 'admin' => 1), array('class' => 'dialog', 'title' => 'Edit Opportunity List')))); 
					echo $this->Form->input('ContactOpportunity.name', array('label' => 'Subject')); 
					echo $this->Form->input('ContactOpportunity.description', array('type' => 'richtext', 'ckeSettings' => array('buttons' => array('Bold','Italic','Underline','FontSize','TextColor','BGColor','-','NumberedList','BulletedList','Blockquote','JustifyLeft','JustifyCenter','JustifyRight','-','Link','Unlink','-', 'Image'))));
					echo $this->Form->input('ContactOpportunity.assignee_id', array('label' => 'Assign To'));
					echo $this->Form->input('ContactOpportunity.due_date', array('minYear' => date('Y'), 'maxYear' => date('Y') + 10, 'interval' =>  15));
				?>
			<?php echo $this->Form->end('Submit');?>	
          </div>
		<?php
		if ($contact['Contact']['ContactOpportunity']) : 
			foreach ($contact['Contact']['ContactOpportunity'] as $opportunity) : 
		?>
				<div class="opportunity detail">
					<p>
					<span class="opportunity-name"><?php echo $this->Html->link(__($opportunity['Enumeration']['name'].' Re: '.$opportunity['name'], true), array('plugin' => 'contacts', 'controller'=> 'contact_opportunities', 'action' => 'edit', $opportunity['id']), array('class' => 'toggleClick', 'name' => 'opportunity-detail'.$opportunity['id'])); ?>
                    </span>
                    </p>
					<div class="hide" id="opportunity-detail<?php echo $opportunity['id']; ?>">
                    	<p><?php __($opportunity['description']); ?></span></p>
                   		<div class="hide" id="extended-detail<?php echo $opportunity['id']; ?>">
							<p><span class="label"><?php __('Due Date: '); ?></span><?php __($opportunity['due_date']); ?></p>
							<p><span class="label"><?php __('Assigned To: '); ?></span><?php __($opportunity['Assignee']['username']); ?></p>
							<p><span class="label"><?php __('Created By: '); ?></span><?php __($opportunity['Assignee']['username']); ?></p>
    	                </div>
                    	<p class="action"><?php echo $this->Html->link(__('Show Details', true), array('plugin' => 'contacts', 'controller'=> 'contact_opportunities', 'action' => 'edit', $opportunity['id']), array('class' => 'toggleClick', 'name' => 'extended-detail'.$opportunity['id'])); ?><?php echo $this->Html->link(__('Delete', true), array('plugin' => 'contacts', 'controller' => 'contact_opportunities', 'action' => 'delete', $opportunity['id']), null, 'Are you sure you want to delete'); ?></p>
					</div>
				</div>
			<?php
            	endforeach;
			endif;
			?>		
		</div>
	</div>
  </div>
  
  <div id="tabs-4">
	<div class="projects data">
		<h6><?php __('Projects') ?></h6>
		<p class="action"><?php echo $this->Html->link(__('Add Project', true), array('plugin' => 'projects', 'controller' => 'projects', 'action' => 'edit', 'contact_id' => $contact['Contact']['id'])); ?></p>	
<?php
if ($contact['Contact']['Project']) : 
?>
		<table>
        	<tr>
            <th><?php __('Status'); ?></th>
            <th><?php __('Name'); ?></th>
            <th><?php __('Estimated Hours'); ?></th>
            <th><?php __('Spent Hours'); ?></th>
            </tr>
			<?php foreach ($contact['Contact']['Project'] as $project) : ?>
            <tr>
            <td><?php echo $project['ProjectStatusType']['name']; ?></td>
			<td><?php echo $this->Html->link(__($project['name'], true), array('plugin' => 'projects', 'controller'=> 'projects', 'action' => 'view', $project['id'])); ?>
			</td>
            <td><?php echo $project['estimated_hours']; ?></td>
            <td><?php #to do put calculation here (copy from projects/view)  echo $project['spent_house']; ?></td>
            </tr>
			<?php endforeach; ?>
        </table>
<?php
endif;
?>		
	</div>
  </div>
</div>




<p class="timing"><strong><?php __($contact['ContactCompany']['name']);?></strong><?php __(' was '); ?><strong><?php __('Created: '); ?></strong><?php echo $this->Time->relativeTime($contact['ContactCompany']['created']); ?><?php __(', '); ?><strong><?php __('Last Modified: '); ?></strong><?php echo $this->Time->relativeTime($contact['ContactCompany']['modified']); ?></p>

</div>

		
<?php 
# state which fields will be editable inline
$editFields = array(
	array(
		'name' => 'companyname',
	  	'tagId' => $contact['ContactCompany']['id'],
		'plugin' => 'contacts',
		'plugin' => 'contacts',
		'controller' => 'contact_companies',
		'fieldId' => 'data[ContactCompany][id]',
		'fieldName' => 'data[ContactCompany][name]',
		'type' => 'text'
	),
	array(
		'name' => 'contacttype',
		'tagId' => $contact['Contact']['id'],
		'plugin' => 'contacts',
		'controller' => 'contacts',
		'fieldId' => 'data[Contact][id]',
		'fieldName' => 'data[Contact][contact_type_id]',
		'loadurl' => '/enumerations/index/type:CONTACTTYPE.json',
		'type' => 'select'
	),
	array(
		'name' => 'source',
		'tagId' => $contact['Contact']['id'],
		'plugin' => 'contacts',
		'controller' => 'contacts',
		'fieldId' => 'data[Contact][id]',
		'fieldName' => 'data[Contact][contact_source_id]',
		'loadurl' => '/enumerations/index/type:CONTACTSOURCE.json',
		'type' => 'select'
	),
	array(
		'name' => 'industry',
		'tagId' => $contact['Contact']['id'],
		'plugin' => 'contacts',
		'controller' => 'contacts',
		'fieldId' => 'data[Contact][id]',
		'fieldName' => 'data[Contact][contact_industry_id]',
		'loadurl' => '/enumerations/index/type:CONTACTINDUSTRY.json',
		'type' => 'select'
	),
	array(
		'name' => 'rating',
		'tagId' => $contact['Contact']['id'],
		'plugin' => 'contacts',
		'controller' => 'contacts',
		'fieldId' => 'data[Contact][id]',
		'fieldName' => 'data[Contact][contact_rating_id]',
		'loadurl' => '/enumerations/index/type:CONTACTRATING.json',
		'type' => 'select'
	),
);

#build address editable fields
$addresses = array(); 
$i = 0;
foreach ($contact['Contact']['ContactAddress'] as $address) :
	$addresses[$i]['name'] = 'addressstreet1';
	$addresses[$i]['tagId'] = $address['id'];
	$addresses[$i]['plugin'] = 'contacts';
	$addresses[$i]['controller'] = 'contact_addresses';
	$addresses[$i]['fieldId'] = 'data[ContactAddress][id]';
	$addresses[$i]['fieldName'] = 'data[ContactAddress][street1]';
	$addresses[$i]['type'] = 'text';
	array_push($editFields, $addresses[$i]);
	$i++;
endforeach;
foreach ($contact['Contact']['ContactAddress'] as $address) :
	$addresses[$i]['name'] = 'addressstreet2';
	$addresses[$i]['tagId'] = $address['id'];
	$addresses[$i]['plugin'] = 'contacts';
	$addresses[$i]['controller'] = 'contact_addresses';
	$addresses[$i]['fieldId'] = 'data[ContactAddress][id]';
	$addresses[$i]['fieldName'] = 'data[ContactAddress][street2]';
	$addresses[$i]['type'] = 'text';
	array_push($editFields, $addresses[$i]);
	$i++;
endforeach;
foreach ($contact['Contact']['ContactAddress'] as $address) :
	$addresses[$i]['name'] = 'addresscity';
	$addresses[$i]['tagId'] = $address['id'];
	$addresses[$i]['plugin'] = 'contacts';
	$addresses[$i]['controller'] = 'contact_addresses';
	$addresses[$i]['fieldId'] = 'data[ContactAddress][id]';
	$addresses[$i]['fieldName'] = 'data[ContactAddress][city]';
	$addresses[$i]['type'] = 'text';
	array_push($editFields, $addresses[$i]);
	$i++;
endforeach;
foreach ($contact['Contact']['ContactAddress'] as $address) :
	$addresses[$i]['name'] = 'addressstate';
	$addresses[$i]['tagId'] = $address['id'];
	$addresses[$i]['plugin'] = 'contacts';
	$addresses[$i]['controller'] = 'contact_addresses';
	$addresses[$i]['fieldId'] = 'data[ContactAddress][id]';
	$addresses[$i]['fieldName'] = 'data[ContactAddress][state_id]';
	$addresses[$i]['loadurl'] = '/admin/states/index.json';
	$addresses[$i]['type'] = 'select';
	array_push($editFields, $addresses[$i]);
	$i++;
endforeach;
foreach ($contact['Contact']['ContactAddress'] as $address) :
	$addresses[$i]['name'] = 'addresszip';
	$addresses[$i]['tagId'] = $address['id'];
	$addresses[$i]['plugin'] = 'contacts';
	$addresses[$i]['controller'] = 'contact_addresses';
	$addresses[$i]['fieldId'] = 'data[ContactAddress][id]';
	$addresses[$i]['fieldName'] = 'data[ContactAddress][zip_postal]';
	$addresses[$i]['type'] = 'text';
	array_push($editFields, $addresses[$i]);
	$i++;
endforeach;
foreach ($contact['Contact']['ContactAddress'] as $address) :
	$addresses[$i]['name'] = 'addresscountry';
	$addresses[$i]['tagId'] = $address['id'];
	$addresses[$i]['plugin'] = 'contacts';
	$addresses[$i]['controller'] = 'contact_addresses';
	$addresses[$i]['fieldId'] = 'data[ContactAddress][id]';
	$addresses[$i]['fieldName'] = 'data[ContactAddress][country_id]';
	$addresses[$i]['loadurl'] = '/admin/countries/index.json';
	$addresses[$i]['type'] = 'select';
	array_push($editFields, $addresses[$i]);
	$i++;
endforeach;
#build details editable fields
$details = array();
foreach ($contact['Contact']['ContactDetail'] as $detail) :
	$details[$i]['name'] = 'detail';
	$details[$i]['tagId'] = $detail['id'];
	$details[$i]['plugin'] = 'contacts';
	$details[$i]['controller'] = 'contact_details';
	$details[$i]['fieldId'] = 'data[ContactDetail][id]';
	$details[$i]['fieldName'] = 'data[ContactDetail][value]';
	$details[$i]['type'] = 'text';
	array_push($editFields, $details[$i]);
	$i++;
endforeach;
#call the ajax edit element to output jquery on the page
echo $this->element('ajax_edit',  array('editFields' => $editFields));
?>



*/ ?>