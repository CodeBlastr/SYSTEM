<div class="galleries form">
<?php echo $this->Form->create('Gallery', array('enctype'=>'multipart/form-data'));?>
	<fieldset id="galleryFields">
 		<legend class="toggleClick"><?php echo __('Edit Gallery Options'); ?></legend>
		<?php
		echo $this->Form->input('Gallery.id');
		echo $this->Form->input('Gallery.name');
		echo $this->Form->hidden('Gallery.model', array('value' => $model));
		echo $this->Form->hidden('Gallery.foreign_key', array('value' => $foreignKey));
		echo $this->Form->input('Gallery.description', array('type' => 'richtext'));
		?>
      	<legend><?php echo __('Gallery Options'); ?></legend>
    	<?php
		echo $this->Form->input('Gallery.type', array('empty' => true));
		echo $this->Form->input('Gallery.thumb_width');
		echo $this->Form->input('Gallery.thumb_height');
		echo $this->Form->input('Gallery.medium_width');
		echo $this->Form->input('Gallery.medium_height');
		echo $this->Form->input('Gallery.full_width');
		echo $this->Form->input('Gallery.full_height');
		echo $this->Form->input('Gallery.conversion_type', array('type' => 'select', 'options' => $conversionTypes, 'empty' => true));
		echo $this->Form->end('Submit');
		?>
	</fieldset>

    
<?php echo $this->Form->create('GalleryImage', array('enctype'=>'multipart/form-data'));?>
	<fieldset>
 		<legend><?php echo __('Add Images'); ?></legend>
		<?php
		echo $this->Form->input('GalleryImage.gallery_id', array('type' => 'hidden', 'value' => $this->request->data['Gallery']['id']));
		echo $this->Form->input('Gallery.model', array('type' => 'hidden', 'value' => $model));
		echo $this->Form->input('Gallery.foreign_key', array('type' => 'hidden', 'value' => $foreignKey));
		echo $this->Form->input('GalleryImage.filename', array('type' => 'file'));
		echo $this->Form->input('GalleryImage.caption', array('type' => 'text'));
		echo $this->Form->input('GalleryImage.description', array('type' => 'richtext'));
		#echo $this->Form->input('GalleryImage.alt');
		echo $this->Form->input('dir', array('type' => 'hidden'));
	    echo $this->Form->input('mimetype', array('type' => 'hidden'));
	    echo $this->Form->input('filesize', array('type' => 'hidden'));
		echo $this->Form->end('Submit');
		?>
    </fieldset>

<h3><?php echo __('Gallery Preview'); ?></h3>
<?php echo $this->Element('gallery', array('model' => $model, 'foreignKey' => $foreignKey), array('plugin' => 'galleries')); ?>
    
</div>

<?php 
// set the contextual menu items
$this->set('context_menu', array('menus' => array(
	array(
		'heading' => 'Galleries',
		'items' => array(
			$this->Html->link(__('View', true), array('action' => 'view', $model, $foreignKey)),
			$this->Html->link(__('List', true), array('action' => 'index')),
			)
		),
	)));
?>
