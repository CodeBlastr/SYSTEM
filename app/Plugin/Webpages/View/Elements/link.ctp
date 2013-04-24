<?php
$navLinkClass = ' nav-link ';
$caret = ' ';
$dataToggle = '';

if ($this->request->here == $data['WebpageMenu']['item_url'] || $_SERVER['REQUEST_URI'] == $data['WebpageMenu']['item_url']) {
    $navLinkClass .= ' active ';
    $this->Tree->addItemAttribute('class', false, $navLinkClass);
}

if (!empty($data['children'])) {
    $navLinkClass .= ' dropdown ';
	$caret .= '<b class="caret"></b>';
	$dataToggle = 'dropdown';
    $this->Tree->addItemAttribute('class', false, $navLinkClass);
}

if (!empty($depth)) {
    $this->Tree->addTypeAttribute('class', 'dropdown-menu', null, 'previous');
}

echo $this->Html->link($data['WebpageMenu']['item_text'] . $caret, $data['WebpageMenu']['item_url'], array('data-toggle' => $dataToggle, 'class' => $navLinkClass, 'escape' => false));

unset($navLinkClass);