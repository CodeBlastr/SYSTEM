<div class="webpages form">
<?php echo $form->create('Webpage');?>
  <fieldset>
    <legend class="toggleClick">
    <?php __('Search Engine Optimization');?>
    </legend>
    <?php 
		echo $form->input('Webpage.id');
		echo $form->input('Alias.id');
		echo $form->input('Alias.value', array('type' => 'hidden', 'value' => $form->value('Webpage.id')));
		echo $form->input('Alias.name', array('label' => 'SEO Url (unique)'));
		echo $form->input('Alias.plugin', array('type' => 'hidden', 'value' => 'webpages'));
		echo $form->input('Alias.controller', array('type' => 'hidden', 'value' => 'webpages'));
		echo $form->input('Alias.action', array('type' => 'hidden', 'value' => 'view'));
		echo $form->input('Webpage.title', array('label' => 'SEO Title'));
		echo $form->input('Webpage.keywords', array('label' => 'SEO Keywords'));
		echo $form->input('Webpage.description', array('label' => 'SEO Description'));
	?>
  </fieldset>
  <fieldset>
    <legend class="toggleClick">
    <?php __('Access Rights');?>
    </legend>
    <?php 
		echo $form->input('RecordLevelAccess.UserRole', array('label' => '', 'type' => 'select', 'multiple' => true, 'options' => $userRoles, 'between' => 'Customize page access. (Note : Uses global settings by default)'));
	?>
  </fieldset>
  <fieldset>
    <legend>
    <?php __('Add Webpage');?>
    </legend>
    <?php
		echo $form->input('type', array('default' => 'page_content'));
	?>
    <fieldset>
      <legend>
      <?php __('Template Settings'); ?>
      </legend>
      <?php
		echo $form->input('is_default', array('type' => 'checkbox'));
		echo $form->input('template_urls', array('type' => 'textarea', 'value' => $templateUrls, 'after' => ' <br>One url per line. (ex. /tickets/tickets/view/*)'));
		echo $form->input('user_roles', array('type' => 'select', 'options' => $userRoles, 'multiple' => 'checkbox'));
	?>
    </fieldset>
    <?php
		echo $form->input('Webpage.name');
		echo $form->input('Webpage.content', array('type' => 'richtext', 'ckeSettings' => $ckeSettings));
	?>
  </fieldset>
  <?php echo $form->end('Save Webpage');?> </div>
<?php
$menu->setValue(
	array(
		  array('heading' => 'Webpages',
			'items' => array(
				$this->Html->link(__('Webpage List', true), array('controller' => 'webpages', 'action' => 'index')),
				$this->Html->link(__('Add Webpage', true), array('controller' => 'webpages', 'action' => 'add'), array('title' => 'Add Webpage')),
				$this->Html->link(__('View Webpage', true), array('controller' => 'webpages', 'action' => 'view', $this->data['Webpage']['id'])),
				$this->Html->link(__('Delete', true), array('action' => 'delete', $form->value('Webpage.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $form->value('Webpage.id'))),
					 )
				)
		  )
	);
		echo $this->Html->script('ckeditor/adapters/jquery');
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