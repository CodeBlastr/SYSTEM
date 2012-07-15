<?php 
$title = !empty($page_title_for_layout) ? $page_title_for_layout : Inflector::humanize($this->request->params['controller']); ?> 
<h1 class="pageTitle">
	<a href="" id="pageTitleBtn" data-role="button" data-icon="arrow-d" data-iconpos="right"><?php echo $title; ?></a>
</h1>
 