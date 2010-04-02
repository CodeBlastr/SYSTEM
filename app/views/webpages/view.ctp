<div class="webpages view">
	<div style="width:400px;padding:30px;">
			<div>
				<div><span>Name : </span><?php echo $webpage['Webpage']['name'];  ?></div>
			</div>
			<div>
				<div><span>Title : </span><?php echo $webpage['Webpage']['title'];  ?></div>
			</div>
			<div>
				<div><span>Alias : </span><?php echo $webpage['Webpage']['alias'];  ?></div>
			</div>
			<div>
				<div><span>Contents : </span><?php echo $webpage['Webpage']['content'];  ?></div>
			</div>
			<div>
				<div><span>Keywords : </span><?php echo $webpage['Webpage']['keywords'];  ?></div>
			</div>
			<div>
				<div><span>Description : </span><?php echo $webpage['Webpage']['description'];  ?></div>
			</div>
	</div>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('New Webpage', true), array('action' => 'add')); ?> </li>
		<li><?php echo $html->link(__('Edit Webpage', true), array('action' => 'edit', $webpage['Webpage']['id'])); ?> </li>
		<li><?php echo $html->link(__('Delete Webpage', true), array('action' => 'delete', $webpage['Webpage']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $webpage['Webpage']['id'])); ?> </li>
		<li><?php echo $html->link(__('List Webpage', true), array('action' => 'index')); ?> </li>
	</ul>
</div>
