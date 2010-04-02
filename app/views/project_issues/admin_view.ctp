<div class="project view">
	<div class="contactname">
		<h2><span id="projectissuename"><?php ajax_add($projectIssue['ProjectIssue']['name']);  ?></span></h2>
	</div>
	<div class="relationships data">
<?php
if ($projectIssue['Project']['id']) : 
?>		<ul class="relationship datalist">
			<li><?php __('ProjectIssue For: '); ?><span id="projectrelationship<?php echo $projectIssue['Project']['id']; ?>"><?php echo $html->link(__($projectIssue['Project']['name'], true), array('controller'=> 'projects', 'action' => 'view', $projectIssue['Project']['id'])); ?></span></li>
		</ul>
<?php
endif;
?>		
	</div>
	
<div id="tabscontent">
  <div id="tabContent1" class="tabContent" style="display:yes;">
	<div class="defaults data">
		<h6><?php __('Default Data') ?></h6>
		<ul class="default datalist">
			<li><strong><?php __('Project Tracker: '); ?></strong><span id="projecttracker"><?php ajax_add($projectIssue['ProjectTrackerType']['name']); ?></span><p class="action"><?php echo $html->link(__('Edit', true), array('controller' => 'project_tracker_types', 'action' => 'index')); ?></p></li>
			<li><strong><?php __('Priority: '); ?></strong><span id="prioritytype"><?php ajax_add($projectIssue['ProjectIssuePriorityType']['name']); ?></span><p class="action"><?php echo $html->link(__('Edit', true), array('controller' => 'project_issue_priority_types', 'action' => 'index')); ?></p></li>		
			<li><strong><?php __('Status: '); ?></strong><span id="statustype"><?php ajax_add($projectIssue['ProjectIssueStatusType']['name']); ?></span><p class="action"><?php echo $html->link(__('Edit', true), array('controller' => 'project_issue_status_types', 'action' => 'index')); ?></p></li>
			<li><strong><?php __('Start Date: '); ?></strong><span id="startdate"><?php ajax_add($projectIssue['ProjectIssue']['start_date']); ?></span></li>
			<li><strong><?php __('Due Date: '); ?></strong><span id="duedate"><?php ajax_add($projectIssue['ProjectIssue']['due_date']); ?></span></li>
			<li><strong><?php __('Estimated Hours: '); ?></strong><span id="estimatedhours"><?php ajax_add($projectIssue['ProjectIssue']['estimated_hours']); ?></span></li>
			<li><strong><?php __('Done Ratio: '); ?></strong><span id="doneratio"><?php ajax_add($projectIssue['ProjectIssue']['done_ratio']); ?></span></li>
		</ul>
	</div>
	<div class="details data">
		<h6><?php __('Details') ?></h6>
		<ul class="detail datalist">
			<li id="detaillist<?php echo $projectIssue['ProjectIssue']['id']; ?>"><div id="detail<?php echo $projectIssue['ProjectIssue']['id']; ?>"><?php ajax_add($projectIssue['ProjectIssue']['description']); ?></div><?php echo $ajax->editor('detail'.$projectIssue['ProjectIssue']['id'], 'ajax_update/'.$projectIssue['ProjectIssue']['id'].'/description/project_issue', array("okControl" => "button", "cancelControl" => "link", "clickToEditText" => "Click to edit","submitOnBlur" => "false", array('inline' => false))); ?>
			</li>
		</ul>
	</div>
	<div class="subissues data">
		<h6><?php __('Discussion') ?></h6>	
		<p class="action"><?php echo $html->link(__('New Thread', true), '', array('onclick' => '$(\'newthread'.$projectIssue['ProjectIssue']['id'].'\').toggle(); return false;')); ?></p>
		
		<div id="newthread<?php echo $projectIssue['ProjectIssue']['id']; ?>" style="display: none;">
			<?php echo $form->create('ProjectIssue');?>
				<fieldset>
				<legend><?php __('Reply');?></legend>
				<?php
					echo $form->input('name'); 
					echo $form->input('description');
					echo $form->hidden('parent_id', array('value' => $projectIssue['ProjectIssue']['id']));
					echo $form->hidden('project_id', array('value' => $projectIssue['Project']['id']));
					echo $form->input('assignee_id', array('label' =>  'Notify / Assign To'));
				?>
				</fieldset>
			<?php echo $form->end('Submit');?>
		</div>	
