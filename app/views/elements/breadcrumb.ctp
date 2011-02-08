<?php
/*
 * This element shows the bread crumbs. uses the crumb helpers.
 * For the index, controller name is shown and history is cleared.
 * For the rest of pages, the action is displayed.
 * eg. Home > Catalog Items > view
 * Home > Categories > view
 */ 
?>
<?php 
echo "Home " . __ELEMENT_BREADCRUMBS_SEPARATOR . ' ' ?>
<?php
	if ($this->params['action'] == 'index')  {
		$humanCtrl = Inflector::humanize(Inflector::underscore($this->params['controller'])); #Contact People
	
	   echo $crumb->getHtml($humanCtrl, 'reset') ;
	} else {
	   echo ucfirst($crumb->getHtml($this->params['action'], null, 'auto') );
	}
?>