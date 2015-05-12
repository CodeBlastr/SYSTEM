<div class="row">
	<div class="col-md-6">
		<legend class="lead">Change the Default Template</legend>
	  	<fieldset>			        	
	        <?php foreach ($templates as $template) : ?>
	        	<?php if ($defaultTemplate[0]['Template']['layout'] == $template['Template']['layout']) : // default template will get reset if you click this so, show warning ?>
		        	<div class="col-xs-2 text-center">
	        			<a href="/install/template/<?php echo $template['Template']['id']; ?>" title="Your current default template. Clicking here will reset this template back to it's original format, erasing any customizations to the template." onclick="return confirm('This is your currently used default template. Please confirm that you want to reset this template to the original version. It will erase any customizations made to this template.');">
		        			<?php echo $template['Template']['icon']; ?>
		        			<?php echo __('%s (active)', $template['Template']['layout']); ?>
		        		</a>
			        	<span class="demo">
			        		<?php echo !empty($template['Template']['demo']) ? __('(%s)', $this->Html->link('demo', $template['Template']['demo'], array('target' => '_blank'))) : null; ?>
			        	</span>
			        </div>
	        	<?php else : ?>
		        	<div class="col-xs-2 text-center">
		        		<a href="/install/template/<?php echo $template['Template']['id']; ?>" title="<?php echo $template['Template']['description']; ?>">
			        		<?php echo $template['Template']['icon']; ?>
			        		<?php echo $template['Template']['layout']; ?>
			        	</a>
			        	<span class="demo">
			        		<?php echo !empty($template['Template']['demo']) ? __('(%s)', $this->Html->link('demo', $template['Template']['demo'], array('target' => '_blank'))) : null; ?>
			        	</span>
			        </div>
		        <?php endif; ?>
	        <?php endforeach; ?>
		</fieldset>
	</div>
	
	<div class="col-md-6">
		<legend class="lead">Installed Templates</legend>
		<div class="list-group">
			<?php foreach ($webpages as $template) : ?>
				<div class="list-group-item">
					<?php echo $this->Html->link($template['Webpage']['name'], array('plugin' => 'webpages', 'controller' => 'webpages', 'action' => 'edit', $template['Webpage']['id'])); ?>
					<?php echo $this->Html->link('<i class="glyphicon glyphicon-floppy-save"></i>', array('plugin' => 'webpages', 'controller' => 'webpages', 'action' => 'export', $template['Webpage']['id']), array('class' => 'badge', 'escape' => false, 'title' => 'Export')); ?>
					<?php echo $this->Html->link('<i class="glyphicon glyphicon-pencil"></i>', array('plugin' => 'webpages', 'controller' => 'webpages', 'action' => 'edit', $template['Webpage']['id']), array('class' => 'badge', 'escape' => false, 'title' => 'Edit')); ?>
					<?php
					$badgeClass = array(
						'Not Used' => 'alert-danger',
						'Default' => 'alert-success',
						'Specific Pages' => 'alert-info'
					)
					?>
					<span class="badge <?echo $badgeClass[$template['Webpage']['_usage']] ?>"><?php echo $template['Webpage']['_usage']; ?></span>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
</div>

<?php
// set the contextual menu items
$this->set('context_menu', array('menus' => array(
	array(
		'heading' => 'Webpages',
		'items' => array(
			$this->Paginator->sort('name', 'Sort by Name'),
			$this->Html->link(__('Add'), array('controller' => 'webpages', 'action' => 'add', 'template')),
			)
		),
	)));