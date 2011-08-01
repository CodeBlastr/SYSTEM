<?php 
# setup defaults
$modelName = !empty($modelName) ? $modelName : Inflector::classify($this->params['controller']); // ContactPerson
$pluginName = !empty($pluginName) ? $pluginName : !empty($modelName) ? pluginize($modelName) : null; // contacts
$controller = Inflector::tableize($modelName); // contact_people, projects
if (!empty($data)) : 
	# setup defaults
	$indexVar = Inflector::variable($controller); // contactPeople, projects
	$humanModel = Inflector::humanize(Inflector::underscore($modelName)); // Contact Person
	$humanCtrl = Inflector::humanize(Inflector::underscore($controller)); // Contact People
	$link['pluginName'] = !empty($link['pluginName']) ? $link['pluginName'] : $pluginName;
	$link['controllerName'] = !empty($link['controllerName']) ? $link['controllerName'] : $controller;
	$link['actionName'] = !empty($link['actionName']) ? $link['actionName'] : 'view';
	if (!empty($showGallery)) : 
		$galleryModel = !empty($galleryModel) ? $galleryModel : $modelName;
		$galleryModelName = is_array($galleryModel) ? $galleryModel['name'] : $galleryModel;
		$galleryModelAlias = is_array($galleryModel) ? $galleryModel['alias'] : $galleryModel;
		$galleryForeignKey = !empty($galleryForeignKey) ? $galleryForeignKey : 'user_id';
		$galleryThumbSize = !empty($settings['galleryThumbSize']) ? $settings['galleryThumbSize'] : 'medium';
	endif;
?>

<div class="<?php echo $controller; ?> index">
  <div class="indexContainer">
    <?php
$i = 0;
foreach ($data as $dat):
	$id = !empty($dat[$modelName]['id']) ? $dat[$modelName]['id'] : null;
	unset($dat[$modelName]['id']);
	$name = !empty($dat[$modelName][$displayName]) ? $dat[$modelName][$displayName] : null;
	unset($dat[$modelName][$displayName]);
	$description = !empty($dat[$modelName][$displayDescription]) ? $dat[$modelName][$displayDescription] : null;
	unset($dat[$modelName][$displayDescription]);
	
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' altrow';
	}
?>
    <div class="indexRow <?php echo $class;?>" id="row<?php echo $id; ?>">
      <div class="indexCell image"> <span>
        <?php echo !empty($showGallery) ? $this->Element('thumb', array('plugin' => 'galleries', 'model' => $galleryModelName, 'foreignKey' => $dat[$galleryModelAlias][$galleryForeignKey], 'showDefault' => 'false', 'thumbSize' => $galleryThumbSize, 'thumbLink' => '/'.$link['pluginName'].'/'.$link['controllerName'].'/'.$link['actionName'].'/'.$dat[$galleryModelAlias][$galleryForeignKey])) : null; ?>
        </span>
        <div class="drop-holder indexDrop"> <span><img src="/img/admin/btn-down.png" /></span>
          <ul class="drop">
          	<?php if(!empty($actions)) : foreach ($actions as $action) : ?>
            <li><?php $patterns = array('/{/', '/}/', '/\[/', '/\]/'); $replaces = array('\'.$', '.\'', '[\'', '\']'); $action = 'echo \''.preg_replace($patterns, $replaces, $action).'\';'; eval($action); ?></li>
            <?php endforeach; else: ?>
            <li><?php echo $html->link('View', array('plugin' => $link['pluginName'], 'controller' => $link['controllerName'], 'action' => $link['actionName'], $id)); ?></li>
            <li><?php echo $html->link('Edit', array('plugin' => $link['pluginName'], 'controller' => $link['controllerName'], 'action' => 'edit', $id)); ?></li>
            <li><?php echo $html->link('Delete', array('plugin' => $link['pluginName'], 'controller' => $link['controllerName'], 'action' => 'delete', $id), array(), 'Are you sure you want to delete "'.strip_tags($name).'"'); ?></li> 
			<?php endif; ?>
          </ul>
        </div>
      </div>
      <div class="indexCell">
        <div class="indexCell">
          <div class="recorddat">
            <h3> <?php echo $html->link($name, array('plugin' => $link['pluginName'], 'controller' => $link['controllerName'], 'action' => $link['actionName'], $id), array('escape' => false)); ?></h3>
          </div>
        </div>
        <div class="indexCell">
          <ul class="metaData">
            <?php foreach($dat[$modelName] as $keyName => $keyValue) : 
			# over write the keyValue if its belongsTo associated record to display (ie. assignee_id = full_name)
			if (!empty($associations) && array_key_exists(Inflector::humanize(str_replace('_id', '', $keyName)), $associations)) :
				$displayField = $associations[Inflector::humanize(str_replace('_id', '', $keyName))]['displayField'];
				$keyName = Inflector::humanize(str_replace('_id', '', $keyName));
				$keyValue = $dat[Inflector::humanize(str_replace('_id', '', $keyName))][$displayField]; 
			else : 
				$keyName = Inflector::humanize($keyName);
			endif;
			# if its a date parse it into words
			if (strtotime($keyValue)) : $keyValue = $time->timeAgoInWords($keyValue); endif; // human readable dates 
			?>
            <li><span class="metaDataLabel"> <?php echo $keyName.' : '; ?></span><span class="metaDataDetail edit" name="<?php echo $keyName; ?>" id="<?php echo $id; ?>"><?php echo $keyValue; ?></span></li>
            <?php endforeach; ?>
          </ul>
        </div>
        <?php if (!empty($displayDescription)) : ?>
        <div class="indexCell">
          <div class="recorddat">
            <div class="truncate"> <span name="<?php echo $displayDescription; ?>" class="edit" id="<?php echo $id; ?>"><?php echo $description; ?></span> </div>
          </div>
        </div>
        <?php endif; ?>
      </div>
    </div>
    <?php
  # used for ajax editing
  # needs to be here because it has to be before the forech ends
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
<div class="actions"> <img src="/img/admin/btn-down.png" />
  <ul class="drop">
    <li><?php echo __('Sort by');?></li>
    <?php foreach ($data[0][$modelName] as $keyName => $keyValue) :  
	   # unset these vars, because they are for scaffolding only
	   if ($keyName != 'id' && $keyName != 'displayName' && $keyName != 'displayDescription') : ?>
    <li><?php echo $paginator->sort($keyName);?></li>
    <?php endif; endforeach; ?>
    <li><?php echo __('Action'); ?></li>
    <li><?php echo $this->Html->link('Add '.$modelName, array('plugin' => $pluginName, 'controller' => $controller, 'action' => 'add')); ?></li>
  </ul>
</div>
<?php echo $this->Element('paging'); ?> <?php echo $this->Element('ajax_edit',  array('editFields' => $editFields)); ?>
<?php 
else : // show a default message pulled as an element called start, from the plugin folder you're in.
?>
<div class="index noItems">
	<?php echo empty($noItems) ? $this->Element('start',  array('plugin' => $pluginName)) : $noItems; ?>
	<div class="actions"> <img src="/img/admin/btn-down.png" />
	  <ul class="drop">
	    <li><?php echo $this->Html->link('Add '.$modelName, array('plugin' => $pluginName, 'controller' => $controller, 'action' => 'add')); ?></li>
	  </ul>
	</div>
</div>
<?php
endif;
?>
