<?php 
$title = !empty($page_title_for_layout) ? $page_title_for_layout : Inflector::humanize($this->request->params['controller']); 
echo !empty($title) ? __('<h1 class="first pull-left pageTitle">%s</h1>', $title) : null;
echo !empty($forms_search) ? $this->Element('forms/search', $forms_search) : null; ?>