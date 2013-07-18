<pre class="prettyprint linenums">
<?php echo htmlentities($webpage['Webpage']['content']); ?>
</pre>  

<?php 

// set the contextual menu items      
$this->set('context_menu', array('menus' => array(
	array(
		'heading' => 'Webpages',
		'items' => array(
			$this->Html->link(__('List', true), array('controller' => 'webpages', 'action' => 'index')),
			$this->Html->link(__('Add', true), array('controller' => 'webpages', 'action' => 'add', 'template')),
			$this->Html->link(__('Edit', true), array('controller' => 'webpages', 'action' => 'edit', $webpage['Webpage']['id'])),
			$this->Html->link(__('Delete', true), array('controller' => 'webpages', 'action' => 'delete', $webpage['Webpage']['id']), array(), 'Are you sure you want to delete "'.strip_tags($webpage['Webpage']['title']).'"'),
			)
		),
	))); ?>