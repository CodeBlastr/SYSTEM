<?php
/**
 * Job Admin Add View
 *
 * PHP versions 5
 *
 * Zuha(tm) : Business Management Applications (http://zuha.com)
 * Copyright 2009-2012, Zuha Foundation Inc. (http://zuhafoundation.org)
 *
 * Licensed under GPL v3 License
 * Must retain the above copyright notice and release modifications publicly.
 *
 * @copyright     Copyright 2009-2012, Zuha Foundation Inc. (http://zuha.com)
 * @link          http://zuha.com Zuha� Project
 * @package       zuha
 * @subpackage    zuha.app.plugins.products.views
 * @since         Zuha(tm) v 0.0.1
 * @license       GPL v3 License (http://www.gnu.org/licenses/gpl.html) and Future Versions
 */
 ?>
<div class="jobUpdate form">
	<?php echo $this->Form->create('Job'); ?>
    <div class="hero-unit pull-right span3">
    <?php
    echo $this->Element('gallery', array('model' => 'Job', 'foreignKey' => $this->request->data['Job']['id']), array('plugin' => 'galleries'));
    echo $this->Html->link('Edit Gallery', array('plugin' => 'galleries', 'controller' => 'galleries', 'action' => 'edit', 'Job', $this->request->data['Job']['id'])); ?>
</div>
    <fieldset>
    	<?php
        echo $this->Form->input('Job.id'); 
        echo $this->Form->input('Job.title', array('label' => 'Job Title')); 
		echo $this->Form->input('Job.description', array('label' => 'Job Description'));
        echo $this->Form->input('Job.budget', array('label' => 'Job Budget')); 
        echo $this->Form->input('Job.status', array('label' => 'Job Status')); 
        echo $this->Form->input('Job.!acreage', array('label' => 'Their Lawn Area (eg. 1200 sq.ft, 50 feet)')); 
        echo $this->Form->input('Job.!address', array('label' => 'Address')); 
        echo $this->Form->input('Job.!city', array('label' => 'City')); 
        echo $this->Form->input('Job.!state', array('label' => 'State')); 
       	?>
    </fieldset>
   <fieldset> 
         <legend class="toggleClick"><?php echo __d('jobs', 'Does this job belong to a category?');?></legend>
            <?php echo $this->Form->input('Category', array('multiple' => 'checkbox', 'label' => 'Which categories? ('.$this->Html->link('add', array('plugin' => 'categories', 'controller' => 'categories', 'action' => 'tree')).' / '.$this->Html->link('edit', array('plugin' => 'categories', 'controller' => 'categories', 'action' => 'tree')).' categoies)')); ?>
    </fieldset>
	<?php
    echo $this->Form->end('Submit');
	?>

<?php
// set the contextual menu items
$this->set('context_menu', array('menus' => array(
	array(
		'heading' => 'Jobs',
    	'items' => array(
			$this->Html->link(__('Lists'), array('controller' => 'jobs', 'action' => 'index')),
            
		)
		),
	)));
?>

<script type="text/javascript">

$('#addCat').click(function(e){
    e.preventDefault();
    $('#anotherCategory').show();
});



</script>

</div>