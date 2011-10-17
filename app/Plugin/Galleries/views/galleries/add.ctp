<div class="galleries form">
	<h2><?php __('Add Gallery '); ?></h2>
    	    
	<?php echo $this->Form->create('Gallery', array('enctype'=>'multipart/form-data'));?>
	<fieldset>
 		<legend><?php __('Gallery Info'); ?></legend>
	<?php
		echo $this->Form->input('Gallery.name');
		echo $this->Form->input('Gallery.type');
		echo $this->Form->input('Gallery.model', array('type' => 'hidden', 'value' => $model));
		echo !empty($this->params['pass'][0]) ? $this->Form->input('Gallery.model', array('type' => 'hidden', 'value' => $this->params['pass'][0])) : '';
		echo !empty($this->params['pass'][1]) ? $this->Form->input('Gallery.foreign_key', array('type' => 'hidden', 'value' => $this->params['pass'][1])) : '';
		echo $this->Form->input('Gallery.description', array('type' => 'richtext'));
	?>
    </fieldset>
	<fieldset>
 		<legend><?php __('Main Image Info'); ?></legend>
    <?php
		echo $this->Form->input('GalleryImage.filename', array('type' => 'file', 'label' => 'Upload your best image for this item.', 'after' => ' <p> This image will be the thumbnail. You can add additional images after save.</p>'));
	    echo $this->Form->input('GalleryImage.dir', array('type' => 'hidden'));
	    echo $this->Form->input('GalleryImage.mimetype', array('type' => 'hidden'));
	    echo $this->Form->input('GalleryImage.filesize', array('type' => 'hidden'));
		echo $this->Form->input('GalleryImage.caption', array('type' => 'text'));
		echo $this->Form->input('GalleryImage.description', array('type' => 'richtext'));
	?>
    </fieldset>
	<?php 
		echo $this->Form->end('Submit');
	?>
</div>

<?php 
// set the contextual menu items
$this->Menu->setValue(array(
	array(
		'heading' => 'Galleries',
		'items' => array(
			$this->Html->link(__('List Galleries', true), array('action' => 'index')),
			)
		),
	)
);
?>
<?php #debug($this->data); ?>
