<?php 
# setup defaults
$indexCount = empty($indexCount) ? 1 : $indexCount;
$modelName = !empty($modelName) ? $modelName : Inflector::classify($this->request->params['controller']); // ContactPerson
$pluginName = !empty($pluginName) ? $pluginName : ZuhaInflector::pluginize($modelName); // contacts
$controller = !empty($controller) ? $controller : Inflector::tableize($modelName); // contact_people, projects
$indexClass = !empty($indexClass) ? $indexClass : null; // collapsed value will reduce it to headlines only by default
if (!empty($data)) { 
	# setup defaults
	$indexVar = Inflector::variable($controller); // contactPeople, projects
	$humanModel = Inflector::humanize(Inflector::underscore($modelName)); // Contact Person
	$humanCtrl = Inflector::humanize(Inflector::underscore($controller)); // Contact People
	if (!empty($showGallery)) { 
		$galleryModel = !empty($galleryModel) ? $galleryModel : $modelName;
		$galleryModelName = is_array($galleryModel) && !empty($galleryModel['name']) ? $galleryModel['name'] : $galleryModel;
		$galleryModelAlias = is_array($galleryModel) && !empty($galleryModel['alias']) ? $galleryModel['alias'] : $galleryModel;
		$galleryModelField = is_array($galleryModel) && !empty($galleryModel['field']) ? $galleryModel['field'] : null;
		$galleryForeignKeyField = !empty($galleryForeignKey) ? $galleryForeignKey : 'user_id';
		$galleryThumbSize = !empty($settings['galleryThumbSize']) ? $settings['galleryThumbSize'] : 'medium';
	}
?>

<div id="<?php echo $modelName . $indexCount; ?>" class="<?php echo $controller; ?> index">
  <div class="indexContainer <?php echo $indexClass; ?>">
    <?php
$i = 0;
foreach ($data as $dat) {
	# individual record defaults
	if (!empty($showGallery)) { 
		$galleryForeignKey = !empty($showGallery) ? $dat[$galleryModelAlias][$galleryForeignKeyField] : null;
		$galleryModelName = !empty($galleryModelField) ? $dat[$galleryModelAlias][$galleryModelField] : $galleryModelName;
	}
	$displayId = !empty($displayId) ? $displayId : 'id';
	$id = !empty($dat[$modelName][$displayId]) ? $dat[$modelName][$displayId] : null;
	unset($dat[$modelName][$displayId]);
	
	# name can be a field_name or a Model.field_name format
	$nameModel = strpos($displayName, '.') ? substr($displayName, 0, strpos($displayName, '.')) : $modelName;
	$displayNameField = strpos($displayName, '.') ? substr($displayName, strpos($displayName, '.') + 1) : $displayName;
	$name = !empty($dat[$nameModel][$displayNameField]) ? $dat[$nameModel][$displayNameField] : null;
	unset($dat[$nameModel][$displayNameField]);
	
	# description can be a field_name or a Model.field_name format
	$descriptionModel = strpos($displayDescription, '.') ? substr($displayDescription, 0, strpos($displayDescription, '.')) : $modelName;
	$displayDescriptionField = strpos($displayDescription, '.') ? substr($displayDescription, strpos($displayDescription, '.') + 1) : $displayDescription;
	$description = !empty($dat[$descriptionModel][$displayDescriptionField]) ? $dat[$descriptionModel][$displayDescriptionField] : null;
	unset($dat[$descriptionModel][$displayDescriptionField]);
	
	extract($dat[$modelName]); // this allows us to access fields from the view page with {var} as a tag
	$link['pluginName'] = !empty($link['pluginName']) ? $link['pluginName'] : $pluginName;
	$link['controllerName'] = !empty($link['controllerName']) ? $link['controllerName'] : $controller;
	$link['actionName'] = !empty($link['actionName']) ? $link['actionName'] : 'view';
	$linkPass = !empty($link['pass']) ? preg_replace('/\{([a-zA-Z_]+)\}/e', "$$1", $link['pass']) : array($id); 
	$viewUrl = array('plugin' => strtolower($link['pluginName']), 'controller' => $link['controllerName'], 'action' => $link['actionName']) + $linkPass;
	$viewUrlOptions = !empty($linkOptions) ? $linkOptions : array();
	
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' altrow';
	}
?>
    <div class="indexRow <?php echo $class;?>" id="row<?php echo $id; ?>">
      <div class="indexCell imageCell"> <span><?php echo !empty($showGallery) ? $this->Element('thumb', array('model' => $galleryModelName, 'foreignKey' => $galleryForeignKey, 'showDefault' => 'false', 'thumbSize' => $galleryThumbSize, 'thumbLink' => $viewUrl, 'thumbLinkOptions' => $viewUrlOptions), array('plugin' => 'galleries')) : null; ?> </span> </div>
      <div class="indexCell metaCell">
        <ul class="metaData">
          <?php 
		  foreach($dat[$modelName] as $keyName => $keyValue) {
			# this is for support of a third level deep of contain (anything beyond this is just too much for a scaffold!!!)
			$_keyName = $keyName;
			$humanKeyName = Inflector::humanize(str_replace('_id', '', $keyName)); 
			$keyName = str_replace(' ', '', Inflector::humanize(str_replace('_id', '', $keyName))); 
       		if(strpos($_keyName, '_') && !empty($dat[$modelName][str_replace(' ', '', $keyName)]) && is_array($dat[$modelName][str_replace(' ', '', $keyName)])) { 
				
			} else {
				# over write the keyValue if its belongsTo associated record to display (ie. assignee_id = full_name)
				if (!empty($associations) && array_key_exists($keyName, $associations)) {
					$displayField = $associations[Inflector::humanize(str_replace('_id', '', $keyName))]['displayField'];
					# this is for support of a third level deep of contain (anything beyond this is just too much for a scaffold!!!)
					$keyValue = !empty($dat[$modelName][$keyName][$displayField]) && is_array($dat[$modelName][$keyName]) ? 
						$dat[$modelName][$keyName][$displayField] : 
						(!empty($dat[$keyName][$displayField]) ? $dat[$keyName][$displayField] : null); 
				}
				# if its a date parse it into words
				$keyDate = strtotime($keyValue);
				if (!empty($keyDate)) {
					$keyValue = $this->Time->timeAgoInWords($keyValue); 
				} // human readable dates ?>
         	<li class="metaDataLi <?php echo $keyName; ?>"><span class="metaDataLabel <?php echo $keyName; ?>"> <?php echo Inflector::humanize(Inflector::underscore($keyName)).' : '; ?></span><span class="metaDataDetail" name="<?php echo $keyName; ?>" id="<?php echo $id; ?>"><?php echo $keyValue; ?></span></li>
          <?php 
			}
		  } // end metadata loop ?>
        </ul>
      </div>
      <div class="indexCell indexData">
        <div class="indexCell titleCell">
          <div class="recorddat">
            <h3> <?php echo $this->Html->link($name, $viewUrl, array_merge($viewUrlOptions + array('escape' => false))); ?></h3>
          </div>
        </div>
        <?php if (!empty($displayDescription)) { ?>
        <div class="indexCell descriptionCell">
          <div class="recorddat">
            <div class="truncate"> <span name="<?php echo $displayDescription; ?>" id="<?php echo $id; ?>"><?php echo strip_tags($description); ?></span> </div>
          </div>
        </div>
        <?php } 
	  	if (isset($actions) && $actions === false) {
		  # show nothing 
		} else { ?>
        <div class="indexCell actionCell">
          <div class="drop-holder indexDrop actions">
            <ul class="drop">
              <?php
			  if(!empty($actions) && is_array($actions)) {
				  foreach ($actions as $action) { ?>
		              <li><?php $patterns = array('{', '}', '[', ']'); $replaces = array('\'.$', '.\'', '[\'', '\']'); $action = 'echo \''.str_replace($patterns, $replaces, urldecode($action)).'\';'; eval($action); ?></li>
              <?php
				  }
			  } else { ?>
		      	  <li><?php echo $this->Html->link('View', $viewUrl); ?></li>
        		  <li><?php echo $this->Html->link('Edit', array('plugin' => strtolower($link['pluginName']), 'controller' => $link['controllerName'], 'action' => 'edit', $id)); ?></li>
              	  <li><?php echo $this->Html->link('Delete', array('plugin' => strtolower($link['pluginName']), 'controller' => $link['controllerName'], 'action' => 'delete', $id), array(), 'Are you sure you want to delete "'.strip_tags($name).'"'); ?></li>
              <?php
			  } ?>
            </ul>
          </div>
        </div>
        <?php 
		} // end actions false check ?>
      </div>
    </div>
    <?php
	/* used for ajax editing
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
	foreach($dat[$modelName] as $keyName => $keyValue) {
		$editFields[] =  array(
			'name' => $keyName,
			'tagId' => $id,
			'plugin' => $pluginName,
			'controller' => $controller,
			'fieldId' => 'data['.$modelName.'][id]',
			'fieldName' => 'data['.$modelName.']['.$keyName.']',
			'type' => 'text'  
			);
	}*/
} // end individual data items loop ?>
  </div>
  <?php 
  echo $this->Element('paging'); ?>
