<div class="contactCompanies view">
	<div class="contactname">
		<h2><span id="companyname"><?php ajax_add($contactCompany['ContactCompany']['name']);  ?></span></h2>
	</div>
	<div class="relationships data">
<?php
if ($contactCompany['Contact']['RelatedContact']) : 
?>		<ul class="relationship datalist">
		<?php foreach ($contactCompany['Contact']['RelatedContact'] as $relationship) : ?>
		<?php 
		if (isset($relationship['Relator']['ContactPerson']['id'])) : 
			$relator = $relationship['Relator']['ContactPerson']['first_name'].' '.$relationship['Relator']['ContactPerson']['last_name'];  
		elseif (isset($relationship['Relator']['ContactCompany']['id'])) : 
			$relator = $relationship['Relator']['ContactCompany']['name']; 
		else: 
			$relator = null;
		 endif;
		?>
			<li><span id="contactrelationship<?php echo $relationship['id']; ?>"><?php __($relationship['ContactRelationshipType']['name']); ?></span><?php __(' of '); ?><?php __($relator); ?><?php echo $ajax->editor('contactrelationship'.$relationship['id'], '/admin/contact_companies/ajax_update/'.$relationship['id'].'/contact_relationship_type_id/contacts_relationship', array("okControl" => "button", "cancelControl" => "link", "clickToEditText" => "Click to edit","submitOnBlur" => "false", "collection" => $ajaxTypeList['ContactRelationshipType'])); ?></li>
		<?php endforeach; ?>
		</ul>
		<p class="action"><?php echo $html->link(__('Create Relationship', true), array('controller'=> 'ContactRelationships', 'action' => 'add')); ?></p>
<?php
endif;
?>		
	</div>

<div id="tabs">
    <ul>
        <li id="tabHeaderActive"><a href="javascript:void(0)" onclick="toggleTab(1,8)"><span><?php __('Details') ?></span></a></li>
        <li id="tabHeader2"><a href="javascript:void(0)" onclick="toggleTab(2,8)" ><span><?php __('Activities') ?></span></a></li>
        <li id="tabHeader3"><a href="javascript:void(0)" onclick="toggleTab(3,8)"><span><?php __('Tasks') ?></span></a></li>
        <li id="tabHeader4"><a href="javascript:void(0)" onclick="toggleTab(4,8)"><span><?php __('Orders') ?></span></a></li>
        <li id="tabHeader5"><a href="javascript:void(0)" onclick="toggleTab(5,8);"><span><?php __('Watching') ?></span></a></li>
        <li id="tabHeader6"><a href="javascript:void(0)" onclick="toggleTab(6,8);"><span><?php __('Projects') ?></span></a></li>
        <li id="tabHeader7"><a href="javascript:void(0)" onclick="toggleTab(7,8);"><span><?php __('Quotes') ?></span></a></li>
        <li id="tabHeader8"><a href="javascript:void(0)" onclick="toggleTab(8,8);"><span><?php __('Tickets') ?></span></a></li>
    </ul>
</div>

<div id="tabscontent">
  <div id="tabContent1" class="tabContent" style="display:yes;">
	<div class="defaults data">
		<h6><?php __('Default Data') ?></h6>
		<ul class="default datalist">
			<li><strong><?php __('Primary Email: '); ?></strong><span id="primaryemail"><?php ajax_add($contactCompany['Contact']['primary_email']); ?></span></li>	
			<li><strong><?php __('Type: '); ?></strong><span id="contacttype"><?php ajax_add($contactCompany['Contact']['ContactType']['name']); ?></span><p class="action"><?php echo $html->link(__('Edit', true), array('controller' => 'contact_types', 'action' => 'index')); ?></p></li>		
			<li><strong><?php __('Source: '); ?></strong><span id="contactsource"><?php ajax_add($contactCompany['Contact']['ContactSource']['name']); ?></span><p class="action"><?php echo $html->link(__('Edit', true), array('controller' => 'contact_sources', 'action' => 'index')); ?></p></li>
			<li><strong><?php __('Industry: '); ?></strong><span id="contactindustry"><?php ajax_add($contactCompany['Contact']['ContactIndustry']['name']); ?></span><p class="action"><?php echo $html->link(__('Edit', true), array('controller' => 'contact_industries', 'action' => 'index')); ?></p></li>
			<li><strong><?php __('Rating: '); ?></strong><span id="contactrating"><?php ajax_add($contactCompany['Contact']['ContactRating']['name']); ?></span><p class="action"><?php echo $html->link(__('Edit', true), array('controller' => 'contact_ratings', 'action' => 'index')); ?></p></li>
		</ul>
	</div>

	<div class="details data">
		<h6><?php __('Details') ?></h6>
		<p class="action"><?php echo $html->link(__('Add Detail', true), array('controller' => 'contact_details', 'action' => 'ajax_edit', 'contact_id' => $contactCompany['ContactCompany']['contact_id']), array('title' => 'Add Detail for '.$contactCompany['ContactCompany']['name'], 'onclick' => 'Modalbox.show(this.href, {title: this.title, width: 500}); return false;')); ?></p>
