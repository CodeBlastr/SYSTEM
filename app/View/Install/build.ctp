
	<div class="install form">
		
		<div class="container">
			
			
			<blockquote>
				<legend class="lead">Choose a default layout.</legend>
				<p> don't forget to make layouts work with themeable / drag / drop </p>
			  	<fieldset>
			        <?php foreach ($templates as $template) : ?>
			        	<?php if ($defaultTemplateName == $template['Template']['layout']) : // default template will get reset if you click this so, show warning ?>
			        		<a href="/install/template/<?php echo $template['Template']['id']; ?>" class="pull-left span2 text-center" title="Your current default template. Clicking here will reset this template back to it's original format, erasing any customizations to the template." onclick="return confirm('This is your currently used default template. Please confirm that you want to reset this template to the original version. It will erase any customizations made to this template.');">
				        		<?php echo $template['Template']['icon']; ?>
				        		<p class="muted" style="font-size: 0.85em;"><?php echo __('%s (active)', $template['Template']['layout']); ?></p> 
					        </a>
			        	<?php else : ?>
				        	<a href="/install/template/<?php echo $template['Template']['id']; ?>" class="pull-left span2 text-center" title="<?php echo $template['Template']['description']; ?>">
				        		<?php echo $template['Template']['icon']; ?>
				        		<p class="muted" style="font-size: 0.85em;"><?php echo $template['Template']['layout']; ?></p> 
					        </a>
				        <?php endif; ?>
			        <?php endforeach; ?>
				</fieldset>
			</blockquote>
			
			
		    <div class="progress">
			    <div class="bar bar-info" style="width: 25%;"></div>
			    <div class="bar bar-success" style="width: 25%;"></div>
			    <div class="bar bar-warning" style="width: 25%;"></div>
			    <div class="bar bar-danger" style="width: 25%;"></div>
		    </div>
 
    
			<blockquote>
				<legend class="lead"><?php echo __('Site settings'); ?> <small>we could put the favicon form here too</small></legend>
			  	<fieldset>
			        <?php
					echo $this->Form->create('Setting', array('class' => 'form-inline', 'url' => array('controller' => 'settings', 'action' => 'edit')));
					echo $this->Form->input('Override.redirect', array('value' => '/install/build', 'type' => 'hidden'));
					echo $this->Form->input('Setting.type', array('value' => 'System', 'type' => 'hidden'));
					echo $this->Form->input('Setting.name', array('value' => 'SITE_NAME', 'type' => 'hidden'));
					echo $this->Form->input('Setting.value', array('label' => 'Company Name', 'value' => __SYSTEM_SITE_NAME, 'type' => 'text'));
					echo $this->Form->end('Change'); ?>
				</fieldset>
			</blockquote>
			
			
		    <div class="progress">
			    <div class="bar bar-info" style="width: 25%;"></div>
			    <div class="bar bar-success" style="width: 25%;"></div>
			    <div class="bar bar-warning" style="width: 25%;"></div>
			    <div class="bar bar-danger" style="width: 25%;"></div>
		    </div>
			
			
			<blockquote>
				<legend class="lead"><?php echo __('User types'); ?></legend>
				<!--p>User usually fall into groups.  By grouping users we can control what parts of the site they have access to. </p-->
			  	<fieldset>
			        <?php foreach ($userRoles as $userRole) : ?>
			        	<span class="label label-info"><?php echo $userRole['UserRole']['name']; ?></span> 
			        <?php endforeach; ?>
			        
			        <?php 
					echo $this->Form->create('UserRole', array('class' => 'form-inline', 'url' => array('plugin' => 'users', 'controller' => 'user_roles', 'action' => 'add')));
					echo $this->Form->input('Override.redirect', array('value' => '/install/build', 'type' => 'hidden'));
					echo $this->Form->input('UserRole.name', array('label' => false, 'placeholder' => 'Add user type'));
					echo $this->Form->end('Add'); ?>
				</fieldset>
			</blockquote>
			
		    
			<?php foreach ($userRoles as $userRole) : ?>
			<div class="progress">
			    <div class="bar bar-info" style="width: 25%;"></div>
			    <div class="bar bar-success" style="width: 25%;"></div>
			    <div class="bar bar-warning" style="width: 25%;"></div>
			    <div class="bar bar-danger" style="width: 25%;"></div>
		    </div>
		    
		    
			<blockquote>
				<legend class="lead"><?php echo $userRole['UserRole']['name']; ?></legend>
				<?php $myMenus = Set::extract('/WebpageMenu[user_role_id=' . $userRole['UserRole']['id'] . ']', $menus); ?>
				<?php if (!empty($myMenus)) : ?>
					<?php foreach ($myMenus as $mine) : ?>
						<div class="primary page">
							<div class="primary name well">
								<?php echo $mine['WebpageMenu']['name']; ?>
							</div>
							<?php echo $this->Element('Webpages.menus', array('id' => $mine['WebpageMenu']['id'])); ?>
						</div>
					<?php endforeach; ?>
				<?php endif; ?>
				
				<p><?php echo __('Add page'); ?></p>
				<p><?php echo __('Add section'); ?></p>
				<p><?php echo __('Add plugin'); ?></p>
				<p><?php echo __('Add custom'); ?> <small>(could be a custom page type, or a custom plugin)</small></p>
			</blockquote>
			<?php endforeach; ?>
			
		</div>
	</div>

<style type="text/css">
	.primary.name {
		float: left;
	}
</style>

<?php /*
 some nice html for the icon

<!-- put webpage icon html here -->
<div style="height: 0px; padding-bottom: 80%; position:relative; width: 100%; float: left;">
	<div style="width: 100%; height: 100%; padding: 0; top: 0; position: absolute; background: #F5F5F5; border: 1px solid #E3E3E3; border-radius: 1em; overflow: hidden;">
		<div style="height: 15%; background: #5EB95E; margin: 0 auto; background-image: linear-gradient(to bottom, #62C462, #57A957); background-repeat: repeat-x; box-shadow: 1px 0 0 rgba(0, 0, 0, 0.15) inset, 0 -1px 0 rgba(0, 0, 0, 0.15) inset;"></div>
		<div style="display: table; width: 80%; height: 68%; margin:  0.1em auto;">
    		<div style="display: table-row;">
    			<div style="display: table-cell; width: 70%; height: 100%; margin: 0.3em 0 0.4em 1em; background-color: #FAA732; background-image: linear-gradient(to bottom, #FBB450, #F89406); background-repeat: repeat-x; box-shadow: 1px 0 0 rgba(0, 0, 0, 0.15) inset, 0 -1px 0 rgba(0, 0, 0, 0.15) inset;">.</div>
    			<div style="display: table-cell; height: 100%; margin: 0.3em 1em 0.4em 0; background-color: #4BB1CF; background-image: linear-gradient(to bottom, #5BC0DE, #339BB9); background-repeat: repeat-x; box-shadow: 1px 0 0 rgba(0, 0, 0, 0.15) inset, 0 -1px 0 rgba(0, 0, 0, 0.15) inset;">.</div>
    		</div>
    	</div>
		<div style="width: 100%; height: 15%; margin: 0 auto; background: #DD514C; background-image: linear-gradient(to bottom, #EE5F5B, #C43C35); background-repeat: repeat-x; box-shadow: 1px 0 0 rgba(0, 0, 0, 0.15) inset, 0 -1px 0 rgba(0, 0, 0, 0.15) inset;"></div>
	</div>
</div>
<!-- end webpage icon html here --> */ ?>