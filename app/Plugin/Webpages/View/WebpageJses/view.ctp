<pre class="prettyprint linenums">
<?php echo htmlentities($webpageJs['WebpageJs']['content']); ?>
</pre>  

<?php 

// set the contextual menu items      
$this->set('context_menu', array('menus' => array(
	array(
		'heading' => 'Webpages',
		'items' => array(
			$this->Html->link(__('List', true), array('controller' => 'webpage_jses', 'action' => 'index')),
			$this->Html->link(__('Add', true), array('controller' => 'webpage_jses', 'action' => 'add', 'template')),
			$this->Html->link(__('Edit', true), array('controller' => 'webpage_jses', 'action' => 'edit', $webpageJs['WebpageJs']['id'])),
			$this->Html->link(__('Delete', true), array('controller' => 'webpage_jses', 'action' => 'delete', $webpageJs['WebpageJs']['id']), array(), 'Are you sure you want to delete "'.strip_tags($webpageJs['WebpageJs']['name']).'"'),
			)
		),
	))); ?>