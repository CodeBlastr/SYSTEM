<ul>
	<?php 
		for ($instance = 1; $instance < 10; ++$instance) {
			if (defined('__ELEMENT_BANNERS_POSITIONS'.$instance)) {
				extract(unserialize(constant('__ELEMENT_BANNERS_POSITIONS'.$instance)));
			}
			$bannerType = !empty($bannerType) ? $bannerType : null;
			if ($bannerType) {
			?>
			
			<li><a class="retail" 
					href="/banners/banners/buy/bannerType:<?php echo $bannerType; ?>">
						<?php echo $bannerType; ?></a></li>
			<?php 
			}
		}
	?>	
	<li><a class="about" href="#">About</a></li>
	<li><a class="faq" href="#">FAQ</a></li>
	<li><a class="contact" href="#">Contact</a></li>
</ul>