</div>






<?php 
/* these are pagination sorting links and should not be compbined with action links (make a drop down or something) 
<div id="<?php echo $modelName; ?>Actions" class="index actions">
  <ul class="drop">
    <li class="actionHeading"><?php echo __('Sort by');?></li>
    <?php foreach ($data[0][$modelName] as $keyName => $keyValue) :  
	   if ($keyName != 'id' && $keyName != 'displayName' && $keyName != 'displayDescription') : ?>
    <li class="actionItem"><?php echo $this->Paginator->sort($keyName, array(), array('class' => 'sort'));?></li>
    <?php endif; endforeach; ?>
  </ul>
</div> */ 

	if (!empty($pageActions)) {
		foreach ($pageActions as $pageAction) { 
			$pageActionLinks[] = $this->Html->link($pageAction['linkText'], $pageAction['linkUrl']);
		} // end pageAction loop
	}  // end pageActions 


# echo $this->Element('ajax_edit',  array('editFields' => $editFields)); 
} else {
# Don't show anything rom the index, show a default message  
# pulled as an element called start, from the plugin folder you're in. ?>
<div id="<?php echo $modelName . $indexCount; ?>" class="index noItems">
	<?php
	$startElement = !empty($startElement) ? $startElement : 'start';
	echo $this->Element($startElement, array(), array('plugin' => $pluginName));
	if (empty($indexOnThisPage)) { 
 		$pageActionLinks[] = $this->Html->link('Add', array('plugin' => strtolower($pluginName), 'controller' => $controller, 'action' => 'add'), array('class' => 'add')); 
	} ?>
</div>
<?php
} 

$pageActionLinks[] = $this->Html->link(' Add ', array('plugin' => strtolower($pluginName), 'controller' => $controller, 'action' => 'add'), array('class' => 'add'));
// set the contextual menu items
$this->set('context_menu', array('menus' => array(
	array(
		'heading' => $modelName,
		'items' => $pageActionLinks,
		),
	))); 
$this->set('indexOnThisPage', true);  // used when there is more than one index on the page calling this element. This variable keeps it the actions from the second index element from over writing the first index element actions. ?>
