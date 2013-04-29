<?php
/**
 * MetaFixture
 *
 */
class MetaFixture extends CakeTestFixture {

/**
 * name property
 *
 * @var string
 */
	public $name = 'Meta';
	
/**
 * Import
 *
 * @var array
 */
	public $import = array('config' => 'Meta');
	

/**
 * Records
 *
 * @var array
 */
	public $records = array(
//		array(
//			'foreign_key' => '4f88970e-b438-4b01-8740-1a14124e0d46',
//			'value' => 'a:6:{s:9:"!location";s:1:"l";s:6:"!phone";s:1:"p";s:14:"!facebook_page";s:1:"f";s:13:"!twitter_page";s:0:"";s:9:"!rebuttal";s:0:"";s:7:"!reason";s:0:"";}',
//			'model' => 'Article'
//		),
		array(
			'foreign_key' => '4f88970e-b438-4b01-8740-1a14124e0d46',
			'value' => 'a:5:{s:9:"!location";s:12:"!WasSyracuse";s:5:"!food";s:6:"turkey";s:10:"!fireproof";s:2:"no";s:5:"!rent";i:535;s:6:"!state";s:2:"NY";}',
			'model' => 'MetaArticle'
		),
	);
}
