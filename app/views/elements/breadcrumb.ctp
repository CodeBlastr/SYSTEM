<?php
/*
 * This element shows the bread crumbs. uses the crumb helpers.
 * For the index, controller name is shown and history is cleared.
 * For the rest of pages, the action is displayed.
 * eg. Home > Catalog Items > view
 * Home > Categories > view
 */ 
?>
<?php $home = $html->link("Home ", '/');?>
<?php if(defined('__ELEMENT_BREADCRUMBS_SEPARATOR')) {
	 	$home .= __ELEMENT_BREADCRUMBS_SEPARATOR . ' ';
} 
// @todo: find home page from setting and pass the reset here.
echo $home;?>

<?php
	if ($this->params['action'] == 'index')  {
		$humanCtrl = Inflector::humanize(Inflector::underscore($this->params['controller'])); #Contact People
	
	   echo $crumb->getHtml($humanCtrl, 'reset') ;
	} else {
	   echo ucfirst($crumb->getHtml($this->params['action'], null, 'auto') );
	}
?>