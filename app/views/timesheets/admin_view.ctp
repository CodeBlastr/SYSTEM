<div class="timesheet view">
	<div class="contactname">
		<h2><span id="timesheetname"><?php ajax_add($timesheet['Timesheet']['name']);  ?></span></h2>
	</div>

<div id="tabscontent">
  <div id="tabContent1" class="tabContent" style="display:yes;">
  	<div class="timesheets data">
		<h6><?php __('Timesheets') ?></h6>	
		<p class="action"><?php echo $html->link(__('Add Time', true), array('controller' => 'timesheet_time_relationships', 'action' => 'ajax_edit', 'timesheet_id' => $timesheet['Timesheet']['id']), array('title' => 'Add Time for '.$timesheet['Timesheet']['name'], 'onclick' => 'Modalbox.show(this.href, {title: this.title, width: 500}); return false;')); ?></p>	
<?php
if ($timesheet['TimesheetTime'][0]) : 
?>		
		<table cellpadding="0" cellspacing="0">
			<tr>
				<th><?php __('Project'); ?></th>
				<th><?php __('Issue'); ?></th>
				<th><?php __('Comments');?></th>
				<th><?php __('Date'); ?></th>
				<th><?php __('Hour(s)');?></th>
				<th><?php __('Action');?></th>
			</tr>
			<?php $i = 0; ?>
			<?php foreach ($timesheet['TimesheetTime'] as $timeItem) : ?>
				<?php $class = null; if ($i++ % 2 == 0) : $class = ' class="altrow"'; endif; ?>
				<tr<?php echo $class;?> id="row<?php __($timeItem['id']); ?>">
					<td>
						<span id="project<?php echo $timeItem['id']; ?>"><?php __($timeItem['Project']['name']); ?></span>
					</td>
					<td>
						<span id="projectissue<?php echo $timeItem['id']; ?>"><?php __($timeItem['ProjectIssue']['name']); ?></span>
					</td>
					<td>
						<span id="comments<?php echo $timeItem['id']; ?>"><?php __($timeItem['comments']); ?></span>
					</td>
					<td>
						<span id="started<?php echo $timeItem['id']; ?>"><?php __($timeItem['started_on']); ?></span>
					</td>
					<td>
						<span id="hour<?php echo $timeItem['id']; ?>"><?php __($timeItem['hours']); ?></span>
					</td>
					<td>
						<?php echo $ajax->link('Delete', array(
															   'controller' => 'timesheets_timesheet_times',
															   'action' => 'ajax_delete',
															   $timeItem['TimesheetsTimesheetTime']['id']
															   ),
											   array(
													 'indicator' => 'loadingimg',
													 'update' => 'row'.$timeItem['id'],
													 'complete' => 'Effect.Fade(\'deleteMessage\', { duration: 2.0 });'
													 ),
											   'Permanently Delete... Are You Sure?'
											   );
						?>
					</td>
				</tr>			
				<?php endforeach; ?>
			</table>
<?php
endif;
?>		
	</div>	
  </div> 
</div>




<p class="timing"><strong><?php __($timesheet['Timesheet']['name']);?></strong><?php __(' was '); ?><strong><?php __('Created: '); ?></strong><?php echo $time->relativeTime($timesheet['Timesheet']['created']); ?><?php __(', '); ?><strong><?php __('Last Modified: '); ?></strong><?php echo $time->relativeTime($timesheet['Timesheet']['modified']); ?></p>

</div>

		
<?php 
## ajax editable fields 
echo $ajax->editor('timesheetname', 'ajax_update/'.$timesheet['Timesheet']['id'].'/name/timesheet', array("okControl" => "button", "cancelControl" => "link", "clickToEditText" => "Click to edit first name","submitOnBlur" => "false")); 
?>

<?php 
$menu->setValue(array($html->link(__('Add Timesheet', true), array('controller' => 'timesheets', 'action' => 'edit')))); 
?>

<!--pre><?php # print_r($timesheet); ?></pre-->