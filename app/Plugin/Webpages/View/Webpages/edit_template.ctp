<div class="webpages form">
<?php echo $this->Form->create('Webpage'); ?>
  
  	<fieldset>
    <?php
	echo $this->Form->input('Webpage.id');
	echo $this->Form->input('Webpage.type', array('type' => 'hidden', 'default' => 'element'));
	echo $this->Form->input('Webpage.name');
	echo $this->Form->input('Webpage.content');	?>
  	</fieldset>
  
	<fieldset>
    	<legend> <?php echo __('Template Settings'); ?> </legend>
      	<?php
		echo $this->Form->input('is_default', array('type' => 'checkbox'));
		echo $this->Form->input('template_urls', array('type' => 'textarea', 'after' => ' <br>One url per line. (ex. /tickets/tickets/view/*)'));
		echo $this->Form->input('user_roles', array('type' => 'select', 'options' => $userRoles, 'multiple' => 'checkbox')); ?>
    </fieldset>
    
<?php
echo $this->Form->end('Save Template'); ?>
</div>

<?php
$menuItems = array(
	$this->Html->link(__('List'), array('controller' => 'webpages', 'action' => 'index', 'template')),
	$this->Html->link(__('Add'), array('controller' => 'webpages', 'action' => 'add', 'template'), array('title' => 'Add Webpage')),
	$this->Html->link(__('Delete'), array('action' => 'delete', $this->Form->value('Webpage.id')), null, sprintf(__('Are you sure you want to delete # %s?'), $this->Form->value('Webpage.id'))),
	);

$this->set('context_menu', array('menus' => array(
	  array('heading' => 'Webpages',
		'items' => $menuItems
			)
	  ))); ?>
<script type="text/javascript">
$(function() {	
	
	// probably can delete some of this (a hold over from unified edit ctp files)
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


<?php /* if (in_array('Drafts', CakePlugin::loaded())) {  ?>
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
	}); */ ?>
