 <style type="text/css">
	legend .form-inline {
		position: relative;
		top: -5px;
	}
	.canvas {
		border: 1px solid #EAEAEA;
		border-radius: 0.3em 0.3em 0.3em 0.3em;
		box-shadow: 0 0 30px #CCCCCC inset;
		margin-top: -8em;
		padding: 9.3em 3em 1.6em;
		overflow: auto;
		overflow-x: scroll;
	}
	.menus.edit {
		margin-top: 9em;
	}
	.menus.edit.form .canvas.medium {
		transform: scale(0.8, 0.8);
		-ms-transform: scale(0.8, 0.8);
		-webkit-transform: scale(0.8, 0.8);
	}
	.menus.edit.form .canvas.small {
		transform: scale(0.6, 0.6);
		-ms-transform: scale(0.6, 0.6);
		-webkit-transform: scale(0.6, 0.6);
	}
	.menus.edit.form ul {
		width: 8.6em;
		margin-left: 8.6em;
		margin-top: -7.3em;
		box-sizing: border-box;
		list-style-type: none;
		
		/*background: -moz-linear-gradient(top,  rgba(143,200,0,0) 0%, rgba(143,200,0,0) 24%, rgba(143,200,0,1) 52%, rgba(143,200,0,0) 81%, rgba(143,200,0,0) 100%);
		background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,rgba(143,200,0,0)), color-stop(24%,rgba(143,200,0,0)), color-stop(52%,rgba(143,200,0,1)), color-stop(81%,rgba(143,200,0,0)), color-stop(100%,rgba(143,200,0,0)));
		background: -webkit-linear-gradient(top,  rgba(143,200,0,0) 0%,rgba(143,200,0,0) 24%,rgba(143,200,0,1) 52%,rgba(143,200,0,0) 81%,rgba(143,200,0,0) 100%);
		background: -o-linear-gradient(top,  rgba(143,200,0,0) 0%,rgba(143,200,0,0) 24%,rgba(143,200,0,1) 52%,rgba(143,200,0,0) 81%,rgba(143,200,0,0) 100%);
		background: -ms-linear-gradient(top,  rgba(143,200,0,0) 0%,rgba(143,200,0,0) 24%,rgba(143,200,0,1) 52%,rgba(143,200,0,0) 81%,rgba(143,200,0,0) 100%);
		background: linear-gradient(to bottom,  rgba(143,200,0,0) 0%,rgba(143,200,0,0) 24%,rgba(143,200,0,1) 52%,rgba(143,200,0,0) 81%,rgba(143,200,0,0) 100%);
		filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#008fc800', endColorstr='#008fc800',GradientType=0 );*/
	}
	.menus.edit.form ul ul ul {
		background: url("/img/flow.png") repeat-y scroll -100% center / 100px 117% transparent;
	}
	.menus.edit.form ul ul li {
		background: #4EC748;
	}
	.menus.edit.form .btn-danger {
		margin-bottom: 4px;
		margin-top: -22px;
		padding: 0 3px;
	}
	.menus.edit.form button.btn, .menus.edit.form input.btn[type="submit"] {
		padding: 3px 9px;
		margin: 0;
	}
	.menus.edit.form ul li div.item {
		position: absolute;
		top: 4.5em;
		width: 7.6em
	}
	.menus.edit.form ul ul li div.item {
		position: relative;
		top: auto;
	}
	.menus.edit.form ul li div.item {
		box-shadow: 1px 1px 1px #000000;
		min-height: 6em;
		padding: 6px;
		-moz-border-bottom-colors: none;
		-moz-border-left-colors: none;
		-moz-border-right-colors: none;
		-moz-border-top-colors: none;
		background: linear-gradient(to bottom, #FFFFFF 0%, #F6F6F6 47%, #EDEDED 100%) repeat scroll 0 0 transparent;
		border-color: #D4D4D4 #D4D4D4 #BCBCBC;
		border-image: none;
		border-radius: 3px 3px 3px 3px;
		border-style: solid;
		border-width: 1px;
		cursor: move;
		margin: -4.5em 0 0 0;
	}
	.menus.edit.form:hover ul li div.item {
		margin-top: 0;
	}
	.menus.edit.form .placeholder {
		max-height: 100px;
		min-height: 100px;
	}
	.menus.edit.form ul li.ui-sortable-helper div.item {
		margin-top: -4.5em !important;
	}
	.menus.edit.form li div.item a.toggle {
		color: #FFFFFF;
		font-weight: bold;
		text-align: center;
		text-shadow: 1px 1px #AAAAAA;
		text-transform: uppercase;
	}
	.menus.edit.form li div.item a.toggled  span.icon {
		display: none;
	}
	.toggleClick.toggle:after {
		content: "";
	}
	.menus.edit.form li div.item span.icon {
		display: inline-block;
		left: 2%;
		opacity: 0.25;
		position: relative;
		top: 0.3em;
		width: 90%;
		cursor: move;
	}
	.menus.edit.form li div.item a.toggle span.link {
		display: inline-block;
		left: 0;
		position: absolute;
		top: 26%;
		width: 100%;
		cursor: pointer;
	}
	.menus.edit.form li div.item:hover {
		z-index: 10;
	}
	.menus.edit.form li div.item a:hover span.icon {
		opacity: 0.7;
	}
	.menus.edit.form li div.item a:hover span.link {
		color: #000;
	}
	/*ul.sortable li div.item {
	 position: relative;
	 width: 6em;
	 }
	 ul.sortable ul li div.item {
	 position: relative;
	 left: 6em;
	 top: -3em;
	 }
	 ul.sortable ul ul li div.item {
	 position: relative;
	 left: 11em;
	 top: -6em;
	 }*/
</style>

<div class="install form">
	<div class="container">
				
		<div class="row-fluid">
			<legend class="lead">Choose a default layout.</legend>
		  	<fieldset>			        	
		        <?php foreach ($templates as $template) : ?>
		        	<?php if ($defaultTemplate[0]['Template']['layout'] == $template['Template']['layout']) : // default template will get reset if you click this so, show warning ?>
			        	<div class="pull-left span2 text-center">
		        			<a href="/install/template/<?php echo $template['Template']['id']; ?>" title="Your current default template. Clicking here will reset this template back to it's original format, erasing any customizations to the template." onclick="return confirm('This is your currently used default template. Please confirm that you want to reset this template to the original version. It will erase any customizations made to this template.');">
			        			<?php echo $template['Template']['icon']; ?>
			        			<?php echo __('%s (active)', $template['Template']['layout']); ?>
			        		</a>
				        	<span class="demo">
				        		<?php echo !empty($template['Template']['demo']) ? __('(%s)', $this->Html->link('demo', $template['Template']['demo'], array('target' => '_blank'))) : null; ?>
				        	</span>
				        </div>
		        	<?php else : ?>
			        	<div class="pull-left span2 text-center">
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
		
		<hr />
 
    
		<div class="row-fluid">
			<legend class="lead"><?php echo __('Site settings'); ?></legend>
		  	<fieldset class="row-fluid clearfix">
		        <div class="span5 pull-left">
		        	<?php echo $this->Form->create('Setting', array('class' => 'form-inline', 'url' => array('controller' => 'settings', 'action' => 'edit'))); ?>
			        <?php echo $this->Form->input('Override.redirect', array('value' => '/install/build', 'type' => 'hidden')); ?>
			        <?php echo $this->Form->input('Setting.type', array('value' => 'System', 'type' => 'hidden')); ?>
			        <?php echo $this->Form->input('Setting.name', array('value' => 'SITE_NAME', 'type' => 'hidden')); ?>
			        <?php echo $this->Form->input('Setting.value', array('label' => 'Company Name', 'value' => __SYSTEM_SITE_NAME, 'type' => 'text')); ?>
			        <?php echo $this->Form->end('Change'); ?>
			    </div>

		        <div class="span5 pull-right">
		          	<?php echo $this->Form->create('Admin', array('class' => 'form-inline', 'url' => array('controller' => 'admin', 'action' => 'index'), 'type' => 'file')); ?>
					<?php echo $this->Form->input('Override.redirect', array('value' => '/install/build', 'type' => 'hidden')); ?>
			        <?php echo $this->Form->input('icon', array('type' => 'file', 'label' => 'Favicon')); ?>
					<?php echo $this->Form->end('Upload'); ?>
				</div>
			</fieldset>
		</div>
		
		<hr />
		
		<div class="row-fluid">
			<legend class="lead"><?php echo __('User types'); ?></legend>
			<!--p>User usually fall into groups.  By grouping users we can control what parts of the site they have access to. </p-->
		  	<fieldset class="row-fluid clearfix">
		  		<div class="span5 pull-left">
			        <?php foreach ($userRoles as $userRole) : ?>
			        	<span class="label label-info"><?php echo $userRole['UserRole']['name']; ?></span> 
			        <?php endforeach; ?>
			        
			        <?php echo $this->Form->create('UserRole', array('class' => 'form-inline', 'url' => array('plugin' => 'users', 'controller' => 'user_roles', 'action' => 'add'))); ?>
					<?php echo $this->Form->input('Override.redirect', array('value' => '/install/build', 'type' => 'hidden')); ?>
					<?php echo $this->Form->input('UserRole.name', array('label' => false, 'placeholder' => 'Add user type')); ?>
					<?php echo $this->Form->end('Add'); ?>
				</div>
 				
		  		<div class="span5 pull-right">
	 				<?php echo $this->Form->create('WebpageMenu', array('class' => 'form-inline', 'url' => array('plugin' => false, 'controller' => 'install', 'action' => 'menu'), 'class' => 'form-inline')); ?>
					<?php echo $this->Form->input('Override.redirect', array('value' => '/install/build', 'type' => 'hidden')); ?>
					<?php echo $this->Form->input('WebpageMenu.user_role_id', array('options' => $userRoleOptions, 'label' => 'New flow for', 'value' => $mine['WebpageMenu']['user_role_id'], 'div' => array('class' => 'input-prepend'), 'class' => 'prependedInput', 'between' => '<span class="add-on">&nbsp;&nbsp;<i class="icon-user"></i>&nbsp;</i></span>')); ?>
					<?php //echo $this->Form->input('WebpageMenu.template', array('options' => array('0' => 'fill this with template names'), 'label' => false, 'div' => array('class' => 'input-prepend'), 'class' => 'prependedInput span1', 'before' => '<span class="add-on">&nbsp;&nbsp;<i class="icon-eye-open"></i>&nbsp;</span>')); ?>
					<?php echo $this->Form->submit('Save', array('div' => false, 'class' => 'btn btn-success btn-small')); ?>
					<?php echo $this->Form->end(); ?>
				</div>
			</fieldset>
		</div>
		
	    
		<?php foreach ($userRoles as $userRole) : ?>
			<?php $var = $userRole['UserRole']['name'] . 'Sections'; $myMenus = $$var; ?>
			<?php foreach ($myMenus as $mine) : ?>
				<hr />
	    
	    
				<div class="row-fluid clearfix">
						<legend class="lead row-fluid clearfix">
							<?php 
							// sucks to put this here, but unless we make a function in the ZuhaSet class it stays (because we're in a loop which wouldn't work well in the controller)
							$continue = false;
							unset($dropdown);
							foreach ($menus as $id => $menu) {
								if ($id == $mine['WebpageMenu']['id']) {
									$dropdown[$id] = $menu;
									$continue = true;
								} else {
									if ($continue === true && strpos($menu, '-') === 0) {
										$dropdown[$id] = $menu;
									} else {
										$continue = false;
									}
								}
							} ?>
							<div class="span10 pull-left create-menu-item">
								<!-- page or section form -->
								<?php echo $this->Form->create('WebpageMenuItem', array('class' => 'form-inline', 'url' => array('plugin' => 'webpages', 'controller' => 'webpage_menu_items', 'action' => 'add'))); ?>
								<?php echo $this->Form->input('Override.redirect', array('value' => '/install/build', 'type' => 'hidden')); ?>
								<?php echo $this->Form->input('WebpageMenuItem.user_role_id', array('value' => $userRole['UserRole']['session_user_role_id'], 'type' => 'hidden')); ?>
								After  
								<?php echo $this->Form->input('WebpageMenuItem.menu_id', array('label' => false, 'options' => $dropdown, 'class' => 'input-medium')); ?>
								<?php echo $userRole['UserRole']['name']; ?> should go to a 
								<?php echo $this->Form->input('WebpageMenuItem.page_type', array('type' => 'select', 'label' => false, 'options' => array('content' => 'page', 'section' => 'section', 'plugin' => 'plugin'), 'class' => 'input-small')); ?>
								<?php echo $this->Form->input('WebpageMenuItem.item_text', array('label' => false, 'placeholder' => 'called', 'class' => 'input-small')); ?>
								<?php echo $this->Form->end(array('label' => 'Save', 'class' => 'btn-success btn-small')); ?>
								
								<!-- plugin form -->
								<?php echo $this->Form->create('WebpageMenuItem', array('class' => 'form-inline', 'url' => array('plugin' => false, 'controller' => 'install', 'action' => 'build'))); ?>
								<?php echo $this->Form->input('Override.redirect', array('value' => '/install/build', 'type' => 'hidden')); ?>
								<?php echo $this->Form->input('WebpageMenuItem.user_role_id', array('value' => $userRole['UserRole']['session_user_role_id'], 'type' => 'hidden')); ?>
								After  
								<?php echo $this->Form->input('WebpageMenuItem.menu_id', array('label' => false, 'options' => $dropdown, 'class' => 'input-medium')); ?>
								<?php echo $userRole['UserRole']['name']; ?> should go to a 
								<?php echo $this->Form->input('WebpageMenuItem.page_type', array('type' => 'select', 'label' => false, 'options' => array('content' => 'page', 'section' => 'section', 'plugin' => 'plugin'), 'value' => 'plugin', 'class' => 'input-small')); ?>
								<?php echo $this->Form->input('WebpageMenuItem.item_text', array('label' => false, 'type' => 'select', 'options' => $plugins, 'class' => 'input-small')); ?>
								<?php echo $this->Form->end(array('label' => 'Save', 'class' => 'btn-success btn-small')); ?>
							</div>
							
							
							
							<div class="span1 pull-right">
								<?php echo $this->Html->link('<i class="icon-minus"></i>', '#', array('class' => 'shrink', 'data-target' => '#canvas' . $mine['WebpageMenu']['id'], 'escape' => false)); ?>
								<?php echo $this->Html->link('<i class="icon-plus"></i>', '#', array('class' => 'grow', 'data-target' => '#canvas' . $mine['WebpageMenu']['id'], 'escape' => false)); ?>
							</div>
						</legend>
						<div class="menus edit">
							 <div class="menus edit form">
						    	<div class="canvas" id="canvas<?php echo $mine['WebpageMenu']['id']; ?>">
						    		<ul style="margin-left: 0em; padding-left: 28px; background: url('/img/flow.png') repeat-y scroll -70% center / 220px 117% transparent;">
						    			<li style="position: relative; left: -2em;">
						    				<div class="item home">
												<?php echo $this->Html->link(__('<span class="icon"> %s </span> <span class="link"> %s </span>', $defaultTemplate[0]['Template']['icon'], $mine['WebpageMenu']['name']), '#', array('class' => 'toggleClick toggle', 'data-target' => '#form' . $mine['WebpageMenu']['id'], 'escape' => false)); ?>
												<div id="form<?php echo $mine['WebpageMenu']['id']; ?>">
													<?php echo $this->Form->create('WebpageMenu', array('class' => 'form-inline', 'url' => array('plugin' => 'webpages', 'controller' => 'webpage_menus', 'action' => 'edit'), 'class' => 'form-inline')); ?>
													<?php echo $this->Form->input('Override.redirect', array('value' => '/install/build', 'type' => 'hidden')); ?>
													<?php echo $this->Form->input('WebpageMenu.id', array('type' => 'hidden', 'value' => $mine['WebpageMenu']['id'])); ?>
													<?php echo $this->Form->input('WebpageMenu.user_role_id', array('options' => array('0' => 'fill this with user role names'), 'label' => false, 'value' => $mine['WebpageMenu']['user_role_id'], 'div' => array('class' => 'input-prepend'), 'class' => 'prependedInput span1', 'before' => '<span class="add-on">&nbsp;&nbsp;<i class="icon-user"></i>&nbsp;</i></span>')); ?>
													<?php echo $this->Form->input('WebpageMenu.template', array('options' => array('0' => 'fill this with template names'), 'label' => false, 'div' => array('class' => 'input-prepend'), 'class' => 'prependedInput span1', 'before' => '<span class="add-on">&nbsp;&nbsp;<i class="icon-eye-open"></i>&nbsp;</span>')); ?>
													<?php echo $this->Form->submit('Save', array('div' => false, 'class' => 'btn btn-success btn-small')); ?>
													<?php echo $this->Form->end(); ?>
												</div>
						    				</div>
						    			</li>
						    			
								        <?php
										$this->Tree->addTypeAttribute('data-identifier', $mine['WebpageMenu']['id'], null, 'previous');
										$remove[] = Set::extract('/WebpageMenu[name=' . $mine['WebpageMenu']['name'] . ']', $mine['children']);
										// used in javascript below
										echo $this->Tree->generate($mine['children'], array('model' => 'WebpageMenu', 'alias' => 'item_text', 'class' => 'sortable sortableMenu', 'id' => 'menu' . $mine['WebpageMenu']['id'], 'element' => 'Webpages.menus/links/build'));
										?>
									</ul>
								</div>
						    </div>						
						</div>
					
				</div>
			<?php endforeach; ?>
				
		<?php endforeach; ?>
		
		<hr />
		
	</div>
</div>

<?php echo $this->Html->css('/css/jquery-ui/jquery-ui-1.9.2.custom.min'); ?>
<?php echo $this->Html->css('/webpages/menus/css/nestedSortable'); ?>
<?php echo $this->Html->script('/js/jquery-ui/jquery-ui-1.9.2.custom.min'); ?>
<?php echo $this->Html->script('/webpages/menus/js/jquery.ui.nestedSortable'); ?>
<?php //echo $this->Html->script('/webpages/menus/js/jquery.jsPlumb.min'); ?>
<script type="text/javascript">
	// trying to get lines to draw, but it's not the most important thing
// re-enable jsPlumb.min if you want to try again
// jsPlumb.ready(function() {
	// var firstInstance = jsPlumb.getInstance();
	// firstInstance.importDefaults({
	  // PaintStyle:{ 
	    // lineWidth:2, 
	    // strokeStyle:"#FF3300", 
	    // outlineColor:"#FF3300", 
	    // outlineWidth:1 
	  // },
	  // EndpointStyle : {
	  	// fillStyle:"#FF3300",
	    // lineWidth:2, 
	    // strokeStyle:"#FF3300", 
	    // outlineColor:"#FF3300", 
	    // outlineWidth:0,
	    // radius: 5 
	  // },
	  // Connector : [ "Bezier", { curviness: 20 } ],
	  // Anchors : [ "LeftMiddle", "RightMiddle" ]
	// });
// 	
	// firstInstance.connect({
	  // source: $('#li_522780f1-ccd8-4e9f-bfc8-24b90ad25527'), 
	  // target: $('#li_52275c71-301c-49d1-8cd9-34970ad25527 .item'), 
	  // //scope:"someScope" 
	// });
// });

$(document).ready(function() {
	// switching menu item form between content/section vs plugin form type
	$('.create-menu-item form:last-child').hide();
	$('.create-menu-item form select[name="data\[WebpageMenuItem\]\[page_type\]"]').change( function() {
		handleFormDisplay();
	});
	function handleFormDisplay() {
		$.each($('.create-menu-item'), function() {
			if ($('form:first-child select[name="data\[WebpageMenuItem\]\[page_type\]"]', this).val() == 'plugin') {
				$('form:first-child select[name="data\[WebpageMenuItem\]\[page_type\]"]', this).val('content');
				$('form:first-child', this).hide();
				$('form:last-child select[name="data\[WebpageMenuItem\]\[page_type\]"]', this).val('plugin');
				$('form:last-child', this).show();
			} else {
				if($('form:last-child select[name="data\[WebpageMenuItem\]\[page_type\]"]', this).is(":visible")) {
					$('form:first-child select[name="data\[WebpageMenuItem\]\[page_type\]"]', this).val($('form:last-child select[name="data\[WebpageMenuItem\]\[page_type\]"]', this).val());
				}
				$('form:first-child', this).show();
				$('form:last-child select[name="data\[WebpageMenuItem\]\[page_type\]"]', this).val('plugin');
				$('form:last-child', this).hide();
			}
		});
	}
	
	
	// some calculated styles needed
	var timer = false;
	$('.menus.edit.form').hover( 
		function () {
			var obj = $('.item.home', this);
			if(timer) {
				clearTimeout(timer);
				timer = null
			}
			timer = setTimeout(function() {
				positionHome(obj, false);
			}, 50);
		},
		function () {
			var obj = $('.item.home', this);
			if(timer) {
				clearTimeout(timer);
				timer = null
			}
			timer = setTimeout(function() {
				positionHome(obj, true);
			}, 50);
		}
	);
	function positionHome(obj, diff) {
		var height = obj.parent().parent().height();
		if (diff) {
			var top = (height / 2);
		} else {
			var top = (height / 2) - (obj.height() / 1.3);
		}
		//still doesn't work perfectly
		//console.log('help' + parseInt(top));
		//console.log(obj);
		//console.log(parseInt(obj.height()));
		if (parseInt(top) > parseInt(obj.height())) {
			obj.css('top', top + 'px');
		} else {
			obj.css('margin-top', '-4.4em');
		}
	}
	
    <?php foreach ($remove as $li) : ?>
    	<?php if (!empty($li[0]['WebpageMenu']['id'])) : ?>
    // remove a link that has the same name as the menu (eg. Home menu links to Homepage) and we don't need it on the build page
    $('#li_<?php echo $li[0]['WebpageMenu']['id']; ?>').hide();
    	<?php endif; ?>
    <?php endforeach; ?>
    
	$('.sortableMenu a').click(function(e) {
		e.preventDefault();
	});
	
	$('.shrink').click(function(e) {
		e.preventDefault();
		if ($($(this).attr('data-target')).hasClass('medium')) {
			$($(this).attr('data-target')).removeClass('medium').addClass('small');
		} else {
			$($(this).attr('data-target')).addClass('medium');
		}
	});
	
	$('.grow').click(function(e) {
		e.preventDefault();
		if ($($(this).attr('data-target')).hasClass('small')) {
			$($(this).attr('data-target')).removeClass('small').addClass('medium');
		} else {
			$($(this).attr('data-target')).removeClass('medium');
		}
	});
<?php foreach ($myMenus as $mine) : ?>
	$('ul#menu<?php echo $mine['WebpageMenu']['id']; ?>').nestedSortable({
		forcePlaceholderSize: true,
		listType: 'ul',
		handle: 'div',
		helper: 'clone',
		opacity: .6,
    	placeholder: 'placeholder',
        rootID: '<?php echo $mine['WebpageMenu']['id']; ?>',
		items: "li",
		delay: 100,
		tolerance: 'pointer',
		toleranceElement: '> div',
		update: function(event, ui) {
			//$('#loadingimg').show();
			var order = $('ul#menu<?php echo $mine['WebpageMenu']['id']; ?>').nestedSortable('toArray');
			$.post('/webpages/webpage_menu_items/sort.json', {order:order},	function(data){
				//$('#loadingimg').hide()
			});
		}
	});
<?php endforeach; ?>
});
</script>

<?php
/*
 some nice html for the icon field

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
 <!-- end webpage icon html here --> */
 ?>