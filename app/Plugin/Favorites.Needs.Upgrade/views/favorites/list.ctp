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
?>
<?php if (empty($favorites[$key])): ?>
	<p><?php echo $emptyMessage; ?></p>
<?php else: ?>
<ul class="favorite-list">
	<?php
	$favoriteCount = count($favorites[$key]);
	foreach ($favorites[$key] as $i => $fav): ?>
		<li>
			<span class="title-bar"><span><?php echo h($fav[$key][$name]); ?></span></span>
			<span class="sort-controls">
				<span class="index"><?php echo $i+ 1; ?></span>
			</span>
		</li>
	<?php endforeach; ?>
</ul>
<?php endif; ?>