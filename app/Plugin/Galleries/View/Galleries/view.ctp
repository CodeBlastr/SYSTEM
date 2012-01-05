<?php $this->set('title_for_layout', $gallery['Gallery']['name']); ?>
<?php #echo $this->Html->meta('keywords', $webpage['Webpage']['keywords'], array('inline' => false)); ?>
<?php #echo $this->Html->meta('description', $webpage['Webpage']['description'], array('inline' => false)); ?>

<div class="gallery view">
	<div class="galleryname">
		<h2><span id="gallery-name"><?php echo __($gallery['Gallery']['name']); ?></span></h2>
	</div>
    <div class="gallery-description">
		<?php echo $gallery['Gallery']['description']; ?>
    </div>
	
	<?php echo $this->Element($gallery['GallerySettings']['galleryType'], array('gallery' => $gallery), array('plugin' => 'galleries')); ?>
    
    <!--p class="timing"><strong><?php echo __($gallery['Gallery']['name']);?></strong><?php echo __(' was '); ?><strong><?php echo __('Created: '); ?></strong><?php echo $this->Time->relativeTime($gallery['Gallery']['created']); ?><?php echo __(', '); ?><strong><?php echo __('Last Modified: '); ?></strong><?php echo $this->Time->relativeTime($gallery['Gallery']['modified']); ?></p-->

</div>
<?php 
// set the contextual menu items
$this->set('context_menu', array('menus' => array(
	array(
		'heading' => 'Galleries',
		'items' => array(
			$this->Html->link(__('Edit'), array('plugin' => 'galleries', 'controller' => 'galleries', 'action' => 'edit', $gallery['Gallery']['model'], $gallery['Gallery']['foreign_key'])),
			$this->Html->link(__('List'), array('plugin' => 'galleries', 'controller' => 'galleries', 'action' => 'index')),
			$this->Html->link(__('Add'), array('plugin' => 'galleries', 'controller' => 'galleries', 'action' => 'add')),
			)
		),
	)));
?>
