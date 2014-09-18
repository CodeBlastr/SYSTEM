<div class="galleries dashboard">
	<h2><?php echo __('Galleries Dashboard'); ?></h2>

	<?php
	if (!empty($instance) && defined('__GALLERIES_SETTINGS_' . $instance)) {
		$values = unserialize(constant('__GALLERIES_SETTINGS_' . $instance));
	} else if (defined('__GALLERIES_SETTINGS')) {
		$values = unserialize(__GALLERIES_SETTINGS);
	}
	echo $this->Element('settings/edit', array('type' => 'Galleries', 'name' => 'SETTINGS'));
	?>

    <div class="galleries index">
		<h3><?php echo __('Galleries List'); ?></h3>

		<div class="galleries index row">
			<?php foreach ($galleries as $gallery) : ?>
				<div class="col-md-3">
					<div class="well">
						<div class="media-body">
							<h4 class="media-heading"><?php echo $gallery['Gallery']['name']; ?></h4>
						</div>
						<?php
						$foreignKey = !empty($gallery['Gallery']['foreign_key']) ? $gallery['Gallery']['foreign_key'] : $gallery['Gallery']['id'];
						$model = !empty($gallery['Gallery']['model']) ? $gallery['Gallery']['model'] : 'Gallery';
						echo $this->Html->link($this->Element('Galleries.thumb', array('model' => $model, 'foreignKey' => $foreignKey)), array('action' => 'view', $model, $foreignKey), array('escape' => false));
						?>
						<div class="btn-group">
							<?php
							echo $this->Html->link('Edit', array('action' => 'edit', $model, $foreignKey), array('class' => 'btn btn-warning btn-xs'));
							echo $this->Html->link('Delete', array('action' => 'delete', $gallery['Gallery']['id']), array('class' => 'btn btn-danger btn-xs'), 'Are you sure you want to permanently delete?');
							?>
						</div>
					</div>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
	<div>
		<?php echo $this->element('paging'); ?>
	</div>
</div>
