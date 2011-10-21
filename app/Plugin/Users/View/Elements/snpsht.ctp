<?php
/**
 * User Snapshot Element
 *
 * Displays the user avatar, and links for edit and view user.
 *
 * PHP versions 5
 *
 * Zuha(tm) : Business Management Applications (http://zuha.com)
 * Copyright 2009-2010, Zuha Foundation Inc. (http://zuhafoundation.org)
 *
 * Licensed under GPL v3 License
 * Must retain the above copyright notice and release modifications publicly.
 *
 * @copyright     Copyright 2009-2010, Zuha Foundation Inc. (http://zuha.com)
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
	}
// set up the config vars
	$useGallery = (!empty($useGallery) ? $useGallery : false);
	$sessionUserId = $this->Session->read('Auth.User.id');
	$userId = (!empty($userId) ? $userId : (!empty($sessionUserId) && empty($userId) ? $sessionUserId : false));
	$showFirstName = (!empty($showFirstName) ? $showFirstName : false);
	$showLastName = (!empty($showLastName) ? $showLastName : false);
	$showViewLink = (!empty($showViewLink) && !empty($userId) ? $showViewLink : false);
	$showEditLink = (!empty($showEditLink) && !empty($userId) && $userId == $sessionUserId ? $showEditLink : false);
	$thumbLink = (!empty($thumbLink) ? $thumbLink : '/users/users/view/'.$userId);
	if ($thumbLink == 'default') { unset($thumbLink); }
	$thumbTitle = (!empty($thumbTitle) ? $thumbTitle : null);
	$thumbSize = (!empty($thumbSize) ? $thumbSize : 'medium');
	$thumbWidth = (!empty($thumbWidth) ? $thumbWidth : null);
	$thumbHeight = (!empty($thumbHeight) ? $thumbHeight : null);
	$thumbAlt = (!empty($thumbAlt) ? $thumbAlt : null);
	$thumbClass = (!empty($thumbClass) ? $thumbClass : 'user-thumb');
	$thumbId = (!empty($thumbId) ? $thumbId : 'userThumb'.$userId);
?>

<?php 
	$cfg['model'] = 'User';
	$cfg['foreignKey'] = $userId;
	#NOTE : I had to remove this cache because there are places where the user gallery
	# would link to the gallery, and other places where it would link to the user profile
	# therefore we need to give it a unique id based on the thumblink as well.
	#$cfg['cache'] = array('key' => 'gallery-thumb-'.$thumbSize.'-'.$userId, 'time' => '+2 days');
	$cfg['thumbLink'] = (!empty($thumbLink) ? $thumbLink : null);
	$cfg['thumbTitle'] = $thumbTitle;
	$cfg['thumbSize'] = $thumbSize;
	$cfg['thumbWidth'] = $thumbWidth;
	$cfg['thumbHeight'] = $thumbHeight;
	$cfg['thumbAlt'] = $thumbAlt;
	$cfg['thumbClass'] = $thumbClass;
	$cfg['thumbId'] = $thumbId;
	
 	$user = (!empty($userId) ? $this->requestAction('/users/users/view/'.$userId) : null);
?>
<div class="box">
    <?php echo $this->Element('thumb', $cfg, array('plugin' => 'galleries')); ?>
	<div class="descript">
		<h2><?php if($showFirstName) { echo $user['User']['first_name']; } echo ' '; if($showLastName) { echo $user['User']['last_name']; }?></h2>
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