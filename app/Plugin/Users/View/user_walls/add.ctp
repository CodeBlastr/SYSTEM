<?php echo $this->Form->create('UserWall' , array('url'=>array('plugin'=>'users','controller'=>'user_walls' , 'action'=>'add' , $this->params['pass'][0])));?>
	<fieldset>
 		<legend><?php __('Add User Wall'); ?></legend>
	<?php
		echo $this->Form->input('post', array('label' => 'Post to Wall', 'type' => 'richtext', 'ckeSettings' => array('buttons' => array('Bold','Italic','Underline','FontSize','TextColor','BGColor','-','NumberedList','BulletedList','Blockquote','JustifyLeft','JustifyCenter','JustifyRight','-','Link','Unlink','-', 'Image'))));
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>