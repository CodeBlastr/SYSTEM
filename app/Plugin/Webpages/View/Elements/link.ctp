<?php
$addClass = !empty($addClass) ? $addClass : '';
//$this->Tree->addItemAttribute('id', false, 'li_' . $data['WebpageMenu']['id']);
if ($this->request->here == $data['WebpageMenu']['item_url'] || $_SERVER['REQUEST_URI'] == $data['WebpageMenu']['item_url']) {
    $this->Tree->addItemAttribute('class', false, 'active');
    $addClass .= __('%s active', $addClass);
}

echo $this->Html->link($data['WebpageMenu']['item_text'], $data['WebpageMenu']['item_url'], array('class' => $addClass)); 