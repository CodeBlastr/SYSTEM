 <style type="text/css">
 	/*Now the CSS*/
* {margin: 0; padding: 0;}

.navbar-fixed-top {
	display: none;
}
.notree li {
	margin-left: 25px;
}
.tree * {
	vertical-align: top;
}
.tree ul {
	padding-top: 20px; position: relative;
	
	transition: all 0.5s;
	-webkit-transition: all 0.5s;
	-moz-transition: all 0.5s;
	margin: 0;
}

.tree li {
	float: left; text-align: center;
	list-style-type: none;
	position: relative;
	padding: 20px 5px 0 5px;
	
	transition: all 0.5s;
	-webkit-transition: all 0.5s;
	-moz-transition: all 0.5s;
}

/*We will use ::before and ::after to draw the connectors*/

.tree li::before, .tree li::after{
	content: '';
	position: absolute; top: 0; right: 50%;
	border-top: 1px solid #ccc;
	width: 50%; height: 20px;
}
.tree li::after{
	right: auto; left: 50%;
	border-left: 1px solid #ccc;
}

/*We need to remove left-right connectors from elements without 
any siblings*/
.tree li:only-child::after, .tree li:only-child::before {
	display: none;
}

/*Remove space from the top of single children*/
.tree li:only-child{ padding-top: 0;}

/*Remove left connector from first child and 
right connector from last child*/
.tree li:first-child::before, .tree li:last-child::after{
	border: 0 none;
}
/*Adding back the vertical connector to the last nodes*/
.tree li:last-child::before{
	border-right: 1px solid #ccc;
	border-radius: 0 5px 0 0;
	-webkit-border-radius: 0 5px 0 0;
	-moz-border-radius: 0 5px 0 0;
}
.tree li:first-child::after{
	border-radius: 5px 0 0 0;
	-webkit-border-radius: 5px 0 0 0;
	-moz-border-radius: 5px 0 0 0;
}

/*Time to add downward connectors from parents*/
.tree ul ul::before{
	content: '';
	position: absolute; top: 0; left: 50%;
	border-left: 1px solid #ccc;
	width: 0; height: 20px;
}

.tree li div.item {
	background: #ffffff;
	border: 1px solid #ccc;
	padding: 6px 19px;
	text-decoration: none;
	color: #666;
	font-family: arial, verdana, tahoma;
	font-size: 1.6em;
	display: inline-block;
	
	border-radius: 5px;
	-webkit-border-radius: 5px;
	-moz-border-radius: 5px;
	
	transition: all 0.5s;
	-webkit-transition: all 0.5s;
	-moz-transition: all 0.5s;
}

/*Time for some hover effects*/
/*We will apply the hover effect the the lineage of the element also*/
.tree li div.item:hover, .tree li div.item:hover+ul li div.item {
	background: #c8e4f8; color: #000; border: 1px solid #94a0b4;
}
/*Connector styles on hover*/
.tree li div.item:hover+ul li::after, 
.tree li div.item:hover+ul li::before, 
.tree li div.item:hover+ul::before, 
.tree li div.item:hover+ul ul::before{
	border-color:  #94a0b4;
}


.navbar-fixed-bottom {
	display:none;
}
div.canvas {
	background: #f9f9f9;
	border: 1px solid #eaeaea;
	border-radius: 0.3em 0.3em 0.3em 0.3em;
	box-shadow: 0 0 10px #bbb inset;
	overflow: scroll;
	max-height: 30em;
	max-width: 100%;
	padding: 1.5em 0.5em 4em;
}
div.canvas.tree {
	text-align: center;
}
.for-centering {
	display: inline-block;
}
.for-centering ul:first-child {
	float: left;
}
.switch, .toggle {
	width: auto;
}
span.icon {
	max-width: 64px;
	display: block;
	float: left;
}

.grow {
	display: none;
}

/* medium canvas */ 
.medium .menus.edit.form .canvas.tree li div.item {
	padding: 3px 7px;
	font-size: 1em;
}
.medium .shrink, .medium .grow {
	display: inline;
}

