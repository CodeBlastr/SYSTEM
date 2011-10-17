<div class="galleries form">
	<h2><?php __('Add Gallery '); ?></h2>
    	    
	<?php echo $form->create('Gallery', array('enctype'=>'multipart/form-data'));?>
	<fieldset>
 		<legend><?php __('Gallery Info'); ?></legend>
	<?php
		echo $form->input('Gallery.name');
		echo $form->input('Gallery.type');
		echo $form->input('Gallery.model', array('type' => 'hidden', 'value' => $model));
		echo !empty($this->params['pass'][0]) ? $form->input('Gallery.model', array('type' => 'hidden', 'value' => $this->params['pass'][0])) : '';
		echo !empty($this->params['pass'][1]) ? $form->input('Gallery.foreign_key', array('type' => 'hidden', 'value' => $this->params['pass'][1])) : '';
		echo $form->input('Gallery.description', array('type' => 'richtext'));
	?>
    </fieldset>
	<fieldset>
 		<legend><?php __('Main Image Info'); ?></legend>
    <?php
		echo $form->input('GalleryImage.filename', array('type' => 'file', 'label' => 'Upload your best image for this item.', 'after' => ' <p> This image will be the thumbnail. You can add additional images after save.</p>'));
	    echo $form->input('GalleryImage.dir', array('type' => 'hidden'));
	    echo $form->input('GalleryImage.mimetype', array('type' => 'hidden'));
	    echo $form->input('GalleryImage.filesize', array('type' => 'hidden'));
		echo $form->input('GalleryImage.caption', array('type' => 'text'));
		echo $form->input('GalleryImage.description', array('type' => 'richtext'));
	?>
    </fieldset>
	<?php 
		echo $form->end('Submit');
	?>
</div>

<?php 
// set the contextual menu items
$menu->setValue(array(
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