<?php
if ($contactCompany['Contact']['ContactDetail']) : 
?>		<ul class="detail datalist">
			<?php foreach ($contactCompany['Contact']['ContactDetail'] as $detail) : ?>
			<li id="detaillist<?php echo $detail['id']; ?>"><strong><?php __($detail['ContactDetailType']['name'].': '); ?></strong><span id="contactdetail<?php echo $detail['id']; ?>"><?php ajax_add($detail['value']); ?></span><?php echo $ajax->editor('contactdetail'.$detail['id'], 'ajax_update/'.$detail['id'].'/value/contact_detail', array("okControl" => "button", "cancelControl" => "link", "clickToEditText" => "Click to edit","submitOnBlur" => "false", array('inline' => false))); ?>
			<p class="action"><?php echo $ajax->link('X', array('controller' => 'contact_details', 'action' => 'ajax_delete', $detail['id']), array('indicator' => 'loadingimg', 'update' => 'detaillist'.$detail['id'], 'complete' => 'Effect.Fade(\'deleteMessage\', { duration: 2.0 });'), 'Are you sure you want to delete "'.$detail['value'].'"'); ?></p></li>
			<?php endforeach; ?>
		</ul>
<?php
endif;
?>		
	</div>


	<div class="addresses data">
		<h6><?php __('Addresses') ?></h6>		
		<p class="action"><?php echo $html->link(__('Add Address', true), array('controller' => 'contact_addresses', 'action' => 'ajax_edit', 'contact_id' => $contactCompany['ContactCompany']['contact_id']), array('title' => 'Add Address for '.$contactCompany['ContactCompany']['name'], 'onclick' => 'Modalbox.show(this.href, {title: this.title, width: 500}); return false;')); ?></p>
