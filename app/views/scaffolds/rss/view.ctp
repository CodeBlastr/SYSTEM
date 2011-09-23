<?php # setup standards for reuse 
	$model = Inflector::classify($this->params['controller']); #ContactPerson
	$controller = $this->params['controller']; #contact_people
	$viewVar = Inflector::variable(Inflector::singularize($this->params['controller'])); #contactPerson
	$humanModel = Inflector::humanize(Inflector::underscore($model)); #Contact Person
	$humanCtrl = Inflector::humanize(Inflector::underscore($controller)); #Contact People
	# Inflector::singularize(Inflector::underscore($model)); #contact_person
	# Inflector::variable(Inflector::pluralize($model)); #contactPeople
	
	
	# http://book.cakephp.org/view/483/Creating-an-RSS-feed-with-the-RssHelper
?><?php /*<pre><?php print_r($xml->data); ?></pre><pre><?php print_r(get_defined_vars()); ?></pre> */ ?>