<?php 
if (!empty($data)) : 
	# setup defaults
	$modelName = !empty($modelName) ? $modelName : Inflector::classify($this->params['controller']); // ContactPerson
	$pluginName = !empty($pluginName) ? $pluginName : !empty($this->params['plugin']) ? $this->params['plugin'] : null; // contacts
	$controller = $this->params['controller']; // contact_people, projects
	$indexVar = Inflector::variable($this->params['controller']); // contactPeople, projects
	$humanModel = Inflector::humanize(Inflector::underscore($modelName)); // Contact Person
	$humanCtrl = Inflector::humanize(Inflector::underscore($controller)); // Contact People
	$galleryThumbSize = !empty($settings['galleryThumbSize']) ? $settings['galleryThumbSize'] : 'medium';
?>

<div class="projects index">
  <div class="drop-holder pageDrop"> <img src="/img/admin/btn-down.png" />
    <ul class="drop">
      <li><?php echo __('Sort by');?></li>
      <?php foreach ($data[0][$modelName] as $keyName => $keyValue) :  
	   # unset these vars, because they are for scaffolding only
	   if ($keyName != 'id' && $keyName != 'displayName' && $keyName != 'displayDescription') : ?>
      <li><?php echo $paginator->sort($keyName);?></li>
      <?php endif; endforeach; ?>
    </ul>
  </div>
  <div class="indexContainer">
    <?php
$i = 0;
foreach ($data as $dat):
	$id = $dat[$modelName]['id'];
	unset($dat[$modelName]['id']);
	$name = $dat[$modelName][$displayName];
	unset($dat[$modelName][$displayName]);
	$description = $dat[$modelName][$displayDescription];
	unset($dat[$modelName][$displayDescription]);
	
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' altrow';
	}
?>
    <div class="indexRow <?php echo $class;?>" id="row<?php echo $id; ?>">
      <div class="indexCell image"> <span>
        <!-- Gallery Thumb img src="/img/admin/img01.jpg" alt="image description" /-->
        </span>
        <div class="drop-holder indexDrop"> <span><img src="/img/admin/btn-down.png" /></span>
          <ul class="drop">
            <li><?php echo $html->link('View', array('plugin' => $pluginName, 'controller' => $controller, 'action' => 'view', $id)); ?></li>
            <li><?php echo $html->link('Edit', array('plugin' => $pluginName, 'controller' => $controller, 'action' => 'edit', $id)); ?></li>
            <li><?php echo $html->link('Delete', array('plugin' => $pluginName, 'controller' => $controller, 'action' => 'delete', $id), array(), 'Are you sure you want to delete "'.strip_tags($name).'"'); ?></li>
          </ul>
        </div>
      </div>
      <div class="indexCell">
        <div class="indexCell">
          <div class="recorddat">
            <h3>
              <?php echo $html->link($name, array('action' => 'view', $id), array('escape' => false)); ?></h3>
          </div>
        </div>
        <div class="indexCell">
          <ul class="metaData">
          	<?php foreach($dat[$modelName] as $keyName => $keyValue) : ?>
            <?php if (strtotime($keyValue)) : $keyValue = $time->timeAgoInWords($keyValue); endif; // human readable dates ?>
            <li><span class="metaDataLabel"> <?php echo Inflector::humanize($keyName).' : '; ?></span><span class="metaDataDetail edit" name="<?php echo $keyName; ?>" id="<?php echo $id; ?>"><?php echo $keyValue; ?></span></li>
            <?php endforeach; ?>
          </ul>
        </div>
        <div class="indexCell">
          <div class="recorddat">
            <div class="truncate">
            <span name="<?php echo $displayDescription; ?>" class="edit" id="<?php echo $id; ?>"><?php echo $description; ?></span>
            </div>
          </div>
        </div>
      </div>
    </div>
    <?php
  # used for ajax editing
  # needs to be here because it hsa to be before the forech ends
  $editFields[] =  array(
	'name' => $displayDescription,
	'tagId' => $id,
	'plugin' => $pluginName,
	'controller' => $controller,
	'fieldId' => 'data['.$modelName.'][id]',
	'fieldName' => 'data['.$modelName.']['.$displayDescription.']',
	'type' => 'text'
	);
  foreach($dat[$modelName] as $keyName => $keyValue) :
	  $editFields[] =  array(
		'name' => $keyName,
		'tagId' => $id,
		'plugin' => $pluginName,
		'controller' => $controller,
		'fieldId' => 'data['.$modelName.'][id]',
		'fieldName' => 'data['.$modelName.']['.$keyName.']',
		'type' => 'text'  
		);
	endforeach;
endforeach;
?>
  </div>
</div>
<?php echo $this->Element('paging'); ?> 
<?php echo $this->Element('ajax_edit',  array('editFields' => $editFields)); ?>
<?php 
else : 
	echo $this->Element('start',  array('plugin' => $pluginName));
endif;
?>
