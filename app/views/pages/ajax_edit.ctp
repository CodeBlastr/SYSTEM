<div class="form">
<?php echo $ajax->form('edit', 'post', array('model' => $model,'url' => array( 'controller' => $controller, 'action' => 'ajax_edit'),'update' => 'MB_content', 'complete' => 'Modalbox.hide(); location.reload(true);'));?>
	<fieldset>
 		<legend><?php __('Add '.$model);?></legend>
	<?php
		foreach ($fields as $field) :
				//select fields
				if (strstr($field, 'type_id')):
					echo $form->input($field, array('after' =>  ' '.$html->link(__('Edit', true), array('controller' => str_replace('_id','s',$field), 'action' => 'index'))));
				//hidden fields
				elseif(isset($this->params['named'][$field])): 
					echo $form->hidden($field, array('value' => $this->params['named'][$field]));
				// text type fields
				else : 
					echo $form->input($field); 
				endif;			
		endforeach;
	?>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>