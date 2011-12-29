<div class="settings form">
<?php echo $this->Form->create('Setting');?>
	<fieldset>
 		<legend><?php echo __('Add Setting');?></legend>
	<?php
		// this is the first instance of our use of the updated select drop down which uses ajax to update other fields. We are attempting to make reusable form elements that can encompass the ajax part as well as the normal automagic form element config. element = the type of field being created or updated, json = the url to call with the value of this element, rel = the target id of the element to update
		echo $this->Form->input('Setting.type', array(
			'empty' => true,
			'label' => 'Type',
			'ajax' => array(
				'element' => 'select',
				'json' => 'settings/names', 
				'variable' => 'settings', 
				'rel' => 'SettingName'
				),
			));
		echo $this->Form->input('Setting.name', array('type' => 'select', 'empty' => 'Select Type First'));
		echo $this->Form->input('Setting.value');
		echo $this->Form->input('Setting.description');
	?>
	</fieldset>
<?php echo $this->Form->end('Submit');?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $this->Html->link(__('List Settings', true), array('action' => 'index'));?></li>
	</ul>
</div>


<script type="text/javascript">
function selectCallBack(data) {
	var name = $('#SettingName').val();
	items = [];
	$.each(data['settings'], function(key, val) {
		if (val['name'] == name) {
		    items += val['description'];
		}
	});
	$('#SettingDescription').html(items);
}

$(function() {
	$('#SettingName').change(function(){
		var url = '/' + $('#SettingType').attr('json') + '/' + $('#SettingType').val() + '.json';
		var target = $('#SettingType').attr('rel');
		$.getJSON(url, function(data){
			selectCallBack(data);
	    });
	});
});
</script>