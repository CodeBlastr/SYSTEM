<div class="invoice view">
	<div class="contactname">
		<h2><span id="invoicename"><?php ajax_add($invoice['Invoice']['name']);  ?></span></h2>
	</div>
	<div class="relationships data">
<?php
if ($invoice['Contact']['id']) : 
?>		<ul class="relationship datalist">
		<?php 
		if (isset($invoice['Contact']['ContactPerson']['id'])) : 
			$relator = $invoice['Contact']['ContactPerson']['first_name'].' '.$invoice['Contact']['ContactPerson']['last_name']; 
			$relator_id = $invoice['Contact']['ContactPerson']['id']; 
			$relator_ctrl = 'contact_people';
		elseif (isset($invoice['Contact']['ContactCompany']['id'])) : 
			$relator = $invoice['Contact']['ContactCompany']['name']; 
			$relator_id = $invoice['Contact']['ContactCompany']['id']; 
			$relator_ctrl = 'contact_companies';
		else: 
			$relator = null;
		 endif;
		?>
			<li><?php __('Invoice For: '); ?><span id="contactrelationship<?php echo $invoice['Contact']['id']; ?>"><?php echo $html->link(__($relator, true), array('controller'=> $relator_ctrl, 'action' => 'view', $relator_id)); ?></span></li>
		</ul>
<?php
endif;
?>		
	</div>

<div id="tabscontent">
  <div id="tabContent1" class="tabContent" style="display:yes;">
	<div class="intros data">
		<h6><?php __('Introduction') ?></h6>
		<ul class="intro datalist">
			<li><span id="introduction"><?php ajax_add($invoice['Invoice']['introduction']); ?></span></li>		
		</ul>
	</div>
	
	
	<div class="timeitems data">
		<h6><?php __('Time Items') ?></h6>
		<p class="action"><?php echo $html->link(__('Add Time Item', true), array('controller' => 'invoice_timesheet_times', 'action' => 'ajax_edit', 'invoice_id' => $invoice['Invoice']['id']), array('title' => 'Add Time Item for '.$invoice['Invoice']['name'], 'onclick' => 'Modalbox.show(this.href, {title: this.title, width: 500}); return false;')); ?></p>
<?php
if ($invoice['InvoiceTimesheetTime']) : 
?>
		<table cellpadding="0" cellspacing="0">
		<tr>
			<th><?php __('Project'); ?></th>
			<th><?php __('Issue'); ?></th>
			<th><?php __('Comments'); ?></th>
			<th><?php __('Hours');?></th>
			<th><?php __('Cost');?></th>
			<th><?php __('Wholesale');?></th>
			<th><?php __('Retail');?></th>
			<th><?php __('Action');?></th>
		</tr>
			<?php $i = 0; ?>
			<?php foreach ($invoice['InvoiceTimesheetTime'] as $timeItem) : ?>
			<?php $class = null; if ($i++ % 2 == 0) : $class = ' class="altrow"'; endif; ?>
				<tr<?php echo $class;?> id="row<?php __($timeItem['id']); ?>">
					<td>
						<span id="project<?php echo $timeItem['id']; ?>"><?php __($timeItem['TimesheetTime']['ProjectIssue']['Project']['name']); ?></span>
					</td>
					<td>
						<span id="issue<?php echo $timeItem['id']; ?>"><?php __($timeItem['TimesheetTime']['ProjectIssue']['name']); ?></span>
					</td>
					<td>
						<span id="comment<?php echo $timeItem['id']; ?>"><?php __($timeItem['TimesheetTime']['comments']); ?></span>
					</td>
					<td>
						<span id="hour<?php echo $timeItem['id']; ?>"><?php __($timeItem['TimesheetTime']['hours']); ?></span>
					</td>
					<td>
						<span id="cost<?php echo $timeItem['id']; ?>"><?php __($timeItem['TimesheetTime']['TimesheetRate']['cost']); ?></span>
					</td>
					<td>
						<span id="wholesale<?php echo $timeItem['id']; ?>"><?php __($timeItem['TimesheetTime']['TimesheetRate']['wholesale']); ?></span>
					</td>
					<td>
						<span id="retail<?php echo $timeItem['id']; ?>"><?php __($timeItem['TimesheetTime']['TimesheetRate']['retail']); ?></span>
					</td>
					<td>
						<?php echo $ajax->link('Delete', array('controller' => 'invoice_timesheet_times', 'action' => 'ajax_delete', $timeItem['id']), array('indicator' => 'loadingimg', 'update' => 'row'.$timeItem['id'], 'complete' => 'Effect.Fade(\'deleteMessage\', { duration: 2.0 });'), 'Permanently Delete... Are You Sure?'); ?>
					</td>
			<?php endforeach; ?>
		</tr>			
		</table>
