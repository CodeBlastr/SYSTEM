<?php 
if (!empty($page_title_for_layout)) : 
	echo "<h1>{$page_title_for_layout}</h1>";
else :
	echo '<h1>'.Inflector::humanize($this->params['controller']).'</h1>';
endif;
?>