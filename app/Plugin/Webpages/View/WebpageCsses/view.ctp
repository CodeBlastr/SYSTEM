<pre class="prettyprint linenums">
<?php echo htmlentities($webpageCss['WebpageCss']['content']); ?>
</pre>  

<?php 

// set the contextual menu items      
$this->set('context_menu', array('menus' => array(
	array(
		'heading' => 'Webpages',
		'items' => array(
			$this->Html->link(__('List', true), array('controller' => 'webpage_csses', 'action' => 'index')),
			$this->Html->link(__('Add', true), array('controller' => 'webpage_csses', 'action' => 'add', 'template')),
			$this->Html->link(__('Edit', true), array('controller' => 'webpage_csses', 'action' => 'edit', $webpageCss['WebpageCss']['id'])),
			$this->Html->link(__('Delete', true), array('controller' => 'webpage_csses', 'action' => 'delete', $webpageCss['WebpageCss']['id']), array(), 'Are you sure you want to delete "'.strip_tags($webpageCss['WebpageCss']['name']).'"'),
			)
		),
	))); ?>