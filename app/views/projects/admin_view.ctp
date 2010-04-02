<div class="project view">
	<div class="contactname">
		<h2><span id="projectname"><?php ajax_add($project['Project']['name']);  ?></span></h2>
	</div>
	<div class="relationships data">
<?php
if ($project['Contact']['id']) : 
?>		<ul class="relationship datalist">
		<?php 
		if (isset($project['Contact']['ContactPerson']['id'])) : 
			$relator = $project['Contact']['ContactPerson']['first_name'].' '.$project['Contact']['ContactPerson']['last_name']; 
			$relator_id = $project['Contact']['ContactPerson']['id']; 
			$relator_ctrl = 'contact_people';
		elseif (isset($project['Contact']['ContactCompany']['id'])) : 
			$relator = $project['Contact']['ContactCompany']['name']; 
			$relator_id = $project['Contact']['ContactCompany']['id']; 
			$relator_ctrl = 'contact_companies';
		else: 
			$relator = null;
		 endif;
		?>
			<li><?php __('Project For: '); ?><span id="contactrelationship<?php echo $project['Contact']['id']; ?>"><?php echo $html->link(__($relator, true), array('controller'=> $relator_ctrl, 'action' => 'view', $relator_id)); ?></span></li>
		</ul>
<?php
endif;
?>		
	</div>

<div id="tabs">
    <ul>
        <li id="tabHeaderActive"><a href="javascript:void(0)" onclick="toggleTab(1,4)"><span><?php __('Details') ?></span></a></li>
        <li id="tabHeader2"><a href="javascript:void(0)" onclick="toggleTab(2,4)" ><span><?php __('Issues') ?></span></a></li>
        <li id="tabHeader3"><a href="javascript:void(0)" onclick="toggleTab(3,4)"><span><?php __('Wiki') ?></span></a></li>
        <li id="tabHeader4"><a href="javascript:void(0)" onclick="toggleTab(4,4)"><span><?php __('Media') ?></span></a></li></li>
    </ul>
</div>

<div id="tabscontent">
  <div id="tabContent1" class="tabContent" style="display:yes;">
	<div class="defaults data">
		<h6><?php __('Default Data') ?></h6>
		<ul class="default datalist">
			<li><strong><?php __('Status: '); ?></strong><span id="statustype"><?php ajax_add($project['ProjectStatusType']['name']); ?></span><p class="action"><?php echo $html->link(__('Edit', true), array('controller' => 'project_status_types', 'action' => 'index')); ?></p></li>
		</ul>
	</div>

	<div class="details data">
		<h6><?php __('Details') ?></h6>
		<ul class="detail datalist">
			<li id="detaillist<?php echo $project['Project']['id']; ?>"><span id="detail<?php echo $project['Project']['id']; ?>"><?php ajax_add($project['Project']['description']); ?></span><?php echo $ajax->editor('detail'.$project['Project']['id'], 'ajax_update/'.$project['Project']['id'].'/description/project', array("okControl" => "button", "cancelControl" => "link", "clickToEditText" => "Click to edit","submitOnBlur" => "false", array('inline' => false))); ?>
			</li>
		</ul>
	</div>


	<div class="members data">
		<h6><?php __('Members') ?></h6>		
		<p class="action"><?php echo $html->link(__('Add Member', true), array( 'controller' => 'projects_members', 'action' => 'ajax_edit', 'project_id' => $project['Project']['id']), array('title' => 'Add Member to '.$project['Project']['name'], 'onclick' => 'Modalbox.show(this.href, {title: this.title, width: 500}); return false;')); ?></p>
