<div class="tasks form">
  <h2><?php echo 'Tasks for ' . $contact['Contact']['name']; ?></h2>
  <fieldset>
	<?php echo $this->Form->create('Task' , array('url'=>'/tasks/tasks/add'));?>
    <legend class="toggleClick"><?php echo 'Create a new task list?'; ?></legend>
    <?php
	 echo $this->Form->input('Task.name', array('label' => __('List Name', true)));
	 echo $this->Form->input('Task.description', array('label' => 'Is there a description for this task list?', 'type' => 'richtext', 'ckeSettings' => array('buttons' => array('Bold','Italic','Underline','FontSize','TextColor','BGColor','-','NumberedList','BulletedList','Blockquote','JustifyLeft','JustifyCenter','JustifyRight','-','Link','Unlink','-', 'Image'))));
	 echo $this->Form->input('Success.redirect', array('type' => 'hidden', 'value' => '/contacts/contacts/tasks/'.$foreignKey));
	 echo $this->Form->input('Task.foreign_key', array('type' => 'hidden', 'value' => $foreignKey));
	 echo $this->Form->input('Task.model', array('type' => 'hidden', 'value' => 'Contact'));
	 echo $this->Form->end(__('Save', true));?>
  </fieldset>
</div>
<?php echo $this->Element('scaffolds/index', array('data' => $tasks)); ?>