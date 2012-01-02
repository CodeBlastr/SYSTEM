<?php
# make a request action to pull the gallery data
$type = !empty($type) ? $type : null;
$name = !empty($name) ? $name : null;
$settings = $this->requestAction("/settings/form/{$type}/{$name}"); ?>

<div class="settings forms">
<?php
$i=0; foreach ($settings['Setting'] as $setting) {
   	echo $this->Form->create('Setting', array('url' => '/settings/edit/'));  ?>
	<div class="settings form">
		<fieldset>
	 		<legend class="toggleClick"><?php echo 'Edit ' . $setting['type']. ' ' . Inflector::humanize(strtolower($setting['name'])) ;?></legend>
    	    <?php
			echo $this->Form->input('Setting.'.$i.'.id', array('value' => $setting['id']));
			echo $this->Form->hidden('Setting.'.$i.'.type', array('value' => $setting['type']));
			echo $this->Form->hidden('Setting.'.$i.'.name', array('value' => $setting['name']));
			if (is_array($setting['value'])) {
				foreach($setting['value'] as $key => $value) {
					echo $this->Form->input('Setting.'.$i.'.value.'.$key, $value);
				}
			} else {
				echo $this->Form->input('Setting.'.$i.'.value', array('value' => $setting['value']));
			}
			# @todo get rid of this description field and use the description from the Setting model as plain text.
			echo $this->Form->input('Setting.'.$i.'.description', array('value' => $setting['description']));
			echo $this->Form->end('Submit'); ?>	
		</fieldset>
	</div>
<?php
$i++; } ?>
</div>