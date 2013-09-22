<?php 
$conflicts = array('media');
$controller = in_array($this->request->params['controller'], $conflicts) ? $this->request->params['controller'] . 'Controller' : $this->request->params['controller'];
$access = $this->Session->read('Auth.User') ? __(' authorized') : __(' restricted');
$action = $this->request->params['action'];
$role = __('userRole%s', $userRoleId);
$template = !empty($templateId) ? str_replace('.ctp', '', $templateId) : 'default-template';
$template = strpos($template, '-template') ? $template : __('%s-template', $template);

$class = __('%s %s %s %s %s', $controller, $access, $action, $role, $template); 

$id = !empty($this->request->params['pass'][0]) ? strtolower($this->request->params['controller'].'_'.$this->request->params['action'].'_'.$this->request->params['pass'][0]) : strtolower($this->request->params['controller'].'_'.$this->request->params['action']);

echo __('class="%s" id="%s" lang="%s"', $class, $id,  Configure::read('Config.language')); ?>