<?php # setup standards for reuse 
	$model = Inflector::classify($this->request->params['controller']); #ContactPerson
	$controller = $this->request->params['controller']; #contact_people
	$viewVar = Inflector::variable(Inflector::singularize($this->request->params['controller'])); #contactPerson
	$humanModel = Inflector::humanize(Inflector::underscore($model)); #Contact Person
	$humanCtrl = Inflector::humanize(Inflector::underscore($controller)); #Contact People
	# Inflector::singularize(Inflector::underscore($model)); #contact_person
	# Inflector::variable(Inflector::pluralize($model)); #contactPeople
?><?php echo $xml->serialize($___dataForView[$viewVar], array('format' => 'tags')); ?><?php /*<pre><?php print_r($xml->data); ?></pre><pre><?php print_r(get_defined_vars()); ?></pre> */ ?>