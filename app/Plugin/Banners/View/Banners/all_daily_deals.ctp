<div id="nav">
	<?php 
		echo $this->Html->link('View All Deals', array('plugin' => 'banners', 'controller'=>'banners' , 'action'=>'all_daily_deals'), array('class' => 'button', 'escape' => false));
		echo $this->Html->link('Back', 'javascript:history.back(-1)', array( 'class' => 'button topright'));
	?>
</div>
<div id="content">
	<?php foreach ($dailyDeals as $i => $dailyDeal): ?>
	<?php
		if($i%2 == 0){ ?>
		<div class="indexRow">
	<?php } ?>
			<div class="indexCell">
				<div class="title"><?php echo $dailyDeal['Banner']['location']; ?></div>
				<div class="galleryThumb">
				<?php 
					echo $this->element('thumb', array('plugin' => 'galleries', 'model' => 'Banner', 'foreignKey' => $dailyDeal['Banner']['id'], 'thumbSize' => 'medium', 'thumbLink' => '/banners/banners/selected_deal/'.$dailyDeal['Banner']['id']));  
					/*echo $this->Html->link($this->Html->image("../images/sampleGalleryThumb.jpg"),
								array('controller' => 'banners', 'action' => 'selected_deal', $dailyDeal['Banner']['id']), 
								array('escape' => false));*/
				?>
				</div>
				<div class="pricing">
					<p>$<?php echo $dailyDeal['Banner']['price']; ?></p>
				</div>
				<div class="details">
					<div class="discount">
						<p>
							Discount <span class="value"><?php echo $dailyDeal['Banner']['discount_percentage']; ?>%</span></p>
					</div>

					<div class="yousave">
						<p>
							You Save <span class="value">$<?php echo $dailyDeal['Banner']['discount_price']; ?></span></p>
					</div>
				</div>
			</div>
	<?php if($i%2 != 0){ ?>
			
		</div>
		<?php }?>
	<?php endforeach; ?>
</div>
