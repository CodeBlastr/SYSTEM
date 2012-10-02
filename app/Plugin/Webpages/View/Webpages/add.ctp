<div class="webpages form">
	<?php echo $this->Form->create('Webpage');?>
	<h2><?php echo __('Webpage Builder');?><?php if($parentId) { echo ' <small>Creating child of Page #'.$parentId.'</small>'; }?></h2>
	<fieldset>
	<legend class="toggleClick"><?php echo __('Search Engine Optimization');?></legend>
    <?php 
		echo $this->Form->input('Alias.name', array('label' => 'SEO Url (unique)'));
		echo $this->Form->input('Alias.plugin', array('type' => 'hidden', 'value' => 'webpages'));
		echo $this->Form->input('Alias.controller', array('type' => 'hidden', 'value' => 'webpages'));
		echo $this->Form->input('Alias.action', array('type' => 'hidden', 'value' => 'view'));
		if($parentId) echo $this->Form->input('Webpage.parent_id', array('type' => 'hidden', 'value' => $parentId));
		echo $this->Form->input('Webpage.title', array('label' => 'SEO Title'));
		echo $this->Form->input('Webpage.keywords', array('label' => 'SEO Keywords'));
		echo $this->Form->input('Webpage.description', array('label' => 'SEO Description'));
	?>
    </fieldset>
    
    
	<fieldset>
	<legend class="toggleClick"><?php echo __('Access Rights');?></legend>
    <?php 
		echo $this->Form->input('RecordLevelAccess.UserRole', array('label' => 'User Roles', 'type' => 'select', 'multiple' => true, 'options' => $userRoles, 'between' => '<br>Site settings used by default, if you use this, only these groups will have access.'));
	?>
    </fieldset>
    
	<fieldset>
	<legend><?php echo __('Add Webpage');?></legend>
	<?php
		echo $this->Form->input('type', array('default' => 'page_content'));
	?>
    	<fieldset>
        <legend><?php echo __('Template Settings'); ?></legend>
    <?php
		echo $this->Form->input('is_default', array('type' => 'checkbox'));
		echo $this->Form->input('template_urls', array('after' => ' <br>One url per line. (ex. /tickets/tickets/view/*)'));
		echo $this->Form->input('user_roles', array('type' => 'select', 'options' => $userRoles, 'multiple' => 'checkbox'));
	?>
    	</fieldset>
    <?php
		echo $this->Form->input('name');
		echo $this->Form->input('Webpage.content', array('type' => 'richtext'));
	?>
	</fieldset>
	<?php echo $this->Form->end('Save Webpage');?>
</div>
<?php
$this->set('context_menu', array('menus' => array(
	array(
		'heading' => 'Webpages',
		'items' => array(
			 $this->Html->link(__('List', true), array('action' => 'index')),									 
			 )
		)
	)));
?>
<script type="text/javascript">
$(function() {
	var webpageType = $("#WebpageType").val();
	$("#WebpageIsDefault").parent().parent().hide();
	if (webpageType == 'template' || webpageType == 'element') {
		$("#RecordLevelAccessUserRole").parent().parent().hide();
 		$("#AliasName").parent().parent().hide();
	}
	if (webpageType == 'template') {
		$("#WebpageIsDefault").parent().parent().show();
	}
	$("#WebpageType").change(function() {
		var webpageType = $("#WebpageType").val();
		if (webpageType == 'template' || webpageType == 'element') {
			  $("#RecordLevelAccessUserRole").parent().parent().hide();
			  $("#AliasName").parent().parent().hide();
		} else {
			  $("#WebpageIsDefault").parent().parent().hide();
			  $("#RecordLevelAccessUserRole").parent().parent().show();
			  $("#AliasName").parent().parent().show();
			<?php if($parentId) { ?>
			$("#WebpageTemplateUrls").parent().parent().children().hide();
			$("#WebpageTemplateUrls").parent().show();
			$("#WebpageTemplateUrls").parent().parent().show();
			<?php } ?>
		}	
		if (webpageType == 'template') {
			$("#WebpageIsDefault").parent().parent().show();
		}
		if (webpageType == 'element') {
			$("#WebpageIsDefault").parent().parent().hide();
		}
	});
	
	
	if ($("#WebpageIsDefault").is(":checked")) {
		$("#WebpageTemplateUrls").parent().hide();
	}
	
	$("#WebpageIsDefault").change(function() {
		if ($(this).is(":checked")) {
			$("#WebpageTemplateUrls").parent().hide();
		} else {
			$("#WebpageTemplateUrls").parent().show();
		}
	});
	
	<?php if($parentId) { ?>
	$("#WebpageTemplateUrls").parent().parent().children().hide();
	$("#WebpageTemplateUrls").parent().show();
	$("#WebpageTemplateUrls").parent().parent().show();
	<?php } ?>
});
</script>   