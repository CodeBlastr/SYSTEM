	<ul id="leadList" data-mini="false" data-role="listview" data-filter="true" data-inset="true">
        <li data-role="list-divider">Leads</li>
		<?php 
        foreach ($contacts as $contact) { 
            echo __('<li data-filtertext="%s zqx%s">%s</li>', $contact['Contact']['name'], $contact['ContactType']['name'], $this->Html->link(__('%s', $contact['Contact']['name']), array('action' => 'view', $contact['Contact']['id'], array('data-transition' => 'flip')))); 
        } ?>
    </ul>


<script type="text/javascript">
	$(document).bind("pageshow", function( event, ui){
		// prefilter the first box
    	var preFilterText = "zqxLead";
    	var listId = "leadList";

    	$("#" + listId + " li").each(function(i) {
			if ($(this).attr("data-filtertext")) {
        		$(this).attr("data-filtertext").toString().indexOf( preFilterText ) === -1 ? $(this).hide() : null;
			}
    	});

    	$("#" + listId).listview('option', 'filterCallback', function (text, searchValue, item) {
        	return preFilterText && text.toString().indexOf( preFilterText ) === -1 ? true : text.toString().toLowerCase().indexOf( searchValue ) === -1;
    	});
		
		// prefilter the second box
    	var preFilterText2 = "zqxCustomer";
    	var listId2 = "customerList";

    	$("#" + listId2 + " li").each(function(i) {
			if ($(this).attr("data-filtertext")) {
        		$(this).attr("data-filtertext").toString().indexOf( preFilterText2 ) === -1 ? $(this).hide() : null;
			}
    	});

    	$("#" + listId2).listview('option', 'filterCallback', function (text2, searchValue2, item) {
        	return preFilterText2 && text2.toString().indexOf( preFilterText2 ) === -1 ? true : text2.toString().toLowerCase().indexOf( searchValue2 ) === -1;
    	});
		
	});
</script>


<?php
// set the contextual menu items
$this->set('context_menu', array('menus' => array(
	array(
		'heading' => '',
		'items' => array(
			$this->Html->link(__('Leads'), array('plugin' => 'contacts', 'controller'=> 'contacts', 'action' => 'index', 'filter' => 'type:leads'), array('data-icon' => 'grid')),
			$this->Html->link(__('Customers'), array('plugin' => 'contacts', 'controller'=> 'contacts', 'action' => 'index', 'filter' => 'type:customers'), array('data-icon' => 'grid')),
			$this->Html->link(__('Companies'), array('plugin' => 'contacts', 'controller'=> 'contacts', 'action' => 'index', 'filter' => 'type:customers'), array('data-icon' => 'grid')),
			$this->Html->link(__('People'), array('plugin' => 'contacts', 'controller'=> 'contacts', 'action' => 'index', 'filter' => 'type:customers'), array('data-icon' => 'grid')),
			),
		),
	array(
		'heading' => '',
		'items' => array(
			$this->Html->link(__('Add'), array('plugin' => 'contacts', 'controller'=> 'contacts', 'action' => 'add'), array('data-icon' => 'plus')),
			),
		),
	))); ?>