<?php
$url = strpos($_SERVER['REQUEST_URI'], 'index') ? $_SERVER['REQUEST_URI'] : DS . $this->request->plugin . DS . $this->request->controller . DS . $this->request->action;
$pattern = '/\/limit:([0-9]*)/i';
?>
Show : 
<?php echo $this->Html->link('25', strpos($_SERVER['REQUEST_URI'], 'limit') ? preg_replace($pattern, '/limit:25', $url) : $url . '/limit:25'); ?> 
<?php echo $this->Html->link('50', strpos($_SERVER['REQUEST_URI'], 'limit') ? preg_replace($pattern, '/limit:50', $url) : $url . '/limit:50'); ?> 
<?php echo $this->Html->link('100', strpos($_SERVER['REQUEST_URI'], 'limit') ? preg_replace($pattern, '/limit:100', $url) : $url . '/limit:100');