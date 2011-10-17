<?php 
if(
	$this->request->params['action'] == 'view' || 
	$this->request->params['action'] == 'messages' || 
	$this->request->params['action'] == 'message' || 
	$this->request->params['action'] == 'tasks' || 
	$this->request->params['action'] == 'task' || 
	$this->request->params['action'] == 'milestones' || 
	$this->request->params['action'] == 'people') :

$tabs_for_layout = !empty($tabs_for_layout) ? $tabs_for_layout : array(
	array('action' => array('view'),
		  'link' => '/contacts/contacts/view/'.$contact['Contact']['id'],
		  'linkText' => 'Dashboard'),
	array('action' => array('task', 'tasks'),
		  'link' => '/contacts/contacts/tasks/'.$contact['Contact']['id'],
		  'linkText' => 'Tasks'),
	);
?>
<div id="<?php echo $this->request->params['controller'].'Tabs'; ?>" class="tab ui-tabs ui-widget">
  <ul id="leadTab" class="ui-tabs-nav ui-helper-reset ui-helper-clearfix ui-widget-header ui-corner-all">
<?php if (!empty($tabs_for_layout)) : foreach ($tabs_for_layout as $tab) : ?>

    <li class="ui-state-default ui-corner-top <?php echo in_array($this->request->params['action'], $tab['action']) ? 'ui-tabs-selected ui-state-active' : null; ?>"><a href="<?php echo $tab['link']; ?>" title="<?php echo $tab['linkText']; ?>"><span><?php echo $tab['linkText']; ?></span></a></li>

<?php endforeach; endif; ?>

  </ul>
</div>
<?php endif; ?>
