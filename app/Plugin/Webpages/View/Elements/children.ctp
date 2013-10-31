<div class="index"><?php foreach ($webpage['Child'] as $child) : ?>
	<?php $isRestrictable = empty($child['user_roles']) ? '' : 'restricted ' . preg_replace("/[^[:alnum:]]/", '', $child['user_roles']); ?>
	<div class="child index-row <?php echo $isRestrictable; ?>">
		<div class="index-cell">
			<h3> <?php echo $this->Html->link($child['name'], array('plugin' => 'webpages', 'controller' => 'webpages', 'action' => 'view', $child['id'])); ?> </h3>
		</div>
		<div class="index-cell">
			<p><?php echo $this->Text->truncate(strip_tags($child['content'])); ?></p>
		</div>
	</div>
<?php endforeach; ?>
</div>