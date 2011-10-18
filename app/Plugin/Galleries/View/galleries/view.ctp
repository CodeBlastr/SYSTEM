<?php $this->set('title_for_layout', $gallery['Gallery']['name']); ?>
<?php #echo $this->Html->meta('keywords', $webpage['Webpage']['keywords'], array('inline' => false)); ?>
<?php #echo $this->Html->meta('description', $webpage['Webpage']['description'], array('inline' => false)); ?>

<div class="gallery view">
	<div class="galleryname">
		<h2><span id="gallery-name"><?php __($gallery['Gallery']['name']); ?></span></h2>
	</div>
    <div class="gallery-description">
		<?php echo $gallery['Gallery']['description']; ?>
    </div>
	
	<div id="tabscontent">
		<div id="tabContent1" class="tabContent" style="display:yes;">
			<?php echo $this->element($gallery['Gallery']['type'], array('id' => $gallery['Gallery']['id'])); ?>
		</div> 
	</div>
    
    <!--p class="timing"><strong><?php __($gallery['Gallery']['name']);?></strong><?php __(' was '); ?><strong><?php __('Created: '); ?></strong><?php echo $this->Time->relativeTime($gallery['Gallery']['created']); ?><?php __(', '); ?><strong><?php __('Last Modified: '); ?></strong><?php echo $this->Time->relativeTime($gallery['Gallery']['modified']); ?></p-->

</div>
<?php 
// set the contextual menu items
echo $this->Element('context_menu', array('menus' => array(
	array(
		'heading' => 'Galleries',
		'items' => array(
			$this->Html->link(__('All Galleries', true), array('plugin' => 'galleries', 'controller' => 'galleries', 'action' => 'index')),
			$this->Html->link(__('New Gallery', true), array('plugin' => 'galleries', 'controller' => 'galleries', 'action' => 'add'), array('checkPermissions' => true)),
			$this->Html->link(__('Edit Gallery', true), array('plugin' => 'galleries', 'controller' => 'galleries', 'action' => 'edit', $gallery['Gallery']['model'], $gallery['Gallery']['foreign_key']), array('checkPermissions' => true)),
			)
		),
	)));
?>
