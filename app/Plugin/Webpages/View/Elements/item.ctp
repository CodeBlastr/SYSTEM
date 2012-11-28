<?php
/*
debug($data);
debug($depth);
debug($hasChildren);
debug($numberOfDirectChildren);
debug($numberOfTotalChildren);
debug($firstChild);
debug($lastChild);
debug($hasVisibleChildren);
debug($plugin); */

$class = $this->request->params['controller'] == 'webpage_menus'  && $this->request->params['action'] == 'view' ? $param['class'] = 'showClick' : '';

$name = $this->request->params['controller'] == 'webpage_menus'  && $this->request->params['action'] == 'view' ? $param['name'] = 'WebpageMenuForm' : '';

$this->Tree->addItemAttribute('id', false, 'li_' . $data['WebpageMenu']['id']);
$this->Tree->addItemAttribute('data-identifier', false, $data['WebpageMenu']['id']);

echo '<div class="item">';
echo $this->Html->link($data['WebpageMenu']['item_text'], $data['WebpageMenu']['item_url'], array('class' => 'toggleClick', 'data-target' => '#form' . $data['WebpageMenu']['id'])); 

    echo '<div id="form' . $data['WebpageMenu']['id'] . '">';
    echo $this->Form->create('WebpageMenuItem', array('url' => array('plugin' => 'webpages', 'controller' => 'webpage_menu_items','action' => 'edit'), 'class' => 'form-inline'));
    echo $this->Form->input('WebpageMenuItem.id', array('type' => 'hidden', 'value' => $data['WebpageMenu']['id']));
    echo $this->Form->input('WebpageMenuItem.menu_id', array('type' => 'hidden', 'value' => $data['WebpageMenu']['menu_id']));
    echo $this->Form->input('WebpageMenuItem.item_text', array('label' => 'Link Text', 'value' => $data['WebpageMenu']['item_text']));
    echo $this->Form->input('WebpageMenuItem.item_url', array('label' => 'Url', 'value' => $data['WebpageMenu']['item_url']));
    echo $this->Form->end(__('Save'));
    
    echo $this->Html->link(__('Delete'), array('plugin' => 'webpages', 'controller' => 'webpage_menu_items', 'action' => 'delete', $data['WebpageMenu']['id']), array('class' => 'btn btn-danger'), __('Are you sure you want to delete %s?', $data['WebpageMenu']['item_text']));
    
    echo '</div>';

echo '</div>';