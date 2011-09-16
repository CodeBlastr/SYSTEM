<?php
/**
 * Created by PhpStorm.
 * User: moncruist
 * Date: 25.12.2010
 * Time: 14:11:43
 * To change this template use File | Settings | File Templates.
 */
//App::import('Datasource', 'Datasources.ArraySource');

ConnectionManager::create('array', array('datasource' => 'ArraySource'));

class Template extends AppModel {

    var $name = 'Template';
    var $useTable = false;
    var $useDbConfig = 'array';

    var $records = array();
}

?>