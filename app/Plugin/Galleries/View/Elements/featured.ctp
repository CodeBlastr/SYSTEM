<?php 
/**
 * Featured image element
 * 
 * This file is mainly for specifying the model and foreignkey from the request, instead
 * of it being part of the element call.  Other than that it is passing through variables 
 * to the thumb element.
 */
 
$default = !empty($default) ? $default : null;
$model = Inflector::classify($this->request->controller);
$foreignKey = $this->request->pass[0];
$thumbClass = !empty($thumbClass) ? $thumbClass : null;

echo $this->Element('Galleries.thumb', array(
	'model' => $model, 
	'foreignKey' => $foreignKey,
	'defaultImage' => $default,
	'thumbClass' => $thumbClass
	// probably need to pass more through, or find a better way of combining vars
	)); 