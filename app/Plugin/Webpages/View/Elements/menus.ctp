<?php
$data = $this->requestAction(array('plugin' => 'webpages', 'controller' => 'webpage_menus', 'action' => 'element', $id));
$type = !empty($menuType) ? $menuType : str_replace(' ', '-', $data['WebpageMenu']['type']);
$cssClass = !empty($class) ? $class : ' nav nav-pills ';
$cssClass = !empty($data['WebpageMenu']['css_class']) ? $data['WebpageMenu']['css_class'] : $cssClass;
$cssId = !empty($data['WebpageMenu']['css_id']) ? $data['WebpageMenu']['css_id'] : 'nav-' . $data['WebpageMenu']['code'];
if (empty($type)) {
    $this->Tree->addTypeAttribute('data-identifier', $data['WebpageMenu']['id'], null, 'previous');
	$this->Tree->addTypeAttribute('role', 'navigation', null, 'previous'); // accessibility
    echo $this->Tree->generate($data['children'], array(
            'model' => 'WebpageMenu', 
    		'alias' => 'item_text', 
    		'class' =>  $cssClass . ' nav-edit '.$data['WebpageMenu']['type'],
    		'id' => $cssId, 
    		'element' => 'Webpages.link'));
} else {
    echo $this->element('Webpages.menus/' . $type, array('data' => $data));
}