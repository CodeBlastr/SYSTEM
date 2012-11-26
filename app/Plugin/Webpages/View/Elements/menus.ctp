<?php
$data = $this->requestAction(array('plugin' => 'webpages', 'controller' => 'webpage_menus', 'action' => 'element', $id));

if (empty($data['WebpageMenu']['type'])) {
    $this->Tree->addTypeAttribute('data-identifier', $data['WebpageMenu']['id'], null, 'previous');
    echo $this->Tree->generate($data['children'], array(
            'model' => 'WebpageMenu', 
    		'alias' => 'item_text', 
    		'class' => 'nav nav-tabs nav-edit '.$data['WebpageMenu']['type'], 
    		'id' => 'nav-' . $data['WebpageMenu']['code'], 
    		'element' => 'Webpages.link'));

} else {
    echo $this->Element('menus/' . str_replace(' ', '-', $data['WebpageMenu']['type']), array('data' => $data), array('plugin' => 'webpages'));
} ?>