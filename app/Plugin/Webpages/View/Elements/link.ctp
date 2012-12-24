<?php
$navLinkClass = 'nav-link';
//$this->Tree->addItemAttribute('id', false, 'li_' . $data['WebpageMenu']['id']);
if ($this->request->here == $data['WebpageMenu']['item_url'] || $_SERVER['REQUEST_URI'] == $data['WebpageMenu']['item_url']) {
    $this->Tree->addItemAttribute('class', false, 'active');
    $navLinkClass = __('%s active', $navLinkClass);
}
echo $this->Html->link($data['WebpageMenu']['item_text'], $data['WebpageMenu']['item_url'], array('class' => $navLinkClass));

unset($navLinkClass);