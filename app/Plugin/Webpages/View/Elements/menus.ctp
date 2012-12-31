<?php
$data = $this->requestAction(array('plugin' => 'webpages', 'controller' => 'webpage_menus', 'action' => 'element', $id));
$cssClass = !empty($data['WebpageMenu']['css_class']) ? $data['WebpageMenu']['css_class'] : ' nav nav-pills ';
$cssId = !empty($data['WebpageMenu']['css_id']) ? $data['WebpageMenu']['css_id'] : 'nav-' . $data['WebpageMenu']['code'];
if (empty($data['WebpageMenu']['type'])) {
    $this->Tree->addTypeAttribute('data-identifier', $data['WebpageMenu']['id'], null, 'previous');
    echo $this->Tree->generate($data['children'], array(
            'model' => 'WebpageMenu', 
    		'alias' => 'item_text', 
    		'class' =>  $cssClass . ' nav-edit '.$data['WebpageMenu']['type'],
    		'id' => $cssId, 
    		'element' => 'Webpages.link'));
} else {
    echo $this->Element('menus/' . str_replace(' ', '-', $data['WebpageMenu']['type']), array('data' => $data), array('plugin' => 'webpages'));
} ?>