<?php
if ($project['Member']) : 
?>		<ul class="member datalist">
			<?php foreach ($project['Member'] as $member) : ?>
			<li id="memberlist<?php echo $member['ProjectsMember']['id']; ?>"><?php echo $member['username']; ?><p class="action"><?php echo $ajax->link('X', array('controller' => 'projects_members', 'action' => 'ajax_delete', $member['ProjectsMember']['id']), array('indicator' => 'loadingimg', 'update' => 'memberlist'.$member['ProjectsMember']['id'], 'complete' => 'Effect.Fade(\'deleteMessage\', { duration: 2.0 });'), 'Are you sure you want to delete "'.$member['username'].'"'); ?></p>
			</li>
			<?php endforeach; ?>
		</ul>
<?php
endif;
?>
	</div>
	

	<div class="watchers data">
		<h6><?php __('Watchers') ?></h6>		
		<p class="action"><?php echo $html->link(__('Add Watcher', true), array( 'controller' => 'projects_watchers', 'action' => 'ajax_edit', 'project_id' => $project['Project']['id']), array('title' => 'Add Watcher to '.$project['Project']['name'], 'onclick' => 'Modalbox.show(this.href, {title: this.title, width: 500}); return false;')); ?></p>
<?php
if ($project['Watcher']) : 
?>		<ul class="watcher datalist">
			<?php foreach ($project['Watcher'] as $watcher) : ?>
		<?php 
		if (isset($watcher['ContactPerson']['id'])) : 
			$relator = $watcher['ContactPerson']['first_name'].' '.$watcher['ContactPerson']['last_name']; 
			$relator_id = $watcher['ContactPerson']['id']; 
			$relator_ctrl = 'contact_people';
		elseif (isset($watcher['ContactCompany']['id'])) : 
			$relator = $watcher['ContactCompany']['name']; 
			$relator_id = $watcher['ContactCompany']['id']; 
			$relator_ctrl = 'contact_companies';
		else: 
			$relator = null;
		 endif;
		?>
			<li id="watcherlist<?php echo $watcher['ProjectsWatcher']['id']; ?>"><span id="watcher<?php echo $project['Contact']['id']; ?>"><?php echo $html->link(__($relator, true), array('controller'=> $relator_ctrl, 'action' => 'view', $relator_id)); ?></span><p class="action"><?php echo $ajax->link('X', array('controller' => 'projects_watchers', 'action' => 'ajax_delete', $watcher['ProjectsWatcher']['id']), array('indicator' => 'loadingimg', 'update' => 'watcherlist'.$watcher['ProjectsWatcher']['id'], 'complete' => 'Effect.Fade(\'deleteMessage\', { duration: 2.0 });'), 'Are you sure you want to delete "'.$relator.'"'); ?></p>
			</li>
			<?php endforeach; ?>
		</ul>
<?php
endif;
?>
	</div>
  </div> 
  <div id="tabContent2" class="tabContent" style="display:none;">
	<div class="issues data">
		<h6><?php __('Issues') ?></h6>
		<p class="action"><?php echo $html->link(__('Add Issue', true), array('controller' => 'project_issues', 'action' => 'ajax_edit', 'project_id' => $project['Project']['id'], 'contact_id' => $project['Contact']['id']), array('title' => 'Add Issue for '.$project['Project']['name'], 'onclick' => 'Modalbox.show(this.href, {title: this.title, width: 500}); return false;')); ?></p>
<?php
if ($project['ProjectIssue']) : 
?>
			<?php foreach ($project['ProjectIssue'] as $issue) : ?>
				<ul class="activity datalist" id="issuelist<?php echo $issue['id']; ?>">
					<li><strong><?php __('Subject: '); echo $html->link(__($issue['name'], true), array('controller'=> 'project_issues', 'action' => 'view', $issue['id'])); ?></strong><p class="action"><?php echo $ajax->link('X', array('controller' => 'project_issues', 'action' => 'ajax_delete', $issue['id']), array('update' => 'issuelist'.$issue['id'], 'complete' => 'Effect.Fade(\'deleteMessage\', { duration: 2.0 });'), 'Are you sure you want to delete "'.$issue['name'].'"'); ?></p>
						<ul>
							<li><span class="description"><?php __($issue['description']); ?></span></li>
							<li><strong><?php __('Created: '); ?></strong><span class="created"><?php __($issue['created']); ?></span></li>
							<li><strong><?php __('Modified: '); ?></strong><span class="modified"><?php __($issue['modified']); ?></span></li>
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
	<div class="wikis data">
		<h6><?php __('Wikis') ?></h6>		
