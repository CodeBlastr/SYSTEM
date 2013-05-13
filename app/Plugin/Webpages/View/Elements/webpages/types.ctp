<?php
$type = !empty($type) ? $type : 'content';
$thumbWidth = !empty($thumbWidth) ? $thumbWidth : 250;
$thumbHeight = !empty($thumbHeight) ? $thumbHeight : 250;
$conversionType = !empty($conversionType) ? $conversionType : 'crop';
$webpages = $this->requestAction(array('plugin' => 'webpages', 'controller' => 'webpages', 'action' => 'index', $type));
if (!empty($webpages)) {
	debug($webpages);
	foreach ($webpages as $page) {
		echo $this->element('Galleries.thumb', array(
			'model' => 'Webpage', 
			'foreignKey' => $page['Webpage']['id'], 
			'thumbWidth' => $thumbWidth,
			'thumbHeight' => $thumbHeight,
			'thumbSize' => 'large',
			'conversionType' => $conversionType,
			'thumbLink' => array('plugin' => 'webpages', 'controller' => 'webpages', 'action' => 'view', $page['Webpage']['id'])
			));
	}
} else {
	echo __('No pages of this type exist.');
}