/* small canvas */
.small .menus.edit.form .canvas.tree ul {
	padding-top: 2px;
}
.small .menus.edit.form .canvas.tree ul ul::before {
	top: -6px;
	height: 9px;
}
.small .menus.edit.form .canvas.tree li {
	padding: 11px 5px 0 5px;
}
.small .menus.edit.form .canvas.tree li::before, .small .menus.edit.form .canvas.tree li::after {
	height: 12px;
}
.small .menus.edit.form .canvas.tree li:only-child {
	padding-top: 0;
}
.small .menus.edit.form .canvas.tree li div.item  {
	padding: 1px 5px;
	font-size: 0.5em;
}
.small .shrink {
	display: none;
}
.small .grow {
	display: inline;
}



.menus.edit.form a {
	color: #000;
	cursor:default;
}
.menus.edit.form a:hover {
	text-decoration: none;
}
.placeholder {
	min-width: 50px;
	min-height: 10px;
	border: 1px dashed #444;
}
.ui-tooltip {
	background: #fff;
	opacity: 1;
}
.modal-body {
	text-align: left;
}
.modal-body textarea {
	width: 100%;
}
/* Css Logo */
.brand {
	/*font-family: 'Myriad Pro', sans-serif;*/
	color: #8A8A8A;
	font-family: 'Open Sans', sans-serif;
	font-size: 0.05em; /* should be able to control the whole logo from here */
	padding: 2em 0 10em;
	white-space: nowrap;
}
.brand .name {
	font-size: 21em;
	line-height: 0.74em;
	display: inline;
}
.brand .name .rr {
	bac.kground: none repeat scroll 0 0 #85B13F;
	background: #85B13F; /* Old browsers */
	background: -moz-linear-gradient(top,  #85B13F 0%, #85B13F 100%); /* FF3.6+ */
	background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#85B13F), color-stop(100%,#85B13F)); /* Chrome,Safari4+ */
	background: -webkit-linear-gradient(top,  #85B13F 0%,#85B13F 100%); /* Chrome10+,Safari5.1+ */
	background: -o-linear-gradient(top,  #85B13F 0%,#85B13F 100%); /* Opera 11.10+ */
	background: -ms-linear-gradient(top,  #85B13F 0%,#85B13F 100%); /* IE10+ */
	background: linear-gradient(to bottom,  #85B13F 0%,#85B13F 100%); /* W3C */
	filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#85B13F', endColorstr='#85B13F',GradientType=0 ); /* IE6-9 */
	
	background-repeat:no-repeat;
	background-position: -0.05em -0.106em;
	
	color: #FFFFFF;
	display: inline-block;
	margin-top: 0;
	height: 0.8em;
}
.brand .tagline {
	display: block;
	font-size: 3.2em;
	letter-spacing: 0.27em;
	line-height: 1;
	text-transform: uppercase;
	margin-top: 1.1em;
	font-weight: 400;
}
.green {
	color: #85B13F;
}
footer {
	margin-top: 10em;
}
</style>

<div class="install form" id="install">
	<div class="container">
		<?php $this->Session->read('Message.flash.message') == 'The UserRole has been saved' ? $in = 'in' : $in = null; ?>
		<a href="#userRoleManager" class="btn btn-inverse" data-toggle="collapse" data-target=".userRoleManager" style="position: absolute; top: -5px; right: 80px;"> <i class="glyphicon glyphicon-cog"></i> Config</a>
		
		<div class="well row collapse <?php echo $in; ?> userRoleManager">
			<legend class="lead text-muted">
				Current User Roles 
		        <?php foreach ($userRoles as $userRole) : ?>
		        	 <span class="badge badge-default"><?php echo $userRole['UserRole']['name']; ?></span>
		        <?php endforeach; ?>
		        <?php echo !empty($in) ? '<span class="text-success"><i class="glyphicon glyphicon-arrow-left"></i> User Role Added</span>' : null; ?>
		 		<?php echo $this->Html->link('Approve', array('action' => 'approve'), array('class' => 'btn btn-success btn-xs pull-right', 'rel' => 'tooltip', 'title' => 'Notify your project manager of an approved site flow.')); ?>
			</legend>

		  	<fieldset class="row clearfix">
		  		<div class="col-md-8 span8">
	 				<?php echo $this->Form->create('WebpageMenu', array('class' => 'form-inline', 'url' => array('plugin' => false, 'controller' => 'install', 'action' => 'menu'), 'class' => 'form-inline')); ?>
					<?php echo $this->Form->input('Override.redirect', array('value' => '/install/client', 'type' => 'hidden')); ?>
					<?php echo $this->Form->input('WebpageMenu.user_role_id', array('options' => $userRoleOptions, 'label' => 'New flow for', 'value' => $mine['WebpageMenu']['user_role_id'], 'div' => false, 'class' => 'input-sm')); ?>
					<?php //echo $this->Form->input('WebpageMenu.template', array('options' => array('0' => 'fill this with template names'), 'label' => false, 'div' => array('class' => 'input-prepend'), 'class' => 'prependedInput span1', 'before' => '<span class="add-on">&nbsp;&nbsp;<i class="icon-eye-open"></i>&nbsp;</span>')); ?>
					<?php echo $this->Form->submit('Save', array('div' => false, 'class' => 'btn btn-primary btn-sm btn-small')); ?>
					<?php echo !empty($in) ? '<span class="lead text-success"><i class="glyphicon glyphicon-arrow-left"></i> Add Experience Visualizer Here</span>' : null; ?>
					<?php echo $this->Form->end(); ?>
				</div>
		  		<div class="span4 col-md-4 text-right">
			        <?php echo $this->Form->create('UserRole', array('class' => 'form-inline', 'url' => array('plugin' => 'users', 'controller' => 'user_roles', 'action' => 'add'))); ?>
					<?php echo $this->Form->input('Override.redirect', array('value' => '/install/client', 'type' => 'hidden')); ?>
					<?php echo $this->Form->input('UserRole.name', array('label' => false, 'placeholder' => 'Add user type (eg. paid-users)', 'style' => 'width: 200px', 'class' => 'input-sm')); ?>
					<?php echo $this->Form->end(array('label' => 'Add', 'class' => 'btn-sm')); ?>
				</div>
			</fieldset>
		</div>

		<div class="jumbotron hero-unit alert clearfix" style="display:none;">
			<div class="col-md-7">
				<h2> <?php echo __SYSTEM_SITE_NAME; ?> Experience Visualizer <br /></h2>
				<p class="lead">
					How will visitors experience your site?  Your site should be easy and intuitive.  It should 
					have a logical flow that moves users from the homepage through to the goal of accomplishing what they came for.
					Whether that is becoming a lead for your business, or using a custom application, this is a tool used to visualize
					how that user will experience your site.  
				</p>
			</div>
			<div class="col-md-5 text-right">
				<h2><small> <cite>brought to you by <a href="http://buildrr.com/" class="brand active"><span class="name">build<span class="rr">r</span>r</span></a> </cite></small></h2>
				<img src="/img/install/visualizer.jpg" class="img-thumbnail" style="margin: 0 0 12px 0" />
			</div>
			<a data-dismiss="alert" class="btn btn-lg btn-warning pull-right" type="button" style="margin-right: 16px">Dismiss Info Box</a>
		</div>
		
	    
		<?php foreach ($userRoles as $userRole) : ?>
			<?php $var = preg_replace("/[^A-Za-z]/", '', $userRole['UserRole']['name']) . 'Sections'; $myMenus = $$var; ?>
			<?php foreach ($myMenus as $mine) : $jsMenus[] = $mine; ?>

				<div class="row-fluid clearfix">
					<div class="lead row-fluid clearfix">
						<?php 
						// sucks to put this here, but unless we make a function in the ZuhaSet class it stays (because we're in a loop which wouldn't work well in the controller)
						// used for removing values from the drop down (eg. --Home, because Home is the name of the menu), and turning it into a 'list' format
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
					</div>
						
					<div class="row">
						<div class="col-md-4">
							<h4 style="margin-top:0; white-space: nowrap; text-overflow: ellipsis; overflow: hidden;">
								<?php echo $this->Html->link('<i class="glyphicon glyphicon-list"></i>', '#', array('class' => 'reorder', 'rel' => 'tooltip', 'title' => 'Re-order easier with a drag and drop list.', 'data-target' => '#canvas' . $mine['WebpageMenu']['id'], 'escape' => false)); ?>
								<?php echo $this->Html->link('<i class="glyphicon glyphicon-resize-small"></i>', '#', array('class' => 'shrink', 'data-target' => '#install', 'escape' => false)); ?>
								<?php echo $this->Html->link('<i class="glyphicon glyphicon-resize-full"></i>', '#', array('class' => 'grow', 'data-target' => '#install', 'escape' => false)); ?>
								<?php echo Inflector::humanize($userRole['UserRole']['name']); ?> Experience Visualizer
							</h4>
						</div>
						<div class="col-md-8 text-right">
							<div class="create-menu-item">
								<!-- page or section form -->
								<?php echo $this->Form->create('WebpageMenuItem', array('class' => 'form-inline', 'url' => array('plugin' => 'webpages', 'controller' => 'webpage_menu_items', 'action' => 'add'))); ?>
								<?php echo $this->Form->input('Override.redirect', array('value' => '/install/client', 'type' => 'hidden')); ?>
								<?php echo $this->Form->input('WebpageMenuItem.user_role_id', array('value' => $userRole['UserRole']['session_user_role_id'], 'type' => 'hidden')); ?>
								From the  
								<?php echo $this->Form->input('WebpageMenuItem.menu_id', array('label' => false, 'options' => $dropdown, 'class' => 'input-medium input-sm')); ?>
								&nbsp;&nbsp; page <?php echo $userRole['UserRole']['name']; ?> can go to the
								<?php echo $this->Form->input('WebpageMenuItem.page_type', array('type' => 'select', 'label' => false, 'options' => array('content' => 'page', 'section' => 'section', 'plugin' => 'plugin'), 'class' => 'input-small input-sm')); ?>
								<a style="position: relative; top: -17px; left: -2px;" rel="tooltip" title="Pages are just one page static content (like about us), a Section is when you have multiple articles under one page (like news), a Plugin is when you have dynamically generated content based on user interaction."><i class="glyphicon glyphicon-question-sign"></i></a>
								<?php echo $this->Form->input('WebpageMenuItem.item_text', array('label' => false, 'placeholder' => 'page or section name', 'class' => 'input-small input-sm')); ?>
								<?php echo $this->Form->end(array('label' => 'Save', 'class' => 'btn-success btn-small btn-sm')); ?>
								
								<!-- plugin form -->
								<?php echo $this->Form->create('WebpageMenuItem', array('class' => 'form-inline', 'url' => array('plugin' => false, 'controller' => 'install', 'action' => 'client'))); ?>
								<?php echo $this->Form->input('Override.redirect', array('value' => '/install/client', 'type' => 'hidden')); ?>
								<?php echo $this->Form->input('WebpageMenuItem.user_role_id', array('value' => $userRole['UserRole']['session_user_role_id'], 'type' => 'hidden')); ?>
								After  
								<?php echo $this->Form->input('WebpageMenuItem.menu_id', array('label' => false, 'options' => $dropdown, 'class' => 'input-medium input-sm')); ?>
								&nbsp;&nbsp; page <?php echo $userRole['UserRole']['name']; ?> can go to the
								<?php echo $this->Form->input('WebpageMenuItem.page_type', array('type' => 'select', 'label' => false, 'options' => array('content' => 'page', 'section' => 'section', 'plugin' => 'plugin'), 'value' => 'plugin', 'class' => 'input-small input-sm')); ?>
								<a style="position: relative; top: -17px; left: -2px;" rel="tooltip" title="Pages are just one page static content (like about us), a Section is when you have multiple articles under one page (like news), a Plugin is when you have dynamically generated content based on user interaction."><i class="glyphicon glyphicon-question-sign"></i></a>
								<?php echo $this->Form->input('WebpageMenuItem.item_text', array('label' => false, 'type' => 'select', 'options' => $plugins, 'class' => 'input-small input-sm')); ?>
								<?php echo $this->Form->end(array('label' => 'Save', 'class' => 'btn-success btn-small btn-sm')); ?>
							</div>
						</div>
					</div>

					<div class="row menus edit">
						 <div class="menus edit form">
					    	<div class="canvas tree" id="canvas<?php echo $mine['WebpageMenu']['id']; ?>">
					    		<div class="for-centering">
						    		<ul>
						    			<li>
						    				<div class="item home">
												<?php echo $this->Html->link(__('<span class="icon"> %s </span> <span class="link"> %s </span>', $defaultTemplate[0]['Template']['icon'], $mine['WebpageMenu']['name']), '#', array('class' => 'toggleClick toggle', 'data-target' => '#form' . $mine['WebpageMenu']['id'], 'escape' => false,  'rel' =>'tooltip', 'title' => $mine['WebpageMenu']['notes'])); ?>
												<div id="form<?php echo $mine['WebpageMenu']['id']; ?>">
													<?php echo $this->Html->link('Notes', '#', array('data-toggle' => 'modal', 'data-target' => '#menuNote'.$mine['WebpageMenu']['id'], 'class' => 'btn btn-info btn-xs btn-mini')); ?>
													<div id="menuNote<?php echo $mine['WebpageMenu']['id']; ?>" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
														<div class="modal-dialog">
															<div class="modal-content">
																<div class="modal-body">
																	<?php echo $this->Form->create('WebpageMenuItem', array('url' => array('plugin' => 'webpages', 'controller' => 'webpage_menu_items', 'action' => 'edit', $mine['WebpageMenu']['id']))); ?>
																	<?php echo $this->Form->input('WebpageMenuItem.id', array('type' => 'hidden', 'value' => $mine['WebpageMenu']['id'])); ?>
																	<?php echo $this->Form->input('Override.redirect', array('value' => '/install/client', 'type' => 'hidden')); ?>
																	<?php echo $this->Form->input('WebpageMenuItem.id', array('type' => 'hidden', 'value' => $mine['WebpageMenu']['id'])); ?>
																	<?php echo $this->Form->input('WebpageMenuItem.notes', array('type' => 'textarea', 'label' => $mine['WebpageMenu']['name'] . ' Notes', 'value' => $mine['WebpageMenu']['notes'])); ?>
																	<?php echo $this->Form->end('Save'); ?> 
																</div>
															</div>
														</div>
													</div>
													<?php //echo $this->Form->create('WebpageMenu', array('class' => 'form-inline', 'url' => array('plugin' => 'webpages', 'controller' => 'webpage_menus', 'action' => 'edit'), 'class' => 'form-inline')); ?>
													<?php //echo $this->Form->input('Override.redirect', array('value' => '/install/client', 'type' => 'hidden')); ?>
													<?php //echo $this->Form->input('WebpageMenu.id', array('type' => 'hidden', 'value' => $mine['WebpageMenu']['id'])); ?>
													<?php //echo $this->Form->input('WebpageMenu.user_role_id', array('options' => array('0' => 'fill this with user role names'), 'label' => false, 'value' => $mine['WebpageMenu']['user_role_id'], 'div' => array('class' => 'input-prepend'), 'class' => 'prependedInput span1', 'before' => '<span class="add-on">&nbsp;&nbsp;<i class="icon-user"></i>&nbsp;</i></span>')); ?>
													<?php //echo $this->Form->input('WebpageMenu.template', array('options' => array('0' => 'fill this with template names'), 'label' => false, 'div' => array('class' => 'input-prepend'), 'class' => 'prependedInput span1', 'before' => '<span class="add-on">&nbsp;&nbsp;<i class="icon-eye-open"></i>&nbsp;</span>')); ?>
													<?php //echo $this->Form->submit('Save', array('div' => false, 'class' => 'btn btn-success btn-small')); ?>
													<?php //echo $this->Form->end(); ?>
												</div>
						    				</div>
						    			
									        <?php $this->Tree->addTypeAttribute('data-identifier', $mine['WebpageMenu']['id'], null, 'previous'); ?>
											<?php $remove = Set::extract('/WebpageMenu[name=' . $mine['WebpageMenu']['name'] . ']', $mine['children']); // used in js below ?>
											<?php $mine['children'] == ZuhaSet::devalue($mine['children'], $remove, true); ?>
											<?php echo $this->Tree->generate($mine['children'], array('model' => 'WebpageMenu', 'alias' => 'item_text', 'class' => 'sortable sortableMenu', 'id' => 'menu' . $mine['WebpageMenu']['id'], 'element' => 'Webpages.menus/links/client')); ?>
						    			</li>
									</ul>
								</div>
							</div>
					    </div>						
					</div>
				</div>
			<?php endforeach; ?>
				
		<?php endforeach; ?>
		
	</div>
</div>
<?php echo $this->Html->css('/css/jquery-ui/jquery-ui-1.9.2.custom.min'); ?>
<?php // echo $this->Html->css('/webpages/menus/css/nestedSortable'); ?>
<?php echo $this->Html->script('/js/plugins/jquery.cookie.min'); ?>
<?php echo $this->Html->script('/js/jquery-ui/jquery-ui-1.9.2.custom.min'); ?>
<?php echo $this->Html->script('/webpages/menus/js/jquery.ui.nestedSortable'); ?>
<script type="text/javascript">

$(document).ready(function() {	
	// when close is clicked we don't need to show the tip anymore
	$('.hero-unit a[data-dismiss=alert]').click(function(e) {
		e.preventDefault;
		$.cookie('installTipClose', 'true', { expires: 365, path: '/' });
	});
	if ($.cookie('installTipClose') != 'true') {
		$('.install.form .hero-unit').show();
	}
	
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
	$('.toggleClick').css('cursor', 'default');
	
	$('.sortableMenu a').click(function(e) {
		e.preventDefault();
	});
	
	
	// canvas size
	$('#install').addClass($.cookie('installCanvasSize')); // keep the canvas the same size on reload
	$('a.shrink').click(function(e) {
		e.preventDefault();
		if ($($(this).attr('data-target')).hasClass('medium')) {
			$($(this).attr('data-target')).removeClass('medium').addClass('small');
			$.cookie('installCanvasSize', 'small', { expires: 365, path: '/' });
		} else {
			$($(this).attr('data-target')).addClass('medium');
			$.cookie('installCanvasSize', 'medium', { expires: 365, path: '/' });
		}
	});
	$('a.grow').click(function(e) {
		e.preventDefault();
		if ($($(this).attr('data-target')).hasClass('small')) {
			$($(this).attr('data-target')).removeClass('small').addClass('medium');
			$.cookie('installCanvasSize', 'medium', { expires: 365, path: '/' });
		} else {
			$($(this).attr('data-target')).removeClass('medium');
			$.cookie('installCanvasSize', '', { expires: 365, path: '/' });
		}
	});

	// toggle view for dragging
	$('a.reorder').click(function(e) {
		e.preventDefault();
		if ($($(this).attr('data-target')).hasClass('tree')) {
			$($(this).attr('data-target')).removeClass('tree').addClass('notree');
		} else {
			$($(this).attr('data-target')).removeClass('notree').addClass('tree');
		}
	});
	
<?php foreach ($jsMenus as $mine) : if(!empty($mine)) : ?>
	$('.tree ul#menu<?php echo $mine['WebpageMenu']['id']; ?>').nestedSortable({
		forcePlaceholderSize: true,
		listType: 'ul',
		handle: 'div.item',
		helper: 'clone',
		opacity: .6,
    	placeholder: 'placeholder',
        rootID: '<?php echo $mine['WebpageMenu']['id']; ?>',
		items: "li",
		delay: 100,
		tolerance: 'pointer',
		toleranceElement: '> div.item',
		update: function(event, ui) {
			//$('#loadingimg').show();
			var order = $('ul#menu<?php echo $mine['WebpageMenu']['id']; ?>').nestedSortable('toArray');
			$.post('/webpages/webpage_menu_items/sort.json', {order:order},	function(data){
				//$('#loadingimg').hide()
			});
		}
	});
<?php endif; endforeach; ?>
});

	// set width of the stuff inside of the canvas element
	// $('.for-centering').width('100000px');
	// var width = $('.for-centering ul:first-child').width();
	// $('.for-centering').width(width + 'px');
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