<?php
if ($project['Wiki'][0]) : 
?>		
		<?php foreach ($project['Wiki'] as $wiki) : ?>
		<ul class="wiki datalist">
			<li>
			<p class="action"><?php echo $html->link(__('Edit', true), array('controller'=> 'wiki_contents', 'action' => 'edit', $wiki['id'], $wiki['WikiStartPage']['title'])); ?></p>
			<?php echo $wikiparser->render($wiki['WikiStartPage']['WikiContent']['text'], $wiki['id']); ?>
			</li>
		</ul>
		<?php endforeach; ?>
<?php
endif;
?>		<p class="action"><?php echo $html->link(__('Create', true), array('controller'=> 'wiki_contents', 'action' => 'edit', 'project_id' => $project['Project']['id'])); ?></p>
	</div>
  </div>
  <div id="tabContent4" class="tabContent" style="display:none;">
	<div class="media data">
		<h6><?php __('Media') ?></h6>		
<?php
if ($project['Contact']['Order']) : 
?>
		<ul class="order datalist">
			<?php foreach ($project['Contact']['Order'] as $order) : ?>
			<li><?php echo $html->link(__($time->nice($order['created']), true), array('controller'=> 'Orders', 'action' => 'view', $order['id'])); ?></li>
			<?php endforeach; ?>
		</ul>
<?php
endif;
?>		<p class="action"><?php echo $html->link(__('Add Media', true), array('controller'=> 'Orders', 'action' => 'add')); ?></p>
	</div>
  </div>
</div>




<p class="timing"><strong><?php __($project['Project']['name']);?></strong><?php __(' was '); ?><strong><?php __('Created: '); ?></strong><?php echo $time->relativeTime($project['Project']['created']); ?><?php __(', '); ?><strong><?php __('Last Modified: '); ?></strong><?php echo $time->relativeTime($project['Project']['modified']); ?></p>

</div>

		
<?php 
## ajax editable fields 
echo $ajax->editor('projectname', 'ajax_update/'.$project['Project']['id'].'/name/project', array("okControl" => "button", "cancelControl" => "link", "clickToEditText" => "Click to edit first name","submitOnBlur" => "false")); 

echo $ajax->editor('statustype', 'ajax_update/'.$project['Project']['id'].'/project_status_type_id/project', array("okControl" => "button", "cancelControl" => "link", "clickToEditText" => "Click to edit contact type","submitOnBlur" => "false", "collection" => $ajaxTypeList['ProjectStatusType'])); 

$menu->setValue(array($html->link(__('Add Project', true), array('controller' => 'projects', 'action' => 'edit'), array('title' => 'Add Project', 'onclick' => 'Modalbox.show(this.href, {title: this.title, width: 500}); return false;')),$html->link(__('Add Issue', true), array('controller' => 'project_issues', 'action' => 'ajax_edit', 'project_id' => $project['Project']['id'], 'contact_id' => $project['Contact']['id']), array('title' => 'Add Issue for '.$project['Project']['name'], 'onclick' => 'Modalbox.show(this.href, {title: this.title, width: 500}); return false;')),$html->link(__('Add Time', true), array('controller' => 'timesheet_times', 'action' => 'ajax_edit', 'project_id' => $project['Project']['id']), array('title' => 'Add Time for '.$project['Project']['name'], 'onclick' => 'Modalbox.show(this.href, {title: this.title, width: 500}); return false;')))); 
?>
<?php # pr($project); ?>