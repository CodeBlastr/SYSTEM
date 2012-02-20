<div class="webpages form"> 
<?php echo $this->Form->create('Webpage');?>
  <fieldset>
    <legend class="toggleClick"> <?php echo __('Search Engine Optimization');?> </legend>
    <?php 
		echo $this->Form->input('Webpage.id');
		echo $this->Form->input('Alias.id');
		echo $this->Form->input('Alias.value', array('type' => 'hidden', 'value' => $this->Form->value('Webpage.id')));
		echo $this->Form->input('Alias.name', array('label' => false, 'placeholder' => 'Unique Permanent SEO Url Address'));
		echo $this->Form->input('Alias.plugin', array('type' => 'hidden', 'value' => 'webpages'));
		echo $this->Form->input('Alias.controller', array('type' => 'hidden', 'value' => 'webpages'));
		echo $this->Form->input('Alias.action', array('type' => 'hidden', 'value' => 'view'));
		echo $this->Form->input('Webpage.title', array('label' => false, 'placeholder' => 'SEO Title'));
		echo $this->Form->input('Webpage.keywords', array('label' => false, 'placeholder' => 'SEO Keywords'));
		echo $this->Form->input('Webpage.description', array('label' => false, 'placeholder' => 'SEO Description'));
	?>
  </fieldset>
  <fieldset>
    <legend class="toggleClick"> <?php echo __('Access Rights');?> </legend>
    <?php 
		echo $this->Form->input('RecordLevelAccess.UserRole', array('label' => '', 'type' => 'select', 'multiple' => true, 'options' => $userRoles, 'between' => 'Customize page access. (Note : Uses global settings by default)'));
	?>
  </fieldset>
  <fieldset>
    <legend> <?php echo __('Add Webpage');?> </legend>
    <?php
		echo $this->Form->input('type', array('default' => 'page_content'));
	?>
    <fieldset>
      <legend> <?php echo __('Template Settings'); ?> </legend>
      <?php
		echo $this->Form->input('is_default', array('type' => 'checkbox'));
		echo $this->Form->input('template_urls', array('type' => 'textarea', 'value' => $templateUrls, 'after' => ' <br>One url per line. (ex. /tickets/tickets/view/*)'));
		echo $this->Form->input('user_roles', array('type' => 'select', 'options' => $userRoles, 'multiple' => 'checkbox'));
	?>
    </fieldset>
    <?php
		echo $this->Form->input('Webpage.name');
		echo $this->Form->input('Webpage.content', array('type' => 'richtext', 'ckeSettings' => $ckeSettings));
	?>
  </fieldset>
<?php echo $this->Form->end('Save Webpage');?>
</div>

<?php
$this->set('context_menu', array('menus' => array(
	  array('heading' => 'Webpages',
		'items' => array(
			$this->Html->link(__('List'), array('controller' => 'webpages', 'action' => 'index')),
			$this->Html->link(__('Add'), array('controller' => 'webpages', 'action' => 'add'), array('title' => 'Add Webpage')),
			$this->Html->link(__('View'), array('controller' => 'webpages', 'action' => 'view', $this->request->data['Webpage']['id'])),
			$this->Html->link(__('Delete'), array('action' => 'delete', $this->Form->value('Webpage.id')), null, sprintf(__('Are you sure you want to delete # %s?'), $this->Form->value('Webpage.id'))),
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
});
</script>
