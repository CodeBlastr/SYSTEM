<div class="webpages form">
	<?php echo $this->Form->create('Webpage');?>
    <fieldset>
    	<?php
        echo $this->Form->input('Webpage.type', array('type' => 'hidden', 'default' => 'template'));
		echo $this->Form->input('Webpage.name', array('label' => 'Internal Template Name'));
		echo $this->Form->input('Webpage.content', array('type' => 'richtext', 'ckeSettings' => array('buttons' => array('Source')))); ?>
	</fieldset>
    
    <fieldset>
        <legend><?php echo __('Template Settings (required)'); ?></legend>
    	<?php
		echo $this->Form->input('is_default', array('type' => 'checkbox'));
		echo $this->Form->input('template_urls', array('label' => 'Urls to use this template. (ex. /tickets/tickets/view/*)'));
		echo $this->Form->input('user_roles', array('label' => 'User roles to use this template.', 'type' => 'select', 'options' => $userRoles, 'multiple' => 'checkbox')); ?>
    </fieldset>
    
	<?php echo $this->Form->end('Save Webpage');?>
</div>
<?php
$this->set('context_menu', array('menus' => array(
	array(
		'heading' => 'Webpages',
		'items' => array(
			 $this->Html->link(__('List', true), array('action' => 'index', 'template')),									 
			 )
		)
	))); ?>
	
<script type="text/javascript">
$(function() {	
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