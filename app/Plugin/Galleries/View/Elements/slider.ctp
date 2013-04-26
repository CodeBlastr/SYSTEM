<?php
// This file is good to edit but make a copy of it in canopy nation first
// thats probably where the javascript we need is too ?>
<!--div class="slide-wrapper"-->
	<div class="slide-container">
		<div id="slides">
			<div class="slides_container">
				<?php foreach ($gallery['GalleryImage'] as $slide) { ?>
				<div class="slide">
					<a href="#" title="<?php echo $slide['caption']; ?>">
					<?php
					$largeImage = $slide['dir'].'thumb/large/'.$slide['filename'];
					echo $this->Html->image($largeImage,
		                array(
		                    'width' => $gallery['GallerySettings']['mediumImageWidth'], 
		                    'height' => $gallery['GallerySettings']['mediumImageHeight'],
		                    'alt' => $slide['alt'],
		                    ),
		                array(
		                    'conversion' => $gallery['GallerySettings']['conversionType'],
		                    'quality' => 75,
		                    )); ?>
	                </a>
					<div class="caption">
						<p>
							<?php echo $slide['caption']; ?>
						</p>
					</div>
				</div>
				<?php } ?>
			</div>
		</div>
	</div>
<!--/div-->
