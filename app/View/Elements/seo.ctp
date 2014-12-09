<?php if (!empty($keywords_for_layout)) : ?>
	<?php echo $this->Html->meta('keywords', $keywords_for_layout); ?>
<?php endif; ?>

<?php if (!empty($description_for_layout)) : ?>
	<?php echo $this->Html->meta('description', $description_for_layout); ?>
<?php endif; ?>