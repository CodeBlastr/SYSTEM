<?php 
# setup view vars for reuse 
$modelClass = Inflector::classify($this->request->params['controller']); #ex. ContactPerson
$prefix = (!empty($this->params['prefix']) ? $this->params['prefix'] : null); #admin
$plugin = (!empty($this->request->params['plugin']) ? $this->request->params['plugin'] : null); #contacts
$controller = $this->request->params['controller']; #contact_people
$indexVar = Inflector::variable($this->request->params['controller']); #contactPeople
$humanModel = Inflector::humanize(Inflector::underscore($modelClass)); #Contact Person
$humanCtrl = Inflector::humanize(Inflector::underscore($controller)); #Contact People
$indexData = $___dataForView[$indexVar];
$galleryThumbSize = !empty($settings['galleryThumbSize']) ? $settings['galleryThumbSize'] : 'medium';
?>

<div class="<?php echo $indexVar;?> index">
  <h2><?php echo(!empty($settings['pageHeading']) ? $settings['pageHeading'] : $humanCtrl); ?></h2>
  <p><?php echo $this->Paginator->counter(array('format' => 'Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%')); ?></p>
  <div class="indexContainer">
    <?php if (!empty($indexData)) : ?>
    <div class="indexRow" id="headingRow">
      <?php if (!empty($settings['showGalleryThumb'])) { ?>
      <div class="indexCell columnHeading">Image</div>
      <?php } ?>
      <?php $i = 0; foreach ($settings['fields'] as $_alias): ?>
      <div class="indexCell columnHeading" id="<?php #echo $_modelClass; ?>"><?php echo $this->Paginator->sort($_alias); ?></div>
      <?php $i++; endforeach;?>
      <?php if(!empty($settings['action'])) { ?>
      <div class="indexCell columnHeading" id="columnActions">
        <?php echo __('Actions');?>
      </div>
      <?php } ?>
    </div>
    <?php


$i = -1;
foreach ($indexData as $_modelClass) :
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' altrow';
	}
echo "\n";
  echo "\t<div class=\"indexRow {$class}\">\n";
  
	# show the gallery
	if (!empty($settings['showGalleryThumb'])) :
		echo "\t\t<div class=\"indexCell galleryThumb\">\n";
		echo $this->element('thumb', array('plugin' => 'galleries', 'model' => $_modelClass['Gallery']['model'], 'foreignKey' => $_modelClass['Gallery']['foreign_key'], 'showDefault' => 'false', 'thumbSize' => $galleryThumbSize, 'thumbLink' => "{$prefix}/{$plugin}/{$controller}/view/".$indexData[$i][$modelClass]['id']));
		echo "</div>\n"; 
	endif; 
	
	# show the display Fields
	foreach ($settings['fields'] as $key) :
		echo "\t\t<div class=\"indexCell\" id=\"{$key}\">\n\t\t\t{$indexData[$i][$modelClass][$key]}\n\t\t</div>\n";
	endforeach;

	# show the actions column
	if(!empty($settings['action'])) : foreach ($settings['action'] as $linkText => $url) :
		echo "\t\t<div class=\"columnActions\">\n";
		echo "\t\t\t" . $this->Html->link(__($linkText, true), $url.$_modelClass[$modelClass]['id']) . "\n";
	 	#echo "\t\t\t" . $this->Html->link(__('Edit', true), array('action' => 'edit', $_modelClass[$modelClass]['id'])) . "\n";
	 	#echo "\t\t\t" . $this->Html->link(__('Delete', true), array('action' => 'delete', $_modelClass[$modelClass]['id']), null, __('Are you sure you want to delete', true).' #' . $_modelClass[$modelClass]['id']) . "\n";
		echo "\t\t</div>\n";
	endforeach; endif;
  echo "\t</div>\n";
endforeach; else:
echo __('No records found.');
endif;
echo "\n";
?>
  </div>
</div>
<?php echo $this->element('paging');?>
<?php /*
$menuItems[] = $this->Html->link('New '.$singularHumanName, array('action' => 'add'));

$done = array();
foreach ($associations as $_type => $_data) {
	foreach ($_data as $_alias => $_details) {
		if ($_details['controller'] != $this->name && !in_array($_details['controller'], $done)) {
			$menuItems[] = $this->Html->link(sprintf(__('List %s', true), Inflector::humanize($_details['controller'])), array('controller' => $_details['controller'], 'action' => 'index'));
			$menuItems[] = $this->Html->link(sprintf(__('New %s', true), Inflector::humanize(Inflector::underscore($_alias))), array('controller' => $_details['controller'], 'action' => 'add'));
			$done[] = $_details['controller'];
		}
	}
}
		
// set the contextual menu items
$this->Menu->setValue(
	array(
		array(
			'heading' => $singularHumanName,
			'items' => $menuItems
		),
	)
); */
?>
