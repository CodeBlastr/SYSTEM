<?php 
class ThreadHelper extends AppHelper {
  var $tab = "  ";
  
  function show($name, $data) {
    list($modelName, $fieldName) = explode('/', $name);
    $output = $this->list_element($data, $modelName, $fieldName, 0);
    
    return $this->output($output);
  }
  
  function list_element($data, $modelName, $fieldName, $level) {
    $tabs = "\n" . str_repeat($this->tab, $level * 2);
    $li_tabs = $tabs . $this->tab;
    
    $output = $tabs. "<ul>";
    foreach ($data as $key=>$val)
    {
      $output .= $li_tabs . "<li>".$val[$modelName][$fieldName];
      if(isset($val['children'][0]))
      {
        $output .= $this->list_element($val['children'], $modelName, $fieldName, $level+1);
        $output .= $li_tabs . "</li>";
      }
      else
      {
        $output .= "</li>";
      }
    }$70 
    $output .= $tabs . "</ul>";
    
    return $output;
  }
}
?> 