<?php
if ($contactCompany['Contact']['ContactAddress']) : 
?>		<ul class="address datalist">
			<?php foreach ($contactCompany['Contact']['ContactAddress'] as $address) : ?>
			<li id="addresslist<?php echo $address['id']; ?>"><strong><?php echo $address['ContactAddressType']['name'].': '; ?></strong><p class="action"><?php echo $ajax->link('X', array('controller' => 'contact_addresses', 'action' => 'ajax_delete', $address['id']), array('indicator' => 'loadingimg', 'update' => 'addresslist'.$address['id'], 'complete' => 'Effect.Fade(\'deleteMessage\', { duration: 2.0 });'), 'Are you sure you want to delete "'.$address['ContactAddressType']['name'].'"'); ?></p>
				<ul>
					<li><strong><?php __('Address 1: '); ?></strong><span id="addressstreet1<?php echo $address['id']; ?>"><?php ajax_add($address['street1']); ?></span><?php echo $ajax->editor('addressstreet1'.$address['id'], 'ajax_update/'.$address['id'].'/street1/contact_address', array("okControl" => "button", "cancelControl" => "link", "clickToEditText" => "Click to edit","submitOnBlur" => "false")); ?></li>

					<li><strong><?php __('Address 2: '); ?></strong><span id="addressstreet2<?php echo $address['id']; ?>"><?php ajax_add($address['street2']); ?></span><?php echo $ajax->editor('addressstreet2'.$address['id'], 'ajax_update/'.$address['id'].'/street2/contact_address', array("okControl" => "button", "cancelControl" => "link", "clickToEditText" => "Click to edit","submitOnBlur" => "false")); ?></li>

					<li><strong><?php __('City: '); ?></strong><span id="addresscity<?php echo $address['id']; ?>"><?php ajax_add($address['city']); ?></span><?php echo $ajax->editor('addresscity'.$address['id'], 'ajax_update/'.$address['id'].'/city/contact_address', array("okControl" => "button", "cancelControl" => "link", "clickToEditText" => "Click to edit","submitOnBlur" => "false")); ?></li>

					<li><strong><?php __('State: '); ?></strong><span id="addressstate<?php echo $address['id']; ?>"><?php ajax_add($address['State']['name']); ?></span><?php echo $ajax->editor('addressstate'.$address['id'], 'ajax_update/'.$address['id'].'/state_id/contact_address', array("okControl" => "button", "cancelControl" => "link", "clickToEditText" => "Click to edit","submitOnBlur" => "false", "collection" => $ajaxTypeList['State'])); ?></li>

					<li><strong><?php __('Zip: '); ?></strong><span id="addresszip<?php echo $address['id']; ?>"><?php ajax_add($address['zip_postal']); ?></span><?php echo $ajax->editor('addresszip'.$address['id'], 'ajax_update/'.$address['id'].'/zip_postal/contact_address', array("okControl" => "button", "cancelControl" => "link", "clickToEditText" => "Click to edit","submitOnBlur" => "false")); ?></li>

					<li><strong><?php __('Country: '); ?></strong><span id="addresscountry<?php echo $address['id']; ?>"><?php ajax_add($address['Country']['name']); ?></span><?php echo $ajax->editor('addresscountry'.$address['id'], 'ajax_update/'.$address['id'].'/country_id/contact_address', array("okControl" => "button", "cancelControl" => "link", "clickToEditText" => "Click to edit","submitOnBlur" => "false", "collection" => $ajaxTypeList['Country'])); ?></li>

				</ul>
			</li>
			<?php endforeach; ?>
		</ul>
<?php
endif;
?>
	</div>


	<div class="tags data">
		<h6><?php __('Tag Cloud') ?></h6>
		<p class="action"><?php echo $html->link(__('Edit Tags', true), array('controller'=> 'contacts_tags', 'action' => 'index', 'contact_id' => $contactCompany['Contact']['id']), array('title' => 'Add Tag for '.$contactCompany['ContactCompany']['name'], 'onclick' => 'Modalbox.show(this.href, {title: this.title, width: 500}); return false;')); ?></p>
<?php
// Format tags for tagcloud
if ($contactCompany['Contact']['Tag']) : 
	$tags = array();
	foreach($contactCompany['Contact']['Tag'] as $tag): 
	    $tags = array_merge($tags, array($tag['name'] => $tag['count']));
	endforeach;
	$cloud = $tagcloud->formulateTagCloud($tags);
?>
		<ul class="tag datalist">
		<?php foreach($cloud as $tag => $count) : ?>
			<li><span style="font-size:<?php __($count['size']) ?>%"><?php __($tag); ?></span></li>
		<?php endforeach; ?>
		</ul>
<?php
endif;
?>		
	</div>
  </div> 
  <div id="tabContent2" class="tabContent" style="display:none;">
	<div class="activities data">
		<h6><?php __('Activities') ?></h6>
		<p class="action"><?php echo $html->link(__('Add Activity', true), array('controller' => 'contact_activities', 'action' => 'ajax_edit', 'contact_id' => $contactCompany['ContactCompany']['contact_id']), array('title' => 'Add Activity for '.$contactCompany['ContactCompany']['name'], 'onclick' => 'Modalbox.show(this.href, {title: this.title, width: 500}); return false;')); ?></p>
<?php
if ($contactCompany['Contact']['ContactActivity']) : 
?>
			<?php foreach ($contactCompany['Contact']['ContactActivity'] as $activity) : ?>
				<ul class="activity datalist" id="activitylist<?php echo $activity['id']; ?>">
					<li><strong><?php __($activity['ContactActivityType']['name'].' Subject: '); echo $html->link(__($activity['name'], true), array('controller'=> 'contact_activities', 'action' => 'edit', $activity['id'])); ?></strong><p class="action"><?php echo $ajax->link('X', array('controller' => 'contact_activities', 'action' => 'ajax_delete', $activity['id']), array('update' => 'activitylist'.$activity['id'], 'complete' => 'Effect.Fade(\'deleteMessage\', { duration: 2.0 });'), 'Are you sure you want to delete "'.$activity['name'].'"'); ?></p>
						<ul>
							<li><span class="description"><?php __($activity['description']); ?></span></li>
							<li><span class="created"><?php __($activity['created']); ?></span></li>
							<li><span class="modified"><?php __($activity['modified']); ?></span></li>
							<li></li>
						</ul>
					</li>
				</ul>
			<?php endforeach; ?>
