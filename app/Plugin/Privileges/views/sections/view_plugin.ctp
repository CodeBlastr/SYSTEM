<?php echo $this->Html->css('/privileges/css/privileges'); ?>
<h2><?php echo __(Inflector::humanize(Inflector::underscore($section)) . ' Privileges', true); ?></h2>
<p><?php __('Set privileges by checking the box under the user role in the row of the action you want to allow access to.') ?></p>
<p class="toggleClick" name="SectionAddForm"> <a href="">Do the actions you want to set privileges for not appear here</a>?</p>
<!--p><?php echo __('Please note, if you do not see the method you are trying to control access to, use the following button to auto update. You can also ' . $this->Html->link(__('view all', true), array('action' => 'index')) . ' and ' . $this->Html->link(__('manage user roles', true), array('plugin' => null, 'controller' => 'user_roles', 'action' => 'index')), true); ?></p-->

<?php echo $this->Form->create('Section', array('action' => 'add', 'class' => 'hide'));?>
<p>Clicking this button will check the latest code in this section and add all available actions/pages to this form.</p>
<?php echo $this->Form->input('parent_id', array('type' => 'hidden', 'value' => 1))?>
<?php echo $this->Form->input('type' , array('type' => 'hidden', 'value' => 'controller'));?>
<?php echo $this->Form->input('alias', array('type' => 'hidden', 'value' => $parent['Section']['alias']))?>
<?php echo $this->Form->input('plugin', array('type' => 'hidden', 'value' => $parent['Section']['alias']))?>
<?php echo $this->Form->end('Update ' . $parent['Section']['alias'] . ' Actions');?>

<?php $group_count = count($groups)?>
<?php echo $form->create('Privilege' , array('url'=> array('plugin'=> 'privileges', 'controller'=> 'privileges', 'action'=> 'add')))?>
<table>
  <tr>
    <th>Action</th>
    <?php foreach($groups as $g):?>
    	<?php if($g["UserRole"]["id"] != 1):?>
    		<th><?php echo $g["UserRole"]["name"]?></th>
    	<?php endif;?>
    <?php endforeach;?> 
    <!--th>Record Level Access (DOES NOT WORK!! -- needs new array piece added to settings (ie. Ticket.view.creator_id;))</th-->
  </tr>
  


<?php foreach($data as $ac):?>
  <tr>
    <td><?php echo $ac['Section']["alias"]?></td>
  	<?php for($i = 0; $i < $group_count; $i++):?>
    			<?php $field_name = $ac["Section"]["id"] . '_' . $groups[$i]["Requestor"]['id'] ?>
    			<?php if(isset($ac["Requestor"][0])):?>
    				<?php if($groups[$i]['UserRole']['id'] != 1):?>
    					<?php 
    						// loop throug Requestors to see if it maches the given group
    						$has_check  = false;
    						for($j = 0 ; $j < count($ac["Requestor"]); $j++){
    							if($ac["Requestor"][$j]['ArosAco']['_create'] == 1 && $ac["Requestor"][$j]['ArosAco']['aro_id'] == $groups[$i]["Requestor"]['id']){
    								$has_check = true;
    							}
    						}
    					
    					?>
		    			<?php if($has_check):?>		
		    				<td><?php echo $form->input($field_name , array('type'=>'checkbox' , 'label'=>'' , 'checked'=>'true'));?></td>
		    			<?php else:?>
		    				<td><?php echo $form->input($field_name , array('type'=>'checkbox' , 'label'=>''));?></td>
		    			<?php endif;?>
		    		<?php endif;?>
	    		<?php else:?>
	    			<?php if($groups[$i]["UserRole"]['id'] != 1):?>
	    				<td><?php echo $form->input($field_name , array('type'=>'checkbox' , 'label'=>''));?></td>
	    			<?php endif;?>
	    		<?php endif;?>
    <?php endfor;?>  
	<!--td>
  		<?php echo $form->input('userFields', array('type' => 'select', 'options' => $userFields, 'multiple' => 'checkbox', 'label' => '', 'div' => false)); ?>
    </td-->
  </tr>
<?php endforeach;?>
</table>
<?php echo $form->end('Update Privileges');?>



<script type="text/javascript">
$("#SectionAddForm").submit(function() {
	alert("Warning, this could take more than 20 minutes.");
});
</script>