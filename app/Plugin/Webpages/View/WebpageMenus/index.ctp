<?php
/**
 * Menus Index View
 *
 * The view for a list of forms.
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
 * @link          http://zuha.com Zuha� Project
 * @package       zuha
 * @subpackage    zuha.app.plugins.webpages.views
 * @since         Zuha(tm) v 0.0.1
 * @license       GPL v3 License (http://www.gnu.org/licenses/gpl.html) and Future Versions
 */
?>

<div class="menus index">

<table cellpadding="0" cellspacing="0">
<thead>
    <tr>
        <th><?php echo $this->Paginator->sort('code', 'Template Tag');?></th>
    	<th><?php echo $this->Paginator->sort('name');?></th>
    	<th><?php echo $this->Paginator->sort('type');?></th>
    	<th class="actions"><?php echo __('Actions');?></th>
    </tr>
</thead>
<tbody>
<?php
foreach ($menus as $menu) { ?>
	<tr>
		<td>
			<?php echo __('&#123menu: %s&#125;', $menu['WebpageMenu']['code']); ?>
		</td>
		<td>
			<?php echo $menu['WebpageMenu']['name']; ?>
		</td>
		<td>
			<?php echo $menu['WebpageMenu']['type']; ?>
		</td>
		
		<td class="actions">
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $menu['WebpageMenu']['id'])); ?>
			<?php echo $this->Html->link(__('Delete'), array('action' => 'delete', $menu['WebpageMenu']['id']), null, __('Are you sure you want to delete # %s?', $menu['WebpageMenu']['code'])); ?>
		</td>
	</tr>
<?php } ?>
</tbody>
</table>
</div>
<?php echo $this->Element('paging'); ?>

<?php
// set the contextual menu items
$this->set('context_menu', array('menus' => array(
    array(
		'heading' => 'Menus',
		'items' => array(
			$this->Html->link(__('Add'), array('action' => 'add')),
			$this->Html->link(__('List'), array('controller' => 'webpage_menus', 'action' => 'index')),
			)
		),
	)));