<?php
endif;
?>	
	</div>
	<div class="catalogitems data">
		<h6><?php __('Catalog Items') ?></h6>
		<p class="action"><?php echo $html->link(__('Add Catalog Item', true), array('controller' => 'invoice_catalog_items', 'action' => 'ajax_edit', 'invoice_id' => $invoice['Invoice']['id']), array('title' => 'Add Catalog Item for '.$invoice['Invoice']['name'], 'onclick' => 'Modalbox.show(this.href, {title: this.title, width: 500}); return false;')); ?></p>
<?php
if ($invoice['InvoiceCatalogItem']) : 
?>
		<table cellpadding="0" cellspacing="0">
		<tr>
			<th><?php __('Name'); ?></th>
			<th><?php __('Quantity');?></th>
			<th><?php __('Cost');?></th>
			<th><?php __('Wholesale');?></th>
			<th><?php __('Retail');?></th>
			<th><?php __('Action');?></th>
		</tr>
			<?php $i = 0; ?>
			<?php foreach ($invoice['InvoiceCatalogItem'] as $catalogItem) : ?>
			<?php $class = null; if ($i++ % 2 == 0) : $class = ' class="altrow"'; endif; ?>
				<tr<?php echo $class;?> id="catalogrow<?php __($catalogItem['id']); ?>">
					<td>
						<span id="catalogitem<?php echo $catalogItem['id']; ?>"><?php __($catalogItem['CatalogItem']['name']); ?></span>
					</td>
					<td>
						<span id="quantity<?php echo $catalogItem['id']; ?>"><?php __($catalogItem['quantity']); ?></span>
					</td>
					<td>
						<span id="cost<?php echo $catalogItem['id']; ?>"><?php __($catalogItem['CatalogItem']['cost']); ?></span>
					</td>
					<td>
						<span id="wholesale<?php echo $catalogItem['id']; ?>"><?php __($catalogItem['CatalogItem']['wholesale']); ?></span>
					</td>
					<td>
						<span id="retail<?php echo $catalogItem['id']; ?>"><?php __($catalogItem['CatalogItem']['retail']); ?></span>
					</td>
					<td>
						<?php echo $ajax->link('Delete', array('controller' => 'invoice_catalog_items', 'action' => 'ajax_delete', $catalogItem['id']), array('indicator' => 'loadingimg', 'update' => 'catalogrow'.$catalogItem['id'], 'complete' => 'Effect.Fade(\'deleteMessage\', { duration: 2.0 });'), 'Permanently Delete... Are You Sure?'); ?>
					</td>
			<?php endforeach; ?>
		</tr>			
		</table>
<?php
endif;
?>	
	</div>
	<div class="conclusions data">
		<h6><?php __('Conclusion') ?></h6>
		<ul class="conclusion datalist">
			<li><span id="conclusion"><?php ajax_add($invoice['Invoice']['conclusion']); ?></span></li>	
			<li><strong><?php __('Also Send To: ') ?></strong><span id="sendto"><?php ajax_add($invoice['Invoice']['sendto']); ?></span></li>
			<li><strong><?php __('Due Date: ') ?></strong><span id="duedate"><?php ajax_add($invoice['Invoice']['due_date']); ?></span></li>	
		</ul>
	</div>
  </div>
</div>




<p class="timing"><strong><?php __($invoice['Invoice']['name']);?></strong><?php __(' was '); ?><strong><?php __('Created: '); ?></strong><?php echo $time->relativeTime($invoice['Invoice']['created']); ?><?php __(', '); ?><strong><?php __('Last Modified: '); ?></strong><?php echo $time->relativeTime($invoice['Invoice']['modified']); ?></p>

</div>


		
<?php 
## ajax editable fields 
echo $ajax->editor('introduction', 'ajax_update/'.$invoice['Invoice']['id'].'/introduction/invoice', array("okControl" => "button", "cancelControl" => "link", "clickToEditText" => "Click to edit","submitOnBlur" => "false")); 
echo $ajax->editor('conclusion', 'ajax_update/'.$invoice['Invoice']['id'].'/conclusion/invoice', array("okControl" => "button", "cancelControl" => "link", "clickToEditText" => "Click to edit","submitOnBlur" => "false")); 
echo $ajax->editor('sendto', 'ajax_update/'.$invoice['Invoice']['id'].'/sendto/invoice', array("okControl" => "button", "cancelControl" => "link", "clickToEditText" => "Click to edit","submitOnBlur" => "false")); 
echo $ajax->editor('duedate', 'ajax_update/'.$invoice['Invoice']['id'].'/due_date/invoice', array("okControl" => "button", "cancelControl" => "link", "clickToEditText" => "Click to edit","submitOnBlur" => "false")); 
?>
<?php 
$menu->setValue(array($html->link(__('Add Invoice', true), array('controller' => 'invoices', 'action' => 'edit'), array('title' => 'Add Invoice', 'onclick' => 'Modalbox.show(this.href, {title: this.title, width: 500}); return false;')))); 
?>

<!--pre><?php #print_r($invoice); ?></pre-->