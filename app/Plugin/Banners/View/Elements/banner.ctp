<?php
// this should be at the top of every element created with format __ELEMENT_PLUGIN_ELEMENTNAME_instanceNumber.
// it allows a database driven way of configuring elements, and having multiple instances of that configuration.
	if(!empty($instance) && defined('__ELEMENT_BANNERS_POSITIONS_'.$instance)) {
		extract(unserialize(constant('__ELEMENT_BANNERS_POSITIONS_'.$instance)));
	} else if (defined('__ELEMENT_BANNERS_POSITIONS')) {
		extract(unserialize(__ELEMENT_BANNERS_POSITIONS));
	}
# setup defaults

$bannerType = !empty($bannerType) ? $bannerType : null;
$banner = !empty($banner) ? $banner : $this->requestAction('banners/banners/daily_deal_data/'.$bannerType);

if (!empty($banner)) {
	echo  $this->Html->script('/banners/js/jquery.countdown.js');
	echo $this->Html->css('/banners/css/jquery.countdown.css');
	?>
		<div id="content">
			<?php echo $this->Form->hidden('id', array('value' => $banner['Banner']['id'])); ?>
			<h2><?php echo $banner['Banner']['name']; ?></h2>
				<p><?php echo $banner['Banner']['description']; ?></p>
			<div id="galleryThumb">
				<?php echo $this->element('thumb', array('plugin' => 'galleries', 'model' => 'Banner', 'foreignKey' => $banner['Banner']['id'], 'thumbSize' => 'medium', 'thumbLink' => '#'));  ?>
			</div>
			<div id="pricing">
				<p>$<?php echo(intval($banner['Banner']['price']) - intval($banner['Banner']['discount_price'])); ?></p>
			</div>
			<div id="details">
				<div id="value">
					<p>Value <span class="detail">$<?php echo $banner['Banner']['price']; ?></span></p>
				</div>
				<div id="discount">
					<p>Discount <span class="detail">
							<?php echo $banner['Banner']['discount_percentage']; ?>%</span></p>
				</div>
				<div id="savings">
					<p>You Save 
						<span class="detail">$<?php echo $banner['Banner']['discount_price']; ?></span></p>
				</div>
			</div>

			<div id="addtocart">
				<?php 
					$url = array('plugin' => 'banners', 'controller'=>'banners' , 
														'action'=>'redeemed', $banner['Banner']['id']);
 					echo $this->Form->submit('Redeem', 
 							array('onclick' => "location.href='".$this->Html->url($url)."'"));
 				?> 
			</div>
			<div id="timer">
				<p>Time Left To Buy <span class="detail">
										<div id="countdown" ></div>
									</span>
				</p>
			</div>
	</div>
<?php
} else {
	header('Location:/banners/banners/all_daily_deals');
}
?>


<script>
	var today = new Date();
	var date = new Date(today.getFullYear(), today.getMonth(), today.getDate()+1);

	//set countdown timer value in countdown div 
	$('#countdown').countdown({until: date});
</script>

