<div class="webpages form">
<?php echo $this->Form->create('Webpage'); ?>
    <h2><?php echo __('Webpage Editor');?></h2>
  <fieldset>
    <legend class="toggleClick"> <?php echo __('Search Engine Optimization');?> </legend>
    <?php
		echo $this->Form->input('Webpage.id');
		echo $this->Form->input('Alias.id');
		echo $this->Form->hidden('Alias.value', array('value' => $this->Form->value('Webpage.id')));
		echo $this->Form->hidden('Alias.plugin', array('value' => 'webpages'));
		echo $this->Form->hidden('Alias.controller', array('value' => 'webpages'));
		echo $this->Form->hidden('Alias.action', array('value' => 'view'));
		echo $this->Form->input('Alias.name', array('label' => false, 'placeholder' => 'Unique Permanent SEO Url Address'));
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
    <legend> <?php echo __('Edit Webpage');?> </legend>
    <?php
		echo $this->Form->input('type', array('default' => 'page_content')); ?>
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
	echo $this->Form->input('Webpage.content', array('type' => 'richtext', 'ckeSettings' => $ckeSettings));	?>
  </fieldset>
<?php
if (in_array('Drafts', CakePlugin::loaded())) {
	echo $this->Form->input('Webpage.draft', array('type' => 'checkbox', 'value' => 0, 'checked' => 'checked'));
}
echo $this->Form->end('Publish Update'); ?>
</div>

<?php
$menuItems = array(
			$this->Html->link(__('List'), array('controller' => 'webpages', 'action' => 'index')),
			$this->Html->link(__('Add'), array('controller' => 'webpages', 'action' => 'add'), array('title' => 'Add Webpage')),
			$this->Html->link(__('View'), array('controller' => 'webpages', 'action' => 'view', $this->request->data['Webpage']['id'])),
			$this->Html->link(__('Delete'), array('action' => 'delete', $this->Form->value('Webpage.id')), null, sprintf(__('Are you sure you want to delete # %s?'), $this->Form->value('Webpage.id'))),
				 );

if($this->data['Webpage']['type'] == 'page_content')
    $menuItems[] = $this->Html->link(__('Add Child'), array('controller' => 'webpages', 'action' => 'add', $this->request->data['Webpage']['id']), array('title' => 'Add Child'));

$this->set('context_menu', array('menus' => array(
	  array('heading' => 'Webpages',
		'items' => $menuItems
			)
	  ))); ?>
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


<?php if (in_array('Drafts', CakePlugin::loaded())) {  ?>
	updateSubmitButton();
	var tid = setInterval(timedDraftSubmit, 30000);

	$("#WebpageDraft").change(function() {
		updateSubmitButton();
	});

	$("#WebpageEditForm").submit(function() {
		if ($("#WebpageDraft").is(":checked")) {
			ajaxDraftSubmit(true)
			return false;
		} else {
			return true;
		}
	});
<?php } ?>

});


function updateSubmitButton() {
	if ($("#WebpageDraft").is(":checked")) {
		$(".submit input").attr("value", "Save Draft & Preview");
	} else {
		$(".submit input").attr("value", "Publish Update");
	}
}

function timedDraftSubmit() {
	if ($("#WebpageDraft").is(":checked")) {
		ajaxDraftSubmit(false)
	}
}


function ajaxDraftSubmit(openwindow) {
	$(".ajaxLoader").show("slow");
	$.ajax({
		type: "POST",
		data: $('#WebpageEditForm').serialize(),
		url: "/webpages/webpages/edit.json" ,
		dataType: "text",
		success:function(data){
			if (openwindow) {
				window.open('/webpages/webpages/view/<?php echo $this->request->data['Webpage']['id']; ?>/draft:1', 'preview')
			}
			$(".ajaxLoader").hide("slow");
		}
	});
}


</script>
