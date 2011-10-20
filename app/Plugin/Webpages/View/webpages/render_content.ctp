<?php
 # WHEN WORKING ON ELEMENT CHECK THIS : http://blog.japanesetesting.com/2010/04/27/widgity-multi-element-designs-with-cakephp/
 # matches helper calls like {element: content_for_layout} or {element: menu_for_layout}
 preg_match_all ("/(\{([^\}\{]*)element([^\}\{]*):([^\}\{]*)([az_]*)([^\}\{]*)\})/", $content_str, $matches);
 $i = 0;
 foreach ($matches[0] as $elementMatch) {
     $element = trim($matches[4][$i]);
     $content_str = str_replace($elementMatch, $$element, $content_str);
     $i++;
 }
 # WHEN WORKING ON ELEMENT CHECK THIS : http://blog.japanesetesting.com/2010/04/27/widgity-multi-element-designs-with-cakephp/
 # matches form calls like {form: Plugin.Model.Type.Limiter} for example {form: Contacts.ContactPeople.add.59}
 preg_match_all ("/(\{([^\}\{]*)form([^\}\{]*):([^\}\{]*)([az_]*)([^\}\{]*)\})/", $content_str, $matches);
 $i = 0;
 foreach ($matches[0] as $elementMatch) {
     $formCfg['id'] = trim($matches[4][$i]);
     $formCfg['cache'] = array('key' => 'form-'.$formCfg['id'], 'time' => '+2 days');
     $formCfg['plugin'] = 'forms';
     $content_str = str_replace($elementMatch, $this->element('forms', $formCfg), $content_str);
     $i++;
 }

 # display the database driven default template
 echo $content_str;

?>