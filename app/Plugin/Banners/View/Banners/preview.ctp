<p> Check the following link on your mobile phone to ensure that your content and copy is correct: </p>
<p>
  <?php
		echo $this->Html->link($this->Html->url('/banners/banners/banner_preview/'. $banner['Banner']['id'], true), 
												'/banners/banners/banner_preview/'. $banner['Banner']['id']); 
	?>
</p>
<p>
<?php
	if ($banner['Banner']['is_published'] != 1) {?>
	<p> If you are satisfied that your ad is correct and you are ready to go then press the button below: </p>
	<?php 
		echo $this->Html->link('Publish', array('action' => 'is_published', $banner['Banner']['id'] ), array('class' => 'button submit1'));
	}?>
</p>
<p> If you want to edit something then click the button below to make any adjustments. </p>
<p>
<?php 
		echo $this->Html->link('Edit', array('controller' => 'banners', 'action' => 'edit', $banner['Banner']['id']), array('class' => 'button submit1')); 
	?>
</p>
<p> Would you like to see the ad performance?  </p>
<p>
<?php 
		echo $this->Html->link('Report', array('controller' => 'banners', 'action' => 'reports', $banner['Banner']['id']), array('class' => 'button submit1')); 
	?>
</p>

<p> If you want to visit all your banners, click here. </p>
<p><?php echo $this->Html->link('My banners',
		 array('controller' => 'banners', 'action' => 'index'),
		 	 array('class' => 'button submit1'));
?>