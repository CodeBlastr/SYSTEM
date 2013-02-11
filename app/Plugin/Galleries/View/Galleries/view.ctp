<?php $this->set('title_for_layout', $gallery['Gallery']['name']); ?>
<?php #echo $this->Html->meta('keywords', $webpage['Webpage']['keywords'], array('inline' => false)); ?>
<?php #echo $this->Html->meta('description', $webpage['Webpage']['description'], array('inline' => false)); ?>

<div class="gallery view">
<?php
if (!empty($gallery)) { ?>
	<div class="galleryname">
		<h2><span id="gallery-name"><?php echo __($gallery['Gallery']['name']); ?></span></h2>
	</div>
    <div class="gallery-description">
		<?php echo $gallery['Gallery']['description']; ?>
    </div>
	
	<?php echo $this->Element($gallery['GallerySettings']['galleryType'], array('gallery' => $gallery), array('plugin' => 'galleries'));
} else { ?>
	<div class="noData">
    	<p> No gallery to display. <?php echo $this->Html->link('Go back', 'javascript:history.go(-1)'); ?> </p>
    </div>
<?php
} ?>
</div>
<?php 
// set the contextual menu items
$this->set('context_menu', array('menus' => array(
	array(
		'heading' => 'Galleries',
		'items' => array(
			$this->Html->link(__('Edit'), array('plugin' => 'galleries', 'controller' => 'galleries', 'action' => 'edit', $gallery['Gallery']['model'], $gallery['Gallery']['foreign_key']), array('class' => 'edit')),
			$this->Html->link(__('List'), array('plugin' => 'galleries', 'controller' => 'galleries', 'action' => 'index'), array('class' => 'index')),
			$this->Html->link(__('Add'), array('plugin' => 'galleries', 'controller' => 'galleries', 'action' => 'add'), array('class' => 'add')),
			$this->Html->link(__('Delete'), array('plugin' => 'galleries', 'controller' => 'galleries', 'action' => 'delete', $gallery['Gallery']['id']), array('class' => 'delete'), 'Are you sure you want to permanently delete?'),
			)
		),
	))); ?>
