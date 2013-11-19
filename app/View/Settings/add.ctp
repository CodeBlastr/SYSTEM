<div class="settings form row">
	<div class="col-sm-7">
		<?php echo $this->Form->create('Setting'); ?>
		<fieldset>
	 		<legend><?php echo __('Add Setting'); ?></legend>
			<?php echo $this->Form->input('Setting.id'); ?>
			<?php echo $this->Form->input('Setting.type', array('empty' => true, 'label' => 'Type', 'ajax' => array('element' => 'select', 'json' => 'settings/names', 'variable' => 'settings', 'rel' => 'SettingName'))); ?>
			<?php echo $this->Form->input('Setting.name', array('type' => 'select', 'empty' => 'Select Type First')); ?>
			<?php echo $this->Form->input('Setting.value'); ?>
		</fieldset>
		<?php echo $this->Form->end('Submit'); ?>
	</div>
	<div class="col-sm-5">
		<h4>Description</h4>
		<p class="well well-lg"><?php echo $this->Form->value('Setting.description'); ?></p>
	</div>
</div>



<?php 
// javascript for dynamic form input
echo $this->Html->scriptBlock('
	function selectCallBack(data) {
		var name = $("#SettingName").val();
		items = [];
		$.each(data["settings"], function(key, val) {
			if (val["name"] == name) {
			    items += val["description"];
			}
		});
		console.log(items);
		$(".col-sm-5 p.well").html(items.replace(/\n/g,"<br>"));
	}
	
	$(function() {
		$("#SettingName").change(function(){
			var url = "/" + $("#SettingType").attr("json") + "/" + $("#SettingType").val() + ".json";
			var target = $("#SettingType").attr("rel");
			$.getJSON(url, function(data){
				selectCallBack(data);
		    });
		});
	});');
	
// set the contextual breadcrumb items
$this->set('context_crumbs', array('crumbs' => array(
	$this->Html->link(__('Admin Dashboard'), '/admin'),
	$page_title_for_layout,
)));

// set the contextual menu items
$this->set('context_menu', array('menus' => array(
	array(
		'heading' => 'Settings',
		'items' => array(
			$this->Html->link(__('List Settings'), array('action' => 'index'))
			)
		),
	)));
