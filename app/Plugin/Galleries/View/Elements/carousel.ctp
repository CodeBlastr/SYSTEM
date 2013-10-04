<div id="myCarousel" class="carousel slide" data-pause="hover" data-interval="5000">
	<!-- Carousel items -->
	<div class="carousel-inner">
        <?php for($i = 0; $i < count($gallery['GalleryImage']); $i++) { ?>
		<div class="<?php echo $i == 0 ? 'active' : null; ?> item">
			<?php 
			echo !empty($gallery['GalleryImage'][$i]['_embed']) ? 
				'<iframe height="' . $gallery['GallerySettings']['largeImageHeight'] . '" width="100%" src="' . $gallery['GalleryImage'][$i]['_embed'] . '" frameborder="0" allowfullscreen></iframe>' :
				$this->Html->image($gallery['GalleryImage'][$i]['dir'] . '/' . $gallery['GalleryImage'][$i]['filename']); ?>
		</div>
		<?php } ?>
	</div>
	<!-- Carousel nav -->
	<a class="carousel-control left" href="#myCarousel" data-slide="prev">&lsaquo;</a>
	<a class="carousel-control right" href="#myCarousel" data-slide="next">&rsaquo;</a>
	<div class="carousel-indicators row-fluid" style="position: static;">
        <?php for($i = 0; $i < count($gallery['GalleryImage']); $i++) { ?>
		<div data-target="#myCarousel" data-slide-to="<?php echo $i; ?>" class="<?php echo $i == 0 ? 'active' : null; ?> pull-left">
			<?php 
			$img = !empty($gallery['GalleryImage'][$i]['_thumb']) ? $gallery['GalleryImage'][$i]['_thumb'] : $gallery['GalleryImage'][$i]['dir'] . '/thumb/small/' . $gallery['GalleryImage'][$i]['filename']; 
			echo $this->Html->image($img, array('width' => $gallery['GallerySettings']['smallImageWidth'], 'height' => $gallery['GallerySettings']['smallImageHeight'])); ?>
		</div>
		<?php } ?>
	</div>
</div>