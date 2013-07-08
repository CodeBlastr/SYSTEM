<?php
$type = !empty($type) ? $type : 'content';
$thumbWidth = !empty($thumbWidth) ? $thumbWidth : 250;
$thumbHeight = !empty($thumbHeight) ? $thumbHeight : 250;
$conversionType = !empty($conversionType) ? $conversionType : 'crop';
$columns = !empty($columns) ? $columns : 3;
$span = 12 / $columns;
$webpages = $this->requestAction(array('plugin' => 'webpages', 'controller' => 'webpages', 'action' => 'index', $type));
if (!empty($webpages)) {
	echo __('<div class="row-fluid">');
	for ($i = 0; $i < count($webpages); $i++) {
    	if ($i % $columns == 0) {
    		 echo __('</div><div class="row-fluid">'); 
		}
    	echo __('<div class="span%s">', $span);
		
		// because this was created before the alias field existed (should be able to remove it in the future)
		$link = !empty($webpages[$i]['Webpage']['alias']) ? '/' . $webpages[$i]['Webpage']['alias'] : array('plugin' => 'webpages', 'controller' => 'webpages', 'action' => 'view', $webpages[$i]['Webpage']['id']);
		echo $this->element('Galleries.thumb', array(
			'model' => 'Webpage', 
			'foreignKey' => $webpages[$i]['Webpage']['id'], 
			'thumbWidth' => $thumbWidth,
			'thumbHeight' => $thumbHeight,
			'thumbSize' => 'large',
			'conversionType' => $conversionType,
			'thumbLink' => $link
			));
			
		echo __('</div>');
    	if ($i % $columns == 0) {
		}
	}
	echo __('</div>'); 
} else {
	echo __('No pages of this type exist.');
}
