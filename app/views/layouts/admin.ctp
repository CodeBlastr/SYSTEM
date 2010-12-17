<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<?php echo $html->charset(); ?>
	<title>
		<?php echo $title_for_layout; __(' : Zuha Business Management'); ?>
	</title>
	<!--[if lt IE 7]><?php echo $this->Html->css('lt7'); ?><![endif]-->
	<?php
		echo $this->Html->meta('icon');		
		echo $this->Html->css('admin');		
		echo $this->Html->css('css3');		
		echo $this->Html->script('jquery-1.4.2.min');
		echo $this->Html->script('addclass');
		echo $this->Html->script('hide-text-inputs');
		echo $this->Html->script('jquery.jeditable');
		echo $this->Html->script('admin');
		echo $scripts_for_layout;  // to use this specify false for the 'in-line' argument when you put javascript into views -- that will cause your view javascript to be pushed to the <head> ie. $javascript->codeBlock($functionForExemple, array('inline'=>false));

	?>
</head>
<body class="<?php echo $this->params['controller']; ?><?php if($session->read('Auth.User')) : __(' authorized'); else : __(' restricted'); endif; ?>">
	<div class="wrapper">
		<div id="header">
			<div class="holder">
				<h1 class="logo"><a href="/admin/" id="logo"></a></h1><!-- /logo end -->
                <div id="loadingimg" style="display: none;"><?php echo $html->image('ajax-loader.gif'); ?></div>
				<ul class="nav">
					<li><a class="dashboard link" href="#"><strong><strong><strong>Dashboard</strong></strong></strong></a>
						<div class="drop">
							<div class="t"></div>
							<div class="c">
								<ul>
									<li>
										<a class="close" href="#">
											<span>Close</span>
										</a>
									</li>
									<li>
										<a href="/admin">
											<img src="/img/admin/ico11.gif" alt="#" width="60" height="68" />
											<span>Dashboard</span>
										</a>
									</li>
									<li>
										<a href="/admin/permissions/acores">
											<img src="/img/admin/ico12.gif" alt="#" width="65" height="68" />
											<span>Permissions</span>
										</a>
									</li>
									<li>
										<a href="/admin/settings">
											<img src="/img/admin/ico15.gif" alt="#" />
											<span>Settings</span>
										</a>
									</li>
								</ul>
							</div>
							<div class="b"></div>
						</div><!-- /drop end -->
                    </li>
					<li><a class="contacts link" href="#"><strong><strong><strong>Contacts</strong></strong></strong></a>
						<div class="drop">
							<div class="t"></div>
							<div class="c">
								<ul>
									<li>
										<a class="close" href="#">
											<span>Close</span>
										</a>
									</li>
									<li>
										<a href="/admin/users">
											<img src="/img/admin/ico17.gif" alt="#" />
											<span>Users</span>
										</a>
									</li>
									<li>
										<a href="/admin/contacts">
											<img src="/img/admin/ico18.gif" alt="#" />
											<span>Contact</span>
										</a>
									</li>
									<li>
										<a href="/admin/contacts/contact_people">
											<img src="/img/admin/ico18.gif" alt="#" />
											<span>People</span>
										</a>
									</li>
									<li>
										<a href="/admin/contacts/contact_companies">
											<img src="/img/admin/ico18.gif" alt="#" />
											<span>Companies</span>
										</a>
									</li>
									<li>
										<a href="/admin/contacts/contact_opportunities/my">
											<img src="/img/admin/ico09.gif" alt="#" width="58" height="68" />
											<span>Opportunities</span>
										</a>
									</li>
								</ul>
							</div>
							<div class="b"></div>
						</div><!-- /drop end -->
                    </li>
					<li><a class="projects link" href="#"><strong><strong><strong>Projects</strong></strong></strong></a>
						<div class="drop">
							<div class="t"></div>
							<div class="c">
								<ul>
									<li>
										<a class="close" href="#">
											<span>Close</span>
										</a>
									</li>
									<li>
										<a href="/admin/projects">
											<img src="/img/admin/ico13.gif" alt="#" width="66" height="68" />
											<span>Projects</span>
										</a>
									</li>
									<li>
										<a href="/admin/timesheets">
											<img src="/img/admin/ico08.gif" alt="#" width="64" height="68" />
											<span>Timesheets</span>
										</a>
									</li>
									<li>
										<a href="/admin/tickets">
											<img src="/img/admin/ico09.gif" alt="#" width="58" height="68" />
											<span>Tickets</span>
										</a>
									</li>
									<li>
										<a href="http://razorit.localhost/admin/priorities/priorities/my">
											<img src="/img/admin/ico10.gif" alt="#" width="63" height="68" />
											<span>Priorities</span>
										</a>
									</li>
								</ul>
							</div>
							<div class="b"></div>
						</div><!-- /drop end -->
					</li>
					<li><a class="e-commerce link" href="#"><strong><strong><strong>e-Commerce</strong></strong></strong></a>
						<div class="drop">
							<div class="t"></div>
							<div class="c">
								<ul>
									<li>
										<a class="close" href="#">
											<span>Close</span>
										</a>
									</li>
									<li>
										<a href="/admin/catalogs">
											<img src="/img/admin/ico08.gif" alt="#" width="64" height="68" />
											<span>Catalogs</span>
										</a>
									</li>
									<li>
										<a href="/admin/categories">
											<img src="/img/admin/ico08.gif" alt="#" width="64" height="68" />
											<span>Categories</span>
										</a>
									</li>
									<li>
										<a href="/admin/catalogs/catalog_items">
											<img src="/img/admin/ico08.gif" alt="#" width="64" height="68" />
											<span>Products</span>
										</a>
									</li>
									<li>
										<a href="/admin/orders">
											<img src="/img/admin/ico08.gif" alt="#" width="64" height="68" />
											<span>Orders</span>
										</a>
									</li>
									<li>
										<a href="/admin/invoices">
											<img src="/img/admin/ico08.gif" alt="#" width="64" height="68" />
											<span>Invoices</span>
										</a>
									</li>
								</ul>
							</div>
							<div class="b"></div>
						</div><!-- /drop end -->
                    </li>
					<li><a class="content link" href="#"><strong><strong><strong>Content</strong></strong></strong></a>
						<div class="drop">
							<div class="t"></div>
							<div class="c">
								<ul>
									<li>
										<a class="close" href="#">
											<span>Close</span>
										</a>
									</li>
									<li>
										<a href="/admin/webpages">
											<img src="/img/admin/ico16.gif" alt="#" />
											<span>Pages</span>
										</a>
									</li>
									<li>
										<a href="/admin/forms">
											<img src="/img/admin/ico15.gif" alt="#" />
											<span>Forms</span>
										</a>
									</li>
									<li>
										<a href="/admin/blogs">
											<img src="/img/admin/ico10.gif" alt="#" />
											<span>Blogs</span>
										</a>
									</li>
									<li>
										<a href="/admin/wikis">
											<img src="/img/admin/ico10.gif" alt="#" />
											<span>Wikis</span>
										</a>
									</li>
									<li>
										<a href="/ckfinder/ckfinder.html">
											<img src="/img/admin/ico14.gif" alt="#" />
											<span>File Manager</span>
										</a>
									</li>
									<li>
										<a href="/admin/tags">
											<img src="/img/admin/ico11.gif" alt="#" />
											<span>Tags</span>
										</a>
									</li>
								</ul>
							</div>
							<div class="b"></div>
						</div><!-- /drop end -->
                    </li>
					<li><a class="marketing link" href="#"><strong><strong><strong>Marketing</strong></strong></strong></a>
						<div class="drop">
							<div class="t"></div>
							<div class="c">
								<ul>
									<li>
										<a class="close" href="#">
											<span>Close</span>
										</a>
									</li>
									<li>
										<a href="/admin/notifications/notification_templates">
											<img src="/img/admin/ico10.gif" alt="#" width="63" height="68" />
											<span>Marketing</span>
										</a>
									</li>
								</ul>
							</div>
							<div class="b"></div>
						</div><!-- /drop end -->                                    
                    </li>
				</ul><!-- /nav end -->
				<div class="info">
			<?php 
			if($session->read('Auth.User')) { 
			?>
					<div class="img">
						<?php echo $this->element('snpsht', array('plugin' => 'profiles', 'useGallery' => true, 'userId' => $session->read('Auth.User.id'), 'thumbAlt' => $session->read('Auth.User.username'), 'thumbTitle' => $session->read('Auth.User.username')));  ?>
					</div>
					<div class="text">
						<p><strong>Welcome, <?php echo $session->read('Auth.User.username'); ?></strong></p>
						<ul>
							<li><strong><a href="#">setting</a></strong></li>
							<li><strong><a href="#">help</a></strong></li>
							<li><strong><?php __($html->link(__($html->tag('span', 'log out'), true), array('plugin' => null, 'controller' => 'users', 'action' => 'logout'), array('escape' => false, 'class' => 'button'))); ?></strong></li>
                            <li><strong><a href="/admin/settings"><?php echo __SYS_ZUHA_DB_VERSION; ?></a></strong></li>
						</ul>
            <?php
			} else { 
			?>
						<p><strong>Welcome</strong></p>
						<ul>
							<li><strong><?php __($html->link(__($html->tag('span', 'sign-up', array('class' => 'button')), true), array('plugin' => null, 'controller' => 'users', 'action' => 'add'), array('escape' => false, 'class' => 'button'))); ?></strong></li>
							<li><strong><?php __($html->link(__($html->tag('span', 'sign-in', array('class' => 'button')), true), array('plugin' => null, 'controller' => 'users', 'action' => 'login'), array('escape' => false, 'class' => 'button'))); ?></strong></li>
						</ul>
            <?php
			};
			?>
					</div>
				</div>
			</div>
		</div><!-- /header end -->
		<div id="main">
			<div class="heading">
				<h2><?php echo $title_for_layout; ?> <!--span>for <em>Water Heater Experts</em></span--></h2>
				<!--div class="search-form">
					<form action="#">
						<fieldset>
							<div class="row">
								<div class="txt-holder">
									<input class="txt" type="text" value="search" />
								</div>
								<input class="btn" type="image" src="/img/admin/btn-search.gif" alt="search" value="search" />
							</div>
						</fieldset>
					</form>
				</div--><!-- /search-form end -->
			</div>


				<div id="content">
					<?php echo $session->flash(); ?>
   					<?php echo $session->flash('auth'); ?>
					<?php echo $content_for_layout; ?>
                    <?php /*
					<div class="info-block">
						<div class="title">
							<strong class="status">Status: <span>Active</span></strong>
							<strong>Total Hours: <span>10.00</span></strong>
							<div class="drop-holder">
								<strong>Sort by:  <a href="#">Priority</a></strong>
								<ul class="drop">
									<li><a href="#">Created Date</a></li>
									<li><a href="#">Modified Date</a></li>
									<li><a href="#">Complete Percent</a></li>
									<li><a href="#">Estimated Hours</a></li>
								</ul>
							</div>
						</div><!-- /title end -->
						<div class="post">
							<div class="image">
								<img src="/img/admin/img01.jpg" alt="image description" width="76" height="78" />
								<div class="drop-holder">
									<a href="#" class="btn">jbyrnes</a>
									<ul class="drop">
										<li><a href="#">View Profile</a></li>
										<li><a href="#">Private Message</a></li>
										<li><a href="#">User Group</a></li>
									</ul>
								</div>
							</div><!-- /image end -->
							<div class="text">
  							<div class="links">
  							  <a href="" class="top-button"><img src="/img/admin/ico22.gif" /></a>
  							  <a href="" class="botton-button"><img src="/img/admin/ico21.gif" /></a>
  							</div>
								<ul>
									<li>Start: <span>2010-05-19</span></li>
									<li>Due: <span>2010-05-20</span></li>
									<li>Estimated Hrs: <span>8.00</span></li>
									<li>Spent Hrs: <strong>14.42</strong></li>
									<li>% Complete: <span>99</span></li>
									<li>Modifiedt:  <span>2010-05-19</span></li>
									<li> Contact: <span>Water Heater Experts</span></li>
								</ul>
								<p>You've received source layered source files in a different email. Client would like you to install CMS Made </p>
								<div class="row">
									<a href="#" class="add-note">ADD NOTE</a>
									<em>note added on 19 May at 5:30pm</em>
									<a href="#" class="expand">Expand</a>
								</div>
							</div>
						</div><!-- /post end -->
						<div class="post post-reply">
							<a href="#" class="close">Close</a>
							<div class="image">
								<img src="/img/admin/img02.jpg" alt="image description" width="76" height="77" />
								<div class="drop-holder">
									<a href="#" class="btn">todd</a>
									<ul class="drop">
										<li><a href="#">View Profile</a></li>
										<li><a href="#">Private Message</a></li>
										<li><a href="#">User Group</a></li>
									</ul>
								</div>
							</div><!-- /image end -->
							<div class="text">
								<p>You've received source layered source files in a different email. Client would like you to install CMS Made Simple and put this template over it. We had mentioned that you would have this by 4:00 pm tomorrow. </p>
								<div class="row">
									<a href="#" class="add-note">ADD NOTE</a>
									<em>note added on 19 May at 6:30pm</em>
								</div>
							</div>
						</div><!-- /post post-reply end -->
						<div class="post">
							<div class="image">
								<img src="/img/admin/img01.jpg" alt="image description" width="76" height="78" />
								<div class="drop-holder">
									<a href="#" class="btn">jbyrnes</a>
									<ul class="drop">
										<li><a href="#">View Profile</a></li>
										<li><a href="#">Private Message</a></li>
										<li><a href="#">User Group</a></li>
									</ul>
								</div>
							</div><!-- /image end -->
							<div class="text">
							  <div class="links">
							    <a href="" class="top-button"><img src="/img/admin/ico22.gif" /></a>
							    <a href="" class="botton-button"><img src="/img/admin/ico21.gif" /></a>
							  </div>
								<ul>
									<li>Start: <span>2010-05-19</span></li>
									<li>Due: <span>2010-05-20</span></li>
									<li>Estimated Hrs: <span>8.00</span></li>
									<li>Spent Hrs: <strong>14.42</strong></li>
									<li>% Complete: <span>99</span></li>
								</ul>
								<p>You've received source layered source files in a different email. Client would like you to install CMS Made Simple and put this template over it. We had mentioned that you would have this by 4:00 pm tomorrow. </p>
								<div class="row">
									<a href="#" class="add-note">ADD NOTE</a>
									<em>note added on 19 May at 5:30pm</em>
								</div>
							</div>
						</div><!-- /post end -->
						<div class="post">
							<div class="image">
								<img src="/img/admin/img01.jpg" alt="image description" width="76" height="78" />
								<div class="drop-holder">
									<a href="#" class="btn">jbyrnes</a>
									<ul class="drop">
										<li><a href="#">View Profile</a></li>
										<li><a href="#">Private Message</a></li>
										<li><a href="#">User Group</a></li>
									</ul>
								</div>
							</div><!-- /image end -->
							<div class="text">
							  <div class="links">
							    <a href="" class="top-button"><img src="/img/admin/ico22.gif" /></a>
							    <a href="" class="botton-button"><img src="/img/admin/ico21.gif" /></a>
							  </div>
								<ul>
									<li>Start: <span>2010-05-19</span></li>
									<li>Due: <span>2010-05-20</span></li>
									<li>Estimated Hrs: <span>8.00</span></li>
									<li>Spent Hrs: <strong>14.42</strong></li>
									<li>% Complete: <span>99</span></li>
								</ul>
								<p>You've received source layered source files in a different email. Client would like you to install CMS Made Simple and put this template over it. We had mentioned that you would have this by 4:00 pm tomorrow. </p>
								<div class="row">
									<a href="#" class="add-note">ADD NOTE</a>
									<em>note added on 19 May at 5:30pm</em>
								</div>
							</div>
						</div><!-- /post end -->
					</div><!-- /info-block end --> */ ?>
				</div><!-- /content end -->
			<div class="main-holder">
				<div id="sidebar">
					<?php echo (!empty($menu_for_layout) ? $menu_for_layout : ''); ?>
				</div><!-- /sidebar end -->
			</div>
		</div><!-- /main end -->
	</div>
	<div id="footer">
		<p>All rights reserved &copy; 2010 zuha.com</p>
		<ul>
			<li><a href="http://zuha.org/">About</a></li>
			<li><a href="http://zuha.org/">Download</a></li>
			<li><a href="http://zuha.org/">Privacy Policy</a></li>
			<li><a href="http://zuha.org/">Terms of Service</a></li>
			<li><a href="http://zuha.org/">Blog </a></li>
			<li><a href="http://zuha.org/">Contact Us</a></li>
		</ul>
		<strong class="logo"><a href="http://zuha.org/" title="Business Management App">zuha</a></strong><!-- /logo end -->
	</div><!-- /footer end -->

<?php echo $this->element('sql_dump'); ?>  
</body>
</html>