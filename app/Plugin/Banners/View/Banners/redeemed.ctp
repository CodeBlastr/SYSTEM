<?php 
//echo $this->Html->link(__($this->Html->tag('span', 'View All Deals', array('class' => 'button')), true), array('plugin' => 'banners', 'controller'=>'banners' , 'action'=>'all_daily_deals'), array('class' => 'button', 'escape' => false));
?>
<!--<h1>Do Not Close This Window Show This Voucher In Store To Redeem</h1>
--><?php 
//echo $redeemDeal['Banner']['discount_percentage'] .' '. $redeemDeal['Banner']['description'];
?>


<div id="nav">
	<?php 
		echo $this->Html->link('View All Deals', array('plugin' => 'banners', 'controller'=>'banners' , 'action'=>'all_daily_deals'), array('class' => 'button', 'escape' => false));
		echo $this->Html->link('Back', 'javascript:history.back(-1)', array('class' => 'button topright'));
	?>        
        </div>
<div id="content">
	<div class="warning">
		<p>DO NOT CLOSE THIS WINDOW! SHOW THIS VOUCHER IN STORE TO REDEEM</p>
	</div>
	<div class="sponsor">
		<?php echo $this->element('thumb', array('plugin' => 'galleries', 'model' => 'Banner', 
				'foreignKey' => $redeemDeal['Banner']['id'], 'thumbSize' => 'medium', 'thumbLink' => '#')); ?>
	</div>
	<div class="offer">
		<p><?php echo $redeemDeal['Banner']['discount_percentage'] ;?>% <?php echo $redeemDeal['Banner']['description']; ?></p>
	</div>
	<div class="redeemed">
		<p>VOUCHER REDEEMED</p>
	</div>
	<div class="disclaimer">
		<p>PRESENT THIS VOUCHER IN STORE TO REDEEM</p>
        <p>* see store for full details</p>
	</div>
</div>


