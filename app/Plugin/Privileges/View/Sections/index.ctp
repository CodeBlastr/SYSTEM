<div class="row"> 
   <?php
    //// navigation links
    echo '<div class="span3 bs-docs-sidebar"><ul class="nav nav-list bs-docs-sidenav affix">';
    foreach ($sections as $section) {
        if (!empty($section['children'][0]['children'])) {
            foreach ($section['children'] as $child) {
                echo '<li>' . $this->Html->link(__('<i class="icon-chevron-right"></i> %s', Inflector::singularize(Inflector::humanize(Inflector::underscore($child['Section']['alias'])))), '#' . Inflector::underscore($child['Section']['alias']), array('escape' => false)) . '</li>'; 
            }
        } else {
            echo '<li>' . $this->Html->link(__('<i class="icon-chevron-right"></i> %s', Inflector::humanize(Inflector::underscore($section['Section']['alias']))), '#' . Inflector::underscore($section['Section']['alias']), array('escape' => false)) . '</li>'; 
           // echo $this->Element('action-privileges-form', array('name' => $section['Section']['alias'], 'data' => $section['children'])); 
        }
    } 
    echo '</ul></div>'; ?>


    <div class="span9">
         <p>Each section listed below contains rows of <a rel="tooltip" title="Things like view, add, edit, delete.  Typically they correspond to an actual page url you can visit.">Actions</a> that a user can take with columns of what the <a rel="tooltip" title="Groups that you put users into to control their access to actions.">User Roles</a> are.  To give a User Role access to an action, simply click the check box under the role, and then the save button at the bottom of that section. By default all actions are restricted to admins, and must be purposely granted. </p>
    
    <?php
    // privileges tables (element)
    foreach ($sections as $section) {
        if (!empty($section['children'][0]['children'])) {
            foreach ($section['children'] as $child) {
                echo $this->Element('action-privileges-form', array('name' => $child['Section']['alias'], 'data' => $child['children'])); 
            }
        } else {
            echo $this->Element('action-privileges-form', array('name' => $section['Section']['alias'], 'data' => $section['children'])); 
        }
    } ?>
    </div>
</div>

<?php
// set the contextual menu items
$this->set('context_menu', array('menus' => array(
	array(
		'heading' => 'Privileges',
		'items' => array(
            $this->Html->link(__('Update Sections & Actions'), array('controller' => 'sections', 'action' => 'clear_session')),
			$this->Html->link(__('Edit User Roles'), array('plugin' => 'users', 'controller' => 'user_roles', 'action' => 'index')),
			)
		),
	)));