<?php 
$title = !empty($page_title_for_layout) ? $page_title_for_layout : Inflector::humanize($this->request->params['controller']); ?> 
<h1 class="pageTitle>
	<fieldset data-role="controlgroup" data-type="horizontal">
		<select name="select-choice-month" id="select-choice-month" data-mini="true">
			<option><?php echo $title; ?></option>
		    <option><?php echo $this->Html->link('Dashboard', array('plugin' => null, 'controller' => 'admin', 'action' => 'index'), array('escape' => false, 'title' => 'Privileges, Settings, Workflows, Conditions, Custom Forms', 'id' => 'navAdmin')); ?></option>
		    <option><?php echo $this->Html->link('<span>Theme</span>', array('plugin' => 'webpages', 'controller' => 'webpages', 'action' => 'theme'), array('escape' => false, 'title' => 'Templates, CSS, Javascript', 'id' => 'navTheme')); ?></option>
		    <option><?php echo $this->Html->link('<span>Content</span>', array('plugin' => 'webpages', 'controller' => 'webpages', 'action' => 'dashboard'), array('escape' => false, 'title' => 'Pages, Modules, Media, Categories, Tags, Enumerations', 'id' => 'navContent')); ?></option>
		    <option><?php echo $this->Html->link('<span>Contacts</span>', array('plugin' => 'contacts', 'controller' => 'contacts', 'action' => 'dashboard'), array('escape' => false, 'title' => 'Leads, Opportunities', 'id' => 'navContacts')); ?></option>
		    <option><?php echo $this->Html->link('<span>Ecommerce</span>', array('plugin' => 'catalogs', 'controller' => 'catalogs', 'action' => 'dashboard'), array('escape' => false, 'title' => 'Catalogs, Orders', 'id' => 'navProducts')); ?></option>
		    <option><?php echo $this->Html->link('<span>Billing</span>', array('plugin' => 'invoices', 'controller' => 'invoices', 'action' => 'dashboard'), array('escape' => false, 'title' => 'Estimates, Invoices', 'id' => 'navBilling')); ?></option>
		    <option><?php echo $this->Html->link('<span>Support</span>', array('plugin' => 'projects', 'controller' => 'projects', 'action' => 'dashboard'), array('escape' => false, 'title' => 'Projects, Tickets, Timesheets', 'id' => 'navSupport')); ?></option>
		    <option><?php echo $this->Html->link('<span>Users</span>', array('plugin' => 'users', 'controller' => 'users', 'action' => 'dashboard'), array('escape' => false, 'title' => 'Social, Groups, Members, Messages', 'id' => 'navUsers')); ?></option>
		</select>
	</fieldset>
</h1>
 