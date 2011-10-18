<div class="tasks view">
  <div id="navigation">
    <div id="n1" class="info-block">
      <div class="viewRow">
        <ul class="metaData">
          <li><span class="metaDataLabel">
            <?php echo __('List Name : '); ?>
            </span><span class="metaDataDetail"><?php echo $task['Task']['name']; ?></span></li>
        </ul>
        <div class="tasks form"> <?php echo $this->Form->create('Task', array('url' => '/tasks/tasks/add'));?>
          <fieldset>
            <legend class="toggleClick">
            <?php echo __('Add a task to this list?');?>
            </legend>
            <?php
			 echo $this->Form->input('Task.parent_id', array('type' => 'hidden', 'value' => $parentId));
			 echo $this->Form->input('Task.name');
			 echo $this->Form->input('Task.due_date');
			 echo $this->Form->input('Task.assignee_id');
			 echo $this->Form->input('Task.model', array('type' => 'hidden', 'value' => $model));
			 echo $this->Form->input('Task.foreign_key', array('type' => 'hidden', 'value' => $foreignKey));
			 echo $this->Form->input('Success.redirect', array('type' => 'hidden', 'value' => '/contacts/contacts/task/'.$parentId));
        	 echo $this->Form->end('Submit');
			?>
          </fieldset>
        </div>
        <h3>Still pending tasks</h3>
        <?php echo $this->Element('scaffolds/index', array(
				'data' => $childTasks, 
				'actions' => array(
					$this->Html->link('View', array('plugin' => 'tasks', 'controller' => 'tasks', 'action' => 'view', '{id}')), 
					$this->Html->link('Edit', array('plugin' => 'tasks', 'controller' => 'tasks', 'action' => 'edit', '{id}')), 
					$this->Html->link('Complete', array('plugin' => 'tasks', 'controller' => 'tasks', 'action' => 'complete', '{id}'), array()),
					$this->Html->link('Delete', array('plugin' => 'tasks', 'controller' => 'tasks', 'action' => 'delete', '{id}'), array(), 'Are you sure you want to permanently delete?'),
					)
				));
		?>
        <h3>Completed tasks</h3>
        <?php echo $this->Element('scaffolds/index', array(
				'data' => $finishedChildTasks, 
				'actions' => array(
					$this->Html->link('View', array('plugin' => 'tasks', 'controller' => 'tasks', 'action' => 'view', '{id}')), 
					$this->Html->link('Edit', array('plugin' => 'tasks', 'controller' => 'tasks', 'action' => 'edit', '{id}')), 
					$this->Html->link('InComplete', array('plugin' => 'tasks', 'controller' => 'tasks', 'action' => 'incomplete', '{id}'), array()),
					$this->Html->link('Delete', array('plugin' => 'tasks', 'controller' => 'tasks', 'action' => 'delete', '{id}'), array(), 'Are you sure you want to permanently delete?'),
					),
				));
		?>
      </div>
    </div>
    <!-- /info-block end -->
  </div>
</div>
<a name="comments"></a>
<div id="post-comments">
  <?php $commentWidget->options(array('allowAnonymousComment' => false));?>
  <?php echo $commentWidget->display();?> </div>
  

<script type="text/javascript">
$(function() {
	$(".indexRow").parent().sortable({
		delay: 300,
		update: function(event, ui) {
			$('#loadingimg').show();
		 	var taskOrder = $(this).sortable('toArray').toString().replace(/row/g, '');
			$.post('/tasks/tasks/sort_order.json', {taskOrder:taskOrder}, 
				   function(data){
					  	var n = 1;
						$.each(data, function(i, item) {
							$('row.'+item).html(n);
							n++;
						});	
						$('#loadingimg').hide()
				   }
			);
		}
	});
});
</script>
