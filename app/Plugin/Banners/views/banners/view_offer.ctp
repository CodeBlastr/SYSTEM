<?php 
/**
 * 
 * 
 * @todo	We should have a separate view file for each banner type, and let the controller pick which view file to display.  That will allow us to keep the html separate for each banner type.
 */
?><?php 
	if(isset($this->params['named']['bannerType'])){
		$banner = $this->requestAction('banners/banners/daily_deal_data/'.$this->params['named']['bannerType']);
	}
?>
	<div id="nav">
		<?php  
			echo $this->Html->link(!empty($banner) ? 'View Offer' : 'N/A', 
					!empty($banner) ? $banner['Banner']['redemption_url'] : '#',
					 array('class' => 'button', 'escape' => false));
			echo $this->Html->link('Daily Deal', array('plugin' => 'banners', 'controller'=>'banners' , 'action'=>'daily_deal'), 
					array('class' => 'button topright'));
		?>
	</div>
	<div id="banner">
	
		<?php if (!empty($banner)) {?>
			<?php echo $form->hidden('id', array('value' => $banner['Banner']['id'])); ?>
			<div id="galleryThumb">
				<?php echo $this->element('thumb', array('plugin' => 'galleries', 'model' => 'Banner', 
						'foreignKey' => $banner['Banner']['id'], 'thumbSize' => 'medium', 'thumbLink' => $banner['Banner']['redemption_url']));  ?>
			</div>
<?php
} else {
	header('Location:/banners/banners/daily_deal');
	#echo '<h1>&nbsp;&nbsp;&nbsp;&nbsp;No current offer </h1>';
}
?>

	</div>