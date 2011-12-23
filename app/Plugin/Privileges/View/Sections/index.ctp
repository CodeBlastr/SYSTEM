<div class="privileges index">
<?php echo $this->Html->css('/privileges/css/privileges', null, array('inline' => false)); ?>
<h2><?php echo __('Privileges', true); ?></h2>
<?php foreach($data as $ac):?>
<?php 
	$ac["Section"]["type"]  = 'plugin'; // temporary (breaks core controllers)
	switch ($ac["Section"]["type"]){
		case 'plugin':
			$action = 'view_plugin';
			$class = 'acl_plugin';
		break;
		
		case 'controller':
			$action = 'view_controller';
			$class = 'acl_controller';
		break;
	}
	if($ac["Section"]["type"] != 'plugin'):
?>
	  <ul>
	      <li>
		  	<?php $name = Inflector::humanize(Inflector::underscore($ac["Section"]["alias"])); ?>
		  	<?php echo $this->Html->link($name, array('plugin'=>'privileges' , 'controller'=>'sections' , 'action'=>'view_plugin', $ac["Section"]["id"]), array('class' => 'toggleClick', 'name' => 'controller'.$ac["Section"]["id"]))?>
            <ul style="display: none;" id="<?php echo 'controller'.$ac["Section"]["id"]; ?>">
            	<li>
  					<?php $name = Inflector::humanize(Inflector::underscore($ac["Section"]["alias"])); ?>
		  			<?php echo $this->Html->link($name, array('plugin' => 'privileges', 'controller' => 'sections', 'action' => 'view_plugin', $ac["Section"]["id"]), array('class' => 'button'))?>
                </li>
        		<li>
					<?php echo $this->Form->create('Section', array('action' => 'add'));?>
					<?php echo $this->Form->input('parent_id', array('type' => 'hidden', 'value' => 1))?>
					<?php echo $this->Form->input('type' , array('type' => 'hidden', 'value' => 'controller'));?>
					<?php echo $this->Form->input('alias', array('type' => 'hidden', 'value' => $ac["Section"]["alias"]))?>
					<?php echo $this->Form->input('controller', array('type' => 'hidden', 'value' => $ac["Section"]["alias"]))?>
					<?php echo $this->Form->end('Update ' . $ac["Section"]["alias"] . ' Actions');?>
	            </li>
             </ul>
      	  </li>
      </ul>
<?php else : // ends plugin check ?>
  	  <ul>
      	<li>
  			<?php $name = Inflector::humanize(Inflector::underscore($ac["Section"]["alias"])); ?>
			<?php echo $this->Html->link($name, array(), array('class' => 'toggleClick', 'name' => 'plugin'.$ac["Section"]["alias"])); ?>
  <?php if (isset($ac["Controller"])): ?>
      	<ul style="display: none;" id="<?php echo 'plugin'.$ac["Section"]["alias"]; ?>">
  		<?php foreach($ac["Controller"] as $c):?>
  				<li>
  					<?php $name = Inflector::humanize(Inflector::underscore($c["Section"]["alias"])); ?>
    				<?php echo $this->Html->link($name, array('plugin' => 'privileges', 'controller' => 'sections', 'action'=> 'view_plugin', $c["Section"]["id"]), array('class' => 'button'))?>
 				</li>
  		<?php endforeach;?>
        		<li>
					<?php echo $this->Form->create('Section', array('action' => 'add'));?>
					<?php echo $this->Form->input('parent_id', array('type' => 'hidden', 'value' => 1))?>
					<?php echo $this->Form->input('type' , array('type' => 'hidden', 'value' => 'controller'));?>
					<?php echo $this->Form->input('alias', array('type' => 'hidden', 'value' => $ac["Controller"][0]["Section"]["alias"]))?>
					<?php echo $this->Form->input('plugin', array('type' => 'hidden', 'value' => $ac["Controller"][0]["Section"]["alias"]))?>
					<?php echo $this->Form->end('Update ' . $ac["Controller"][0]["Section"]["alias"] . ' Actions');?>
	            </li>
    	    </ul>
  <?php endif;?>
         </li>
      </ul>
 <?php endif; // ends plugin check  ?>
<?php endforeach;?>
</div>


<?php
// set the contextual menu items
$this->set('context_menu', array('menus' => array(
	array(
		'heading' => 'Actions',
		'items' => array(
			$this->Html->link(__('Update Available Sections', true), array('plugin' => 'privileges', 'controller' => 'sections', 'action' => 'clear_session')),
			)
		),
	)));
?>

<script type="text/javascript">
$("form").submit(function() {
	window.confirm("Warning, this could take more than 20 minutes.");
});
</script>