<?php
if ($projectTree) : 
?>		<ul class="member datalist">
			<?php foreach ($projectTree[0]['children'] as $branch) : ?>
			<li id="branchlist<?php echo $branch['ProjectIssue']['id']; ?>"><strong><?php echo $branch['ProjectIssue']['name']; ?></strong><p class="action"><?php echo $html->link(__('Reply', true), '', array('onclick' => '$(\'reply'.$branch['ProjectIssue']['id'].'\').toggle(); return false;')); ?></p>
				<ul>
					<li><?php echo nl2br($branch['ProjectIssue']['description']); ?>
					<?php if ($branch['children'][0]) : ?>
					<?php foreach ($branch['children'] as $child) : ?> 
						<ul>
							<li><strong><?php echo $child['ProjectIssue']['name']; ?></strong></li>
							<li><?php echo nl2br($child['ProjectIssue']['description']); ?></li>
						</ul>
					<?php endforeach; ?>
					<?php endif; ?>		
					</li>		
					<li id="reply<?php echo $branch['ProjectIssue']['id']; ?>" style="display: none;">
						<?php echo $form->create('ProjectIssue');?>
						<fieldset>
				 		<legend><?php __('Reply');?></legend>
						<?php
							echo $form->input('name'); 
							echo $form->input('description');
							echo $form->hidden('parent_id', array('value' => $branch['ProjectIssue']['id']));
							echo $form->hidden('project_id', array('value' => $projectIssue['Project']['id']));
							echo $form->input('assignee_id', array('label' =>  'Notify / Assign To'));
						?>
						</fieldset>
						<?php echo $form->end('Submit');?>
					</li>
				</ul>
			</li>
			<?php endforeach; ?>
		</ul>
<?php
endif;
?>
	</div>
  </div> 
</div>
<p class="timing"><strong><?php __($projectIssue['ProjectIssue']['name']);?></strong><?php __(' was '); ?><strong><?php __('Created: '); ?></strong><?php echo $time->relativeTime($projectIssue['ProjectIssue']['created']); ?><?php __(', '); ?><strong><?php __('Last Modified: '); ?></strong><?php echo $time->relativeTime($projectIssue['ProjectIssue']['modified']); ?></p>

</div>

		
<?php 
## ajax editable fields 
echo $ajax->editor('projectissuename', 'ajax_update/'.$projectIssue['ProjectIssue']['id'].'/name/project_issue', array("okControl" => "button", "cancelControl" => "link", "clickToEditText" => "Click to edit","submitOnBlur" => "false")); 

echo $ajax->editor('projecttracker', 'ajax_update/'.$projectIssue['ProjectIssue']['id'].'/project_tracker_type_id/project_issue', array("okControl" => "button", "cancelControl" => "link", "clickToEditText" => "Click to edit","submitOnBlur" => "false", "collection" => $ajaxTypeList['ProjectTrackerType'])); 

echo $ajax->editor('prioritytype', 'ajax_update/'.$projectIssue['ProjectIssue']['id'].'/project_issue_priority_type_id/project_issue', array("okControl" => "button", "cancelControl" => "link", "clickToEditText" => "Click to edit","submitOnBlur" => "false", "collection" => $ajaxTypeList['ProjectIssuePriorityType'])); 

echo $ajax->editor('statustype', 'ajax_update/'.$projectIssue['ProjectIssue']['id'].'/project_issue_status_type_id/project_issue', array("okControl" => "button", "cancelControl" => "link", "clickToEditText" => "Click to edit","submitOnBlur" => "false", "collection" => $ajaxTypeList['ProjectIssueStatusType']));

echo $ajax->editor('startdate', 'ajax_update/'.$projectIssue['ProjectIssue']['id'].'/start_date/project_issue', array("okControl" => "button", "cancelControl" => "link", "clickToEditText" => "Click to edit","submitOnBlur" => "false")); 

echo $ajax->editor('duedate', 'ajax_update/'.$projectIssue['ProjectIssue']['id'].'/due_date/project_issue', array("okControl" => "button", "cancelControl" => "link", "clickToEditText" => "Click to edit","submitOnBlur" => "false")); 

echo $ajax->editor('estimatedhours', 'ajax_update/'.$projectIssue['ProjectIssue']['id'].'/estimated_hours/project_issue', array("okControl" => "button", "cancelControl" => "link", "clickToEditText" => "Click to edit","submitOnBlur" => "false")); 

echo $ajax->editor('doneratio', 'ajax_update/'.$projectIssue['ProjectIssue']['id'].'/done_ratio/project_issue', array("okControl" => "button", "cancelControl" => "link", "clickToEditText" => "Click to edit","submitOnBlur" => "false")); 

?> 
<?php 
$menu->setValue(array($html->link(__('Add Issue', true), array('controller' => 'project_issues', 'action' => 'ajax_edit', 'contact_id' => $projectIssue['ProjectIssue']['contact_id'], 'project_id' => $projectIssue['ProjectIssue']['project_id'], 'parent_id' => $projectIssue['ProjectIssue']['id']), array('title' => 'Add Issue', 'onclick' => 'Modalbox.show(this.href, {title: this.title, width: 500}); return false;')),$html->link(__('Add Time', true), array('controller' => 'timesheet_times', 'action' => 'ajax_edit', 'project_id' => $projectIssue['ProjectIssue']['project_id'], 'project_issue_id' => $projectIssue['ProjectIssue']['id']), array('title' => 'Add Time for '.$projectIssue['ProjectIssue']['name'], 'onclick' => 'Modalbox.show(this.href, {title: this.title, width: 500}); return false;')))); 
?>