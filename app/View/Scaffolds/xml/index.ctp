<?php # setup standards for reuse 
echo $xml->header(); 
	$model = Inflector::classify($this->request->params['controller']); #ContactPerson
	$controller = $this->request->params['controller']; #contact_people
	$indexVar = Inflector::variable($this->request->params['controller']); #contactPeople
	$humanModel = Inflector::humanize(Inflector::underscore($model)); #Contact Person
	$humanCtrl = Inflector::humanize(Inflector::underscore($controller)); #Contact People
	# Inflector::singularize(Inflector::underscore($model)); #contact_person
	# Inflector::variable(Inflector::pluralize($model)); #contactPeople

echo $xml->serialize(array($indexVar => $___dataForView[$indexVar]), array('format' => 'tags', 'whitespace' => true)); ?>
<?php /*<pre><?php print_r($xml->data); ?></pre><pre><?php print_r(get_defined_vars()); ?></pre> */ ?>