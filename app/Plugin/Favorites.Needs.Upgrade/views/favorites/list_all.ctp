<?php 
/**
 * Copyright 2009-2010, Cake Development Corporation (http://cakedc.com)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright 2009-2010, Cake Development Corporation (http://cakedc.com)
 * @license MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

/**
 * Output for getting a list of favorites of a type for a user.
 *
 */
$key = Inflector::camelize($type);

$emptyMessage = (isset($emptyMessage)) ? $emptyMessage : __d('favorites', 'You have no favorites in this category.', true);
$name = 'name';
$name = 'caption';
?>
<h1><?php echo __(Inflector::humanize(Inflector::pluralize($type))); ?></h1>
<?php if (empty($favorites[$key])): ?>
	<p><?php echo $emptyMessage; ?></p>
<?php else: ?>
<ul class="favorite-list">
	<?php
	$favoriteCount = count($favorites[$key]);
	foreach ($favorites[$key] as $i => $fav): 
		$prefix = null;
		$plugin = ZuhaInflector::pluginize($fav['Favorite']['model']);
		$controller = Inflector::tableize($fav['Favorite']['model']);
		$modelClass = Inflector::classify($controller); 
		$galleryThumbSize = 'small'; 
		?>
		<li>
			<?php #echo $this->element('thumb', array('plugin' => 'galleries', 'model' => $modelClass, 'foreignKey' => $fav['Favorite']['foreign_key'], 'showDefault' => 'false', 'thumbSize' => $galleryThumbSize, 'thumbLink' => "{$prefix}/{$plugin}/{$controller}/view/".$fav['Favorite']['foreign_key'])); ?>
            <?php if (!empty($fav[$modelClass]['dir']) && !empty($fav[$modelClass]['filename'])) { 
				echo $this->Html->link($this->Html->image($fav[$modelClass]['dir'].'thumb/small/'.$fav[$modelClass]['filename']), array('plugin' => $plugin, 'controller' => $controller, 'action' => 'view', $fav['Favorite']['foreign_key']), array('escape' => false));
			} ?>
			<span class="title-bar"><span><?php echo $this->Html->link($fav[$fav['Favorite']['model']][$name], array('plugin' => $plugin, 'controller' => $controller, 'action' => 'view', $fav['Favorite']['foreign_key'])); ?></span></span>
			<span class="description-bar"><span><?php echo $this->Text->truncate($fav[$modelClass]['description'], 75, array('ending' => '...', 'html' => false)); ?></span></span>
			<!--span class="sort-controls">
				<span class="index"><?php echo $i+ 1; ?></span>
			</span-->
		</li>
	<?php endforeach; ?>
</ul>
<?php endif; ?>

<?php 
$this->set('context_menu', array('menus' => array(
	array('heading' => 'Action',
		'items' => array(
			$this->Html->link(__('Print', true), array(), array('onclick' => 'window.print(); return false;')),
			)
		)
	)));
?>