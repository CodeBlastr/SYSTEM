<?php if($banner['Banner']['banner_position_id'] == 1) { ?> 
{element: banners.banner.1}
<?php } else { ?>
	<div id="banner">
	
		<?php if (!empty($banner)) {?>
			<?php echo $form->hidden('id', array('value' => $banner['Banner']['id'])); ?>
			<div id="galleryThumb">
				<?php echo $this->element('thumb', array('plugin' => 'galleries', 'model' => 'Banner', 
						'foreignKey' => $banner['Banner']['id'], 'thumbSize' => 'medium', 'thumbLink' => $banner['Banner']['redemption_url']));  ?>
			</div>
        <?php } ?>
     </div>
<?php } ?>