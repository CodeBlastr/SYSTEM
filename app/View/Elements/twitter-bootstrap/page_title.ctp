<?php $title = !empty($page_title_for_layout) ? $page_title_for_layout : Inflector::humanize($this->request->params['controller']); ?> 
<h1><?php echo $title; ?></h1>
 