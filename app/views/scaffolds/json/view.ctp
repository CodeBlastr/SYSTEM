<?php # setup standards for reuse 
	$model = Inflector::classify($this->params['controller']); #ContactPerson
	$controller = $this->params['controller']; #contact_people
	$viewVar = Inflector::variable(Inflector::singularize($this->params['controller'])); #contactPerson
	$humanModel = Inflector::humanize(Inflector::underscore($model)); #Contact Person
	$humanCtrl = Inflector::humanize(Inflector::underscore($controller)); #Contact People
	# Inflector::singularize(Inflector::underscore($model)); #contact_person
	# Inflector::variable(Inflector::pluralize($model)); #contactPeople
$items = array();
foreach($___dataForView[$viewVar][$model] as $key => $value) {
	$items[$key] = $value;
}
echo $javascript->object($items);
?>