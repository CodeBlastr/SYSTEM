<div id="nav">
	<?php 
		echo $this->Html->link('View All Deals', array('plugin' => 'banners', 'controller'=>'banners' , 'action'=>'all_daily_deals'), array('class' => 'button', 'escape' => false));
		echo $this->Html->link('Back', 'javascript:history.back(-1)', array('class' => 'button topright'));
	?>
</div>
{element: banners.banner.1}
