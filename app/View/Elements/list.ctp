<?php
# this should be at the top of every element created with format __ELEMENT_PLUGIN_ELEMENTNAME_instanceNumber.
# it allows a database driven way of configuring elements, and having multiple instances of that configuration.
if(!empty($instance) && defined('__ELEMENT_LIST_'.$instance)) {
	extract(unserialize(constant('__ELEMENT_LIST_'.$instance)));
} else if (defined('__ELEMENT_LIST')) {
	extract(unserialize(__ELEMENT_LIST));
}
# Set the defaults
$plugin = !empty($plugin) ? strtolower($plugin) : null;
$controller = !empty($controller) ? strtolower($controller) : null;
$instance = !empty($instance) ? strtolower($instance) : null;
if (!empty($displayField)) { $displayField = strtolower($displayField); } // can't have the var set at all if not already there
if (!empty($displayDescription)) { $displayDescription = strtolower($displayDescription); }

if (!empty($controller)) {
	# Get the data and put it into variables
	$results = $this->requestAction('/'.$plugin.'/'.$controller.'/itemize/'.$instance);
	extract($results['options'], EXTR_PREFIX_SAME, 'ext');
	$results = $results['results'];
	
	if (!empty($results)) { ?>
		<ul class="<?php echo $controller.'List'; ?>">
		<?php
	    foreach ($results as $result) { 
			$viewLink['plugin'] = strtolower($viewPlugin); 
			$viewLink['controller'] = $viewController; 
			$viewLink['action'] = $viewAction; 
			$viewLink[0] = $result[$model][$idField];
			$galleryKey = $result[$model][$galleryForeignKey]; ?>
		    <li>
	    	<?php echo !empty($showGallery) ? $this->Element('thumb', array('model' => $galleryModelName, 'foreignKey' => $galleryKey, 'showDefault' => 'false', 'thumbSize' => $galleryThumbSize, 'thumbLink' => $viewLink), array('plugin' => 'galleries')) : null; ?>
		        <h3><?php echo $this->Html->link($result[$model][$displayField], $viewLink); ?></h3>
		       	<?php !empty($displayDescription) ? '<p>' . $result[$model][$displayDescription] . '</p>' : null; ?>
		    </li>
			<?php } // end foreach ?>
		</ul> 
	<?php
	} // end results check 
} // end controller variable check ?>