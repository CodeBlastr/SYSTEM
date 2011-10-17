<?php 
/**
 * 
 * @todo 	I did something very bad here, to make time.  We need to separate these out into separate view files, and pick the view file by the banner type.  That way each banner type can have its own form fields, and we don't need this horrible formatting.
 * @todo	These size variables should be passed to this view by the controller.
 */
?>
<div class="banners form">
<?php echo $form->create('Banner', array('type' => 'file'));?>
<h1><?php $this->data['Banner']['banner_position_id'] == 1 ?  __('Daily Deal Builder') : __('Ad Builder'); ?></h1>
	<fieldset>
 		<fieldset> 
		<?php
			echo $form->input('Banner.id', array('class' => 'text-1'));
			echo $form->input('Banner.banner_position_id', array('type' => 'hidden')); 
			echo $form->input('name', array('class' => 'text-1', 
											'label' => 'Give this ad a title.', 
											'div' => array('class' => 'text-inputs')));
			echo $this->data['Banner']['banner_position_id'] == 1 ? $form->input('description', array('class' => 'text-1', 
												   'label' => 'A very short (3-8 word) tagline.', 
												   'div' => array('class' => 'text-inputs'))) : '';
		?>
		</fieldset>
		<?php 
			echo $this->data['Banner']['banner_position_id'] == 1 ? $form->input('price', array('class' => 'text-1',
											 'label' => 'What is the regular price for the item being advertised?',
											 'div' => array('class' => 'text-inputs'))) : '';
			echo $this->data['Banner']['banner_position_id'] == 1 ? $form->input('discount_price', array('class' => 'text-1',
													  'label' => 'What is the sale price for the item?', 
													  'div' => array('class' => 'text-inputs'))) : '';
			echo $this->data['Banner']['banner_position_id'] == 2 ? $form->input('redemption_url', array('class' => 'text-1', 
													  'label' => 'Where should users who click the ad go?',
													  'div' => array('class' => 'text-inputs'))) : '';
			echo $this->element('thumb', array('plugin' => 'galleries', 
											   'model' => 'Banner', 'foreignKey' => $this->data['Banner']['id'], 
											   'thumbSize' => 'medium', 'thumbLink' => '#'));  
			echo $this->data['Banner']['banner_position_id'] == 1 ? 
				 $form->input('GalleryImage.filename', array('type' => 'file', 
															 'label' => 'Upload Image for Ad (w 284 x h 125 pixels)', 
															 'div' => array('class' => 'search-file'),
															 'class' => 'text')) : 
				 $form->input('GalleryImage.filename', array('type' => 'file', 
															 'label' => 'Upload Image for Ad (w 284 x h 260 pixels)', 
															 'div' => array('class' => 'search-file'),
															 'class' => 'text'));
		    echo $form->input('GalleryImage.dir', array('type' => 'hidden'));
		    echo $form->input('GalleryImage.mimetype', array('type' => 'hidden'));
		    echo $form->input('GalleryImage.filesize', array('type' => 'hidden'));
		    echo $form->input('Gallery.id', array('type' => 'hidden'));
			
			# move these variables to the controller and define them there in their own function
			if (defined('__BANNERS_POSITION_'.$this->data['Banner']['banner_position_id'].'_WIDTH') &&
					defined('__BANNERS_POSITION_'.$this->data['Banner']['banner_position_id'].'_HEIGHT')) {
				echo $form->input('Gallery.medium_width', array('type' => 'hidden', 'value' => 
						constant('__BANNERS_POSITION_'.$this->data['Banner']['banner_position_id'].'_WIDTH')));
				echo $form->input('Gallery.medium_height', array('type' => 'hidden', 'value' => 
						constant('__BANNERS_POSITION_'.$this->data['Banner']['banner_position_id'].'_HEIGHT')));
			} else {
				# temporary holder for defaults
				echo  $form->input('Gallery.medium_width', array('type' => 'hidden', 'value' => '284'));
				echo $this->data['Banner']['banner_position_id'] == 1 ? $form->input('Gallery.medium_height', array('type' => 'hidden', 'value' => '125')) : $form->input('Gallery.medium_height', array('type' => 'hidden', 'value' => '260'));
			}
						
		?>
		</fieldset>
	
	<?php
		$options = array(
			'name' => 'Submit',
			'label' => 'Submit',
			'class' => 'submit1'
		);
		echo $form->end($options); 
	?>
</div>