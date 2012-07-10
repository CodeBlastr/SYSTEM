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
 $class = $this->request->params['controller'] == 'webpage_menus'  && $this->request->params['action'] == 'view' ? $param['class'] = 'showClick' : '';
 $name = $this->request->params['controller'] == 'webpage_menus'  && $this->request->params['action'] == 'view' ? $param['name'] = 'WebpageMenuItemForm' : '';
 echo '<div>'.$this->Html->link($data['WebpageMenuItem']['item_text'], $data['WebpageMenuItem']['item_url'], $param).'</div>';
#debug($data['MenuItem']);
?>