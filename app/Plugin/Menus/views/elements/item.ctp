<?php
 #debug($data);
 #debug($depth);
 #debug($hasChildren);
 #debug($numberOfDirectChildren);
 #debug($numberOfTotalChildren);
 #debug($firstChild);
 #debug($lastChild);
 #debug($hasVisibleChildren);
 #debug($plugin);
 $param = null;
 $class = $this->request->params['controller'] == 'menus'  && $this->request->params['action'] == 'view' ? $param['class'] = 'showClick' : '';
 $name = $this->request->params['controller'] == 'menus'  && $this->request->params['action'] == 'view' ? $param['name'] = 'MenuItemForm' : '';
 echo '<div>'.$this->Html->link($data['MenuItem']['item_text'], $data['MenuItem']['item_url'], $param).'</div>';
#debug($data['MenuItem']);
?>