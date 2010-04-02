<div class="webpages preview">
	<div style="padding:30px;">
			<div style="padding-top:20px;">
				<div><span style="font-weight:bold">Name : </span><?php echo $webpage['Webpage']['name'];  ?></div>
			</div>
			<div style="padding-top:20px;">
				<div><span style="font-weight:bold">Title : </span><?php echo $webpage['Webpage']['title'];  ?></div>
			</div>
			<div style="padding-top:20px;">
				<div><span style="font-weight:bold">Alias : </span><?php echo $webpage['Webpage']['alias'];  ?></div>
			</div>
			<div style="padding-top:20px;">
				<div><span style="font-weight:bold">Contents : </span><?php echo $webpage['Webpage']['content'];  ?></div>
			</div>
			<div style="padding-top:20px;">
				<div><span style="font-weight:bold">Keywords : </span><?php echo $webpage['Webpage']['keywords'];  ?></div>
			</div>
			<div style="padding-top:20px;">
				<div><span style="font-weight:bold">Description : </span><?php echo $webpage['Webpage']['description'];  ?></div>
			</div>
	</div>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('List Webpage', true), array('action' => 'index')); ?></li>
	</ul>
</div>
<?php
	$menu->setValue(array($html->link(__('List Webpage', true), array('controller' => 'webpages', 'action' => 'index'), array('title' => 'List Webpage', 'onclick' => 'Modalbox.show(this.href, {title: this.title, width: 500}); return false;'))));
?>