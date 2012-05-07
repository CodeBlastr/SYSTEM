<?php
/**
 * User Snapshot Element
 *
 * Displays the user avatar, and links for edit and view user.
 *
 * PHP versions 5
 *
 * Zuha(tm) : Business Management Applications (http://zuha.com)
 * Copyright 2009-2012, Zuha Foundation Inc. (http://zuhafoundation.org)
 *
 * Licensed under GPL v3 License
 * Must retain the above copyright notice and release modifications publicly.
 *
 * @copyright     Copyright 2009-2012, Zuha Foundation Inc. (http://zuha.com)
 * @link          http://zuha.com Zuha™ Project
 * @package       zuha
 * @subpackage    zuha.app.plugins.forms.views.elements
 * @since         Zuha(tm) v 0.0.1
 * @license       GPL v3 License (http://www.gnu.org/licenses/gpl.html) and Future Versions
 */
?>
<?php 
// this should be at the top of every element created with format __ELEMENT_PLUGIN_ELEMENTNAME_instanceNumber.
// it allows a database driven way of configuring elements, and having multiple instances of that configuration.
	if(!empty($instance) && defined('__ELEMENT_USERS_SNPSHT_'.$instance)) {
		extract(unserialize(constant('__ELEMENT_USERS_SNPSHT_'.$instance)));
	} else if (defined('__ELEMENT_USERS_SNPSHT')) {
		extract(unserialize(__ELEMENT_USERS_SNPSHT));
	}
// set up the config vars
	$useGallery = !empty($useGallery) ? $useGallery : false;
	$sessionUserId = $this->Session->read('Auth.User.id');
	$userId = !empty($userId) ? $userId : (!empty($sessionUserId) && empty($userId) ? $sessionUserId : false);
	$showFirstName = !empty($showFirstName) ? $showFirstName : false;
	$showLastName = !empty($showLastName) ? $showLastName : false;
	$showViewLink = !empty($showViewLink) && !empty($userId) ? $showViewLink : false;
	$showEditLink = !empty($showEditLink) && !empty($userId) && $userId == $sessionUserId ? $showEditLink : false;
	$thumbLink = !empty($thumbLink) ? $thumbLink : '/users/users/view/'.$userId;
	$thumbSize = !empty($thumbSize) ? $thumbSize : 'medium';
	#image options
	$thumbWidth = !empty($thumbWidth) ? array('width' => $thumbWidth) : array();
	$thumbHeight = !empty($thumbHeight) ? array('height' => $thumbHeight) : array();
	$thumbAlt = !empty($thumbAlt) ? array('alt' => $thumbAlt) : array('alt' => 'snpsht');
	$thumbImageOptions = array_merge($thumbWidth, $thumbHeight, $thumbAlt);
	#link options
	$thumbTitle = !empty($thumbTitle) ? array('title' => $thumbTitle) : array();
	$thumbClass = !empty($thumbClass) ? array('class' => $thumbClass) : array('class' => 'user-thumb');
	$thumbId = !empty($thumbId) ? array('id' => $thumbId) : array('id' => 'userThumb'.$userId);
	$thumbLinkOptions = array_merge($thumbTitle, $thumbClass, $thumbId);
?>

<?php 
	$cfg['model'] = 'User';
	$cfg['foreignKey'] = $userId;
	$cfg['thumbSize'] = $thumbSize;
	$cfg['thumbLink'] = (!empty($thumbLink) ? $thumbLink : null);
	$cfg['thumbLinkOptions'] = $thumbLinkOptions;
	$cfg['thumbImageOptions'] = $thumbImageOptions;
	
 	$user = (!empty($userId) ? $this->requestAction('/users/users/view/'.$userId) : null);
	$firstName = !empty($showFirstName) ? $user['User']['first_name'] : null;
	$lastName = !empty($showLastName) ? $user['User']['last_name'] : null;
	$name = $firstName || $lastName ? '<h2>' . $this->Html->link(__('%s %s', $firstName, $lastName), array('plugin' => 'users', 'controller' => 'users', 'action' => 'view', $user['User']['id'])) . '</h2>' : null;
?>
<div class="box">
    <?php echo $this->Element('thumb', $cfg, array('plugin' => 'galleries')); ?>
	<div class="descript">
		<?php echo $name; ?>
        <?php if($showViewLink || $showEditLink) { ?>
		<ul>
        	<?php if($showViewLink) { ?>
			<li>
				<a href="/users/users/view/<?php echo $user['User']['id']; ?>"><strong>view my user</strong></a></li>
			<?php } ?>
        	<?php if($showEditLink) { ?>
			<li>
				<a href="/users/users/edit/<?php echo $user['User']['id']; ?>"><strong>edit my user</strong></a></li>
			<?php } ?>
		</ul>
        <?php } ?>
	</div>
</div>