<?php
endif;
?>	
	</div>
  </div>
  <div id="tabContent3" class="tabContent" style="display:none;">
	<div class="tasks data">
		<h6><?php __('Tasks') ?></h6>		
<?php
if ($contactCompany['Contact']['ContactTask']) : 
?>		<ul class="task datalist">
			<?php foreach ($contactCompany['Contact']['ContactTask'] as $task) : ?>
			<li><?php echo $html->link(__($task['name'], true), array('controller'=> 'ContactTasks', 'action' => 'view', $task['id'])); ?></li>
			<?php endforeach; ?>
		</ul>
<?php
endif;
?>		<p class="action"><?php echo $html->link(__('Create', true), array('controller'=> 'ContactTasks', 'action' => 'add')); ?></p>
	</div>
  </div>
  <div id="tabContent4" class="tabContent" style="display:none;">
	<div class="orders data">
		<h6><?php __('Orders') ?></h6>		
<?php
if ($contactCompany['Contact']['Order']) : 
?>
		<ul class="order datalist">
			<?php foreach ($contactCompany['Contact']['Order'] as $order) : ?>
			<li><?php echo $html->link(__($time->nice($order['created']), true), array('controller'=> 'Orders', 'action' => 'view', $order['id'])); ?></li>
			<?php endforeach; ?>
		</ul>
<?php
endif;
?>		<p class="action"><?php echo $html->link(__('Create', true), array('controller'=> 'Orders', 'action' => 'add')); ?></p>
	</div>
  </div>
  <div id="tabContent5" class="tabContent" style="display:none;">
  	<div class="watching data">
		<h6><?php __('Watching') ?></h6>	
		<p class="action"><?php echo $html->link(__('Add Project', true), array('controller'=> 'projects', 'action' => 'edit')); ?></p>	
<?php
if ($contactCompany['Contact']['Watcher']) : 
?>
		<ul class="watch datalist">
			<?php foreach ($contactCompany['Contact']['Watcher'] as $project) : ?>
			<li><?php echo $html->link(__($project['Project']['name'], true), array('controller'=> 'projects', 'action' => 'view', $project['Project']['id'])); ?>
				<ul>
				<?php foreach ($project['Project']['ProjectIssue'] as $issue) : ?>
					<li><?php echo $html->link(__($issue['name'], true), array('controller'=> 'project_issues', 'action' => 'view', $issue['id'])); ?></li>
				<?php endforeach; ?>
				</ul>
			</li>
			<?php endforeach; ?>
		</ul>
<?php
endif;
?>		
	</div>
  </div>
  <div id="tabContent6" class="tabContent" style="display:none;">
	<div class="projects data">
		<h6><?php __('Projects') ?></h6>
		<p class="action"><?php echo $html->link(__('Add Project', true), array('controller' => 'projects', 'action' => 'edit', 'contact_id' => $contactCompany['Contact']['id']), array('title' => 'Add Project', 'onclick' => 'Modalbox.show(this.href, {title: this.title, width: 500}); return false;')); ?></p>		
<?php
if ($contactCompany['Contact']['Project']) : 
?>
		<ul class="project datalist">
			<?php foreach ($contactCompany['Contact']['Project'] as $project) : ?>
			<li><?php echo $html->link(__($project['name'], true), array('controller'=> 'Projects', 'action' => 'view', $project['id'])); ?>
				<ul>
				<?php foreach ($project['ProjectIssue'] as $issue) : ?>
					<li><?php echo $html->link(__($issue['name'], true), array('controller'=> 'ProjectIssues', 'action' => 'view', $issue['id'])); ?></li>
				<?php endforeach; ?>
				</ul>
			</li>
			<?php endforeach; ?>
		</ul>
