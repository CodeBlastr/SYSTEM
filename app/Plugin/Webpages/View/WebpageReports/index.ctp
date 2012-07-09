<h2><?php echo __('Reports');?></h2>

<ul>
<li><?php echo  $this->Html->link(' Open Order Items ', array('controller'=>'reports'
			, 'action'=>'view', 'open'))?></li>
<li><?php echo $this->Html->link(' Returned Order Items ', array('controller'=>'reports'
			, 'action'=>'view', 'return'))?></li>
</ul>
</h2>