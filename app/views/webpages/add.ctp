<div class="webpages form">
	<script type="text/javascript" src="<?php echo $this->webroot."ckeditor/ckeditor.js";?>"></script>
	<script type="text/javascript" src="<?php echo $this->webroot."ckfinder/ckfinder.js";?>"></script>
	<?php echo $form->create('Webpage');?>
	<fieldset>
	<legend><?php __('Add Webpage');?></legend>
	<?php
		echo $form->input('name', array('error' => array(
			'required' => 'Please specify a valid name',
			'length' => 'The name must have not more than 100 characters'
			)));
		echo $form->input('title', array('error' => array(
			'required' => 'Please specify a valid title',
			'length' => 'The title must have not more than 100 characters'
			)));
		echo $form->input('alias', array('error' => array(
			'required' => 'Please specify a valid alias',
			'rule' => 'Alias name is already in use. Please choose another'
			)));
		?>
		<div>
			<span>Content</span>
			<textarea name="data[Webpage][content]" width="400"></textarea>
			<script type="text/javascript">
				var editor = CKEDITOR.replace( 'data[Webpage][content]' );
				CKFinder.SetupCKEditor( editor, { BasePath : '/ckfinder/', RememberLastFolder : false } ) ;
			</script>
		</div>
<!-- 		echo $form->textarea('content', array('class'=>'ckeditor'), array('error' => 'Please enter contents of webpage')); -->
		<?php
		echo $form->input('keywords');
		echo $form->input('description');
	?>
	</fieldset>
	<?php echo $form->end('Save Webpage');?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('List Webpage', true), array('action' => 'index'));?></li>
	</ul>
</div>
<?php
	$menu->setValue(array($html->link(__('List Webpage', true), array('controller' => 'webpages', 'action' => 'index'), array('title' => 'List Webpage', 'onclick' => 'Modalbox.show(this.href, {title: this.title, width: 500}); return false;'))));
?>