<?php
endif;
?>		
	</div>
  </div>
  <div id="tabContent7" class="tabContent" style="display:none;">
	<div class="quotes data">
		<h6><?php __('Quotes') ?></h6>		
<?php
if ($contactCompany['Contact']['Quote']) : 
?>
		<ul class="quote datalist">
			<?php foreach ($contactCompany['Contact']['Quote'] as $quote) : ?>
			<li><?php echo $html->link(__($quote['name'], true), array('controller'=> 'Quotes', 'action' => 'view', $quote['id'])); ?></li>
			<?php endforeach; ?>
		</ul>
<?php
endif;
?>		<p class="action"><?php echo $html->link(__('Create', true), array('controller'=> 'Quotes', 'action' => 'add')); ?></p>
	</div>
  </div>
  <div id="tabContent8" class="tabContent" style="display:none;">
	<div class="tickets data">
		<h6><?php __('Tickets') ?></h6>		
<?php
if ($contactCompany['Contact']['Ticket']) : 
?>
		<ul class="ticket datalist">
			<?php foreach ($contactCompany['Contact']['Ticket'] as $ticket) : ?>
			<li><?php echo $html->link(__($ticket['subject'], true), array('controller'=> 'Tickets', 'action' => 'view', $ticket['id'])); ?></li>
			<?php endforeach; ?>
		</ul>
<?php
endif;
?>		<p class="action"><?php echo $html->link(__('Create', true), array('controller'=> 'Tickets', 'action' => 'add')); ?></p>
	</div>
  </div>
</div>




<p class="timing"><strong><?php __($contactCompany['ContactCompany']['name']);?></strong><?php __(' was '); ?><strong><?php __('Created: '); ?></strong><?php echo $time->relativeTime($contactCompany['ContactCompany']['created']); ?><?php __(', '); ?><strong><?php __('Last Modified: '); ?></strong><?php echo $time->relativeTime($contactCompany['ContactCompany']['modified']); ?></p>

</div>

		
<?php 
## ajax editable fields 
echo $ajax->editor('primaryemail', 'ajax_update/'.$contactCompany['Contact']['id'].'/primary_email/contact', array("okControl" => "button", "cancelControl" => "link", "clickToEditText" => "Click to edit","submitOnBlur" => "false")); 

echo $ajax->editor('companyname', 'ajax_update/'.$contactCompany['ContactCompany']['id'].'/name/contact_company', array("okControl" => "button", "cancelControl" => "link", "clickToEditText" => "Click to edit","submitOnBlur" => "false")); 

echo $ajax->editor('contacttype', 'ajax_update/'.$contactCompany['Contact']['id'].'/contact_type_id/contact', array("okControl" => "button", "cancelControl" => "link", "clickToEditText" => "Click to edit contact type","submitOnBlur" => "false", "collection" => $ajaxTypeList['ContactType'])); 

echo $ajax->editor('contactsource', 'ajax_update/'.$contactCompany['Contact']['id'].'/contact_source_id/contact', array("okControl" => "button", "cancelControl" => "link", "clickToEditText" => "Click to edit","submitOnBlur" => "false", "collection" => $ajaxTypeList['ContactSource'])); 

echo $ajax->editor('contactindustry', 'ajax_update/'.$contactCompany['Contact']['id'].'/contact_industry_id/contact', array("okControl" => "button", "cancelControl" => "link", "clickToEditText" => "Click to edit","submitOnBlur" => "false", "collection" => $ajaxTypeList['ContactIndustry']));

echo $ajax->editor('contactrating', 'ajax_update/'.$contactCompany['Contact']['id'].'/contact_rating_id/contact', array("okControl" => "button", "cancelControl" => "link", "clickToEditText" => "Click to edit","submitOnBlur" => "false", "collection" => $ajaxTypeList['ContactRating']));
?>

<?php 
$menu->setValue(array($html->link(__('New Person', true), '/admin/contact_people/edit', array('title' => 'Add Person', 'onclick' => 'Modalbox.show(this.href, {title: this.title, width: 500}); return false;')), $html->link(__('New Company', true), '/admin/contact_companies/edit', array('title' => 'Add Company', 'onclick' => 'Modalbox.show(this.href, {title: this.title, width: 500}); return false;')))); 
?>

<?php # pr($contactCompany); ?>