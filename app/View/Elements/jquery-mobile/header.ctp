    <div data-role="header" data-theme="c">
		<?php echo $this->Element('page_title'); ?>	
        <a href="/admin" class="floManagrLogo">flo<span class="floManagrLogoBlue">Managr</spa></a>
		<?php echo !empty($quickNavBeforeBack_callback) ? $quickNavAfterBack_callback : '' ; ?><?php echo !empty($quickNavAfterBack_callback) ? $quickNavAfterBack_callback : '<a data-rel="back" data-icon="back" data-iconpos="notext" data-direction="reverse">Back</a>' ; ?>
        <?php echo $this->Element('context_menu'); ?>
	</div>

    
<div id="pageTitleNavigation" data-rel="dialog" style="position: absolute; top: 30px; z-index: 10; width: 100%; padding: 0; margin: 0; display: none;">
	<ul data-role="listview" data-inset="true" style="margin: 0 auto; width: 95%">
    	<li data-role="list-divider">Dashboard</li>
		<li><?php echo $this->Html->link('Privileges', array('plugin' => 'privileges', 'controller' => 'sections', 'action' => 'index')); ?></li>
	    <li><?php echo $this->Html->link('<span>Theme</span>', array('plugin' => 'webpages', 'controller' => 'webpages', 'action' => 'theme'), array('escape' => false, 'title' => 'Templates, CSS, Javascript', 'id' => 'navTheme')); ?></li>
	    <li><?php echo $this->Html->link('<span>Content</span>', array('plugin' => 'webpages', 'controller' => 'webpages', 'action' => 'dashboard'), array('escape' => false, 'title' => 'Pages, Modules, Media, Categories, Tags, Enumerations', 'id' => 'navContent')); ?></li>
	    <li><?php echo $this->Html->link('<span>Contacts</span>', array('plugin' => 'contacts', 'controller' => 'contacts', 'action' => 'dashboard'), array('escape' => false, 'title' => 'Leads, Opportunities', 'id' => 'navContacts')); ?></li>
	    <li><?php echo $this->Html->link('<span>Ecommerce</span>', array('plugin' => 'catalogs', 'controller' => 'catalogs', 'action' => 'dashboard'), array('escape' => false, 'title' => 'Catalogs, Orders', 'id' => 'navProducts')); ?></li>
	    <li><?php echo $this->Html->link('<span>Billing</span>', array('plugin' => 'invoices', 'controller' => 'invoices', 'action' => 'dashboard'), array('escape' => false, 'title' => 'Estimates, Invoices', 'id' => 'navBilling')); ?></li>
	    <li><?php echo $this->Html->link('<span>Support</span>', array('plugin' => 'projects', 'controller' => 'projects', 'action' => 'dashboard'), array('escape' => false, 'title' => 'Projects, Tickets, Timesheets', 'id' => 'navSupport')); ?></li>
	    <li><?php echo $this->Html->link('<span>Users</span>', array('plugin' => 'users', 'controller' => 'users', 'action' => 'dashboard'), array('escape' => false, 'title' => 'Social, Groups, Members, Messages', 'id' => 'navUsers')); ?></li>
	</ul>
</div>

<script type="text/javascript">
	$(document).bind("pageshow", function( event, ui){
		$("#pageTitleBtn").click( function (event) {
			event.preventDefault();
			$("#pageTitleNavigation").slideToggle("slow");
		});
	});
</script>
