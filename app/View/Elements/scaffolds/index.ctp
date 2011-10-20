<?php 
# setup defaults
$modelName = !empty($modelName) ? $modelName : Inflector::classify($this->request->params['controller']); // ContactPerson
$pluginName = !empty($pluginName) ? $pluginName : pluginize($modelName); // contacts
$controller = !empty($controller) ? $controller : Inflector::tableize($modelName); // contact_people, projects
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
		$galleryForeignKeyField = !empty($galleryForeignKey) ? $galleryForeignKey : 'user_id';
		$galleryThumbSize = !empty($settings['galleryThumbSize']) ? $settings['galleryThumbSize'] : 'medium';
	endif;
?>

<div class="<?php echo $controller; ?> index">
  <div class="indexContainer">
    <?php
$i = 0;
foreach ($data as $dat):
	#this value needs to be set here in case we unset it a few lines after.
	$galleryForeignKey = !empty($showGallery) ? $dat[$galleryModelAlias][$galleryForeignKeyField] : null;
	$displayId = !empty($displayId) ? $displayId : 'id';
	$id = !empty($dat[$modelName][$displayId]) ? $dat[$modelName][$displayId] : null;
	unset($dat[$modelName][$displayId]);
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
      <div class="indexCell image"> <span> <?php echo !empty($showGallery) ? $this->Element('thumb', array('model' => $galleryModelName, 'foreignKey' => $galleryForeignKey, 'showDefault' => 'false', 'thumbSize' => $galleryThumbSize, 'thumbLink' => '/'.$link['pluginName'].'/'.$link['controllerName'].'/'.$link['actionName'].'/'.$galleryForeignKey), array('plugin' => 'galleries')) : null; ?> </span> </div>
      <div class="indexCell">
        <div class="indexCell">
          <div class="recorddat">
            <h3> <?php echo $this->Html->link($name, array('plugin' => $link['pluginName'], 'controller' => $link['controllerName'], 'action' => $link['actionName'], $id), array('escape' => false)); ?></h3>
          </div>
        </div>
        <div class="indexCell">
          <ul class="metaData">
            <?php foreach($dat[$modelName] as $keyName => $keyValue) : 
			# this is for support of a third level deep of contain (anything beyond this is just too much for a scaffold!!!)
			$_keyName = $keyName;
			$humanKeyName = Inflector::humanize(str_replace('_id', '', $keyName)); 
			$keyName = str_replace(' ', '', Inflector::humanize(str_replace('_id', '', $keyName))); 
       		if(strpos($_keyName, '_') && !empty($dat[$modelName][str_replace(' ', '', $keyName)]) && is_array($dat[$modelName][str_replace(' ', '', $keyName)])) :  
			else :
			# over write the keyValue if its belongsTo associated record to display (ie. assignee_id = full_name)
			if (!empty($associations) && array_key_exists($keyName, $associations)) :
				$displayField = $associations[Inflector::humanize(str_replace('_id', '', $keyName))]['displayField'];
				# this is for support of a third level deep of contain (anything beyond this is just too much for a scaffold!!!)
				$keyValue = !empty($dat[$modelName][$keyName][$displayField]) && is_array($dat[$modelName][$keyName]) ? 
						$dat[$modelName][$keyName][$displayField] : 
						(!empty($dat[$keyName][$displayField]) ? $dat[$keyName][$displayField] : null); 
			endif;
			$keyName = Inflector::humanize($keyName);
			# if its a date parse it into words
			if ($keyValue == date('Y-m-d h:i:s', strtotime($keyValue)) || $keyValue == date('Y-m-d', strtotime($keyValue))) : $keyValue = $this->Time->timeAgoInWords($keyValue); endif; // human readable dates 
			?>
            <li><span class="metaDataLabel"> <?php echo $keyName.' : '; ?></span><span class="metaDataDetail edit" name="<?php echo $keyName; ?>" id="<?php echo $id; ?>"><?php echo $keyValue; ?></span></li>
            <?php endif; ?>
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
        <div class="indexCell">
          <div class="drop-holder indexDrop actions">
            <ul class="drop">
              <?php if(!empty($actions) && is_array($actions)) : foreach ($actions as $action) : ?>
              <li>
                <?php $patterns = array('/{/', '/}/', '/\[/', '/\]/'); $replaces = array('\'.$', '.\'', '[\'', '\']'); $action = 'echo \''.preg_replace($patterns, $replaces, $action).'\';'; eval($action); ?>
              </li>
              <?php endforeach; else: ?>
              <li><?php echo $this->Html->link('View', array('plugin' => $link['pluginName'], 'controller' => $link['controllerName'], 'action' => $link['actionName'], $id)); ?></li>
              <li><?php echo $this->Html->link('Edit', array('plugin' => $link['pluginName'], 'controller' => $link['controllerName'], 'action' => 'edit', $id)); ?></li>
              <li><?php echo $this->Html->link('Delete', array('plugin' => $link['pluginName'], 'controller' => $link['controllerName'], 'action' => 'delete', $id), array(), 'Are you sure you want to delete "'.strip_tags($name).'"'); ?></li>
              <?php endif; ?>
            </ul>
          </div>
        </div>
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
<div id="<?php echo $modelName; ?>Actions" class="index actions">
  <ul class="drop">
    <li class="actionHeading"><?php echo __('Sort by');?></li>
    <?php foreach ($data[0][$modelName] as $keyName => $keyValue) :  
	   if ($keyName != 'id' && $keyName != 'displayName' && $keyName != 'displayDescription') : ?>
    <li class="actionItem"><?php echo $this->Paginator->sort($keyName);?></li>
    <?php endif; endforeach; ?>
    <?php if (!empty($pageActions)) : ?>
    <li class="actionHeading"><?php echo __('Action'); ?></li>
    <?php foreach ($pageActions as $pageAction) : ?>
    <li class="actionItem"><?php echo $this->Html->link($pageAction['linkText'], $pageAction['linkUrl']); ?></li>
    <?php endforeach; else : ?>
    <li class="actionHeading"><?php echo __('Action'); ?></li>
    <li class="actionItem"><?php echo $this->Html->link(' Add ', array('plugin' => $pluginName, 'controller' => $controller, 'action' => 'add')); ?></li>
    <?php endif; ?>
  </ul>
</div>
<?php echo $this->Element('paging'); ?> <?php echo $this->Element('ajax_edit',  array('editFields' => $editFields)); ?>
<?php 
else : // show a default message pulled as an element called start, from the plugin folder you're in.
?>
<div class="index noItems"> <?php echo empty($noItems) ? $this->Element('start',  array('plugin' => $pluginName)) : $noItems; ?>
  <div class="actions">
    <ul class="drop">
      <li class="actionItem"><?php echo $this->Html->link('Add '.$modelName, array('plugin' => $pluginName, 'controller' => $controller, 'action' => 'add')); ?></li>
    </ul>
  </div>
</div>
<?php
endif;
?>
