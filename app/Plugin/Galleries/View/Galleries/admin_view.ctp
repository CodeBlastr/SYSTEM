<div class="gallery view">
	<div class="galleryname">
		<h2><span id="gallery-name"><?php echo __($gallery['Gallery']['name']); ?></span></h2>
	</div>
	
	<div id="tabscontent">
		<div id="tabContent1" class="tabContent" style="display:yes;">
			<div class="details data">
				<ul class="detail datalist">
					<li>
		            	<span class="label"><?php echo __('Type'); ?></span>
		                <span name="type" id="<?php echo __($gallery['Gallery']['id']); ?>"><?php echo $gallery['Gallery']['type']; ?></span>
        		    </li>
					<li>
		            	<span class="label"><?php echo __('Created Date'); ?></span>
		                <span name="createddate" id="<?php echo __($gallery['Gallery']['id']); ?>"><?php echo $this->Time->format('M d, Y', $gallery['Gallery']['created']); ?></span>
        		    </li>
				</ul>
			</div>
		</div> 
	</div>
    
    <p class="timing"><strong><?php echo __($gallery['Gallery']['name']);?></strong><?php echo __(' was '); ?><strong><?php echo __('Created: '); ?></strong><?php echo $this->Time->relativeTime($gallery['Gallery']['created']); ?><?php echo __(', '); ?><strong><?php echo __('Last Modified: '); ?></strong><?php echo $this->Time->relativeTime($gallery['Gallery']['modified']); ?></p>

</div>
<?php 
// set the contextual menu items
$this->set('context_menu', array('menus' => array(
	array(
		'heading' => 'Galleries',
		'items' => array(
			$this->Html->link(__('Edit Gallery', true), array('action' => 'edit', $gallery['Gallery']['id'])),
			$this->Html->link(__('List Galleries', true), array('action' => 'index')),
			$this->Html->link(__('New Gallery', true), array('action' => 'edit')),
			)
		),
	)));
?>
<?php #pr($gallery); ?>
