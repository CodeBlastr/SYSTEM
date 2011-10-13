<?php 
if (!empty($page_title_for_layout)) : 
	echo "<h1 class=\"pageTitle\">{$page_title_for_layout}</h1>";
else :
	echo '<h1 class="pageTitle">'.Inflector::humanize($this->params['controller']).'</h1>';
endif;
?>