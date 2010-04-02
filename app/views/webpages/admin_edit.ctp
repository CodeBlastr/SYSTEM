<div class="webpages form">
	<script type="text/javascript" src="<?php echo $this->webroot."ckeditor/ckeditor.js";?>"></script>
	<script type="text/javascript" src="<?php echo $this->webroot."ckfinder/ckfinder.js";?>"></script>
	<?php echo $form->create('Webpage');?>
	<fieldset>
 		<legend><?php __('Edit Webpage');?></legend>
	<?php
		echo $form->input('name');
		echo $form->input('title');
		echo $form->input('alias');
	?>
		<div>
			<span>Content</span>
			<textarea name="data[Webpage][content]" width="400"><?php echo $webpage['Webpage']['content']; ?></textarea>
			<script type="text/javascript">
				var editor = CKEDITOR.replace( 'data[Webpage][content]' );
 				CKFinder.SetupCKEditor( editor, { BasePath : '/ckfinder/', RememberLastFolder : false } ) ;
			</script>
		</div>
	<?php
// 		echo $form->textarea('content', array('class'=>'ckeditor'));
		echo $form->input('keywords');
		echo $form->input('description');
	?>
	</fieldset>
	<?php echo $form->end('Save Webpage');?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Delete', true), array('action' => 'delete', $form->value('Webpage.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $form->value('Webpage.id'))); ?></li>
		<li><?php echo $html->link(__('List Webpage', true), array('action' => 'index'));?></li>
	</ul>
</div>
<?php
	$menu->setValue(
		array(
			$html->link(__('List Webpage', true), array('controller' => 'webpages', 'action' => 'index'), array('title' => 'List Webpage', 'onclick' => 'Modalbox.show(this.href, {title: this.title, width: 500}); return false;')),
			$html->link(__('Add Webpage', true), array('controller' => 'webpages', 'action' => 'add'), array('title' => 'Add Webpage', 'onclick' => 'Modalbox.show(this.href, {title: this.title, width: 500}); return false;')),
			$html->link(__('View Webpage', true), array('controller' => 'webpages', 'action' => 'view', $webpage['Webpage']['id']), array('title' => 'View Webpage', 'onclick' => 'Modalbox.show(this.href, {title: this.title, width: 500}); return false;'))
		)
	);
?>