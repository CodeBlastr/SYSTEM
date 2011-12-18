
<?php echo $this->Html->link(__('List Acos', true), array('action' => 'index'));?>

<?php echo $this->Form->create('Section');?>
	
	<?php echo $this->Form->input('parent_id')?>
	<?php echo $this->Form->input('alias')?>
	<?php echo $this->Form->input('type' , array('type'=>'select' , 'options'=>array('controller'=>'Controller' , 'plugin'=>'Plugin', 'pcontroller'=>'Plugin Controller' , 'action'=>'Action', 'paction'=>'Plugin Action' )));?>
	
<?php echo $this->Form->end('Create Aco');?>

