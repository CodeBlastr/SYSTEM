	<div class="singleEvent">
	    <h4><?php echo $this->Html->link(h($event['Event']['name']), array('plugin' => 'events', 'controller' => 'events', 'action' => 'view', $event['Event']['id'])); ?></h4>
	    <?php echo h($this->Text->truncate($event['Event']['description'])); ?>
	    <br />
	    <i class="icon-tag"></i> $ <?php echo h($event['Event']['ticket_price']); ?>&nbsp; <i class="icon-time"></i> <?php echo date('g:i a', strtotime($event['Event']['start'])) ?>
	</div>