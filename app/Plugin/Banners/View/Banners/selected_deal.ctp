<?php
	echo  $this->Html->script('/banners/js/jquery.countdown.js');
	echo $this->Html->css('/banners/css/jquery.countdown.css');

	if (!empty($dealItem)) {
?>
		<div id="nav">
		<?php 
			echo $this->Html->link('View All Deals', array('plugin' => 'banners', 'controller'=>'banners' , 'action'=>'all_daily_deals'), array('class' => 'button', 'escape' => false));
			echo $this->Html->link('Back', 'javascript:history.back(-1)', array( 'class' => 'button topright'));
		?>
		</div>
		<div id="content">
			<?php echo $this->Form->hidden('id', array('value' => $dealItem['Banner']['id'])); ?>
			<h2><?php echo $dealItem['Banner']['name']; ?></h2>
				<p><?php echo $dealItem['Banner']['description']; ?></p>
			<div id="galleryThumb">
					<?php echo $this->element('thumb', array('plugin' => 'galleries', 'model' => 'Banner', 'foreignKey' => $dealItem['Banner']['id'], 'thumbSize' => 'medium', 'thumbLink' => '#'));  ?>
			</div>
			<div id="pricing">
				<p>$<?php echo(intval($dealItem['Banner']['price']) - intval($dealItem['Banner']['discount_price'])); ?></p>
			</div>
			<div id="details">
				<div id="value">
					<p>Value <span class="detail">$<?php echo $dealItem['Banner']['price']; ?></span></p>
				</div>
				<div id="discount">
					<p>Discount <span class="detail"><?php echo $dealItem['Banner']['discount_percentage']; ?>%</span></p>
				</div>
				<div id="savings">
					<p>You Save <span class="detail">$<?php echo $dealItem['Banner']['discount_price']; ?></span></p>
				</div>
			</div>

			<div id="addtocart">
				<?php 
					$url = array('plugin' => 'banners', 'controller'=>'banners' , 
														'action'=>'redeemed', $dealItem['Banner']['id']);
 					echo $this->Form->submit('Redeem', array('onclick' => "location.href='".$this->Html->url($url)."'"));
 				?> 	
			</div>
			<div id="timer">
				<p>
					Time Left To Redeem <span class="detail"><div id="countdown" >
	</div></span></p>
			</div>
		
	</div>
<?php
}
?>
		
<script>
	var today = new Date();
	var date = new Date(today.getFullYear(), today.getMonth(), today.getDate()+1);
	
	$('#countdown').countdown({until: date});
</script>
