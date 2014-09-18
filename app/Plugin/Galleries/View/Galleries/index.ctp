<div class="galleries index row">
	<?php foreach ($galleries as $gallery) { ?>
		<div class="media span3 col-md-3 well">
		<?php
		$foreignKey = !empty($gallery['Gallery']['foreign_key']) ? $gallery['Gallery']['foreign_key'] : $gallery['Gallery']['id'];
		$model = !empty($gallery['Gallery']['model']) ? $gallery['Gallery']['model'] : 'Gallery';
		echo $this->Html->link($this->Element('Galleries.thumb', array('model' => $model, 'foreignKey' => $foreignKey)), array('action' => 'view', $model, $foreignKey), array('escape' => false)); ?>
		<div class="media-body">
			<h4 class="media-heading"><?php echo $gallery['Gallery']['name']; ?></h4>
		</div>
	</div>
	<?php } ?>
</div>
<style>
	.media img {
		width: 100%;
	}
</style>